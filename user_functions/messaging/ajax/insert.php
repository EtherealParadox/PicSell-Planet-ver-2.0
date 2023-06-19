<?php 

session_start();

	    // setting up the time Zone
		// It Depends on your location or your P.c settings
		define('TIMEZONE', 'Asia/Manila');
		date_default_timezone_set(TIMEZONE);

		$time = date("l, h:i a");
		$date = date("Y-m-d H:i:s");

# check if the user is logged in
if (isset($_SESSION['login_user_id'])) {

	if (isset($_POST['message_content']) &&
        isset($_POST['receiver_id'])) {
	
	# database connection file
	include '../db_conn.php';

	# get data from XHR request and store them in var
	$message = $_POST['message_content'];
	$to_id = $_POST['receiver_id'];

	# get the logged in user's username from the SESSION
	$from_id = $_SESSION['login_user_id'];

	// setting up the time Zone
	// It Depends on your location or your P.c settings

	

	$sql = "INSERT INTO 
	       tbl_messages (message_content, sender_id, receiver_id) 
	       VALUES (?, ?, ?)";
	$stmt = $conn->prepare($sql);
	$res  = $stmt->execute([$message, $from_id, $to_id]);
  
	$dbh3 = "UPDATE tbl_messages_userlist
	SET userlist_date = ?	
	WHERE (sender_id = ? AND receiver_id = ?)
	OR (receiver_id = ? AND sender_id = ?)";
	$stmt22 = $conn->prepare($dbh3); 
	$stmt22->execute([$date, $from_id, $to_id, $from_id, $to_id]);
    # if the message inserted
    if ($res) {
    	/**
       check if this is the first
       conversation between them
       **/
       $sql2 = "SELECT * FROM tbl_messages_userlist
               WHERE (sender_id=? AND receiver_id=?)
               OR    (receiver_id=? AND sender_id=?)";
       $stmt2 = $conn->prepare($sql2);
	   $stmt2->execute([$from_id, $to_id, $from_id, $to_id]);



		if ($stmt2->rowCount() == 0 ) {
			# insert them into conversations table 
			$sql3 = "INSERT INTO 
			         tbl_messages_userlist(sender_id, receiver_id)
			         VALUES (?,?)";
			
			$stmt3 = $conn->prepare($sql3); 
			$stmt3->execute([$from_id, $to_id]);
			$dbh = "UPDATE tbl_messages_userlist
			SET userlist_date = ?
			WHERE (sender_id = ? AND receiver_id = ?)
			OR (receiver_id = ? AND sender_id = ?)";
			$stmt4 = $conn->prepare($dbh); 
			$stmt4->execute([$date, $from_id, $to_id, $from_id, $to_id]);

		}
		else{

		}

	
		?>

		<p class="rtext align-self-end
		          border rounded p-2 mb-1">
		    <?=$message?>  
		    <small class="d-block"><?=$time?></small>      	
		</p>

    <?php 
     }
  }
}else {
	header("Location: ../../index.php");
	exit;
}