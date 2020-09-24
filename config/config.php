<?php

require_once "init.php";

date_default_timezone_set(TIMEZONE); // SET TIMEZONE

require_once _WORKERS_ . "AutoLoader.php";

require_once _NEEDS_ . "routing.control.php";

if (ML) {
    require_once _NEEDS_ . "language.control.php";
}

if (FIX_MODE) {
    eview("fix_mode");
}

if (USING_DB) {
    require_once "db_con.php";
}

if (USE_MAILER) {
    require_once _NEEDS_ . "mail.control.php";
}
