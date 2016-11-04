<?php
/**
 * Created by PhpStorm.
 * User: Gerwin
 * Date: 4-11-2016
 * Time: 15:59
 */

require_once __DIR__ . '/db_config.php';

$db = mysqli_connect(DB_SERVER, DB_USER, DB_PASSWORD, DB_DATABASE);

if ($db->connect_error) {
    die('Connect Error(' . $db->connect_errno . ')' . $db->connect_error);
}

if ($_SERVER['REQUEST_METHOD'] == "POST" && isset($_POST['opdrachten'])) {
    
    $opdrachten = $_POST['opdrachten'];
    $response = [];

    $response["success"] = 1;

    echo json_encode($response);


}