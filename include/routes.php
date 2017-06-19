<?php

$app->get('/', 'ComponentController:listing')->setName('index');
$app->get('/category', 'ComponentController:listing')->setName('index');
$app->get('/component/{id:[0-9]+}', 'ComponentController:view')->setName('component');
$app->get('/component/{id:[0-9]+}/edit', 'ComponentController:edit')->setName('component_edit');
$app->post('/component/{id:[0-9]+}/edit', 'ComponentController:save')->setName('component_edit');
$app->post('/component/{id:[0-9]+}/delete', 'ComponentController:delete')->setName('component_delete');
$app->get('/component/add', 'ComponentController:add')->setName('component_add');
$app->get('/component/add/{id:[0-9]+}', 'ComponentController:add')->setName('component_add');
$app->post('/component/add', 'ComponentController:save')->setName('component_add');
$app->post('/component/add/{id:[0-9]+}', 'ComponentController:save')->setName('component_add');
$app->get('/components/public', 'ComponentController:public_listing')->setName('components_public');
$app->get('/components/search', 'ComponentController:search')->setName('search');
$app->post('/ajax/change_component_count_field', 'AjaxController:component_count')->setName('ajax_component_count');
$app->get('/ajax/autocomplete', 'AjaxController:autocomplete')->setName('ajax_autocomplete');
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
$app->get('/my', 'MemberController:edit')->setName('member_edit');
$app->post('/my', 'MemberController:edit')->setName('member_edit');
$app->get('/terms', 'TermsController:index')->setName('terms');
$app->get('/contact', 'ContactController:index')->setName('contact');
$app->get('/donate', 'DonateController:index')->setName('donate');
$app->get('/shoplist', 'ShopController:index')->setName('shoplist');

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
