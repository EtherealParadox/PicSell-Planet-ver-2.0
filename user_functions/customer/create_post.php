	<?php 
		session_start(); 
		//include 'db_connect.php';
		include '../db_connect.php';
		$prof_img = $conn->query("SELECT user_profile_image FROM tbl_user_account WHERE user_id = {$_SESSION['login_user_id']}")->fetch_assoc();
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
	</style>
	<?php 
	if(isset($_GET['id'])){
		$qry = $conn->query("SELECT * FROM tbl_post where post_id = {$_GET['id']}")->fetch_array();
		foreach($qry as $k => $v){
			$$k= $v;
		}
	}
	?>
	<div class="container-fluid">
		<form action="" id="manage_post">
			<input type="hidden" name="post_id" value="<?php echo isset($post_id) ? $post_id : '' ?>">
			<div class="d-flex w-100 align-items-center">
				<div class="rounded-circle mr-1" style="width: 40px;height: 40px;top:-5px;left: -40px">
					<img src="../../images/profile-images/<?php echo $prof_img['user_profile_image'] ?>" class="image-fluid image-thumbnail rounded-circle" alt="" style="width: calc(100%);height: calc(100%); object-fit: cover;">
				</div>
				<div class="ml-4 text-left" style="width:calc(80%)">
					<div><b><?php echo ucwords($_SESSION['login_user_first_name']) . ' ' . ucwords($_SESSION['login_user_last_name']) . ' (' . ucwords($_SESSION['login_user_nickname']) . ')' ?></b></div>
					
				</div>
			</div>
			<div class="form-group" style="margin-top: 10px;">
				<textarea name="post_content" id="post_content" cols="30" rows="2" class="form-control" placeholder="What's on your mind, <?php echo ucwords($_SESSION['login_user_first_name']) . ' ' . ucwords($_SESSION['login_user_last_name']) ?>?" style="resize:none;border: none"><?php echo isset($post_content) ? $post_content : '' ?></textarea>
			</div>
			<div class="c-row" id="">
				<div id="file-display" class="column">

					<?php 
					if(isset($post_id)):
					if(is_dir('../assets/uploads/'.$post_id)):
					$gal = scandir('../assets/uploads/'.$post_id);
					unset($gal[0]);
					unset($gal[1]);
					foreach($gal as $k=>$v):
						$path = '../assets/uploads/'.$post_id.'/'.$v;
						$mime = mime_content_type('../assets/uploads/'.$post_id.'/'.$v);
						$img = file_get_contents('../assets/uploads/'.$post_id.'/'.$v); 
						$type = pathinfo($path, PATHINFO_EXTENSION);
						$base64 = 'data:image/' . $type . ';base64,' . base64_encode($img);
						
						echo'
							<script>

							</script>
						';

					?>
						<div class="imgF">
							<span class="rem badge badge-primary" onclick="rem_func($(this))" style="cursor: pointer;"><i class="fa fa-times"></i></span>
							<input type="hidden" name="img[]" value="<?php echo $base64 ?>">
							<input type="hidden" name="imgName[]" value="<?php echo $v ?>">
							<?php if(strstr($mime,'image')): ?>
							<img class="imgDropped" src="../assets/uploads/<?php echo $post_id.'/'.$v ?>">
							<?php else: ?>
							<video src="../assets/uploads/<?php /*echo $row['file_path']*/ echo $post_id.'/'.$v ?>"></video>
							<?php endif; ?>
						</div>
					<?php endforeach; ?>
					<?php endif; ?>
					<?php endif; ?>
					
				</div>
			</div>
			<input type="file" name="file[]" multiple="multiple" onchange="" id="postF" onchange="displayUpload(this)" class="d-none" accept="image/*,video/*">
			<div class="card solid">
				<div class="card-body">
					<div class="d-flex justify-content-between align-items-center">
						<small>Add to Your Post</small>
						<span>
							<label for="postF" style="cursor: pointer;"><a class="rounded-circle"><i class="fa fa-photo-video text-success"></i></a></label>
						</span>
					</div>
				</div>
			</div>
			
		</form>
	</div>
	<div class="modal-footer display py-1 px-1">
		<div class="d-block w-100">
			<button class="btn btn-block btn-primary btn-sm" form="manage_post">POST</button>
		</div>
	</div>
	<div class="imgF" style="display: none " id="img-clone">
				<span class="rem badge badge-primary" onclick="rem_func($(this))" style="cursor: pointer;"><i class="fa fa-times"></i></span>
		</div>
	<style>
		#uni_modal .modal-footer{
			display: none;
		}
		#uni_modal .modal-footer.display{
			display: block !important;
		}

	</style>
	<script>
		if('<?php echo isset($_GET['upload']) ?>' == 1){
			$('#postF').trigger('click')
		}
		if('<?php echo isset($_GET['id']) ?>' == 1){
			$('[name="content"]').trigger('keyup')
		}
		$('[name="file[]"]').change(function(){
			displayUpload(this)
		})
		
		function displayUpload(input){
			if (input.files) {
					Object.keys(input.files).map(function(k){
						var reader = new FileReader();
						var t = input.files[k].type;
							var _types = ['video/mp4','image/x-png','image/png','image/gif','image/jpeg','image/jpg'];
							if(_types.indexOf(t) == -1)
								return false;
							reader.onload = function (e) {
								// $('#cimg').attr('src', e.target.result);

							var bin = e.target.result;
							var fname = input.files[k].name;
							if(input.files[k].size < 26214400)
							{
								var imgF = document.getElementById('img-clone');
								imgF = imgF.cloneNode(true);
								imgF.removeAttribute('id')
								imgF.removeAttribute('style')
								if(t == "video/mp4"){
									var img = document.createElement("video");
									}else{
									var img = document.createElement("img");
									}
								var fileinput = document.createElement("input");
								var fileinputName = document.createElement("input");
								fileinput.setAttribute('type','hidden')
								fileinputName.setAttribute('type','hidden')
								fileinput.setAttribute('name','img[]')
								fileinputName.setAttribute('name','imgName[]')
								fileinput.value = bin
								fileinputName.value = fname
								img.classList.add("imgDropped")
								img.src = bin;
								imgF.appendChild(fileinput);
								imgF.appendChild(fileinputName);
								imgF.appendChild(img);
								console.log(bin)
								document.querySelector('#file-display').appendChild(imgF)
							}
							else
							{
								Swal.fire({
									position: 'top-end',
									icon: 'warning',
									title: 'File more than 25mb is not allowed',
									toast: true,
									showConfirmButton: false, 
									timer: 5500
								})
							}
							}
					reader.readAsDataURL(input.files[k]);
					})
					rem_func()
		}
		}
			
		function rem_func(_this){
				_this.closest('.imgF').remove()
				if($('#drop .imgF').length <= 0){
					$('#drop').append('<span id="dname" class="text-center">Drop Files Here <br> or <br> <label for="chooseFile"><strong>Choose File</strong></label></span>')
				}
		}
	
		$('#post_content').on('change keyup keydown paste cut', function () {
			if(this.scrollHeight <= 250)
			$(this).height(0).height(this.scrollHeight);
		})
		$('.type-item').click(function(){
			$('[name="type"').val($(this).attr('date-type'))
			$('#type-selected').html($(this).html())
		})
		$('#manage_post').submit(function(e){
			e.preventDefault()
			if($("#post_content").val().trim().length < 1)
			{
				if(!$("#file-display").children().length > 0)
				{
					alert_toast("Fields cannot be empty",'error');
				}
				else
				{
					start_load()
					$.ajax({
						url:"ajax.php?action=save_post",
						data: new FormData($(this)[0]),
						cache: false,
						contentType: false,
						processData: false,
						method: 'POST',
						type: 'POST',
						success:function(resp){
							if(resp == 1){
								location.reload()
							}
						}
					})
				}
			}
			else
			{
				start_load()
				$.ajax({
					url:"ajax.php?action=save_post",
					data: new FormData($(this)[0]),
					cache: false,
					contentType: false,
					processData: false,
					method: 'POST',
					type: 'POST',
					success:function(resp){
						/*console.log(resp)
						end_load()*/
						if(resp == 1){
							location.reload()
						}
					}
				})
			}
		})
	</script>