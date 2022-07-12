<?php

namespace Radion;

use Radion\Contracts\RadioInterface;

final class DirectoryRadio implements RadioInterface
{
    private array $envs;
    private array $list;

    public function __construct(array $list, array $envs)
    {
        $this->list = $list;
        $this->envs = $envs;
    }

    public function play()
    {

    }

    public function stop()
    {
    }

    public function next()
    {
    }

    public function prev()
    {
    }

    public function getList(): array
    {
        return $this->list;
    }
}