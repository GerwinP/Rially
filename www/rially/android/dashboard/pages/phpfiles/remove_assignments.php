<?php
/**
 * Created by PhpStorm.
 * User: Admin
 * Date: 10/29/2016
 * Time: 8:34 PM
 */

require_once __DIR__ . '/../../../db_config.php';


if ($_SERVER['REQUEST_METHOD'] == "POST" && isset($_POST['json'])) {

    json_decode($_POST['json']);
    

    echo $_POST;
}
