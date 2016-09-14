<?php
/**
 * Created by PhpStorm.
 * User: Gerwin
 * Date: 5-5-2016
 * Time: 16:35
 * The following code will create a new opdracht row
 * The opdracht is read from the HTTP Post Request
 */

// array for JSON response
$response = array();

//check for required fields
if (isset($_POST['opdracht'])) {

    $opdracht = $_POST['opdracht'];

    // include db connect class
    require_once __DIR__ . '/db_connect.php';

    // connecting to db
    $db = new db_connect();

    // mysql inserting a new row
    $result = mysqli_query("INSERT INTO opdrachten(opdracht) VALUES('$opdracht')");

    // check if row is inserted or not
    if ($result) {
        // successfully inserted into database
        $response["succes"] = 1;
        $response["message"] = "Opdracht successfully created";

        // echoing JSON response
        echo json_encode($response);
    } else {
        // failed to insert row
        $response["succes"] = 0;
        $response["message"] = "Oops! An error occurred";

        // echoing JSON response
        echo json_encode($response);
    }
} else {
    //required field is missing
    $response["succes"] = 0;
    $response["message"] = "Required field is missing";

    // echoing JSON response
    echo json_encode($respone);
}