<?php
/**
 * Created by PhpStorm.
 * User: Admin
 * Date: 5/7/2016
 * Time: 7:05 PM
 */

require_once __DIR__ . '/db_config.php';

$response = array();

$db = mysqli_connect(DB_SERVER, DB_USER, DB_PASSWORD, DB_DATABASE);

if ($db->connect_error) {
    die('Connect Error (' . $db->connect_errno . ')' . $db->connect_error);
}

$result = mysqli_query($db, "SELECT * FROM opdrachten");

// check for empty result
if (mysqli_num_rows($result) > 0) {
    // looping through all results
    // opdrachten node
    $response["opdrachten"] = array();

    while ($row = mysqli_fetch_array($result)) {
        //temp user array
        $opdracht = array();
        $opdracht["id"] = $row["id"];
        $opdracht["opdracht"] = $row["opdracht"];
        array_push($response["opdrachten"], $opdracht);
    }
    // success
    $response["succes"] = 1;

    //close database
    $db->close();

    //echoing JSON response
    echo json_encode($response);
} else {
    //no opdrachten found
    $response["success"] = 0;
    $response["message"] = "No opdrachten found";

    // echo no users JSON
    echo json_encode($response);
}