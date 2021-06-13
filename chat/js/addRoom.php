<?php

include('../includeDatabase.php');
session_start();

if(isset($_POST['roomId']) && !empty($_POST['roomId'])) {
	$roomId = mysqli_real_escape_string( $dbConnect, $_POST['roomId'] );
	mysqli_query($dbConnect, "INSERT INTO `roomMembers` (
		`memberUserId`, 
		`memberRoomId` 
	) VALUES(
		'".$_SESSION['chatUserId']."', 
		'".$roomId."'
	)");
}
?> 