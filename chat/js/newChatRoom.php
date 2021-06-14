<?php
error_reporting(E_ALL);

include('../includeDatabase.php');
// session_start();

if(isset($_POST['roomName']) && !empty($_POST['roomName'])) {
	$roomName = mysqli_real_escape_string( $dbConnect, $_POST['roomName'] );
	$result = mysqli_query($dbConnect, "INSERT INTO chatrooms(roomName, roomImg, customRoom) VALUES('".$roomName."', 'assets/images/faces/c.png', '1')");
	if($result) {
		$room_id = mysqli_insert_id($dbConnect);
		$users = mysqli_query($dbConnect, "SELECT * FROM bmwusers");
		while($userData = mysqli_fetch_assoc( $users )) {
			mysqli_query($dbConnect, "INSERT INTO roommembers(memberUserId, memberRoomId) VALUES('".$userData['userId']."', '".$room_id."')");
		}
		echo json_encode(array(
			'success' => true,
			'roomId' => $room_id
		));
		return;
	}
}
echo json_encode(array(
	'success' => false
));
?>