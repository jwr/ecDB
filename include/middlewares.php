<?php

$app->add(function ($request, $response, $next) {
    // set base url variable in view
    $base_url = $request->getUri()->getBaseUrl();
    $this->view->assign('base_url', $base_url);

    $types = array(
        'ERRMSG_ARR' => 'errors',
        'messages' => 'messages',
        'info' => 'info',
    );

    $data = array();
    foreach ($types as $session_var=>$smarty_var) {
        if (!empty($_SESSION[$session_var])) {
            $this->view->assign($smarty_var, $_SESSION[$session_var]);
            $data[$session_var] = $_SESSION[$session_var];
            unset($_SESSION[$session_var]);
        }
    }

    $response = $next($request, $response);

    // not normal page, put all flash messages back to session
    if (!$response->isOk()) {
        foreach ($types as $session_var=>$smarty_var) {
            if (!empty($data[$session_var])) {
                $new_data = !empty($_SESSION[$session_var]) ? $_SESSION[$session_var] : array();
                $smarty_data = empty($this->view->tpl_vars[$smarty_var]->value) ? array() : $this->view->tpl_vars[$smarty_var]->value;
                $_SESSION[$session_var] = array_merge($new_data, $smarty_data, $data[$session_var]);
            }
        }
    }

    return $response;
});
