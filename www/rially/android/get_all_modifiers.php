<?php
/**
 * Created by PhpStorm.
 * User: Admin
 * Date: 11/7/2016
 * Time: 3:35 PM
 */

require_once __DIR__ . '/db_config.php';

$response = array();

$db = mysqli_connect(DB_SERVER, DB_USER, DB_PASSWORD, DB_DATABASE);

if ($db->connect_error) {
    die('Connect Error (' . $db->connect_erno . ')' . $db->connect_error);
}

$result = mysqli_query($db, "SELECT * FROM modifiers");

if (mysqli_num_rows($result) > 0) {

    $response["modifiers"] = array();

    while ($row = mysqli_fetch_array($result)) {
        $modifier = array();
        $modifier["id"] = $row["id"];
        $modifier["modifier"] = $row["modifier"];
        array_push($response["modifiers"], $modifier);
    }

    $response["success"] = 1;

    $db->close();

    echo json_encode($response);
} else {
    $response["success"] = 0;
    $response["message"] = "No modifiers found";

    echo json_encode($response);
}