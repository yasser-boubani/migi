<?php

namespace Workers;

class SDealer
{
    public static function start() {
        session_start();
        if (!isset($_SESSION["SID"])) {
            $_SESSION["SID"] = Helper::random_token();
        }
    }

    public static function set($s_name, $s_value) {
        if ($s_name != null && $s_name != "") {
            $_SESSION[$s_name] = $s_value;
        } else {
            exit("Invalid session name!");
        }
    }

    public static function get($s_name) {
        if (isset($_SESSION[$s_name])) {
            return $_SESSION[$s_name];
        } else {
            exit("The session '$s_name' doesn't exist!");
        }
    }

    public static function check($s_name) : Bool {
        if (isset($_SESSION[$s_name])) {
            return true;
        } else {
            return false;
        }
    }

    public static function unset($s_name) {
        if (isset($_SESSION[$s_name])) {
            unset($_SESSION[$s_name]);
        } else {
            exit("The session $s_name doesn't exist!");
        }
    }

    public static function destroy() {
        session_unset();
        session_destroy();
    }
}
