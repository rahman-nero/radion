<?php

function print_n($mixed)
{
    echo $mixed . PHP_EOL;
}


function printLists(array $lists)
{
    print_n("ID   Название                          Путь");
    print_n("--------------------------------------------------------------------------");

    for ($i = 0; $i < count($lists); $i++) {
        $id = $i + 1;
        $song = $lists[$i];

        $resource = $song[0];

        $title = $song[1] ?? "Без названия";

        if (mb_strlen($title) > 30) {
            $title = mb_strcut($title, 0, 27) . '...';
        } else {
            $countSpace = 30 - mb_strlen($title);

            for ($j = 1; $j <= $countSpace; $j++) {
                $title .= ' ';
            }
        }

        print_n("{$id} |  {$title} |  {$resource}");
    }

    print_n("--------------------------------------------------------------------------");
}
