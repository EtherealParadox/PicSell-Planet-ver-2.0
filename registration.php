<?php
    session_start();
    ?>


    <!DOCTYPE html>
    <html lang="en">

    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Registration | Pic-Sell Planet</title>
        <link rel="stylesheet" href="css/style_registration.css">
        <link rel="shortcut icon" href="css/images/shortcut-icon.png">
        <script src="https://kit.fontawesome.com/67415cff19.js" crossorigin="anonymous"></script>
        <script src="https://code.jquery.com/jquery-3.6.3.js"></script>
    </head>

    <style>
        .ic{
        cursor: pointer !important;
    }
    </style>

    <body>
        <div class="mainContainer" style="display: flex; max-width: 1500px;">
    <div class="container">
        <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
        <script>
        <?php
            if(isset($_SESSION['alert_text_rg'])):
        
                if(isset($_SESSION['result_rg']) && $_SESSION['result_rg']==true)
                {
        ?>
                    Swal.fire({
                        position: 'top',
                        icon: 'success',
                        title: '<?php echo $_SESSION['alert_text_rg'] ?>',
                        toast: true,
                        showConfirmButton: false, 
                        timer: 2500
                    })
                    setTimeout(function(){
                        location.href="login.php";
                    },3500)
        <?php
                }
                else if(isset($_SESSION['result_rg']) && $_SESSION['result_rg']==false)
                {
        ?>
                    Swal.fire({
                        position: 'top',
                        icon: 'error',
                        title: '<?php echo $_SESSION['alert_text_rg'] ?>',
                        toast: true,
                        showConfirmButton: false, 
                        timer: 4000
                    })
        <?php
                    if(isset($_SESSION['user_type']) && $_SESSION['user_type']=="Lensman")
                    {
                        $data_array = array("lastname", "firstname", "middlename", "nickname",
                        "email", "address", "birthday", "studio_name", "tin", "contact_num",
                        "id_upload_hidden", "id_upload_name_hidden",
                        "permit_upload_hidden", "permit_upload_name_hidden",
                        "pfp_upload_hidden", "pfp_upload_name_hidden",
                        "lat", "lng");
                        $user_type = "Lensman";
                        foreach($data_array as $value)
                        {
                            $$value = $_SESSION['regis_'.$value];
                            unset($_SESSION['regis_'.$value]);
                        }
                    }
                    else if(isset($_SESSION['user_type']) && $_SESSION['user_type']=="Customer")
                    {
                        $data_array = array("lastname", "firstname", "middlename", "nickname", 
                        "email", "address", "birthday", "contact_num", "pfp_upload_hidden", "pfp_upload_name_hidden");
                        foreach($data_array as $value)
                        {
                            $$value = $_SESSION['regis_'.$value];
                            unset($_SESSION['regis_'.$value]);
                        }
                    }
                }
                unset($_SESSION['alert_text_rg']);
                unset($_SESSION['result_rg']);
                unset($_SESSION['user_type']);
            endif; 
        ?>
        </script>
        <div class="title">
            <span style="margin-top: 30px;">Registration</span>
            <img src="css/images/brand-logo.png" style="margin-left: 150px; width: 25%; height:auto; margin-bottom: 20px" alt="">
        </div>
        <form method="POST" action="registration/register_usertype.php" enctype="multipart/form-data">
            <div class="type-details">
                <input type="radio" name="user_type" id="dot-2" value="Lensman" onclick="userTypeCheck();" checked>
                <input type="radio" name="user_type" id="dot-1" value="Customer" onclick="userTypeCheck();" ></br>
    
                <span class="type-title">Type of Account</span>
                <div class="category">
                
                <label for="dot-2">
                    <span class="dot two"></span>
                    <span class="type">Lensman</span>
                </label>
                <label for="dot-1">
                    <span class="dot one"></span>
                    <span class="type">Customer</span>
                </label>
                </div>
            </div>
            <div class="user-details">
                <div class="input-box">
                    <span class="details">Last Name</span>
                    <input type="text" name="lastname" placeholder="Enter your Last Name" value="<?php echo isset($lastname) ? $lastname : '' ?>" required>
                </div>
                <div class="input-box">
                    <span class="details">First Name</span>
                    <input type="text" name="firstname" placeholder="Enter your First Name" value="<?php echo isset($firstname) ? $firstname : '' ?>" required>
                </div>
                <div class="input-box">
                    <span class="details">Middle Name</span>
                    <input type="text" name="middlename" placeholder="Enter your Middle Name" value="<?php echo isset($middlename) ? $middlename : '' ?>" required>
                </div>
                <div class="input-box">
                    <span class="details">Nickname</span>
                    <input type="text" name="nickname" placeholder="Enter your desired Nickname" value="<?php echo isset($nickname) ? $nickname : '' ?>" required>
                </div>
                <div class="input-box">
                    <span class="details">Email</span>
                    <input type="text" name="email" placeholder="Enter your Email" value="<?php echo isset($email) ? $email : '' ?>" required>
                </div>
                <div class="input-box">
                    <span class="details">Address</span>
                    <input type="text" name="address" placeholder="Enter your Address" value="<?php echo isset($address) ? $address : '' ?>" required>
                </div>
                <div class="input-box">
                    <span class="details">Birthday</span>
                    <input type="date" name="birthday" placeholder="Enter your Birthday" value="<?php echo isset($birthday) ? $birthday : '' ?>" required>
                </div>
                <div class="input-box">
                    <span class="details">Sex</span>
                    <input type="radio" name="user_sex" value="Male" id="dot-11" checked>
                    <input type="radio" name="user_sex" value="Female" id="dot-12">
                    <div class="category">
                        <label for="dot-11">
                        <span class="dot eleven"></span>
                        <span class="type">Male</span>
                        </label>
                        <label for="dot-12">
                        <span class="dot twelve"></span>
                        <span class="type">Female</span>
                        </label>
                    </div>
                </div>
                <div class="input-box" id="ifLensman">
                    <label>Studio Name</label><br>
                    <input type="text" name="studio_name" id="studio_name" placeholder="Enter your Studio Name" value="<?php echo isset($studio_name) ? $studio_name : '' ?>" required>
                </div>
                
                <div class="input-box" id="ifLensman1">
                    <span class="details">Image of Valid ID<b class="ic" id="prev_btn_ID" onclick="showID()">&nbsp;&nbsp;Preview&nbsp;&nbsp;<i class="fas fa-id-card ic"></i></b></span>
                    <div for="id_upload" style="border: 1px solid gray; height: 45px; border-radius: 5px 5px 5px 5px; font-size: 18px; text-align:center; padding-top: 7px;">
                    <label for="id_upload" id="idLabel">Click here to upload file...</label>
                    </div>
                    <input type="file" name="id_upload" id="id_upload" style="color: grey;" onchange="imgActionID(this)" accept="image/png, image/gif, image/jpeg" hidden>
                    <input type="hidden" name="id_upload_hidden" id="id_upload_hidden" value="<?php echo isset($id_upload_hidden) ? $id_upload_hidden : '' ?>">
                    <input type="hidden" name="id_upload_name_hidden" id="id_upload_name_hidden" value="<?php echo isset($id_upload_name_hidden) ? $id_upload_name_hidden : '' ?>">
                </div>

                <div class="input-box" id="ifLensman2">
                    <span class="details">Image of BIR Permit<b class="ic" id="prev_btn_Permit" onclick="showPermit()">&nbsp;&nbsp;Prev&nbsp;&nbsp;<i class="fa-solid fa-money-check ic"></i></b></span>
                    <div for="permit_upload" style="border: 1px solid gray; height: 45px; border-radius: 5px 5px 5px 5px; font-size: 18px; text-align:center; padding-top: 7px;">
                    <label for="permit_upload" id="permitLabel">Click here to upload file...</label>
                    </div>
                    <input type="file" name="permit_upload" id="permit_upload" style="color: grey;" onchange="imgActionPermit(this)" accept="image/png, image/gif, image/jpeg" hidden>
                    <input type="hidden" name="permit_upload_hidden" id="permit_upload_hidden" value="<?php echo isset($permit_upload_hidden) ? $permit_upload_hidden : '' ?>">
                    <input type="hidden" name="permit_upload_name_hidden" id="permit_upload_name_hidden" value="<?php echo isset($permit_upload_name_hidden) ? $permit_upload_name_hidden : '' ?>">
                </div>
                <div class="input-box" id="ifLensman3">
                    <span class="details">TIN</span>
                    <input type="text" name="tin" id="tin" placeholder="ex. (XXX-XXX-XXX-XXX)" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');" maxlength="16" title="XXX-XXX-XXX-XXX" value="<?php echo isset($tin) ? $tin : '' ?>" required>
                </div>
                <div class="input-box">
                    <span class="details">Contact# (If Lensman G-Cash#)</span>
                    <input type="text" name="contact_num" placeholder="Enter your Contact Number" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');" maxlength="11" value="<?php echo isset($contact_num) ? $contact_num : '' ?>" required>
                </div>
                <div class="input-box">
                    <span class="details">Profile Picture<b class="ic" id="prev_btn_PP" onclick="showPP()">&nbsp;&nbsp;Preview&nbsp;&nbsp;<i class="fa fa-user" ic></i></b></span>
                    <div for="pfp_upload" style="border: 1px solid gray; height: 45px; border-radius: 5px 5px 5px 5px; font-size: 18px; text-align:center; padding-top: 7px;">
                    <label for="pfp_upload" id="ppLabel">Click here to upload file...</label>
                    </div>
                    <input type="file" name="pfp_upload" id="pfp_upload" style="color: grey;" onchange="imgActionPP(this)" accept="image/png, image/gif, image/jpeg" hidden>
                    <input type="hidden" name="pfp_upload_hidden" id="pfp_upload_hidden" value="<?php echo isset($pfp_upload_hidden) ? $pfp_upload_hidden : '' ?>">
                    <input type="hidden" name="pfp_upload_name_hidden" id="pfp_upload_name_hidden" value="<?php echo isset($pfp_upload_name_hidden) ? $pfp_upload_name_hidden : '' ?>">
                </div>

                <div class="input-box">
                    <span class="details">Password&nbsp;<i onclick="passInfo()" class="fas fa-lock ic" style="cursor: pointer; color: #114383;"></i><b id="passState"></b></span>
                    <input type="password" name="password" id="password" placeholder="Minimum of 8 Digits" title="Must contain at least one  number and one uppercase and lowercase letter, and at least 8 or more characters" required>
                </div>
                <div class="input-box">
                    <span class="details">Confirm Password<b id="cpassState"></b></span>
                    <input type="password" name="cPassword" id="cPassword" placeholder="Re-Enter Password" required>
                </div>
                <input type="hidden" name="lat" id="lat" value="<?php echo isset($lat) ? $lat : '' ?>">
                <input type="hidden" name="lng" id="lng" value="<?php echo isset($lng) ? $lng : '' ?>">
            </div>
            <div>
                <input style="cursor: pointer;" type="checkbox" id="agreement" name="agreement" value="agree" required>
                <label> I Accept Terms and Agreement</label>
                <label onclick='Terms_and_Conditions()'><i class="fas fa-info-circle ic" style="cursor: pointer; color: #114383;"></i></label>
            </div>
            <div class="button">
                <input type="submit" name="register" value="Register">
            </div>
        </form>
        <span class="toLog">
        <div>
				<p style="text-align: center;">Already have an Account? <a href="login.php">Go to Login</a></p>
			</div>
			<br>
			<div>
				<p style="text-align: center;"><a href="index.php">Go Back to Home Page</a></p>
			</div>
			<br>
        </span>
        </div>
        
		
        <div class="mapContainer" id="lensmanMap" style="text-align: center;">
            <h1 style="padding-top: 20px;">Location of the Studio</h1>
            <div class="map" id="googleMap">

            </div>
        </div>
    </div>
        <script>

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
                    customClass: {
                        cancelButton: 'swal2PP_cancel',
                    },
                    html: `
                        <h3 style="text-align: justify;">"Password must be a combination of lowercase and uppercase letter, number, special character, and  at least 8 or more digits"</h3>
                    `,
                    toast: true,
                    position: "center",
                    width: '400px',
                    showConfirmButton: false,
                    showCancelButton: true,
                    cancelButtonText: "Close",
                })
            }

            $('#password, #cPassword').on('keyup', function() {
                var pass = $('[name="password"]').val()
                var cpass = $('[name="cPassword"]').val()
                if(pass!='')
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
                }
            });

            document.getElementById('tin').addEventListener('input', function(e) {
                var foo = this.value.split("-").join("");
                if (foo.length <= 12) { //!/^\d{3}\-\d{3}\-\d{3}$/.test(foo)
                    foo = foo.match(new RegExp('.{1,3}', 'g')).join("-");
                }
                if (foo.length == 13) { //!/^\d{3}\-\d{3}\-\d{3}$/.test(foo)
                    foo = foo.replace(/(\d{3})(\d{3})(\d{3})(\d{4})/, "$1-$2-$3-$4");
                }
                this.value = foo;
            });

			function myMap() {
				var red_icon =  "assets/img/logos/confirmed.png" ;

                const myLatlng = { lat: 14.6499, lng: 120.4311 };
                const map = new google.maps.Map(document.getElementById("googleMap"), {
                    zoom: 10,
                    center: myLatlng,
                });

                var marker;

                <?php
                    if((isset($lat) && !empty($lat)) && (isset($lng) && !empty($lng)))
                    {
                ?>
                        const myOldLatlng = { lat: <?php echo $lat ?>, lng: <?php echo $lng ?> };
                        new google.maps.Marker({
                            position: myOldLatlng,
                            map: map,
                            icon :  red_icon,
                            title: "Previous Pin",
                        });
                <?php
                    }
                ?>

                function placeMarker(location) {
                    if ( marker ) {
                        marker.setPosition(location);
                    } else {
                        marker = new google.maps.Marker({
                            position: location,
                            map: map
                        });
                    }
                }
            
                google.maps.event.addListener(map, 'click', function(event) {
                    placeMarker(event.latLng);
                    var lat = event.latLng.lat(); // lat of clicked point
                    var lng = event.latLng.lng(); // lng of clicked point
                    document.getElementById('lat').value = lat;
                    document.getElementById('lng').value = lng;
                });

			}

            function Terms_and_Conditions()
            {
                window.open("Terms and Agreement/DataActPrivacy.php", "_blank")
            }
		</script>
        <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDtXuNd8wbu-NaASSm5G16Rba7Xc-mvSFs&callback=myMap"></script>
    </body>
    <script type="text/javascript" src="js/rButton_register.js"></script>
    <script type="text/javascript" src="js/file_upload_rg.js"></script>
    <script type="text/javascript" src="js/show_image_rg.js"></script>
    </html>