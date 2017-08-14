<?php


$container = $app->getContainer();

$container['LoginController'] = function ($container) use ($app) {
    return new \Ecdb\Controllers\LoginController($app);
};
$container['RegisterController'] = function ($container) use ($app) {
    return new \Ecdb\Controllers\RegisterController($app);
};
$container['AboutController'] = function ($container) use ($app) {
    return new \Ecdb\Controllers\AboutController($app);
};
$container['ProjectController'] = function ($container) use ($app) {
    return new \Ecdb\Controllers\ProjectController($app);
};
$container['MemberController'] = function ($container) use ($app) {
    return new \Ecdb\Controllers\MemberController($app);
};
$container['TermsController'] = function ($container) use ($app) {
    return new \Ecdb\Controllers\TermsController($app);
};
$container['ContactController'] = function ($container) use ($app) {
    return new \Ecdb\Controllers\ContactController($app);
};
$container['DonateController'] = function ($container) use ($app) {
    return new \Ecdb\Controllers\DonateController($app);
};
$container['ShopController'] = function ($container) use ($app) {
    return new \Ecdb\Controllers\ShopController($app);
};
$container['ComponentController'] = function ($container) use ($app) {
    return new \Ecdb\Controllers\ComponentController($app);
};
$container['AjaxController'] = function ($container) use ($app) {
    return new \Ecdb\Controllers\AjaxController($app);
};
$container['view'] = function ($container) use ($ECDB_VERSION, $config) {
    $smarty = new Smarty();
    $smarty->setTemplateDir(__DIR__ . '/../views');
    $smarty->setCompileDir($config['smarty_compile_dir']);
    $smarty->assign('ECDB_VERSION', $ECDB_VERSION);
    $smarty->error_reporting = E_ALL & ~E_NOTICE;

    /** @var \Doctrine\DBAL\Connection $db */
    $db = $container['db'];

    $data1 = $db->fetchAssoc('SELECT COUNT(member_id) AS count FROM members');
    $data2 = $db->fetchAssoc('SELECT COUNT(id) AS count FROM data');
    $data3 = $db->fetchAssoc('SELECT COUNT(project_id) AS count FROM projects');

    $STATS = array(
        'members' => $data1['count'],
        'components' => $data2['count'],
        'projects' => $data3['count'],
    );
    $smarty->assign('STATS', $STATS);

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
