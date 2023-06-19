			<?php
			//include 'db_connect.php';
			//include '../db_connect.php';
			
			?>
			<link rel="stylesheet" href="../../css/style_messaging.css">
			<style>
				nav{
					background-color: #114481;
				}
				.left-panel{
					width: calc(25%);
					height: calc(100% - 3rem);
					overflow: auto;
					position: fixed;
				}
				.center-panel{
					left: calc(25%);
					width: calc(75%);
					height: calc(100% - 3rem);
					overflow: auto;
					position: fixed;
				}
				.side-nav:hover, .side-nav span:hover{
					background: #114481;
					color: #fed136;
				}
				.side-nav{
					margin-right: 20px !important;
					padding-left: 50px !important;
					color: black;
					border-radius: 50px 50px 50px 50px !important;
				}
				.col-md-12:last-child{ 
					padding-bottom: 50px;
				}
				.center-panel::-webkit-scrollbar {
					display: none;
				}
			</style>
			<div class="d-flex w-100 h-100"  onload="myFunction()">
				<div class="left-panel mt-2">
					<?php ($_SESSION['login_user_type'] === "Lensman") ? $in_sess_link = "lensman" : $in_sess_link = "customer"; ?>
					<a href="<?php echo $in_sess_link ?>_dashboard.php?page=profile" class="d-flex py-4 px-1 side-nav rounded">
						<?php if(isset($_SESSION['login_user_profile_image']) && !empty($_SESSION['login_user_profile_image'])): ?>
							<div class="rounded-circle mr-1" style="width: 30px;height: 30px;top:-5px;left: -40px">
							<img src="../../images/profile-images/<?php echo $prof_img['user_profile_image'] ?>" class="image-fluid image-thumbnail rounded-circle" alt="" style="width: calc(100%);height: calc(100%); background:center; background-size: cover; object-fit: cover;">
							</div>
						<?php else: ?>
						<span class="fa fa-user mr-2" style="width: 30px;height: 30px;top:-5px;left: -40px"></span>
						<?php endif; ?>
						<span class="ml-3" style="margin-top: 4px; font-size: 20px;"><b><?php echo ucwords($_SESSION['login_user_first_name'] . ' ' . $_SESSION['login_user_last_name'])?></b></span>
					</a>
					<a href="<?php echo $in_sess_link ?>_dashboard.php?page=home" class="d-flex py-4 px-1 side-nav rounded">
						<span class="fa fa-home mr-2" style="width: 30px;height: 30px;top:-5px;left: -40px"></span>
						<span class="ml-3" style="margin-top: -1px; font-size: 20px;"><b>Home</b></span>
					</a>
					<a href="<?php echo $in_sess_link ?>_dashboard.php?page=service" class="d-flex py-4 px-1 side-nav rounded">
						<span class="fa fa-camera mr-2" style="width: 30px;height: 30px;top:-5px;left: -40px"></span>
						<span class="ml-3" style="margin-top: -1px; font-size: 20px;"><b>Service</b></span>
					</a>
					<a href="<?php echo $in_sess_link ?>_dashboard.php?page=market" class="d-flex py-4 px-1 side-nav rounded">
						<span class="fa fa-store mr-2" style="width: 30px;height: 30px;top:-5px;left: -40px"></span>
						<span class="ml-3" style="margin-top: -1px; font-size: 20px;"><b>Marketplace</b></span>
					</a>
					<a href="<?php echo $in_sess_link ?>_dashboard.php?page=map" class="d-flex py-4 px-1 side-nav rounded">
						<span class="fa fa-map mr-2" style="width: 30px;height: 30px;top:-5px;left: -40px"></span>
						<span class="ml-3" style="margin-top: -1px; font-size: 20px;"><b>Map</b></span>
					</a>
					<a href="<?php echo $in_sess_link ?>_dashboard.php?page=messages" class="d-flex py-4 px-1 side-nav rounded">
						<span class="fa fa-envelope mr-2" style="width: 30px;height: 30px;top:-5px;left: -40px"></span>
						<span class="ml-3" style="margin-top: -1px; font-size: 20px;"><b>Messages</b></span>
					</a>
					<hr>
				</div>
				<div class="center-panel py-2 px-2">

				<?php 
				include '../messaging/db_conn.php';
				include '../messaging/helpers/user.php';
				include '../messaging/helpers/conversations.php';
				include '../messaging/helpers/last_chat.php';

				if(!isset($_GET['user_id'])):
				//include '../messaging/helpers/conversations.php';

				# Getting User data data
			$user = getUser($_SESSION['login_user_id'], $conn);

				# Getting User conversations
			$conversations = getConversation($user['user_id'], $conn);
				?>
					<div class="container-fluid">
						<div class="col-md-12">
						<div class="p-2 w-400
						rounded shadow">
				<div>
					<div class="d-flex
								mb-3 p-3 bg-light
								justify-content-between
								align-items-center">
						<div class="d-flex
									align-items-center">
							<img src="../../images/profile-images/<?=$user['user_profile_image']?>"
								class="rounded-circle" style="object-fit: cover; width: 50px; height: 50px;">
							<h3 class="fs-xs m-2"><?=$user['user_first_name'].' '.$user['user_last_name'].' ('.$user['user_nickname'].')'?></h3> 
						</div>
						<h2>Please Search a User to Chat</h2>
					</div>

					<div class="input-group mb-3">
						<input type="text"
							placeholder="Search..."
							id="searchText"
							class="form-control" style="height: 50px; font-size: 20px;">
						<button style="color:#fed136; background-color:#114481; width: 80px;"
								id="serachBtn">
								<i class="fa fa-search" style="font-size: 20px;"></i>	
						</button>       
					</div>
					<ul id="chatList"
						class="list-group mvh-50 overflow-auto" style="height: 570px;">
						<?php if (!empty($conversations)) { ?>
							<?php 

							foreach ($conversations as $conversation){ 
										
								if(lastRead($_SESSION['login_user_id'], $conversation['user_id'], $conn)===1){
										?>
									
							<li class="list-group-item" style="margin: 5px;">
								<a href="customer_dashboard.php?page=messages&user_id=<?=$conversation['user_id']?>"
								class="d-flex
										justify-content-between
										align-items-center p-2">
									<div class="d-flex
												align-items-center">
										<img src="../../images/profile-images/<?=$conversation['user_profile_image']?>"
											class="w-10 rounded-circle" style="object-fit: cover; width: 50px; height: 50px;">
										<h3 class="fs-xs m-2" style="color: black;">
											<?=$conversation['user_first_name'].' '.$conversation['user_last_name']?><br>
							<small>
								<?php 
								echo 'Message: '.lastChat($_SESSION['login_user_id'], $conversation['user_id'], $conn);
								?>
							</small>
										</h3>            	
									</div>
									<div title="online">
										<div class="online"></div>
									</div>
									<?php
										$online = $conn->query("SELECT user_active_status FROM tbl_user_account WHERE user_id = {$conversation['user_id']}")->fetch();
										
										if($online['user_active_status']=='1')
										{
									?>
											<i class="fa fa-circle" aria-hidden="true" style="color:green;"></i>
									<?php
										}
										else if($online['user_active_status']=='0')
										{
									?>
											<i class="fa fa-circle" aria-hidden="true" style="color:#D9D9D9;"></i>
									<?php
										}
										else
										{
									?>
											<i class="fa fa-circle" aria-hidden="true" style="color:#D9D9D9;"></i>
									<?php
										}
									?>
									
								</a>
							</li>
							<?php }else if(lastRead($_SESSION['login_user_id'], $conversation['user_id'], $conn)===0){ ?>
										<li class="list-group-item" style="background-color: gray; margin: 5px;">
								<a href="customer_dashboard.php?page=messages&user_id=<?=$conversation['user_id']?>"
								class="d-flex
										justify-content-between
										align-items-center p-2">
									<div class="d-flex
												align-items-center">
										<img src="../../<?=$conversation['user_profile_image']?>"
											class="w-10 rounded-circle" style="object-fit: cover; width: 50px; height: 50px;">
										<h3 class="fs-xs m-2" style="color: black;">
											<?=$conversation['user_first_name'].' '.$conversation['user_last_name']?><br>
							<small>
								<?php 
								echo 'Message: '.lastChat($_SESSION['login_user_id'], $conversation['user_id'], $conn);
								?>
							</small>
										</h3>            	
									</div>
									<div title="online">
										<div class="online"></div>
									</div>
									<?php
										$online = $conn->query("SELECT user_active_status FROM tbl_user_account WHERE user_id = {$conversation['user_id']}")->fetch();
										
										if($online['user_active_status']=='1')
										{
									?>
											<i class="fa fa-circle" aria-hidden="true" style="color:green;"></i>
									<?php
										}
										else if($online['user_active_status']=='0')
										{
									?>
											<i class="fa fa-circle" aria-hidden="true" style="color:#D9D9D9;"></i>
									<?php
										}
										else
										{
									?>
											<i class="fa fa-circle" aria-hidden="true" style="color:#D9D9D9;"></i>
									<?php
										}
									?>
								</a>
							</li>
									<?php }else{?>
										<li class="list-group-item" style="margin: 5px;">
								<a href="customer_dashboard.php?page=messages&user_id=<?=$conversation['user_id']?>"
								class="d-flex
										justify-content-between
										align-items-center p-2">
									<div class="d-flex
												align-items-center">
										<img src="../../<?=$conversation['user_profile_image']?>"
											class="w-10 rounded-circle" style="object-fit: cover; width: 50px; height: 50px;">
										<h3 class="fs-xs m-2" style="color: black;">
											<?=$conversation['user_first_name'].' '.$conversation['user_last_name']?><br>
							<small>
								<?php 
								echo 'Message: '.lastChat($_SESSION['login_user_id'], $conversation['user_id'], $conn);
								?>
							</small>
										</h3>            	
									</div>
									<div title="online">
										<div class="online"></div>
									</div>
									<?php
										$online = $conn->query("SELECT user_active_status FROM tbl_user_account WHERE user_id = {$conversation['user_id']}")->fetch();
										
										if($online['user_active_status']=='1')
										{
									?>
											<i class="fa fa-circle" aria-hidden="true" style="color:green;"></i>
									<?php
										}
										else if($online['user_active_status']=='0')
										{
									?>
											<i class="fa fa-circle" aria-hidden="true" style="color:#D9D9D9;"></i>
									<?php
										}
										else
										{
									?>
											<i class="fa fa-circle" aria-hidden="true" style="color:#D9D9D9;"></i>
									<?php
										}
									?>
								</a>
							</li>
										<?php
									}} ?>
						<?php }else{ ?>
							<div style="max-height: 680px; color: #fed136;" class="overflow-auto">
								<div class="text-center" style="height: 100%; background-color: #114481; padding: 10px;">
									<div style="display: flex; justify-content: center; margin-top: 10px; margin-bottom: auto;">
									<i class="fa fa-comments" style="font-size: 40px; margin-right: 10px;"></i>
						<p  style="font-size: 30px;">No messages yet, Start the conversation</p>
									</div>
							</div>
							</div>
						<?php } ?>
					</ul>
				</div>
			</div>
						</div>
					</div>
				</div>
			</div>

			<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

		<script>
			$(document).ready(function(){
			
			// Search
			$("#searchText").on("input", function(){
				var searchText = $(this).val();
				if(searchText == "") return;
				$.post('../messaging/ajax/search.php', 
						{
							key: searchText
						},
					function(data, status){
						$("#chatList").html(data);
					});
			});

			// Search using the button
			$("#serachBtn").on("click", function(){
				var searchText = $("#searchText").val();
				if(searchText == "") return;
				$.post('../messaging/ajax/search.php', 
						{
							key: searchText
						},
					function(data, status){
						$("#chatList").html(data);
					});
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
			setInterval(lastSeenUpdate, 100);

			});
		</script>

		<?php
			endif;
		?>

		<?php
			if(isset($_GET['user_id'])):
				
		?>
			<div class="center-panel py-2 px-2">
				<div class="container-fluid">
					<div class="col-md-12">
		<?php
				include 'chat.php';

			endif;

		?>
					</div>
				</div>
			</div>