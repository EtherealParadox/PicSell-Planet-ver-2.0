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

        .modal-content {
            width: 1000px;
        }

		.edit_product_form {
			margin-top: 10px;
			border-radius: 5px 5px 5px 5px;
			background-color: rgba(33, 150, 243, 0.4);
			padding: 10px 20px 10px 20px;
		}
		.label {
			font-weight: bolder;
			text-align: left;
		}
		.edit_product {
			display: grid;
			grid-template-columns: repeat(2, 1fr);
			font-size: 20px;
			grid-gap: 20px;
		}
		
		.input {
			margin-bottom: 10px;
			width: 100%;
			padding: 5px;
		}
		textarea {
            font-size: 20px;
			resize: none;
			overflow-y: auto;
			padding: 5px;
		}
        .file_logo {
            display: flex;
		}
        .file_logo img{
			width: 40px;
		}
		label img:hover {
			cursor: pointer;
		}
		#output {
			border: 1px solid black;
			width: 100%;
			height: 322px;
			background: center; 
			background-size: cover; 
			object-fit: contain;
		}
		input[type=submit] {
			margin-top: 20px;
			background-color: rgba(0, 0, 0, 0.2);
			color: white;
			padding: 10px 20px 10px 20px;
			border: none;
			border-radius: 50px 50px 50px 50px;
		}
		input[type=submit]:hover {
			background: #114481;
			color: #fed136;
		}
	</style>
    <div class="container-fluid">
		<div class="product_package_container" style="text-align: center;">
        <?php
            if(isset($_GET['prod_id'])){
                $qry = $conn->query("SELECT * FROM tbl_product where `product_id` = {$_GET['prod_id']}")->fetch_array();
                foreach($qry as $k => $v){
                    $$k= $v;
                }
            }
            //$row['product_description'] = str_replace("\n","<br/>",$row['product_description']); 
			//(empty($row['product_banner'])) ? $src = "../assets/banners/placeholder_image.png" : $src = "../assets/banners/" . $row['product_banner']; 
		?>
    
            <div class="edit_product_form">
                <form action="" id="edit_product" >
                    <div class="edit_product">
                        <div class="edit_product_left">
                            <input type="hidden" id="product_id" name="product_id" value="<?php echo $product_id ?>">
                            <p class="label">Product Name</p>
                            <input class="input" type="text" id="product_name" name="product_name" value="<?php echo $product_name ?>" required>
                            <p class="label">Product Price</p> 
                            <input class="input" type="text" id="product_price" name="product_price" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');" value="<?php echo $product_price ?>" required>
                            <p class="label">Product Description</p>
                            <textarea class="input" name="product_description" id="product_description" cols="50" rows="9" required><?php echo $product_description ?></textarea>
                        </div>
                        <div>
                            <p class="label">Product Stock</p>
							<input class="input" type="text" id="product_stock" name="product_stock" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');" value="<?php echo $product_stock ?>"required>
                            <p class="label">Product Banner</p>
                            <input type="hidden" id="product_banner_old" name="product_banner_old" value="<?php echo $product_banner ?>">
                            <label class="file_logo">
                                <img src="../../assets/img/logos/image.png">
                                <input type="file" id="product_banner" name="product_banner" accept="image/*" onchange="loadFile(event)" style="display:none">
                            </label>
                            <img id="output" src="../assets/banners/products/<?php echo $product_banner ?>" />
                            <center><input type="submit" id="product_submit" name="product_submit" value="Submit" style="margin-bottom: 5px; font-weight: 700;" form="edit_product"></center>
                        </div>
                    </div>
                </form>
            </div>
		</div>
    </div>
    <script>
        var loadFile = function(event) {
			var output = document.getElementById('output');
			output.src = URL.createObjectURL(event.target.files[0]);
			output.onload = function() {
		    URL.revokeObjectURL(output.src) // free memory
			}
		};

        $('#edit_product').submit(function(e){
			e.preventDefault()
			var name = document.getElementById('product_name').value
			var price = document.getElementById('product_price').value//$("#product_price").val()
			var description = document.getElementById('product_description').value
			var banner = document.getElementById('product_banner')
			const isEmpty = str => !str.trim().length;
			if( (!name && isEmpty(name)) || (!price || price <= 0) || !description || !banner ) {
				alert_toast("Some data needed is missing",'warning')
			} 
			else 
			{
				if(isEmpty(name) || isEmpty(description))
				{
					alert_toast("Some data needed is missing",'warning')
				}
				else
				{
					price_new = price.replace(/^0+/,'');
					name=name.trimStart();
					name_new=name.trimEnd();
					description=description.trimStart();
					description_new=description.trimEnd();
					var file = banner[0];
					
					start_load()
					$.ajax({
						url:"ajax.php?action=edit_product",
						data: new FormData($(this)[0]),
						cache: false,
						contentType: false,
						processData: false,
						method: 'POST',
						type: 'POST',
						success:function(resp){
							console.log(resp)
							if(resp == 1){
								alert_toast("Successfully updated product", "success")
                                setTimeout(function(){
									location.reload()
								},1500)
							}
							else
							{
								alert_toast("Something went wrong", "warning")
								end_load()
							}
						}
					})
				}
				
			}
			/*const toBase64 = file => new Promise((resolve, reject) => {
				const reader = new FileReader();
				reader.readAsDataURL(file);
				reader.onload = () => resolve(reader.result);
				reader.onerror = error => reject(error);
			});
			const file = document.querySelector('#product_banner').files[0];
			console.log(toBase64(file));*/
		})
    </script>
    <style>
		#uni_modal .modal-footer{
			display: none;
		}
		#uni_modal .modal-footer.display{
			display: block !important;
		}

	</style>