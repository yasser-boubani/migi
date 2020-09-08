<?php

use Workers\SDealer;

/*
Routing Wall:
    "target->chain" => "condition->chain"
    "view->page" => "method->key->value",
                    // method->key === method->key->null
    "controller->controllerName->action" => "method->key->value",
    // "controller->controllerName" === all actions in this controller
    
*/
// assoc
$wall_rules = array(
    // "target->chain" => "condition->chain"
);

// indexed
$excluded_wall_rules = array(
    // "view->home"
);

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
