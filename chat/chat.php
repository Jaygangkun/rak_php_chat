<div class="row">
              <div class="col-md-12">
                
                <div class="card chat-app-wrapper">
                  <div class="row mx-0">
                    <div class="col-lg-3 col-md-4 chat-list-wrapper px-0">
                      <div class="sidebar-spacer">
                        <div class="input-group chat-search-input">
                          <input type="text" class="form-control" id="searchRooms" placeholder="Search Rooms" aria-label="Username">
                          <div class="input-group-append">
                            <span class="input-group-text 
                                ">
                              <i class="mdi mdi-magnify"></i>
                            </span>
                          </div>
                        </div>
                      </div>
					   <div class="chat-list-item-wrapper" id="newRooms" style="display: none;">
						<div class="list-item">
                          <div class="profile-image">
                            <div class="dot-indicator sm bg-success"></div>
                            <img class="img-sm rounded-circle" src="assets/images/faces/c.png"></img>
                          </div>
                          <p class="user-name">CSC1321</p>
                          <p class="chat-time">30min ago</p>
                          <p class="chat-text"><button type="button" class="btn btn-outline-primary btn-fw addRoom">
                            <i class="mdi mdi-plus" id=""></i>Join Room</button></p>
                        </div>
					  </div>
                      <div class="chat-list-item-wrapper" id="currentRooms" style="display: block;">
						<?
						function timeAgo($timestamp){
							$datetime1=new DateTime("now");
							$datetime2=new DateTime("@$timestamp");
							$diff=date_diff($datetime1, $datetime2);
							$timemsg='';
							if($diff->y > 0){
								$timemsg = $diff->y .' year'. ($diff->y > 1?"'s":'');

							}
							else if($diff->m > 0){
							 $timemsg = $diff->m . ' month'. ($diff->m > 1?"'s":'');
							}
							else if($diff->d > 0){
							 $timemsg = $diff->d .' day'. ($diff->d > 1?"'s":'');
							}
							else if($diff->h > 0){
							 $timemsg = $diff->h .' hour'.($diff->h > 1 ? "'s":'');
							}
							else if($diff->i > 0){
							 $timemsg = $diff->i .' minute'. ($diff->i > 1?"'s":'');
							}
							else if($diff->s > 0){
							 $timemsg = $diff->s .' second'. ($diff->s > 1?"'s":'');
							}

						$timemsg = $timemsg.' ago';
						return $timemsg;
						}
						$getCurrentRooms = mysqli_query($dbConnect, "SELECT `memberRoomId` FROM `roomMembers` WHERE `memberUserId` = '".$_SESSION['chatUserId']."' GROUP BY `memberRoomId` ORDER  BY memberRoomId DESC");
						while($roomMemberData = mysqli_fetch_assoc( $getCurrentRooms )) {
							$getRoomData = mysqli_query($dbConnect, "SELECT * FROM `chatRooms` WHERE `roomId` = '".$roomMemberData['memberRoomId']."'");
              if(mysqli_num_rows( $getRoomData ) == 0){
                continue;
              }
							$roomData = mysqli_fetch_assoc( $getRoomData );
							$getLastMessage = mysqli_query($dbConnect, "SELECT `messageText`, `messageUserId`, `messageTime` FROM `roomMessages` WHERE `messageRoomId` = '".$roomMemberData['memberRoomId']."' ORDER BY `messageId` DESC");
							if(mysqli_num_rows( $getLastMessage ) > 0) {
								$lastMessageData = mysqli_fetch_assoc( $getLastMessage );
								$lastMessage = $lastMessageData['messageText'];
								$messageTime = timeAgo($lastMessageData['messageTime']);
							}
							else {
								$lastMessage = 'No recent messages';
								$messageTime = '';
							}
							?>
							<div class="list-item openChat" id="<? echo $roomMemberData['memberRoomId']; ?>">
								<div class="profile-image">
									<div class="dot-indicator sm bg-success"></div>
									<img class="img-sm rounded-circle" src="<? echo $roomData['roomImg']; ?>"></img>
								</div>
                <div class="list-item-right">
								<p class="user-name chat-room-name"><span><? echo $roomData['roomName']; ?></span>
                <?php
                if($roomData['customRoom'] != '1'){
                  ?>
                  <img class="chat-room-offical-icon" src="assets/images/icon-official.svg"></p>
                  <?php
                }
                ?>
								<p class="chat-time">
									<i class="mdi mdi-window-close btn-outline-danger closeRoom" id="<? echo $roomMemberData['memberRoomId']; ?>"></i>
								</p>
								<p class="chat-text"><? echo $lastMessage; ?></p>
                </div>
							</div>
							<?
						}
						?>
            
						<div style="display: none;">
                        <div class="list-item">
                          <div class="profile-image">
                            <div class="dot-indicator sm bg-success"></div>
                            <img class="img-sm rounded-circle" src="assets/images/faces/c.png"></img>
                          </div>
                          <p class="user-name">CSC1321</p>
                          <p class="chat-time">30min ago</p>
                          <p class="chat-text">Hi, Who has the homework for tomorrow?</p>
                        </div>
                        <div class="list-item">
                          <div class="profile-image">
                            <div class="dot-indicator sm bg-primary"></div>
                            <img class="img-sm rounded-circle" src="assets/images/faces/face5.png"></img>
                          </div>
                          <p class="user-name">ETCE451</p>
                          <p class="chat-time">1 day ago</p>
                          <p class="chat-text">I think i blew up my laptop today</p>
                        </div>
                        <div class="list-item">
                          <div class="profile-image">
                            <div class="dot-indicator sm bg-primary"></div>
                            <img class="img-sm rounded-circle" src="assets/images/faces/chess.png"></img>
                          </div>
                          <p class="user-name">UOWD Chess Club</p>
                          <p class="chat-time">2 days ago</p>
                          <p class="chat-text">I feel like the king today!</p>
                        </div>
                        <div class="list-item">
                          <div class="profile-image">
                            <div class="dot-indicator sm bg-warning"></div>
                            <img class="img-sm rounded-circle" src="assets/images/faces/math.png"></img>
                          </div>
                          <p class="user-name">We love math</p>
                          <p class="chat-time">3.14 days ago</p>
                          <p class="chat-text">Can't count on these girls these days</p>
                        </div>
                        <div class="list-item">
                          <div class="profile-image">
                            <img class="img-sm rounded-circle" src="assets/images/faces/l.png"></img>
                          </div>
                          <p class="user-name">Lambert</p>
                          <p class="chat-time">4 days ago</p>
                          <p class="chat-text">Hello, this is an invitation from one of the most interesting teams... </p>
                        </div>
						</div>
                      </div>
                      <div class="sidebar-spacer">
                        <button class="btn btn-block btn-success py-3" type="button" data-toggle="modal" data-target="#newChatRoomModal">+ New Chat</button>
                      </div>
                    </div>
                    <div class="col-lg-6 col-md-8 px-0 d-flex flex-column">
                      <div class="chat-container-wrapper" id="chatRoom">
						<?
						$getCurrentMessages = mysqli_query($dbConnect, "SELECT `messageText`, `messageUserId` FROM `roomMessages` WHERE `messageRoomId` = '".$roomId."'");
						$lastMessageUserId = '';
						while($messagesData = mysqli_fetch_assoc( $getCurrentMessages )) {
							if($messagesData['messageUserId'] == $_SESSION['chatUserId']) {
								?>
								<div class="chat-bubble outgoing-chat" <?if($lastMessageUserId == $messagesData['messageUserId']) {?>style="margin-top: 2px;"<?}?>>
									<div class="chat-message">
										<p><? echo $messagesData['messageText']; ?></p>
									</div>
								</div>
								<?
								$lastMessageUserId = $messagesData['messageUserId'];
							}
							else {
								$getMessageUserData = mysqli_query($dbConnect, "SELECT `userName`, `userEmail`, `profile` FROM `bmwusers` WHERE `userId` = '".$messagesData['messageUserId']."'");
								$messageUserData = mysqli_fetch_assoc( $getMessageUserData );
								?>
								<div class="chat-bubble incoming-chat" <?if($lastMessageUserId == $messagesData['messageUserId']) {?>style="margin-top: 2px;"<?}?>>
                  <div class="chat-bubble-left">
                    <?if($lastMessageUserId != $messagesData['messageUserId']) {?>
                      <?php $profile_img = $messageUserData['profile'];?>
                    <div class="chat-user__img" data-toggle="tooltip" data-placement="top" title="<?php echo $messageUserData['userEmail']?>" style="background-image: url('<?php echo $profile_img != '' ? $profile_img."?v=".time() : "assets/images/avatar-default.png" ?>')"></div>
                    <?}?>
                  </div>
                  <div class="chat-bubble-right"  <?if($lastMessageUserId == $messagesData['messageUserId']) {?>style="margin-left: 60px;"<?}?>>
                    <div class="chat-message">
                    <?if($lastMessageUserId != $messagesData['messageUserId']) {?>
                      <p class="chat-user__email"><? echo $messageUserData['userName']; ?></p>
                    <?}?>
                    <p><? echo $messagesData['messageText']; ?></p>
                    </div>
                  </div>
								</div>
								<?
								$lastMessageUserId = $messagesData['messageUserId'];
							}
						}
						?>
                      </div>
                      <div class="chat-text-field mt-auto">
                          <div class="input-group">
                            <input type="text" class="form-control" id="sendChat" placeholder="Type a message here">
                            <div class="input-group-append" id="submitChat">
                              <button type="submit" class="input-group-text"><i class="mdi mdi-send icon-sm"></i></b>
                            </div>
                          </div>
                      </div>
                    </div>
                    <div class="col-lg-3 d-none d-lg-block px-0 chat-sidebar" style="opacity: 0;">
                      <img class="img-fluid w-100" src="assets/images/chat/profile_image.jpg" alt="profile image">
                      <div class="px-4">
                        <div class="d-flex pt-4">
                          <div class="wrapper">
                            <h5 class="font-weight-medium mb-0 ellipsis">Cecelia Benson</h5>
                            <p class="mb-0 text-muted ellipsis">General manager</p>
                          </div>
                          <div class="badge badge-inverse-success mb-auto ml-auto">Online</div>
                        </div>
                        <div class="pt-3">
                          <div class="d-flex align-items-center py-1">
                            <i class="mdi mdi-whatsapp mr-2"></i>
                            <p class="mb-0 font-weight-medium">225-248-4861</p>
                          </div>
                          <div class="d-flex align-items-center py-1">
                            <i class="mdi mdi-email-outline mr-2"></i>
                            <p class="mb-0 font-weight-medium ellipsis">cecilia.tromp@danny.com</p>
                          </div>
                          <div class="d-flex align-items-center py-1">
                            <i class="mdi mdi-map-marker-outline mr-2"></i>
                            <p class="mb-0 font-weight-medium ellipsis">United Kingdom</p>
                          </div>
                        </div>
                        
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
    <div class="modal fade" id="newChatRoomModal" tabindex="-1" role="dialog" aria-labelledby="newChatRoomModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="newChatRoomModalLabel">New Chat</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
                  <div class="input-group">
                      <input type="text" class="form-control" placeholder="Room Name" id="chatRoomName">
                  </div>
                  <div class="error mt-2 text-danger" for="chatRoomName" id="chatRoomError" style="display: none">Please Input Room Name</div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="button" class="btn btn-primary" id="btn_create_room">Create</button>
      </div>
    </div>
  </div>
