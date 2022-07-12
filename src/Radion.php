<?php

namespace Radion;


final class Radion
{
    protected array $lists;
    protected array $envs;

    public function __construct(array $envs)
    {
        $this->envs = $envs;
        $this->parseListFile();
    }

    public function play()
    {

        if ($this->)

    }

    public function stop() {

    }

    public function next() {

    }

    public function prev() {

    }

    protected function parseListFile(): void
    {
        if (!array_key_exists('LISTS_PATH', $this->envs)) {
            throw new \RuntimeException('Env "LISTS_PATH" not defined');
        }

        if (!file_exists($this->envs['LISTS_PATH'])) {
            throw new \RuntimeException('File lists.json is not exists');
        }

        $parsedLists = json_decode(file_get_contents($this->envs['LISTS_PATH']));

        $this->lists = (array) $parsedLists;
    }

    public function getAllLists()
    {

    }

}