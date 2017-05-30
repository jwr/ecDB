<?php

$app->add(function ($request, $response, $next) {
    // set base url variable in view
    $base_url = $request->getUri()->getBaseUrl();
    $this->view->assign('base_url', $base_url);

    if (!empty($_SESSION['ERRMSG_ARR'])) {
        $this->view->assign('errors', $_SESSION['ERRMSG_ARR']);
        unset($_SESSION['ERRMSG_ARR']);
    }
    if (!empty($_SESSION['messages'])) {
        $this->view->assign('messages', $_SESSION['messages']);
        unset($_SESSION['messages']);
    }
    if (!empty($_SESSION['info'])) {
        $this->view->assign('info', $_SESSION['info']);
        unset($_SESSION['info']);
    }

    return $next($request, $response);
});
