<?php

/**
 * Created by PhpStorm.
 * User: Admin
 * Date: 5/7/2016
 * Time: 7:01 PM
 */
class db_connect
{
    function __construct()
    {
        $link = $this->connect();
        return $link;
    }

    function __destruct()
    {
        $this->close();
    }

    function connect() {
        require_once __DIR__ . '/db_config.php';

        $link = mysqli_connect(DB_SERVER, DB_USER, DB_PASSWORD, DB_DATABASE);

        if ($link->connect_error) {
            die('Connect Error (' . $link->connect_errno . ')' . $link->connect_error);
        }

        return $link;
    }

    function close($link) {
        mysqli_close($link);
    }
}