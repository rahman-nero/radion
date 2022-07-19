<?php

declare(strict_types=1);

namespace Radion\Implements;

use Radion\Contracts\RadioInterface;

final class LocalSong extends BaseRadio implements RadioInterface
{
    public function play(int $index): void
    {
        dump(__METHOD__ . '- Запуск локальной песни');
        $this->updatePID(getmypid());

        $current = $this->list[$index]; // Песню которую запускаем

        $resource = $current[0];
//        $title = $current[1];
//        $icon = $current[2];

        system("mpv --no-video {$resource}");
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

}