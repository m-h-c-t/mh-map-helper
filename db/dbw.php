<?php

require_once "__FILE__/../config.php";

$db = new PDO('mysql:host=' . $config['dbwhost'] . ';dbname=' . $config['dbwname'] . ';charset=utf8', $config['dbwuser'], $config['dbwpassword']);
