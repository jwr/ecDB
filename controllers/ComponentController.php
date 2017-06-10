<?php

namespace Ecdb\Controllers;

use Doctrine\DBAL\Driver\DrizzlePDOMySql\Connection;

class ComponentController extends BaseController {

    public function listing(\Slim\Http\Request $req, \Slim\Http\Response $response, $args) {

        $owner = $_SESSION['SESS_MEMBER_ID'];

        $category_id = $req->getParam('cat');
        $sub_category_id = $req->getParam('subcat');
        $by = $req->getParam('by');
        $order = $req->getParam('order');
        if (!in_array($order, array('asc', 'desc'))) {
            $order = 'asc';
        }
        $by_map = array(
            'price' => 'price+0 ' . $order,
            'pins' => 'pins+0 ' . $order,
            'quantity' => 'quantity+0 ' . $order,
            'category' => "nx {$order}, snx {$order}",
            'name' => 'd.name ' . $order,
            'package' => 'package ' . $order,
            'smd' => 'smd ' . $order,
        );
        $components_order = in_array($by, $by_map) ? $by_map[$by] : "d.name $order";

        if (!$category_id && $sub_category_id) {
            $sql = "SELECT floor(id / 100) FROM category_sub where id = ?";
            $category_id = $this->db->fetchColumn($sql, array($sub_category_id));
        }

        $sql = "SELECT ch.id
                     , ch.name
                     , COUNT(d.id) elements
                  FROM category_head ch
             LEFT JOIN data d ON floor(d.category / 100) = ch.id
                 GROUP BY ch.name
                 ORDER BY ch.name ASC";
        $categories = $this->db->fetchAll($sql);

        if ($category_id) {
            $sql = "SELECT c.id
                         , c.name
                         , COUNT(d.id) elements
                      FROM category_sub c
                 LEFT JOIN data d ON d.category = c.id
                     WHERE floor(c.id / 100) = ?
                     GROUP BY c.name
                     ORDER by c.name ASC";
            $sub_categories = $this->db->fetchAll($sql, array($category_id));
            $sub_category_ids = array();
            foreach ($sub_categories as $sub_category) {
                $sub_category_ids[] = $sub_category['id'];
            }

            $sql = "SELECT category FROM data WHERE owner = ? AND category IN (?) GROUP BY category";
            $stmt = $this->db->executeQuery($sql, array(
                $owner,
                $sub_category_ids,
            ), array(
                \PDO::PARAM_INT,
                \Doctrine\DBAL\Connection::PARAM_INT_ARRAY,
            ));
            $subcategories_with_components = $stmt->fetchAll();
            $subcategories_with_components = array_map(function ($row) {
                return (int) $row['category'];
            }, $subcategories_with_components);

            $this->view->assign('sub_categories', $sub_categories);
            $this->view->assign('subcategories_with_components', $subcategories_with_components);
        }

        $sql = "SELECT d.id
                     , d.name
                     , d.category
                     , d.package
                     , d.pins
                     , d.datasheet
                     , d.url1
                     , d.smd
                     , d.price
                     , d.quantity
                     , d.comment
                     , d.location
                     , c.`name` as nx
                     , sc.name as snx
                     , sc.id as scid
                  FROM data d
                  JOIN category_sub sc ON d.category = sc.id
                  JOIN category_head c ON c.id = FLOOR(sc.id / 100)
                 WHERE owner = ?";
        $params = array(
            $owner,
        );
        if ($category_id) {
            $sql .= " AND c.id = ? ";
            $params[] = $category_id;
        }
        if ($sub_category_id) {
            $sql .= " AND sc.id = ? ";
            $params[] = $sub_category_id;
        }
        $sql .= "ORDER BY {$components_order}";
        $components = $this->db->fetchAll($sql, $params);

        $this->view->assign('categories', $categories);
        $this->view->assign('category_id', $category_id);
        $this->view->assign('sub_category_id', $sub_category_id);
        $this->view->assign('components', $components);
        $this->view->assign('order', $order);
        $this->view->assign('selected_menu', 'components');

        return $this->render('components.tpl');
    }
}

