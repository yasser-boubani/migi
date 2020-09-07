<?php

use Workers\SDealer;

SDealer::start(); // Start the session

require_once _NEEDS_ . "routes.functions.php";
require_once _NEEDS_ . "routes.map.php"; // The required routes map for the Router

/*
**
** CSRF Protection feature
**
*/
define("CSRF_TOKEN", sha1(SDealer::get("SID")), TRUE);
define("CSRF_INPUT", '<input type="hidden" name="_token" value="' . CSRF_TOKEN . '">', TRUE);

// excluded routes from csrf protection (Routes here must be same as the Routes in the routes.map)
$excluded_csrf_routes = [
    // "/URI1",
    // "/URI2",
];
