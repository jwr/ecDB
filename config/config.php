<?php

$config = array();

$config['debug'] = true;

$config['db'] = array(
    'host' => 'localhost',
    'username' => 'username',
    'password' => 'password',
    'db' => 'database',
);

/**
 * Google Analytics config
 */
$config['google_analytics'] = array(
    'account' => '', // UA-xxxxxxxx-x
    'site' => '', // ecdb.net
);

/**
 * Directory where Smarty will store compiled templates
 */
$config['smarty_compile_dir'] = sys_get_temp_dir();
