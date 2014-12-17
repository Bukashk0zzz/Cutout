<?php

$db = new SQLite3("temperature.db");
if (!$db) exit("Can not create database.");

$query_table = $db->exec("CREATE TABLE temperature
                              (id INTEGER PRIMARY KEY,
                               temperature REAL,
                               humidity REAL,
                               time INTEGER);
                              ");
if (!$query_table) exit("Can not create table.");
