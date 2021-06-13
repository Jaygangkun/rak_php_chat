<?
ini_set('session.gc_maxlifetime', 30*60);
session_start();
include('includeDatabase.php');

if(!isset($_SESSION['chatUserId']) || empty($_SESSION['chatUserId'])) {
	header("Location: https://195.201.99.166/chat/login.php");
}
$lastMessageId = 0;
$getUserData = mysqli_query($dbConnect, "SELECT `userName`, `userId`, `userEmail` FROM `bmwUsers` WHERE `userId` = '".$_SESSION['chatUserId']."'");
$userData = mysqli_fetch_assoc( $getUserData );
if(isset($_GET['roomId']) && !empty($_GET['roomId'])) {
	$roomId = mysqli_real_escape_string( $dbConnect, $_GET['roomId'] );
	$getLastMessage = mysqli_query($dbConnect, "SELECT `messageId` FROM `roomMessages` WHERE `messageRoomId` = '".$roomId."' ORDER BY `messageId` DESC");
	if(mysqli_num_rows( $getLastMessage ) > 0) {
		$lastMessageData = mysqli_fetch_assoc( $getLastMessage );
		$lastMessageId = $lastMessageData['messageId'];
	}
}
else {
	$roomId = 0;
	$lastMessageId = 0;
}
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
	<base href="http://195.201.99.166/chat/">
    <title>UOWD Chat</title>
    <!-- plugins:css -->
    <link rel="stylesheet" href="assets/vendors/mdi/css/materialdesignicons.min.css">
    <link rel="stylesheet" href="assets/vendors/flag-icon-css/css/flag-icon.min.css">
    <link rel="stylesheet" href="assets/vendors/ti-icons/css/themify-icons.css">
    <link rel="stylesheet" href="assets/vendors/typicons/typicons.css">
    <link rel="stylesheet" href="assets/vendors/css/vendor.bundle.base.css">
    <link rel="stylesheet" href="style.css">
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
	<script type="text/javascript">
		currentChatRoomId = <? echo $roomId; ?>;
		lastMessageId = <? echo $lastMessageId; ?>;
		jQuery(document).ready(function() {
			canOpenChat = 1;
			jQuery(".closeRoom").click(function() {
				canOpenChat = 0;
				var thisRoomId = jQuery(this).attr('id');
				jQuery.post('js/removeRoom.php', {roomId: thisRoomId}, function(removeData) {
					window.location.href = "/chat/"; 
				});
			});
			jQuery('#chatRoom').scrollTop($('#chatRoom')[0].scrollHeight - $('#chatRoom')[0].clientHeight);
			jQuery("body").on("click", ".addRoom", function() {
				var thisRoomId = jQuery(this).attr('id');
				jQuery.post('js/addRoom.php', {roomId: thisRoomId}, function(addData) {
					window.location.href = "/chat/room/" + thisRoomId + "/";
				});
			});
			jQuery("#searchRooms").on("keyup change", function(e) {
				var thisSearch = jQuery(this).val();
				jQuery.post('js/searchRooms.php', {roomName: thisSearch}, function(searchData) {
					jQuery("#currentRooms").hide();
					jQuery("#newRooms").show();
					jQuery("#newRooms").html("");
					searchData.forEach(function(roomData) {
						jQuery("#newRooms").append('<div class="list-item"><div class="profile-image"><img class="img-sm rounded-circle" src="' + roomData[2] + '"></img></div><p class="user-name">' + roomData[1] + '</p><p class="chat-time">' + roomData[3] + ' members</p><p class="chat-text"><button type="button" class="btn btn-outline-primary btn-fw addRoom" id="' + roomData[0] + '"><i class="mdi mdi-plus"></i>Join Room</button></p></div>');
					});
				}, "json");
			});
			jQuery("#sendChat").keypress(function(e) {
				if(e.which == 13) {
					var thisMessage = jQuery(this).val();
					jQuery("#sendChat").val('');
					jQuery.post('js/sendChat.php', {roomId: currentChatRoomId, sendMessage: thisMessage}, function(sendData) {
						jQuery("#chatRoom").append('<div class="chat-bubble outgoing-chat"><div class="chat-message"><p>' + thisMessage + '</p></div></div>');
						jQuery("#chatRoom").animate({
						  scrollTop: $('#chatRoom')[0].scrollHeight - $('#chatRoom')[0].clientHeight
						}, 1000);
					});
				}
			});
			jQuery("#submitChat").click(function() {
				var thisMessage = jQuery("#sendChat").val();
				jQuery("#sendChat").val('');
				jQuery.post('js/sendChat.php', {roomId: currentChatRoomId, sendMessage: thisMessage}, function(sendData) {
					jQuery("#chatRoom").append('<div class="chat-bubble outgoing-chat"><div class="chat-message"><p>' + thisMessage + '</p></div></div>');
					jQuery("#chatRoom").animate({
					  scrollTop: $('#chatRoom')[0].scrollHeight - $('#chatRoom')[0].clientHeight
					}, 1000);
				});
			})
			jQuery(".openChat").click(function() {
				if(canOpenChat == 1) {
					var thisRoomId = jQuery(this).attr('id');
					window.location.href = "/chat/room/" + thisRoomId + "/";
				}
			});
			jQuery(".content-wrapper").on("swiperight", function() {
				jQuery("#openAllChats").click();
			});
		});
		document.addEventListener('touchstart', handleTouchStart, false);        
		document.addEventListener('touchmove', handleTouchMove, false);

		var xDown = null;                                                        
		var yDown = null;
		
		chatListIsOpen = 0;
		
		function getTouches(evt) {
		  return evt.touches ||             // browser API
				 evt.originalEvent.touches; // jQuery
		}                                                     

		function handleTouchStart(evt) {
			const firstTouch = getTouches(evt)[0];                                      
			xDown = firstTouch.clientX;                                      
			yDown = firstTouch.clientY;                                      
		};                                                

		function handleTouchMove(evt) {
			if ( ! xDown || ! yDown ) {
				return;
			}

			var xUp = evt.touches[0].clientX;                                    
			var yUp = evt.touches[0].clientY;

			var xDiff = xDown - xUp;
			var yDiff = yDown - yUp;

			if ( Math.abs( xDiff ) > Math.abs( yDiff ) ) {
				if ( xDiff > 0 ) {
					if(chatListIsOpen == 1) {
						chatListIsOpen = 0;
						jQuery("#openAllChats").click();
					}
				} else {
					if(chatListIsOpen == 0) {
						chatListIsOpen = 1;
						jQuery("#openAllChats").click();
					}
				}                       
			}
			
			xDown = null;
			yDown = null;                                             
		};
		
		window.setInterval(function(){
			jQuery.post('js/checkMessages.php', {roomId: currentChatRoomId, lastMessage: lastMessageId}, function(messagesData) {
				messagesData.forEach(function(messageData) {
					jQuery("#chatRoom").append('<div class="chat-bubble incoming-chat"><div class="chat-message"><p class="font-weight-bold">' + messageData[1] + '</p><p>' + messageData[0] + '</p></div></div>');
					lastMessageId = messageData[2];
					jQuery("#chatRoom").animate({
					  scrollTop: $('#chatRoom')[0].scrollHeight - $('#chatRoom')[0].clientHeight
					}, 1000);
				});
			}, "json");
		}, 1000);
	</script>
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
  <body class="sidebar-fixed">
    <div class="container-scroller">
      <!-- partial:../../partials/_navbar.html -->
      <nav class="navbar default-layout col-lg-12 col-12 p-0 fixed-top d-flex flex-row">
        <div class="text-center navbar-brand-wrapper d-flex align-items-top justify-content-center">
          <a class="navbar-brand brand-logo" href="/chat/">
			UOWD Chat
            <img src="assets/images/logo.svg" alt="logo" style="display: none;" /> </a>
          <a class="navbar-brand brand-logo-mini" href="/chat/">
            <img src="assets/images/faces/face8.jpg" alt="logo" /> </a>
        </div>
        <div class="navbar-menu-wrapper d-flex align-items-center">
          <button class="navbar-toggler navbar-toggler align-self-center" type="button" data-toggle="minimize">
            <span class="mdi mdi-menu"></span>
          </button>
          <ul class="navbar-nav">
           
          </ul>
          <form class="ml-auto search-form d-none d-md-block" action="#">
          
          </form>
          <ul class="navbar-nav ml-auto">
            <li class="nav-item dropdown" style="display: none;">
              <a class="nav-link count-indicator" id="chat-toggler" href="javascript:void(0);" aria-expanded="false">
                <i class="mdi mdi-chat-processing"></i>
                
              </a>
            </li>
			 <li class="nav-item dropdown">
              <a class="nav-link count-indicator aside-toggler" id="openAllChats" href="javascript:void(0);" aria-expanded="false">
                <i class="mdi mdi-chat-processing"></i>
                
              </a>
            </li>
            
            <li class="nav-item dropdown d-none d-xl-inline-block user-dropdown">
              <a class="nav-link dropdown-toggle" id="UserDropdown" href="#" data-toggle="dropdown" aria-expanded="false">
                <img class="img-xs rounded-circle" src="assets/images/faces/face8.jpg" alt="Profile image"> </a>
              <div class="dropdown-menu dropdown-menu-right navbar-dropdown" aria-labelledby="UserDropdown">
                <div class="dropdown-header text-center">
                  <img class="img-md rounded-circle" src="assets/images/faces/face8.jpg" alt="Profile image">
                  <p class="mb-1 mt-3 font-weight-semibold"><? echo $userData['userName']; ?></p>
                  <p class="font-weight-light text-muted mb-0"><? echo $userData['userEmail']; ?></p>
                </div>
                <a class="dropdown-item"><i class="dropdown-item-icon mdi mdi-account-outline text-primary"></i> My Profile</a>
                <a class="dropdown-item" href="logout.php"><i class="dropdown-item-icon mdi mdi-power text-primary"></i>Sign Out</a>
              </div>
            </li>
          </ul>
          <button class="navbar-toggler navbar-toggler-right d-lg-none align-self-center" type="button" data-toggle="offcanvas">
            <span class="mdi mdi-menu" style=""></span>
          </button>
        </div>
      </nav>
      <!-- partial -->
      <div class="container-fluid page-body-wrapper">
        <!-- partial:../../partials/_settings-panel.html -->
        <div class="right-sidebar-toggler-wrapper" style="display: none;">
          <div class="sidebar-toggler" id="layout-toggler"><i class="mdi mdi-settings"></i></div>
          <div class="sidebar-toggler" id="chat-toggler"><i class="mdi mdi-chat-processing"></i></div>
          <div class="sidebar-toggler"><a href="http://195.201.99.166/chat/dashboard/" target="_blank"><i class="mdi mdi-file-document-outline"></i></a></div>
          <div class="sidebar-toggler"><a href="http://195.201.99.166/chat/dashboard/" target="_blank"><i class="mdi mdi-cart"></i></a></div>
        </div>
        <!-- partial -->
        <!-- partial:../../partials/_sidebar.html -->
        <nav class="sidebar sidebar-offcanvas" id="sidebar">
          <ul class="nav">
            <li class="nav-item nav-profile">
              <a href="#" class="nav-link">
                <div class="profile-image">
                  <img class="img-xs rounded-circle" src="assets/images/faces/face8.jpg" alt="profile image">
                  <div class="dot-indicator bg-success"></div>
                </div>
                <div class="text-wrapper">
                  <p class="profile-name"><? echo $userData['userName']; ?></p>
                  <p class="designation">Admin</p>
                </div>
              </a>
            </li>
            <li class="nav-item nav-category">Main Menu</li>
			<li class="nav-item">
              <a class="nav-link" href="dashboard/">
                <i class="menu-icon typcn typcn-mail"></i>
                <span class="menu-title">Dashboard</span>
              </a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="/chat/">
                <i class="menu-icon typcn typcn-mail"></i>
                <span class="menu-title">Chat</span>
              </a>
            </li>
			<li class="nav-item">
              <a class="nav-link" href="admin/">
                <i class="menu-icon typcn typcn-mail"></i>
                <span class="menu-title">Admin</span>
              </a>
            </li>
          </ul>
        </nav>
        <!-- partial -->
        <div class="main-panel">
          <div class="content-wrapper">
            <?
			if(isset($_GET['page']) && !empty($_GET['page']) && isset($_GET['sub']) && !empty($_GET['sub'])) {
				$_GET['page'] = str_replace(".php", "", $_GET['page']);
				if(file_exists($_GET['sub'] . '/' . $_GET['page'] . '.php')) {
					$loadSubPage = $_GET['sub'];
					$loadPage = $_GET['page'];
				}
				else {
					$loadPage = "chat";
				}
			}
			elseif(isset($_GET['page']) && !empty($_GET['page'])) {
				$_GET['page'] = str_replace(".php", "", $_GET['page']);
				if(file_exists($_GET['page'] . '.php')) {
					$loadPage = $_GET['page'];
				}
				else {
					$loadPage = "chat";
				}
			}
			else {
				$loadPage = "chat";
			}
			require($loadPage . '.php');
			?>
          </div>
          <!-- content-wrapper ends -->
          <!-- partial:../../partials/_footer.html -->

          <!-- partial -->
        </div>
        <!-- main-panel ends -->
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
	<script src="assets/js/shared/misc.js"></script>
    <script src="assets/js/shared/todolist.js"></script>
    <!-- endinject -->
    <!-- Custom js for this page -->
    <!-- End custom js for this page -->
  </body>
</html>