<?php

use Dotenv\Dotenv;

require_once 'vendor/autoload.php';

/**
 * @require libraries
 * dunst
 * dunstify
 */

$dotenv = Dotenv::createMutable('./');
$envs = $dotenv->load();

$m = $argv[1];
$action = $argv[1];

switch ($action) {
    case 'play':
    case 'start':
        play($pidFile);
        break;

    case 'stop':
        stop($pidFile);
        break;

    default:
        help();
        break;
}


function stop($pid)
{
    if (!$pid) {
        print_n('Вы ничего не запустили, чтобы завершать');
        exit();
    }

    exec('pkill -TERM -P ' . $pid);
    unlink(PATH_TO_PID);
}

function help()
{
    print_n(<<<HELP
    radion - 




    HELP);
}

function play($pid)
{
    global $urls;

    if ($pid) {
        exec('pkill -TERM -P ' . $pid);
    }

}

