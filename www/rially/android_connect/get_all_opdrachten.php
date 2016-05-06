<?php
/**
 * Created by PhpStorm.
 * User: Gerwin
 * Date: 5-5-2016
 * Time: 16:55
 * The following code will list all the opdrachten
 */

// array for JSON response
$response = array();

// include db connect class
require_once __DIR__ . '/db_connect.php';

// connect to db
$db = new db_connect();

// get all the opdrachten from opdrachten table
$result = mysqli_query("SELECT * FROM opdrachten") or die (mysqli_error());

// check for empty result
if (mysqli_num_rows($result) > 0) {
    // looping through all results
    // opdrachten node
    $response["opdrachten"] = array();

    while ($row = mysqli_fetch_array($result)) {
        //temp user array
        array_push($response["products"], $row["product"]);
    }
    // success
    $response["succes"] = 1;

    //echoing JSON response
    echo json_encode($response);
} else {
    //no opdrachten found
    $response["success"] = 0;
    $response["message"] = "No opdrachten found";

    // echo no users JSON
    echo json_encode($response);
}
