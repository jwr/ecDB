<?php

namespace Ecdb\Controllers;

class AboutController extends BaseController {

    public function index(\Slim\Http\Request $req, \Slim\Http\Response $response, $args) {
        $this->view->assign('selected_menu', 'About');
        return $this->view->display('about.tpl');
    }

}

