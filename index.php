<?php

use Dotenv\Dotenv;

require_once 'vendor/autoload.php';

/**
 * @require libraries
 * dunst
 * dunstify
 */


//$urls = [
//    ['https://www.youtube.com/watch?v=znZiSZHcQaU', '1. Female Nightcore Mix 2022', DEFAULT_ICON],
//    ['https://www.youtube.com/watch?v=CmycNy581Oc', '2. Nightcore top 20 music', DEFAULT_ICON],
//    ['https://www.youtube.com/watch?v=5Ux-2RSNX-8', '3. Horror. Nightcore', DEFAULT_ICON],
//    ['https://www.youtube.com/watch?v=IEQDvaXBxp8', '4. Horror. Nightcore pt 3', DEFAULT_ICON],
//    ['https://www.youtube.com/watch?v=5qap5aO4i9A', '5. Lo-Fi radio', DEFAULT_ICON],
//    ['https://www.youtube.com/watch?v=kgx4WGK0oNU', '6. jazz/lofi hip hop radio', DEFAULT_ICON],
//];

$dotenv = Dotenv::createMutable('./');
$envs = $dotenv->load();

$pidFile = file_exists($envs['PID_PATH']) ? file_get_contents($envs['PID_PATH']) : null;

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
    print_n('Help будешь просить у своего отца');
}

function play($pid)
{
    global $urls;

    if ($pid) {
        exec('pkill -TERM -P ' . $pid);
    }

}

