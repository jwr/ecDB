<?php

namespace Ecdb\Controllers;

use Doctrine\DBAL\Driver\DrizzlePDOMySql\Connection;

class ComponentController extends BaseController {

    public function search(\Slim\Http\Request $req, \Slim\Http\Response $response, $args) {

        $owner				=	$_SESSION['SESS_MEMBER_ID'];

        $query = $req->getParam('q');
        $query = trim(strip_tags(strtoupper($query)));
        $by = $req->getParam('by');
        $order = $req->getParam('order');

        if (!in_array($order, array('asc', 'desc'))) {
            $order = 'asc';
        }

        $by_map = array(
            'price' => 'price+0',
            'pins' => 'pins+0',
            'quantity' => 'quantity+0',
            'name' => 'name',
            'category' => 'category',
            'package' => 'package',
            'smd' => 'smd',
            'manufacturer' => 'manufacturer',
        );
        if (!array_key_exists($by, $by_map)) {
            $by = 'name';
        } else {
            $by = $by_map[$by];
        }

        $sql = "SELECT d.*
                     , c.`name` as nx
                     , sc.name as snx
                     , sc.id as scid
                  FROM data d
                  JOIN category_sub sc ON d.category = sc.id
                  JOIN category_head c ON c.id = FLOOR(sc.id / 100)
                 WHERE (d.name LIKE ? OR d.package LIKE ? OR d.manufacturer LIKE ? OR d.pins LIKE ? OR d.location LIKE ? OR d.comment LIKE ?)
                   AND owner = ?
                 ORDER BY {$by} {$order}";
        $components = $this->db->fetchAll($sql, array(
            "%{$query}%",
            "%{$query}%",
            "%{$query}%",
            "%{$query}%",
            "%{$query}%",
            "%{$query}%",
            $owner,
        ));



        $this->view->assign('components', $components);
        $this->view->assign('selected_menu', 'search');

        return $this->render('components_search.tpl');
    }

    public function public_listing(\Slim\Http\Request $req, \Slim\Http\Response $response, $args) {

        $this->view->assign('selected_menu', 'components_public');

        return $this->render('components_public.tpl');
    }

