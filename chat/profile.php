<?php
// include('includeDatabase.php');

// if(!isset($_SESSION['chatUserId']) || empty($_SESSION['chatUserId'])) {
// 	header("Location: https://localhost:8903/chat/login.php");
// }
$getUserData = mysqli_query($dbConnect, "SELECT * FROM `bmwUsers` WHERE `userId` = '".$_SESSION['chatUserId']."'");
$userData = mysqli_fetch_assoc( $getUserData );
?>
	<?php
	$username = '';
	$firstname = '';
	$lastname = '';
	$email = '';
	$password = '';
	$confirm_password = '';
	$profile = null;
	$profile_img = '';
	if(isset($_POST['submit'])){
		if(isset($_POST['username'])){
			$username = $_POST['username'];
		}

		if(isset($_POST['firstname'])){
			$firstname = $_POST['firstname'];
		}

		if(isset($_POST['lastname'])){
			$lastname = $_POST['lastname'];
		}

		if(isset($_POST['email'])){
			$email = $_POST['email'];
		}
		

		if(isset($_FILES['profile_file']) && $_FILES['profile_file']['name'] != ''){
			//upload identification image
			$filename = 'avatar-'.$userData['userId'].".".pathinfo($_FILES['profile_file']['name'], PATHINFO_EXTENSION);
			
			move_uploaded_file($_FILES['profile_file']['tmp_name'], __DIR__.'/profiles/'.$filename);
			$profile_img = 'profiles/'.$filename;
		}
		else{
			$profile_img = $userData['profile'];
		}
	}
	else{
		$username = $userData['userName'];
		$firstname = $userData['firstName'];
		$lastname = $userData['lastName'];
		$email = $userData['userEmail'];
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
										<div class="profile-avatar__img <?php echo $profile_img == '' ? "no-image": "" ?>" id="profile_preview_img" style="background-image: url('<?php echo $profile_img."?v=".time()?>')">
											<span>No Image</span>
										</div>
										<input type="file" name="profile_file" accept="image/*" id="profile_file" style="display: none">
										<input type="hidden" id="profile_image">
									</div>
									<div class="form-group">
										<div class="input-group">
											<div class="input-group-prepend">
												<span class="input-group-text">
												<i class="mdi mdi-account-outline"></i>
												</span>
											</div>
											<input type="text" name="username" class="form-control" placeholder="Username" value="<?php echo $username?>">
										</div>
										<?php
											if(isset($_POST['submit']) && empty($_POST['username'])) {
											  $submit_error = true;
											  ?>
										    <div class="error mt-2 text-danger" for="username">Please fill in your username</div>
										<?php
											}
											?>
									</div>
									<div class="form-group">
										<div class="input-group">
											<div class="input-group-prepend">
												<span class="input-group-text">
												<i class="mdi mdi-account-outline"></i>
												</span>
											</div>
											<input type="text" name="email" class="form-control" placeholder="Email" value="<?php echo $email ?>">
										</div>
										<?php
											if(isset($_POST['submit']) && empty($_POST['email'])) {
											  $submit_error = true;
											  ?>
										    <div class="error mt-2 text-danger" for="email">Please fill in your email</div>
										<?php
											}
											else if(isset($_POST['submit']) && !filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)){
												$submit_error = true;
												?>
												<div class="error mt-2 text-danger" for="email">Please fill in correct email format</div>
												<?php
											}
											else if(isset($_POST['submit']) && filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)){
												$domain = array_pop(explode('@', $_POST['email']));
												if($domain != 'uowmail.edu.au'){
												$submit_error = true;
												?>
												<div class="error mt-2 text-danger" for="email">This domain doesn't allow to reigster</div>
												<?php
												}
											}
											?>
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
												<i class="mdi mdi-lock-outline"></i>
												</span>
											</div>
											<input type="password" name="password" class="form-control" placeholder="Password" value="<?php echo isset($_POST['password']) ? $_POST['password'] : "" ?>">
										</div>
										<?php
											if(isset($_POST['submit']) && empty($_POST['password'])) {
											  $submit_error = true;
											  ?>
										    <div class="error mt-2 text-danger" for="password">Please fill in your password</div>
										<?php
											}
											?>
									</div>
									<div class="form-group">
										<div class="input-group">
											<div class="input-group-prepend">
												<span class="input-group-text">
												<i class="mdi mdi-lock-outline"></i>
												</span>
											</div>
											<input type="password" name="confirm_password" class="form-control" placeholder="Confirm Password" value="<?php echo isset($_POST['confirm_password']) ? $_POST['confirm_password'] : "" ?>">
										</div>
										<?php
											if(isset($_POST['submit']) && empty($_POST['confirm_password'])) {
											  $submit_error = true;
											  ?>
										    <div class="error mt-2 text-danger" for="confirm_password">Please fill in your confirm password</div>
										<?php
											}
											if(isset($_POST['submit']) && isset($_POST['password']) && isset($_POST['confirm_password']) && $_POST['password'] !="" && $_POST['confirm_password'] != "" && $_POST['password'] != $_POST['confirm_password']) {
											  $submit_error = true;
											  ?>
										    <div class="error mt-2 text-danger" for="confirm_password">Passwords don't match</div>
										<?php
											}
											?>
									</div>
									<div class="form-group">
										<input type="submit" name="submit" class="btn btn-primary submit-btn" value="Update" />
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
    <?php
    if(isset($_POST['submit']) && !$submit_error){
      $username = mysqli_real_escape_string( $dbConnect, $_POST['username'] );
      $email = mysqli_real_escape_string( $dbConnect, $_POST['email'] );
      $password = mysqli_real_escape_string( $dbConnect, $_POST['password'] );
	  $firstname = mysqli_real_escape_string( $dbConnect, $_POST['firstname'] );
	  $lastname = mysqli_real_escape_string( $dbConnect, $_POST['lastname'] );
	  $profile = $profile_img;
	//   if(isset($_FILES['profile_file']) && $_FILES['profile_file']['name'] != ''){
	// 	//upload identification image

	// 	$filename = 'avatar-'.$userData('userId').".".pathinfo($_FILES['profile_file']['name'], PATHINFO_EXTENSION);
			
	// 	move_uploaded_file($_FILES['profile_file']['tmp_name'], __DIR__.'/profiles/'.$filename);
	// 	$profile = 'profiles/'.$filename;
	// }

      $result = mysqli_query($dbConnect, "UPDATE bmwusers SET userName='".$username."', userEmail='".$email."', userPass='".md5($password)."', firstName='".$firstname."', lastName='".$lastname."', profile='".$profile."' WHERE userId='".$userData['userId']."'");
      if($result){
        ?>
        <script>
          swal({
            title: '',
            text: 'Success!',
            icon: 'success',
            button: {
              text: "OK",
              value: true,
              visible: true,
              className: "btn btn-primary"
            }
          })
        </script>
        <?php
      }
    }
    ?>
	</body>
</html>