<?php

declare(strict_types=1);

namespace Radion\Implements;

use Radion\Contracts\RadioInterface;
use Radion\Db;
use RuntimeException;

abstract class BaseRadio
{
    protected Db $db;
    protected array $envs;
    protected array $list;

    public function __construct(Db $db, array $list, array $envs)
    {
        $this->list = $list;
        $this->envs = $envs;
        $this->db = $db;
    }

    /**
     * @param string|int $pid
     * @return bool
     */
    public function setPID(string|int $pid): bool
    {
        return file_put_contents($this->envs['PID_PATH'], $pid) !== false;
    }

    /**
     * @return bool
    */
    public function deletePIDFile(): bool
    {
       return unlink($this->envs['PID_PATH']);
    }

    /**
     * @return array
     */
    public function getList(): array
    {
        return $this->list;
    }
}