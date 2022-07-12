<?php

declare(strict_types=1);

namespace Radion\Implements;

use Radion\Contracts\RadioInterface;
use Radion\Db;

final class DirectoryRadio implements RadioInterface
{
    private array $envs;
    private array $list;

    public function __construct(Db $db, array $list, array $envs)
    {
        $this->list = $list;
        $this->envs = $envs;
    }

    public function play(): void
    {

    }

    public function stop(): void
    {
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