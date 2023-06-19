	<?php
	include 'database.php';
	?>
	<!DOCTYPE html>
	<html>
	<head>
	<style>
		* {
			-webkit-print-color-adjust: exact;
			font-family:'Trebuchet MS', 'Lucida Sans Unicode', 'Lucida Grande', 'Lucida Sans', Arial, sans-serif
		}

		*:not(.title h5) {
			font-size: 17.5px;
		}

		body {
			text-align: center;
			color: #333;
		}
		
		body h1 {
			font-weight: 300;
			margin-bottom: 0px;
			padding-bottom: 0px;
			color: #000;
		}

		body h5 {
			font-size: 0.83em;
			font-weight: 700;
			margin-top: 10px;
			margin-bottom: 20px;
			font-style: italic;
			color: #333;
		}

		body a {
			color: #06f;
		}

		.invoice-box {
			max-width: 800px;
			margin: auto;
			padding: 20px;
			font-size: 16px;
			line-height: 24px;
			font-family: 'Helvetica Neue', 'Helvetica', Helvetica, Arial, sans-serif;
			color: #333;
		}

		.invoice-box table {
			width: 100%;
			line-height: inherit;
			text-align: left;
			border-collapse: collapse;
		}

		.invoice-box table td {
			padding: 5px;
			vertical-align: top;
		}

		.invoice-box table tr td:nth-child(2) {
			text-align: right;
		}

		.invoice-box table tr.top table td {
			padding-bottom: 20px;
		}

		.invoice-box table tr.top table td.title {
			font-size: 45px;
			line-height: 45px;
			color: #333;
		}
		
		.invoice-box table tr.information table td {
			padding-bottom: 40px;
		}

		.invoice-box table tr.heading td {
			background: #eee;
			font-weight: bold;
		}

		.invoice-box table tr.details td {
			padding-bottom: 20px;
		}


		.invoice-box table tr.item.last td {
			border-bottom: none;
		}

		.invoice-box table tr.total td:nth-child(2) {
			border-top: 2px solid #eee;
			font-size: 20px;
			font-weight: bold;
		}

		@media only screen and (max-width: 600px) {
			.invoice-box table tr.top table td {
				width: 100%;
				display: block;
				text-align: center;
			}

			.invoice-box table tr.information table td {
				width: 100%;
				display: block;
				text-align: center;
			}
		}
	</style>
	</head>
	<body onload="window.print()">

	<!-- Invoice styling -->
	
	<?php
		$user_qry="SELECT * FROM `tbl_service_avail` t1 JOIN `tbl_service_packages` t2 ON t1.service_id = t2.service_id JOIN `tbl_user_account` t3 ON t1.user_id = t3.user_id WHERE avail_id = {$_GET['avail_id']};";  //Need Logic hereeeeeeeeeeeee
		$user_res=mysqli_query($con,$user_qry);
		$user_data=mysqli_fetch_assoc($user_res);
		
		$user_qry2="SELECT * FROM `tbl_service_packages` t1 JOIN `tbl_user_account` t2 ON t1.user_id = t2.user_id WHERE service_id = {$_GET['srvc_id']};";  //Need Logic hereeeeeeeeeeeee
		$user_res2=mysqli_query($con,$user_qry2);
		$user_data2=mysqli_fetch_assoc($user_res2)
	?>
	<div class="invoice-box" >
		<table>
			<tr class="top">
				<td colspan="2">
					<table>
						<tr>
							<td class="title" style="display: flex;">
								<img src="../../css/images/shortcut-icon.png" alt="website logo" style="width: 150px" />
								<h5 style="margin-top:auto; margin-bottom:auto; vertical-align: center;color:#fed136; padding-left: 20px">Pic-Sell Planet</h5>
							</td>
							
							<td>
							<?php
								echo 'Invoice #: '. $user_data['avail_id'] .'<br />';
								echo date("F d, Y", time()) .'<br />';
								echo 'TIN #: '.$user_data2['user_tin'];
							?>
							</td>
						</tr>
					</table>
				</td>
			</tr>
			<tr class="information">
				<td colspan="2">
					<table>
						<tr>
							<td>
							<?php
								echo $user_data['user_type'] .'<br />';
								echo ucwords($user_data['user_first_name'] . ' ' . $user_data['user_last_name']) .'<br />';
								echo str_replace(" ", ", ", $user_data['user_address']);
							?>
							</td>

							<td>
							<?php
								echo $user_data2['user_type'] .'<br />';
								echo ucwords($user_data2['user_first_name'] . ' ' . $user_data2['user_last_name']) .'<br />';
								echo $user_data2['user_studio_name'] .'<br />';
							?>
							</td>
						</tr>
					</table>
				</td>
			</tr>

			<tr class="heading">
				<td>Service Package</td>
				<td></td>
			</tr>

			<tr class="details">
				<td>
				<?php
					echo $user_data['service_name'] . '<br />';
				?>
				</td>

				<td>
				<?php
					echo nl2br($user_data['service_description']);
				?>
				</td>
			</tr>

			<tr class="heading">
				<td>Schedule</td>
				<td></td>
			</tr>

			<tr class="details">
				<td >
				<?php
					$start = strtotime($user_data['avail_starting_date_time']);
					echo '' . date("F d, Y", $start) . ' (' . date("h:i A", $start) . ')';
				?>
				</td>

				<td>
				<?php
					$start = strtotime($user_data['avail_starting_date_time']);
					$end = strtotime($user_data['avail_ending_date_time']);
					echo '' . date("F d, Y", $end) . ' (' . date("h:i A", $end) . ')';
				?>
				</td>
			</tr>

			<tr class="heading">
				<td>Price</td>
				<td>Subtotal</td>
			</tr>

			<tr class="item last">
					<td>
					<?php
						echo '₱ ' . number_format($user_data['service_price']) . ' - 25% Downpayment';
					?>
					</td>

					<td>
					<?php
						echo '<div id="price" value="' . $user_data['service_price'] . '">₱ ' . number_format($user_data['service_price']) . ' - ₱' . number_format($user_data['service_price'] * .25) . '</div>';
					?>
					</td>
				</tr>

				<tr class="total">
					<td> </td>

					<td>
					<?php
						echo 'Total: ₱ ' . number_format($user_data['service_price'] * .75);
					?>
					</td>
				</tr>
					<?php
						if($user_data['avail_status'] == 2)
						{
							$status = "Confirmed";
						}
						if($user_data['avail_status'] == 3)
						{
							$status = "Completed";
						}
						if($user_data['avail_status'] == 4)
						{
							$status = "Cancelled";
						}
					?>
				<tr>
					<td>Status: <?php echo (isset($status)) ? $status : '' ?></td>

					<td>
					<?php
						if($user_data['avail_status'] == 3)
						{
							echo "<b>(Paid)</b>";
						}
						if($user_data['avail_status'] == 4)
						{
							echo "<b>(Void)</b>";
						}
					?>
					</td>
				</tr>
		</table>
		<br />
		<h4>Thank You For Choosing Our Service!!</h4>
		<br />
		<br />
		<div style="display:flex; flex-direction: row; justify-content: space-between;">
		<div>
		<h2 style="text-transform: UPPERCASE"><?php echo ucwords($user_data['user_first_name'] . ' ' . $user_data['user_last_name']);?></h2>
			<h4 style="float: right; border-top: 2px solid black; width: 300px;">Signature of Customer</h4>
		</div>
		<div>
		<h2 style="text-transform: UPPERCASE"><?php echo ucwords($user_data2['user_first_name'] . ' ' . $user_data2['user_last_name']);?></h2>
			<h4 style="float: right; border-top: 2px solid black; width: 300px;">Signature of Lensman</h4>
		</div>
		</div>
	</div>
	</div>
	</body>
	<script>
		document.getElementsByClassName("cancel-button").onclick = function() {window.close(this)};
	</script>
</html>
