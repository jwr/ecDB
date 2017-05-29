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

        if (!empty($_SESSION['ERRMSG_ARR'])) {
            $this->view->assign('errors', $_SESSION['ERRMSG_ARR']);
            unset($_SESSION['ERRMSG_ARR']);
        }
        if (!empty($_SESSION['messages'])) {
            $this->view->assign('messages', $_SESSION['messages']);
            unset($_SESSION['messages']);
        }
    }

}