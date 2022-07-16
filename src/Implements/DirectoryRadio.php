<?php

declare(strict_types=1);

namespace Radion\Implements;

use Radion\Contracts\RadioInterface;

final class DirectoryRadio extends BaseRadio implements RadioInterface
{
    private array $musicList = [];

    public function play(): void
    {
        dump(__METHOD__ . '- Вызвали локальную песню');

        $this->setPID(getmypid());
        $this->parseDirectoryList();

        $songPath = $this->musicList[0];

        if ($lastIndex = $this->db->get('lastIndex')) {
            $songPath = $this->musicList[$lastIndex];
        }

        system("mpg123 {$songPath}");
    }

    public function stop(): void
    {
        dump(__METHOD__ . '- Завершили локальную песню');
        $sessionPid = file_exists($this->envs['PID_PATH'])
            ? file_get_contents($this->envs['PID_PATH'])
            : null;

        if ($sessionPid) {
            exec("pkill -TERM -P {$sessionPid}");
            $this->deletePIDFile();
        }
    }

    public function next(): void
    {
    }

    public function prev(): void
    {
    }

    private function parseDirectoryList(): void
    {
        $lists = $this->list;
        $files = [];

        foreach ($lists as $directory) {
            $directory = rtrim($directory, '/');
            $parsedFiles = glob($directory . '/*.mp3');

            count($parsedFiles) > 0
                ? $files = [...$files, ...$parsedFiles]
                : null;
        }

        $this->musicList = $files;
    }
}