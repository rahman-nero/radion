<?php

namespace Radion;

use Radion\Contracts\RadioInterface;

final class FileRadio implements RadioInterface
{
    private array $list;

    public function __construct(array $list)
    {
        $this->list = $list;
    }

    public function play()
    {
        $pidFile = file_exists($envs['PID_PATH']) ? file_get_contents($envs['PID_PATH']) : null;


        file_put_contents('pid', getmypid());

        // Код дочернего процесса
        system("mpv --start=00:10  --no-video {$urls[0][0]}");


        // TODO: Implement play() method.
    }

    public function stop()
    {
    }

    public function next()
    {
    }

    public function prev()
    {
    }

    public function getList(): array
    {
        return $this->list;
    }
}