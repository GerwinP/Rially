<?php
/**
 * Created by PhpStorm.
 * User: Admin
 * Date: 02-Jan-17
 * Time: 21:21
 */

require_once __DIR__ . '/db_config.php';

$response = array();

$db = mysqli_connect(DB_SERVER, DB_USER, DB_PASSWORD, DB_DATABASE);

if ($db->connect_error) {
    die('Connect Error (' . $db->connect_erno . ')' . $db->connect_error);
}

$result = mysqli_query($db, "SELECT username, admin FROM users");

if (mysqli_num_rows($result) > 0) {
    $response["users"] = array();

    while($row = mysqli_fetch_array($result)) {
        $user = array();
        $user["username"] = $row["username"];
        $user["admin"] = $row["admin"];
        array_push($response["users"], $user);
    }

    $response["success"] = 1;
    $response["message"] = "All users added to response";
    $db->close();

    echo json_encode($response);
} else {
    $response["success"] = 0;
    $response["message"] = "No users found";

    echo json_encode($response);
}