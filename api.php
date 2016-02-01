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
                            <?php list($temperature, $humidity, $time, $temperature_o, $humidity_o) = $db->getTemperature(); ?>
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
                                    <span>
                                        <?= $temperature_o ?> <i class="mdi-image-wb-sunny"></i>
                                    </span>
                                    <span>
                                        <?= $humidity_o ?>% <i class="mdi-action-invert-colors"></i>
                                    </span>
                                    <span >
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
                            <div class="col s7">
                                <a class="modal-trigger waves-effect waves-light btn blue" href="#play"><i class="large mdi-av-play-arrow left"></i> Play</a>
                            </div>
                            <div class="col s4">
                                <button class="waves-effect waves-red btn commandStart red darken-4" data-id="3">Stop</button>
                            </div>
                        </div>


                        <div class="row">
                            <div class="col s12">
                                <button class="waves-effect waves-light btn commandStart blue-grey darken-4" data-id="1"><i class="large mdi-av-repeat left"></i>Restart airplay</button>
                            </div>
                        </div>




                        <!-- Modal Structure -->
                        <div id="play" class="modal bottom-sheet">
                            <div class="modal-content">
                                <div style="width: 80%; margin: 0 auto 0 auto;">
                                    <div class="row">
                                        <div class="col s12">
                                            <button class="waves-effect waves-green btn commandStart blue width100" data-id="4">
                                                <i class="large mdi-av-play-arrow left"></i> Aristocrats
                                            </button>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col s12">
                                            <button class="waves-effect waves-green btn commandStart blue width100" data-id="5">
                                                <i class="large mdi-av-play-arrow left"></i> Music (A)
                                            </button>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col s12">
                                            <button class="waves-effect waves-green btn commandStart blue width100" data-id="8">
                                                <i class="large mdi-av-play-arrow left"></i> Jazz (A)
                                            </button>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col s12">
                                            <button class="waves-effect waves-green btn commandStart blue width100" data-id="7">
                                                <i class="large mdi-av-play-arrow left"></i> Lounge FM
                                            </button>
                                        </div>
                                    </div>
                                    <div class="row" style="margin-bottom: 0;">
                                        <div class="col s12">
                                            <button class="waves-effect waves-green btn commandStart blue width100" data-id="6">
                                                <i class="large mdi-av-play-arrow left"></i> Prostoradio
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="landscape">
                    <div class="row temperatureGraph" style="text-align: center;">
                        <script>
                            <?php list($labels,$data,$dataH,$data_o,$dataH_o) = $db->getTemperatureTodayData()?>
                            temperatureTodayData = {
                                labels: [<?=$labels?>],
                                datasets: [
                                    {
                                        label: "Humidity",
                                        fillColor: "rgba(151,187,205,0.2)",
                                        strokeColor: "rgba(151,187,205,1)",
                                        pointColor: "rgba(151,187,205,1)",
                                        pointStrokeColor: "#fff",
                                        pointHighlightFill: "#fff",
                                        pointHighlightStroke: "rgba(151,187,205,0.8)",
                                        data: [<?=$dataH?>]
                                    },
                                    {
                                        label: "Temperature",
                                        fillColor: "rgba(247,70,74,0.2)",
                                        strokeColor: "rgba(247,70,74,1)",
                                        pointColor: "rgba(247,70,74,1)",
                                        pointStrokeColor: "#fff",
                                        pointHighlightFill: "#fff",
                                        pointHighlightStroke: "rgba(247,70,74,0.8)",
                                        data: [<?=$data?>]
                                    }
                                ]
                            };
                        </script>
                        <canvas id="temperatureToday" height="175"></canvas>
                    </div>
                    <div class="row temperatureGraph" style="text-align: center;">
                        <script>
                            temperatureTodayOutdoorData = {
                                labels: [<?=$labels?>],
                                datasets: [
                                    {
                                        label: "Humidity outdoor",
                                        fillColor: "rgba(253,180,92,0.2)",
                                        strokeColor: "rgba(253,180,92,1)",
                                        pointColor: "rgba(253,180,92,1)",
                                        pointStrokeColor: "#fff",
                                        pointHighlightFill: "#fff",
                                        pointHighlightStroke: "rgba(253,180,92,0.8)",
                                        data: [<?=$dataH_o?>]
                                    },
                                    {
                                        label: "Temperature outdoor",
                                        fillColor: "rgba(70,191,189,0.2)",
                                        strokeColor: "rgba(70,191,189,1)",
                                        pointColor: "rgba(70,191,189,1)",
                                        pointStrokeColor: "#fff",
                                        pointHighlightFill: "#fff",
                                        pointHighlightStroke: "rgba(70,191,189,0.8)",
                                        data: [<?=$data_o?>]
                                    }
                                ]
                            };
                        </script>
                        <canvas id="temperatureTodayOutdoor" height="175"></canvas>
                    </div>
                    <div class="row temperatureGraph" style="text-align: center;">
                        <script>
                            temperatureTodayAllData = {
                                labels: [<?=$labels?>],
                                datasets: [
                                    {
                                        label: "Humidity",
                                        fillColor: "rgba(151,187,205,0.2)",
                                        strokeColor: "rgba(151,187,205,1)",
                                        pointColor: "rgba(151,187,205,1)",
                                        pointStrokeColor: "#fff",
                                        pointHighlightFill: "#fff",
                                        pointHighlightStroke: "rgba(151,187,205,0.8)",
                                        data: [<?=$dataH?>]
                                    },
                                    {
                                        label: "Temperature",
                                        fillColor: "rgba(247,70,74,0.2)",
                                        strokeColor: "rgba(247,70,74,1)",
                                        pointColor: "rgba(247,70,74,1)",
                                        pointStrokeColor: "#fff",
                                        pointHighlightFill: "#fff",
                                        pointHighlightStroke: "rgba(247,70,74,0.8)",
                                        data: [<?=$data?>]
                                    },
                                    {
                                        label: "Humidity outdoor",
                                        fillColor: "rgba(253,180,92,0.2)",
                                        strokeColor: "rgba(253,180,92,1)",
                                        pointColor: "rgba(253,180,92,1)",
                                        pointStrokeColor: "#fff",
                                        pointHighlightFill: "#fff",
                                        pointHighlightStroke: "rgba(253,180,92,0.8)",
                                        data: [<?=$dataH_o?>]
                                    },
                                    {
                                        label: "Temperature outdoor",
                                        fillColor: "rgba(70,191,189,0.2)",
                                        strokeColor: "rgba(70,191,189,1)",
                                        pointColor: "rgba(70,191,189,1)",
                                        pointStrokeColor: "#fff",
                                        pointHighlightFill: "#fff",
                                        pointHighlightStroke: "rgba(70,191,189,0.8)",
                                        data: [<?=$data_o?>]
                                    }
                                ]
                            };
                        </script>
                        <canvas id="temperatureTodayAll" height="175"></canvas>
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

