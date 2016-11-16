<?php
/**
 * Created by PhpStorm.
 * User: Gerwin
 * Date: 26-5-2016
 * Time: 13:03
 */

require_once __DIR__ . '/db_config.php';

$response = array();

if (isset($_POST['image']) && isset($_POST['opdracht_ids']) && isset($_POST['username']) && isset($_POST['modifier_ids'])) {

    $image = $_POST['image'];
    $username = $_POST['username'];
    $opdracht_ids = $_POST['opdracht_ids'];
    $modifier_ids = $_POST['modifier_ids'];

    $db = mysqli_connect(DB_SERVER, DB_USER, DB_PASSWORD, DB_DATABASE);

    if ($db->connect_error) {
        die ('Connect error (' . $db->connect_errno . ')' . $db->connect_error);
    }

    $check = mysqli_query($db, "SELECT * FROM images WHERE image = '$image'");

    if (mysqli_num_rows($check) == 0) {
        $result = mysqli_query($db, "INSERT INTO images(image) VALUES ('$image')");

        if ($result) {
            $response["success"] = 1;
            $response["message"] = "Successfully uploaded image";

            echo json_encode($response);

            $result2 = mysqli_query($db, "SELECT * FROM images WHERE image='$image'");
            if (mysqli_num_rows($result2) > 0) {
                while ($row = mysqli_fetch_array($result2)) {
                    $image_id = $row['id'];
                }
                $result3 = mysqli_query($db, "INSERT INTO image_teams(image_id, username, opdracht_ids, modifier_ids)
                                          VALUES('$image_id', '$username', '$opdracht_ids', '$modifier_ids')");
                if ($result3) {
                    $response["success"] = 1;
                    $response["message"] = "Successfully added image with opdrachten";

                    echo json_encode($response);
                } else {
                    $response["success"] = 0;
                    $response["message"] = "Failed to insert image in image_teams";

                    echo json_encode($response);
                }
            } else {
                $response["success"] = 0;
                $response["message"] = "Failed to get the image id";

                echo json_encode($response);
            }
        } else {
            $response["success"] = 0;
            $response["message"] = "Failed to insert image in images";

            echo json_encode($response);
        }

    } else {
        $response["success"] = 0;
        $response["message"] = "Image already exists";

        echo json_encode($response);
    }


} else {
    $response["success"] = 0;
    $response["message"] = "Required field(s) are missing";

    echo json_encode($response);
}
