<?php

declare(strict_types=1);

namespace Radion\Implements;

use Radion\Contracts\RadioInterface;

final class LocalSong extends BaseRadio implements RadioInterface
{
    public function play(): void
    {
        dump(__METHOD__ . '- Поиск локальную песню');

        $index = $this->db->get('index') ?? 0;
        $current = $this->list[$index];

        $resource = $current[0];
//        $title = $current[1];
//        $icon = $current[2];

        $this->db->write(['index' => $index]);

        system("mpv --no-video {$resource}");
    }

    public function stop(): void
    {
        dump(__METHOD__ . '- Завершили локальную песню');

        $sessionPid = file_exists($this->envs['PID_PATH'])
                    ? file_get_contents($this->envs['PID_PATH'])
                    : null;

        if ($sessionPid) {
            system("pkill -TERM -P" . $sessionPid);
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