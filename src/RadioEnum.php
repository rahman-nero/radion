<?php

namespace Radion;

enum RadioEnum: string
{
    case MPV = 'mpv';
    case DIRECTORY = 'directory';

    public function getName(): string
    {
        return $this->name;
    }
}