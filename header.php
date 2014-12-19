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
<header>
    <nav >
        <div class="container">
            <div class="nav-wrapper"><a href="/" class="brand-logo">Cutout</a>
                <ul id="nav-mobile" class="right side-nav">
                    <li id="l_dashboard"><a href="/">Dashboard</a></li>
                    <li id="l_temperature"><a href="/temperature.php">Temperature</a></li>
                    <li id="l_move"><a href="/move.php">Move</a></li>
                </ul><a href="#" data-activates="nav-mobile" class="button-collapse"><i class="mdi-navigation-menu"></i></a>
            </div>
        </div>
    </nav>
</header>
<main>
    <div class="container">