<?php 
		session_start(); 
		//include 'db_connect.php';
		include '../db_connect.php';
	?>
	<style>
		.column {
		float: left;
		width: 100%;
		padding: 10px;
		}

		.column img,.column video {
		margin-top: 12px;
		max-width: 100%;
		max-height: 20vh;
		}
		.c-row {
		display: flex;
		flex-wrap: wrap;
		padding: 0 4px;
		}

		.modal-dialog {
			margin-top: 150px !important;
		}

        .items {
            text-align: center
        }

        .items .availActionBtns {
            background: #114481; 
            color: #fed136; 
            border: none; 
            border-radius: 5px 5px 5px 5px; 
            padding: 5px 10px 5px 10px; 
            font-size: 20px;
            text-align: center;
			font-weight: bolder;
        }

		.items .availCancelBtn {
			background-color: crimson;
			color: white;
			border: none; 
            border-radius: 5px 5px 5px 5px; 
            padding: 5px 10px 5px 10px; 
            font-size: 20px;
            text-align: center;
			font-weight: bolder;
		}

		.showAvailSwalCont {
			font-family: 'Mulish' !important;
		}

		.showAvailSwalTitle{
			font-size: 22.5px;
			text-align: left !important; 
			color: black;
			margin-top: 0 !important;
		}

		.swal2_img {
			height: 300px;
			width: 300px;
			border: 2px black;
			object-fit: contain;
		}
	</style>
    <div class="container-fluid">
        <?php
            $a_id = $_GET['avail_id'];
            $l_id = $_GET['l_id'];
			$d_id = $_GET['ym'];
            $s_id = $_GET['srvc_id'];
            $avail = $conn->query("SELECT a.* , s.service_name, s.service_price from tbl_service_packages s inner join tbl_service_avail a on a.service_id = s.service_id where a.avail_id = $a_id ORDER BY avail_id DESC LIMIT 1");
			while($row=$avail->fetch_assoc()):
            $s_time = strtotime($row['avail_starting_date_time']); $s_nt = date("F d, Y (H:i A)", $s_time);
            $e_time = strtotime($row['avail_ending_date_time']); $e_nt = date("F d, Y (H:i A)", $e_time);
			
		?>
            <div class="items">
				<p>Status: 
					<?php
						$txt = "";
						if($row['avail_status'] == 0){$txt = "Pending";}
						if($row['avail_status'] == 1){$txt = "Downpayment";}
						if($row['avail_status'] == 2){$txt = "Confirmed";}
						if($row['avail_status'] == 3){$txt = "Completed";}
						if($row['avail_status'] == 4){$txt = "Cancelled";}
						if($row['avail_status'] == 5){$txt = "Rescheduling";}
						echo $txt
					?>
				</p>
		<?php
				if($row['avail_status'] == 0 || $row['avail_status'] == 1)
				{
					echo '<p>Amount for downpayment: ₱hp. '.number_format($row['service_price'] * .25).'</p>';
				}
		?>
				<p>Package: <?php echo $row['service_name'] ?></p>
		<?php
				if(!empty($row['avail_note']))
				{
					echo '<p>Avail Note: '.$row['avail_note'].'</p>';
				}
		?>
                <p>Start Date: <?php echo $s_nt ?></p>
                <p>End Date: <?php echo $e_nt ?></p>
				
		<?php
				if(($row['avail_status'] == 1 || $row['avail_status'] == 2) && !empty($row['avail_downpayment_image']))
				{
		?>
					<p>Downpayment Image:</p>
					<img src="../assets/payment/<?php echo $row['avail_downpayment_image'] ?>" alt="downpayment_img" style="border: 2px solid black; width: 200px; height: 200px; object-fit:contain;">
					<br /><br />
		<?php
				}
				if($row['avail_status'] == 4):
		?>
				<label>Reason:</label>
				<p style="word-wrap:break-word;"><?php echo $row['avail_cancel_reason'] ?></p>
		<?php
				endif;
		?>
				<div>
				<?php
					if($row['avail_status'] == 0):
				?>
					<button class="availActionBtns" onclick="window.location.href='?page=service&l_id=<?php echo $l_id ?>&srvc_id=<?php echo $s_id ?>&ym=<?php echo $d_id ?>&avail_id=<?php echo $a_id ?>'; ">Edit Avail</button>
				<?php
					endif;
					if($row['avail_status'] == 1):
				?>
					<button class="availActionBtns" onclick="upload_dwnpayment()">Upload Downpayment</button>
					<button class="availActionBtns" onclick="window.location.href='?page=service&l_id=<?php echo $l_id ?>&srvc_id=<?php echo $s_id ?>&ym=<?php echo $d_id ?>&avail_id=<?php echo $a_id ?>'; ">Resched Avail</button>
				<?php
					endif;
					if($row['avail_status'] == 2 || $row['avail_status'] == 5 ):
				?>
					<button class="availActionBtns" onclick="window.location.href='?page=service&l_id=<?php echo $l_id ?>&srvc_id=<?php echo $s_id ?>&ym=<?php echo $d_id ?>&avail_id=<?php echo $a_id ?>&action=print'; ">Receipt</button>
					<button class="availActionBtns" onclick="window.location.href='?page=service&l_id=<?php echo $l_id ?>&srvc_id=<?php echo $s_id ?>&ym=<?php echo $d_id ?>&avail_id=<?php echo $a_id ?>'; ">Resched Avail</button>
				<?php
					endif;
					if($row['avail_status'] == 3):
				?>
					<button class="availActionBtns" onclick="window.location.href='?page=service&l_id=<?php echo $l_id ?>&srvc_id=<?php echo $s_id ?>&ym=<?php echo $d_id ?>&avail_id=<?php echo $a_id ?>&action=print'; ">Receipt</button>
				<?php
					endif;
					if($row['avail_status'] == 4 && !is_null($row['avail_downpayment_image'])):
				?>
					<button class="availActionBtns" onclick="window.location.href='?page=service&l_id=<?php echo $l_id ?>&srvc_id=<?php echo $s_id ?>&ym=<?php echo $d_id ?>&avail_id=<?php echo $a_id ?>&action=print'; ">Receipt</button>
				<?php
					endif;
					if($row['avail_status'] <= 2 || $row['avail_status'] == 5):
				?>
					<button class="availCancelBtn" onclick="cancel()">Cancel Avail</button>
				<?php
					endif;
					
				?>
				</div>
			</div>
		<?php
			endwhile;
        ?>
    </div>
	<script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
	<script>
		function closeFunc()
		{
			location.reload()
		}

		function upload_dwnpayment()
		{
			Swal.fire({
				title: 'Select a file',
				text: 'Kindly upload the screenshot of your downpayment via Gcash',
				showCloseButton: true,
				confirmButtonText: 'Upload',
				input: 'file',
				inputAttributes: {
					id: 'swal2-file',
					'accept': 'image/png, image/jpeg',
					'aria-label': 'Upload your downpayment proof'
				},
			}).then((file) => {
				if (file.value) {
					var formData = new FormData();
					
					var file = $('.swal2-file')[0].files[0];
					const reader = new FileReader()
					reader.onload = (e) => {
						Swal.fire({
							customClass: {
								image: 'swal2_img',
							},
							html:
								'<h4>Proceed to submit this image?</h4>' 
							,
							imageUrl: e.target.result,
							showCancelButton: true,
							confirmButtonText: 'Submit',
						}).then(function(result) {
							if(result.isConfirmed)
							{
								
								var formData = {
									avail_id: '<?php echo $a_id ?>',
									//receiver is the one who gonna receive the notification, 
									//in this case it will be the lensman who will receive the notification
									notification_receiver: '<?php echo $l_id ?>',
									payment_image: reader.result,
								};
								start_load()
								$.ajax({
									url:"ajax.php?action=upload_downpayment",
									method: 'POST',
									data: formData,
									success:function(resp){
										console.log(resp)
										end_load()
										if(resp == 1){
											alert_toast("Downpayment image successfully uploaded",'success')
											setTimeout(function(){
												location.reload()
											},1500)
										}
										if(resp == 2){
											alert_toast("Something went wrong..",'error')
											setTimeout(function(){
												location.reload()
											},1500)
										}
										if(resp == 3){
											alert_toast("Something went wrong with file upload..",'error')
											setTimeout(function(){
												location.reload()
											},1500)
										}
									}
								})
							}
						})
					}
					reader.readAsDataURL(file)
				}
				else if(!file.value && !file.dismiss )
				{
					alert_toast("You didnt upload anything",'error')
				}
			})
		}

		function cancel()
		{
			Swal.fire({
				customClass: {
					container: 'showAvailSwalCont',
					title: 'showAvailSwalTitle',
				},
				title: "Avail Cancellation",
				confirmButtonText: "Submit",
				showCloseButton: true,
				allowOutsideClick: false,
				html:
					'<textarea id="cancelReason" placeholder="Please enter your reason here for your cancellation...">'+
					'</textarea>',
				preConfirm: () => {
					var id = document.getElementById("cancelReason");
					var value = id.value;
					if (value.trim().length > 0) {

					} else { 
						Swal.showValidationMessage('Please do not leave the input empty') 
					}
				}
			}).then(function(result) {
				if(result.isConfirmed)
				{
					var id = document.getElementById("cancelReason");
					var value = id.value;
					//alert(value+'  '+<?php echo $_SESSION['login_user_id'] ?>)
					var formData = {
						avail_id: '<?php echo $a_id ?>',
						//receiver is the one who gonna receive the notification, 
						//in this case it will be the lensman who will receive the notification
						notification_receiver: '<?php echo $l_id ?>',
						avail_cancel_reason: value,
					};
					start_load()
					$.ajax({
						url:"ajax.php?action=cancel_avail_cm",
						method: 'POST',
						data: formData,
						success:function(resp){
							console.log(resp)
							end_load()
							if(resp == 1){
								alert_toast("Avail successfully updated",'success')
								setTimeout(function(){
									location.reload()
								},1500)
							}
							if(resp == 2){
								alert_toast("Something went wrong..",'error')
								setTimeout(function(){
									location.reload()
								},1500)
							}
						}
					})
				}
			})
		}
		
	</script>
    <style>
		#uni_modal .modal-footer{
			display: none;
		}
		#uni_modal .modal-footer.display{
			display: block !important;
		}
	</style>