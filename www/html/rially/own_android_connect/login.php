<?php
/**
 * Created by PhpStorm.
 * User: Gerwin
 * Date: 22-5-2016
 * Time: 18:09
 */

require_once __DIR__ . '/db_config.php';

$response = array();

if (isset($_POST['username']) && isset($_POST['hpassword'])) {

    $username = $_POST['username'];
    $hpassword = $_POST['password'];

    $db = mysqli_connect(DB_SERVER, DB_USER, DB_PASSWORD, DB_DATABASE);

    if ($db->connect_error) {
        die('Connect Error (' . $db->connect_errno . ')' . $db->connect_error);
    }

    $result = mysqli_query($db, "SELECT * FROM users WHERE username='$username' AND password='$hpassword'");
    while ($row = mysqli_fetch_array($result)) {
        $success = true;
    }
    if ($success) {
        $response["username"] = $username;
        $response["message"] = "Successfully logged in";
        $response["success"] = 1;
    } else {
        $response["username"] = $username;
        $response["message"] = "Your username/password combination was not recognized";
        $response["success"] = 0;
    }

    $db->close();

    echo json_encode($response);
}