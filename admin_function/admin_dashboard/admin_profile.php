<?php
        session_start();
        require 'adminContent.php';

        if (!isset($_SESSION['login_admin_email']) && $_SESSION['logged_in_adm'] != true) {
            header("location: ../admin_login.php");
        }
        include '../db_connect.php';
        $qry = $conn->query("SELECT admin_name, admin_email, admin_profile_image FROM tbl_admin_account WHERE admin_id = {$_SESSION['login_admin_id']}")->fetch_assoc();
    ?>

    <!DOCTYPE html>
    <html lang="en">
        <head>
            <meta charset="UTF-8">
            <meta http-equiv="X-UA-Compatible" content="IE=edge">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <link rel="stylesheet" href="css/style_admin_pages.css">
            <link rel="stylesheet" href="css/style_notif.css">
            <link rel="shortcut icon" href="logo.png">
            <script type="text/javascript" src="js/notif.js"></script>
            <script src="https://kit.fontawesome.com/04bcc1e908.js" crossorigin="anonymous"></script>
            <title>Pic-Sell Planet: Admin</title>
        </head>
        <style>
            .swal2_img {
                width: 250px; 
                height: 250px; 
                object-fit: cover; 
                border-radius: 100%;
            }
            
        </style>
        <body>
            <div class="side-menu">
                <div class="brand-name">
                    <img class="logo" src="logo.png" alt="">
                    <h1>Pic-Sell Planet</h1>
                </div>
                <ul>
                <li><a href="admin_dashboard.php"><i class="fa fa-table"></i> <span>Dashboard</span></a></li>
                    <li><a href="admin_newsfeed.php"><i class="fa fa-home"></i> <span>Newsfeed</span></a></li>
                    <li><a href="admin_services.php"><i class="fa fa-camera"></i> <span>Services</span></a></li>
                    <li><a href="admin_products.php"><i class="fa fa-store"></i> <span>Products</span></a></li>
                    <li><a href="admin_feedback.php"><i class="fa fa-comment"></i> <span>Feedbacks</span></a></li>
                    <li><a href="admin_accounts.php"><i class="fa fa-users"></i> <span>Accounts</span></a></li>
                    <li><a href="admin_profile.php"><i class="fa fa-user"></i> <span>Admin Profile</span></a></li>
                </ul>
            </div>
            <div class="container">
                <div class="header">
                    <div class="nav">
                        <div class="user">
                            <?php
                                include "notification.php";
                            ?>
                            <div class="img-case">
                                <img src="../assets/img/<?php echo $qry['admin_profile_image'] ?>" alt="" style="object-fit: cover; border-radius: 100%;" />
                            </div>
                            <span class="user-name"><?php echo $qry['admin_name'] ?></span>
                            <span class="user-name">/</span>
                            <a href="../logout.php"><span class="admin-logout">Logout</span></a>
                        </div>
                    </div>
                </div>
                <div class="content">
                    <div class="content-2">
                        <div class="recent-payments">
                            <div style="margin-top: 20px; width:100%;">
                                <div style="margin:auto; position:relative; width:fit-content;">
                                    <img src="../assets/img/<?php echo $qry['admin_profile_image'] ?>" alt="admin_profile_pic" style="width: 250px; height: 250px; object-fit: cover; border: 3px solid black; border-radius: 100%;">
                                    <i onclick="changeProfImg()" style="position: absolute; right: 10px; bottom: 10px; padding: 30px 15px 30px 15px; border-radius: 100%; background-color: black; color: white;" class="fa fa-camera rounded-circle fa-xl"></i>
                                </div>
                                <div style="margin: 20px auto auto auto; width:fit-content; text-align:center;">
                                    <div style="display: flex;">
                                        <img style="width:50px; height: auto;" src="https://cdn-icons-png.flaticon.com/512/7716/7716975.png" alt="">
                                        &nbsp;&nbsp;
                                        <h1 class="user-name"><?php echo $qry['admin_name'] ?></h1>
                                    </div>
                                    <small onclick="changeName()" style="color: grey; cursor: pointer;"><b>Edit Name</b></small><br />
                                    <small onclick="changePass()" style="color: grey; cursor: pointer;"><b>Change Password</b></small>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </body>
        <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
        <script>

            function changeName()
            {
                Swal.fire({
                    title: 'Change Admin Name',
                    html: `
                        <input style="margin: 0; width: 440px;" type="text" id="Name" class="swal2-input" oninput="this.value = this.value.replace(/[^0-9a-zA-Z ]+/g,'');" placeholder="Please enter your new name">
                    `,
                    showCloseButton: true,
                    confirmButtonText: 'Change name',
                    focusConfirm: false,
                    preConfirm: () => {
                        const Name = Swal.getPopup().querySelector('#Name').value
                        if (!Name) {
                            Swal.showValidationMessage(`Input is empty!`)
                        }
                        return { Name: Name}
                    }
                }).then((result) => {
                    const name = result.value.Name;
                    Swal.fire({
                        title:
                            'Proceed to change Admin Name?' 
                        ,
                        showCloseButton: true,
                        confirmButtonText: 'Proceed',
                    }).then(function(result) {
                        if(result.isConfirmed)
                        {
                            $.ajax({
                                url:"admin_ajax.php?action=change_admin_name",
                                method: 'POST',
                                data: {admin_id: '<?php echo $_SESSION['login_admin_id'] ?>', admin_name: name},
                                success:function(resp){
                                    console.log(resp)
                                    if(resp == 1){
                                        Swal.fire({
                                            position: 'top',
                                            icon: 'success',
                                            title: 'Admin Name Successfully Changed',
                                            toast: true,
                                            showConfirmButton: false, 
                                            timer: 1500
                                        })
                                        setTimeout(function(){
                                            location.reload()
                                        },1000)
                                    }
                                    if(resp == 2){
                                        Swal.fire({
                                            position: 'top',
                                            icon: 'success',
                                            title: 'Something went wrong..',
                                            toast: true,
                                            showConfirmButton: false, 
                                            timer: 1500
                                        })
                                        setTimeout(function(){
                                            location.reload()
                                        },1000)
                                    }
                                }
                            })
                        }
                    })
                })
            }

            function changeProfImg()
            {
                Swal.fire({
                    title: 'Select a file',
                    text: 'Select the image you want to be your Profile Image',
                    showCancelButton: true,
                    confirmButtonText: 'Upload',
                    input: 'file',
                    inputAttributes: {
                        id: 'swal2-file',
                        'accept': 'image/png, image/jpeg',
                        'aria-label': 'Upload your new profile image'
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
                                    '<h4>Proceed to use this image?</h4>' 
                                ,
                                imageUrl: e.target.result,
                                showCancelButton: true,
                                confirmButtonText: 'Proceed',
                            }).then(function(result) {
                                if(result.isConfirmed)
                                {
                                    var formData = {
                                        admin_id: '<?php echo $_SESSION['login_admin_id'] ?>',
                                        new_prof_image: reader.result,
                                    };
                                    $.ajax({
                                        url:"admin_ajax.php?action=change_admin_profile",
                                        method: 'POST',
                                        data: formData,
                                        success:function(resp){
                                            console.log(resp)
                                            if(resp == 1){
                                                Swal.fire({
                                                    position: 'top',
                                                    icon: 'success',
                                                    title: 'Profile Image Successfully Changed',
                                                    toast: true,
                                                    showConfirmButton: false, 
                                                    timer: 1500
                                                })
                                                setTimeout(function(){
                                                    location.reload()
                                                },1000)
                                            }
                                            if(resp == 2){
                                                Swal.fire({
                                                    position: 'top',
                                                    icon: 'error',
                                                    title: 'Something went wrong..',
                                                    toast: true,
                                                    showConfirmButton: false, 
                                                    timer: 1500
                                                })
                                                setTimeout(function(){
                                                    location.reload()
                                                },1000)
                                            }
                                            if(resp == 3){
                                                Swal.fire({
                                                    position: 'top',
                                                    icon: 'error',
                                                    title: 'Nothing was changed..',
                                                    toast: true,
                                                    showConfirmButton: false, 
                                                    timer: 1500
                                                })
                                                setTimeout(function(){
                                                    location.reload()
                                                },1000)
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
                        Swal.fire({
                            position: 'top',
                            icon: 'error',
                            title: 'You didnt upload anything..',
                            toast: true,
                            showConfirmButton: false, 
                            timer: 1500
                        })
                        setTimeout(function(){
                            location.reload()
                        },1000)
                    }
                })
            }

            function changePass()
            {
                Swal.fire({
                    title: 'Change Admin Password',
                    html: `
                        <div style="display: flex; flex-direction: column;">
                            <input onkeyup="checkPass()" style="margin: 0 0 10px 0; width: 440px;" type="password" name="password" id="password" class="swal2-input" oninput="this.value = this.value.split(" ").join("");" placeholder="Password">
                            <small style="font-weight: 700;" id="passState"></small>
                            <input onkeyup="checkPass()" style="margin: 10px 0 10px 0; width: 440px;" type="password" name="cPassword" id="cPassword" class="swal2-input" oninput="this.value = this.value.split(" ").join("");" placeholder="Confirm Password">
                            <small style="font-weight: 700;" id="cpassState"></small>
                        </div>
                    `,
                    showCloseButton: true,
                    confirmButtonText: 'Change password',
                    focusConfirm: false,
                    preConfirm: () => {
                        const password = Swal.getPopup().querySelector('#password').value
                        const cPassword = Swal.getPopup().querySelector('#cPassword').value
                        if (!password || !cPassword) {
                            Swal.showValidationMessage(`Some input is empty!`)
                        }
                        return { password: password, cPassword: cPassword}
                    }
                }).then((result) => {
                    const password = result.value.password;
                    const cPassword = result.value.cPassword;
                    Swal.fire({
                        title:
                            'Proceed to change password?' 
                        ,
                        showCloseButton: true,
                        confirmButtonText: 'Proceed',
                    }).then(function(result) {
                        if(result.isConfirmed)
                        {
                            $.ajax({
                                url:"admin_ajax.php?action=change_admin_pass",
                                method: 'POST',
                                data: {admin_id: '<?php echo $_SESSION['login_admin_id'] ?>', password: password, cPassword: cPassword},
                                success:function(resp){
                                    console.log(resp)
                                    if(resp == 1){
                                        Swal.fire({
                                            position: 'top',
                                            icon: 'success',
                                            title: 'Password Successfully Changed',
                                            toast: true,
                                            showConfirmButton: false, 
                                            timer: 1500
                                        })
                                        setTimeout(function(){
                                            location.reload()
                                        },1000)
                                    }
                                    if(resp == 2){
                                        Swal.fire({
                                            position: 'top',
                                            icon: 'error',
                                            title: 'Something went wrong..',
                                            toast: true,
                                            showConfirmButton: false, 
                                            timer: 1500
                                        })
                                        setTimeout(function(){
                                            location.reload()
                                        },1000)
                                    }
                                    if(resp == 3){
                                        Swal.fire({
                                            position: 'top',
                                            icon: 'error',
                                            title: 'Password should be a mix of Uppercase, Lowercase, Number, and optional Special character',
                                            toast: true,
                                            showConfirmButton: false, 
                                            timer: 1500
                                        })
                                        setTimeout(function(){
                                            location.reload()
                                        },1000)
                                    }
                                    if(resp == 4){
                                        Swal.fire({
                                            position: 'top',
                                            icon: 'error',
                                            title: 'Password does not match',
                                            toast: true,
                                            showConfirmButton: false, 
                                            timer: 1500
                                        })
                                        setTimeout(function(){
                                            location.reload()
                                        },1000)
                                    }
                                    if(resp == 5){
                                        Swal.fire({
                                            position: 'top',
                                            icon: 'error',
                                            title: 'Password is too short',
                                            toast: true,
                                            showConfirmButton: false, 
                                            timer: 1500
                                        })
                                        setTimeout(function(){
                                            location.reload()
                                        },1000)
                                    }
                                }
                            })
                        }
                    })
                })
            }

            function checkPass()
            {
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
            }
		</script>
    </html>