<?php

/*
**
** If you want to change the display language, you just need to change the cookie "lang" to your wanted language (ar for instance).
**
*/

if (!isset($_COOKIE["lang"])) {
    setcookie("lang", DEF_LANG, time() + (86400 * 30), "/"); // 86400 = 1 day
    $selected_language = DEF_LANG;
} else {
    $selected_language = $_COOKIE["lang"];
}

if (!file_exists(_LANGUAGES_ . $selected_language . ".php")) {
    exit("$selected_language Language file doesn't exist!");
} else {
    include_once _LANGUAGES_ . $selected_language . ".php";
}

function trans($input) {
    global $lang; // included from the language file

    if (isset($lang[$input])) {
        return $lang[$input];
    } else {
        trigger_error("The word [$input] doesn't exist in the Language dictionary!");
    }
}
