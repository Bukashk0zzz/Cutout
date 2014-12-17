<?php

$db = new SQLite3("pir.db");
if (!$db) exit("Can not create database.");

$query_table = $db->exec("CREATE TABLE pir
                          (id INTEGER PRIMARY KEY,
                           time INTEGER);
                          ");
if (!$query_table) exit("Can not create table.");
