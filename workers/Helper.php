<?php

namespace Workers;

class Helper
{
    public static function pp($value, Bool $exit = true) {
        echo "<pre>";
        print_r($value);
        echo "</pre>";
        if ($exit) {
            exit;
        }
    }

    public static function inc_comp($comp_name, Array $data = []) {
        $comp_path = _COMPONENTS_ . "_$comp_name.php";
        if (file_exists($comp_path)) {
            include $comp_path;
        } else {
            exit("COMPONENT $comp_name doesn't exist!");
        }
    }

    public static function redirect($url, $s = 0) {
        header("refresh:$s; url=$url");
        exit;
    }

    public static function calc_duration($date) {
        $now = date("Y-m-d h:i:sa");
        $now = strtotime($now);
        $date = strtotime($date);
        $duration = abs($now-$date);
        
        if ($duration < 59) {
            $duration = floor($duration) . " seconds";
        } else if ($duration >= 60 && $duration < 3600) { // greater than or equal 1 min and less than 1 hour
        
            $duration = floor($duration / 60);
        
            if ($duration >= 1 && $duration <= 1) {
                $duration = "1 minute";
            } else {
                $duration .= " minutes";
            }
            
        } else if ($duration >= 3600 && $duration < 86400) { // greater than or equal 1 hour and less than 1 day
        
            $duration = floor($duration / 60 / 60);
            
            if ($duration >= 0 && $duration <= 1) {
                $duration = "1 hour";
            } else {
                $duration .= " hours";
            }
        
        } else if ($duration >= 86400 && $duration < 604800) { // greater than or equal 1 day and less than 1 week
            
            $duration = floor($duration / 60 / 60 / 24);
            
            if ($duration >= 0 && $duration <= 1) {
                $duration = "1 day";
            } else {
                $duration .= " days";
            }
        
        } else if ($duration >= 604800 && $duration < 2419200) { // greater than or equal 1 week and less than 1 month
                    
            $duration = floor($duration / 60 / 60 / 24 / 7);
            
            if ($duration >= 0 && $duration <= 1) {
                $duration = "1 week";
            } else {
                $duration .= " weeks";
            }
        
        } else if ($duration >= 2419200 && $duration < 31104000) { // greater than or equal 1 month and less than 1 year
                            
            $duration = floor($duration / 60 / 60 / 24 / 30);
            
            if ($duration >= 0 && $duration <= 1) {
                $duration = "1 month";
            } else {
                $duration .= " months";
            }
        
        } else if ($duration >= 31104000 && $duration < 311040000) { // greater than or equal 1 year and less than 1 decade
                            
            $duration = floor($duration / 60 / 60 / 24 / 30 / 12);
            
            if ($duration >= 0 && $duration <= 1) {
                $duration = "1 year";
            } else {
                $duration .= " years";
            }
        
        } else {
            $duration = floor($duration / 60 / 60 / 24 / 30 / 12);
            $duration .= " years";
        }

        return $duration;
    }

    public static function d_num($num) { // describe_num
        $num = "$num";

        if ($num < 1000) {
            return $num;
        } elseif ($num >= 1000 && $num < 10000) {
            $p1 = substr($num, 0, 1);
            $p2 = substr($num, 1, 1);
            if ($p2 == "0") {
                return $p1 . "k";
            } else {
                return "$p1.$p2" . "k";
            }
        } elseif ($num >= 10000 && $num < 100000) {
            return substr($num, 0, 2) . "k";
        } elseif ($num >= 100000 && $num < 1000000) {
            return substr($num, 0, 3) . "k";
        } elseif ($num >= 1000000 && $num < 10000000) {
            $p1 = substr($num, 0, 1);
            $p2 = substr($num, 1, 1);
            if ($p2 == "0") {
                return $p1 . "M";
            } else {
                return "$p1.$p2" . "M";
            }
        } elseif ($num >= 10000000 && $num < 100000000) {
            return substr($num, 0, 2) . "M";
        } elseif ($num >= 100000000 && $num < 1000000000) {
            return substr($num, 0, 3) . "M";
        } else {
            return $num;
        }
    }

    public static function time_now() { // CURRENT_TIMESTAMP
        return Date("Y-m-d H:i:s", time());
    }

    /*
    **
    ** V 1.0.0
    ** arguments:
    ** $string (Haystack)
    ** $needle (needle)
    **
    */
    public static function str_contains(String $string, String $needle) : Bool {

        if (strpos($string, $needle) === false) {
            return false;
        } else {
            return true;
        }

    }

    /* 
    ** 
    */
    public static function str_starts_with(String $string, String $needle) : Bool {
        if (strpos($string, $needle) === 0) {
            return true;
        } else {
            return false;
        }
    }

    /* 
    ** 
    */
    public static function str_ends_with(String $string, String $needle) : Bool {
        if (strrpos($string, $needle) === strlen($string)-1) {
            return true;
        } else {
            return false;
        }
    }

    /*
    **
    */
    public static function how_many_chars(String $string, String $needle) : Int {

        if (strlen($needle) > 1) {
            exit("The \$needle argument in how_many_chars function must be 1 character only!");
        }

        $chars_arr = str_split($string);
        $number = 0;

        foreach ($chars_arr as $char) {
            if ($char == $needle) {
                $number++;
            }
        }

        return $number;
    }

    /*
    ** Convert number of seconds to Days:Hours:Minutes:Seconds Format
    */
    public static function DHMS_format($seconds) {
        $dt1 = new \DateTime();
        $dt2 = new \DateTime($seconds);
        if ($dt1 > $dt2) {
            return "--:--:--:--";
        } else {
            return $dt1->diff($dt2)->format("%a:%h:%i:%s");
        }
    }
}
