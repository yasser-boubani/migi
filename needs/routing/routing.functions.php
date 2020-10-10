<?php

use Workers\Helper;
use Workers\SDealer;
use Workers\CDealer;

/*
**
** Returns a view (views directory)
**
*/
function view(String $view_name, Array $view_data = []) {

    // routing wall check
    global $routes;
    global $wall_rules;
    global $excluded_wall_rules;

    $target = "view->$view_name"; // The target that we will check

    if (in_array($target, $routes)) { // If  true that means this view is called from a route
        if (isset($wall_rules[$target]) && !in_array($target, $excluded_wall_rules)) { // if that view exists in the $wall_rules array and does not exists in the $excluded_wall_rules array .. we will call the function
            require_once "routing.wall.functions.php";
            $wall_rules[$target](); // calling the function from the routing.wall.functions.php
        }
    }

    // selecting view
    $view_name = str_replace("/", DS, $view_name);
    $view_name = str_replace("\\", DS, $view_name);

    extract($view_data);
    
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

    $eview_name = str_replace("/", DS, $eview_name);
    $eview_name = str_replace("\\", DS, $eview_name);

    extract($view_data);
    
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
function controller(String $controller_name, Array $parameters = []) {

    // routing wall check
    global $wall_rules;
    global $excluded_wall_rules;

    $target = "controller->$controller_name"; // The target that we will check

    if (Helper::str_contains($target, "@")) {
        $target = str_replace("@", "->", $target);
        if (Helper::str_contains($target, "(") && Helper::str_contains($target, ")")) {
            $target = substr($target, 0, strpos($target, "("));
        }
    }

    /**
     * $target_arr ==> 0         -> 1            -> 2
     * $target_arr ==> controller->controllerName->methodName
     */
    $target_arr = explode("->", $target);

    if (
        isset($wall_rules["controller->$target_arr[1]"])
        &&
        !in_array("controller->$target_arr[1]", $excluded_wall_rules)
        )
    { // if controller->controllerName exists in the wall rules array and does not exist in the excluded array. so the controller is in the wall and we must deal with all the methods inside that controller
        require_once "routing.wall.functions.php";
        if (isset($target_arr[2])) { // check if we have a method inside the wall
            if ( isset( $wall_rules["controller->$target_arr[1]->$target_arr[2]"] ) ) { // if we have a method inside the wall rules we will call the function for it instead of call the function of controller in the wall rules array or -->
                $wall_rules["controller->$target_arr[1]->$target_arr[2]"]();
            } else { // or ---> we will call the function of controller in the wall rules array
                $wall_rules["controller->$target_arr[1]"]();
            }
        } else { // call tje function of controller in the wall rules array if we dont have a method inside the wall because we have to check all the methods because we have the controller in the rules
            $wall_rules["controller->$target_arr[1]"]();
        }
    } else { // if we dont have a specific controller but we have specified one method of the controller in the rules .. we have to check it and call the function for it
        if (isset($target_arr[2])) {
            if (
                isset($wall_rules["controller->$target_arr[1]->$target_arr[2]"])
                && 
                !in_array("controller->$target_arr[1]->$target_arr[2]", $excluded_wall_rules)
                &&
                !in_array("controller->$target_arr[1]", $excluded_wall_rules)
            )
            {
                require_once "routing.wall.functions.php";
                $wall_rules["controller->$target_arr[1]->$target_arr[2]"]();
            }
        }
    }

    // start working
    $controller_name = str_replace("/", "\\", $controller_name);

    $controller_name_arr = explode("@", $controller_name);

    $controller_class_name = "App\Controllers\\" . $controller_name_arr[0];
    $action = "default";
    if (isset($controller_name_arr[1])) {
        if (Helper::str_contains($controller_name_arr[1], "(")
            && 
            Helper::str_contains($controller_name_arr[1], ")"))
        {
            $action = substr($controller_name_arr[1], 0, strpos($controller_name_arr[1], "(")); // $controller_name_arr[1]
            $target_params_arr = []; // controller->target(p1, p2, p3 ...)
            $action_params_arr = [];

            $target_params_str = substr($controller_name_arr[1], strpos($controller_name_arr[1], "(")+1);
            $target_params_str = rtrim($target_params_str, ")");
            $target_params_str = str_replace(" ", "", $target_params_str);

            $target_params_arr = explode(",", $target_params_str);

            foreach ($target_params_arr as $param) {
                if (isset($parameters[$param])) {
                    $action_params_arr[] = $parameters[$param];
                }
            }

        } else {
            $action = $controller_name_arr[1];
        }
    }

    $controller = new $controller_class_name();
    if (empty($action_params_arr)) {
        $controller->$action();
    } else {
        $controller->$action(...$action_params_arr);
    }

    exit;
}
