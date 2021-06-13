<?php

include('../includeDatabase.php');
session_start();

if(isset($_POST['roomId']) && !empty($_POST['roomId']) || isset($_POST['sendMessage']) && !empty($_POST['sendMessage'])) {
	$roomId = mysqli_real_escape_string( $dbConnect, $_POST['roomId'] );
	$sendMessage = mysqli_real_escape_string( $dbConnect, $_POST['sendMessage'] );
	$thisTime = time();
	mysqli_query($dbConnect, "INSERT INTO `roomMessages` (
		`messageUserId`, 
		`messageRoomId`, 
		`messageTime`, 
		`messageText`
	) VALUES(
		'".$_SESSION['chatUserId']."', 
		'".$roomId."', 
		'".$thisTime."', 
		'".$sendMessage."'
	)");
}
?> 