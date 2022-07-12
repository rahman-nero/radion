<?php

declare(strict_types=1);

namespace Radion\Implements;

use Radion\Contracts\RadioInterface;
use Radion\Db;

final class DirectoryRadio implements RadioInterface
{
    private array $envs;
    private array $list;

    public function __construct(array $list, array $envs)
    {
        $this->list = $list;
        $this->envs = $envs;
    }

    public function play(): void
    {
        dump(__METHOD__, 'Вызвали локальную песню');
    }

    public function stop(): void
    {
        dump(__METHOD__, 'Завершили локальную песню');
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