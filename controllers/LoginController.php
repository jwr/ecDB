<?php

namespace Ecdb\Controllers;

class LoginController extends BaseController {

    public function logout(\Slim\Http\Request $req, \Slim\Http\Response $response, $args) {
        unset($_SESSION['SESS_MEMBER_ID']);
        unset($_SESSION['SESS_FIRST_NAME']);
        unset($_SESSION['SESS_LAST_NAME']);
        unset($_SESSION['SESS_IS_ADMIN']);

        $_SESSION['messages'] = 'You have successfully signed out of your account.';

        return $response->withRedirect('login');
    }

    public function auth(\Slim\Http\Request $req, \Slim\Http\Response $response, $args) {
        //Array to store validation errors
        $errmsg_arr = array();

        //Sanitize the POST values
        $login = $req->getParam('login');
        $password = $req->getParam('password');

        //Input Validations
        if (!$login) {
            $errmsg_arr[] = 'Login ID missing';
        }
        if (!$password) {
            $errmsg_arr[] = 'Password missing';
        }

        //If there are input validations, redirect back to the login form
        if ($errmsg_arr) {
            $_SESSION['ERRMSG_ARR'] = $errmsg_arr;

            return $response->withRedirect('login');
        }

        $data = $this->db->fetchAssoc('SELECT * FROM members WHERE login=? AND passwd=?', array(
            $login,
            md5($_POST['password']),
        ));

        if (!$data) {
            $_SESSION['ERRMSG_ARR'] = 'Invalid username/password';

            return $response->withRedirect('login');
        }

        //Login Successful
        session_regenerate_id(true);
        $_SESSION['SESS_MEMBER_ID'] = $data['member_id'];
        $_SESSION['SESS_FIRST_NAME'] = $data['firstname'];
        $_SESSION['SESS_LAST_NAME'] = $data['lastname'];
        $_SESSION['SESS_IS_ADMIN'] = intval($data['admin']);
        session_write_close();

        $member_id = $_SESSION['SESS_MEMBER_ID'];
        $this->db->insert('members_stats', array('members_stats_member' => $member_id));

        return $this->redirect($response, 'index');
    }

    public function index(\Slim\Http\Request $req, \Slim\Http\Response $response, $args) {
        //Unset the variables stored in session
        unset($_SESSION['SESS_MEMBER_ID']);
        unset($_SESSION['SESS_FIRST_NAME']);
        unset($_SESSION['SESS_LAST_NAME']);
        unset($_SESSION['SESS_IS_ADMIN']);

        $this->view->assign('selected_menu', 'Login');

        return $this->view->display('login.tpl');
    }

}

