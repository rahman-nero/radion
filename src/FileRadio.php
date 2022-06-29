<?php

namespace Nero;

use Nero\Contracts\RadioInterface;

final class FileRadio implements RadioInterface
{
    public function __construct()
    {

    }

    public function play()
    {
        file_put_contents('pid', getmypid());

        // Код дочернего процесса
        system("mpv --start=00:10  --no-video {$urls[0][0]}");


        // TODO: Implement play() method.
    }

    public function stop()
    {
        // TODO: Implement stop() method.
    }

    public function next()
    {
        // TODO: Implement next() method.
    }

    public function prev()
    {
        // TODO: Implement prev() method.
    }

    public function getList()
    {
        // TODO: Implement getList() method.
    }
}