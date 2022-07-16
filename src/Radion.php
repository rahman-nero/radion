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
        // Getting play's "type"
        if (!$type = $this->db->get('type')) {
            $type = array_key_first($this->lists);
        }

        $currentList = $this->lists[$type];

        // Stop old song session
        $this->stop();

        // Get concrete implements of player
        $object = RadioFactory::make(RadioEnum::from($type), $this->envs, $currentList);

        // Write the type of playing song in db.json
        $this->db->append(['type' => $type]);

        $object->play();

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
        // Getting play's "type"
        if (!$type = $this->db->get('type')) {
            $this->fallbackStop();
            return;
        }

        $currentList = $this->lists[$type];

        // Get concrete implements of player
        $object = RadioFactory::make(RadioEnum::from($type), $this->envs, $currentList);

        // Stopping song
        $object->stop();
    }

    public function next(): void
    {

    }

    public function prev(): void
    {
    }

    public function getAllLists()
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