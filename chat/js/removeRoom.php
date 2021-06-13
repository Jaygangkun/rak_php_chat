<?php

include('../includeDatabase.php');
session_start();

if(isset($_POST['roomId']) && !empty($_POST['roomId'])) {
	$roomId = mysqli_real_escape_string( $dbConnect, $_POST['roomId'] );
	mysqli_query($dbConnect, "DELETE FROM `roomMembers` WHERE `memberUserId` = '".$_SESSION['chatUserId']."' && `memberRoomId` = '".$roomId."'");
}
?> 