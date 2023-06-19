	<?php
	ob_start();
	date_default_timezone_set("Asia/Manila");

	$action = $_GET['action'];
	include 'myAdmin.php';
	$myAdmin = new myAdmin();

	if($action == 'change_admin_profile'){
		$save = $myAdmin->change_admin_profile();
		if($save)
			echo $save;
	}

	if($action == 'change_admin_name'){
		$save = $myAdmin->change_admin_name();
		if($save)
			echo $save;
	}

	if($action == 'change_admin_pass'){
		$save = $myAdmin->change_admin_pass();
		if($save)
			echo $save;
	}

	if($action == 'archive_account'){
		$save = $myAdmin->archive_account();
		if($save)
			echo $save;
	}

	if($action == 'delete_account'){
		$save = $myAdmin->delete_account();
		if($save)
			echo $save;
	}

	if($action == 'archive_feedback'){
		$save = $myAdmin->archive_feedback();
		if($save)
			echo $save;
	}

	if($action == 'archive_service'){
		$save = $myAdmin->archive_service();
		if($save)
			echo $save;
	}

	if($action == 'archive_post'){
		$save = $myAdmin->archive_post();
		if($save)
			echo $save;
	}

	if($action == 'remove_post'){
		$save = $myAdmin->remove_post();
		if($save)
			echo $save;
	}

	if($action == 'archive_product'){
		$save = $myAdmin->archive_product();
		if($save)
			echo $save;
	}

	if($action == 'send_verification'){
		$save = $myAdmin->send_verification();
		if($save)
			echo $save;
	}

	if($action == 'resend_email_lm'){
		$save = $myAdmin->resend_email_lm();
		if($save)
			echo $save;
	}

	if($action == 'resend_email_cm'){
		$save = $myAdmin->resend_email_cm();
		if($save)
			echo $save;
	}

	if($action == 'reactivate_cm'){
		$save = $myAdmin->reactivate_cm();
		if($save)
			echo $save;
	}

	if($action == 'update_notif_status_adm'){
		$save = $myAdmin->update_notif_status_adm();
		if($save)
			echo $save;
	}

	ob_end_flush();
	?>