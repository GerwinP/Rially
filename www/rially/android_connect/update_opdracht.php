<?php
/**
 * Created by PhpStorm.
 * User: Gerwin
 * Date: 5-5-2016
 * Time: 17:11
 * Following code will update an opdracht information
 * A opdracht is identified by its id
 */

// Array for JSON response
$response = array();

// check for required fields
if (isset($_POST['id']) && isset($_POST['opdracht'])) {
    
    $id = $_POST['id'];
    $opdracht = $_POST['opdracht'];
    
    //include db connect class
    require_once __DIR__ . '/db_connect.php';
    
    // connecting to DB
    $db = new db_connect();


    // mysql update row with matched id
    $result = mysqli_query("UPDATE opdrachten SET opdracht = '$opdracht' WHERE id = '$id'");

    //check if row is inserted or not
    if ($result) {
        //successfully updated
        $response["success"] = 1;
        $response["message"] = "Product is succcessfully updated";

        // echoing JSON response
        echo json_encode($response);
    } else {

    }
} else {
    // required field is missing
    $response["success"] = 0;
    $response["message"] = "Required fields missing";

    //echoing JSON response
    echo json_encode($response);
}