<?php
/**
 * Created by PhpStorm.
 * User: gerwin
 * Date: 21-8-16
 * Time: 17:24
 */

session_start();

if(!(isset($_SESSION['login']) && $_SESSION['login'] != "")) {
    header("location: login.php");
}

require_once __DIR__ . '/../../db_config.php';

$db = mysqli_connect(DB_SERVER, DB_USER, DB_PASSWORD, DB_DATABASE);

if ($db->connect_error) {
    die ('Connect error (' . $db->connect_errno . ')' . $db->connect_error);
}

$account = $_GET['username'];

?>

<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Rially Admin - Blank</title>

    <!-- Bootstrap Core CSS -->
    <link href="../vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">

    <!-- MetisMenu CSS -->
    <link href="../vendor/metisMenu/metisMenu.min.css" rel="stylesheet">

    <!-- Custom CSS -->
    <link href="../dist/css/sb-admin-2.css" rel="stylesheet">

    <!-- Personal CSS -->
    <link href="../css/styles.css" rel="stylesheet">

    <!-- Custom Fonts -->
    <link href="../vendor/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
    <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->

</head>

<body>

<div id="wrapper">

    <!-- Navigation -->
    <nav class="navbar navbar-default navbar-static-top" role="navigation" style="margin-bottom: 0">

        <div id="header-import"></div>

        <div id="navbar-import"></div>

    </nav>

    <div id="page-wrapper">
        <div class="row">
            <div class="col-lg-12">
                <?php
                echo "<h1 class='page-header'>$account</h1>"
                ?>
            </div>
            <!-- /.col-lg-12 -->
        </div>
        <div class = "row">
            <div class="col-lg-12">

                <ul class="list-unstyled">
                    <?php

                    $result = mysqli_query($db, "SELECT * FROM image_teams WHERE username = '$account'");

                    if (mysqli_num_rows($result) > 0) {
                        while ($row = mysqli_fetch_array($result)) {
                            $image_id = $row['image_id'];
                            $opdracht_ids = $row['opdracht_ids'];
                            $modifier_ids = $row['modifier_ids'];

                            $result_image = mysqli_query($db, "SELECT * FROM images WHERE id = '$image_id'");
                            if (mysqli_num_rows($result_image) > 0) {
                                while($row = mysqli_fetch_array($result_image)) {
                                    $image = base64_decode($row['image']);
                                    echo '<li><img class="img-thumbnail team_image" src = "data:image/jpeg;base64,' . base64_encode($image) . '"/></li>';
                                }
                            }
                        }
                    }


                    ?>
                </ul>
            </div>
        </div>

    </div>
    <!-- /#page-wrapper -->

</div>
<!-- /#wrapper -->

<!-- jQuery -->
<script src="../vendor/jquery/jquery.min.js"></script>

<!-- Bootstrap Core JavaScript -->
<script src="../vendor/bootstrap/js/bootstrap.min.js"></script>

<!-- Metis Menu Plugin JavaScript -->
<script src="../vendor/metisMenu/metisMenu.min.js"></script>

<!-- Custom Theme JavaScript -->
<script src="../dist/js/sb-admin-2.js"></script>

<!-- Custom script for generating participants list -->
<script src="../js/global-javascript.js"></script>

</body>

</html>
