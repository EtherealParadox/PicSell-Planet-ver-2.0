    <?php

    use LDAP\Result;

    class myAdmin
    {
        private $host;
        private $username;
        private $password;
        private $database;
        private $link;

        function __construct()
        {
            $this->host = "localhost";
            $this->username = "root";
            $this->password = "";
            $this->database = "picsellplanet_database";

            $this->link = mysqli_connect(
                $this->host,
                $this->username,
                $this->password,
                $this->database
            );
            if (mysqli_connect_errno()) {
                $log = "MySQL Error: " . mysqli_connect_error();
                exit($log);
            }
        }

        function __destruct()
        {
            if (isset($this->link)) {
                mysqli_close($this->link);
            }
        }

        //Admin Profile Info  
        
        public function change_admin_name()
        {
            extract($_POST);

            $data = "admin_name = '$admin_name'";

            $save = $this->link->query("UPDATE tbl_admin_account set $data where admin_id = $admin_id");
            if($save)
            {
                return 1;
            }
            else
            {
                return 2;
            }
        }

        public function change_admin_profile(){
			extract($_POST);

			if(isset($new_prof_image))
			{
				
				$new_img_name = uniqid("IMG-", true) . ".png";
				
				$data = "admin_profile_image='$new_img_name'";

				$save = $this->link->query("UPDATE tbl_admin_account set $data where admin_id = $admin_id");

				list($type, $new_prof_image) = explode(';', $new_prof_image);
				list(, $new_prof_image)      = explode(',', $new_prof_image);
				$new_prof_image = str_replace(' ', '+', $new_prof_image);
				$new_prof_image = base64_decode($new_prof_image);
				
				if($save && file_put_contents( '../assets/img/'.$new_img_name.'' , $new_prof_image ))
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

        public function change_admin_pass()
        {
            extract($_POST);

            if(strlen($password) >= 8 && strlen($cPassword) >= 8)
			{
				if($password === $cPassword)
				{
					if(preg_match("/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[!@#$%^&*()_.])[A-Za-z\d!@#$%^&*()_.]{8,}$/", $password) || preg_match("/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)[A-Za-z\d!@#$%^&*()_.]{8,}$/", $password))
					{
						$hashed_password = password_hash($password, PASSWORD_DEFAULT);
						$data = "admin_password='$hashed_password'";
						$save = $this->link->query("UPDATE tbl_admin_account set $data where admin_id = $admin_id");

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
        }
        //Total Customers
            public function totalCustomer(){
                $qstr = "SELECT COUNT(*) FROM `tbl_user_account` WHERE `user_type` = 'Customer';";
                $result = mysqli_query($this->link, $qstr);
                $count = mysqli_fetch_assoc($result)['COUNT(*)'];
                echo '<a href="admin_accounts.php"><h1>'.$count.'</h1></a>';
            }
            
            public function totalLensman(){
                $qstr = "SELECT COUNT(*) FROM `tbl_user_account` WHERE `user_type` = 'Lensman';";
                $result = mysqli_query($this->link, $qstr);
                $count = mysqli_fetch_assoc($result)['COUNT(*)'];
                echo '<a href="admin_accounts.php"><h1>'.$count.'</h1></a>';
            }

            public function totalPost(){
                $qstr = "SELECT COUNT(*) FROM `tbl_post`";
                $result = mysqli_query($this->link, $qstr);
                $count = mysqli_fetch_assoc($result)['COUNT(*)'];
                echo '<a href="admin_newsfeed.php"><h1>'.$count.'</h1></a>';
            }
            
            public function totalServices(){
                $qstr = "SELECT COUNT(*) FROM `tbl_service_packages`";
                $result = mysqli_query($this->link, $qstr);
                $count = mysqli_fetch_assoc($result)['COUNT(*)'];
                echo '<a href="admin_services.php"><h1>'.$count.'</h1></a>';
            }

            public function totalProducts(){
                $qstr = "SELECT COUNT(*) FROM `tbl_product`";
                $result = mysqli_query($this->link, $qstr);
                $count = mysqli_fetch_assoc($result)['COUNT(*)'];
                echo '<a href="admin_products.php"><h1>'.$count.'</h1></a>';
            }

        //admin dashboard

            public function tblDashPost(){
                $qstr = "SELECT * FROM `tbl_post` ";
                $result = mysqli_query($this->link, $qstr);
                $records = array();
        
                if (mysqli_num_rows($result) > 0) {
                while ($row = mysqli_fetch_assoc($result)) {
                    $records[] =
                        [
                            'post_id' => $row['post_id'],
                            'post_content' => $row['post_content'],
                            'post_type' => $row['post_type'],
                            'post_date' => $row['post_date'],
                            'user_id' => $row['user_id'],
                        ];
                }
            } else {
                $records = null;
                }
                    mysqli_free_result($result);
                    return $records;
            }

            public function tblDashCustomer(){
                $qstr = "SELECT *, CONCAT(user_first_name , ' ', user_last_name) as user_name FROM `tbl_user_account` WHERE user_type='Customer' ";
                $result = mysqli_query($this->link, $qstr);
                $records = array();
        
                if (mysqli_num_rows($result) > 0) {
                while ($row = mysqli_fetch_assoc($result)) {
                    $records[] =
                        [
                            'user_id' => $row['user_id'],
                            'user_name' => $row['user_name'],
                        ];
                }
            } else {
                $records = null;
                }
                    mysqli_free_result($result);
                    return $records;
            }

        //end of admin dashboard

        public function tblPost(){
        $qstr = "SELECT  t1.post_id, t1.post_content, t1.post_date, CONCAT(t2.user_first_name , ' ', t2.user_last_name) as user_name FROM `tbl_post` t1
        JOIN `tbl_user_account` t2
        ON t1.user_id = t2.user_id WHERE NOT post_archive_status = 0;";
        $result = mysqli_query($this->link, $qstr);
        $records = array();

        if (mysqli_num_rows($result) > 0) {
            while ($row = mysqli_fetch_assoc($result)) {
                $records[] =
                    [
                        'post_id' => $row['post_id'],
                        'post_content' => $row['post_content'],
                        'post_date' => $row['post_date'],
                        'user_name' => $row['user_name'],
                    ];
            }
        } else {
            $records = null;
            }
                mysqli_free_result($result);
                return $records;
        }
        public function tblServices(){
            $qstr = "SELECT t1.service_id, t1.service_name, t1.service_price, t1.service_description, CONCAT(t2.user_first_name , ' ', t2.user_last_name) as user_name FROM `tbl_service_packages` t1
            JOIN `tbl_user_account` t2
            ON t1.user_id = t2.user_id WHERE NOT service_archive_status = 0;";
            $result = mysqli_query($this->link, $qstr);
            $records = array();
    
            if (mysqli_num_rows($result) > 0) {
            while ($row = mysqli_fetch_assoc($result)) {
                $records[] =
                    [
                        'service_id' => $row['service_id'],
                        'service_name' => $row['service_name'],
                        'service_price' => $row['service_price'],
                        'service_description' => $row['service_description'],
                        'user_name' => $row['user_name'],
                    ];
            }
        } else {
            $records = null;
            }
                mysqli_free_result($result);
                return $records;
        }
        public function tblProduct(){
            $qstr = "SELECT t1.product_id, t1.product_name, t1.product_price, t1.product_description, CONCAT(t2.user_first_name , ' ', t2.user_last_name) as user_name
            FROM `tbl_product` t1
            JOIN `tbl_user_account` t2
            ON t1.user_id = t2.user_id WHERE NOT product_archive_status = 0;";
            $result = mysqli_query($this->link, $qstr);
            $records = array();
    
            if (mysqli_num_rows($result) > 0) {
            while ($row = mysqli_fetch_assoc($result)) {
                $records[] =
                    [
                        'product_id' => $row['product_id'],
                        'product_name' => $row['product_name'],
                        'product_price' => $row['product_price'],
                        'product_description' => $row['product_description'],
                        'user_name' => $row['user_name'],
                    ];
            }
        } else {
            $records = null;
            }
                mysqli_free_result($result);
                return $records;
        }

        public function tblFeedback(){
            $qstr = "SELECT t1.feedback_id, t1.feedback_rate, t1.feedback_message, t1.feedback_date, CONCAT(t2.user_first_name , ' ', t2.user_last_name) as user_name
            FROM `tbl_feedback` t1
            JOIN `tbl_user_account` t2
            ON t1.user_id = t2.user_id WHERE NOT feedback_archive_status = 0;";
            $result = mysqli_query($this->link, $qstr);
            $records = array();
    
            if (mysqli_num_rows($result) > 0) {
            while ($row = mysqli_fetch_assoc($result)) {
                $records[] =
                    [
                        'feedback_id' => $row['feedback_id'],
                        'feedback_rate' => $row['feedback_rate'],
                        'feedback_message' => $row['feedback_message'],
                        'feedback_date' => $row['feedback_date'],
                        'user_name' => $row['user_name'],
                    ];
            }
        } else {
            $records = null;
            }
                mysqli_free_result($result);
                return $records;
        }

        public function tblAccounts(){
            $qstr = "SELECT *, CONCAT(user_first_name , ' ', user_last_name) as user_name FROM `tbl_user_account`";
            $result = mysqli_query($this->link, $qstr);
            $records = array();
    
            if (mysqli_num_rows($result) > 0) {
            while ($row = mysqli_fetch_assoc($result)) {
                $records[] =
                    [
                        'user_id' => $row['user_id'],
                        'user_name' => $row['user_name'],
                        'user_email' => $row['user_email'],
                        'user_type' => $row['user_type'],
                        'user_address' => $row['user_address'],
                        'user_sex' => $row['user_sex'],
                        'user_contact' => $row['user_contact'],
                        'user_archive_status' => $row['user_archive_status'],
                    ];
            }
        } else {
            $records = null;
            }
                mysqli_free_result($result);
                return $records;
        }

        public function archive_account()
        {
            extract($_POST);

            $qstr = "UPDATE `tbl_user_account` SET user_verified='0', user_archive_status='0' WHERE `user_id` = $user_id";
            $result = mysqli_query($this->link, $qstr);

            $qstr2 = "DELETE FROM `tbl_messages_userlist` WHERE (`sender_id` = $user_id OR `receiver_id` = $user_id)";
            $result2 = mysqli_query($this->link, $qstr2);

            if($result && $result2)
            {
                return 1;
            }
            else
            {
                return 2;
            }
        }

        public function delete_account()
        {
            extract($_POST);

            $qstr = "DELETE FROM `tbl_user_account` WHERE `user_id` = $user_id";
            $result = mysqli_query($this->link, $qstr);

            $qstr2 = "DELETE FROM `tbl_messages_userlist` WHERE (`sender_id` = $user_id OR `receiver_id` = $user_id)";
            $result2 = mysqli_query($this->link, $qstr2);

            if($result && $result2)
            {
                return 1;
            }
            else
            {
                return 2;
            }
        }

        public function archive_feedback()
        {
            extract($_POST);

            $qstr = "UPDATE `tbl_feedback` SET feedback_archive_status='0' WHERE `feedback_id` = $feedback_id";
            $result = mysqli_query($this->link, $qstr);

            if(mysqli_affected_rows($this->link) == 1)
            {
                return 1;
            }
            else
            {
                return 2;
            }
        }

        public function archive_post()
        {
            extract($_POST);

            $qstr = "UPDATE `tbl_post` SET post_archive_status='0' WHERE `post_id` = $post_id";
            $result = mysqli_query($this->link, $qstr);

            if(mysqli_affected_rows($this->link) == 1)
            {
                return 1;
            }
            else
            {
                return 2;
            }
        }

        public function remove_post()
        {
            extract($_POST);


            $qstr1 = "DELETE FROM `tbl_post` WHERE `post_id` = $post_id";
            $result1 = mysqli_query($this->link, $qstr1);

            $qstr2 = "DELETE FROM `tbl_notification` WHERE `post_reported` = $report_id";
            $result2 = mysqli_query($this->link, $qstr2);

            $qstr3 = "DELETE FROM `tbl_reports` WHERE `report_id` = $report_id";
            $result3 = mysqli_query($this->link, $qstr3);

            if($result1 && $result2 && $result3)
            {
                return 1;
            }
            else
            {
                return 2;
            }
        }

        public function archive_product()
        {
            extract($_POST);

            $qstr = "UPDATE `tbl_product` SET product_archive_status='0' WHERE `product_id` = $product_id";
            $result = mysqli_query($this->link, $qstr);

            if(mysqli_affected_rows($this->link) == 1)
            {
                return 1;
            }
            else
            {
                return 2;
            }
        }

        public function archive_service()
        {
            extract($_POST);

            $qstr = "UPDATE `tbl_service_packages` SET service_archive_status='0' WHERE `service_id` = $service_id";
            $result = mysqli_query($this->link, $qstr);

            if(mysqli_affected_rows($this->link) == 1)
            {
                return 1;
            }
            else
            {
                return 2;
            }
        }

        public function send_verification()
        {
            extract($_POST);

            require_once '../../registration/email_verification.php';

            $v_code = bin2hex(random_bytes(16));

            $data = "user_verification_code='$v_code', user_archive_status='1'";

            $qstr = "UPDATE `tbl_user_account` SET $data WHERE `user_id` = $user_id";
            $result = mysqli_query($this->link, $qstr);

            if(mysqli_affected_rows($this->link) == 1 && sendMailOfAdmin($user_email, $v_code))
            {
                return 1;
            }
            else
            {
                return 2;
            }
        }

        public function resend_email_lm()
        {
            extract($_POST);

            require_once '../../registration/email_verification.php';

            $v_code = bin2hex(random_bytes(16));

            $data = "user_verification_code='$v_code', user_archive_status='1'";

            $qstr = "UPDATE `tbl_user_account` SET $data WHERE `user_id` = $user_id";
            $result = mysqli_query($this->link, $qstr);

            if(mysqli_affected_rows($this->link) == 1 && requestResendMailLensman($user_email, $v_code))
            {
                return 1;
            }
            else
            {
                return 2;
            }
        }

        public function resend_email_cm()
        {
            extract($_POST);

            require_once '../../registration/email_verification.php';

            $v_code = bin2hex(random_bytes(16));

            $data = "user_verification_code='$v_code', user_archive_status='1'";

            $qstr = "UPDATE `tbl_user_account` SET $data WHERE `user_id` = $user_id";
            $result = mysqli_query($this->link, $qstr);

            if(mysqli_affected_rows($this->link) == 1 && requestResendMailCustomer($user_email, $v_code))
            {
                return 1;
            }
            else
            {
                return 2;
            }
        }

        public function reactivate_cm()
        {
            extract($_POST);

            require_once '../../registration/email_verification.php';

            $v_code = bin2hex(random_bytes(16));

            $data = "user_verification_code='$v_code', user_archive_status='1'";

            $qstr = "UPDATE `tbl_user_account` SET $data WHERE `user_id` = $user_id";
            $result = mysqli_query($this->link, $qstr);

            if(mysqli_affected_rows($this->link) == 1 && reactivateMailCustomer($user_email, $v_code))
            {
                return 1;
            }
            else
            {
                return 2;
            }
        }

        public function update_notif_status_adm(){
			
            $qstr = "UPDATE `tbl_notification` SET `notification_status` = 1 WHERE `notification_receiver` = 'Admin'  AND `notification_status` = 0";
            $result = mysqli_query($this->link, $qstr);

            if($result)
            {
                return 1;
            }
            else
            {
                return 2;
            }
		}
    }