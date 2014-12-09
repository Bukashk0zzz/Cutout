<?php define('APPLICATION_ENV', (getenv('APPLICATION_ENV') ? getenv('APPLICATION_ENV') : 'production'));?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Cutout</title>
    <meta name="viewport" content="initial-scale=1, maximum-scale=1">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-status-bar-style" content="black-translucent">


    <link href="apple-touch-icon-precomposed.png"
          sizes="152x152"
          rel="apple-touch-icon">

    <link href="apple-touch-icon-precomposed-120x120.png"
          sizes="120x120"
          rel="apple-touch-icon">

    <link href="apple-touch-startup-image-640x1096.jpg"
          media="(device-width: 320px) and (device-height: 568px)
                 and (-webkit-device-pixel-ratio: 2)"
          rel="apple-touch-startup-image">

    <link href="apple-touch-startup-image-640x920.jpg"
          media="(device-width: 320px) and (device-height: 480px)
                 and (-webkit-device-pixel-ratio: 2)"
          rel="apple-touch-startup-image">

    <link href="/css/styles.min.css" rel="stylesheet">
</head>
<body>
<nav style="padding-top: 10px;">
    <div class="container">
        <div class="nav-wrapper">
            <a href="#" class="brand-logo">Cutout</a>
        </div>
    </div>
</nav>
<div class="container">
    <div class="container" style="text-align: center;">
        <div class="radio">
            <div class="row">
                <i class="mdi-av-radio" style="font-size: 120px; text-shadow: 0 12px 15px rgba(0,0,0,.24),0 17px 50px rgba(0,0,0,.19);"></i>
            </div>
            <div class="row">
                <div class="col s6">
                    <button class="waves-effect waves-green btn commandStart" data-id="2">Play radio<i class="mdi-av-play-arrow"></i></button>
                </div>
                <div class="col s6">
                    <button class="waves-effect waves-red btn commandStart" data-id="3">Stop radio<i class="mdi-av-pause"></i></button>
                </div>
            </div>
            <div>
                <div class="row">
                    <div class="col s12 range-field">
                        <input id="volume" type="range" min="80" max="100" step="0.1" value="<?=getVolume()?>" class="form-control">
                        <label for="volume">Volume</label>
                    </div>
                </div>
            </div>
        </div>
        <div class="row" style="margin-top: 40px;">
            <button class="waves-effect waves-light btn commandStart" data-id="1"><i class="mdi-av-repeat"></i>Restart airplay</button>
        </div>
    </div>
</div>

<script src="/js/main.min.js"></script>
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
    $volume = (APPLICATION_ENV == 'development') ?'Mono: Playback -3854 [95%] [-38.54dB] [on]':exec("amixer | grep 'Mono: Playback'");
    $volume = explode('[',$volume)[1];
    $volume = explode('%]',$volume)[0];
    return (int)$volume;
}

function setVolume($volume) {
    exec("amixer set PCM $volume%");
}
