<?php
/**
 * Created by PhpStorm.
 * User: Gerwin
 * Date: 12-5-2016
 * Time: 16:34
 */

require_once __DIR__ . '/db_config.php';

$response = array();

if (isset($_POST['id']) && isset($_GET['opdracht'])) {

    $id = $_POST['id'];
    $opdracht = $_POST['opdracht'];

    //connect to database
    $db = mysqli_connect(DB_SERVER, DB_USER, DB_PASSWORD, DB_DATABASE);

    if ($db->connect_error) {
        die('Connect Error (' . $db->connect_errno . ')' . $db->connect_error);
    }

    $result = mysqli_query($db, "UPDATE opdrachten SET opdracht = $opdracht WHERE id = $id");

    //check if row is updated or not
    if ($result) {
        $response["succes"] = 1;
        $response["message"] = "Opdracht is successfully updated";

        echo json_encode($response);
    } else {
        $response["succes"] = 0;
        $response["message"] = "Failed to update opdracht";

        echo json_encode($response);
    }
} else {
    $response["succes"] = 0;
    $response["message"] = "Required field missing";

    echo json_encode($response);
}