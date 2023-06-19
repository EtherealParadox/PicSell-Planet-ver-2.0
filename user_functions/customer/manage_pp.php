<?php 
	session_start();
	include '../db_connect.php'; 
    $prof_img = $conn->query("SELECT user_profile_image FROM tbl_user_account WHERE user_id = {$_SESSION['login_user_id']}")->fetch_assoc();
?>
<div class="container-fluid">
	<form action="" id="update-profile">
		<div class="row">
			<div class="form-group">
			<label for="" class="control-label">Profile Picture</label>
				<div class="custom-file">
					<input type="hidden" name="user_id" value="<?php echo $_SESSION['login_user_id'] ?>">
					<input type="hidden" name="pfp_old" value="<?php echo $prof_img['user_profile_image'] ?>">
					<input type="file" class="custom-file-input" id="customFile" name="pp" accept="image/*" onchange="displayImgProfile(this,$(this))">
					<label class="custom-file-label" for="customFile" id="chooseLbl">Choose file</label>
                </div>
			</div>
		</div>
		<div class="row">
			<div class="form-group d-flex justify-content-center rounded-circle" style="height: 250px; width: 450px;">
			
				<img src="../../images/profile-images/<?php echo $prof_img['user_profile_image'] ?>" alt="" id="profile" class="img-fluid img-thumbnail rounded-circle" style="width: 250px; height: 250px; object-fit: cover;">
			</div>
		</div>
		
	</form>
</div>
<script>
	$('#update-profile').submit(function(e){
		e.preventDefault()
		start_load()
		$.ajax({
			url:"ajax.php?action=update_profile",
			data: new FormData($(this)[0]),
			cache: false,
			contentType: false,
			processData: false,
			method: 'POST',
			type: 'POST',
			success:function(resp){
				console.log(resp)
				if(resp == 1){
					alert_toast("Successfully changed your Profile Pic", "success")
					location.reload()
				}
				else if(resp == 3)
				{
					alert_toast("No Changes were made", "warning")
					end_load()
				}
				else if(resp == 2)
				{
					alert_toast("Something went wrong...", "error")
					end_load()
				}
			}
		})
	})
	function displayImgProfile(input,_this) {
		if (input.files && input.files[0]) {

			var file = input.files[0];

			if(file.name.length > 30)
			{
				var old_txt = file.name
				var file_name = old_txt.substring(0, 30) + '...';
				document.getElementById("chooseLbl").innerHTML = file_name
			}
			else
			{
				var file_name = file.name;
				document.getElementById("chooseLbl").innerHTML = file_name
			}

			var reader = new FileReader();
			reader.onload = function (e) {
				$('#profile').attr('src', e.target.result);
			}

			reader.readAsDataURL(input.files[0]);
		}
	}
</script>