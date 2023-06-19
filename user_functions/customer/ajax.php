<?php
ob_start();
date_default_timezone_set("Asia/Manila");

$action = $_GET['action'];
include 'admin_class.php';
$crud = new Action();
if($action == 'login'){
	$login = $crud->login();
	if($login)
		echo $login;
}
if($action == 'login2'){
	$login = $crud->login2();
	if($login)
		echo $login;
}
if($action == 'logout'){
	$logout = $crud->logout();
	if($logout)
		echo $logout;
}
if($action == 'logout2'){
	$logout = $crud->logout2();
	if($logout)
		echo $logout;
}
if($action == 'logout3'){
	$logout = $crud->logout3();
	if($logout)
		echo $logout;
}

if($action == 'signup'){
	$save = $crud->signup();
	if($save)
		echo $save;
}
if($action == 'save_user'){
	$save = $crud->save_user();
	if($save)
		echo $save;
}
if($action == 'update_pass'){
	$save = $crud->update_pass();
	if($save)
		echo $save;
}
if($action == 'update_user'){
	$save = $crud->update_user();
	if($save)
		echo $save;
}
if($action == 'delete_user'){
	$save = $crud->delete_user();
	if($save)
		echo $save;
}
if($action == 'save_post'){
	$save = $crud->save_post();
	if($save)
		echo $save;
}
if($action == 'delete_post'){
	$delete = $crud->delete_post();
	if($delete)
		echo $delete;
}
if($action == 'report_post'){
	$delete = $crud->report_post();
	if($delete)
		echo $delete;
}
if($action=='like'){
	$save = $crud->like();
	if($save)
		echo $save;
}
if($action == 'save_comment'){
	$save = $crud->save_comment();
	if($save)
		echo $save;
}
if($action == 'update_cover'){
	$save = $crud->update_cover();
	if($save)
echo $save;
}
if($action == 'update_profile'){
	$save = $crud->update_profile();
	if($save)
echo $save;
}

if($action == 'save_avail'){
	$save = $crud->save_avail();
	if($save)
		echo $save;
}

if($action == 'resched_avail'){
	$save = $crud->resched_avail();
	if($save)
		echo $save;
}

if($action == 'upload_downpayment'){
	$save = $crud->upload_downpayment();
	if($save)
		echo $save;
}

if($action == 'cancel_avail_cm'){
	$save = $crud->cancel_avail_cm();
	if($save)
		echo $save;
}

if($action == 'save_review_service'){
	$save = $crud->save_review_service();
	if($save)
		echo $save;
}

if($action == 'save_review_lensman'){
	$save = $crud->save_review_lensman();
	if($save)
		echo $save;
}

if($action == 'update_notif_status'){
	$save = $crud->update_notif_status();
	if($save)
		echo $save;
}

if($action == 'save_cart'){
	$save = $crud->save_cart();
	if($save)
		echo $save;
}

if($action == 'delete_cart'){
	$save = $crud->delete_cart();
	if($save)
		echo $save;
}

if($action == 'minus_quant'){
	$save = $crud->minus_quant();
	if($save)
		echo $save;
}

if($action == 'plus_quant'){
	$save = $crud->plus_quant();
	if($save)
		echo $save;
}

if($action == 'buy_now'){
	$save = $crud->buy_now();
	if($save)
		echo $save;
}

if($action == 'confirm_order'){
	$save = $crud->confirm_order();
	if($save)
		echo $save;
}

if($action == 'cancel_order_cm'){
	$save = $crud->cancel_order_cm();
	if($save)
		echo $save;
}

if($action == 'save_review_product'){
	$save = $crud->save_review_product();
	if($save)
		echo $save;
}

ob_end_flush();
?>
