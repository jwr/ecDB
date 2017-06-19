<?php

namespace Ecdb\Controllers;

class AjaxController extends BaseController {

    public function autocomplete(\Slim\Http\Request $req, \Slim\Http\Response $response, $args) {

        $q = $req->getParam('q');
        $field = $req->getParam('f');
        $q = strtolower($q);
        if (!in_array($field, array('manufacturer', 'name', 'package'))) {
            $field = 'name';
        }

        $sql = "select DISTINCT {$field} as f from data where {$field} LIKE ? ORDER by {$field} ASC";
        $values = $this->db->fetchAll($sql, array(
            "%{$q}%",
        ));

        foreach ($values as $value) {
            echo $value['f'],"\n";
        }
    }

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

