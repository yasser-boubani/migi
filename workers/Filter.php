<?php

namespace Workers;

/*
**
** filters:
** 1- names ==> filter name [Name must be only normal characters without numbers or special chars]
** 2- username ==> filter username [it must be only chars + number and its max length is 30 char]
** 3- email ==> filter email
** 
*/
class Filter
{
    public static function names($name) // filter names
    {
        // the name have to "don't" match these patterns
        $p1 = "/[0-9\@\#\€\%\&\+\(\)\*\"\:\;\!\?\,\_\/\.\~\`\|\•\√\π\÷\×\¶\∆\£\¥\$\¢\^\°\=\{\}\\\©\®\™\℅\[\]\<\>]/";
        $p2 = "/^(-|')/";  // ism yabd bi - wala '
        $p3 = "/[-']{2,}/"; // lakan kayn -- ''
        $p4 = "/(-'|'-)/"; // lkn kayn -' '-
        $p5 = "/(.[-'].+){3,}/"; // lkn kayn bzf - '

        if (preg_match($p1, $name) ||
            preg_match($p2, $name) ||
            preg_match($p3, $name) ||
            preg_match($p4, $name) ||
            preg_match($p5, $name)) {
            return false;
        } else {
            return true;
        }
    }

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
                return true;
            } else {
                return false;
            }
        }
    }

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
                if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
                    return true;
                }
            } else {
                return false;
            }
        }
    }
}