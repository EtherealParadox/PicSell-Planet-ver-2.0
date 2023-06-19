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
		function logout3()
		{
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
			/*$data = "";
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
				$d['data']['alert'] = "Comment area shouldn\'t be empty";
				return json_encode($d);
			}
			else
			{
				$save = $this->db->query("INSERT INTO tbl_post_comments set $data ");
				
				if($save){
					$id = $this->db->insert_id;
					$d['status'] = 1;
					$qry = $this->db->query("SELECT c.*, CONCAT(u.user_first_name, ' ', u.user_last_name) as user_name, u.user_profile_image, u.user_nickname FROM tbl_post_comments c inner join tbl_user_account u on u.user_id = c.user_id where c.comment_id = $id ")->fetch_array();
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
							if($k == "user_nickname")
							{
								$k = 'name_type';
								$v = $diff_output .= ' ('.$v.')';
							}
							$d['data'][$k] = $v;
						}
					}
					return json_encode($d);
				}
				else
				{
					return 2;
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
				if(!in_array($k, array('avail_id', 'notification_receiver')) && !is_numeric($k)){
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

			$s_nt = date('Y-m-d', strtotime($start));
			$s_nt2 = date('Y-m-d 23:59:59', strtotime($start));
			$e_nt = date('Y-m-d', strtotime($end));
			$e_nt2 = date('Y-m-d 23:59:59', strtotime($end));

			//$qry = $this->db->query("SELECT * FROM tbl_service_avail WHERE (avail_starting_date_time between '$s_nt' and '$s_nt2') AND (avail_ending_date_time between '$e_nt' and '$e_nt2') AND service_id = $service_id AND (avail_status = 0 OR avail_status = 1 OR avail_status = 2 OR avail_status = 3 OR avail_status = 5)")->num_rows;
			//$qry2 = $this->db->query("SELECT * FROM tbl_service_avail WHERE (avail_starting_date_time between '$s_nt' and '$s_nt2') AND (avail_ending_date_time between '$e_nt' and '$e_nt2') AND user_id = $user_id AND service_id = $service_id AND (avail_status = 3 OR avail_status = 4)")->num_rows;
			$qry = $this->db->query("SELECT * FROM tbl_service_avail sa LEFT JOIN tbl_service_packages sp ON sa.service_id = sp.service_id WHERE (sa.avail_starting_date_time between '$s_nt' and '$s_nt2') AND (sa.avail_ending_date_time between '$e_nt' and '$e_nt2') AND sp.user_id = $notification_receiver AND (sa.avail_status = 0 OR sa.avail_status = 1 OR sa.avail_status = 2 OR sa.avail_status = 5)")->num_rows;
			$qry2 = $this->db->query("SELECT * FROM tbl_service_avail sa LEFT JOIN tbl_service_packages sp ON sa.service_id = sp.service_id WHERE (sa.avail_starting_date_time between '$s_nt' and '$s_nt2') AND (sa.avail_ending_date_time between '$e_nt' and '$e_nt2') AND sa.user_id = $user_id AND sa.service_id = $service_id AND (sa.avail_status = 3 OR sa.avail_status = 4)")->num_rows;


			($qry2>=1) ? $chk = '2' : (($qry>=1) ? $chk = '1' : $chk = '3');

			if($chk == '2')
			{
				return 4;
			}
			else if($chk == '1')
			{
				return 3;
			}
			else
			{
				if(empty($avail_id))
				{
					$save = $this->db->query("INSERT INTO tbl_service_avail set $data ");
					if($save)
					{
						$latest_avail_id = $this->db->insert_id;
						$date = new DateTime("now", new DateTimeZone('Asia/Manila') );
						$final_date = $date->format('Y-m-d H:i:s');

						$save2 = $this->db->query("INSERT INTO `tbl_notification`(`notification_date`, `notification_receiver`, `avail_pending`) VALUES ('$final_date','$notification_receiver','$latest_avail_id') ");
						if($save2)
						{
							return 1;
						}
						else
						{
							return 5;
						}
					}
				}
				else
				{
					$save = $this->db->query("UPDATE tbl_service_avail set $data where avail_id = $avail_id");
					if($save)
					{
						$date = new DateTime("now", new DateTimeZone('Asia/Manila') );
						$final_date = $date->format('Y-m-d H:i:s');

						$save2 = $this->db->query("INSERT INTO `tbl_notification`(`notification_date`, `notification_receiver`, `avail_pending`) VALUES ('$final_date','$notification_receiver','$avail_id') ");
						if($save2)
						{
							return 2;
						}
						else
						{
							return 5;
						}
					}
					else
					{
						return 5;
					}
				}
			}

			
		}

		function resched_avail()
		{
			extract($_POST);
			$data = "";

			foreach($_POST as $k => $v){
				if(!in_array($k, array('avail_id', 'notification_receiver')) && !is_numeric($k)){
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

			$qry = $this->db->query(" SELECT avail_starting_date_time, avail_ending_date_time, avail_status FROM tbl_service_avail where avail_id = $avail_id")->fetch_assoc();
			$old_start = $qry['avail_starting_date_time'];
			$old_end = $qry['avail_ending_date_time'];
			$old_status = $qry['avail_status'];

			$s_nt = date('Y-m-d', strtotime($start));
			$s_nt2 = date('Y-m-d 23:59:59', strtotime($start));
			$e_nt = date('Y-m-d', strtotime($end));
			$e_nt2 = date('Y-m-d 23:59:59', strtotime($end));

			$qry2 = $this->db->query("SELECT * FROM tbl_service_avail sa LEFT JOIN tbl_service_packages sp ON sa.service_id = sp.service_id WHERE (sa.avail_starting_date_time between '$s_nt' and '$s_nt2') AND (sa.avail_ending_date_time between '$e_nt' and '$e_nt2') AND sp.user_id = $notification_receiver AND (sa.avail_status = 0 OR sa.avail_status = 1 OR sa.avail_status = 2 OR sa.avail_status = 5)")->num_rows;
			$qry3 = $this->db->query("SELECT * FROM tbl_service_avail sa LEFT JOIN tbl_service_packages sp ON sa.service_id = sp.service_id WHERE (sa.avail_starting_date_time between '$s_nt' and '$s_nt2') AND (sa.avail_ending_date_time between '$e_nt' and '$e_nt2') AND sa.user_id = $user_id AND sa.service_id = $service_id AND (sa.avail_status = 3 OR sa.avail_status = 4)")->num_rows;

			($qry3>=1) ? $chk = '2' : (($qry2>=1) ? $chk = '1' : $chk = '3');

			if($chk == '2')
			{
				return 3;
			}
			else if($chk == '1')
			{
				return 2;
			}
			else
			{
				$data .= ", old_starting_date_time = '$old_start', old_ending_date_time = '$old_end', old_status='$old_status' ,avail_status = '5' ";
				$resched = $this->db->query("UPDATE tbl_service_avail set $data where avail_id = $avail_id");
				if($resched)
				{
					$date = new DateTime("now", new DateTimeZone('Asia/Manila') );
					$final_date = $date->format('Y-m-d H:i:s');

					$resched2 = $this->db->query("INSERT INTO `tbl_notification`(`notification_date`, `notification_receiver`, `avail_reschedule`) VALUES ('$final_date','$notification_receiver','$avail_id') ");
					if($resched2)
					{
						return 1;
					}
					else
					{
						return 4;
					}
				}
				else
				{
					return 4;
				}
			}
		}

		function upload_downpayment()
		{
			extract($_POST);

			if(isset($payment_image))
			{

				/*$qry = $this->db->query("SELECT * FROM tbl_service_avail WHERE avail_id = $avail_id")->fetch_array();
				foreach($qry as $k => $v)
				{
					if($k == "avail_downpayment_image")
					{
						$avail_downpayment_image = $v;
					}
				}

				if(isset($avail_downpayment_image))
				{
					unlink('../assets/payment/'.$avail_downpayment_image);
				}*/

				$notif_num = $this->db->query("SELECT * FROM tbl_notification WHERE avail_downpayment_sent = $avail_id")->num_rows;

				if($notif_num == 0)
				{
					$date = new DateTime("now", new DateTimeZone('Asia/Manila') );
					$final_date = $date->format('Y-m-d H:i:s');

					$data = "notification_date='$final_date', notification_receiver='$notification_receiver', avail_downpayment_sent='$avail_id'";
					$notif_payment = $this->db->query("INSERT INTO tbl_notification set $data ");
				}
				
				$new_img_name = uniqid("IMG-", true) . ".png";
				
				$data = "avail_downpayment_image='$new_img_name'";

				$save = $this->db->query("UPDATE tbl_service_avail set $data where avail_id = $avail_id");

				list($type, $payment_image) = explode(';', $payment_image);
				list(, $payment_image)      = explode(',', $payment_image);
				$payment_image = str_replace(' ', '+', $payment_image);
				$payment_image = base64_decode($payment_image);
				
				if($save && file_put_contents( '../assets/payment/'.$new_img_name.'' , $payment_image ))
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
				return 3;
			}
		}

		function cancel_avail_cm(){
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

			$save = $this->db->query("UPDATE tbl_service_avail set $data where avail_id = $avail_id");

			$date = new DateTime("now", new DateTimeZone('Asia/Manila') );
			$final_date = $date->format('Y-m-d H:i:s');

			$save2 = $this->db->query("INSERT INTO `tbl_notification`(`notification_date`, `notification_receiver`, `avail_cancelled`) VALUES ('$final_date','$notification_receiver','$avail_id')");
			if($save && $save2)
			{
				return 1;
			}
			else
			{
				return 2;
			}
		}

		function save_review_service(){
			extract($_POST);
			//$data = "";

			/*foreach($_POST as $k => $v){
				if(!is_numeric($k)){
					if(empty($data)){
						$data .= " $k='$v' ";
					}
					else if($k == "user_id"){
						$u_id = $v;
						$data .= ", $k='$v' ";
					}
					else if($k == "service_id"){
						$s_id = $v;
						$data .= ", $k='$v' ";
					}
					else{
						$data .= ", $k='$v' ";
					}
				}
			}*/

			$user_id = mysqli_real_escape_string($this->db, $_SESSION['login_user_id']);
			$feedback_message = mysqli_real_escape_string($this->db, $feedback_message);
			$feedback_rate = mysqli_real_escape_string($this->db, $feedback_rate);
			$date = new DateTime("now", new DateTimeZone('Asia/Manila') );
			$final_date = $date->format('Y-m-d H:i:s');

			$data = " feedback_rate = '$feedback_rate'";
			$data .= ", feedback_message = '$feedback_message'";
			$data .= ", feedback_date = '$final_date'";
			$data .= ", service_id = '$service_id'";
			
			$check = $this->db->query("SELECT * FROM `tbl_feedback` WHERE `user_id` = '$user_id' AND `service_id` = '$service_id'")->num_rows;
			if($check == 1)
			{
				$save = $this->db->query("UPDATE `tbl_feedback` set $data where user_id = $user_id AND service_id = $service_id");
				if($save)
				{
					return 1;
				}
				else
				{
					return 3;
				}
			}
			else
			{
				$data .= ", user_id = '$user_id'";
				$save = $this->db->query("INSERT INTO tbl_feedback set $data");
				if($save)
				{
					return 2;
				}
				else
				{
					return 3;
				}
			}
		}

		function save_review_lensman(){
			extract($_POST);
			/*$data = "";

			foreach($_POST as $k => $v){
				if(!is_numeric($k)){
					if(empty($data)){
						$data .= " $k='$v' ";
					}
					else if($k == "user_id"){
						$u_id = $v;
						$data .= ", $k='$v' ";
					}
					else if($k == "lensman_id"){
						$l_id = $v;
						$data .= ", $k='$v' ";
					}
					else{
						$data .= ", $k='$v' ";
					}
				}
			}*/

			$user_id = mysqli_real_escape_string($this->db, $_SESSION['login_user_id']);
			$feedback_message = mysqli_real_escape_string($this->db, $feedback_message);
			$feedback_rate = mysqli_real_escape_string($this->db, $feedback_rate);
			$date = new DateTime("now", new DateTimeZone('Asia/Manila') );
			$final_date = $date->format('Y-m-d H:i:s');

			$data = " feedback_rate = '$feedback_rate'";
			$data .= ", feedback_message = '$feedback_message'";
			$data .= ", feedback_date = '$final_date'";
			$data .= ", lensman_id = '$lensman_id'";
			
			$check = $this->db->query("SELECT * FROM `tbl_feedback` WHERE `user_id` = '$user_id' AND `lensman_id` = '$lensman_id'")->num_rows;
			if($check == 1)
			{
				$save = $this->db->query("UPDATE `tbl_feedback` set $data where user_id = $user_id AND lensman_id = $lensman_id");
				if($save)
				{
					return 1;
				}
				else
				{
					return 3;
				}
			}
			else
			{
				$data .= ", user_id = '$user_id'";
				$save = $this->db->query("INSERT INTO tbl_feedback set $data");
				if($save)
				{
					return 2;
				}
				else
				{
					return 3;
				}
			}
			
		}

		function update_notif_status(){
			$update_notif_status = $this->db->query("UPDATE `tbl_notification` SET `notification_status` = 1 WHERE `notification_receiver` = {$_SESSION['login_user_id']}  AND `notification_status` = 0");
			if($update_notif_status)
			{
				return 1;
			}
		}

		function save_cart(){
			extract($_POST);
			$data = "";

			$check = $this->db->query("SELECT * FROM `tbl_cart` WHERE `user_id` = '$user_id' AND `product_id` = '$product_id' AND `cart_status` = 0")->num_rows;

			if($check == 0)
			{
				foreach($_POST as $k => $v){
					if(!is_numeric($k)){
						if(empty($data)){
							$data .= " $k='$v' ";
						}
						else{
							$data .= ", $k='$v' ";
						}
					}
				}
				$save = $this->db->query("INSERT INTO tbl_cart set $data");
				if($save)
				{
					return 1;
				}
			}
			else
			{
				return 2;
			}

			
		}

		function delete_cart(){
			extract($_POST);

			$delete = $this->db->query("DELETE FROM `tbl_cart` WHERE `cart_id` = '$cart_id'");
			if($delete)
			{
				return 1;
			}
			else
			{
				return 2;
			}
		}

		function minus_quant()
		{
			extract($_POST);

			$qry = $this->db->query("SELECT `cart_quantity` FROM `tbl_cart` WHERE `cart_id` = '$cart_id'")->fetch_array();
			$quant = "";
			foreach($qry as $k => $v)
			{
				if($k == "cart_quantity")
				{
					$quant .= $v;
				}
			}
			$qry2 = $this->db->query("SELECT * FROM `tbl_product` WHERE `product_id` = '$product_id'")->fetch_array();
			foreach($qry2 as $k => $v)
			{
				if($k == "product_price")
				{
					$prod_price = $v;
				}
			}
			$f_quant = $quant-1;
			if($f_quant<=0)
			{
				$f['result'] = 3;
				return json_encode($f);
			}
			else
			{
				$update_minus_quant = $this->db->query("UPDATE `tbl_cart` SET `cart_quantity` = $f_quant WHERE `cart_id` = '$cart_id'");
				if($update_minus_quant)
				{
					$f['result'] = 1;
					$f['cart_quantity'] = $f_quant;
					$f['subtotal'] = $f_quant*$prod_price;
					return json_encode($f);
				}
				else
				{
					$f['result'] = 2;
					return json_encode($f);
				}
			}
		}

		function plus_quant()
		{
			extract($_POST);
			//$pr_id = $product_id;
			//$c_id = $cart_id;

			$qry = $this->db->query("SELECT * FROM `tbl_cart` WHERE `cart_id` = '$cart_id'")->fetch_array();
			$quant = "";
			foreach($qry as $k => $v)
			{
				if($k == "cart_quantity")
				{
					$quant .= $v;
				}
			}
			$qry2 = $this->db->query("SELECT * FROM `tbl_product` WHERE `product_id` = '$product_id'")->fetch_array();
			foreach($qry2 as $k => $v)
			{
				if($k == "product_stock")
				{
					$current_prod_stock = $v;
				}
				if($k == "product_price")
				{
					$prod_price = $v;
				}
			}
			$f_quant = $quant+1;
			if($f_quant > $current_prod_stock)
			{
				$f['result'] = 3;
				return json_encode($f);
			}
			else
			{
				$update_plus_quant = $this->db->query("UPDATE `tbl_cart` SET `cart_quantity` = $f_quant WHERE `cart_id` = '$cart_id'");
				if($update_plus_quant)
				{
					$f['result'] = 1;
					$f['cart_quantity'] = $f_quant;
					$f['subtotal'] = $f_quant*$prod_price;
					return json_encode($f);
				}
				else
				{
					$f['result'] = 2;
					return json_encode($f);
				}
			}
		}

		function buy_now()
		{
			extract($_POST);

			$data = "order_quantity='$order_quant', user_id='$user_id', product_id='$prod_id'";
			$qry = $this->db->query("SELECT * FROM `tbl_product` WHERE `product_id` = '$prod_id'")->fetch_array();
			foreach($qry as $k => $v)
			{
				if($k == "product_stock")
				{
					$current_prod_quant = $v;
				}
			}
			$new_quant = $current_prod_quant - $order_quant;
			//updating the number of stocks
			$update_prod_stock = $this->db->query("UPDATE `tbl_product` SET `product_stock` = $new_quant WHERE `product_id` = '$prod_id'");
			//inserting data to tbl_order
			$buy_now = $this->db->query("INSERT INTO tbl_order set $data");

			$date = new DateTime("now", new DateTimeZone('Asia/Manila') );
			$final_date = $date->format('Y-m-d H:i:s');
			$latest_order_id = $this->db->insert_id;
			//inserting data to tbl_notification
			$buy_now2 = $this->db->query("INSERT INTO `tbl_notification`(`notification_date`, `notification_receiver`, `order_pending`) VALUES ('$final_date','$notification_receiver','$latest_order_id')");
			if($buy_now && $buy_now2 && $update_prod_stock)
			{
				return 1;
			}
			else
			{
				return 2;
			}
		}

		function confirm_order()
		{
			extract($_POST);
			$data = "";
			$cart_id_arr = json_decode($cart_id_arr, true);
			$cart_quant_arr = json_decode($cart_quant_arr, true);
			$prod_id_arr = json_decode($prod_id_arr, true);
			$notif_rcvr_id_arr = json_decode($notif_rcvr_id_arr, true);

			$allSet = true;
			for($i=0; $i < count($cart_id_arr); $i++)
			{
				$data = "";
				$cart_id = $cart_id_arr[$i];
				$cart_quant = $cart_quant_arr[$i];
				$prod_id = $prod_id_arr[$i];
				$notif_rcvr_id = $notif_rcvr_id_arr[$i];
				$qry = $this->db->query("SELECT * FROM `tbl_product` WHERE `product_id` = '$prod_id'")->fetch_array();
				foreach($qry as $k => $v)
				{
					if($k == "product_stock")
					{
						$current_prod_quant = $v;
					}
				}
				$new_quant = $current_prod_quant - $cart_quant;
				//updating the number of stocks
				$update_prod_stock = $this->db->query("UPDATE `tbl_product` SET `product_stock` = $new_quant WHERE `product_id` = '$prod_id'");
				
				//inserting data to tbl_order
				$data .= " order_quantity='$cart_quant', user_id='$user_id', product_id='$prod_id'  ";
				$confirm_order = $this->db->query("INSERT INTO tbl_order set $data");

				//inserting data to tbl_notification
				$date = new DateTime("now", new DateTimeZone('Asia/Manila') );
				$final_date = $date->format('Y-m-d H:i:s');
				$latest_order_id = $this->db->insert_id;
				$confirm_order2 = $this->db->query("INSERT INTO `tbl_notification`(`notification_date`, `notification_receiver`, `order_pending`) VALUES ('$final_date','$notif_rcvr_id','$latest_order_id')");
				
				//updating the cart so that we can order same item in next time
				$update_cart = $this->db->query("UPDATE `tbl_cart` SET `cart_status` = 1 WHERE `cart_id` = '$cart_id'");
				if(!$update_prod_stock && !$confirm_order && !$confirm_order2 && !$update_cart)
				{
					$allSet = false;
					break;
				}
				else
				{
					continue;
				}
			}
			if($allSet)
			{
				return 1;
			}
			else
			{
				return 2;
			}
		}

		function cancel_order_cm()
		{
			extract($_POST);

			$qry = $this->db->query("SELECT product_id, order_quantity FROM `tbl_order` WHERE order_id = $order_id")->fetch_assoc();

			$product_id = $qry['product_id'];

			$qry2 = $this->db->query("SELECT product_stock FROM `tbl_product` WHERE product_id = '$product_id'")->fetch_assoc();

			$new_quant = $qry['order_quantity'] + $qry2['product_stock'];
			
			$update_prod_stock = $this->db->query("UPDATE `tbl_product` SET `product_stock` = $new_quant WHERE `product_id` = '$product_id'");
			
			$data = "order_cancel_reason = '$order_cancel_reason', order_status = '3' ";
			
			$cancel_order = $this->db->query("UPDATE `tbl_order` set $data where order_id = $order_id");

			$date = new DateTime("now", new DateTimeZone('Asia/Manila') );
			$final_date = $date->format('Y-m-d H:i:s');

			$cancel_order2 = $this->db->query("INSERT INTO `tbl_notification`(`notification_date`, `notification_receiver`, `order_cancelled`) VALUES ('$final_date','$notification_receiver','$order_id')");

			if($update_prod_stock && $cancel_order && $cancel_order2)
			{
				return 1;
			}
			else
			{
				return 2;
			}
		}

		function save_review_product()
		{
			extract($_POST);
			//$data = "";

			/*foreach($_POST as $k => $v){
				if(!is_numeric($k)){
					if(empty($data)){
						$data .= " $k='$v' ";
					}
					else if($k == "user_id"){
						$u_id = $v;
						$data .= ", $k='$v' ";
					}
					else if($k == "product_id"){
						$pr_id = $v;
						$data .= ", $k='$v' ";
					}
					else{
						$data .= ", $k='$v' ";
					}
				}
			}*/

			$user_id = mysqli_real_escape_string($this->db, $_SESSION['login_user_id']);
			$feedback_message = mysqli_real_escape_string($this->db, $feedback_message);
			$feedback_rate = mysqli_real_escape_string($this->db, $feedback_rate);
			$date = new DateTime("now", new DateTimeZone('Asia/Manila') );
			$final_date = $date->format('Y-m-d H:i:s');

			$data = " feedback_rate = '$feedback_rate'";
			$data .= ", feedback_message = '$feedback_message'";
			$data .= ", feedback_date = '$final_date'";
			$data .= ", product_id = '$product_id'";
			
			$check = $this->db->query("SELECT * FROM `tbl_feedback` WHERE `user_id` = '$user_id' AND `product_id` = '$product_id'")->num_rows;
			if($check == 1)
			{
				$save = $this->db->query("UPDATE `tbl_feedback` set $data where user_id = $user_id AND product_id = $product_id");
				if($save)
				{
					return 1;
				}
				else
				{
					return 3;
				}
			}
			else
			{
				$data .= ", user_id = '$user_id'";
				$save = $this->db->query("INSERT INTO tbl_feedback set $data");
				if($save)
				{
					return 2;
				}
				else
				{
					return 3;
				}
			}
		}
	}