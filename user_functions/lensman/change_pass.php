<?php 
	session_start();
	include '../db_connect.php';
?>
<style>
	#uni_modal .modal-footer{
		display: none;
	}
	#uni_modal .modal-footer.display{
		display: block !important;
	}

	.input-box .details{
    display: block;
    font-weight: 500;
    margin-bottom: 5px;
    }

    .input-box input{
    height: 45px;
    width: 100%;
    outline: none;
    border-radius: 5px;
    border: 1px solid #ccc;
    padding-left: 15px;
    font-size: 16px;
    border-bottom-width: 2px;
    transition: all 0.3s ease;
    }

    .input-box input:focus,
    .input-box input:valid{
    border-color: #edbb06;
    }
</style>
<div class="container-fluid">
		<input type="hidden" name="user_id" id="user_id" value="<?php echo $_SESSION['login_user_id'] ?>">
		<div class="col-lg-12">
			<div id="msg"></div>
			<div class="row">
				<div class="form-group col-md-12">
					<div class="input-box">
						<span class="details">Password&nbsp;<i onclick="passInfo()" class="fas fa-lock ic" style="cursor: pointer; color: #114383;"></i><b id="passState"></b></span>
						<input type="password" name="password" id="password" placeholder="Minimum of 8 Digits" title="Must contain at least one  number and one uppercase and lowercase letter, and at least 8 or more characters">
					</div>
					<div class="input-box">
						<span class="details">Confirm Password<b id="cpassState"></b></span>
						<input type="password" name="cPassword" id="cPassword" placeholder="Re-Enter Password">
					</div>
					<br />
					<button onclick="changePass()" style="float: right; background-color: #114383; color:#edbb06; font-size: 20px; padding: 5px 10px 5px 10px; border: none; border-radius: 5px;">Save</button>
				</div>
			</div>
		</div>
