<?php

namespace Workers;

class Router
{
    public static function start() {
        global $routes;

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

                    view($target_arr[1]);

                } else if ($target_arr[0] == "controller") {

                    controller($target_arr[1]);

                } else if ($target_arr[0] == "eview") {

                    eview($target_arr[1]);

                } else {

                    exit("Invalid target delimiter ({$target_arr[0]}) in the ($target) route");

                }
                break;
            }
        }
    }

    public static function select_view(String $view_name, Array $view_data = []) {
        view($view_name, $view_data);
    }

    public static function fix_mode() {
        eview("fix_mode");
    }
}