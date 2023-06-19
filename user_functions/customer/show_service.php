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
		.service_package_info {
			margin-top: 10px;
			height: 200px;
			overflow-y: auto;
		}

		.service_package_info::-webkit-scrollbar {
			width: 10px;
		}
		
		/* Track */
		.service_package_info::-webkit-scrollbar-track {
			background: #f1f1f1; 
		}
			
		/* Handle */
		.service_package_info::-webkit-scrollbar-thumb {
			background: #888; 
		}
		
		/* Handle on hover */
		.service_package_info::-webkit-scrollbar-thumb:hover {
			background: #555; 
		}

		.service_package_info p:last-of-type{
			word-wrap: break-word;
		}
	</style>
    <div class="container-fluid">
		<div class="service_package_container" style="text-align: center;">
        <?php
            $s_id = $_GET['srvc_id'];
            $services = $conn->query("SELECT * FROM tbl_service_packages WHERE `service_id` = '$s_id' ");
			while($row=$services->fetch_assoc()):
            $row['service_description'] = str_replace("\n","<br/>",$row['service_description']); 
			(empty($row['service_banner'])) ? $src = "../assets/banners/placeholder_image.png" : $src = "../assets/banners/" . $row['service_banner']; 
		?>
    
			<img src="<?php echo $src ?>" ids="<?php echo $row['service_id'] ?>" alt="" style="width: calc(90%); height: calc(40%); background:center; background-size: cover; object-fit: cover; border-radius: 5px 5px 5px 5px;">
			<div class="service_package_info" style="text-align: center;">
			<label>Package Name</label>
			<p><?php echo $row['service_name'] ?></p>
			<label>Package Price</label>
			<p>PHP <?php echo number_format($row['service_price']) ?></p>
			<label>Package Hours</label>
			<p><?php echo $row['service_hours'] ?> hours</p>
			<label>Package Description</label>
			<p><?php echo $row['service_description'] ?></p>   
            </div>
		<?php
			endwhile;
        ?>
    </div>
    <style>
		#uni_modal .modal-footer{
			display: none;
		}
		#uni_modal .modal-footer.display{
			display: block !important;
		}

	</style>