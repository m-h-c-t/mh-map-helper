<?php

require_once "config.php";

$db = new PDO('mysql:host=' . $config['dbwhost'] . ';dbname=' . $config['dbwname'] . ';charset=utf8', $config['dbwuser'], $config['dbwpassword']);
