<?php

include_once "init.php";

date_default_timezone_set(TIMEZONE); // SET TIMEZONE

include_once _WORKERS_ . "AutoLoader.php";

include_once _NEEDS_ . "routes.functions.php";
include_once _NEEDS_ . "routes.map.php"; // The required routes map for the Router

if (FIX_MODE) {
    eview("fix_mode");
}

if (USING_DB) {
    include_once "db_con.php";
}