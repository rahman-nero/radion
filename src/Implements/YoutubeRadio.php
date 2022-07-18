<?php

declare(strict_types=1);

namespace Radion\Implements;

use Radion\Contracts\RadioInterface;

final class YoutubeRadio extends BaseRadio implements RadioInterface
{
    public function play(): void
    {
        dump(__METHOD__ . '- Поиск ютубную песню');

        $index = $this->db->get('index') ?? 0; // Индекс песни которую нужно запустить
        $current = $this->list[$index]; // Песню которую запускаем

        $resource = $current[0];
//        $title = $current[1];
//        $icon = $current[2];

        $this->updateIndex($index);

        system("mpv --no-video {$resource}");
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
    protected function updateIndex(int $index)
    {
        $this->db->write(['index' => $index]);
    }
}