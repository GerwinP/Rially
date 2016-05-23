<?php
/**
 * Created by PhpStorm.
 * User: Gerwin
 * Date: 23-5-2016
 * Time: 12:39
 */

require_once __DIR__ . '/db_config.php';

$response = array();

if (isset($_POST['username']) && isset($_POST['hpassword'])) {
    
    $username = $_POST['username'];
    $hpassword = $_POST['hpassword'];
    
    $db = mysqli_connect(DB_SERVER, DB_USER, DB_PASSWORD, DB_DATABASE);
    
    if ($db->connect_error) {
        die ('Connect error (' . $db->connect_errno . ')' . $db->connect_error);
    }
    
    $result = mysqli_query($db, "INSERT INTO users(username, password) VALUES('$username', '$hpassword')");

    if ($result) {
        $response["success"] = 1;
        $response["message"] = "User successfully created";

        echo json_encode($response);
    } else {
        $response["success"] = 0;
        $response["message"] = "Failed to create new user";

        echo json_encode($response);
    }
} else {
    $response["success"] = 0;
    $response["message"] = "Required field(s) missing";

    echo json_encode($response);
}