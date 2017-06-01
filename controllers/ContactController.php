<?php

namespace Ecdb\Controllers;

class ContactController extends BaseController {

    public function index(\Slim\Http\Request $req, \Slim\Http\Response $response, $args) {
        return $this->view->display('contact.tpl');
    }

}