    public function save(\Slim\Http\Request $req, \Slim\Http\Response $response, $args) {
        $owner				=	$_SESSION['SESS_MEMBER_ID'];
        $id = !empty($args['id']) ? $args['id'] : null;

        $new_component = $req->getAttribute('route')->getName() == 'component_add';

        $component = $req->getParam('component');

        $name = isset($component['name']) ? $component['name'] : '';
        $quantity = isset($component['quantity']) ? $component['quantity'] : '';
        $category = isset($component['category']) ? $component['category'] : '';
        $comment = isset($component['comment']) ? $component['comment'] : '';
        $order_quantity = isset($component['order_quantity']) ? $component['order_quantity'] : '';
        $price = isset($component['price']) ? $component['price'] : '';
        $location = isset($component['location']) ? $component['location'] : '';
        $manufacturer = isset($component['manufacturer']) ? $component['manufacturer'] : '';
        $package = isset($component['package']) ? $component['package'] : '';
        $pins = isset($component['pins']) ? $component['pins'] : '';
        $scrap = isset($component['scrap']) ? $component['scrap'] : 'No';
        $smd = isset($component['smd']) ? $component['smd'] : 'No';
        $width = isset($component['width']) ? $component['width'] : null;
        $height = isset($component['height']) ? $component['height'] : null;
        $depth = isset($component['depth']) ? $component['depth'] : null;
        $weight = isset($component['weight']) ? $component['weight'] : null;
        $datasheet = isset($component['datasheet']) ? $component['datasheet'] : null;
        $url1 = isset($component['url1']) ? $component['url1'] : '';
        $url2 = isset($component['url2']) ? $component['url2'] : '';
        $url3 = isset($component['url3']) ? $component['url3'] : '';
        $url4 = isset($component['url4']) ? $component['url4'] : '';
        $public = isset($component['public']) ? $component['public'] : 'No';

        $project = $req->getParam('project');
        $projquant = $req->getParam('projquant');

        if (mb_strlen($name) < 2) {
            $_SESSION['ERRMSG_ARR'][] = 'You have to specify a name!';
        }
        if (!$category) {
            $_SESSION['ERRMSG_ARR'][] = 'You have to choose a category!';
        }
        if (strlen($comment) >= 2500) {
            $_SESSION['ERRMSG_ARR'][] = 'Max 2500 characters in the comment!';
        }
        if ($quantity && !is_numeric($quantity)) {
            $_SESSION['ERRMSG_ARR'][] = 'The quantity must only be a number!';
        }
        if ($pins && !is_numeric($pins)) {
            $_SESSION['ERRMSG_ARR'][] = 'The pin-count must only be a number!';
        }
        if ($price && !is_numeric($price)) {
            $_SESSION['ERRMSG_ARR'][] = 'The price must only be a number!';
        }
        if ($order_quantity && !is_numeric($order_quantity)) {
            $_SESSION['ERRMSG_ARR'][] = 'The order quantity must only be a number!';
        }
        if ($weight && !is_numeric($weight)) {
            $_SESSION['ERRMSG_ARR'][] = 'The weight must only be a number!';
        }
        if ($width && !is_numeric($width)) {
            $_SESSION['ERRMSG_ARR'][] = 'The width must only be a number!';
        }
        if ($depth && !is_numeric($depth)) {
            $_SESSION['ERRMSG_ARR'][] = 'The depth must only be a number!';
        }
        if ($height && !is_numeric($height)) {
            $_SESSION['ERRMSG_ARR'][] = 'The height must only be a number!';
        }
        if ($projquant && !$project) {
            $_SESSION['ERRMSG_ARR'][] = 'You have to choose a project!';
        }
        if ($project && !$projquant) {
            $_SESSION['ERRMSG_ARR'][] = 'You have to specify a quantity for this component to add to the project!';
        }

        $inserted = false;
        $updated = false;

        if (empty($_SESSION['ERRMSG_ARR'])) {
            if ($id && !$new_component) {
                $updated = $this->db->update('data', array(
                    'name' => $name,
                    'manufacturer' => $manufacturer,
                    'package' => $package,
                    'pins' => $pins,
                    'smd' => $smd,
                    'quantity' => $quantity,
                    'location' => $location,
                    'scrap' => $scrap,
                    'width' => $width,
                    'height' => $height,
                    'depth' => $depth,
                    'weight' => $weight,
                    'datasheet' => $datasheet,
                    'comment' => $comment,
                    'category' => $category,
                    'url1' => $url1,
                    'url2' => $url2,
                    'url3' => $url3,
                    'url4' => $url4,
                    'price' => $price,
                    'order_quantity' => $order_quantity,
                    'public' => $public,
                ), array(
                    'id' => $id,
                ));
                if ($updated) {
                    $_SESSION['messages'][] = 'Updated';
                }

                $edit_projects = $req->getParam('projquantedit');
                foreach ($edit_projects as $edit_project_id=>$edit_project_quantity) {
                    if ($edit_project_quantity < 1) {
                        $project_deleted = $this->db->delete('projects_data', array(
                            'projects_data_owner_id' => $owner,
                            'projects_data_project_id' => $edit_project_id,
                            'projects_data_component_id' => $id,
                        ));
                        if ($project_deleted) {
                            $_SESSION['messages'][] = 'Component deleted from project';
                        }
                    } else {
                        $project_updated = $this->db->update('projects_data', array(
                            'projects_data_quantity' => $edit_project_quantity,
                        ), array(
                            'projects_data_owner_id' => $owner,
                            'projects_data_project_id' => $edit_project_id,
                            'projects_data_component_id' => $id,
                        ));
                        if ($project_updated) {
                            $_SESSION['messages'][] = 'Component quantity in project updated';
                        }
                    }
                }
            } else {
                $inserted = $this->db->insert('data', array(
                    'owner' => $owner,
                    'name' => $name,
                    'manufacturer' => $manufacturer,
                    'package' => $package,
                    'pins' => $pins,
                    'smd' => $smd,
                    'quantity' => $quantity,
                    'location' => $location,
                    'scrap' => $scrap,
                    'width' => $width,
                    'height' => $height,
                    'depth' => $depth,
                    'weight' => $weight,
                    'datasheet' => $datasheet,
                    'comment' => $comment,
                    'category' => $category,
                    'url1' => $url1,
                    'url2' => $url2,
                    'url3' => $url3,
                    'url4' => $url4,
                    'price' => $price,
                    'order_quantity' => $order_quantity,
                    'public' => $public,
                ));
                if ($inserted) {
                    $id = $this->db->lastInsertId();
                    // TODO: base path here
                    $_SESSION['messages'][] = "Component added! - <a href=\"component/{$id}\">View component ({$name})</a>";
                }
            }

            if ($project && $projquant) {
                $this->db->insert('projects_data', array(
                    'projects_data_owner_id' => $owner,
                    'projects_data_project_id' => $project,
                    'projects_data_component_id' => $id,
                    'projects_data_quantity' => $projquant,
                ));
            }
        }

        if ($inserted || $updated) {
            return $this->redirect($response, 'component_edit', array(
                'id' => $id,
            ));
        }

        $args['post_component'] = $component;

        if ($new_component) {
            return $this->add($req, $response, $args);
        }
        return $this->edit($req, $response, $args);
    }

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

