<?php

$dbUser = "root";
$dbPass = 'root';
$dbHost = "localhost";
$dbName = "chat";

$dbConnect = mysqli_connect($dbHost, $dbUser, $dbPass, $dbName)
  or die("This is website is currently under construction.");

//mysqli_select_db($dbConnect, $dbName);
date_default_timezone_set('Asia/Dubai');

?>
