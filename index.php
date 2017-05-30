<?php

require_once __DIR__ . '/setup.php';

$app = new \Slim\App(new \Slim\Container);

require_once __DIR__ . '/include/dependencies.php';
require_once __DIR__ . '/include/middlewares.php';
require_once __DIR__ . '/include/routes.php';

$app->run();