</div>
<script>
  jQuery(document).on('click', '#btn_create_room', function(){

    if(jQuery('#chatRoomName').val() == ''){
      jQuery('#chatRoomError').show();
      return;
    }
    else{
      jQuery('#chatRoomError').hide();
    }
    
    jQuery.post('js/newChatRoom.php', {roomName: jQuery('#chatRoomName').val()}, function(response) {
      response = JSON.parse(response);
      if(response.success) {

        var newRoomHtml = '<div class="list-item openChat" id="' + response.roomId + '">';
        newRoomHtml = newRoomHtml + '<div class="profile-image">';
        newRoomHtml = newRoomHtml + '<div class="dot-indicator sm bg-success"></div>';
        newRoomHtml = newRoomHtml + '<img class="img-sm rounded-circle" src="assets/images/faces/c.png"></img>';
        newRoomHtml = newRoomHtml + '</div>';
        newRoomHtml = newRoomHtml + '<p class="user-name chat-room-name"><span>' + jQuery('#chatRoomName').val() + '</span></p>';
        newRoomHtml = newRoomHtml + '<p class="chat-time">';
        newRoomHtml = newRoomHtml + '<i class="mdi mdi-window-close btn-outline-danger closeRoom" id="' + response.roomId + '"></i>';
        newRoomHtml = newRoomHtml + '        </p>';
        newRoomHtml = newRoomHtml + '<p class="chat-text">No recent messages</p></div>';

        jQuery('#currentRooms').prepend(newRoomHtml);

        jQuery('#newChatRoomModal').modal('toggle');

        swal({
          title: '',
          text: 'Created Successfully!',
          icon: 'success',
          button: {
            text: "OK",
            value: true,
            visible: true,
            className: "btn btn-primary"
          }
        })
      }
    });
  })
  </script>