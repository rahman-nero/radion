<?php

namespace Tests;

use PHPUnit\Framework\TestCase;
use Radion\Radion;
use RuntimeException;

final class RadionTest extends TestCase
{
    // Если нет env переменных должна быть ошибка
    public function testEnvError()
    {
        $this->expectException(RuntimeException::class);

        $envs = [];
        new Radion($envs);
    }

}