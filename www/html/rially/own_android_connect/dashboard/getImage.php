<?php
/**
 * Created by PhpStorm.
 * User: Gerwin
 * Date: 27-5-2016
 * Time: 09:26
 */
if (isset($_POST['username']) && isset($_POST['password'])) {
    $username = $_POST['username'];
    $password = $_POST['password'];

    if ($password != "rially2016") {
        echo "<h1>Wrong password</h1>";
    } else {
        require_once __DIR__ . '/../db_config.php';

        $db = mysqli_connect(DB_SERVER, DB_USER, DB_PASSWORD, DB_DATABASE);

        if ($db->connect_error) {
            die('Connect Error (' . $db->connect_errno . ')' . $db->connect_error);
        }

        $result = mysqli_query($db, "SELECT * FROM image_teams WHERE username='$username'");
        echo 'Team: ' . $username;
        echo '<br>';
        echo '<hr>';
        if ( mysqli_num_rows($result) > 0) {
            while( $row = mysqli_fetch_array($result)) {
                //temp image array
                $image_id = $row['image_id'];
                $opdracht_ids = $row['opdracht_ids'];
                $modifier_ids = $row['modifier_ids'];
                echo 'De opdrachten voor deze afbeelding: ' . $opdracht_ids;
                echo '</br>';
                echo 'De modifiers: ' . $modifier_ids;
                echo '</br>';
                $result_image = mysqli_query($db, "SELECT * FROM images WHERE id='$image_id'");
                if (mysqli_num_rows($result_image) > 0) {
                    while ($row = mysqli_fetch_array($result_image)) {
                        $image = base64_decode($row['image']);
                        echo '<img src = "data:image/jpeg;base64,' . base64_encode($image) . '"/>';
                        echo '</br>';
                        echo '<hr>';
                    }

                }

            }
        }
    }
} else {
    echo "<h1>Missing fields</h1>";
}


