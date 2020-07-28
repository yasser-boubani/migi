<?php

namespace Workers;

class AutoLoader
{
    public static function load($class_name) {
        $class_path = $class_name . ".php";
        // echo $class_path;
        // exit;
        if (file_exists($class_path)) {
            include_once $class_path;
        }
    }
}

spl_autoload_register("Workers\AutoLoader::load");