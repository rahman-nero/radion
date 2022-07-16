<?php

declare(strict_types=1);

namespace Radion;

use Radion\Contracts\RadioInterface;
use Radion\Implements\{LocalSong, YoutubeRadio};

abstract class RadioFactory
{
    public static function make(RadioEnum $type, array $envs, array $list): RadioInterface
    {
        // TODO: Отрефакторить, можно сделать Singletone
        $db = new Db($envs['DB_PATH']);

        return match ($type) {
            RadioEnum::YOUTUBE_SONG => new YoutubeRadio($db, $list, $envs),
            RadioEnum::LOCAL_SONG => new LocalSong($db, $list, $envs)
        };
    }

}