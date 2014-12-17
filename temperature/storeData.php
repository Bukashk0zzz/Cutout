<?php

$db = new SQLite3("temperature.db");
if (!$db) exit("Can not create database.");

$status = false;
$data = exec("./readDHT");

while (!$status) {
    if ($data) {
        $data = explode(';',$data);
        $t = trim($data[0]);
        $h = trim($data[1]);
        $time = time();
        $db->exec("INSERT INTO temperature(temperature, humidity, time) VALUES ($t, $h, $time);");
        $status = true;
    }
}

