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
        <style>
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
                        <div class="title">
                            <div class="titlePart">
                                <h2 style="text-align:center; font-weight: bold;">Table in Services</h2>
                            </div>
                            <div class="search">
                                <input type="text" placeholder="Search..." id="text_input">
                                <input type="button" id="searchBtn" value="Search" onclick="search()">
                                <input type="button" id="cancelSearchBtn" value="&#x2715;" onclick="location.href='admin_services.php'">
                            </div>
                        </div>
                        <table>
                            <tr>
                                <th>Service ID</th>
                                <th>Service Type</th>
                                <th>Price</th>
                                <th>Description</th>
                                <th>User Name</th>
                                <th colspan=2>Action</th>
                            </tr>
                        <?php
                            if(isset($_GET['search']))
                            {
                                include '../db_connect.php';
                                $item = $_GET['search'];
                                $srvc_pckgs = $conn->query("SELECT sp.service_id, sp.service_name, sp.service_price, sp.service_description, CONCAT(u.user_first_name , ' ', u.user_last_name) as user_name FROM `tbl_service_packages` sp JOIN `tbl_user_account` u ON sp.user_id = u.user_id where (sp.service_name like '%$item%' or (u.user_first_name like '%$item%' or u.user_last_name like '%$item%')) AND NOT service_archive_status = 0");
                                while($row = $srvc_pckgs->fetch_assoc())
                                {
                                    echo '<tr>';
                                        echo '<td>' . $row['service_id'] . '</td>';
                                        echo '<td>' . $row['service_name'] . '</td>';
                                        echo '<td>' . $row['service_price'] . '</td>';
                                        echo '<td>' . $row['service_description'] . '</td>';
                                        echo '<td>' . $row['user_name'] . '</td>';
                                        echo '<td><a href="?service_id=' . $row['service_id'] . '" class="btn" /*href="admin_dashboard.php?posts_editing_id=' . $row['service_id'] . '"*/>View</a></td>';
                                        echo '<td onclick="archive('. $row['service_id'] .')"><a href="#" class="btn text-danger" href="admin_dashboard.php?posts_deleting_id=' . $row['service_id'] . '">Archive</a></td>';
                                    echo '</tr>';
                                }
                            }
                            else
                            {
                                getAllServices();
                            }
                        ?>
                        </table>
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
			location.href = '?search='+item+''
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
                            url:"admin_ajax.php?action=archive_service",
                            method: 'POST',
                            data: {service_id:id},
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
        function showServiceInfo($id)
        {
            include '../db_connect.php';
            $service = $conn->query("SELECT s.* , CONCAT(u.user_first_name , ' ', u.user_last_name) as user_name from tbl_service_packages s inner join tbl_user_account u on u.user_id = s.user_id where s.service_id = $id");
            while($row = $service->fetch_assoc()):
                foreach($row as $k => $v)
                {
                    # 0 = service_id, 1 = service_name, 2 = service_price, 3 = service_hours
                    # 4 = service_description, 5 = service_banner, 6 = user_id, 7 = service_archive_status, 8 = user_name
                    $arr[] = $v;
                    $mwe = json_encode($arr);
                }    
            endwhile;
            echo '
                <script>
                    console.log('.$mwe.')
                </script>
            ';
            echo '
                <script>
                    Swal.fire({
                        confirmButtonText: \'Close\',
                        html:
                            "<div>" +
                                \'<img src="../../user_functions/assets/banners/'.$arr[5].'"  style="width:200px;">\' +
                                \'<h3 style="margin-bottom: 15px">'.$arr[1].'</h3>\' +
                                \'<h4 style="margin-bottom: 15px">Php '.$arr[2].'</h4>\' +
                                \'<h4 style="margin-bottom: 15px">'.$arr[3].' hour/s</h4>\' +
                                \'<h4 style="margin-bottom: 15px">'.$arr[8].'</h4>\' +
                            "</div>",
                    }).then((result) => {
                        if (result.isConfirmed) {
                            location.href = "admin_services.php"
                        }
                    })
                </script>
            ';
        }
    
        if (isset($_GET['service_id']))
        {
            showServiceInfo($_GET['service_id']);
        }
    ?>
    </html>