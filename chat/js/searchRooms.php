<?php

include('../includeDatabase.php');
session_start();

if(isset($_POST['roomName']) && !empty($_POST['roomName'])) {
	$roomName = mysqli_real_escape_string( $dbConnect, $_POST['roomName'] );
	if($roomName == ''){
		$getRooms = mysqli_query($dbConnect, "SELECT * FROM `chatRooms` LIMIT 20");	
	}
	else{
		$getRooms = mysqli_query($dbConnect, "SELECT * FROM `chatRooms` WHERE `roomName` LIKE '%".$roomName."%' LIMIT 20");
	}
	$roomArray = array();
	while($roomData = mysqli_fetch_assoc($getRooms)) {
		if($roomData['customRoom'] == '1'){
			$countMembers = mysqli_query($dbConnect, "SELECT `memberId` FROM `roomMembers` WHERE `memberRoomId` = '".$roomData['roomId']."'");
			$memberCount = mysqli_num_rows( $countMembers );
			$thisRoom = array();
			array_push($thisRoom, $roomData['roomId']);
			array_push($thisRoom, $roomData['roomName']);
			array_push($thisRoom, $roomData['roomImg']);
			array_push($thisRoom, $memberCount);
			array_push($thisRoom, $roomData['customRoom']);
			array_push($roomArray, $thisRoom);
		}
		else{
			$checkIfUserAllowToRoom = mysqli_query($dbConnect, "SELECT `memberRoomId` FROM `roomMembersAllowed` WHERE `memberRoomId` = '".$roomData['roomId']."' && `memberUserId` = '".$_SESSION['chatUserId']."'");
			if(mysqli_num_rows( $checkIfUserAllowToRoom ) > 0) {
				$countMembers = mysqli_query($dbConnect, "SELECT `memberId` FROM `roomMembers` WHERE `memberRoomId` = '".$roomData['roomId']."'");
				$memberCount = mysqli_num_rows( $countMembers );
				$thisRoom = array();
				array_push($thisRoom, $roomData['roomId']);
				array_push($thisRoom, $roomData['roomName']);
				array_push($thisRoom, $roomData['roomImg']);
				array_push($thisRoom, $memberCount);
				array_push($thisRoom, $roomData['customRoom']);
				array_push($roomArray, $thisRoom);
			}
		}
	}
	echo json_encode($roomArray);
}
?> 