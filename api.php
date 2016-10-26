<?php

define('APPLICATION_ENV', (getenv('APPLICATION_ENV') ?: 'production'));
include_once __DIR__.'/data.class.php';
$db = new dbData();

if (array_key_exists('id', $_GET) && $id = $_GET['id']) {
    if ($id === 3) {
        stopRadio();
    } elseif ($id === 2) {
        playRadio();
    } elseif ($id === 4) {
        playRadio(4);
    } elseif ($id === 5) {
        playRadio(5);
    } elseif ($id === 6) {
        playRadio(6);
    } elseif ($id === 7) {
        playRadio(7);
    } elseif ($id === 1) {
        restartAirPlay();
    }
}

if (array_key_exists('volume', $_GET) && $volume = $_GET['volume']) {
    setVolume($volume);
}

if (array_key_exists('data', $_GET) && $_GET['data'] === 'main') {
    list($temperature, $humidity, $time, $temperature_o, $humidity_o) = $db->getTemperature();

    response([
        'temperature' => $temperature,
        'humidity' => $humidity,
        'time' => $time,
        'temperature_o' => $temperature_o,
        'humidity_o' => $humidity_o,
        'time_action' => $db->getPir(),
        'volume' => getVolume(),
    ]);
}

if (array_key_exists('data', $_GET) && $_GET['data'] === 'volume') {
    response([
        'volume' => getVolume(),
    ]);
}

if (array_key_exists('data', $_GET) && $_GET['data'] === 'radio') {
    response([
        'radio' => getRadioStatus(),
    ]);
}

if (array_key_exists('data', $_GET) && $_GET['data'] === 'temperature') {
    list($temperature, $humidity, $time, $temperature_o, $humidity_o) = $db->getTemperature();

    response([
        'temperature' => $temperature,
        'humidity' => $humidity,
        'time' => $time,
        'temperature_o' => $temperature_o,
        'humidity_o' => $humidity_o,
    ]);
}

if (array_key_exists('data', $_GET) && $_GET['data'] === 'statistic') {
    list($labels,$data,$dataH,$data_o,$dataH_o) = $db->getTemperatureTodayData();
    list($labelsPir,$dataPir) = $db->getPirTodayData();

    response([
        'pir' => [
            'labels' => $labelsPir,
            'data' => $dataPir,
        ],
        'temperature' => [
            'labels' => $labels,
            'data' => $data,
            'dataH' => $dataH,
            'data_o' => $data_o,
            'dataH_o' => $dataH_o,
        ],
    ]);
}

function restartAirPlay() {
    exec('/usr/sbin/service shairport restart');
}

function playRadio($id = 0) {
    stopRadio();
    if ($id === 6) {
        exec('/usr/bin/screen /usr/bin/mplayer http://62.80.190.246:8000/PRK128 &'); //Prosto
    } elseif ($id === 5) {
        exec('/usr/bin/screen /usr/bin/mplayer http://144.76.79.38:8000/amusic-128 &'); //Aristocrats music
    } elseif ($id === 7) {
        exec('/usr/bin/screen /usr/bin/mplayer http://cast.loungefm.com.ua/loungefm &'); //Lounge fm
    } elseif($id === 4) {
        exec('/usr/bin/screen /usr/bin/mplayer http://144.76.79.38:8000/live2 &'); //Aristocrats
    } elseif($id === 8) {
        exec('/usr/bin/screen /usr/bin/mplayer http://144.76.79.38:8000/ajazz &'); //Aristocrats jazz
    }
}

function stopRadio() {
    exec('/usr/bin/killall -9 mplayer');
}

function getVolume() {
    $volume = (APPLICATION_ENV === 'development') ?'Mono: Playback -3854 [95%] [-38.54dB] [on]':exec("amixer | grep 'Mono: Playback'");
    $volume = explode('[',$volume)[1];
    $volume = explode('%]',$volume)[0];
    return (int)$volume;
}

function getRadioStatus() {
    $status = (APPLICATION_ENV === 'development') ?'1':exec('ps -ef |grep mplayer |wc -l');
    return ((int)$status > 1);
}

function setVolume($volume) {
    exec("amixer set PCM $volume%");
}

function response(array $data) {
    header('Content-Type: application/json');
    echo json_encode($data);
}