</div>
<script>

	function changePass()
	{
		var id = document.getElementById('user_id').value;
		var pass = document.getElementById('password').value;
		var cpass = document.getElementById('cPassword').value;
		if((pass==="" || pass==null ) || (cpass ==="" || cpass==null))
		{
			alert_toast("Some Input/s are empty",'warning')
		}
		else
		{
			$.ajax({
			url:"ajax.php?action=update_pass",
			data: {user_id: id, password: pass, cPassword: cpass},
		    method: 'POST',
			success:function(resp){
				console.log(resp);
				if(resp == 1){
					alert_toast("Password Successfully Changed",'success')
					setTimeout(function(){
						location.reload()
					},2500)
				}
				else if(resp == 2){
					alert_toast("Something Went Wrong",'error')
				}
				else if(resp == 3){
					alert_toast("Password should be a mix of Uppercase, Lowercase, Number, and optional Special character",'error')
				}
				else if(resp == 4){
					alert_toast("Password does not match",'error')
				}
				else if(resp == 5){
					alert_toast("Password is too short",'error')
				}
			}
		})
		}
	}
	
	document.getElementById('password').addEventListener('input', function(e) {
		var foo = this.value.split(" ").join("");
		this.value = foo;
	});

	document.getElementById('cPassword').addEventListener('input', function(e) {
		var foo = this.value.split(" ").join("");
		this.value = foo;
	});
	
	function passInfo()
	{
		Swal.fire({
			html: `
				<br />
				<h3 style="text-align: justify;">"Password must be a combination of lowercase and uppercase letter, number, special character, and  at least 8 or more digits"</h3>
			`,
			position: "center",
			width: '500px',
			showConfirmButton: false,
			showCloseButton: true,
		})
	}

	$('#password, #cPassword').on('keyup', function() {
		var pass = $('[name="password"]').val()
		var cpass = $('[name="cPassword"]').val()
		if(pass!='' || cpass!='' )
		{

			if(/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[!@#$%^&*()_.])[A-Za-z\d!@#$%^&*()_.]{8,}$/.test(pass))
			{
				document.getElementById('passState').innerHTML = '&nbsp;&nbsp;Very Strong'
				document.getElementById('passState').style.color = 'green';
				if(cpass!='')
				{
					if(cpass == pass)
					{
						document.getElementById('cpassState').innerHTML = '&nbsp;&nbsp;Match'
						document.getElementById('cpassState').style.color = 'green';
					}
					else
					{
						document.getElementById('cpassState').innerHTML = '&nbsp;&nbsp;Mismatch'
						document.getElementById('cpassState').style.color = 'red';
					}
				}
				else
				{
					document.getElementById('cpassState').innerHTML = ''
				}
			}
			else if(/^(?=.*[A-Z])(?=.*\d)(?=.*[!@#$%^&*()_.])[A-Z\d!@#$%^&*()_.]{8,}$/.test(pass) || /^(?=.*[a-z])(?=.*\d)(?=.*[!@#$%^&*()_.])[a-z\d!@#$%^&*()_.]{8,}$/.test(pass) || /^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)[A-Za-z\d]{8,}$/.test(pass) || /^(?=.*[a-z])(?=.*[A-Z])(?=.*[!@#$%^&*()_.])[A-Za-z!@#$%^&*()_.]{8,}$/.test(pass))
			{
				document.getElementById('passState').innerHTML = '&nbsp;&nbsp;Strong'
				document.getElementById('passState').style.color = 'green';
				if(cpass!='')
				{
					if(cpass == pass)
					{
						document.getElementById('cpassState').innerHTML = '&nbsp;&nbsp;Match'
						document.getElementById('cpassState').style.color = 'green';
					}
					else
					{
						document.getElementById('cpassState').innerHTML = '&nbsp;&nbsp;Mismatch'
						document.getElementById('cpassState').style.color = 'red';
					}
				}
				else
				{
					document.getElementById('cpassState').innerHTML = ''
				}
			}
			else if(/^(?=.*[\d])(?=.*[!@#$%^&*()_.])[\d!@#$%^&*()_.]{0,}$/.test(pass) || /^(?=.*[A-Z])(?=.*[!@#$%^&*()_.])[A-Z!@#$%^&*()_.]{0,}$/.test(pass) || /^(?=.*[a-z])(?=.*[!@#$%^&*()_.])[a-z!@#$%^&*()_.]{0,}$/.test(pass) || /^(?=.*[a-z])(?=.*\d)[a-z\d]{0,}$/.test(pass) || /^(?=.*[a-z])(?=.*[A-Z])[A-Za-z]{0,}$/.test(pass) || /^(?=.*[A-Z])(?=.*\d)[A-Z\d]{0,}$/.test(pass))
			{
				document.getElementById('passState').innerHTML = '&nbsp;&nbsp;Weak'
				document.getElementById('passState').style.color = 'red';
				if(cpass!='')
				{
					if(cpass == pass)
					{
						document.getElementById('cpassState').innerHTML = '&nbsp;&nbsp;Match'
						document.getElementById('cpassState').style.color = 'green';
					}
					else
					{
						document.getElementById('cpassState').innerHTML = '&nbsp;&nbsp;Mismatch'
						document.getElementById('cpassState').style.color = 'red';
					}
				}
				else
				{
					document.getElementById('cpassState').innerHTML = ''
				}
			}
			else if(/^(?=.*[a-z])[a-z]{0,}$/.test(pass) || /^(?=.*\d)[\d]{0,}$/.test(pass) || /^(?=.*[A-Z])[A-Z]{0,}$/.test(pass) || /^(?=.*[!@#$%^&*()_.])[!@#$%^&*()_.]{0,}$/.test(pass))
			{
				document.getElementById('passState').innerHTML = '&nbsp;&nbsp;Very Weak'
				document.getElementById('passState').style.color = 'red';
				if(cpass!='')
				{
					if(cpass == pass)
					{
						document.getElementById('cpassState').innerHTML = '&nbsp;&nbsp;Match'
						document.getElementById('cpassState').style.color = 'green';
					}
					else
					{
						document.getElementById('cpassState').innerHTML = '&nbsp;&nbsp;Mismatch'
						document.getElementById('cpassState').style.color = 'red';
					}
				}
				else
				{
					document.getElementById('cpassState').innerHTML = ''
				}
			}
			
		}
		else
		{
			document.getElementById('passState').innerHTML = ''
			document.getElementById('cpassState').innerHTML = ''
		}
	});

	function displayImgCover(input,_this) {
	    if (input.files && input.files[0]) {
	        var reader = new FileReader();
	        reader.onload = function (e) {
	        	$('#cover').attr('src', e.target.result);
	        }

	        reader.readAsDataURL(input.files[0]);
	    }
	}
</script>