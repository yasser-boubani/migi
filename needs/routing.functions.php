<?php

use Workers\Helper;
use Workers\SDealer;
use Workers\CDealer;

/*
**
** Routing Wall functions
**
*/
function chain_method_session($key, $value = null, $action = "forbidden") {
    if (!SDealer::check($key)) {
        if ($action == "back") {
            if (isset($_SERVER["HTTP_REFERER"])) {
                Helper::redirect($_SERVER["HTTP_REFERER"]);
            } else {
                Helper::redirect("/");
            }
        } else if (Helper::str_starts_with($action, "/")) {
            Helper::redirect($action);
        } else {
            eview($action);
        }
    }

    if ($value !== null) {
        if (SDealer::get($key) !== $value) {
            if ($action == "back") {
                if (isset($_SERVER["HTTP_REFERER"])) {
                    Helper::redirect($_SERVER["HTTP_REFERER"]);
                } else {
                    Helper::redirect("/");
                }
            } else if (Helper::str_starts_with($action, "/")) {
                Helper::redirect($action);
            } else {
                eview($action);
            }
        }
    }
}
function chain_method_cookie($key, $value = null, $action = "forbidden") {
    if (!CDealer::check($key)) {
        if ($action == "back") {
            if (isset($_SERVER["HTTP_REFERER"])) {
                Helper::redirect($_SERVER["HTTP_REFERER"]);
            } else {
                Helper::redirect("/");
            }
        } else if (Helper::str_starts_with($action, "/")) {
            Helper::redirect($action);
        } else {
            eview($action);
        }
    }

    if ($value !== null) {
        if (CDealer::get($key) !== $value) {
            if ($action == "back") {
                if (isset($_SERVER["HTTP_REFERER"])) {
                    Helper::redirect($_SERVER["HTTP_REFERER"]);
                } else {
                    Helper::redirect("/");
                }
            } else if (Helper::str_starts_with($action, "/")) {
                Helper::redirect($action);
            } else {
                eview($action);
            }
        }
    }
}
function chain_method_get($key, $value = null, $action = "forbidden") {
    if (!isset($_GET[$key])) {
        if ($action == "back") {
            if (isset($_SERVER["HTTP_REFERER"])) {
                Helper::redirect($_SERVER["HTTP_REFERER"]);
            } else {
                Helper::redirect("/");
            }
        } else if (Helper::str_starts_with($action, "/")) {
            Helper::redirect($action);
        } else {
            eview($action);
        }
    }

    if ($value !== null) {
        if ($_GET[$key] !== $value) {
            if ($action == "back") {
                if (isset($_SERVER["HTTP_REFERER"])) {
                    Helper::redirect($_SERVER["HTTP_REFERER"]);
                } else {
                    Helper::redirect("/");
                }
            } else if (Helper::str_starts_with($action, "/")) {
                Helper::redirect($action);
            } else {
                eview($action);
            }
        }
    }
}
function chain_method_post($key, $value = null, $action = "forbidden") {
    if (!isset($_POST[$key])) {
        if ($action == "back") {
            if (isset($_SERVER["HTTP_REFERER"])) {
                Helper::redirect($_SERVER["HTTP_REFERER"]);
            } else {
                Helper::redirect("/");
            }
        } else if (Helper::str_starts_with($action, "/")) {
            Helper::redirect($action);
        } else {
            eview($action);
        }
    }

    if ($value !== null) {
        if ($_POST[$key] !== $value) {
            if ($action == "back") {
                if (isset($_SERVER["HTTP_REFERER"])) {
                    Helper::redirect($_SERVER["HTTP_REFERER"]);
                } else {
                    Helper::redirect("/");
                }
            } else if (Helper::str_starts_with($action, "/")) {
                Helper::redirect($action);
            } else {
                eview($action);
            }
        }
    }
}

