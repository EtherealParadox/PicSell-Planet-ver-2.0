	<?php
	session_start();
	ini_set('display_errors', 1);
	Class Action {
		private $db;

		public function __construct() {
			ob_start();
		include '../db_connect.php';
		
		$this->db = $conn;
		}
		function __destruct() {
			$this->db->close();
			ob_end_flush();
		}

		function login(){
			extract($_POST);
				$qry = $this->db->query("SELECT *,concat(firstname,' ',lastname) as name FROM users where email = '".$email."' and password = '".md5($password)."' ");
			if($qry->num_rows > 0){
				foreach ($qry->fetch_array() as $key => $value) {
					if($key != 'password' && !is_numeric($key))
						$_SESSION['login_'.$key] = $value;
				}
					return 1;
			}else{
				return 3;
			}
		}
		function logout(){
			session_destroy();
			foreach ($_SESSION as $key => $value) {
				unset($_SESSION[$key]);
			}
			header("location: ../../index.php");
		}
		function login2(){
			extract($_POST);
				$qry = $this->db->query("SELECT *,concat(lastname,', ',firstname,' ',middlename) as name FROM users where email = '".$email."' and password = '".md5($password)."'  and type= 2 ");
			if($qry->num_rows > 0){
				foreach ($qry->fetch_array() as $key => $value) {
					if($key != 'password' && !is_numeric($key))
						$_SESSION['login_'.$key] = $value;
				}
					return 1;
			}else{
				return 3;
			}
		}
		function logout2(){
			session_destroy();
			foreach ($_SESSION as $key => $value) {
				unset($_SESSION[$key]);
			}
			header("location:../index.php");
		}
		function logout3(){
			$id = $_SESSION['login_user_id'];
			$save = $this->db->query("UPDATE `tbl_user_account` SET user_active_status='0' WHERE `user_id` = $id ");
			if($save)
			{
				session_destroy();
				foreach ($_SESSION as $key => $value) {
					unset($_SESSION[$key]);
				}
				header("location: ../../index.php");
			}
		}
		function save_user(){
			extract($_POST);
			$data = "";
			foreach($_POST as $k => $v){
				if(!in_array($k, array('id','cpass','password')) && !is_numeric($k)){
					if(empty($data)){
						$data .= " $k='$v' ";
					}else{
						$data .= ", $k='$v' ";
					}
				}
			}
			if(!empty($cpass) && !empty($password)){
						$data .= ", password=md5('$password') ";

			}
			$check = $this->db->query("SELECT * FROM users where email ='$email' ".(!empty($id) ? " and id != {$id} " : ''))->num_rows;
			if($check > 0){
				return 2;
				exit;
			}
			if(isset($_FILES['img']) && $_FILES['img']['tmp_name'] != ''){
				$fname = strtotime(date('y-m-d H:i')).'_'.$_FILES['img']['name'];
				$move = move_uploaded_file($_FILES['img']['tmp_name'],'../../assets/uploads/'. $fname);
				$data .= ", avatar = '$fname' ";

			}
			if(empty($id)){
				$save = $this->db->query("INSERT INTO users set $data");
			}else{
				$save = $this->db->query("UPDATE users set $data where id = $id");
			}

			if($save){
				return 1;
			}
		}
		function signup(){
			extract($_POST);
			$data = "";
			foreach($_POST as $k => $v){
				if(!in_array($k, array('id','cpass','month','day','year')) && !is_numeric($k)){
					if($k =='password'){
						if(empty($v))
							continue;
						$v = md5($v);

					}
					if(empty($data)){
						$data .= " $k='$v' ";
					}else{
						$data .= ", $k='$v' ";
					}
				}
			}
			if(isset($month)){
						$data .= ", dob='{$year}-{$month}-{$day}' ";
			}
			if(isset($email)){
				$check = $this->db->query("SELECT * FROM users where email ='$email' ".(!empty($id) ? " and id != {$id} " : ''))->num_rows;
				if($check > 0){
					return 2;
					exit;
				}
			}
			if(isset($_FILES['pp']) && $_FILES['pp']['tmp_name'] != ''){
				$fnamep = strtotime(date('y-m-d H:i')).'_'.$_FILES['pp']['name'];
				$move = move_uploaded_file($_FILES['pp']['tmp_name'],'../assets/uploads/'. $fnamep);
				$data .= ", profile_pic = '$fnamep' ";

			}
			if(isset($_FILES['cover']) && $_FILES['cover']['tmp_name'] != ''){
				$fnamec = strtotime(date('y-m-d H:i')).'_'.$_FILES['cover']['name'];
				$move = move_uploaded_file($_FILES['cover']['tmp_name'],'../assets/uploads/'. $fnamec);
				$data .= ", cover_pic = '$fnamec' ";

			}
			if(empty($id)){
				$save = $this->db->query("INSERT INTO users set $data");

			}else{
				$save = $this->db->query("UPDATE users set $data where id = $id");
			}

			if($save){
				if(empty($id))
					$id = $this->db->insert_id;
				foreach ($_POST as $key => $value) {
					if(!in_array($key, array('id','cpass','password')) && !is_numeric($key))
						if($k = 'pp'){
							$k ='profile_pic';
						}
						if($k = 'cover'){
							$k ='cover_pic';
						}
						$_SESSION['login_'.$key] = $value;
				}
						$_SESSION['login_id'] = $id;
						if(isset($_FILES['pp']) &&$_FILES['pp']['tmp_name'] != '')
							$_SESSION['login_profile_pic'] = $fnamep;
						if(isset($_FILES['cover']) &&$_FILES['cover']['tmp_name'] != '')
							$_SESSION['login_cover_pic'] = $fnamec;
				return 1;
			}
		}

		function update_pass(){
			extract($_POST);

			if(strlen($password) >= 8 && strlen($cPassword) >= 8)
			{
				if($password === $cPassword)
				{
					if(preg_match("/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[!@#$%^&*()_.])[A-Za-z\d!@#$%^&*()_.]{8,}$/", $password) || preg_match("/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)[A-Za-z\d!@#$%^&*()_.]{8,}$/", $password))
					{
						$hashed_password = password_hash($password, PASSWORD_DEFAULT);
						$data = "user_password='$hashed_password'";
						$save = $this->db->query("UPDATE tbl_user_account set $data where user_id = $user_id");

						if($save){
							return 1;
						}
						else
						{
							return 2;
						}
					}
					else
					{
						return 3;
					}
				}
				else
				{
					return 4;
				}
			}
			else
			{
				return 5;
			}
			/*extract($_POST);
			$data = "";
			foreach($_POST as $k => $v){
				if(!in_array($k, array('cpass')) && !is_numeric($k)){
					if($k =='user_password')
						$v = password_hash($v, PASSWORD_DEFAULT);;
					if(empty($data)){
						$data .= " $k='$v' ";
					}else{
						$data .= ", $k='$v' ";
					}
				}
			}
			
			$save = $this->db->query("UPDATE tbl_user_account set $data where user_id = $user_id");

			if($save){
				return 1;
			}*/
		}

		function update_user(){
			extract($_POST);
			$data = "";
			foreach($_POST as $k => $v){
				if(!in_array($k, array('id','cpass','table')) && !is_numeric($k)){
					if($k =='password')
						$v = md5($v);
					if(empty($data)){
						$data .= " $k='$v' ";
					}else{
						$data .= ", $k='$v' ";
					}
				}
			}
			if($_FILES['img']['tmp_name'] != ''){
				$fname = strtotime(date('y-m-d H:i')).'_'.$_FILES['img']['name'];
				$move = move_uploaded_file($_FILES['img']['tmp_name'],'../assets/uploads/'. $fname);
				$data .= ", avatar = '$fname' ";

			}
			$check = $this->db->query("SELECT * FROM users where email ='$email' ".(!empty($id) ? " and id != {$id} " : ''))->num_rows;
			if($check > 0){
				return 2;
				exit;
			}
			if(empty($id)){
				$save = $this->db->query("INSERT INTO users set $data");
			}else{
				$save = $this->db->query("UPDATE users set $data where id = $id");
			}

			if($save){
				foreach ($_POST as $key => $value) {
					if($key != 'password' && !is_numeric($key))
						$_SESSION['login_'.$key] = $value;
				}
				
				return 1;
			}
		}
		function delete_user(){
			extract($_POST);
			$delete = $this->db->query("DELETE FROM users where id = ".$id);
			if($delete)
				return 1;
		}
		function save_post(){
			extract($_POST);
			/*$data = "";

			foreach($_POST as $k => $v){
				if(!in_array($k, array('post_id','img','imgName')) && !is_numeric($k)){
					if(empty($data)){
						$data .= " $k='$v' ";
					}else{
						$data .= ", $k='$v' ";
					}
				}
			}*/

			$user_id = mysqli_real_escape_string($this->db, $_SESSION['login_user_id']);
			$post_content = mysqli_real_escape_string($this->db, $post_content);
			$date = new DateTime("now", new DateTimeZone('Asia/Manila') );
			$final_date = $date->format('Y-m-d H:i:s');

			$data = "user_id = '$user_id', post_content='$post_content', post_date='$final_date'";

			if(empty($post_id)){
				$save = $this->db->query("INSERT INTO tbl_post set $data");
				if($save && isset($img)){
					$post_id = $this->db->insert_id;
					mkdir('../assets/uploads/'.$post_id);
					for($i = 0 ; $i< count($img);$i++){
						list($type, $img[$i]) = explode(';', $img[$i]);
						list(, $img[$i])      = explode(',', $img[$i]);
						$img[$i] = str_replace(' ', '+', $img[$i]);
						$img[$i] = base64_decode($img[$i]);
						$fname = strtotime(date('Y-m-d H:i'))."_".$imgName[$i];
						$upload = file_put_contents('../assets/uploads/'.$post_id.'/'.$fname,$img[$i]);
						$data = " file_path = '".$fname."' ";
					}
				}
			}else{
				$save = $this->db->query("UPDATE tbl_post set $data where post_id = $post_id");
				if($save){
					if(is_dir('../assets/uploads/'.$post_id)){
						$gal = scandir('../assets/uploads/'.$post_id);
						unset($gal[0]);
						unset($gal[1]);
						foreach($gal as $k=>$v){
							unlink('../assets/uploads/'.$post_id.'/'.$v);
						}
						rmdir('../assets/uploads/'.$post_id);
					}
					if(isset($img)){
						mkdir('../assets/uploads/'.$post_id);
						for($i = 0 ; $i< count($img);$i++){
							list($type, $img[$i]) = explode(';', $img[$i]);
							list(, $img[$i])      = explode(',', $img[$i]);
							$img[$i] = str_replace(' ', '+', $img[$i]);
							$img[$i] = base64_decode($img[$i]);
							$fname = strtotime(date('Y-m-d H:i'))."_".$imgName[$i];
							$upload = file_put_contents('../assets/uploads/'.$post_id.'/'.$fname,$img[$i]);
							$data = " file_path = '".$fname."' ";
						}
					}
				}
			}
			if($save){
				return 1;
			}
		}
		function delete_post(){
			extract($_POST);
			$delete = $this->db->query("DELETE FROM tbl_post where post_id = $id");
			if($delete){
				if(is_dir('../assets/uploads/'.$id)){
					$gal = scandir('../assets/uploads/'.$id);
					unset($gal[0]);
					unset($gal[1]);
					foreach($gal as $k=>$v){
						unlink('../assets/uploads/'.$id.'/'.$v);
					}
					rmdir('../assets/uploads/'.$id);
				}
				return 1;
			}
		}
		function report_post(){
			extract($_POST);

			$check = $this->db->query("SELECT * FROM `tbl_reports` WHERE user_id = $user_id AND post_id = $post_id")->num_rows;

			if($check == 1)
			{
				return 2;
			}
			else
			{
				$date = new DateTime("now", new DateTimeZone('Asia/Manila') );
				$final_date = $date->format('Y-m-d H:i:s');

				$data = "report_reason='$report_reason', report_date='$final_date', post_id='$post_id', user_id='$user_id'";

				$report_post = $this->db->query("INSERT INTO tbl_reports set $data ");

				$report_id = $this->db->insert_id;

				$report_post2 = $this->db->query("INSERT INTO `tbl_notification`(`notification_date`, `notification_receiver`, `post_reported`) VALUES ('$final_date','Admin','$report_id')");

				if($report_post && $report_post2)
				{
					return 1;
				}
				else
				{
					return 3;
				}
			}
			
		}
		function like(){
			extract($_POST);
			$data = " user_id = {$_SESSION['login_user_id']} ";
			$data .= ", post_id = $post_id ";
			$chk = $this->db->query("SELECT * FROM tbl_post_likes where user_id = {$_SESSION['login_user_id']} and post_id = $post_id ")->num_rows;
			if($chk > 0){
				$delete = $this->db->query("DELETE FROM tbl_post_likes where user_id = {$_SESSION['login_user_id']} and post_id = $post_id ");
				if($delete){
					return 0;
					exit;
				}
			}
			$save = $this->db->query("INSERT INTO tbl_post_likes set $data ");
			if($save){
				return 1;
			}
		}
		function save_comment(){
			extract($_POST);

			$user_id = mysqli_real_escape_string($this->db, $_SESSION['login_user_id']);
			$post_id = mysqli_real_escape_string($this->db, $post_id);
			$comment_content = mysqli_real_escape_string($this->db, $comment_content);
			$date = new DateTime("now", new DateTimeZone('Asia/Manila') );
			$final_date = $date->format('Y-m-d H:i:s');

			$data = " user_id = '$user_id' ";
			$data .= ", post_id ='$post_id'";
			$data .= ", comment_content = '$comment_content' ";
			$data.= ", comment_date='$final_date'";

			if(empty($comment_content) || !strlen(trim($comment_content)))
			{
				$d['status'] = 0;
				$d['data']['alert'] = "Comment area shouldn't be empty";
				return json_encode($d);
			}
			else
			{
				
				$save = $this->db->query("INSERT INTO tbl_post_comments set $data ");
				if($save){
					$id = $this->db->insert_id;
					$d['status'] = 1;
					$qry = $this->db->query("SELECT c.*, CONCAT(u.user_first_name, ' ', u.user_last_name) as user_name, u.user_profile_image, u.user_type FROM tbl_post_comments c inner join tbl_user_account u on u.user_id = c.user_id where c.comment_id = $id ")->fetch_array();
					$diff_output = '';	
					foreach($qry as $k => $v){
						if(!is_numeric($k)){
							if($k == "comment_content"){
								$v = str_replace("\n","<br/>",$v);
							}
							if($k == "comment_date"){
								$k = 'timestamp';
								$v = date("M d, h:i A",strtotime($v));
							}
							if($k == "user_name")
							{
								$diff_output .= $v;
							}
							if($k == "user_type")
							{
								$k = 'name_type';
								$v = $diff_output .= ' ('.$v.')';
							}
							$d['data'][$k] = $v;
						}
					}
					return json_encode($d);
				}
			}
			
		}
		function update_cover(){
			
			if(isset($_FILES['cover']) && $_FILES['cover']['tmp_name'] != ''){
				$fnamec = strtotime(date('y-m-d H:i')).'_'.$_FILES['cover']['name'];
				$move = move_uploaded_file($_FILES['cover']['tmp_name'],'../assets/uploads/'. $fnamec);
				$data = " cover_pic = '$fnamec' ";

			}
			if(isset($data)){
				$save = $this->db->query("UPDATE users set $data where id = {$_SESSION['login_id']}");
				if($save){
					if(isset($_FILES['cover']) &&$_FILES['cover']['tmp_name'] != '')
							$_SESSION['login_cover_pic'] = $fnamec;
					return 1;
				}
			}
		}
		function update_profile(){
			extract($_POST);

			if(isset($_FILES['pp']) && $_FILES['pp']['tmp_name'] != ''){

				
				$new_img_name = uniqid("IMG-", true) . ".png";
				$data = "user_profile_image= '$new_img_name'";
				$save = $this->db->query("UPDATE tbl_user_account set $data WHERE user_id = {$user_id}");
				$path  = '../../images/profile-images/'. $new_img_name;
				move_uploaded_file($_FILES['pp']['tmp_name'], $path);
				if($save)
				{
					$old_path = '../../images/profile-images/' . $pfp_old;
					unlink($old_path);
					return 1;
				}
				else
				{
					return 2;
				}
			}
			else
			{
				return 3;
			}
		}
		function save_avail(){
			extract($_POST);
			$data = "";

			foreach($_POST as $k => $v){
				if(!in_array($k, array('avail_id')) && !is_numeric($k)){
					if(empty($data))
					{
						$data .= " $k='$v' ";
					}
					elseif($k == "avail_starting_date_time")
					{
						$start = $v;
						$data .= ", $k='$v' ";
					}
					elseif($k == "avail_ending_date_time")
					{
						$end = $v;
						$data .= ", $k='$v' ";
					}
					else
					{
						$data .= ", $k='$v' ";
					}
				}
			}

			if(empty($avail_id))
			{
				$save = $this->db->query("INSERT INTO tbl_service_avail set $data ");
				if($save)
				{
					return 1;
				}
			}
			else
			{
				$save = $this->db->query("UPDATE tbl_service_avail set $data where avail_id = $avail_id");
				if($save)
				{
					return 2;
				}
			}

			
		}

		function add_service(){
			extract($_POST);
			//$data = "";

			/*foreach($_POST as $k => $v){
				if(!is_numeric($k)){
					if(empty($data))
					{
						$data .= ` `.$k.`=`.mysqli_real_escape_string($this->db, $v).` `;
					}
					else
					{
						$data .= `, `.$k.`=`.mysqli_real_escape_string($this->db, $v).` `;
					}
				}
			}*/

			$user_id = mysqli_real_escape_string($this->db, $_SESSION['login_user_id']);
			$service_name = mysqli_real_escape_string($this->db, $service_name);
			$service_price = mysqli_real_escape_string($this->db, $service_price);
			$service_description = mysqli_real_escape_string($this->db, $service_description);
			$service_hours = mysqli_real_escape_string($this->db, $service_hours);

			$data = "user_id='$user_id', service_name='$service_name', service_price='$service_price', service_description='$service_description', service_hours='$service_hours'";

			if(isset($_FILES['service_banner']) && $_FILES['service_banner']['tmp_name'] != '')
			{
				$new_img_name = uniqid("IMG-", true) . ".png";
				$data .= ", service_banner= '$new_img_name' ";
				//return json_encode($data);
				$save = $this->db->query("INSERT INTO tbl_service_packages set $data");
				$path  = '../assets/banners/'. $new_img_name;
				move_uploaded_file($_FILES['service_banner']['tmp_name'], $path);
				if($save)
				{
					return 1;
				}
				else
				{
					return 2;
				}
			}
			else
			{
				return 2;
			}
		}

		function edit_service(){
			extract($_POST);
			//$data = "";

			/*foreach($_POST as $k => $v){
				if(!in_array($k, array('user_id', 'service_id', 'service_banner_old')) && !is_numeric($k)){
					if(empty($data))
					{
						$data .= " $k='$v' ";
					}
					else
					{
						$data .= ", $k='$v' ";
					}
				}
			}*/
			
			$user_id = mysqli_real_escape_string($this->db, $_SESSION['login_user_id']);
			$service_name = mysqli_real_escape_string($this->db, $service_name);
			$service_price = mysqli_real_escape_string($this->db, $service_price);
			$service_description = mysqli_real_escape_string($this->db, $service_description);
			$service_hours = mysqli_real_escape_string($this->db, $service_hours);

			$data = "service_name='$service_name', service_price='$service_price', service_description='$service_description', service_hours='$service_hours'";

			if(isset($_FILES['service_banner']) && $_FILES['service_banner']['tmp_name'] != '')
			{
				$new_img_name = uniqid("IMG-", true) . ".png";
				$data .= ", service_banner= '$new_img_name' ";
				//return json_encode($data);
				$save = $this->db->query("UPDATE tbl_service_packages set $data where user_id = {$user_id} and service_id = {$service_id}");
				$path  = '../assets/banners/'. $new_img_name;
				$old_path = '../assets/banners/' . $service_banner_old;
				move_uploaded_file($_FILES['service_banner']['tmp_name'], $path);
				unlink($old_path);
				if($save)
				{
					return 1;
				}
				else
				{
					return 2;
				}
			}
			else
			{
				$save = $this->db->query("UPDATE tbl_service_packages set $data where user_id = {$user_id} and service_id = {$service_id}");
				if($save)
				{
					return 1;
				}
				else
				{
					return 2;
				}
			}
		}

		function proceed_to_downpayment()
		{
			extract($_POST);
			$avail_proceed_downpayment = $this->db->query("UPDATE `tbl_service_avail` SET `avail_status`= 1 where avail_id = $avail_id");
			
			$date = new DateTime("now", new DateTimeZone('Asia/Manila') );
			$final_date = $date->format('Y-m-d H:i:s');
			
			$avail_proceed_downpayment2 = $this->db->query("INSERT INTO `tbl_notification`(`notification_date`, `notification_receiver`, `avail_proceed_downpayment`) VALUES ('$final_date','$notification_receiver','$avail_id')");
			if($avail_proceed_downpayment && $avail_proceed_downpayment2){
				return 1;
			}
			else
			{
				return 2;
			}
		}

		function confirm_avail(){
			extract($_POST);
			$confirm_avail = $this->db->query("UPDATE `tbl_service_avail` SET `avail_status`= 2 where avail_id = $avail_id AND avail_downpayment_image IS NOT NULL");

			$date = new DateTime("now", new DateTimeZone('Asia/Manila') );
			$final_date = $date->format('Y-m-d H:i:s');

			$confirm_avail2 = $this->db->query("INSERT INTO `tbl_notification`(`notification_date`, `notification_receiver`, `avail_confirmed`) VALUES ('$final_date','$notification_receiver','$avail_id')");
			if($confirm_avail && $confirm_avail2){
				return 1;
			}
			else
			{
				return 2;
			}
		}

		function complete_avail(){
			extract($_POST);
			$complete_avail = $this->db->query("UPDATE `tbl_service_avail` SET `avail_status`= 3 where avail_id = $avail_id");
			
			$date = new DateTime("now", new DateTimeZone('Asia/Manila') );
			$final_date = $date->format('Y-m-d H:i:s');
			
			$complete_avail2 = $this->db->query("INSERT INTO `tbl_notification`(`notification_date`, `notification_receiver`, `avail_completed`) VALUES ('$final_date','$notification_receiver','$avail_id')");
			if($complete_avail && $complete_avail2){
				return 1;
			}
			else
			{
				return 2;
			}
		}

		function resched_avail_lm(){
			extract($_POST);

			$qry = $this->db->query(" SELECT old_status FROM tbl_service_avail where avail_id = $avail_id")->fetch_assoc();
			$old_status = $qry['old_status'];

			$resched_avail = $this->db->query("UPDATE `tbl_service_avail` SET `avail_status`= $old_status, `old_status` = NULL where avail_id = $avail_id");
			
			$date = new DateTime("now", new DateTimeZone('Asia/Manila') );
			$final_date = $date->format('Y-m-d H:i:s');
			
			$resched_avail2 = $this->db->query("INSERT INTO `tbl_notification`(`notification_date`, `notification_receiver`, `avail_reschedule_accepted`) VALUES ('$final_date','$notification_receiver','$avail_id')");
			if($resched_avail && $resched_avail2){
				return 1;
			}
			else
			{
				return 2;
			}
		}

		function deny_resched_avail_lm(){
			extract($_POST);

			$qry = $this->db->query(" SELECT old_starting_date_time, old_ending_date_time, old_status FROM tbl_service_avail where avail_id = $avail_id")->fetch_assoc();
			$old_start = $qry['old_starting_date_time'];
			$old_end = $qry['old_ending_date_time'];
			$old_status = $qry['old_status'];

			$data = "avail_starting_date_time = '$old_start', avail_ending_date_time = '$old_end', avail_status= '$old_status', old_status = NULL";

			$resched_avail = $this->db->query("UPDATE `tbl_service_avail` SET $data where avail_id = $avail_id");
			
			$date = new DateTime("now", new DateTimeZone('Asia/Manila') );
			$final_date = $date->format('Y-m-d H:i:s');
			
			$resched_avail2 = $this->db->query("INSERT INTO `tbl_notification`(`notification_date`, `notification_receiver`, `avail_reschedule_rejected`) VALUES ('$final_date','$notification_receiver','$avail_id')");
			if($resched_avail && $resched_avail2){
				return 1;
			}
			else
			{
				return 2;
			}
		}

		function cancel_avail_lm(){
			extract($_POST);
			$data = "";

			foreach($_POST as $k => $v){
				if(!in_array($k, array('avail_id', 'notification_receiver')) && !is_numeric($k)){
					if(empty($data))
					{
						$data .= " $k='$v' ";
					}
					else
					{
						$data .= ", $k='$v' ";
					}
				}
			}
			
			$data .= ", avail_status = '4' ";
			
			$cancel_avail = $this->db->query("UPDATE tbl_service_avail set $data where avail_id = $avail_id");

			$date = new DateTime("now", new DateTimeZone('Asia/Manila') );
			$final_date = $date->format('Y-m-d H:i:s');

			$cancel_avail2 = $this->db->query("INSERT INTO `tbl_notification`(`notification_date`, `notification_receiver`, `avail_cancelled`) VALUES ('$final_date','$notification_receiver','$avail_id')");
			if($cancel_avail && $cancel_avail2)
			{
				return 1;
			}
			else
			{
				return 2;
			}
		}

		public function save_service($user_id, $service_name, $service_price, $service_hours, $service_description, $new_img_name){
			$user_id = mysqli_real_escape_string($this->db, $user_id);
			$service_name = mysqli_real_escape_string($this->db, $service_name);
			$service_price = mysqli_real_escape_string($this->db, $service_price);
			$service_hours = mysqli_real_escape_string($this->db, $service_hours);
			$service_description = mysqli_real_escape_string($this->db, $service_description);
			$new_img_name = mysqli_real_escape_string($this->db, $new_img_name);

			$add_service = $this->db->query("INSERT INTO `tbl_service_packages`(`service_id`, `service_type`, `service_price`, `service_hours`, `service_description`, `service_banner`, `user_id`) 
			VALUES ('0', '$service_name', '$service_price', '$service_hours', '$service_description', '$new_img_name', '$user_id')");
			if($add_service)
			{
				return 1;
			}
			else
			{
				return 0;
			}
		}

		function update_notif_status(){
			$update_notif_status = $this->db->query("UPDATE `tbl_notification` SET `notification_status` = 1 WHERE `notification_receiver` = {$_SESSION['login_user_id']}  AND `notification_status` = 0 ");
			if($update_notif_status)
			{
				return 1;
			}
		}

		function add_product(){
			extract($_POST);
			//$data = "";

			/*foreach($_POST as $k => $v){
				if(!is_numeric($k)){
					if(empty($data))
					{
						$data .= " $k='$v' ";
					}
					else
					{
						$data .= ", $k='$v' ";
					}
				}
			}*/

			$user_id = mysqli_real_escape_string($this->db, $_SESSION['login_user_id']);
			$product_name = mysqli_real_escape_string($this->db, $product_name);
			$product_price = mysqli_real_escape_string($this->db, $product_price);
			$product_description = mysqli_real_escape_string($this->db, $product_description);
			$product_stock = mysqli_real_escape_string($this->db, $product_stock);

			$data = "user_id='$user_id', product_name='$product_name', product_price='$product_price', product_description='$product_description', product_stock='$product_stock'";

			if(isset($_FILES['product_banner']) && $_FILES['product_banner']['tmp_name'] != '')
			{
				$new_img_name = uniqid("IMG-", true) . ".png";
				$data .= ", product_banner= '$new_img_name' ";
				//return json_encode($data);
				$save = $this->db->query("INSERT INTO tbl_product set $data");
				$path  = '../assets/banners/products/'. $new_img_name;
				move_uploaded_file($_FILES['product_banner']['tmp_name'], $path);
				if($save)
				{
					return 1;
				}
				else
				{
					return 2;
				}
			}
			else
			{
				return 2;
			}
		}

		function edit_product(){
			extract($_POST);
			//$data = "";

			/*foreach($_POST as $k => $v){
				if(!in_array($k, array('user_id', 'product_id', 'product_banner_old')) && !is_numeric($k)){
					if(empty($data))
					{
						$data .= " $k='$v' ";
					}
					else
					{
						$data .= ", $k='$v' ";
					}
				}
			}*/
			
			$user_id = mysqli_real_escape_string($this->db, $_SESSION['login_user_id']);
			$product_name = mysqli_real_escape_string($this->db, $product_name);
			$product_price = mysqli_real_escape_string($this->db, $product_price);
			$product_description = mysqli_real_escape_string($this->db, $product_description);
			$product_stock = mysqli_real_escape_string($this->db, $product_stock);

			$data = "product_name='$product_name', product_price='$product_price', product_description='$product_description', product_stock='$product_stock'";

			if(isset($_FILES['product_banner']) && $_FILES['product_banner']['tmp_name'] != '')
			{
				$new_img_name = uniqid("IMG-", true) . ".png";
				$data .= ", product_banner= '$new_img_name' ";
				//return json_encode($data);
				$save = $this->db->query("UPDATE tbl_product set $data where user_id = {$user_id} and product_id = {$product_id}");
				$path  = '../assets/banners/products/'. $new_img_name;
				$old_path = '../assets/banners/products/' . $product_banner_old;
				move_uploaded_file($_FILES['product_banner']['tmp_name'], $path);
				unlink($old_path);
				if($save)
				{
					return 1;
				}
				else
				{
					return 2;
				}
			}
			else
			{
				$save = $this->db->query("UPDATE tbl_product set $data where user_id = {$user_id} and product_id = {$product_id}");
				if($save)
				{
					return 1;
				}
				else
				{
					return 2;
				}
			}
		}

		function archive_product()
		{
			extract($_POST);
			$save = $this->db->query("UPDATE tbl_product set product_archive_status = 0 where user_id = {$user_id} and product_id = {$product_id}");
			if($save)
			{
				return 1;
			}
			else
			{
				return 2;
			}
		}

		function confirm_order_lm()
		{
			extract($_POST);
			//$save = $this->db->query("UPDATE tbl_order set order_status = 1 where order_id = $order_id");
			$confirm_order = $this->db->query("UPDATE tbl_order set order_status = 1 where order_id = $order_id");

			$date = new DateTime("now", new DateTimeZone('Asia/Manila') );
			$final_date = $date->format('Y-m-d H:i:s');

			$confirm_order2 = $this->db->query("INSERT INTO `tbl_notification`(`notification_date`, `notification_receiver`, `order_confirmed`) VALUES ('$final_date','$notification_receiver','$order_id')");
			/*if($save)
			{
				return 1;
			}
			else
			{
				return 2;
			}*/
			if($confirm_order && $confirm_order2)
			{
				return 1;
			}
			else
			{
				return 2;
			}
		}

		function complete_order_lm()
		{
			extract($_POST);
			//$save = $this->db->query("UPDATE tbl_order set order_status = 2 where order_id = $order_id");
			$complete_order = $this->db->query("UPDATE tbl_order set order_status = 2 where order_id = $order_id");

			$date = new DateTime("now", new DateTimeZone('Asia/Manila') );
			$final_date = $date->format('Y-m-d H:i:s');

			$complete_order2 = $this->db->query("INSERT INTO `tbl_notification`(`notification_date`, `notification_receiver`, `order_completed`) VALUES ('$final_date','$notification_receiver','$order_id')");
			/*if($save)
			{
				return 1;
			}
			else
			{
				return 2;
			}*/
			if($complete_order && $complete_order2)
			{
				return 1;
			}
			else
			{
				return 2;
			}
		}

		function cancel_order_lm()
		{
			extract($_POST);

			$qry = $this->db->query("SELECT product_id, order_quantity FROM `tbl_order` WHERE order_id = $order_id")->fetch_assoc();

			$product_id = $qry['product_id'];

			$qry2 = $this->db->query("SELECT product_stock FROM `tbl_product` WHERE product_id = '$product_id'")->fetch_assoc();

			$new_quant = $qry['order_quantity'] + $qry2['product_stock'];
			
			$update_prod_stock = $this->db->query("UPDATE `tbl_product` SET `product_stock` = $new_quant WHERE `product_id` = '$product_id'");
			
			$data = "order_cancel_reason = '$order_cancel_reason', order_status = '3' ";
			
			$cancel_order = $this->db->query("UPDATE tbl_order set $data where order_id = $order_id");

			$date = new DateTime("now", new DateTimeZone('Asia/Manila') );
			$final_date = $date->format('Y-m-d H:i:s');

			$cancel_order2 = $this->db->query("INSERT INTO `tbl_notification`(`notification_date`, `notification_receiver`, `order_cancelled`) VALUES ('$final_date','$notification_receiver','$order_id')");
			

			/*$save = $this->db->query("UPDATE tbl_order set order_status = 3 where order_id = $order_id");
			if($save)
			{
				return 1;
			}
			else
			{
				return 2;
			}*/

			if($update_prod_stock && $cancel_order && $cancel_order2)
			{
				return 1;
			}
			else
			{
				return 2;
			}
		}
		
		function update_location_lm()
		{
			extract($_POST);

			$data = "user_lat='$lat', user_lng='$lng'";

			$save = $this->db->query("UPDATE tbl_user_account set $data where user_id = $user_id AND user_type = 'Lensman'");
			if($save)
			{
				return 1;
			}
			else
			{
				return 2;
			}

			return json_encode($data);
		}
	}