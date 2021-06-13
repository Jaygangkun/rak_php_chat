<?php

// Just Destroy Everything lol
session_start();
setcookie(session_name(), '', 100);
session_unset();
session_destroy();
$_SESSION = array();

// Include URL for Login page to login again.
header("Location: login.php");
exit;
?>

