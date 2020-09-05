<?php

namespace Workers;

class CDealer
{
    public static function
    set($c_name, $c_value, $hours = 1, 
        $path = null, $domain = null, 
        $secure = null, $httponly = null)
    {
        if ($c_name != null && $c_name != "") {
            setcookie($c_name, $c_value, time() + (3600 * $hours), $path, $domain, $secure, $httponly);
        } else {
            exit("Invalid cookie name!");
        }
    }

    public static function get($c_name) {
        if (isset($_COOKIE[$c_name])) {
            return $_COOKIE[$c_name];
        } else {
            exit("The cookie '$c_name' doesn't exist!");
        }
    }

    public static function check($c_name) : Bool {
        if (isset($_COOKIE[$c_name])) {
            return true;
        } else {
            return false;
        }
    }

    public static function unset($c_name) {
        if (isset($_COOKIE[$c_name])) {
            self::set($c_name, "", -1);
        } else {
            exit("The cookie $c_name doesn't exist!");
        }
    }

    public static function destroy() {
        foreach ($_COOKIE as $c_name => $c_value) {
            self::unset($c_name);
        }
    }
}
