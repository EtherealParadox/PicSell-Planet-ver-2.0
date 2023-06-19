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

		.product_info {
			margin-top: 10px;
			height: 200px;
			overflow-y: auto;
		}

		.product_info::-webkit-scrollbar {
			width: 10px;
		}
		
		/* Track */
		.product_info::-webkit-scrollbar-track {
			background: #f1f1f1; 
		}
			
		/* Handle */
		.product_info::-webkit-scrollbar-thumb {
			background: #888; 
		}
		
		/* Handle on hover */
		.product_info::-webkit-scrollbar-thumb:hover {
			background: #555; 
		}

		.product_info p:last-of-type{
			word-wrap: break-word;
		}
	</style>
    <div class="container-fluid">
		<div class="product_container" style="text-align: center;">
        <?php
            $pr_id = $_GET['prod_id'];
            $products = $conn->query("SELECT * FROM tbl_product WHERE `product_id` = '$pr_id' ");
			while($row=$products->fetch_assoc()):
            $row['product_description'] = str_replace("\n","<br/>",$row['product_description']); 
			(empty($row['product_banner'])) ? $src = "../assets/banners/products/placeholder_image.png" : $src = "../assets/banners/products/" . $row['product_banner'];
		?>
    
			<img src="<?php echo $src ?>" ids="<?php echo $row['product_id'] ?>" alt="" style="width: calc(90%); height: calc(40%); background:center; background-size: cover; object-fit: cover; border-radius: 5px 5px 5px 5px;">
			<div class="product_info" style="text-align: center;">
			<label>Product Name</label>
			<p><?php echo $row['product_name'] ?></p>
			<label>Product Price</label>
			<p>PHP <?php echo $row['product_price'] ?></p>
			<label>Product Stock</label>
			<p><?php echo $row['product_stock'] ?></p>
			<label>Product Description</label>
			<p><?php echo $row['product_description'] ?></p>   
            </div>
        <?php 
            endwhile;
        ?>
		</div>
    </div>
    <style>
		#uni_modal .modal-footer{
			display: none;
		}
		#uni_modal .modal-footer.display{
			display: block !important;
		}

	</style>