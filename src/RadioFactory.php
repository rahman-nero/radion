<?php

namespace Radion;

use Radion\Contracts\RadioInterface;

abstract class RadioFactory
{
    public static function make(RadioEnum $type, array $envs, array $list): RadioInterface
    {
        switch ($type) {
            case RadioEnum::MPV:
                return new MPVRadio($list, $envs);
            case RadioEnum::DIRECTORY:
                return new DirectoryRadio($list, $envs);
        }
    }

}