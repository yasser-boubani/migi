<?php

namespace App\Controllers;

class Controller
{
    protected $_view = null;

    public function default() {
        view($this->_view);
    }
}
