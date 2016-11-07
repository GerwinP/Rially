<?php
/**
 * Created by PhpStorm.
 * User: Admin
 * Date: 11/7/2016
 * Time: 4:05 PM
 */
require_once __DIR__ . '/db_config.php';

$response = array();

if ($_SERVER['REQUEST_METHOD'] == "POST" && isset($_POST['modifier'])) {

    $modifier = $_POST["modifier"];

    $db = mysqli_connect(DB_SERVER, DB_USER, DB_PASSWORD, DB_DATABASE);

    if ($db->connect_error) {
        die('Connect Error( ' . $db->connect_errno . ')' . $db->connect_error);
    }

    if ($modifier != "") {

        $check = mysqli_query($db, "SELECT * FROM modifiers WHERE modifier = '$modifier'");

        if (mysqli_num_rows($check) == 0) {
            $result = mysqli_query($db, "INSERT INTO modifiers(modifier) VALUES('$modifier')");

            if ($result) {
                $response["success"] = 1;
                $response["message"] = "Modifier successfully added";
                $response["modifier"] = $modifier;

                echo json_encode($response);
            } else {
                $response["success"] = 0;
                $response["message"] = "Could not add the modifier";
                $response["modifier"] = $modifier;

                echo json_encode($response);
            }
        } else {
            $response["success"] = 0;
            $response["message"] = "Modifier already exists";
            $response["modifier"] = $modifier;

            echo json_encode($response);
        }
    }
} else {
    $response["success"] = 0;
    $response["message"] = "Required field is missing";
    $response["modifier"] = "";
}