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
?>

<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Rially Admin - Add Modifier</title>

    <!-- Bootstrap Core CSS -->
    <link href="../vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">

    <!-- MetisMenu CSS -->
    <link href="../vendor/metisMenu/metisMenu.min.css" rel="stylesheet">

    <!-- Custom CSS -->
    <link href="../dist/css/sb-admin-2.css" rel="stylesheet">

    <!-- Custom Fonts -->
    <link href="../vendor/font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">

    <link href="../css/styles.css" rel="stylesheet">

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
            <div class="col-lg-5">
                <h1 class="page-header">Add new modifier</h1>

                <!-- Hidden Warnings -->

                <div class="alert-success-message">
                    <div class="alert alert-success alert-dismissable">
                        <button class="close" type="button" data-dismiss="alert" aria-hidden="true">x</button>
                        Successfully added a new modifier
                    </div>
                </div>
                <div class="alert-danger-message">
                    <div class="alert alert-danger alert-dismissable">
                        <button class="close" type="button" data-dismiss="alert" aria-hidden="true">x</button>
                        <span id = "failmessage">Failed to add a new assignment</span>
                    </div>
                </div>

                <!-- /Hidden warnings -->

                <label>Modifier</label>
                <p><input class="form-control" type="text" id="modifier"  placeholder="Modifier" autofocus></p>
                <button id="add-modifier" class="btn btn-primary" >Add modifier</button>
            </div>

            <div class="col-lg-1"></div>

            <!-- /.col-lg-12 -->
            <div class="col-lg-5">
                <h1 class="page-header">Existing modifiers</h1>
                <div style="overflow:auto; height:600px;">
                    <ul id="modifiers"></ul>
                </div>
            </div>

            <div class="col-lg-1"></div>
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

<!-- Custom script for loading and adding stuff -->
<script src="../js/add_modifier.js"></script>

</body>

</html>
