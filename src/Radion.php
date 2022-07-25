<?php

declare(strict_types=1);

namespace Radion;

use RuntimeException;

final class Radion
{
    /**
     * @var array
     */
    const REQUIRE_ENVS = ['LISTS_PATH', 'PID_PATH', 'DB_PATH'];

    /**
     * @var Db
     */
    private Db $db;

    /**
     * @var array
     */
    private readonly array $lists;

    /**
     * @var array
     */
    private readonly array $envs;

    /**
     * @param array $envs
     */
    public function __construct(array $envs)
    {
        $this->initEnvs($envs);
        $this->boot();
    }

    /**
     * @return void
     */
    private function boot(): void
    {
        $this->db = new Db($this->envs['DB_PATH']);
        $this->parseListFile();
    }

    /**
     * @param array $envs
     */
    private function initEnvs(array $envs): void
    {
        // Check for exists required parameters
        foreach (self::REQUIRE_ENVS as $env) {
            if (!array_key_exists($env, $envs)) {

                throw new RuntimeException(<<<TEXT
                    Please fill in the .env file with the required parameters:
                    LISTS_PATH
                    PID_PATH
                    DB_PATH
                TEXT);

            }
        }

        $this->envs = $envs;
    }

    /**
     * Start song
     *
     * @return void
     */
    public function play(): void
    {
        // Index last played song
        $current = $this->db->get('index') ?: 0;

        // If last index is not exists in lists, then index default 0
        if (!array_key_exists($current, $this->lists)) {
            $current = 0;
        }

        // "https://youtube......" or "/home/user/Music/file.mp3"
        $selected = $this->lists[$current][0];

        // Detect type resource
        $typeRadio = $this->parseResource($selected);

        // Stop old song session
        $this->stopBeforePlay();

        // Get concrete implements of player
        $object = RadioFactory::make($typeRadio, $this->envs, $this->lists);

        $this->db->write(['index' => $current]);

        $object->play($current);
        // code is not working, process is busy
    }

    /**
     * Stop song
     *
     * @param RadioEnum|null $type
     * @return void
     */
    public function stop(): void
    {
        if (($current = $this->db->get('index')) === false) {
            $this->fallbackStop();
            return;
        }

        // If last index is not exists in lists, then index default 0
        if (!array_key_exists($current, $this->lists)) {
            throw new RuntimeException('Невозможно остановить не существующую песню');
        }

        // "https://youtube......" or "/home/user/Music/file.mp3"
        $selected = $this->lists[$current][0];

        // Detect type resource
        $typeRadio = $this->parseResource($selected);

        // Get concrete implements of player
        $object = RadioFactory::make($typeRadio, $this->envs, $this->lists);

        // Stopping song
        $object->stop();
    }

    /**
     * @return void
     */
    public function stopBeforePlay()
    {
        if (!file_exists($this->envs['PID_PATH'])) {
            return;
        }

        $this->stop();
    }

    /**
     * @return void
     * @throws \JsonException
     */
    public function next(): void
    {
        // Index last played song
        if (($current = $this->db->get('index')) !== false) {
            $next = $current + 1;
        } else {
            $next = 0;
        }

        // If there is no other song after this song, then just start from the beginning
        if (!array_key_exists($next, $this->lists)) {
            $next = 0;
        }

        // "https://youtube......" or "/home/user/Music/file.mp3"
        $selected = $this->lists[$next][0];

        // Detect type resource
        $typeRadio = $this->parseResource($selected);

        // Stop old song session
        $this->stopBeforePlay();

        // Get concrete implements of player
        $object = RadioFactory::make($typeRadio, $this->envs, $this->lists);

        // Overwriting index
        $this->db->write(['index' => $next]);

        $object->play($next);
        // code is not working, process is busy
    }

    /**
     * @return void
     * @throws \JsonException
     */
    public function prev(): void
    {
        // Index last played song
        if (($current = $this->db->get('index')) !== false) {
            $next = $current - 1;
        } else {
            $next = 0;
        }

        // If there is no other song after this song, then just start from the beginning
        if (!array_key_exists($next, $this->lists)) {
            $next = 0;
        }

        // "https://youtube......" or "/home/user/Music/file.mp3"
        $selected = $this->lists[$next][0];

        // Detect type resource
        $typeRadio = $this->parseResource($selected);

        // Stop old song session
        $this->stopBeforePlay();

        // Get concrete implements of player
        $object = RadioFactory::make($typeRadio, $this->envs, $this->lists);

        // Overwriting index
        $this->db->write(['index' => $next]);

        $object->play($next);
        // code is not working, process is busy
    }

    /**
     * @param string $resource
     * @return RadioEnum
     */
    protected function parseResource(string $resource): RadioEnum
    {
        if (filter_var($resource, \FILTER_VALIDATE_DOMAIN)) {
            return RadioEnum::YOUTUBE_SONG;
        }

        if (is_file($resource)) {
            return RadioEnum::LOCAL_SONG;
        }

        throw new RuntimeException(<<<TEXT
            Не удалось расшифровать как нужно воспроизводить песню, пожалуйста проверьте правильность этой строки: {$resource}
        TEXT);
    }

    /**
     * @return array
     */
    public function getAllLists(): array
    {
        return $this->lists;
    }

    /**
     * Parse the file containing the lists
    */
    private function parseListFile(): void
    {
        if (!file_exists($this->envs['LISTS_PATH'])) {
            throw new RuntimeException('File lists.json is not exists');
        }

        $parsedLists = json_decode(file_get_contents($this->envs['LISTS_PATH']));

        $this->lists = (array)$parsedLists;
    }

    /**
     * If the specific type of player to be terminated is not specified, then simply terminate by killing the process
     *
     * @return void
     */
    private function fallbackStop(): void
    {
        $sessionPid = file_exists($this->envs['PID_PATH'])
            ? file_get_contents($this->envs['PID_PATH'])
            : null;

        if (!$sessionPid) {
            throw new RuntimeException('Нет воспроизводящей песни чтобы остановить');
        }

        exec("pkill -TERM -P {$sessionPid}");
    }
}