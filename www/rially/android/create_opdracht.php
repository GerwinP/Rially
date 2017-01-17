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
if ($_SERVER['REQUEST_METHOD'] == "POST" && isset($_POST['opdracht'])) {

    $opdracht = $_POST['opdracht'];

    //make connection with the database
    $db = mysqli_connect(DB_SERVER, DB_USER, DB_PASSWORD, DB_DATABASE);

    if ($db->connect_error) {
        die('Connect Error ('. $db->connect_errno . ')' . $db->connect_error);
    }

    if ($opdracht != "") {

        $check = mysqli_query($db, "SELECT * FROM opdrachten WHERE opdracht = '$opdracht'");

        if (mysqli_num_rows($check) == 0) {
            //try to insert row in database
            $result = mysqli_query($db, "INSERT INTO opdrachten(opdracht) VALUES('$opdracht')");

            //check if row is inserted
            if ($result) {
                //successfully inserted into database
                $response["success"] = 1;
                $response["message"] = "Assignment successfully created";
                $id = mysqli_query($db, "SELECT id FROM opdrachten WHERE opdracht = '$opdracht'");
                $row = mysqli_fetch_array($id);
                $response["id"] = $row["id"];
                $response["opdracht"] = $opdracht;

                //echoing JSON response
                echo json_encode($response);
            } else {
                //failed to insert row
                $response["success"] = 0;
                $response["message"] = "Could not add the assignment";

                echo json_encode($response);
            }
        } else {
            $response['success'] = 0;
            $response['message'] = "Assignment already exists";

            echo json_encode($response);
        }


    }


} else {
    //required field was missing
    $response["success"] = 0;
    $response["message"] = "Required field is missing";

    echo json_encode($response);
}


