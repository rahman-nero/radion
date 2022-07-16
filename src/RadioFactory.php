<?php

declare(strict_types=1);

namespace Radion;

use Radion\Contracts\RadioInterface;
use Radion\Implements\{DirectoryRadio, MPVRadio};

abstract class RadioFactory
{
    public static function make(RadioEnum $type, array $envs, array $list): RadioInterface
    {
        // TODO: Отрефакторить, можно сделать Singletone
        $db = new Db($envs['DB_PATH']);

        return match ($type) {
            RadioEnum::MPV => new MPVRadio($db, $list, $envs),
            RadioEnum::DIRECTORY => new DirectoryRadio($db, $list, $envs)
        };
    }

}