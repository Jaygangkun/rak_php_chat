<?php
error_reporting(E_ALL);

include('../includeDatabase.php');
session_start();

if(isset($_POST['userName']) && !empty($_POST['userName']) && isset($_POST['userPass']) && !empty($_POST['userPass'])) {
	$userName = mysqli_real_escape_string( $dbConnect, $_POST['userName'] );
	$userPass = mysqli_real_escape_string( $dbConnect, $_POST['userPass'] );
	$savePass = md5($userPass);
	$checkLogin = mysqli_query($dbConnect, "SELECT `userId`, `userName` FROM `bmwUsers` WHERE `userEmail` = '".$userName."' && `userPass` = '".$savePass."'");
	if(mysqli_num_rows( $checkLogin ) > 0) {
		$loginData = mysqli_fetch_assoc( $checkLogin );
		$_SESSION['chatUserId'] = $loginData['userId'];
		$_SESSION['chatUserName'] = $loginData['userName'];
		echo "success";
	}
	else {
		echo "fail";
	}
}
?>