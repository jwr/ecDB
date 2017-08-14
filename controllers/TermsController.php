<?php

namespace Ecdb\Controllers;

class TermsController extends BaseController {

    public function index(\Slim\Http\Request $req, \Slim\Http\Response $response, $args) {
        return $this->view->display('terms.tpl');
    }

}

