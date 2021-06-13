<?
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
				<?
				if(isset($_POST['register'])) {
					$canRegister = 1;
					if(empty($_POST['username'])) {
						$canRegister = 0;
						?>
						<div class="meldingHolder meldingWarning" style="margin: 0;">Please fill in your username</div>
						<br />
						<br />
						<?
					}
					if(empty($_POST['email'])) {
						$canRegister = 0;
						?>
						<div class="meldingHolder meldingWarning" style="margin: 0;">Please fill in your email</div>
						<br />
						<br />
						<?
					}
					if(empty($_POST['password'])) {
						$canRegister = 0;
						?>
						<div class="meldingHolder meldingWarning" style="margin: 0;">Please fill in your password</div>
						<br />
						<br />
						<?
					}
					if(empty($_POST['confirmPassword'])) {
						$canRegister = 0;
						?>
						<div class="meldingHolder meldingWarning" style="margin: 0;">Please confirm your password</div>
						<br />
						<br />
						<?
					}
					if($_POST['password'] != $_POST['confirmPassword']) {
						$canRegister = 0;
						?>
						<div class="meldingHolder meldingWarning" style="margin: 0;">Passwords don't match</div>
						<br />
						<br />
						<?
					}
					if($canRegister == 1) {
						$username = mysqli_real_escape_string( $dbConnect, $_POST['username'] );
						$email = mysqli_real_escape_string( $dbConnect, $_POST['email'] );
						$password = mysqli_real_escape_string( $dbConnect, $_POST['password'] );
					}
				}
				?>
                <form method="POST">
                  <h3 class="mr-auto">Register</h3>
                  <p class="mb-5 mr-auto">Enter your details below.</p>
                  <div class="form-group">
                    <div class="input-group">
                      <div class="input-group-prepend">
                        <span class="input-group-text">
                          <i class="mdi mdi-account-outline"></i>
                        </span>
                      </div>
                      <input type="text" name="username" class="form-control" placeholder="Username">
                    </div>
                  </div>
				  <div class="form-group">
                    <div class="input-group">
                      <div class="input-group-prepend">
                        <span class="input-group-text">
                          <i class="mdi mdi-account-outline"></i>
                        </span>
                      </div>
                      <input type="text" name="email" class="form-control" placeholder="Email">
                    </div>
                  </div>
                  <div class="form-group">
                    <div class="input-group">
                      <div class="input-group-prepend">
                        <span class="input-group-text">
                          <i class="mdi mdi-lock-outline"></i>
                        </span>
                      </div>
                      <input type="password" name="password" class="form-control" placeholder="Password">
                    </div>
                  </div>
                  <div class="form-group">
                    <div class="input-group">
                      <div class="input-group-prepend">
                        <span class="input-group-text">
                          <i class="mdi mdi-lock-outline"></i>
                        </span>
                      </div>
                      <input type="password" name="confirmPassword" class="form-control" placeholder="Confirm Password">
                    </div>
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
    <script src="assets/js/shared/off-canvas.js"></script>
    <script src="assets/js/shared/hoverable-collapse.js"></script>

    <script src="assets/js/shared/settings.js"></script>
    <script src="assets/js/shared/todolist.js"></script>
    <!-- endinject -->
    <!-- Custom js for this page -->
    <!-- End custom js for this page -->
  </body>
</html>