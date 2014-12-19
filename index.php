<?php include_once('header.php'); ?>

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
                <div class="col s12">
                    <input id="volume" type="range" min="80" max="100" step="0.1" value="<?=getVolume()?>" class="form-control">
                    <label for="volume">Volume</label>
                </div>
            </div>
        </div>
    </div>
    <div class="temperature">
        <?php list($temperature,$humidity,$time) = $db->getTemperature();?>
        <div class="row">
            <span>
                <?=$temperature?> <i class="mdi-image-wb-sunny"></i>
            </span>
            <span>
                <?=$humidity?>% <i class="mdi-action-invert-colors"></i>
            </span>
            <span>
                <?=date('H:i:s',$time)?> <i class="mdi-device-access-time"></i>
            </span>
        </div>
    </div>
    <div class="pir">
        <?php $time_action = $db->getPir();?>
        <div class="row">
        <span class="pirContent">
            <?=date('H:i:s',$time_action)?> <i class="mdi-action-accessibility"></i>
        </span>
        </div>
    </div>
    <div class="row" style="margin-top: 40px;">
        <button class="waves-effect waves-light btn commandStart" data-id="1"><i class="mdi-av-repeat"></i>Restart airplay</button>
    </div>
</div>

<?php
include_once('footer.php');

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