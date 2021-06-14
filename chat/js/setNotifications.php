<?php
error_reporting(E_ALL);

include('../includeDatabase.php');
// session_start();

if(isset($_POST['roomId']) && !empty($_POST['roomId']) && isset($_POST['message'])) {
	$roomId = mysqli_real_escape_string( $dbConnect, $_POST['roomId'] );
	$message = mysqli_real_escape_string( $dbConnect, $_POST['message'] );
	$result = mysqli_query($dbConnect, "DELETE FROM roomnotifications WHERE roomId='".$roomId."'");

	if($message != ''){
		$result = mysqli_query($dbConnect, "INSERT INTO roomnotifications(roomId, message) VALUES('".$roomId."', '".$message."')");
		if($result) {
			echo json_encode(array(
				'success' => true
			));
	
			return;
		}
	}
	else{
		echo json_encode(array(
			'success' => true
		));

		return;
	}
	
}

echo json_encode(array(
	'success' => false
));
?>