<?php

/**
 * In case running PHP built-in web server, images/js/css requests will not be handled by this file, but server directly.
 * In case running with Apache web server, this is handled with .htaccess.
 */
if (php_sapi_name() == 'cli-server' && preg_match('/\.(?:png|jpg|jpeg|gif|css|js|ico)$/', $_SERVER['REQUEST_URI'])) {
    return false;
}

require_once __DIR__ . '/../setup.php';

$app = new \Slim\App(array(
    'settings' => array(
        'determineRouteBeforeAppMiddleware' => true,
    ),
));

require_once __DIR__ . '/../include/dependencies.php';
require_once __DIR__ . '/../include/middlewares.php';
require_once __DIR__ . '/../include/routes.php';

$app->run();
