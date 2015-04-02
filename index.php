<?php
    define('APPLICATION_ENV', (getenv('APPLICATION_ENV') ? getenv('APPLICATION_ENV') : 'production'));
    include_once('data.class.php');
    $db = new dbData();
?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <title>Cutout</title>
        <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
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
        <header class="portrait">
            <nav id="mainMenu">
                <div class="container">
                    <div class="nav-wrapper"><a href="#" class="brand-logo">Cutout</a>
                </div>
            </nav>
        </header>
        <main>
            <div class="container">
                <div class="portrait radioWrap">
                    <div class="radio">
                        <div class="row">
                            <i class="mdi-av-radio" style="font-size: 120px; text-shadow: 0 12px 15px rgba(0,0,0,.24),0 17px 50px rgba(0,0,0,.19);"></i>
                        </div>

                        <div class="temperature row">
                            <?php list($temperature, $humidity, $time) = $db->getTemperature(); ?>
                            <div class="row">
                                <span>
                                    <?= $temperature ?> <i class="mdi-image-wb-sunny"></i>
                                </span>
                                <span>
                                    <?= $humidity ?>% <i class="mdi-action-invert-colors"></i>
                                </span>
                                <span>
                                    <?= date('H:i:s', $time) ?> <i class="mdi-device-access-time"></i>
                                </span>
                            </div>
                            <div class="pir">
                                <?php $time_action = $db->getPir(); ?>
                                <div class="row">
                                <span class="pirContent">
                                    <?= date('H:i:s', $time_action) ?> <i class="mdi-action-accessibility"></i>
                                </span>
                                </div>
                            </div>
                        </div>


                        <div class="row volumeWrapper">
                            <div class="col s12">
                                <input id="volume" type="range" min="80" max="100" step="0.1"
                                       value="<?= getVolume() ?>" class="form-control">
                                <label for="volume">Volume</label>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col s4">
                                <button class="waves-effect waves-green btn commandStart" data-id="4">
                                    A
                                </button>
                            </div>
                            <div class="col s4">
                                <button class="waves-effect waves-green btn commandStart" data-id="5">
                                    M
                                </button>
                            </div>
                            <div class="col s4">
                                <button class="waves-effect waves-green btn commandStart" data-id="6">
                                    P
                                </button>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col s12">
                                <button class="waves-effect waves-red btn commandStart red darken-4" data-id="3"><i class="large mdi-av-stop left"></i>Stop radio</button>
                            </div>

                            <div class="col s12">
                                <button class="waves-effect waves-light btn commandStart blue-grey darken-4" data-id="1"><i class="large mdi-av-repeat left"></i>Restart airplay</button>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="landscape">
                    <div class="row temperatureGraph" style="text-align: center;">
                        <script>
                            <?php list($labels,$data,$dataH) = $db->getTemperatureTodayData()?>
                            temperatureTodayData = {
                                labels: [<?=$labels?>],
                                datasets: [
                                    {
                                        label: "Humidity",
                                        fillColor: "rgba(220,220,220,0.2)",
                                        strokeColor: "rgba(220,220,220,1)",
                                        pointColor: "rgba(220,220,220,1)",
                                        pointStrokeColor: "#fff",
                                        pointHighlightFill: "#fff",
                                        pointHighlightStroke: "rgba(220,220,220,1)",
                                        data: [<?=$dataH?>]
                                    },
                                    {
                                        label: "Temperature",
                                        fillColor: "rgba(151,187,205,0.2)",
                                        strokeColor: "rgba(151,187,205,1)",
                                        pointColor: "rgba(151,187,205,1)",
                                        pointStrokeColor: "#fff",
                                        pointHighlightFill: "#fff",
                                        pointHighlightStroke: "rgba(151,187,205,1)",
                                        data: [<?=$data?>]
                                    }
                                ]
                            };
                        </script>
                        <canvas id="temperatureToday" height="175"></canvas>
                    </div>
                    <div class="row pirGraph" style="text-align: center;">
                        <script>
                            <?php list($labels,$data) = $db->getPirTodayData()?>
                            pirTodayData = {
                                labels: [<?=$labels?>],
                                datasets: [
                                    {
                                        label: "PIR",
                                        fillColor: "rgba(151,187,205,0.2)",
                                        strokeColor: "rgba(151,187,205,1)",
                                        pointColor: "rgba(151,187,205,1)",
                                        pointStrokeColor: "#fff",
                                        pointHighlightFill: "#fff",
                                        pointHighlightStroke: "rgba(151,187,205,1)",
                                        data: [<?=$data?>]
                                    }
                                ]
                            };
                        </script>
                        <canvas id="pirToday" height="175"></canvas>
                    </div>
                </div>
            </div>
        </main>
        <script src="/js/main.min.js"></script>
    </body>
</html>

<?php

if (isset($_GET['id']) && $id = $_GET['id']) {
    if ($id == 3) stopRadio();
    elseif ($id == 2) playRadio();
    elseif ($id == 4) playRadio(4);
    elseif ($id == 5) playRadio(5);
    elseif ($id == 6) playRadio(6);
    elseif ($id == 1) restartAirPlay();
}

if (isset($_GET['volume']) && $volume = $_GET['volume']) {
    setVolume($volume);
}

function restartAirPlay() {
    exec("service shairport restart");
}

function playRadio($id = 0) {
    if ($id == 6) {
        exec("screen /usr/bin/mplayer http://62.80.190.246:8000/PRK128 &"); //Prosto
    } elseif ($id == 5) {
        exec("screen /usr/bin/mplayer http://144.76.79.38:8000/amusic-128 &"); //Aristocrats music
    } else {
        exec("screen /usr/bin/mplayer http://144.76.79.38:8000/live2 &"); //Aristocrats
    }
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