<?php

namespace Workers;

class AutoLoader
{
    public static function load($class_name) {
        $class_path = _ROOT_ . $class_name . ".php";
        $class_path = str_replace("\\", DS, $class_path);
        if (file_exists($class_path)) {
            include_once $class_path;
        }
    }
}

spl_autoload_register("Workers\AutoLoader::load");