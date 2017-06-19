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

    protected function render($template_filename) {

        $message_types = array(
            'ERRMSG_ARR' => 'errors',
            'messages' => 'messages',
            'info' => 'info',
        );
        foreach ($message_types as $var_session=>$var_tpl) {
            if (!empty($_SESSION[$var_session])) {
                $existing_messages = empty($this->view->tpl_vars[$var_tpl]->value) ? array() : $this->view->tpl_vars[$var_tpl]->value;
                $this->view->assign($var_tpl, array_merge($existing_messages, $_SESSION[$var_session]));
                unset($_SESSION[$var_session]);
            }
        }

        return $this->view->display($template_filename);
    }

    protected function renderError(\Slim\Http\Response $response, $error_code) {
        $this->view->assign('error_code', $error_code);
        $this->view->display('error.tpl');
        return $response->withStatus(403);
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