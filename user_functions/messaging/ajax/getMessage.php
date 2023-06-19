<?php 

session_start();
		define('TIMEZONE', 'Asia/Manila');
		date_default_timezone_set(TIMEZONE);

# check if the user is logged in
if (isset($_SESSION['login_user_id'])) {

	if (isset($_POST['receiver_id'])) {
	
	# database connection file
	include '../db_conn.php';

	$id_1  = $_SESSION['login_user_id'];
	$id_2  = $_POST['receiver_id'];
	$opend = 0;

	$sql = "SELECT * FROM tbl_messages
	        WHERE receiver_id=?
	        AND   sender_id= ?
	        ORDER BY message_id ASC";
	$stmt = $conn->prepare($sql);
	$stmt->execute([$id_1, $id_2]);

	if ($stmt->rowCount() > 0) {
	    $chats = $stmt->fetchAll();

	    # looping through the chats
	    foreach ($chats as $chat) {
	    	if ($chat['message_status'] == 0) {
	    		
	    		$opened = 1;
	    		$chat_id = $chat['message_id'];

	    		$sql2 = "UPDATE tbl_messages
	    		         SET message_status = ?
	    		         WHERE message_id = ?";
	    		$stmt2 = $conn->prepare($sql2);
	            $stmt2->execute([$opened, $chat_id]); 

					

	            ?>
	            <?php
	    	}
	    }
	}

 }

}else {
	header("Location: ../../index.php");
	exit;
}