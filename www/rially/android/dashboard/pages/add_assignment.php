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

    <title>Rially Admin - Add Assignment</title>

    <!-- jQuery UI CSS -->
    <link href="../vendor/jquery-ui/jquery-ui.min.css" rel="stylesheet">

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
        
        <div id="header-import"></div>

        <div id="navbar-import"></div>

    </nav>

    <div id="page-wrapper">
        <div class="row">

            <div class="col-lg-5">
                <h1 class="page-header">Existing Assignments</h1>

                <div class="panel panel-default">
                    <div class="panel-heading">Selection options</div>
                    <div class="panel-body">
                        <div class="row">
                            <div class="col-lg-4 center-block"><button id="select-all" class="btn btn-primary">Select all</button></div>
                            <div class="col-lg-4 center-block"><button id="select-none" class="btn btn-primary">Deselect all</button></div>
                            <div class="col-lg-4 center-block"><button id="reverse-selected" class="btn btn-primary">Reverse selected</button></div>
                        </div>
                    </div>
                </div>

                <div class="panel panel-default">
                    <div style="overflow:auto; height:650px;">
                        <ul class="list-unstyled" id="assignments"></ul>
                    </div>
                </div>

            </div>

            <div class="col-lg-1"></div>

            <div class="col-lg-5">
                <h1 class="page-header">Options</h1>

                <div class="panel panel-default" id="search-panel">
                    <div class="panel-heading" id="search-panel-heading">Search assignment</div>
                    <div class="panel-body">
                        <label>Search</label>
                        <p><input class="form-control" type="text" id="search-field" placeholder="Search"></p>
                        <button id="search-assignment" class="btn btn-primary">Search assignment</button>
                    </div>
                </div>

                <div class="panel panel-default" id="add-panel">
                    <div class="panel-heading" id="add-panel-heading">Add new assignment</div>
                    <div class="panel-body">
                        <label>Assignment</label>
                        <p><input class="form-control" type="text" id="assignment"  placeholder="Assignment" autofocus></p>
                        <button id="add-assignment" class="btn btn-primary" >Add assignment</button>
                    </div>
                </div>

                <div class="panel panel-default" id="remove-panel">
                    <div class="panel-heading" id="remove-panel-heading">Delete assignments</div>
                    <div class="panel-body">
                        <p><button id="remove-assignment" class="btn btn-danger">Remove selected assignments</button></p>
                        <p><span id="assignment-count">There are currently no assignments selected.</span></p>
                    </div>
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

<!-- Custom ajax script -->
<script src="../js/add_assignment.js"></script>

<!-- jQuery UI Javascript -->
<script src="../vendor/jquery-ui/jquery-ui.min.js"></script>\

<!-- Custom script for generating participants list -->
<script src="../js/global-javascript.js"></script>

</body>

</html>
