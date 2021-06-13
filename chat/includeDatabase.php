<?php

$dbUser = "root";
$dbPass = 'flamingo';
$dbHost = "195.201.99.166";
$dbName = "chat";

$dbConnect = mysqli_connect($dbHost, $dbUser, $dbPass, $dbName)
  or die("This is website is currently under construction.");

//mysqli_select_db($dbConnect, $dbName);
date_default_timezone_set('Asia/Dubai');

?>
