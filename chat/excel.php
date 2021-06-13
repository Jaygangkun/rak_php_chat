<html>
<body>

<?php

session_start();
include('includeDatabase.php');

include "simplexlsx.php";

if ( $xlsx = SimpleXLSX::parse('test.xlsx') ) {
	echo '<table><tbody>';
	$i = 0;

	foreach ($xlsx->rows() as $elt) {
		$searchUser = mysqli_query($dbConnect, "SELECT `userId` FROM `bmwUsers` WHERE `userEmail` = '".$elt[0]."'");
		if(mysqli_num_rows( $searchUser ) > 0) {
			$userData = mysqli_fetch_assoc( $searchUser );
			$allRooms = explode(',', $elt[1]);
			foreach($allRooms AS $roomId) {
				$checkRoom = mysqli_query($dbConnect, "SELECT `roomId` FROM `chatRooms` WHERE `roomName` = '".$roomId."'");
				if(mysqli_num_rows( $checkRoom ) > 0) {
					$roomData = mysqli_fetch_assoc( $checkRoom );
					mysqli_query($dbConnect, "INSERT INTO `roomMembers` (
						`memberUserId`, 
						`memberRoomId` 
					) VALUES(
						'".$userData['userId']."', 
						'".$roomData['roomId']."'
					)");
					echo "<tr><td>" . $elt[0] . "</td><td>" . $roomId . "</td></tr>";
				}
			}
		}
		$i++;
	}

echo "</tbody></table>";

} else {
echo SimpleXLSX::parseError();
}

?>

</body>
</html>	