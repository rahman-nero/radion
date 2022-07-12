<?php

declare(strict_types=1);

namespace Radion;

use Radion\Contracts\RadioInterface;
use Radion\Implements\{DirectoryRadio, MPVRadio};

abstract class RadioFactory
{
    public static function make(RadioEnum $type, array $envs, array $list): RadioInterface
    {
        return match ($type) {
            RadioEnum::MPV => new MPVRadio($list, $envs),
            RadioEnum::DIRECTORY => new DirectoryRadio($list, $envs)
        };
    }

}