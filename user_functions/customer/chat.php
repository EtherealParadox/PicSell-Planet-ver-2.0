	<?php 
		# database connection file
		include '../messaging/helpers/chat.php';
		include '../messaging/helpers/opened.php';

		include '../messaging//helpers/timeAgo.php';

		# Getting User data data
		$chatWith = getUser($_GET['user_id'], $conn);

			if (empty($chatWith)) {
			header("Location: messaging.php");
			exit;
		}

		$chats = getChats($_SESSION['login_user_id'], $chatWith['user_id'], $conn);

		opened($chatWith['user_id'], $conn, $chats);
	?>
	<head>
		<link rel="stylesheet" href="../messaging/style.css">
	</head>

		<div class="w-400 shadow p-4 rounded">
			<h3><a href="?page=messages" style="float: left;"><i class="fa fa-arrow-left"></i></a></h3><br>

			<div class="d-flex align-items-center">
				<img src="../../images/profile-images/<?=$chatWith['user_profile_image']?>"
					class="w-15 rounded-circle" style="object-fit: cover; width: 50px; height: 50px;">

				<h3 class="display-4 fs-sm m-2">
					<?=$chatWith['user_first_name'].' '.$chatWith['user_last_name']?> <br>
					<div class="d-flex
								align-items-center"
							title="online">
						<?php
							if (last_seen($chatWith['user_last_seen']) == "Active") {
						?>
							<div class="online"></div>
							<small style="color: black !important;" class="d-block p-1">Online</small>
						<?php }else{ ?>
							<small style="color: black !important;" class="d-block p-1">
								Last Active:
								<?=last_seen($chatWith['user_last_seen'])?>
							</small>
						<?php } ?>
					</div>
				</h3>
			</div>

			<div class="shadow p-4 rounded
						d-flex flex-column
						mt-2 chat-box"
					id="chatBox">
					<?php 
						if (!empty($chats)) {
						foreach($chats as $chat){
							if($chat['sender_id'] == $_SESSION['login_user_id'])
							{ ?>
							<p class="rtext align-self-end
									border rounded p-2 mb-1">
								<?=$chat['message_content']?> 
								<small class="d-block">
									<?=date("l, h:i a", strtotime($chat['message_date']))?>
								</small>      	
							</p>
						<?php }else{ ?>
						<p class="ltext border 
								rounded p-2 mb-1">
							<?=$chat['message_content']?> 
							<small class="d-block">
								<?=date("l, h:i a", strtotime($chat['message_date']))?>
							</small>      	
						</p>
						<?php } 
						}	
					}else{ ?>
				<div style="display: flex; justify-content: center; margin-top: 10px; margin-bottom: auto;">
								<i class="fa fa-comments" style="font-size: 40px; margin-right: 10px;"></i>
					<p style="font-size: 30px;">No messages yet, Start the conversation</p>
								</div>
				<?php } ?>
			</div>
			<div class="input-group mb-3">
				<textarea cols="3"
							id="message"
							class="form-control chat-textfield"></textarea>
				<button class="sendBtn"
						id="sendBtn">
					<i class="fa fa-paper-plane"></i>
				</button>
			</div>

		</div>
	

	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

	<script>
		var scrollDown = function(){
			let chatBox = document.getElementById('chatBox');
			chatBox.scrollTop = chatBox.scrollHeight;
		}

		scrollDown();

		$(document).ready(function(){
		
		$("#sendBtn").on('click', function(){
			message_content = $("#message").val();
			if (message_content.trim() == "") return;

			$.post("../messaging/ajax/insert.php",
				{
								message_content: message_content,
								receiver_id: <?=$chatWith['user_id']?>
				},
				function(data, status){
					$("#message").val("");
					$("#chatBox").append(data);
					scrollDown();
				});
		});

		$('.chat-textfield').on('keypress', function (e) {
			if(e.which == 13 && e.shiftKey == false){
				message_content = $("#message").val();
			if (message_content.trim() == "") return;

			$.post("../messaging/ajax/insert.php",
				{
								message_content: message_content,
								receiver_id: <?=$chatWith['user_id']?>
				},
				function(data, status){
					$("#message").val("");
					$("#chatBox").append(data);
					scrollDown();
				}); 
			}
		});

		/** 
		 auto update last seen 
		for logged in user
		**/
		let lastSeenUpdate = function(){
			$.get("../messaging/ajax/update_last_seen.php");
		}
		lastSeenUpdate();
		/** 
		 auto update last seen 
		every 10 sec
		**/
		setInterval(lastSeenUpdate, 500);



		// auto refresh / reload
		let fechData = function(){
			$.post("../messaging/ajax/getMessage.php", 
				{
								receiver_id: <?=$chatWith['user_id']?>
				},
				function(data, status){
					$("#chatBox").append(data);
					if (data != "") scrollDown();
					});
		}

		fechData();
		/** 
		 auto update last seen 
		every 0.5 sec
		**/
		setInterval(fechData, 500);
		
		});
	</script>