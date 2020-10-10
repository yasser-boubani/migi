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
