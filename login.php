	<?php
	session_start();

	$session_logged_in_lm = isset($_SESSION['logged_in_lm']);
	$session_user_lm = isset($_SESSION['user_id_lm']);
	if ($session_user_lm && $session_logged_in_lm == true) {
		header("location: user_functions/lensman/lensman_dashboard.php?page=home");
	}

	$session_logged_in_cm = isset($_SESSION['logged_in_cm']);
	$session_user_cm = isset($_SESSION['user_id_cm']);
	if ($session_user_cm && $session_logged_in_cm == true) {
		header("location: user_functions/customer/customer_dashboard.php?page=home");
	}
	?>


	<!DOCTYPE html>
	<html lang="en">

	<head>
		<meta charset="UTF-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<title>Login | Pic-Sell Planet</title>
		<link rel="stylesheet" href="css/style_login.css">
		<link rel="shortcut icon" href="css/images/shortcut-icon.png">
	</head>

	<body>


	<script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
	<script>
	<?php
		if(isset($_SESSION['alert_text_lg']) && $_SESSION['alert_session_lg']==true):
	?>
			
		Swal.fire({
			position: 'top',
			icon: 'error',
			title: '<?php echo $_SESSION['alert_text_lg'] ?>',
			toast: true,
			showConfirmButton: false, 
			timer: 1500
		})
	<?php
			if(isset($_SESSION['result_lg']) && $_SESSION['result_lg']==true)
			{
	?>
					
            Swal.fire({
                position: 'top',
                icon: 'success',
                title: '<?php echo $_SESSION['alert_text_lg'] ?>',
                toast: true,
                showConfirmButton: false, 
                timer: 4500
            })
	<?php
			unset($_SESSION['result_lg']);
			}
			elseif(isset($_SESSION['result_lg']) && $_SESSION['result_lg']==false)
			{
	?>
            Swal.fire({
                position: 'top',
                icon: 'warning',
                title: '<?php echo $_SESSION['alert_text_lg'] ?>',
                toast: true,
                showConfirmButton: false, 
                timer: 14500
            })
	<?php
			unset($_SESSION['result_lg']);
			}
                
		(isset($_SESSION['relogin_email'])) ? $relogin_email = $_SESSION['relogin_email'] : $relogin_email = '';

		unset($_SESSION['relogin_email']);
		unset($_SESSION['alert_text_lg']);
		unset($_SESSION['alert_session']);
		endif; 
	?>
	</script>
	<div class="container">
		
		<div class="title">
			<span style="margin-top: 25px;">Login</span>
			<img src="css/images/brand-logo.png" style="width: 50%; height:auto; margin-bottom: 20px" alt="">
		</div>
		<form method="POST" action="authentication/login_function.php" enctype="multipart/form-data">
		
			<div class="user-details">
			<div class="input-box">
				<span class="details">Email</span>
				<input type="text" name="email" placeholder="Enter your Email" value="<?php echo isset($relogin_email) ? $relogin_email : '' ?>" required>
			</div>
			
			<div class="input-box">
				<span class="details">Password</span>
				<input type="password" name="password" placeholder="Enter your Password" required>
			</div>
			</div>
			<div class="button">
			<input type="submit" name="login" value="Login">
			</div>
		</form>
		<span class="toReg">
			<div>
				<p style="text-align: center;">Dont have an Account? <a href="registration.php">Go to Register</a></p>
			</div>
			<br>
			<div>
				<p style="text-align: center;"><a href="registration/password_reset.php">Forgot Password</a></p>
			</div>
			<br>
			<div>
				<p style="text-align: center;"><a href="index.php">Go Back to Home Page</a></p>
			</div>
			<br>
		</span>
	</div>
		
	</body>


	</html>
