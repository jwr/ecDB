<?php

namespace Ecdb\Controllers;

class RegisterController extends BaseController {

    public function __construct($app) {
        parent::__construct($app);

        $this->view->assign('selected_menu', 'Register');
    }

    public function index(\Slim\Http\Request $req, \Slim\Http\Response $response, $args) {
        return $this->view->display('registration.tpl');
    }

    public function register(\Slim\Http\Request $req, \Slim\Http\Response $response, $args) {

        //Array to store validation errors
        $errors = array();

        //Sanitize the POST values
        $fname = $req->getParam('fname');
        $lname = $req->getParam('lname');
        $login = $req->getParam('login');
        $mail = $req->getParam('mail');
        $password = $req->getParam('password');
        $cpassword = $req->getParam('cpassword');

        //Input Validations
        if (!$fname) {
            $errors[] = 'First name missing';
        } else if (strlen($fname) < 2) {
            $errors[] = 'Minimum of 2 chars in first name.';
        }
        if (!$lname) {
            $errors[] = 'Last name missing';
        } else if (strlen($lname) < 2) {
            $errors[] = 'Minimum of 2 chars in last name.';
        }
        if (!$login) {
            $errors[] = 'Username missing';
        } else if (strlen($login) < 2) {
            $errors[] = 'Minimum of 2 chars in username.';
        }
        if (!$mail) {
            $errors[] = 'Mail missing';
        } else if (!filter_var($mail, FILTER_VALIDATE_EMAIL)) {
            $errors[] = 'Invalid e-mail address';
        }
        if (!$password) {
            $errors[] = 'Password missing';
        } else if (strlen($password) < 5) {
            $errors[] = 'Minimum of 5 chars in password.';
        }
        if (!$cpassword) {
            $errors[] = 'Confirm password missing';
        } else if (strcmp($password, $cpassword) != 0) {
            $errors[] = 'Passwords do not match';
        }

        //Check for duplicate login ID
        if ($login) {
            $data = $this->db->fetchAssoc('SELECT COUNT(*) as count FROM members WHERE login=?', array(
                $login,
            ));
            if ($data['count']) {
                $errors[] = 'Username already in use';
            }
        }

        //If there are input validations, redirect back to the registration form
        if ($errors) {
            $_SESSION['ERRMSG_ARR'] = $errors;

            $this->view->assign('fname', $fname);
            $this->view->assign('lname', $lname);
            $this->view->assign('login', $login);
            $this->view->assign('mail', $mail);
            return $this->render('registration.tpl');
        }

        //Create INSERT query
        $added = $this->db->insert('members', array(
            'firstname' => $fname,
            'lastname' => $lname,
            'login' => $login,
            'mail' => $mail,
            'passwd' => md5($_POST['password']),
        ));

        $_SESSION['messages'][] = 'User created';

        // TODO: just do auto-login, why user has to login
        return $response->withRedirect('login');
    }

}

