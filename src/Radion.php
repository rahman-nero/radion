<?php

namespace Radion;


use RuntimeException;

final class Radion
{
    /**
     * @var array
     */
    const REQUIRE_ENVS = ['LISTS_PATH', 'PID_PATH'];

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
        $this->parseListFile();
    }

    /**
     * @param array $envs
     */
    private function initEnvs(array $envs): void
    {
        // Проверка на существование нужных переменных окружения
        foreach (self::REQUIRE_ENVS as $env) {
            if (!array_key_exists($env, $envs)) {

                throw new RuntimeException(<<<TEXT
                    Пожалуйста, заполните .env файл необходимыми параметрами:
                    LISTS_PATH
                    PID_PATH 
                TEXT);

            }
        }

        $this->envs = $envs;
    }

    /**
     * 1. Остановить прошлый сеанс если запущен
     */
    public function play(): void
    {
        // Получение тип который будет воспроизводиться
        $type = array_key_first($this->lists);
        $currentList = $this->lists[$type];

        // Остановить прошлый сеанс если запущен
        $this->stop(RadioEnum::from($type));

        // Получаем объект реализаций для конкретного типа плеера
        $object = RadioFactory::make(RadioEnum::from($type), $this->envs, $currentList);

        $object->play();
    }

    public function stop(RadioEnum $type = null): void
    {
        // Если не указан конкретный тип плеера который нужно завершить
        if (!$type) {
            $this->fallbackStop();
            return;
        }

        $currentList = $this->lists[$type->value];

        // Получаем объект реализаций для конкретного типа плеера
        $object = RadioFactory::make($type, $this->envs, $currentList);

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

    }

    private function parseListFile(): void
    {
        if (!array_key_exists('LISTS_PATH', $this->envs)) {
            throw new RuntimeException('Env "LISTS_PATH" not defined');
        }

        if (!file_exists($this->envs['LISTS_PATH'])) {
            throw new RuntimeException('File lists.json is not exists');
        }

        $parsedLists = json_decode(file_get_contents($this->envs['LISTS_PATH']));

        $this->lists = (array)$parsedLists;
    }


    /**
     * Если не указан конкретный тип плеера который нужно завершить, то просто завершаем убивая процесс
     *
     * @return void
     */
    protected function fallbackStop(): void
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