/*
**
** Returns a view (views directory)
**
*/
function view(String $view_name, Array $view_data = []) {

    // routing wall check
    global $wall_rules;
    global $excluded_wall_rules;

    if (!in_array("view->$view_name", $excluded_wall_rules)) { // if this view is not excluded from the wall rules
        if (isset($wall_rules["view->$view_name"])) { // if this view exists in the wall rules

            if (is_array($wall_rules["view->$view_name"])) {
                $condition_chain = $wall_rules["view->$view_name"][0];
                $condition_chain_arr = explode("->", $condition_chain);
                $action_if_false = $wall_rules["view->$view_name"][1];
            } else {
                $condition_chain = $wall_rules["view->$view_name"];
                $condition_chain_arr = explode("->", $condition_chain);
                $action_if_false = "forbidden";
            }

            if (count($condition_chain_arr) == 2) {
                $chain_method = $condition_chain_arr[0];
                $chain_key = $condition_chain_arr[1];
                $chain_value = null;
            } else if (count($condition_chain_arr) == 3) {
                $chain_method = $condition_chain_arr[0];
                $chain_key = $condition_chain_arr[1];
                $chain_value = $condition_chain_arr[2];
            } else {
                exit("Invalid chain condition '$condition_chain' in the wall_rules array!");
            }

            if ($chain_method == "session" || $chain_method == "cookie" ||
                $chain_method == "get" || $chain_method == "post")
            {
                // (function_name)(key, value, action)
                ("chain_method_".$chain_method)($chain_key, $chain_value, $action_if_false);
            } else {
                exit("Invalid chain method '$chain_method' in '$condition_chain'!");
            }
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

    if (Helper::str_contains($controller_name, "@")) {
        $temp_controller_name = str_replace("@", "->", $controller_name);
    } else {
        $temp_controller_name = $controller_name . "->default";
    }

    $temp_controller_name_without_action = explode("->", $temp_controller_name);
    $temp_controller_name_without_action = $temp_controller_name_without_action[0];

    if (Helper::str_contains($temp_controller_name, "(") && Helper::str_ends_with($temp_controller_name, ")")) {
        $temp_controller_name = substr($temp_controller_name, 0, strpos($temp_controller_name, "("));
    }

    // Helper::pp($temp_controller_name);

    if (!in_array("controller->$temp_controller_name", $excluded_wall_rules)
        && !in_array("controller->$temp_controller_name_without_action", $excluded_wall_rules)
    ) { // if this controller is not excluded from the wall rules
        if (isset($wall_rules["controller->$temp_controller_name"])) { // if this controller exists in the wall rules

            if (is_array($wall_rules["controller->$temp_controller_name"])) {
                $condition_chain = $wall_rules["controller->$temp_controller_name"][0];
                $condition_chain_arr = explode("->", $condition_chain);
                $action_if_false = $wall_rules["controller->$temp_controller_name"][1];
            } else {
                $condition_chain = $wall_rules["controller->$temp_controller_name"];
                $condition_chain_arr = explode("->", $condition_chain);
                $action_if_false = "forbidden";
            }

            if (count($condition_chain_arr) == 2) {
                $chain_method = $condition_chain_arr[0];
                $chain_key = $condition_chain_arr[1];
                $chain_value = null;
            } else if (count($condition_chain_arr) == 3) {
                $chain_method = $condition_chain_arr[0];
                $chain_key = $condition_chain_arr[1];
                $chain_value = $condition_chain_arr[2];
            } else {
                exit("Invalid chain condition '$condition_chain' in the wall_rules array!");
            }

            if ($chain_method == "session" || $chain_method == "cookie" ||
                $chain_method == "get" || $chain_method == "post")
            {
                // (function_name)(key, value, action_if_false)
                ("chain_method_".$chain_method)($chain_key, $chain_value, $action_if_false);
            } else {
                exit("Invalid chain method '$chain_method' in '$condition_chain'!");
            }
        } else if (isset($wall_rules["controller->$temp_controller_name_without_action"])) { // if this controller exists in the wall rules
            
            if (is_array($wall_rules["controller->$temp_controller_name_without_action"])) {
                $condition_chain = $wall_rules["controller->$temp_controller_name_without_action"][0];
                $condition_chain_arr = explode("->", $condition_chain);
                $action_if_false = $wall_rules["controller->$temp_controller_name_without_action"][1];
            } else {
                $condition_chain = $wall_rules["controller->$temp_controller_name_without_action"];
                $condition_chain_arr = explode("->", $condition_chain);
                $action_if_false = "forbidden";
            }

            if (count($condition_chain_arr) == 2) {
                $chain_method = $condition_chain_arr[0];
                $chain_key = $condition_chain_arr[1];
                $chain_value = null;
            } else if (count($condition_chain_arr) == 3) {
                $chain_method = $condition_chain_arr[0];
                $chain_key = $condition_chain_arr[1];
                $chain_value = $condition_chain_arr[2];
            } else {
                exit("Invalid chain condition '$condition_chain' in the wall_rules array!");
            }

            if ($chain_method == "session" || $chain_method == "cookie" ||
                $chain_method == "get" || $chain_method == "post")
            {
                // (function_name)(key, value, action_if_false)
                ("chain_method_".$chain_method)($chain_key, $chain_value, $action_if_false);
            } else {
                exit("Invalid chain method '$chain_method' in '$condition_chain'!");
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
