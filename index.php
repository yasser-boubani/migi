<?php

if (!defined("DS")) {
    define("DS", DIRECTORY_SEPARATOR);
}

include_once "config" . DS . "config.php";

// Workers\Router::fix_mode(); // Turn the fix mode on
// Workers\Router::select_view("home"); // Select a fixed view directly
Workers\Router::start(); // Start Routing
