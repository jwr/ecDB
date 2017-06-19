<?php

namespace Ecdb\Controllers;

class AjaxController extends BaseController {

    public function component_count(\Slim\Http\Request $req, \Slim\Http\Response $response, $args) {

        $owner = $_SESSION['SESS_MEMBER_ID'];
        $component_id = $req->getParam('component_id');
        $field = $req->getParam('field');
        $increase = (bool) $req->getParam('increase');

        if (!in_array($field, array('quantity', 'order_quantity'))) {
            return $response->withJson(array(
                'error' => 'Unknown component field',
            ));
        }

        $sql = "UPDATE data SET {$field} = {$field} + 1 WHERE owner = ? AND id = ?";
        if (!$increase) {
            $sql = "UPDATE data SET {$field} = {$field} - 1 WHERE owner = ? AND id = ?";
        }
        $changes = $this->db->executeUpdate($sql, array(
            $owner,
            $component_id,
        ));

        if (!$changes) {
            return $response->withJson(array(
                'error' => 'Component not found',
            ));
        }

        $sql = 'SELECT * FROM data WHERE owner = ? and id = ?';
        $component = $this->db->fetchAssoc($sql, array(
            $owner,
            $component_id,
        ));

        return $response->withJson(array(
            'data' => array(
                'name' => $field,
                'value' => $component[$field],
            ),
        ));
    }

}

