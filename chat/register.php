<?php
	include('includeDatabase.php');
	?>
<!DOCTYPE html>
<html lang="en">
	<head>
		<!-- Required meta tags -->
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
		<title>Register</title>
		<!-- plugins:css -->
		<link rel="stylesheet" href="assets/vendors/mdi/css/materialdesignicons.min.css">
		<link rel="stylesheet" href="assets/vendors/flag-icon-css/css/flag-icon.min.css">
		<link rel="stylesheet" href="assets/vendors/ti-icons/css/themify-icons.css">
		<link rel="stylesheet" href="assets/vendors/typicons/typicons.css">
		<link rel="stylesheet" href="assets/vendors/css/vendor.bundle.base.css">
		<link rel="stylesheet" href="style.css">
		<!-- endinject -->
		<!-- Plugin css for this page -->
		<!-- End Plugin css for this page -->
		<!-- inject:css -->
		<link rel="stylesheet" href="assets/css/shared/style.css">
		<!-- endinject -->
		<!-- Layout styles -->
		<link rel="stylesheet" href="assets/css/demo_1/style.css">
		<!-- End Layout styles -->
		<link rel="shortcut icon" href="assets/images/favicon.png" />
	</head>
	<body>
		<div class="container-scroller">
			<div class="container-fluid page-body-wrapper full-page-wrapper">
				<div class="content-wrapper auth p-0 theme-two">
					<div class="row d-flex align-items-stretch">
						<div class="col-md-4 banner-section d-none d-md-flex align-items-stretch justify-content-center">
							<div class="slide-content bg-2"> </div>
						</div>
						<div class="col-12 col-md-8 h-100 bg-white">
							<div class="auto-form-wrapper d-flex align-items-center justify-content-center flex-column">
								<div class="nav-get-started">
									<p>Already have an account?</p>
									<a class="btn get-started-btn" href="login.php">SIGN IN</a>
								</div>
								<?php
                $submit_error = false;
									?>
								<form method="POST">
									<h3 class="mr-auto">Register</h3>
									<p class="mb-3 mr-auto">Enter your details below.</p>
									<div class="form-group">
										<div class="input-group">
											<div class="input-group-prepend">
												<span class="input-group-text">
												<i class="mdi mdi-account-outline"></i>
												</span>
											</div>
											<input type="text" name="email" class="form-control" placeholder="Email" value="<?php echo isset($_POST['email']) ? $_POST['email'] : "" ?>">
										</div>
										<?php
											if(isset($_POST['register']) && empty($_POST['email'])) {
											  $submit_error = true;
											  ?>
										    <div class="error mt-2 text-danger" for="email">Please fill in your email</div>
										<?php
											}
                      else if(isset($_POST['register']) && !filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)){
                        $submit_error = true;
                        ?>
                        <div class="error mt-2 text-danger" for="email">Please fill in correct email format</div>
                        <?php
                      }
                      else if(isset($_POST['register']) && filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)){
                        $emails = explode('@', $_POST['email']);
                        $domain = array_pop($emails);
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
												<i class="mdi mdi-lock-outline"></i>
												</span>
											</div>
											<input type="text" name="firstname" class="form-control" placeholder="First Name" value="<?php echo isset($_POST['firstname']) ? $_POST['firstname'] : "" ?>">
										</div>
										<?php
											if(isset($_POST['register']) && empty($_POST['firstname'])) {
											  $submit_error = true;
											  ?>
										    <div class="error mt-2 text-danger" for="password">Please fill in your First Name</div>
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
											<input type="text" name="lastname" class="form-control" placeholder="Last Name" value="<?php echo isset($_POST['lastname']) ? $_POST['lastname'] : "" ?>">
										</div>
										<?php
											if(isset($_POST['register']) && empty($_POST['lastname'])) {
											  $submit_error = true;
											  ?>
										    <div class="error mt-2 text-danger" for="lastname">Please fill in your Last Name</div>
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
											<input type="password" name="password" class="form-control" placeholder="Password" value="<?php echo isset($_POST['password']) ? $_POST['password'] : "" ?>">
										</div>
										<?php
											if(isset($_POST['register']) && empty($_POST['password'])) {
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
											if(isset($_POST['register']) && empty($_POST['confirm_password'])) {
											  $submit_error = true;
											  ?>
										    <div class="error mt-2 text-danger" for="confirm_password">Please fill in your confirm password</div>
										<?php
											}
											if(isset($_POST['register']) && isset($_POST['password']) && isset($_POST['confirm_password']) && $_POST['password'] !="" && $_POST['confirm_password'] != "" && $_POST['password'] != $_POST['confirm_password']) {
											  $submit_error = true;
											  ?>
										    <div class="error mt-2 text-danger" for="confirm_password">Passwords don't match</div>
										<?php
											}
											?>
									</div>
									<div class="form-group">
										<input type="submit" name="register" class="btn btn-primary submit-btn" value="REGISTER" />
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
		<!-- plugins:js -->
		<script src="assets/vendors/js/vendor.bundle.base.js"></script>
		<!-- endinject -->
		<!-- Plugin js for this page -->
		<!-- End plugin js for this page -->
		<!-- inject:js -->
    <script src="assets/vendors/sweetalert/sweetalert.min.js"></script>
		<script src="assets/js/shared/off-canvas.js"></script>
		<script src="assets/js/shared/hoverable-collapse.js"></script>
		<script src="assets/js/shared/settings.js"></script>
		<script src="assets/js/shared/todolist.js"></script>
		<!-- endinject -->
		<!-- Custom js for this page -->
		<!-- End custom js for this page -->
    <?php
    if(isset($_POST['register']) && !$submit_error){
      $firstname = mysqli_real_escape_string( $dbConnect, $_POST['firstname'] );
      $lastname = mysqli_real_escape_string( $dbConnect, $_POST['lastname'] );
      $username = $firstname.' '.$lastname;
      $email = mysqli_real_escape_string( $dbConnect, $_POST['email'] );
      $password = mysqli_real_escape_string( $dbConnect, $_POST['password'] );
      $result = mysqli_query($dbConnect, "INSERT INTO bmwUsers( userPass, userName, userEmail, userAdmin, userTeacher, firstName, lastName) VALUES('".md5($password)."', '".$username."', '".$email."', '0', '0', '".$firstname."', '".$lastname."')");
      if($result){
        ?>
        <script>
          swal({
            title: '',
            text: 'Account successfully registered!',
            icon: 'success',
            button: {
              text: "OK",
              value: true,
              visible: true,
              className: "btn btn-primary"
            }
          }).then(() => {
            location.href = 'login.php';
          })
        </script>
        <?php
      }
    }
    ?>
	</body>
</html>