    public function delete(\Slim\Http\Request $req, \Slim\Http\Response $response, $args) {

        $deleted = $this->db->delete('data', array(
            'id' => $args['id'],
            'owner' => $_SESSION['SESS_MEMBER_ID'],
        ));

        if ($deleted) {
            $_SESSION['messages'][] = 'Component deleted';
            return $this->redirect($response, 'index');
        }

        $_SESSION['ERRMSG_ARR'][] = 'Component not found';
        return $this->redirect($response, 'component', array(
            'id' => $args['id'],
        ));
    }

    public function edit(\Slim\Http\Request $req, \Slim\Http\Response $response, $args) {
        $owner = $_SESSION['SESS_MEMBER_ID'];
        $id = !empty($args['id']) ? $args['id'] : null;

        $component = $this->getComponent($id);

        if (!$component) {
            return $this->renderError($response, 2);
        }

        $category = $this->getCategoriesNames($component['category']);
        $project = $this->getComponentProject($component['id']);

        $sql = 'SELECT currency, measurement FROM members WHERE member_id = ?';
        $member_settings = $this->db->fetchAssoc($sql, array(
            $owner,
        ));

        if (!empty($args['post_component'])) {
            $args['post_component']['id'] = $id;
            $this->view->assign('component', $args['post_component']);
        } else {
            $this->view->assign('component', $component);
        }
        $this->view->assign('member_settings', $member_settings);
        $this->view->assign('category', $category);
        $this->view->assign('project', $project);
        $this->view->assign('projects', $this->getAllProjects());
        $this->view->assign('category_tree', $this->getCategoryTree());
        $this->view->assign('selected_menu', 'components');

        return $this->render('component_edit.tpl');
    }

    private function getCategoryTree() {
        $sql = 'SELECT id, name  FROM category_head ORDER by name ASC';
        $data = $this->db->fetchAll($sql);

        $sql = 'SELECT id, name FROM category_sub WHERE floor(id / 100) = ? ORDER by name ASC';
        foreach ($data as &$row) {
            $row['subcategories'] = $this->db->fetchAll($sql, array($row['id']));
        }

        return $data;
    }

