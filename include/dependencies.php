<?php


$container = $app->getContainer();

$container['view'] = function ($container) use ($ECDB_VERSION) {
    $smarty = new Smarty();
    $smarty->setTemplateDir(__DIR__ . '/../views');
    $smarty->assign('ECDB_VERSION', $ECDB_VERSION);
    $smarty->error_reporting = E_ALL & ~E_NOTICE;

    return $smarty;
};

$container['db'] = function ($container) use ($config) {
    $c = new \Doctrine\DBAL\Configuration();

    $connectionParams = array(
        'dbname' => $config['db']['db'],
        'user' => $config['db']['username'],
        'password' => $config['db']['password'],
        'host' => $config['db']['host'],
        'driver' => 'pdo_mysql',
    );

    return \Doctrine\DBAL\DriverManager::getConnection($connectionParams, $c);
};
