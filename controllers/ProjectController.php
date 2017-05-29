<?php

namespace Ecdb\Controllers;

class ProjectController extends BaseController {

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

        $_SESSION['messages'] = array(
            'Project added!',
        );
        return $response->withRedirect('proj_list');
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

