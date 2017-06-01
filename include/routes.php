<?php

// index
$app->any('/', function ($request, $response, $args) {
    require_once(__DIR__ . '/../index_page.php');
})->setName('index');
$app->any('/index.php', function ($request, $response, $args) {
    require_once(__DIR__ . '/../index_page.php');
})->setName('index');

// login/logout
$app->get('/login', 'LoginController:index')->setName('login');
$app->post('/auth', 'LoginController:auth')->setName('auth');
$app->get('/logout', 'LoginController:logout')->setName('logout');
$app->get('/register', 'RegisterController:index')->setName('register');
$app->post('/register', 'RegisterController:register')->setName('register');
$app->get('/about', 'AboutController:index')->setName('about');
$app->get('/proj_list', 'ProjectController:projects')->setName('projects');
$app->post('/project_add', 'ProjectController:add')->setName('project_add');
$app->get('/project/{id}/edit', 'ProjectController:edit')->setName('project_edit');
$app->post('/project/{id}/edit', 'ProjectController:edit')->setName('project_edit');
$app->get('/project/{id}', 'ProjectController:view')->setName('project');

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
