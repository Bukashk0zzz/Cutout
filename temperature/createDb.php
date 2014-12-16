<?php
// Создадим новую базу данных
$db = sqlite_open("temperature.db");
if (!$db) exit("Невозможно создать базу данных!");

$query_table = sqlite_query($db, "CREATE TABLE temperature
                              (id INTEGER PRIMARY KEY,
                               temperature REAL,
                               humidity REAL,
                               time INTEGER);
                              ");
if (!$query_table) exit("Невозможно создать таблицу в базе данных!");
