<?php
/**
 * Created by PhpStorm.
 * User: Admin
 * Date: 14-Jan-17
 * Time: 22:12
 */

require_once __DIR__ . '/db_config.php';

$response = array();

if (isset($_POST['username'])) {

    $username = $_POST['username'];

    $db = mysqli_connect(DB_SERVER, DB_USER, DB_PASSWORD, DB_DATABASE);

    if ($db->connect_error) {
        die('Connect Error(' . $db->conect_erno . ')' . $db->connect_error);
    }

    $result = mysqli_query($db, "SELECT * FROM image_teams WHERE username = '$username'");

    if (mysqli_num_rows($result) > 0) {

        $images = array();

        while($row = mysqli_fetch_array($result)) {
            $image_id = $row['image_id'];
            $opdracht_ids = $row['opdracht_ids'];
            $modifier_ids = $row['modifier_ids'];

            $result_image = mysqli_query($db, "SELECT * FROM images WHERE id = '$image_id'");

            
        }
    }

}

