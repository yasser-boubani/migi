<?php

if (!defined("DS")) {
    define("DS", DIRECTORY_SEPARATOR);
}

include_once "config" . DS . "config.php";

// Workers\Router::fix_mode();
// Workers\Router::select_view("home"); // Start Routing
Workers\Router::start(); // Start Routing