<?php

namespace Tests;

use PHPUnit\Framework\TestCase;
use Radion\Radion;

final class RadionTest extends TestCase
{
    /**
     * Воспроизведение песни
    */
    public function testPlaySongSuccess()
    {
        $radion = new Radion();

        $radion->play();

        $this->assertFileExists('db.json');
    }


    /**
     * Остановка песни
     */
    public function testStopSongSuccess()
    {

    }

    /**
     * Перелистывание песни на следующую
    */
    public function testNextSongSuccess()
    {

    }

    /**
     * Перелистывание песни на предыдущую
     */
    public function testPrevSongSuccess()
    {

    }

    /**
     * Проверка возможности переключения с одного плейлиста на другой
     *
     * Если допустим
    */
    public function testCheckoutSongFromPlaylistToOther()
    {

    }

    /**
     * Если воспроизвелся последний плейлист, то начать с начала, перейти на первый плейлист
    */
    public function testCircleIfEndSongs()
    {

    }

}