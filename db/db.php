<?php

require_once "__FILE__/../config.php";

$db = new PDO('mysql:host=' . $config['dbhost'] . ';dbname=' . $config['dbname'] . ';charset=utf8', $config['dbuser'], $config['dbpassword']);
