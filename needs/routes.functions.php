<?php
use Workers\Helper;

/*
**
** Returns a view (views directory)
**
*/
function view(String $view_name, Array $view_data = []) {

    // extract($view_data);
    
    if (!Helper::str_contains($view_name, ".php")) {
        $view_name = $view_name . ".php";
    }

    if (!file_exists(_VIEWS_ . $view_name)) {
        exit("<b>Error:</b> VIEW '$view_name' does not exist!");
    }

    include_once _VIEWS_ . $view_name;
    exit;
}

/*
**
** Returns an error_view (epages directory)
**
*/
function eview(String $eview_name, Array $view_data = []) {

    // extract($view_data);
    
    if (!Helper::str_contains($eview_name, ".php")) {
        $eview_name = $eview_name . ".php";
    }

    if (!file_exists(_EPAGES_ . $eview_name)) {
        exit("<b>Error:</b> EVIEW '$eview_name' does not exist!");
    }

    include_once _EPAGES_ . $eview_name;
    exit;
}

/**
 * 
 */
function controller(String $view_name, Array $view_data = []) {
    echo $view_name;
    exit;
}