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

		.edit_service_form {
			margin-top: 10px;
			border-radius: 5px 5px 5px 5px;
			background-color: rgba(33, 150, 243, 0.4);
			padding: 10px 20px 10px 20px;
		}
		.label {
			font-weight: bolder;
			text-align: left;
		}
		.edit_service {
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
		<div class="service_package_container" style="text-align: center;">
        <?php
            if(isset($_GET['srvc_id'])){
                $qry = $conn->query("SELECT * FROM tbl_service_packages where `service_id` = {$_GET['srvc_id']}")->fetch_array();
                foreach($qry as $k => $v){
                    $$k= $v;
                }
            }
            //$row['service_description'] = str_replace("\n","<br/>",$row['service_description']); 
			//(empty($row['service_banner'])) ? $src = "../assets/banners/placeholder_image.png" : $src = "../assets/banners/" . $row['service_banner']; 
		?>
    
            <div class="edit_service_form">
                <form action="" id="edit_service" >
                    <div class="edit_service">
                        <div class="edit_service_left">
                            <input type="hidden" id="user_id" name="user_id" value="<?php echo $_SESSION['login_user_id'] ?>">
                            <input type="hidden" id="service_id" name="service_id" value="<?php echo $service_id ?>">
                            <p class="label">Service Name</p>
                            <input class="input" type="text" id="service_name" name="service_name" value="<?php echo $service_name ?>" required>
                            <p class="label">Service Price</p> 
                            <input class="input" type="text" id="service_price" name="service_price" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');" value="<?php echo $service_price ?>" required>
                            <p class="label">Service Description</p>
                            <textarea class="input" name="service_description" id="service_description" cols="50" rows="9" required><?php echo $service_description ?></textarea>
                        </div>
                        <div>
                            <p class="label">Service Hour/s</p>
                            <input class="input" type="text" id="service_hours" name="service_hours"  oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');"  value="<?php echo $service_hours ?>" required>
                            <p class="label">Service Banner</p>
                            <input type="hidden" id="service_banner_old" name="service_banner_old" value="<?php echo $service_banner ?>">
                            <label class="file_logo">
                                <img src="../../assets/img/logos/image.png">
                                <input type="file" id="service_banner" name="service_banner" accept="image/*" onchange="loadFile(event)" style="display:none">
                            </label>
                            <img id="output" src="../assets/banners/<?php echo $service_banner ?>" />
                            <center><input type="submit" id="service_submit" name="service_submit" value="Submit" style="margin-bottom: 5px; font-weight: 700;" form="edit_service"></center>
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

        $('#edit_service').submit(function(e){
			e.preventDefault()
			var name = document.getElementById('service_name').value
			var price = document.getElementById('service_price').value//$("#service_price").val()
			var description = document.getElementById('service_description').value
			var banner = document.getElementById('service_banner')
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
						url:"ajax.php?action=edit_service",
						data: new FormData($(this)[0]),
						cache: false,
						contentType: false,
						processData: false,
						method: 'POST',
						type: 'POST',
						success:function(resp){
							console.log(resp)
							if(resp == 1){
								alert_toast("Successfully updated service", "success")
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
			const file = document.querySelector('#service_banner').files[0];
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