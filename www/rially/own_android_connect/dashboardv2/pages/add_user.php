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

if ($_SERVER['REQUEST_METHOD'] == "POST" && isset($_POST['Username'])
        && isset($_POST['Password'])
            && isset($_POST['RPassword'])
                && isset($_POST['isAdmin'])) {

    $response = array();



    $username = $_POST['Username'];
    $hpassword = hash("sha256", $_POST['Password']);
    $hRpassword = hash("sha256", $_POST['RPassword']);
    $isAdmin = $_POST['isAdmin'];

    if ($username != "" && $_POST['Password'] != "") {
        if ($hpassword == $hRpassword) {

            //Check if the username already exists
            $check = mysqli_query($db, "SELECT * FROM users WHERE username = '$username'");

            if (mysqli_num_rows($check) == 0) {
                $result = mysqli_query($db, "INSERT INTO users(username, password, admin) VALUES('$username', '$hpassword', '$isAdmin')");

                if ($result) {
                    create_error(0);
                    $response["success"] = 1;
                    $response["message"] = "User successfully created";
                } else {
                    $response["success"] = 0;
                    $response["message"] = "Failed to create new user";
                }
            } else {
                create_error(1);
                $response["success"] = 0;
                $response["message"] = "Username already exists";
            }


        } else {
            create_error(2);
            $response["success"] = 0;
            $response["message"] = "Passwords are not equal";
        }
    } else {
        create_error(3);
        $response["success"] = 0;
        $response["message"] = "Fields are still empty";
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

    <title>Rially Admin - Add User</title>

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
                    <li>
                        <a href="#"><i class="fa fa-user fa-fw"></i> Participants<span class="fa arrow"></span></a>
                        <ul class="nav nav-second-level">
                            <?php
                            $result = mysqli_query($db, "SELECT uid,username FROM users");

                            while ($row = mysqli_fetch_array($result)) {
                                $username = $row["username"];
                                $uid = $row["uid"];
                                echo "<li> <a href='viewimages.php?username=$username'>$username</a></li>";
                            }
                            ?>
                        </ul>
                    </li>
                </ul>
            </div>
            <!-- /.sidebar-collapse -->
        </div>
        <!-- /.navbar-static-side -->
    </nav>

    <div id="page-wrapper">
        <div class="row">
            <div class="col-md-12">
                <h1 class="page-header">Add User</h1>
            </div>
            <!-- /.col-lg-12 -->
        </div>

        <div class="row">
            <div class="col-md-4">

                <form role="form" action="add_user.php" method="post" >

                    <fieldset>
                        <div class="form-group">
                            <label>Username/Team name</label>
                            <input class="form-control" placeholder="Username" name="Username">
                        </div>
                        <div class="form-group">
                            <label>Password</label>
                            <input class="form-control" placeholder="Password" type="password" name="Password">
                        </div>
                        <div class="form-group">
                            <label>Reenter password</label>
                            <input class="form-control" placeholder="Reenter Password" type="password" name="RPassword">
                        </div>
                        <div class="checkbox">
                            <label>
                                <input type="hidden" name="isAdmin" value="0">
                                <input type="checkbox" name="isAdmin" value="1">
                                Is admin
                            </label>
                        </div>
                        <button type="submit" class="btn btn-primary">Submit</button>
                    </fieldset>
                </form>
                <?php
                function create_error($error) {
                    if ($error == 1) {
                        echo "<div class=\"alert alert-danger alert-dismissable\"> 
                                <button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>
                                The username already exists, try a different username.
                                </div>";
                    } elseif ($error == 2) {
                        echo "<div class=\"alert alert-danger alert-dismissable\"> 
                                <button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>
                                The passwords are not equal.
                                </div>";
                    } elseif ($error == 3) {
                        echo "<div class=\"alert alert-warning alert-dismissable\"> 
                                <button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>
                                Not all fields are filled.
                                </div>";
                    } elseif ($error == 0) {
                        echo "<div class=\"alert alert-success alert-dismissable\"> 
                                <button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>
                                User is successfully created.
                                </div>";
                    }
                }
                ?>
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