define('APPLICATION_ENV', (getenv('APPLICATION_ENV') ? getenv('APPLICATION_ENV') : 'production'));
include_once('data.class.php');
$db = new dbData();

if (isset($_GET['id']) && $id = $_GET['id']) {
    if ($id == 3) stopRadio();
    elseif ($id == 2) playRadio();
    elseif ($id == 4) playRadio(4);
    elseif ($id == 5) playRadio(5);
    elseif ($id == 6) playRadio(6);
    elseif ($id == 7) playRadio(7);
    elseif ($id == 1) restartAirPlay();
}

if (isset($_GET['volume']) && $volume = $_GET['volume']) {
    setVolume($volume);
}

if (isset($_GET['data']) && $_GET['data'] == 'main') {
    header('Content-Type: application/json');

    list($temperature, $humidity, $time, $temperature_o, $humidity_o) = $db->getTemperature();
    $time_action = $db->getPir();

    echo json_encode([
        'temperature' => $temperature,
        'humidity' => $humidity,
        'time' => $time,
        'temperature_o' => $temperature_o,
        'humidity_o' => $humidity_o,
        'time_action' => $time_action,
        'volume' => getVolume(),
    ]);
}

if (isset($_GET['data']) && $_GET['data'] == 'statistic') {
    header('Content-Type: application/json');

    list($labels,$data,$dataH,$data_o,$dataH_o) = $db->getTemperatureTodayData();
    list($labels,$data) = $db->getPirTodayData();

    echo json_encode([
        'pir' => [
            'labels' => $labels,
            'data' => $data,
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
    exec("/usr/sbin/service shairport restart");
}

function playRadio($id = 0) {
    stopRadio();
    if ($id == 6) {
        exec("/usr/bin/screen /usr/bin/mplayer http://62.80.190.246:8000/PRK128 &"); //Prosto
    } elseif ($id == 5) {
        exec("/usr/bin/screen /usr/bin/mplayer http://144.76.79.38:8000/amusic-128 &"); //Aristocrats music
    } elseif ($id == 7) {
        exec("/usr/bin/screen /usr/bin/mplayer http://cast.loungefm.com.ua/loungefm &"); //Lounge fm
    } elseif($id == 4) {
        exec("/usr/bin/screen /usr/bin/mplayer http://144.76.79.38:8000/live2 &"); //Aristocrats
    } elseif($id == 8) {
        exec("/usr/bin/screen /usr/bin/mplayer http://144.76.79.38:8000/ajazz &"); //Aristocrats jazz
    }
}

function stopRadio() {
    exec("/usr/bin/killall -9 mplayer");
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