<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Cutout</title>
    <meta name="viewport" content="initial-scale=1, maximum-scale=1">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-status-bar-style" content="black">


    <link href="apple-touch-icon-precomposed.png"
          sizes="152x152"
          rel="apple-touch-icon">

    <link href="apple-touch-icon-precomposed-120x120.png"
          sizes="120x120"
          rel="apple-touch-icon">

    <link href="apple-touch-startup-image-640x1096.png"
          media="(device-width: 320px) and (device-height: 568px)
                 and (-webkit-device-pixel-ratio: 2)"
          rel="apple-touch-startup-image">

    <link href="apple-touch-startup-image-640x920.png"
          media="(device-width: 320px) and (device-height: 480px)
                 and (-webkit-device-pixel-ratio: 2)"
          rel="apple-touch-startup-image">

    <link href="/css/styles.min.css" rel="stylesheet">
    <script src="/js/main.min.js"></script>
</head>
<body>
<header class="bar bar-nav">
    <h1 class="title">Cutout</h1>
</header>

<div class="content">
    <br>
    <button class="btn btn-primary btn-block btn-outlined commandStart" data-id="1">Restart airplay</button>
    <button class="btn btn-positive btn-block btn-outlined commandStart" data-id="2">Play radio</button>
    <button class="btn btn-negative btn-block btn-outlined commandStart" data-id="3">Stop radio</button>
    <h3 style="text-align: center;">Volume</h3>
    <input id="volume" type="range" min="0" max="100" step="1" value="<?=getVolume()?>" class="form-control">
</div>

</body>
</html>

<?php

if (isset($_GET['id']) && $id = $_GET['id']) {
    if ($id == 3) stopRadio();
    elseif ($id == 2) playRadio();
    elseif ($id == 1) restartAirPlay();
}

if (isset($_GET['volume']) && $volume = $_GET['volume']) {
    setVolume($volume);
}

function restartAirPlay() {
    exec("service shairport restart");
}

function playRadio() {
    exec("screen mplayer http://62.80.190.246:8000/PRK128 &");
}

function stopRadio() {
    exec("killall -9 mplayer");
}

function getVolume() {
//    $volume = 'Mono: Playback -3854 [60%] [-38.54dB] [on]';
    $volume = exec("amixer | grep 'Mono: Playback'");
    $volume = explode('[',$volume)[1];
    $volume = explode('%]',$volume)[0];
    return (int)$volume;
}

function setVolume($volume) {
    exec("amixer set PCM $volume%");
}
