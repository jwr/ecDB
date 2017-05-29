<?php

// index
$app->any('/', function ($request, $response, $args) {
    require_once(__DIR__ . '/../index_page.php');
});
$app->any('/index.php', function ($request, $response, $args) {
    require_once(__DIR__ . '/../index_page.php');
});

// redirect to php file
$app->any('/{filename}.php', function ($request, \Slim\Http\Response $response, $args) {
    $filename = realpath($args['filename'] . '.php');
    if (!$filename) {
        return $response->withStatus(404);
    }
    $base = dirname($filename);
    if (dirname(__DIR__) != $base) {
        return $response->withStatus(404);
    }

    require_once $filename;
});
