<?php

namespace App\Controllers;

class Controller
{
    const _view = null;

    public function default() {
        view($this::_view);
    }
}