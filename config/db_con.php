<?php

try {

    $con = new PDO(
        "mysql:host=" . DB_HOST . ";dbname=" . DB_NAME,
        DB_USERNAME, DB_PASS,
        [PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8"]
    );

    // set the PDO error mode to exception
    $con->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

} catch(PDOException $e) {

    eview(
        "db_error",
        ["error" => $e]
    );

}
