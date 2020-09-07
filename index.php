<?php

// Main Constants
if (!defined("DS")) {
    define("DS", DIRECTORY_SEPARATOR);
}
if (!defined("_ROOT_")) {
    define("_ROOT_", __DIR__ . DS);
}

require_once "config" . DS . "config.php";

// Workers\Router::fix_mode(); // Turn the fix mode on
// Workers\Router::select_view("home"); // Select a fixed view directly
Workers\Router::start(); // Start Routing
