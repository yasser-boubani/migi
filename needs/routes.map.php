<?php

/*
$routes = array(
    "route" => "view->target/path/name",
    "route" => "eview->target/path/name",
    "route" => "controller->targetClass",
)
*/

$routes = array(
    // Default routes
    "/"     => "view->home",
    "/home" => "view->home",

    // test routes
    "/test" => "controller->Test",
    "/test/{number}" => "controller->Test@show_num(number)",
);