<?php

namespace Ecdb\Controllers;

class MemberController extends BaseController {

    private function inPasswordValid($member_id, $password) {
        $data = $this->db->fetchAssoc('SELECT COUNT(*) AS c FROM members WHERE member_id = ? AND passwd = ?', array(
            $member_id,
            md5($password),
        ));

        return !empty($data['c']);
    }

    public function edit(\Slim\Http\Request $req, \Slim\Http\Response $response, $args) {


        if($req->isPost()) {
            $owner = $_SESSION['SESS_MEMBER_ID'];
            $firstname = $req->getParam('firstname');
            $lastname = $req->getParam('lastname');
            $mail = $req->getParam('mail');
            $measurement = (int) $req->getParam('measurement');
            $currency = $req->getParam('currency');
            $oldpass = $req->getParam('oldpass');
            $newpass = $req->getParam('newpass');

            if (!in_array($currency, array('SEK', 'USD', 'EUR', 'GBP'))) {
                $currency = 'SEK';
            }

            if (!$firstname) {
                $_SESSION['ERRMSG_ARR'][] = 'First name missing';
            } else if (strlen($firstname) < 2) {
                $_SESSION['ERRMSG_ARR'][] = 'Minimum of 2 chars in first name.';
            }

            if (!$lastname) {
                $_SESSION['ERRMSG_ARR'][] = 'Last name missing';
            } else if (strlen($lastname) < 2) {
                $_SESSION['ERRMSG_ARR'][] = 'Minimum of 2 chars in last name.';
            }

            if (!$mail) {
                $_SESSION['ERRMSG_ARR'][] = 'Mail missing';
            } else if (!filter_var($mail, FILTER_VALIDATE_EMAIL)) {
                $_SESSION['ERRMSG_ARR'][] = 'Invalid e-mail address';
            }

            if (!$oldpass && $newpass) {
                $_SESSION['ERRMSG_ARR'][] = 'For setting new password, please provide current password';
            } else if ($oldpass && !$newpass && strlen($newpass) < 5) {
                $_SESSION['ERRMSG_ARR'][] = 'Minimum of 5 chars in password';
            } else if ($oldpass && !$this->inPasswordValid($owner, $oldpass)) {
                $_SESSION['ERRMSG_ARR'][] = 'Provided current password is incorrect';
            }

            if (empty($_SESSION['ERRMSG_ARR'])) {
                $data = array(
                    'firstname' => $firstname,
                    'lastname' => $lastname,
                    'mail' => $mail,
                    'passwd' => md5($newpass),
                    'measurement' => $measurement,
                    'currency' => $currency,
                );
                if ($oldpass && $newpass) {
                    $data['passwd'] = md5($newpass);
                }
                $this->db->update('members', $data, array(
                    'member_id' => $owner,
                ));
                $_SESSION['messages'][] = 'Settings updated';
                return $this->redirect($response, 'my');
            }
        }

        $data = $this->db->fetchAssoc('SELECT * FROM members WHERE member_id = ?', array(
            $_SESSION['SESS_MEMBER_ID']
        ));

        unset($data['passwd']);

        if ($req->isPost()) {
            $data['firstname'] = $firstname;
            $data['lastname'] = $lastname;
            $data['mail'] = $mail;
            $data['measurement'] = $measurement;
            $data['currency'] = $currency;
        }

        $this->view->assign('member', $data);

        $this->view->assign('selected_menu', 'my');

        return $this->view->display('member.tpl');
    }

}

