<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Cutout</title>
    <meta name="viewport" content="initial-scale=1, maximum-scale=1">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-status-bar-style" content="black">
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
</div>

</body>
</html>

<?php

if (isset($_GET['id']) && $id = $_GET['id']) {
    if ($id == 3) stopRadio();
    elseif ($id == 2) playRadio();
    elseif ($id == 1) restartAirPlay();
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
