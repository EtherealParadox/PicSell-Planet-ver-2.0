<?php
	include 'database.php';
	?>
	
	<?php
		$user_qry="SELECT * FROM `tbl_order` t1 JOIN `tbl_product` t2 ON t1.product_id = t2.product_id JOIN `tbl_user_account` t3 ON t1.user_id = t3.user_id WHERE order_id = {$_GET['order_id']};";  //Need Logic hereeeeeeeeeeeee
		$user_res=mysqli_query($con,$user_qry);
		$user_data=mysqli_fetch_assoc($user_res);
		
		$user_qry2="SELECT * FROM `tbl_product` t1 JOIN `tbl_user_account` t2 ON t1.user_id = t2.user_id WHERE product_id = {$_GET['product_id']};";  //Need Logic hereeeeeeeeeeeee
		$user_res2=mysqli_query($con,$user_qry2);
		$user_data2=mysqli_fetch_assoc($user_res2)
	?>
	<body onload="window.print()">
	<div id="invoice-box">
		<style>
			.invoice-box * {
				-webkit-print-color-adjust: exact;
				font-family:'Trebuchet MS', 'Lucida Sans Unicode', 'Lucida Grande', 'Lucida Sans', Arial, sans-serif
			}

			.invoice-box *:not(.title h5) {
				font-size: 17.5px;
			}

			#invoice-box {
				color: #333;
				border: 2px solid black;
				max-width: 800px;
				margin: auto;
				padding: 20px;
			}

			.invoice-box h1 {
				font-weight: 300;
				margin-bottom: 0px;
				padding-bottom: 0px;
				color: #000;
			}

			.invoice-box .title h5 {
				font-size: 0.83em;
				font-weight: 700;
				margin-top: 10px;
				margin-bottom: 20px;
				font-style: italic;
				color: #333;
			}

			.invoice-box a {
				color: #06f;
			}

			.invoice-box {
				text-align: center;
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
								$status;
								if($user_data['order_status'] == 0){
									$status = 'Pending';
								}else if($user_data['order_status'] == 1){
									$status = 'Confirmed';
								}else if($user_data['order_status'] == 2){
									$status = 'Completed';
								}
									echo 'Invoice #: '. $user_data['order_id'] .'<br />';
									echo 'Status: '. $status .'<br />';
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
									echo $user_data['user_name'] .'<br />';
									echo str_replace(" ", ", ", $user_data['user_address']);
								?>
								</td>

								<td>
								<?php
									echo $user_data2['user_type'] .'<br />';
									echo $user_data2['user_name'] .'<br />';
									echo $user_data2['user_studio_name'] .'<br />';
								?>
								</td>
							</tr>
						</table>
					</td>
				</tr>

				<tr class="heading">
					<td>Order Product</td>
					<td>Order Description</td>
				</tr>

				<tr class="details">
					<td>
					<?php
						echo $user_data['product_name'] . '<br />';
					?>
					</td>

					<td>
					<?php
						echo nl2br($user_data['product_description']);
					?>
					</td>
				</tr>

				<tr class="heading">
					<td>Price</td>
					<td>Quantity</td>
				</tr>

				<tr class="item last">
					<td>
					<?php
						echo '₱ ' . $user_data['product_price'];
					?>
					</td>

					<td>
					<?php
						echo 'x' . $user_data['order_quantity'];
					?>
					</td>
				</tr>

				<tr class="total">
					<td> </td>

					<td>
					<?php
						echo 'Total: ₱ ' . ($user_data['product_price'] * $user_data['order_quantity']);
					?>
					</td>
				</tr>
			</table>
			<br />
			<h4>Thank You For Buying our Product!!</h4>
			<br />
			<br />
			<div style="display:flex; flex-direction: row; justify-content: space-between;">
		<div>
		<h2 style="text-transform: UPPERCASE"><?php echo $user_data['user_name'];?></h2>
			<h4 style="float: right; border-top: 2px solid black; width: 300px;">Signature of Customer</h4>
		</div>
		<div>
		<h2 style="text-transform: UPPERCASE"><?php echo $user_data2['user_name'];?></h2>
			<h4 style="float: right; border-top: 2px solid black; width: 300px;">Signature of Lensman</h4>
		</div>
		</div>
		</div>
	</div>
	</body>
