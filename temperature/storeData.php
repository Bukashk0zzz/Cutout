<?php

$db = new SQLite3("temperature.db");
if (!$db) exit("Can not create database.");
$data = exec("./readDHT");

if ($data) {
    $BASE_URL = "http://query.yahooapis.com/v1/public/yql";

    $yql_query = 'select atmosphere,item from weather.forecast where woeid in (select woeid from geo.places(1) where text="Kiev, Ukraine") and u="c"';
    $yql_query_url = $BASE_URL . "?q=" . urlencode($yql_query) . "&format=json";

    $session = curl_init($yql_query_url);
    curl_setopt($session, CURLOPT_RETURNTRANSFER,true);
    $json = curl_exec($session);
    $weather =  json_decode($json,true);
    if (isset($weather['query']['results']['channel']['atmosphere']['humidity']) && isset($weather['query']['results']['channel']['item']['condition']['temp'])) {
        $h_o = $weather['query']['results']['channel']['atmosphere']['humidity'];
        $t_o = $weather['query']['results']['channel']['item']['condition']['temp'];
    } else {
        $h_o = null;
        $t_o = null;
    }
    $data = explode(';',$data);
    $t = trim($data[0]);
    $h = trim($data[1]);
    $time = time();
    $db->exec("INSERT INTO temperature(temperature_o, humidity_o, temperature, humidity, time) VALUES ($t_o,$h_o,$t, $h, $time);");
}