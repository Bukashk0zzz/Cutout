<?php

$db = new SQLite3("temperature.db");
if (!$db) exit("Can not create database.");

$query_table = $db->exec("CREATE TABLE temperature
                              (id INTEGER PRIMARY KEY,
                               temperature REAL,
                               temperature_o REAL,
                               humidity REAL,
                               humidity_o REAL,
                               time INTEGER);
                              ");
if (!$query_table) exit("Can not create table.");
