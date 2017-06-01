<?php

namespace Ecdb\Controllers;

class DonateController extends BaseController {

    public function index(\Slim\Http\Request $req, \Slim\Http\Response $response, $args) {
        $this->view->assign('selected_menu', 'donate');
        return $this->view->display('donate.tpl');
    }

}

