<?php

use Workers\SDealer;

/*
** CSRF Protection feature
** Note: Use csrf() function to protect from csrf using Migi's method.
    But, if you want to use your own protection method, you can use those constants only.
*/
define("CSRF_TOKEN", sha1(SDealer::get("SID")), TRUE);
define("CSRF_INPUT", '<input type="hidden" name="_token" value="' . CSRF_TOKEN . '">', TRUE);

// excluded URIs from csrf protection (URIs here must be sale as the URIs in the routes.map)
$excluded_csrf_URIs = [
    // "/URI1",
    // "/URI2",
];