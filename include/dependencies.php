<?php


$container = $app->getContainer();

$container['view'] = function ($container) use ($ECDB_VERSION) {
    $smarty = new Smarty();
    $smarty->setTemplateDir(__DIR__ . '/../views');
    $smarty->assign('ECDB_VERSION', $ECDB_VERSION);
    $smarty->error_reporting = E_ALL & ~E_NOTICE;

    return $smarty;
};
