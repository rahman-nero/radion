<?php

declare(strict_types=1);

namespace Radion\Implements;

use Radion\Contracts\RadioInterface;

final class MPVRadio extends BaseRadio implements RadioInterface
{
    public function play(): void
    {
        $this->setPID(getmypid());
        system("mpv --no-video {$this->list[0][0]}");
    }

    public function stop(): void
    {
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

}