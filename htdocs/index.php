<?php

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
