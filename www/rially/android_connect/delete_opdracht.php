<?php
/**
 * Created by PhpStorm.
 * User: Gerwin
 * Date: 5-5-2016
 * Time: 17:29
 * Following code will delete an opdracht from table
 * An opdracht is identified by id
 */

//array for JSON response
$response = array();

// check for required fields
if (isset($_POST['id'])) {
    $id = $_POST['id'];

    // include db connect class
    require_once __DIR__ . '/db_connect.php';

    // connect to db
    $db = new db_connect();

    // mysql update row with matched id
    $result = mysqli_query("DELETE FROM opdrachten WHERE id = $id");

    // check if row is deleted or not
    if (mysqli_affected_rows() > 0) {
        // successfully updated
        $response["succes"] = 1;
        $response["message"] = "Product successfully deleted";

        // echo JSON response
        echo json_encode($response);
    }
} else {
    // required field is missing
    $response["success"] = 0;
    $response["message"] = "Required field is missing";

    // echo JSON response
    echo json_encode($response);
}