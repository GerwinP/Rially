<?php
/**
 * Created by PhpStorm.
 * User: gerwin
 * Date: 21-8-16
 * Time: 17:24
 */

session_start();

require_once __DIR__ . '/../../db_config.php';

if(!(isset($_SESSION['login']) && $_SESSION['login'] != "")) {
    header("location: login.php");
}

$db = mysqli_connect(DB_SERVER, DB_USER, DB_PASSWORD, DB_DATABASE);

if ($db->connect_error) {
    die ('Connect error (' . $db->connect_errno . ')' . $db->connect_error);
}

if ($_SERVER['REQUEST_METHOD'] == "POST" && isset($_POST['assignment'])) {

    $response = array();

    $assignment = $_POST['assignment'];

    if ($assignment != "") {

        $check = mysqli_query($db, "SELECT * FROM opdrachten WHERE opdracht = '$assignment'");

        if (mysqli_num_rows($check) == 0 ) {
            $result = mysqli_query($db, "INSERT INTO opdrachten(opdracht) VALUES('$assignment')");

            if ($result) {
                $response['success'] = 1;
                $response['message'] = "Assignment succesfully added";
                //json_encode($response);
            } else {
                $response['success'] = 0;
                $response['message'] = "Could not add the assignment";
                json_encode($response);
            }
        } else {
            $response['success'] = 0;
            $response['message'] = "Assignment already exists";
            json_encode($response);
        }
    } else {
        $response['success'] = 0;
        $response['message'] = "Not all fields are filled";
        json_encode($response);
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Rially Admin - Add Assignment</title>

    <!-- Bootstrap Core CSS -->
    <link href="../vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">

    <!-- MetisMenu CSS -->
    <link href="../vendor/metisMenu/metisMenu.min.css" rel="stylesheet">

    <!-- Custom CSS -->
    <link href="../dist/css/sb-admin-2.css" rel="stylesheet">

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

        <?php include "page_parts/header.html"?>

        <?php include "page_parts/navbar.html" ?>

    </nav>

    <div id="page-wrapper">
        <div class="row">
            <div class="col-lg-6">
                <h1 class="page-header">Add new assignment</h1>
            </div>

            <div class="col-lg-6">
                <h1 class="page-header">Existing Assignments</h1>
            </div>

            <div class="col-md-4">
                <div class="alert alert-success alert-dismissable" style="display: none;">
                    <button class="close" type="button" data-dismiss="alert" aria-hidden="true">x</button>
                    Successfully added a new assignment
                </div>
                <div class="alert alert-danger alert-dismissable" style="display: none;">
                    <button class="close" type="button" data-dismiss="alert" aria-hidden="true">x</button>
                    Failed to add a new assignment
                </div>
               <label>Assignment</label>
                <p><input class="form-control" type="text" id="assignment"  placeholder="Assignment" autofocus></p>
                <button id="add-assignment" class="btn btn-primary" >Add assignment</button>
            </div>
            <div class="col-md-2"></div>

            <div class="col-md-6">
                <ul id="assignments"></ul>
            </div>

            <!--
            <div class="col-md-4">
                <form role="form" action="add_assignment.php" method="post" >
                    <fieldset>
                        <div class="form-group">
                            <label>Assignment</label>
                            <input class="form-control" placeholder="Assignment" name="assignment" autofocus>
                        </div>
                        <button type="submit" class="btn btn-primary">Add assignment</button>
                    </fieldset>
                </form>
            </div>
            <div class="col-md-2">

            </div>
            <div class="col-md-6">
                <div style="overflow-y: auto; height: 450px;">
                    <?php
                    $result = mysqli_query($db, "SELECT opdracht FROM opdrachten");

                    while ($row = mysqli_fetch_array($result)) {
                        $opdracht = $row["opdracht"];
                        echo "- $opdracht</br>";
                    }
                    ?>
                </div>
            </div>
            -->
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

<!-- Custom ajax script -->
<script src="../js/add_assignment.js"></script>

</body>

</html>
