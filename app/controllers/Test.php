<?php

namespace App\Controllers;

class Test extends Controller
{
    const _view = "test";

    public function show_num($num) {
        view("test.number", ["num" => $num]);
    }
}