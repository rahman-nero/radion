<?php

require_once 'functions.php';

/**
 * @require libraries
 * dunst
 * dunstify
 */

const DEFAULT_ICON = '~/.config/dunst/icons/radio.png';
const PATH_TO_PID = './pid';

$urls = [
    ['https://www.youtube.com/watch?v=znZiSZHcQaU', '1. Female Nightcore Mix 2022', DEFAULT_ICON],
    ['https://www.youtube.com/watch?v=CmycNy581Oc', '2. Nightcore top 20 music', DEFAULT_ICON],
    ['https://www.youtube.com/watch?v=5Ux-2RSNX-8', '3. Horror. Nightcore', DEFAULT_ICON],
    ['https://www.youtube.com/watch?v=IEQDvaXBxp8', '4. Horror. Nightcore pt 3', DEFAULT_ICON],
    ['https://www.youtube.com/watch?v=5qap5aO4i9A', '5. Lo-Fi radio', DEFAULT_ICON],
    ['https://www.youtube.com/watch?v=kgx4WGK0oNU', '6. jazz/lofi hip hop radio', DEFAULT_ICON],
];

$pidFile = file_exists(PATH_TO_PID) ? file_get_contents(PATH_TO_PID) : null;

$action = $argv[1];

switch ($action) {
    case 'play':
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
    }

    exec('pkill -TERM -P' . $pid);
//    posix_kill($pid, SIG_ERR);

    unlink(PATH_TO_PID);
}

function help()
{
    print_n('Help будешь просить у своего отца');
}



// Код родительского процесса
if ($pid) {
    pcntl_wait($status);
    exit();
}

function play($pid)
{
    $pid = pcntl_fork();

    if ($pid == -1) {
        die('Не удалось породить дочерний процесс');
    }

    if ($pid) {
        exec('kill ' . $pid);
    }

    file_put_contents('pid', getmypid());

// Код дочернего процесса
    exec('mpv --start=03:10 --no-video ' . $urls[0][0] . ' 2>&1', $output);
}

    pcntl_exec('./bash.sh', ['--start=03:10', '--no-video', $urls[0][0]]);
}

