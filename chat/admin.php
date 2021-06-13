<?php
include "simplexlsx.php";

if(isset($_POST['addUserRooms'])) {
	$target_dir = "uploads/";
	$target_file = $target_dir . basename($_FILES["fileToUpload"]["name"]);
	if(basename($_FILES["fileToUpload"]["name"]) == 'users.xlsx') {
		$imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
		if($imageFileType == "xlsx") {
			if(move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {
				if ( $xlsx = SimpleXLSX::parse($target_file) ) {
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
									mysqli_query($dbConnect, "INSERT INTO `roomMembersAllowed` (
										`memberUserId`, 
										`memberRoomId` 
									) VALUES(
										'".$userData['userId']."', 
										'".$roomData['roomId']."'
									)");
								}
							}
						}
						$i++;
					}
					?>
					<div class="meldingHolder">Allowed Student Classrooms succesfully imported</div>
					<?
				} else {
				echo SimpleXLSX::parseError();
				}
			}
		}
		else {
			?>
			<div class="meldingHolder meldingWarning">Wrong file type, needs to be xlxs</div>
			<?
		}
	}
	else {
		?>
		<div class="meldingHolder meldingWarning">Wrong file name, needs to be users.xlsx</div>
		<?
	}
}
// classrooms
if(isset($_POST['addClassRooms'])) {
	$target_dir = "uploads/";
	$target_file = $target_dir . basename($_FILES["fileToUpload2"]["name"]);
	if(basename($_FILES["fileToUpload2"]["name"]) == 'rooms.xlsx') {
		$imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
		if($imageFileType == "xlsx") {
			if(move_uploaded_file($_FILES["fileToUpload2"]["tmp_name"], $target_file)) {
				if ( $xlsx = SimpleXLSX::parse($target_file) ) {
					$i = 0;

					foreach ($xlsx->rows() as $elt) {
						mysqli_query($dbConnect, "INSERT INTO `chatRooms` (
							`roomName`, 
							`roomImg`
						) VALUES(
							'".$elt[0]."', 
							'assets/images/faces/c.png'
						)");
						$i++;
					}
					?>
					<div class="meldingHolder">Classrooms imported</div>
					<?
				} else {
				echo SimpleXLSX::parseError();
				}
			}
		}
		else {
			?>
			<div class="meldingHolder meldingWarning">Wrong file type, needs to be xlxs</div>
			<?
		}
	}
	else {
		?>
		<div class="meldingHolder meldingWarning">Wrong file name, needs to be rooms.xlsx</div>
		<?
	}
}
// delete
if(isset($_POST['removeClassRooms'])) {
	mysqli_query($dbConnect, "TRUNCATE `chatRooms`");
	mysqli_query($dbConnect, "TRUNCATE `roomMembers`");
	?>
	<div class="meldingHolder">Classrooms deleted</div>
	<?
}
?>

<script type="text/javascript">
	jQuery(document).ready(function() {
		jQuery("#uploadFileClick").click(function() {
			jQuery("#fileToUpload").click();
		});
		jQuery("#uploadFileClick2").click(function() {
			jQuery("#fileToUpload2").click();
		});
		jQuery("#removeTheRooms").click(function(e) {
			if(confirm('are you sure?')) {
				jQuery("#removeTheRoomsSubmit").click();
			}
		});
	});		
</script>

<div class="main-panel">
	<div class="content-wrapper">
		<div class="row">
			<div class="col-md-6 grid-margin stretch-card">
				<div class="card">
					<div class="card-body">
						<h4 class="card-title">Allowed Student Classrooms</h4>
						<form method="POST" class="forms-sample"  enctype="multipart/form-data">
							<div class="form-group">
								<input type="file" name="fileToUpload" id="fileToUpload" style="display: none;">
								<button type="button" id="uploadFileClick" class="btn btn-info btn-fw"><i class="mdi mdi-upload"></i>Upload users.xlsx</button>
							</div>
							<button type="submit" name="addUserRooms" class="btn btn-success mr-2">UPLOAD</button>
						</form>
					</div>
				</div>
			</div>
		</div>
		<div class="row">
			<div class="col-md-6 grid-margin stretch-card">
				<div class="card">
					<div class="card-body">
						<h4 class="card-title">Upload Classrooms</h4>
						<form method="POST" class="forms-sample"  enctype="multipart/form-data">
							<div class="form-group">
								<input type="file" name="fileToUpload2" id="fileToUpload2" style="display: none;">
								<button type="button" id="uploadFileClick2" class="btn btn-info btn-fw"><i class="mdi mdi-upload"></i>Upload rooms.xlsx</button>
							</div>
							<button type="submit" name="addClassRooms" class="btn btn-success mr-2">UPLOAD</button><br /><br />
							<button type="submit" name="removeClassRooms" id="removeTheRoomsSubmit" class="btn btn-danger mr-2" style="display: none;">REMOVE ALL ROOMS</button>
							<button type="button" id="removeTheRooms" class="btn btn-danger mr-2">REMOVE ALL ROOMS</button>
						</form>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>