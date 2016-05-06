<?php

/**
 * Created by PhpStorm.
 * User: Gerwin
 * Date: 5-5-2016
 * Time: 16:28
 */
class db_connect
{
    function __construct() {
        $this->connect();
    }

    function __destruct() {
        $this->close();
    }

    function connect() {
        // import database connection variable
        require_once __DIR__ . '/db_config.php';

        // Connecting to mysql database
        $con = mysqli_connect(DB_SERVER, DB_USER, DB_PASSWORD) or die (mysqil_error());

        // Selecting the database
        $db = mysqli_select_db(DB_DATABASE) or die(mysqli_error()) or die (mysqli_error());

        // returning connection cursor
        return $con;
    }

    function close() {
        mysqli_close();
    }
}