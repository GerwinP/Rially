<?php
/**
 * Created by PhpStorm.
 * User: Gerwin
 * Date: 12-5-2016
 * Time: 15:57
 */

require_once __DIR__ . '/db_config.php';

$response = array();

//check for required fields
if (isset($_POST['opdracht'])) {

    $opdracht = $_POST['opdracht'];

    //make connection with the database
    $db = mysqli_connect(DB_SERVER, DB_USER, DB_PASSWORD, DB_DATABASE);

    if ($db->connect_error) {
        die('Connect Error ('. $db->connect_errno . ')' . $db->connect_error);
    }

    //try to insert row in database
    $result = mysqli_query($db, "INSERT INTO opdrachten(opdracht) VALUES('$opdracht')");

    //check if row is inserted
    if ($result) {
        //successfully inserted into database
        $response["succes"] = 1;
        $response["message"] = "Opdracht successfully created";

        //echoing JSON response
        echo json_encode($response);
    } else {
        //failed to insert row
        $response["succes"] = 0;
        $response["message"] = "Oops! An error occurred!";

        echo json_encode($response);
    }
} else {
    //required field was missing
    $response["succes"] = 0;
    $response["message"] = "Required field is missing";

    echo json_encode($response);
}


