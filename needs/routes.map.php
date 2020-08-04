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
    "/test/{number_id}" => "controller->Test@show_num(number_id)",
    "/test/all" => "controller->Test@show_all",
    "/test/update/{number_id}/{new_value}" => "controller->Test@update_num(number_id, new_value)",
    "/test/add/{value}/{note}" => "controller->Test@add_num(value, note)",
    "/test/delete/{number_id}" => "controller->Test@del_num(number_id)",
);