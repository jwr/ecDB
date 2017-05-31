<?php

namespace Ecdb\Controllers;

use Doctrine\DBAL\Connection;

class BaseController {

    /**
     * @var \Smarty
     */
    protected $view;

    /**
     * @var \Slim\App
     */
    protected $app;

    /**
     * @var Connection
     */
    protected $db;

    public function __construct($app) {
        $this->app = $app;
        $this->view = $app->getContainer()->get('view');
        $this->db = $app->getContainer()->get('db');
    }

    protected function redirect($response, $path_or_name, $args=array()) {
        try {
            $path = $this->app->getContainer()->get('router')->pathFor($path_or_name, $args);
        } catch (\Exception $e) {
            $path = $path_or_name;
        }

        return $response->withRedirect($path);
    }

}