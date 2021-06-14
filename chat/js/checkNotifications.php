<?php
// error_reporting(E_ALL);

include('../includeDatabase.php');
// session_start();

if(isset($_POST['roomId']) && !empty($_POST['roomId'])) {
	$roomId = mysqli_real_escape_string( $dbConnect, $_POST['roomId'] );
	
	$result = mysqli_query($dbConnect, "SELECT * FROM roomnotifications WHERE roomId='".$roomId."'");
	$notificationData = mysqli_fetch_assoc( $result );
	if($notificationData) {
		echo json_encode(array(
			'success' => true,
			'message'=> $notificationData['message']
		));

		die();
	}
}

echo json_encode(array(
	'success' => false
));
?>