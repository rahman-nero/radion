<?php

namespace Radion\Contracts;

interface RadioInterface
{
    public function play(): void;
    public function stop(): void;
    public function next(): void;
    public function prev(): void;
    public function getList(): array;
}