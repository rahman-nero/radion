<?php

declare(strict_types=1);

namespace Radion\Implements;

use Radion\Contracts\RadioInterface;
use RuntimeException;

final class MPVRadio implements RadioInterface
{
    private array $envs;
    private array $list;

    public function __construct(array $list, array $envs)
    {
        $this->list = $list;
        $this->envs = $envs;
    }

    public function play(): void
    {
        file_put_contents($this->envs['PID_PATH'], getmypid());
        system("mpv --no-video {$this->list[0][0]}");
    }

    public function stop(): void
    {
        $sessionPid = file_exists($this->envs['PID_PATH'])
            ? file_get_contents($this->envs['PID_PATH'])
            : null;

        if ($sessionPid) {
            exec("pkill -TERM -P {$sessionPid}");
        }
    }

    public function next(): void
    {
    }

    public function prev(): void
    {
    }

    public function getList(): array
    {
        return $this->list;
    }
}