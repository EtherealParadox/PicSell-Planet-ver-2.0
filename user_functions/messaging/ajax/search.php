	<?php

	session_start();

	# check if the user is logged in
	if (isset($_SESSION['login_user_profile_image']) && !empty($_SESSION['login_user_profile_image'])) {
		# check if the key is submitted
		if(isset($_POST['key'])){
		# database connection file
		include '../db_conn.php';

		# creating simple search algorithm :) 
		$key = "{$_POST['key']}%";
		
		$sql = "SELECT * FROM tbl_user_account
				WHERE user_first_name
				LIKE ? OR user_last_name LIKE ?";
		$stmt = $conn->prepare($sql);
		$stmt->execute([$key, $key]);

		if($stmt->rowCount() > 0){ 
			$users = $stmt->fetchAll();

			foreach ($users as $user) {
				if ($user['user_id'] == $_SESSION['login_user_id']) continue;
		?>
		<li class="list-group-item" style="text-decoration: none;">
		<?php ($_SESSION['login_user_type'] === "Lensman") ? $in_sess_link = "lensman" : $in_sess_link = "customer"; ?>
			<a href="<?php echo $in_sess_link ?>_dashboard.php?page=messages&user_id=<?=$user['user_id']?>"
			class="d-flex
					justify-content-between
					align-items-center p-2">
				<div class="d-flex
							align-items-center">

					<img src="../../images/profile-images/<?=$user['user_profile_image']?>"
						class="w-10 rounded-circle" style="object-fit: cover; width: 50px; height: 50px;">

					<h3 class="fs-xs m-2" style="color: black;">
						<?=$user['user_first_name'].' '.$user['user_last_name']?>
					</h3>            	
				</div>
			</a>
		</li>
		<?php } }else { ?>
					<div style="max-height: 680px; color: #fed136;" class="overflow-auto">
			<div class="text-center"
					style="height: 100%; background-color: #114481; padding: 10px;">
					<div style="display: flex; justify-content: center; margin-top: 10px; margin-bottom: auto;">
			<i class="fa fa-user-times" style="font-size: 40px; margin-right: 10px;"></i>
			<p style="font-size: 30px;">The user "<?=htmlspecialchars($_POST['key'])?>"
			is  not found.</p>
					</div>
				</div>
				</div>
		<?php }
		}

	}else {
		header("Location: ../customer/messaging.php");
		exit;
	}