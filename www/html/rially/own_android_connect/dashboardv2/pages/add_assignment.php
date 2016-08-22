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

if ($_SERVER['REQUEST_METHOD'] == "POST" && isset($_POST['assignment'])) {

    require_once __DIR__ . '/../../db_config.php';

    $response = array();

    $assignment = $_POST['assignment'];

    if ($assignment != "") {
        $db = mysqli_connect(DB_SERVER, DB_USER, DB_PASSWORD, DB_DATABASE);

        if ($db->connect_error) {
            die ('Connect error (' . $db->connect_errno . ')' . $db->connect_error);
        }

        $check = mysqli_query($db, "SELECT * FROM opdrachten WHERE opdracht = '$assignment'");

        if (mysqli_num_rows($check) == 0 ) {
            $result = mysqli_query($db, "INSERT INTO opdrachten(opdracht) VALUES('$assignment')");

            if ($result) {
                $response['success'] = 1;
                $response['message'] = "Assignment succesfully added";
                echo json_encode($response);
            } else {
                $response['success'] = 0;
                $response['message'] = "Could not add the assignment";
                echo json_encode($response);
            }
        } else {
            $response['success'] = 0;
            $response['message'] = "Assignment already exists";
            echo json_encode($response);
        }
    } else {
        $response['success'] = 0;
        $response['message'] = "Not all fields are filled";
        echo json_encode($response);
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
        <div class="navbar-header">
            <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand" href="index.php">Rially Admin</a>
        </div>
        <!-- /.navbar-header -->

        <ul class="nav navbar-top-links navbar-right">

            <!-- /.dropdown -->
            <li class="dropdown">
                <a class="dropdown-toggle" data-toggle="dropdown" href="#">
                    <i class="fa fa-user fa-fw"></i> <i class="fa fa-caret-down"></i>
                </a>
                <ul class="dropdown-menu dropdown-user">
                    <li><a href="#"><i class="fa fa-user fa-fw"></i> User Profile</a>
                    </li>
                    <li><a href="#"><i class="fa fa-gear fa-fw"></i> Settings</a>
                    </li>
                    <li class="divider"></li>
                    <li><a href="logout.php"><i class="fa fa-sign-out fa-fw"></i> Logout</a>
                    </li>
                </ul>
                <!-- /.dropdown-user -->
            </li>
            <!-- /.dropdown -->
        </ul>
        <!-- /.navbar-top-links -->

        <div class="navbar-default sidebar" role="navigation">
            <div class="sidebar-nav navbar-collapse">
                <ul class="nav" id="side-menu">
                    <li class="sidebar-search">
                        <div class="input-group custom-search-form">
                            <input type="text" class="form-control" placeholder="Search...">
                            <span class="input-group-btn">
                                <button class="btn btn-default" type="button">
                                    <i class="fa fa-search"></i>
                                </button>
                            </span>
                        </div>
                        <!-- /input-group -->
                    </li>
                    <li>
                        <a href="index.php"><i class="fa fa-dashboard fa-fw"></i> Dashboard</a>
                    </li>
                    <li>
                        <a href="add_user.php"><i class="fa fa-users fa-fw"></i> Add User/Team</a>
                    </li>
                    <li>
                        <a href="add_assignment.php"><i class="fa fa-list fa-fw"></i> Add Assignments</a>
                    </li>
                    <li>
                        <a href="add_modifier.php"><i class="fa fa-list fa-fw"></i> Add Modifiers</a>
                    </li>
                </ul>
            </div>
            <!-- /.sidebar-collapse -->
        </div>
        <!-- /.navbar-static-side -->
    </nav>

    <div id="page-wrapper">
        <div class="row">
            <div class="col-lg-12">
                <h1 class="page-header">Add new assignment</h1>
            </div>
            <!-- /.col-lg-12 -->
        </div>
        <div class="row">
            <div class="col-md-4">
                <form role="form" action="add_assignment.php" method="post" >
                    <fieldset>
                        <div class="form-group">
                            <label>Assignment</label>
                            <input class="form-control" placeholder="Assignment" name="assignment">
                        </div>
                        <button type="submit" class="btn btn-primary">Add assignment</button>
                    </fieldset>
                </form>
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

</body>

</html>
