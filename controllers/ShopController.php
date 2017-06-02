<?php

namespace Ecdb\Controllers;

class ShopController extends BaseController {

    public function index(\Slim\Http\Request $req, \Slim\Http\Response $response, $args) {

        $order_fields = array(
            'name',
            'manufacturer',
            'package',
            'smd',
            'price',
            'quantity',
            'quantity_order',
        );

        $by = $req->getParam('order');
        $order = $req->getParam('by');

        if (!in_array($order, array('asc', 'desc'))) {
            $order = 'asc';
        }
        if (!array_key_exists($by, $order_fields)) {
            $by = 'name';
        }

        $sql = "SELECT * FROM data WHERE owner = ? AND order_quantity > 0 ORDER by {$by} {$order}";
        $data = $this->db->fetchAll($sql, array(
            $_SESSION['SESS_MEMBER_ID'],
        ));
        $this->view->assign('components', $data);

        $total_price = 0;
        foreach ($data as $row) {
            $total_price += (float) $row['price'] * (int) $row['order_quantity'];
        }
        $this->view->assign('total_price', $total_price);

        $sql = "SELECT currency FROM members WHERE member_id = ?";
        $currency = $this->db->fetchAssoc($sql, array(
            $_SESSION['SESS_MEMBER_ID'],
        ));
        $this->view->assign('currency', $currency['currency']);

        $this->view->assign('selected_menu', 'shop_list');

        return $this->view->display('shop_list.tpl');
    }

}

