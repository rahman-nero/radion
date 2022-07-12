<?php

namespace Radion;

use Radion\Contracts\RadioInterface;

final class MPVRadio implements RadioInterface
{
    private array $envs;
    private array $list;

    public function __construct(array $list, array $envs)
    {
        $this->list = $list;
        $this->envs = $envs;
    }

    public function play()
    {
        file_put_contents($this->envs['PID_PATH'], getmypid());

        system("mpv --start=00:10  --no-video {$this->list[0][0]}");
    }

    public function stop()
    {
        $sessionPid = file_exists($this->envs['PID_PATH'])
            ? file_get_contents($this->envs['PID_PATH'])
            : null;

        if (!$sessionPid) {
            throw new \RuntimeException('Нет воспроизводящей песни чтобы остановить');
        }

        exec("pkill -TERM -P {$sessionPid}");
    }

    public function next()
    {
    }

    public function prev()
    {
    }

    public function getList()
    {
    }
}