<?php

namespace App\Controllers;

class Controller
{
    public $view_name;

    public function __constructor($vn) {
        $this->view_name = $vn;
    }
}