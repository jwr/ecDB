<?php

namespace Ecdb\Controllers;

class ProjectController extends BaseController {

    public function view(\Slim\Http\Request $req, \Slim\Http\Response $response, $args) {

        $owner = !empty($_SESSION['SESS_MEMBER_ID']) ? $_SESSION['SESS_MEMBER_ID'] : null;
        $id = (int) $args['id'];
        $order = $req->getParam('order');
        if (!in_array($order, array('asc', 'desc'))) {
            $order = 'asc';
        }

        $by_map = array(
            'name' => 'd.name',
            'category' => "c.name {$order}, sc.subcategory",
            'manufacturer' => 'manufacturer',
            'package' => 'package',
            'smd' => 'smd',
            'price' => 'price',
            'stock_quantity' => 'quantity',
            'order_quantity' => 'order_quantity',
            'quantity' => 'projects_data_quantity',
            'bin_location' => '', // ?
        );
        $by = $req->getParam('by', 'name');
        if (!array_key_exists($by, $by_map)) {
            $by = 'name';
        }

        $data = $this->getProject($id, $owner);

        if (!$data) {
            return $response->withRedirect('proj_list');
        }

        $this->view->assign('project', $data);

        $sql = "SELECT pd.*
                     , d.*
                     , sc.name as subcategory
                     , c.name as category
                  FROM projects_data pd
                  JOIN data d ON pd.projects_data_component_id = d.id
                  JOIN category_sub sc ON d.category = sc.id
                  JOIN category_head c ON c.id = floor(sc.id / 100)
                 WHERE pd.projects_data_project_id = ? ORDER BY {$by_map[$by]} {$order}";
        $components = $this->db->fetchAll($sql, array(
            $id,
        ));
        $this->view->assign('components', $components);

        // TODO: improve this weird query
        $sql = 'SELECT sum(project_total.total) as total
                     , m.currency
                  FROM (SELECT cast(cast(price as decimal(14, 3)) * projects_data_quantity as decimal(14, 2)) AS total
                          FROM projects_data
                          JOIN `data`
                         WHERE data.id = projects_data_component_id
                           AND projects_data_project_id = ?) AS project_total
                      , projects p
                   JOIN members m ON m.member_id = p.project_owner
                  where p.project_id = ?
               group by m.currency';
        $sum = $this->db->fetchAssoc($sql, array($id, $id));
        $this->view->assign('price', $sum);

        $this->view->assign('selected_menu', 'projects');

        return $this->view->display('project-view.tpl');
    }

    private function getProject($id, $owner_id) {
        $sql = 'SELECT * FROM projects WHERE project_id = ? AND project_owner = ?';
        return $this->db->fetchAssoc($sql, array(
            $id,
            $owner_id,
        ));
    }

    public function edit(\Slim\Http\Request $req, \Slim\Http\Response $response, $args) {

        $owner = $_SESSION['SESS_MEMBER_ID'];
        $id = (int) $args['id'];

        if ($req->isPost() && $req->getParam('delete', false) === false) {
            $name = $req->getParam('name');
            $public = (int) $req->getParam('project_public');
            $url = $req->getParam('project_url');
            $description = $req->getParam('project_desc');

            if (!$name) {
                $_SESSION['ERRMSG_ARR'][] = 'Project name missing';
            }
        } else if ($req->isPost() && $req->getParam('delete', false) !== false) {
            $deleted = $this->db->delete('projects', array(
                'project_id' => $id,
                'project_owner' => $owner,
            ));
            if ($deleted) {
                $_SESSION['messages'][] = 'Project deleted';
                return $this->redirect($response, 'projects');
            } else {
                $_SESSION['ERRMSG_ARR'][] = 'Unable to delete project';
                return $this->redirect($response, 'project_edit', array(
                    'id' => $id,
                ));
            }
        }

        $data = $this->getProject($id, $owner);

        if (!$data) {
            $_SESSION['ERRMSG_ARR'][] = 'Project not found';
            return $response->withRedirect('proj_list');
        }

        if ($req->isPost() && !empty($_SESSION['ERRMSG_ARR'])) {
            if (!empty($name)) {
                $data['project_name'] = $name;
            }
            if (isset($public)) {
                $data['project_public'] = $public;
            }
            if (isset($url)) {
                $data['project_url'] = $url;
            }
            if (isset($description)) {
                $data['project_desc'] = $description;
            }
        }

        if ($req->isPost() && empty($_SESSION['ERRMSG_ARR'])) {
            $this->db->update('projects', array(
                'project_name' => $name,
                'project_public' => $public,
                'project_url' => $url,
                'project_desc' => $description,
            ), array(
                'project_id' => $id,
            ));
            $_SESSION['messages'][] = 'Project saved';
            return $this->redirect($response, 'project_edit', array('id'=>$id));
        }

        $this->view->assign('project', $data);
        $this->view->assign('selected_menu', 'projects');

        return $this->render('project-edit.tpl');
    }

    public function add(\Slim\Http\Request $req, \Slim\Http\Response $response, $args) {

        $owner = $_SESSION['SESS_MEMBER_ID'];
        $name = $req->getParam('name');

        if (!$name) {
            $_SESSION['ERRMSG_ARR'] = array(
                'You have to specify a name!',
            );

            return $response->withRedirect('proj_list');
        }

        $added = $this->db->insert('projects', array(
            'project_owner' => $owner,
            'project_name' => $name,
        ));

        if ($added) {
            $_SESSION['messages'] = array(
                'Project added!',
            );
            return $this->redirect($response, 'project_edit', array(
                'id' => $this->db->lastInsertId(),
            ));
        } else {
            $_SESSION['ERRMSG_ARR'][] = 'Error creating new project';
        }
        return $this->redirect($response, 'projects');
    }

    public function projects(\Slim\Http\Request $req, \Slim\Http\Response $response, $args) {


        $owner = $_SESSION['SESS_MEMBER_ID'];

        $order = strtolower($req->getParam('order', 'asc')) == 'asc' ? 'asc' : 'desc';
        $sql = "SELECT projects.*
                     , m.currency currency
                     , SUM(pd1.projects_data_id) AS qty
                     , CAST(data.price as decimal(14, 2)) * pd1.projects_data_quantity AS total_price
                  FROM projects
             LEFT JOIN projects_data AS pd1 ON pd1.projects_data_project_id = projects.project_id
             LEFT JOIN data ON data.id = pd1.projects_data_component_id
                  JOIN members m ON project_owner = m.member_id
                 WHERE project_owner = ?
              group by projects.project_id
              ORDER BY project_name ".$order;
        $data = $this->db->fetchAll($sql, array($owner));

        $this->view->assign('projects', $data);

        if ($owner) {
            $data = $this->db->fetchAssoc('SELECT COUNT(*) c FROM projects WHERE project_owner = ?', array(
                $owner,
            ));
            if (empty($data['c'])) {
                $_SESSION['info'] = array(
                    'To create a BOM-list (Bill Of Material) you have to first create a project. You will then be able to add your components to your project and automaticly create a BOM-list.',
                );
            }
        }

        $this->view->assign('selected_menu', 'projects');
        $this->view->assign('order', $order);

        return $this->view->display('projects-list.tpl');
    }

}

