<?php

include('../includeDatabase.php');
session_start();

if(isset($_POST['roomId']) && !empty($_POST['roomId']) && isset($_POST['lastMessage']) && !empty($_POST['lastMessage'])) {
	$roomId = mysqli_real_escape_string( $dbConnect, $_POST['roomId'] );
	$lastMessage = mysqli_real_escape_string( $dbConnect, $_POST['lastMessage'] );
	$getCurrentMessages = mysqli_query($dbConnect, "SELECT `messageText`, `messageUserId`, `messageId` FROM `roomMessages` WHERE `messageRoomId` = '".$roomId."' && `messageId` > '".$lastMessage."' && `messageUserId` != '".$_SESSION['chatUserId']."'");
	$allMessagesArray = array();
	while($messagesData = mysqli_fetch_assoc( $getCurrentMessages )) {
		$getMessageUserData = mysqli_query($dbConnect, "SELECT `userName` FROM `bmwUsers` WHERE `userId` = '".$messagesData['messageUserId']."'");
		$messageUserData = mysqli_fetch_assoc( $getMessageUserData );
		$messageArray = array();
		array_push($messageArray, $messagesData['messageText']);
		array_push($messageArray, $messageUserData['userName']);
		array_push($messageArray, $messagesData['messageId']);
		array_push($allMessagesArray, $messageArray);
	}
	echo json_encode($allMessagesArray);
}
?> 