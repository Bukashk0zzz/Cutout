<?php
// Создадим новую базу данных
$db = sqlite_open("temperature.db");
if (!$db) exit("Невозможно создать базу данных!");

$data = exec("./readDHT");
$data = explode(';',$data);
$t = trim($data[0]);
$h = trim($data[1]);
$time = time();
sqlite_query($db, "INSERT INTO temperature(temperature, humidity, time) VALUES ($t, $h, $time);");