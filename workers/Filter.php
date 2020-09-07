<?php

namespace Workers;

/*
**
** filters
** 
*/
class Filter
{

    /*
    ** return true if the $value matches the RegEx $pattern
    */
    public static function match($value, $pattern) {
        return preg_match($pattern, $value);
    }

    /*
    **
    */
    public static function boolean($value, $check_level = "soft") {
        if ($check_level == "soft") {

            return filter_var($value, FILTER_VALIDATE_BOOLEAN);

        } else if ($check_level == "hard") {
            if (gettype($value) === TRUE)
            {
                return true;
            } else {
                return false;
            }
        } else {
            exit("Invalid check level '$check_level'!");
        }
    }


    /*
    **
    */
    public static function string($value, $check_level = "soft") {
        if ($check_level == "soft") {
            if (gettype($value) == "string" ||
                gettype($value) == "integer" || filter_var($value, FILTER_VALIDATE_INT) ||
                gettype($value) == "double" || filter_var($value, FILTER_VALIDATE_FLOAT))
            {
                return true;
            } else {
                return false;
            }
        } else if ($check_level == "hard") {
            if (gettype($value) == "string")
            {
                return true;
            } else {
                return false;
            }
        } else {
            exit("Invalid check level '$check_level'!");
        }
    }

    /*
    ** $level = "soft" // default
    ** $level = "hard"
    */
    public static function number($value, $check_level = "soft") {
        if ($check_level == "soft") {
            if (filter_var($value, FILTER_VALIDATE_INT) || filter_var($value, FILTER_VALIDATE_FLOAT))
            {
                return true;
            } else {
                return false;
            }
        } else if ($check_level == "hard") {
            if (gettype($value) == "integer" || gettype($value) == "double")
            {
                return true;
            } else {
                return false;
            }
        } else {
            exit("Invalid check level '$check_level'!");
        }
    }

    /*
    **
    */
    public static function integer($value, $check_level = "soft") {
        if ($check_level == "soft") {

            return filter_var($value, FILTER_VALIDATE_INT);

        } else if ($check_level == "hard") {
            if (gettype($value) == "integer")
            {
                return true;
            } else {
                return false;
            }
        } else {
            exit("Invalid check level '$check_level'!");
        }
    }

    /*
    **
    */
    public static function float($value, $check_level = "soft") {
        if ($check_level == "soft") {

            return filter_var($value, FILTER_VALIDATE_FLOAT);

        } else if ($check_level == "hard") {
            if (gettype($value) == "double")
            {
                return true;
            } else {
                return false;
            }
        } else {
            exit("Invalid check level '$check_level'!");
        }
    }

    /*
    **
    */
    public static function names($name) // filter names
    {
        // the name have to "don't" match these patterns
        $p1 = "/[0-9\@\#\€\%\&\+\(\)\*\"\:\;\!\?\,\_\/\.\~\`\|\•\√\π\÷\×\¶\∆\£\¥\$\¢\^\°\=\{\}\\\©\®\™\℅\[\]\<\>]/";
        $p2 = "/^(-|')/";  // starts with - or '
        $p3 = "/[-']{2,}/"; // contains -- ''
        $p4 = "/(-'|'-)/"; // contains -' '-
        $p5 = "/(.[-'].+){3,}/"; // there are lots of - '

        if (preg_match($p1, $name) ||
            preg_match($p2, $name) ||
            preg_match($p3, $name) ||
            preg_match($p4, $name) ||
            preg_match($p5, $name)) {
            return false;
        } else {
            return self::string($name);
        }
    }

    /*
    **
    */
    public static function username($username) // filter username
    {
        // false if match
        $p1 = "/[\@\#\€\%\&\+\(\)\*\"\'\:\;\!\?\,\/\~\`\|\•\√\π\÷\×\¶\∆\£\¥\$\¢\^\°\=\{\}\\\©\®\™\℅\[\]\<\> ]/";
        // true if match
        $pattern = "/[a-zA-Z0-9.-_]/";

        if (preg_match($p1, $username)) {
            return false;
        } else {
            if (preg_match($pattern, $username)) {
                return self::string($username);
            } else {
                return false;
            }
        }
    }

    /*
    **
    */
    public static function email($email) // filter email
    {
        // false if match
        $p1 = "/[\#\€\%\&\+\(\)\*\"\'\:\;\!\?\,\/\~\`\|\•\√\π\÷\×\¶\∆\£\¥\$\¢\^\°\=\{\}\\\©\®\™\℅\[\]\<\> ]/";
        // the email must match this pattern
        $emailPattern = "/^[a-z0-9-_.]+@[a-z0-9]+\.[a-z.]{2,5}$/";

        if (preg_match($p1, $email)) {
            return false;
        } else {
            if (preg_match($emailPattern, $email)) {
                return filter_var($email, FILTER_VALIDATE_EMAIL);
            } else {
                return false;
            }
        }
    }

    /*
    **
    */
    public static function domain($domain) {
        return filter_var($domain, FILTER_VALIDATE_DOMAIN);
    }

    /*
    **
    */
    public static function ip($ip) {
        return filter_var($ip, FILTER_VALIDATE_IP);
    }

    /*
    **
    */
    public static function mac($mac) {
        return filter_var($mac, FILTER_VALIDATE_MAC);
    }

    /*
    **
    */
    public static function url($url) {
        return filter_var($url, FILTER_VALIDATE_URL);
    }
}
