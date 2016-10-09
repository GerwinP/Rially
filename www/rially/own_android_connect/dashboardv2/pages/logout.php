<?php
/**
 * Created by PhpStorm.
 * User: gerwin
 * Date: 21-8-16
 * Time: 17:53
 */

session_start();
session_destroy();
header("location: login.php");