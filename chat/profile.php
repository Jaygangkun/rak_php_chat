<?php
// include('includeDatabase.php');

// if(!isset($_SESSION['chatUserId']) || empty($_SESSION['chatUserId'])) {
// 	header("Location: https://localhost:8903/chat/login.php");
// }
$getUserData = mysqli_query($dbConnect, "SELECT * FROM `bmwUsers` WHERE `userId` = '".$_SESSION['chatUserId']."'");
$userData = mysqli_fetch_assoc( $getUserData );
?>
	<?php
	$firstname = '';
	$lastname = '';
	$password = '';
	$profile = null;
	// $profile_img = '';
	if(isset($_POST['submit_profile'])){
		if(isset($_POST['firstname'])){
			$firstname = $_POST['firstname'];
		}

		if(isset($_POST['lastname'])){
			$lastname = $_POST['lastname'];
		}


		// if(isset($_FILES['profile_file']) && $_FILES['profile_file']['name'] != ''){
		// 	//upload identification image
		// 	$filename = 'avatar-'.$userData['userId'].".".pathinfo($_FILES['profile_file']['name'], PATHINFO_EXTENSION);
			
		// 	move_uploaded_file($_FILES['profile_file']['tmp_name'], __DIR__.'/profiles/'.$filename);
		// 	$profile_img = 'profiles/'.$filename;
		// }
		// else{
		// 	$profile_img = $userData['profile'];
		// }
		$profile_img = $userData['profile'];
	}
	else{
		$firstname = $userData['firstName'];
		$lastname = $userData['lastName'];
		$profile_img = $userData['profile'];
	}
	
	?>
	<body>
		<div class="container-scroller">
			<div class="container-fluid page-body-wrapper full-page-wrapper">
				<div class="content-wrapper auth p-0 theme-two">
					<div class="row d-flex align-items-stretch">
						<div class="col-12 col-md-12 h-100 bg-white">
							<div class="auto-form-wrapper d-flex align-items-center justify-content-center flex-column">
								<?php
                $submit_error = false;
									?>
								<form method="POST" enctype="multipart/form-data">
									<div class="profile-avatar-wrap mb-4">
										<div class="profile-avatar__img <?php echo $profile_img == '' ? "no-image": "" ?>" id="profile_preview_img" style="background-image: url('<?php echo $profile_img != '' ? $profile_img."?v=".time() : "assets/images/avatar-default.png" ?>')">
											
										</div>
										<input type="file" name="profile_file" accept="image/*" id="profile_file" style="display: none" value="<?php echo isset($_POST['profile_file']) ? $_POST['profile_file'] : ''?>">
										<input type="hidden" id="profile_image">
									</div>
									<div class="form-group">
										<div class="input-group">
											<div class="input-group-prepend">
												<span class="input-group-text">
												<i class="mdi mdi-account-outline"></i>
												</span>
											</div>
											<input type="text" name="firstname" class="form-control" placeholder="First Name" value="<?php echo $firstname?>">
										</div>
									</div>
									<div class="form-group">
										<div class="input-group">
											<div class="input-group-prepend">
												<span class="input-group-text">
												<i class="mdi mdi-account-outline"></i>
												</span>
											</div>
											<input type="text" name="lastname" class="form-control" placeholder="Last Name" value="<?php echo $lastname?>">
										</div>
									</div>
									<div class="form-group">
										<div class="input-group">
											<div class="input-group-prepend">
												<span class="input-group-text">
												<i class="mdi mdi-lock-outline"></i><span style="color: red;margin-left: 5px;">*</span>
												</span>
											</div>
											<input type="password" name="password" class="form-control" placeholder="Password" value="<?php echo isset($_POST['password']) ? $_POST['password'] : "" ?>">
										</div>
										<?php
											if(isset($_POST['submit_profile']) && empty($_POST['password'])) {
											  $submit_error = true;
											  ?>
										    <div class="error mt-2 text-danger" for="password">Please fill in your password</div>
										<?php
											}
											?>
									</div>
									<div class="form-group">
										<input type="submit" name="submit_profile" class="btn btn-primary submit-btn" value="Update" />
									</div>

                  
								</form>
							</div>
						</div>
					</div>
				</div>
				<!-- content-wrapper ends -->
			</div>
			<!-- page-body-wrapper ends -->
		</div>
		<!-- container-scroller -->
    <script src="assets/vendors/sweetalert/sweetalert.min.js"></script>
		<!-- endinject -->
		<!-- Custom js for this page -->
		<!-- End custom js for this page -->
		<script>
			jQuery(document).on('change', '#profile_file', function(evt){
				const [file] = this.files;
				if (file) {
					jQuery('#profile_preview_img').css('background-image', 'url(' + URL.createObjectURL(file) + ')');
					jQuery('#profile_preview_img').removeClass('no-image');
					// jQuery('#profile_image').val(URL.createObjectURL(file));
				}
			})

			jQuery(document).on('click', '#profile_preview_img', function(){
				jQuery('#profile_file').click();
			})
		</script>
	</body>
</html>