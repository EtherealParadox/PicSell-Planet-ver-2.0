    <?php
        session_start();
        require 'adminContent.php';

        if (!isset($_SESSION['login_admin_email']) && $_SESSION['logged_in_adm'] != true) {
            header("location: ../../index.php");
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
        <style>
            .btn:hover {
                cursor: pointer;
            }

            .title {
				display: flex;
				justify-content: space-between;
			}
            
            .search input[type=text] {
                padding: 5px;
                font-size: 20px;
            }
            
            .search input[type=button] {
                font-size: 20px;
				background-color: #114481;
				color:#fed136;
				border: none;
				border-radius: 5%;
			}
            
            #searchBtn {
                padding: 7px;
            }
            
            #cancelSearchBtn {
                padding: 3px 5px 7px 5px;
            }

            .rightPart {
                display: flex;
            }
            
			/* The container <div> - needed to position the dropdown content */
			.dropdown {
				margin-top: auto;
				margin-bottom: auto;
				position: relative;
				display: inline-block; margin-right: 10px;
			}

            .dropbtn {
				background-color: #114481;
				color: #fed136;
				padding: 7px;
				font-size: 20px;
				border: none !important;
				border-radius: 5%;
				cursor: pointer;
			}
            
			/* Dropdown Content (Hidden by Default) */
			.dropdown-content {
				right: 0;
				display: none;
				min-width: 140px;
				position: absolute;
				background-color: #f9f9f9;
				box-shadow: 0px 8px 16px 0px rgba(0,0,0,0.2);
				z-index: 1;
			}
            
			/* Links inside the dropdown */
			.dropdown-content a {
				color: black;
				padding: 12px 16px;
				text-decoration: none;
				display: block;
				text-align: center;
				font-weight: 650;
			}
            
			/* Change color of dropdown links on hover */
			.dropdown-content a:hover {background-color: #f1f1f1}
			/* Show the dropdown menu on hover */
			.dropdown:hover .dropdown-content {
				display: block;
			}
            
			/* Change the background color of the dropdown button when the dropdown content is shown */
			.dropdown:hover .dropbtn {
				border: none !important;
				background-color: #fed136;
				color: #114481;
			}

            .swal2_confirm_btn {
                background-color: #114481 !important;
            }

            .swal2_cancel_btn {
                background-color: crimson !important;
            }
        </style>
    </head>

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
                    <?php
                        if((isset($_GET['user_id']) || !isset($_GET['user_id'])) && !isset($_GET['verify'])):
                    ?>
                        <div class="title">
                            <div class="titlePart">
                                <h2 style="text-align:center; font-weight: bold;">Table in Accounts</h2>
                            </div>
                            <div class="rightPart">
                                <div class="dropdown">
                                    <button class="dropbtn">Sort Users</button>
                                    <div class="dropdown-content">
                                        <?php (isset($_GET['search'])) ? $search = '&search=' . $_GET['search'] : $search = '' ?>
                                        <a href="admin_accounts.php">All</a>
                                        <a href="?sort=Lensman<?php echo $search ?>">Lensman</a>
                                        <a href="?sort=Customer<?php echo $search ?>">Customer</a>
                                    </div>
                                </div>
                                <div class="search">
                                    <input type="text" placeholder="Search..." id="text_input">
                                    <input type="button" id="searchBtn" value="Search" onclick="search()">
                                    <input type="button" id="cancelSearchBtn" value="&#x2715;" onclick="location.href='admin_accounts.php'">
                                </div>
							</div>
                        </div>
                        <table>
                            <tr>
                                <th>User ID</th>
                                <th>Username</th>
                                <th>Email</th>
                                <th>Type</th>
                                <th>Address</th>
                                <th>Sex</th>
                                <th>Contact</th>
                                <th>Status</th>
                                <th colspan=2>Action</th>
                            </tr>
                        <?php
                            #If both are set
                            if(isset($_GET['search']) && isset($_GET['sort']))
                            {
                                include '../db_connect.php';
                                $item = $_GET['search'];
                                $sort = $_GET['sort'];

                                $users = $conn->query("SELECT user_id, CONCAT(user_first_name , ' ', user_last_name) as user_name, user_email, user_type, user_address, user_sex, user_birthday, user_contact, user_archive_status FROM `tbl_user_account` where user_first_name like '%$item%' OR user_last_name like '%$item%' and user_type = '$sort'");
                                while($row = $users->fetch_assoc())
                                {
                                    echo '<tr>';
                                        echo '<td>' . $row['user_id'] . '</td>';
                                        echo '<td>' . $row['user_name'] . '</td>';
                                        echo '<td>' . $row['user_email'] . '</td>';
                                        echo '<td>' . $row['user_type'] . '</td>';
                                        echo '<td>' . $row['user_address'] . '</td>';
                                        echo '<td>' . $row['user_sex'] . '</td>';
                                        echo '<td>' . $row['user_contact'] . '</td>';
                                        echo '<td>' . $row['user_archive_status'] . '</td>';
                                        echo '<td><a href="?user_id=' . $row['user_id'] . '" class="btn" /*href="admin_dashboard.php?posts_editing_id=' . $row['user_id'] . '"*/>View</a></td>';
                                        echo '<td onclick="archive('. $row['user_id'] .')"><a class="btn text-danger">Archive</a></td>';
                                    echo '</tr>';
                                }
                            }
                            #If search is set but not sort
                            if(isset($_GET['search']) && !isset($_GET['sort']))
                            {
                                include '../db_connect.php';
                                $item = $_GET['search'];

                                $users = $conn->query("SELECT user_id, CONCAT(user_first_name , ' ', user_last_name) as user_name, user_email, user_type, user_address, user_sex, user_birthday, user_contact, user_archive_status FROM `tbl_user_account` where user_first_name like '%$item%' OR user_last_name like '%$item%'");
                                while($row = $users->fetch_assoc())
                                {
                                    echo '<tr>';
                                        echo '<td>' . $row['user_id'] . '</td>';
                                        echo '<td>' . $row['user_name'] . '</td>';
                                        echo '<td>' . $row['user_email'] . '</td>';
                                        echo '<td>' . $row['user_type'] . '</td>';
                                        echo '<td>' . $row['user_address'] . '</td>';
                                        echo '<td>' . $row['user_sex'] . '</td>';
                                        echo '<td>' . $row['user_contact'] . '</td>';
                                        echo '<td>' . $row['user_archive_status'] . '</td>';
                                        echo '<td><a href="?user_id=' . $row['user_id'] . '" class="btn" /*href="admin_dashboard.php?posts_editing_id=' . $row['user_id'] . '"*/>View</a></td>';
                                        echo '<td onclick="archive('. $row['user_id'] .')"><a class="btn text-danger">Archive</a></td>';
                                    echo '</tr>';
                                }
                            }
                            #If sort is set but not search
                            if(!isset($_GET['search']) && isset($_GET['sort']))
                            {
                                include '../db_connect.php';
                                $sort = $_GET['sort'];

                                $users = $conn->query("SELECT user_id, CONCAT(user_first_name , ' ', user_last_name) as user_name, user_email, user_type, user_address, user_sex, user_birthday, user_contact, user_archive_status FROM `tbl_user_account` where user_type = '$sort'");
                                while($row = $users->fetch_assoc())
                                {
                                    echo '<tr>';
                                        echo '<td>' . $row['user_id'] . '</td>';
                                        echo '<td>' . $row['user_name'] . '</td>';
                                        echo '<td>' . $row['user_email'] . '</td>';
                                        echo '<td>' . $row['user_type'] . '</td>';
                                        echo '<td>' . $row['user_address'] . '</td>';
                                        echo '<td>' . $row['user_sex'] . '</td>';
                                        echo '<td>' . $row['user_contact'] . '</td>';
                                        echo '<td>' . $row['user_archive_status'] . '</td>';
                                        echo '<td><a href="?user_id=' . $row['user_id'] . '" class="btn" /*href="admin_dashboard.php?posts_editing_id=' . $row['user_id'] . '"*/>View</a></td>';
                                        echo '<td onclick="archive('. $row['user_id'] .')"><a class="btn text-danger">Archive</a></td>';
                                    echo '</tr>';
                                }
                            }
                            #If both are not set
                            if(!isset($_GET['search']) && !isset($_GET['sort']))
                            {
                                getAllAccounts();
                            }
                        ?>
                        </table>
                    <?php
                        endif;
                        if(isset($_GET['user_id']) && isset($_GET['verify'])):
                        include '../db_connect.php';
                        $user = $conn->query("SELECT * from tbl_user_account where user_id = {$_GET['user_id']}");
                        while($row=$user->fetch_assoc()):
                    ?>
                        <style>
                            .userInfoCont {
                                display: flex;
                                flex-direction: row;
                            }

                            .user_info_left {
                                height: 730px;
                                width: 50%;
                                background-color: #114481;
                            }

                            .user_info_left1 {
                                display: flex;
                                flex-direction: row;
                                margin: 20px;
                            }

                            .user_info_left1 > * {
                                margin: auto 0px auto 30px;
                                
                            }

                            .user_info_left2 {
                                text-align: center;
                            }

                            .user_info_left2 > * {
                                margin: 20px;
                            }

                            .user_info_left2 button {
                                background: #fed136;
                                color: black;
                                font-size: 20px;
                                font-weight: 600;
                                padding: 5px 10px;
                                border-radius: 20px;
                                border: none;
                            }

                            .user_info_right {
                                height: 730px;
                                width: 50%;
                                background-color: #114481;
                            }

                            h4 {
                                font-weight: normal;
                            }

                            #mapCont {
                                height: 730px
                            }
                        </style>
                        <div class="title">
                            <h2 style="text-align:center; font-weight: bold;">
                                <a href="admin_accounts.php"style="float: left; color:#114383"><i class="fa fa-arrow-left"></i>&nbsp;&nbsp;&nbsp;</a>
                                User Info
                            </h2>
                        </div>
                        <div class="userInfoCont">
                            <div class="user_info_left">
                                <div class="user_info_left1">
                                    <img src="../../images/profile-images/<?php echo $row['user_profile_image'] ?>"  style="width:150px; height: 150px; border-radius: 50%; object-fit:cover; ">
                                    <div style="display: flex; flex-direction: column; line-height: 30px; color: #fed136;">
                                        <h4 class="user_name"><b>Name:</b> <?php echo ucwords($row['user_last_name'] . ', ' .$row['user_first_name'] . ' ' . $row['user_middle_name']) ?></h4>
                                        <h4><b>Email:</b> <?php echo $row['user_email'] ?></h4>
                                        <h4><b>Address:</b> <?php echo $row['user_address'] ?></h4>
                                        <h4><b>Birthday:</b> <?php echo date("F m, Y", strtotime($row['user_birthday'])) ?></h4>
                                        <h4><b>Contact Num:</b> <?php echo $row['user_contact'] ?></h4>
                                    </div>
                                </div>
                                <div class="user_info_left2">
                                    <div>
                                        <a href="../../images/ID-images/<?php echo $row['user_id_image'] ?>"><img src="../../images/ID-images/<?php echo $row['user_id_image'] ?>"  style="width:350px; height: 200px; object-fit:cover; margin-bottom: 10px"></a>
                                        <a href="../../images/permit-images/<?php echo $row['user_permit_image'] ?>"><img src="../../images/permit-images/<?php echo $row['user_permit_image'] ?>"  style="width:350px; height: 200px; object-fit:cover; "></a>
                                    </div>
                                    <button style="cursor: pointer;" onclick="verifyLensman('<?php echo $row['user_id'] ?>', '<?php echo $row['user_email'] ?>')">Send Verification Email</button>
                                </div>
                            </div>
                            <div class="user_info_right" id="mapCont">

                            </div>
                        </div>
                        
                        
                        <script>
                            function verifyLensman(id, email)
                            {
                                Swal.fire({
                                    confirmButtonText: "Proceed",
                                    showCloseButton: true,
                                    html:
                                        '<h4>Proceed to send verification email to this Lensman?</h4>'
                                }).then((result) => {
                                        if (result.isConfirmed) {
                                            $.ajax({
                                                url:"admin_ajax.php?action=send_verification",
                                                method: 'POST',
                                                data: {user_id:id, user_email: email,},
                                                success:function(resp){
                                                    console.log(resp)
                                                    if(resp == 1){
                                                        Swal.fire({
                                                            position: 'top',
                                                            icon: 'success',
                                                            title: 'Verification Email Successfully Sent',
                                                            toast: true,
                                                            showConfirmButton: false, 
                                                            timer: 1500
                                                        })
                                                        setTimeout(function(){
                                                            location.href = "admin_accounts.php"
                                                        },4500)
                                                    }
                                                    if(resp == 2){
                                                        Swal.fire({
                                                            position: 'top',
                                                            icon: 'error',
                                                            title: 'Something went wrong',
                                                            toast: true,
                                                            showConfirmButton: false, 
                                                            timer: 2000
                                                        })
                                                    }
                                                }
                                            })
                                        }
                                })
                            }


                            function myMap()
                            {
                                var marker;
                                var infowindow;

                                const currentLatLng = { lat: <?php echo $row['user_lat'] ?>, lng: <?php echo $row['user_lng'] ?> };
                                const map = new google.maps.Map(document.getElementById("mapCont"), {
                                    zoom: 12,
                                    center: currentLatLng,
                                });

                                var myMarker = new google.maps.Marker({
                                    position: currentLatLng,
                                    map,
                                    html: 
                                        '<div><h3 style="font-weight:bold;"><?php echo ucwords($row['user_first_name'] . ' ' . $row['user_last_name']) . ' location' ?></h3></div>'
                                        
                                });
                                google.maps.event.addListener(myMarker, 'click', function() {
                                    infowindow = new google.maps.InfoWindow();
                                    infowindow.setContent(myMarker.html);
                                    infowindow.open(map, myMarker);
                                });
                            }
                        </script>
                        <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDtXuNd8wbu-NaASSm5G16Rba7Xc-mvSFs&callback=myMap"></script>
                    <?php
                        endwhile;
                        endif;
                    ?>
                    </div>
                </div>
            </div>
        </div>
    </body>
    
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
    <script>
        function search()
		{
			var item = document.getElementById("text_input").value;
            <?php (isset($_GET['sort'])) ? $sort = '&sort=' . $_GET['sort'] : $sort = '' ?>
			location.href = '?search='+item+'<?php echo $sort ?>'
		}

        function archive(id)
        {
            Swal.fire({
                confirmButtonText: "Proceed",
                showCancelButton: true,
                html:
                    '<h4>Proceed to archive this row from the database?</h4>'
            }).then((result) => {
                    if (result.isConfirmed) {
                        $.ajax({
                            url:"admin_ajax.php?action=archive_account",
                            method: 'POST',
                            data: {user_id:id},
                            success:function(resp){
                                console.log(resp)
                                if(resp == 1){
                                    Swal.fire({
                                        position: 'top',
                                        icon: 'success',
                                        title: 'Successfully Archived',
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
                                        title: 'Something went wrong',
                                        toast: true,
                                        showConfirmButton: false, 
                                        timer: 2000
                                    })
                                }
                            }
                        })
                    }
			})
        }
    </script>
    <?php
        function showUserInfo($id)
        {
            include '../db_connect.php';
            $user = $conn->query("SELECT * from tbl_user_account where user_id = $id")->fetch_assoc();
            if($user['user_type'] == "Customer")
            {
                if($user['user_verified'] == 0 && $user['user_archive_status'] == 0)
                {
                    echo '
                        <script>
                            Swal.fire({
                                customClass: {
                                    confirmButton: "swal2_confirm_btn",
                                    cancelButton: "swal2_cancel_btn",
                                },
                                confirmButtonText: \'Reactivate\',
                                cancelButtonText: \'Delete Data\',
                                showCancelButton: true,
                                showCloseButton: true,
                                html:
                                    "<div>" +
                                        \'<img src="../../images/profile-images/'.$user['user_profile_image'].'"  style="width:200px; height:200px; border: 2px solid black;border-radius: 50%; object-fit: cover;">\' +
                                        \'<h3 style="margin-bottom: 15px">Customer</h3>\' +
                                        \'<h4 style="margin-bottom: 15px">'. $user['user_last_name'] . ', ' . $user['user_first_name'] . ' ' . $user['user_middle_name'].'</h4>\' +
                                        \'<h4 style="margin-bottom: 15px">'.$user['user_nickname'].'</h4>\' +
                                        \'<h4 style="margin-bottom: 15px">'.$user['user_email'].'</h4>\' +
                                        \'<h4 style="margin-bottom: 15px">'.$user['user_address'].'</h4>\' +
                                    "</div>",
                                didOpen: () => {
                                    const close = document.querySelector(\'.swal2-close\')
                                
                                    close.addEventListener(\'click\', () => {
                                        location.href = "admin_accounts.php"
                                    })
                                }
                            }).then((result) => {
                                if (result.isConfirmed) {
                                    Swal.fire({
                                        customClass: {
                                            confirmButton: "swal2_confirm_btn",
                                        },
                                        title: \'Do you want to reactivate this user account?\',
                                        confirmButtonText: \'Proceed\',
                                        showCloseButton: true,
                                        didOpen: () => {
                                            const close = document.querySelector(\'.swal2-close\')
                                        
                                            close.addEventListener(\'click\', () => {
                                                location.href = "admin_accounts.php"
                                            })
                                        }
                                    }).then((result) => {
                                        if (result.isConfirmed) {
                                            $.ajax({
                                                url:"admin_ajax.php?action=reactivate_cm",
                                                method: \'POST\',
                                                data: {user_id:"'.$user['user_id'].'", user_email:"'.$user['user_email'].'"},
                                                success:function(resp){
                                                    console.log(resp)
                                                    if(resp == 1){
                                                        Swal.fire({
                                                            position: \'top\',
                                                            icon: \'success\',
                                                            title: \'Successfully Sent\',
                                                            toast: true,
                                                            showConfirmButton: false, 
                                                            timer: 2500
                                                        })
                                                        setTimeout(function(){
                                                            location.href = "admin_accounts.php"
                                                        },2000)
                                                    }
                                                    if(resp == 2){
                                                        Swal.fire({
                                                            position: \'top\',
                                                            icon: \'error\',
                                                            title: \'Something went wrong\',
                                                            toast: true,
                                                            showConfirmButton: false, 
                                                            timer: 3000
                                                        })
                                                        setTimeout(function(){
                                                            location.href = "admin_accounts.php"
                                                        },2000)
                                                    }
                                                }
                                            })
                                        }
                                    })
                                }
                                else if(result.dismiss == \'cancel\'){
                                    Swal.fire({
                                        customClass: {
                                            confirmButton: "swal2_confirm_btn",
                                        },
                                        title: \'Are you sure you want to delete this data?\',
                                        confirmButtonText: \'Proceed\',
                                        showCloseButton: true,
                                        didOpen: () => {
                                            const close = document.querySelector(\'.swal2-close\')
                                        
                                            close.addEventListener(\'click\', () => {
                                                location.href = "admin_accounts.php"
                                            })
                                        }
                                    }).then((result) => {
                                        if (result.isConfirmed) {
                                            $.ajax({
                                                url:"admin_ajax.php?action=delete_account",
                                                method: \'POST\',
                                                data: {user_id:"'.$user['user_id'].'"},
                                                success:function(resp){
                                                    console.log(resp)
                                                    if(resp == 1){
                                                        Swal.fire({
                                                            position: \'top\',
                                                            icon: \'success\',
                                                            title: \'Successfully Deleted\',
                                                            toast: true,
                                                            showConfirmButton: false, 
                                                            timer: 2500
                                                        })
                                                        setTimeout(function(){
                                                            location.reload()
                                                        },1000)
                                                    }
                                                    if(resp == 2){
                                                        Swal.fire({
                                                            position: \'top\',
                                                            icon: \'error\',
                                                            title: \'Something went wrong\',
                                                            toast: true,
                                                            showConfirmButton: false, 
                                                            timer: 3000
                                                        })
                                                    }
                                                }
                                            })
                                        }
                                    })
                                }
                            })
                        </script>
                    ';
                }
                else
                {
                    echo '
                        <script>
                            Swal.fire({
                                customClass: {
                                    confirmButton: "swal2_confirm_btn",
                                    cancelButton: "swal2_cancel_btn",
                                },
                                confirmButtonText: \'Re-send Email\',
                                cancelButtonText: \'Delete Data\',
                                showCancelButton: true,
                                showCloseButton: true,
                                html:
                                    "<div>" +
                                        \'<img src="../../images/profile-images/'.$user['user_profile_image'].'"  style="width:200px; height:200px; border: 2px solid black;border-radius: 50%; object-fit: cover;">\' +
                                        \'<h3 style="margin-bottom: 15px">Customer</h3>\' +
                                        \'<h4 style="margin-bottom: 15px">'. $user['user_last_name'] . ', ' . $user['user_first_name'] . ' ' . $user['user_middle_name'].'</h4>\' +
                                        \'<h4 style="margin-bottom: 15px">'.$user['user_nickname'].'</h4>\' +
                                        \'<h4 style="margin-bottom: 15px">'.$user['user_email'].'</h4>\' +
                                        \'<h4 style="margin-bottom: 15px">'.$user['user_address'].'</h4>\' +
                                    "</div>",
                                didOpen: () => {
                                    const close = document.querySelector(\'.swal2-close\')
                                
                                    close.addEventListener(\'click\', () => {
                                        location.href = "admin_accounts.php"
                                    })
                                }
                            }).then((result) => {
                                if (result.isConfirmed) {
                                    Swal.fire({
                                        customClass: {
                                            confirmButton: "swal2_confirm_btn",
                                        },
                                        title: \'Do you want to resend an email to this account?\',
                                        confirmButtonText: \'Proceed\',
                                        showCloseButton: true,
                                        didOpen: () => {
                                            const close = document.querySelector(\'.swal2-close\')
                                        
                                            close.addEventListener(\'click\', () => {
                                                location.href = "admin_accounts.php"
                                            })
                                        }
                                    }).then((result) => {
                                        if (result.isConfirmed) {
                                            $.ajax({
                                                url:"admin_ajax.php?action=resend_email_cm",
                                                method: \'POST\',
                                                data: {user_id:"'.$user['user_id'].'", user_email:"'.$user['user_email'].'"},
                                                success:function(resp){
                                                    console.log(resp)
                                                    if(resp == 1){
                                                        Swal.fire({
                                                            position: \'top\',
                                                            icon: \'success\',
                                                            title: \'Successfully Sent\',
                                                            toast: true,
                                                            showConfirmButton: false, 
                                                            timer: 2500
                                                        })
                                                        setTimeout(function(){
                                                            location.href = "admin_accounts.php"
                                                        },2000)
                                                    }
                                                    if(resp == 2){
                                                        Swal.fire({
                                                            position: \'top\',
                                                            icon: \'error\',
                                                            title: \'Something went wrong\',
                                                            toast: true,
                                                            showConfirmButton: false, 
                                                            timer: 3000
                                                        })
                                                        setTimeout(function(){
                                                            location.href = "admin_accounts.php"
                                                        },2000)
                                                    }
                                                }
                                            })
                                        }
                                    })
                                }
                                else if(result.dismiss == \'cancel\'){
                                    Swal.fire({
                                        customClass: {
                                            confirmButton: "swal2_confirm_btn",
                                        },
                                        title: \'Are you sure you want to delete this data?\',
                                        confirmButtonText: \'Proceed\',
                                        showCloseButton: true,
                                        didOpen: () => {
                                            const close = document.querySelector(\'.swal2-close\')
                                        
                                            close.addEventListener(\'click\', () => {
                                                location.href = "admin_accounts.php"
                                            })
                                        }
                                    }).then((result) => {
                                        if (result.isConfirmed) {
                                            $.ajax({
                                                url:"admin_ajax.php?action=delete_account",
                                                method: \'POST\',
                                                data: {user_id:"'.$user['user_id'].'"},
                                                success:function(resp){
                                                    console.log(resp)
                                                    if(resp == 1){
                                                        Swal.fire({
                                                            position: \'top\',
                                                            icon: \'success\',
                                                            title: \'Successfully Deleted\',
                                                            toast: true,
                                                            showConfirmButton: false, 
                                                            timer: 2500
                                                        })
                                                        setTimeout(function(){
                                                            location.reload()
                                                        },1000)
                                                    }
                                                    if(resp == 2){
                                                        Swal.fire({
                                                            position: \'top\',
                                                            icon: \'error\',
                                                            title: \'Something went wrong\',
                                                            toast: true,
                                                            showConfirmButton: false, 
                                                            timer: 3000
                                                        })
                                                    }
                                                }
                                            })
                                        }
                                    })
                                }
                            })
                        </script>
                    ';
                }
            }
            if($user['user_type'] == "Lensman")
            {
                if($user['user_verified'] == 0 && $user['user_archive_status'] == 0)
                {
                    echo '
                        <script>
                            Swal.fire({
                                customClass: {
                                    confirmButton: "swal2_confirm_btn",
                                    cancelButton: "swal2_cancel_btn",
                                },
                                confirmButtonText: \'Verify\',
                                cancelButtonText: \'Delete Data\',
                                showCancelButton: true,
                                showCloseButton: true,
                                html:
                                    "<div>" +
                                        \'<img src="../../images/profile-images/'.$user['user_profile_image'].'"  style="width:200px; height:200px; border: 2px solid black;border-radius: 50%; object-fit: cover;">\' +
                                        \'<h3 style="margin-bottom: 15px">Lensman</h3>\' +
                                        \'<h4 style="margin-bottom: 15px">'. $user['user_last_name'] . ', ' . $user['user_first_name'] . ' ' . $user['user_middle_name'].'</h4>\' +
                                        \'<h4 style="margin-bottom: 15px">'.$user['user_nickname'].'</h4>\' +
                                        \'<h4 style="margin-bottom: 15px">'.$user['user_email'].'</h4>\' +
                                        \'<h4 style="margin-bottom: 15px">'.$user['user_address'].'</h4>\' +
                                    "</div>",
                                didOpen: () => {
                                    const close = document.querySelector(\'.swal2-close\')
                                
                                    close.addEventListener(\'click\', () => {
                                        location.href = "admin_accounts.php"
                                    })
                                }
                            }).then((result) => {
                                if (result.isConfirmed) {
                                    //window.open(\'admin_user_verify.php?user_id='.$user['user_id'].'\', \'_blank\').focus();
                                    location.href = "admin_accounts.php?user_id='.$user['user_id'].'&verify"
                                }
                                else if(result.dismiss == \'cancel\'){
                                    Swal.fire({
                                        customClass: {
                                            confirmButton: "swal2_confirm_btn",
                                        },
                                        title: \'Are you sure you want to delete this data?\',
                                        confirmButtonText: \'Proceed\',
                                        showCloseButton: true,
                                        didOpen: () => {
                                            const close = document.querySelector(\'.swal2-close\')
                                        
                                            close.addEventListener(\'click\', () => {
                                                location.href = "admin_accounts.php"
                                            })
                                        }
                                    }).then((result) => {
                                        if (result.isConfirmed) {
                                            $.ajax({
                                                url:"admin_ajax.php?action=delete_account",
                                                method: \'POST\',
                                                data: {user_id:"'.$user['user_id'].'"},
                                                success:function(resp){
                                                    console.log(resp)
                                                    if(resp == 1){
                                                        Swal.fire({
                                                            position: \'top\',
                                                            icon: \'success\',
                                                            title: \'Successfully Deleted\',
                                                            toast: true,
                                                            showConfirmButton: false, 
                                                            timer: 2500
                                                        })
                                                        setTimeout(function(){
                                                            location.reload()
                                                        },1000)
                                                    }
                                                    if(resp == 2){
                                                        Swal.fire({
                                                            position: \'top\',
                                                            icon: \'error\',
                                                            title: \'Something went wrong\',
                                                            toast: true,
                                                            showConfirmButton: false, 
                                                            timer: 3000
                                                        })
                                                    }
                                                }
                                            })
                                        }
                                    })
                                }
                            })
                        </script>
                    ';
                }
                else
                {
                    #Resend email if user_verified is 0 and archive status is 1
                    echo '
                        <script>
                            Swal.fire({
                                customClass: {
                                    confirmButton: "swal2_confirm_btn",
                                    cancelButton: "swal2_cancel_btn",
                                },
                                confirmButtonText: \'Re-send Email\',
                                cancelButtonText: \'Delete Data\',
                                showCancelButton: true,
                                showCloseButton: true,
                                html:
                                    
                                    "<div>" +
                                        \'<img src="../../images/profile-images/'.$user['user_profile_image'].'"  style="width:200px; height:200px; border: 2px solid black;border-radius: 50%; object-fit: cover;">\' +
                                        \'<h3 style="margin-bottom: 15px">Lensman</h3>\' +
                                        \'<h4 style="margin-bottom: 15px">'. $user['user_last_name'] . ', ' . $user['user_first_name'] . ' ' . $user['user_middle_name'].'</h4>\' +
                                        \'<h4 style="margin-bottom: 15px">'.$user['user_nickname'].'</h4>\' +
                                        \'<h4 style="margin-bottom: 15px">'.$user['user_email'].'</h4>\' +
                                        \'<h4 style="margin-bottom: 15px">'.$user['user_address'].'</h4>\' +
                                    "</div>",
                                didOpen: () => {
                                    const close = document.querySelector(\'.swal2-close\')
                                
                                    close.addEventListener(\'click\', () => {
                                        location.href = "admin_accounts.php"
                                    })
                                }
                            }).then((result) => {
                                if (result.isConfirmed) {
                                    Swal.fire({
                                        customClass: {
                                            confirmButton: "swal2_confirm_btn",
                                        },
                                        title: \'Do you want to resend an email to this account?\',
                                        confirmButtonText: \'Proceed\',
                                        showCloseButton: true,
                                        didOpen: () => {
                                            const close = document.querySelector(\'.swal2-close\')
                                        
                                            close.addEventListener(\'click\', () => {
                                                location.href = "admin_accounts.php"
                                            })
                                        }
                                    }).then((result) => {
                                        if (result.isConfirmed) {
                                            $.ajax({
                                                url:"admin_ajax.php?action=resend_email_lm",
                                                method: \'POST\',
                                                data: {user_id:"'.$user['user_id'].'", user_email:"'.$user['user_email'].'"},
                                                success:function(resp){
                                                    console.log(resp)
                                                    if(resp == 1){
                                                        Swal.fire({
                                                            position: \'top\',
                                                            icon: \'success\',
                                                            title: \'Successfully Sent\',
                                                            toast: true,
                                                            showConfirmButton: false, 
                                                            timer: 2500
                                                        })
                                                        setTimeout(function(){
                                                            location.href = "admin_accounts.php"
                                                        },2000)
                                                    }
                                                    if(resp == 2){
                                                        Swal.fire({
                                                            position: \'top\',
                                                            icon: \'error\',
                                                            title: \'Something went wrong\',
                                                            toast: true,
                                                            showConfirmButton: false, 
                                                            timer: 3000
                                                        })
                                                        setTimeout(function(){
                                                            location.href = "admin_accounts.php"
                                                        },2000)
                                                    }
                                                }
                                            })
                                        }
                                    })
                                }
                                else if(result.dismiss == \'cancel\'){
                                    Swal.fire({
                                        customClass: {
                                            confirmButton: "swal2_confirm_btn",
                                        },
                                        title: \'Are you sure you want to delete this data?\',
                                        confirmButtonText: \'Proceed\',
                                        showCloseButton: true,
                                        didOpen: () => {
                                            const close = document.querySelector(\'.swal2-close\')
                                        
                                            close.addEventListener(\'click\', () => {
                                                location.href = "admin_accounts.php"
                                            })
                                        }
                                    }).then((result) => {
                                        if (result.isConfirmed) {
                                            $.ajax({
                                                url:"admin_ajax.php?action=delete_account",
                                                method: \'POST\',
                                                data: {user_id:"'.$user['user_id'].'"},
                                                success:function(resp){
                                                    console.log(resp)
                                                    if(resp == 1){
                                                        Swal.fire({
                                                            position: \'top\',
                                                            icon: \'success\',
                                                            title: \'Successfully Deleted\',
                                                            toast: true,
                                                            showConfirmButton: false, 
                                                            timer: 2500
                                                        })
                                                        setTimeout(function(){
                                                            location.reload()
                                                        },1000)
                                                    }
                                                    if(resp == 2){
                                                        Swal.fire({
                                                            position: \'top\',
                                                            icon: \'error\',
                                                            title: \'Something went wrong\',
                                                            toast: true,
                                                            showConfirmButton: false, 
                                                            timer: 3000
                                                        })
                                                    }
                                                }
                                            })
                                        }
                                    })
                                }
                            })
                        </script>
                    ';
                }
            }
        }
    
        if (isset($_GET['user_id']) && !isset($_GET['verify']))
        {
            showUserInfo($_GET['user_id']);
        }
    ?>
    
    </html>