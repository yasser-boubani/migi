<?php

namespace Workers;

class Router
{
    public static function start() {
        global $routes;
        global $excluded_csrf_URIs;

        $uri = $_SERVER["REQUEST_URI"];

        // check if the url have GET query values to ignore it eg: www.test.com/page/{value}?key=value we must ignore ?key=value (key = value) to not face any problems
        if (strpos($uri, "?")) {
            $uri = substr($uri, 0, strpos($uri, "?"));
        }

        // remove the last '/' in the uri if it exists
        if (Helper::str_ends_with($uri, "/") && $uri != "/") {
            $uri = rtrim($uri, "/");
        }

        // Helper::pp($uri);

        /*
        ** The $target may be a direct view or a controller
        */

        // First try
        foreach ($routes as $route => $target) {
            if ($uri == $route) {
                $target_arr = explode("->", $target);

                if ($target_arr[0] == "view") {

                    // csrf protection
                    if ($_SERVER["REQUEST_METHOD"] == "POST") {
                        if (in_array($uri, $excluded_csrf_URIs)) { // check if the URI is excluded from the csrf protection or not
                            view($target_arr[1]);
                        } else {
                            if (isset($_POST["_token"]) && $_POST["_token"] == SHA1(SDealer::get("SID"))) {
                                view($target_arr[1]);
                            } else {
                                eview("expired");
                            }
                        }
                    } else {
                        view($target_arr[1]);
                    }

                } else if ($target_arr[0] == "controller") {

                    // csrf protection
                    if ($_SERVER["REQUEST_METHOD"] == "POST") {
                        if (in_array($uri, $excluded_csrf_URIs)) { // check if the URI is excluded from the csrf protection or not
                            controller($target_arr[1]);
                        } else {
                            if (isset($_POST["_token"]) && $_POST["_token"] == SHA1(SDealer::get("SID"))) {
                                controller($target_arr[1]);
                            } else {
                                eview("expired");
                            }
                        }
                    } else {
                        controller($target_arr[1]);
                    }

                } else if ($target_arr[0] == "eview") {

                    eview($target_arr[1]);

                } else {

                    exit("Invalid target delimiter ({$target_arr[0]}) in the ($target) route");

                }
                break;
            }
        }

        // Second try
        $uri_arr = explode("/", $uri);
        $true_routes = [];
        
        // Helper::pp($uri_arr, false);
        // Helper::pp($routes, false);

        foreach ($routes as $route => $target) {
            $passed = false;
            $route_arr = explode("/", $route);

            // 1st filter
            if (count($route_arr) !== count($uri_arr)) {
                continue;
            }

            // 2nd filter
            if ($route_arr[1] !== $uri_arr[1] &&
                    (
                    !Helper::str_starts_with($route_arr[1], "{")
                    &&
                    !Helper::str_ends_with($route_arr[1], "}")
                    )
            ) {
                continue;
            }

            // checking loop
            for ($i = 1; $i < count($route_arr); $i++) {
                
                if ($route_arr[$i] !== $uri_arr[$i]) {
                    if (!Helper::str_starts_with($route_arr[$i], "{")
                        &&
                        !Helper::str_ends_with($route_arr[$i], "}")) {
                        break;
                    }
                }

                if ($i === count($route_arr)-1) {
                    $passed = true;
                }
            }
            
            // add the passed route to $true_routes array
            if ($passed) {
                $true_routes[] = $route;
                $passed = false;
            }
        }

        // Check if there is a routes conflict
        if (count($true_routes) > 1) {
            Helper::pp($true_routes, false);
            exit("There is a Routes Conflict in your routes map!");
        } else if (empty($true_routes)) {
            eview("404");
        }

        // Helper::pp($true_routes, false);

        // Route global variables /{variable}
        // $final_route_arr = explode("/", $true_routes[0]);

        // for ($v = 1; $v < count($final_route_arr); $v++) {
        //     if (strpos($final_route_arr[$v], "{") === 0 && strrpos($final_route_arr[$v], "}")) {
        //         $final_route_arr[$v] = str_replace("{", "", $final_route_arr[$v]);
        //         $final_route_arr[$v] = str_replace("}", "", $final_route_arr[$v]);
        //         global ${$final_route_arr[$v]};
        //         ${$final_route_arr[$v]} = $uri_arr[$v];
        //     }
        // }

        // Route variables /{variable} (uri_params)
        $final_route_arr = explode("/", $true_routes[0]);
        $uri_params = [];

        for ($v = 1; $v < count($final_route_arr); $v++) {
            if (strpos($final_route_arr[$v], "{") === 0 && strrpos($final_route_arr[$v], "}")) {
                $final_route_arr[$v] = str_replace("{", "", $final_route_arr[$v]);
                $final_route_arr[$v] = str_replace("}", "", $final_route_arr[$v]);
                $uri_params[$final_route_arr[$v]] = $uri_arr[$v];
            }
        }

         // ******
        $target_arr = explode("->", $routes[$true_routes[0]]);
        if ($target_arr[0] == "view") {

            // csrf protection
            if ($_SERVER["REQUEST_METHOD"] == "POST") {
                if (in_array($true_routes[0], $excluded_csrf_URIs)) { // check if the URI is excluded from the csrf protection or not
                    view($target_arr[1], $uri_params);
                } else {
                    if (isset($_POST["_token"]) && $_POST["_token"] == SHA1(SDealer::get("SID"))) {
                        view($target_arr[1], $uri_params);
                    } else {
                        eview("expired");
                    }
                }
            } else {
                view($target_arr[1], $uri_params);
            }

        } else if ($target_arr[0] == "controller") {

            // csrf protection
            if ($_SERVER["REQUEST_METHOD"] == "POST") {
                if (in_array($true_routes[0], $excluded_csrf_URIs)) { // check if the URI is excluded from the csrf protection or not
                    controller($target_arr[1], $uri_params);
                } else {
                    if (isset($_POST["_token"]) && $_POST["_token"] == SHA1(SDealer::get("SID"))) {
                        controller($target_arr[1], $uri_params);
                    } else {
                        eview("expired");
                    }
                }
            } else {
                controller($target_arr[1], $uri_params);
            }

        } else if ($target_arr[0] == "eview") {

            eview($target_arr[1], $uri_params);

        } else {

            exit("Invalid target delimiter ({$target_arr[0]}) in the ($target) route");

        } // ******
    }

    public static function select_view(String $view_name, Array $view_data = []) {
        view($view_name, $view_data);
    }

    public static function fix_mode() {
        eview("fix_mode");
    }
}