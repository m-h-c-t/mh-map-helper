<?php

require_once "config.php";

//$db = new PDO("mysql:host=localhost;dbname=agiletr1_mhmaphelper;charset=utf8", 'agiletr1_mh', 'h]T$q%~s39f1');

$db = new PDO('mysql:host=' . $config['dbhost'] . ';dbname=' . $config['dbname'] . ';charset=utf8', $config['dbuser'], $config['dbpassword']);
