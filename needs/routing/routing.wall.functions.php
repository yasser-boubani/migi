<?php

use Workers\Helper;
use Workers\SDealer;
use Workers\CDealer;

/**
 * 
 * Routing Wall Functions
 * 
 */
function back() {
    if (isset($_SERVER["HTTP_REFERER"])) {
        Helper::redirect($_SERVER["HTTP_REFERER"]);
    } else {
        Helper::redirect("/");
    }
}
