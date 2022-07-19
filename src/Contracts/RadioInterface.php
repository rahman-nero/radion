<?php

namespace Radion\Contracts;

interface RadioInterface
{
    public function play(int $index): void;
    public function stop(): void;
    public function getList(): array;
}