<?php

Workers\SDealer::start(); // Start the session

require_once _NEEDS_ . "routing" . DS . "routing.wall.php";
require_once _NEEDS_ . "routing" . DS . "routing.functions.php";
require_once _NEEDS_ . "routing" . DS . "routes.map.php"; // The required routes map for the Router
