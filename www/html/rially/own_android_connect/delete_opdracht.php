<?php
/**
 * Created by PhpStorm.
 * User: Gerwin
 * Date: 12-5-2016
 * Time: 16:22
 */

require_once __DIR__ . '/db_config.php';

$response = array();

if (isset($_POST['id'])) {

    $id = $_POST['id'];

    //connect to db
    $db = mysqli_connect(DB_SERVER, DB_USER, DB_PASSWORD, DB_DATABASE);

    if ($db->connect_error) {
        die('Connect Error (' . $db->connect_errno . ')' . $db->connect_error);
    }

    $result = mysqli_query($db, "DELETE FROM opdrachten WHERE id = $id");

    //check if row is deleted or not
    if (mysqli_affected_rows($db) > 0) {
        //successfully updated
        $response["succes"] = 1;
        $response["message"] = "Opdracht succesfully deleted";

        echo json_encode($response);
    }
} else {
    //required field is missing
    $response["succes"] = 0;
    $response["message"] = "Required field is missing";

    echo json_encode($response);
}