    private function getComponent($id) {
        $owner = $_SESSION['SESS_MEMBER_ID'];

        $sql = 'SELECT * FROM data WHERE id = ? AND owner = ?';
        $component = $this->db->fetchAssoc($sql, array(
            $id,
            $owner,
        ));

        return $component;
    }

    private function getCategoriesNames($subcategory_id) {
        $sql = 'SELECT c.name category_name
                     , c.id category_id
                     , cs.name sub_category_name
                     , cs.id sub_category_id
                  FROM category_head c
                  JOIN category_sub cs ON c.id = floor(cs.id / 100)
                 WHERE cs.id = ?';
        $category = $this->db->fetchAssoc($sql, array(
            $subcategory_id,
        ));

        return $category;
    }

    private function getComponentProject($component_id) {
        $sql = "SELECT projects_data.projects_data_project_id
                     , projects_data.projects_data_quantity
                     , projects_data.projects_data_project_id
                     , projects_data.projects_data_component_id
                     , projects.project_id
                     , projects.project_name
                  FROM projects_data
                     , projects
                 WHERE projects_data.projects_data_project_id = projects.project_id
                   AND projects_data.projects_data_component_id = ?
                 LIMIT 1";
        $project = $this->db->fetchAssoc($sql, array(
            $component_id,
        ));
        return $project;
    }

    private function getAllProjects() {
        $owner = $_SESSION['SESS_MEMBER_ID'];

        $sql = "SELECT * FROM projects WHERE project_owner = ?";
        $projects = $this->db->fetchAll($sql, array(
            $owner,
        ));

        return $projects;
    }

    public function view(\Slim\Http\Request $req, \Slim\Http\Response $response, $args) {
        $owner = $_SESSION['SESS_MEMBER_ID'];
        $id = !empty($args['id']) ? $args['id'] : null;

        $component = $this->getComponent($id);

        if (!$component) {
            return $this->renderError($response, 1);
        }

        $sql = 'SELECT currency, measurement FROM members WHERE member_id = ?';
        $member_settings = $this->db->fetchAssoc($sql, array(
            $owner,
        ));

        $category = $this->getCategoriesNames($component['category']);
        $project = $this->getComponentProject($component['id']);

        $this->view->assign('component', $component);
        $this->view->assign('member_settings', $member_settings);
        $this->view->assign('category', $category);
        $this->view->assign('project', $project);
        $this->view->assign('selected_menu', 'components');

        return $this->render('component.tpl');
    }

    public function add(\Slim\Http\Request $req, \Slim\Http\Response $response, $args) {
        $owner = $_SESSION['SESS_MEMBER_ID'];
        $id_based = !empty($args['id']) ? $args['id'] : null;

        $component = false;
        if ($id_based) {
            $component = $this->getComponent($id_based);
        }

        if ($id_based && !$component) {
            return $this->renderError($response, 2);
        }

        if ($component) {
            $category = $this->getCategoriesNames($component['category']);
            $project = $this->getComponentProject($component['id']);

            $this->view->assign('category', $category);
            $this->view->assign('project', $project);
        }

        $sql = 'SELECT currency, measurement FROM members WHERE member_id = ?';
        $member_settings = $this->db->fetchAssoc($sql, array(
            $owner,
        ));

        if (!empty($args['post_component'])) {
            if ($id_based) {
                $args['post_component']['id'] = $id_based;
            }
            $this->view->assign('component', $args['post_component']);
        } else {
            $this->view->assign('component', $component);
        }
        $this->view->assign('member_settings', $member_settings);
        $this->view->assign('projects', $this->getAllProjects());
        $this->view->assign('category_tree', $this->getCategoryTree());
        $this->view->assign('new_component', true);
        $this->view->assign('id_based', $id_based);
        $this->view->assign('selected_menu', 'component_add');

        return $this->render('component_edit.tpl');
    }
}

