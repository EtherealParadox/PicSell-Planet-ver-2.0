<?php
        session_start();
        require 'adminContent.php';

        if (!isset($_SESSION['login_admin_email']) && $_SESSION['logged_in_adm'] != true) {
            header("location: ../admin_login.php");
        }
?>

<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Document</title>
</head>
	<body>
		<?php
			include '../db_connect.php';
            $user = $conn->query("SELECT * from tbl_user_account where user_id = {$_GET['lensman_id']}");
			while($row=$user->fetch_assoc())
			{
				echo '<img src="../../'.$row['user_profile_image'].'"  style="width:200px;">';
				echo $row['user_first_name'];
			}
		?>
	</body>
</html>