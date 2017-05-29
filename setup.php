<?php

$ECDB_VERSION = '0.3';

//Start session
session_start();

require_once __DIR__ . '/vendor/autoload.php';
require_once __DIR__ . '/config/config.php';

if (!empty($config['debug'])){
    error_reporting(E_ALL);
    ini_set('display_errors', '1');
}
