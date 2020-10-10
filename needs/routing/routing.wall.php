<?php

use Workers\SDealer;
/*
**
** CSRF Protection feature
**
*/
define("CSRF_TOKEN", sha1(SDealer::get("SID")), TRUE);
define("CSRF_INPUT", '<input type="hidden" name="_token" value="' . CSRF_TOKEN . '">', TRUE);

// excluded routes from csrf protection (Routes here must be same as the Routes in the routes.map)
$excluded_csrf_routes = array(
    // "route1",
    // "route2",
);

/*
**
** Routing Wall feature
** target->chain ==> (view->name) or (controller->controllerName) or (controller->controllerName->method)
**
*/
// associative array
$wall_rules = array(
    // "target->chain" => "function"
);

// indexed array
$excluded_wall_rules = array(
    // "target->chain",
);
