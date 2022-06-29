<?php

namespace Nero\Contracts;

interface RadioInterface
{
    public function play();
    public function stop();
    public function next();
    public function prev();
    public function getList();
}