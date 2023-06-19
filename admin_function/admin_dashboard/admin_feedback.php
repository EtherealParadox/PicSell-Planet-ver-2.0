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
				min-width: 154px;
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
                                <h2 style="text-align:center; font-weight: bold;">Table in Feedback</h2>
                            </div>
                            <div class="rightPart">
                                <div class="dropdown">
                                    <button class="dropbtn">Sort Feedbacks</button>
                                    <div class="dropdown-content">
                                        <?php (isset($_GET['search'])) ? $search = '&search=' . $_GET['search'] : $search = '' ?>
                                        <a href="admin_feedback.php">All</a>
                                        <a href="?sort=5<?php echo $search ?>">5 <i class="fas fa-star" style="color: #f3da35"></i> Ratings</a>
                                        <a href="?sort=4<?php echo $search ?>">4 <i class="fas fa-star" style="color: #f3da35"></i> Ratings</a>
                                        <a href="?sort=3<?php echo $search ?>">3 <i class="fas fa-star" style="color: #f3da35"></i> Ratings</a>
                                        <a href="?sort=2<?php echo $search ?>">2 <i class="fas fa-star" style="color: #f3da35"></i> Ratings</a>
                                        <a href="?sort=1<?php echo $search ?>">1 <i class="fas fa-star" style="color: #f3da35"></i> Ratings</a>
                                    </div>
                                </div>
                                <div class="search">
                                    <input type="text" placeholder="Search..." id="text_input">
                                    <input type="button" id="searchBtn" value="Search" onclick="search()">
                                    <input type="button" id="cancelSearchBtn" value="&#x2715;" onclick="location.href='admin_feedback.php'">
                                </div>
							</div>
                        </div>
                        <table>
                            <tr>
                                <th>Feedback ID</th>
                                <th>Rate</th>
                                <th>Message</th>
                                <th>Date</th>
                                <th>User Name</th>
                                <th colspan=2>Action</th>
                            </tr>
                        <?php
                            #If both are set
                            if(isset($_GET['search']) && isset($_GET['sort']))
                            {
                                include '../db_connect.php';
                                $item = $_GET['search'];
                                $sort = $_GET['sort'];

                                $users = $conn->query("SELECT f.feedback_id, f.feedback_rate, f.feedback_message, f.feedback_date, CONCAT(u.user_first_name , ' ', u.user_last_name) as user_name FROM `tbl_feedback` f JOIN `tbl_user_account` u ON f.user_id = u.user_id where (u.user_first_name like '%$item%' or u.user_last_name like '%$item%') and f.feedback_rate = '$sort' AND NOT feedback_archive_status = 0");
                                while($row = $users->fetch_assoc())
                                {
                                    (!empty($row['feedback_message'])) ? $fdbk_msg = $row['feedback_message'] : $fdbk_msg = "User did not leave any message.";
                                    echo '<tr>';
                                        echo '<td>' . $row['feedback_id'] . '</td>';
                                        echo '<td>' . $row['feedback_rate'] . ' <i class="fas fa-star" style="color: #f3da35"></i></td>';
                                        echo '<td>' . $fdbk_msg . '</td>';
                                        echo '<td>' . $row['feedback_date'] . '</td>';
                                        echo '<td>' . $row['user_name'] . '</td>';
                                        echo '<td><a href="#" class="btn" href="admin_dashboard.php?posts_editing_id=' . $row['feedback_id'] . '">View</a></td>';
                                        echo '<td onclick="archive('. $row['feedback_id'] .')"><a href="#" class="btn text-danger" href="admin_dashboard.php?posts_deleting_id=' . $row['feedback_id'] . '">Archive</a></td>';
                                    echo '</tr>';
                                }
                            }
                            #If search is set but not sort
                            if(isset($_GET['search']) && !isset($_GET['sort']))
                            {
                                include '../db_connect.php';
                                $item = $_GET['search'];

                                $fdbk = $conn->query("SELECT f.feedback_id, f.feedback_rate, f.feedback_message, f.feedback_date, CONCAT(u.user_first_name , ' ', u.user_last_name) as user_name FROM `tbl_feedback` f JOIN `tbl_user_account` u ON f.user_id = u.user_id where (u.user_first_name like '%$item%' or u.user_last_name like '%$item%') AND NOT feedback_archive_status = 0");
                                while($row = $fdbk->fetch_assoc())
                                {
                                    (!empty($row['feedback_message'])) ? $fdbk_msg = $row['feedback_message'] : $fdbk_msg = "User did not leave any message.";
                                    echo '<tr>';
                                        echo '<td>' . $row['feedback_id'] . '</td>';
                                        echo '<td>' . $row['feedback_rate'] . ' <i class="fas fa-star" style="color: #f3da35"></i></td>';
                                        echo '<td>' . $fdbk_msg . '</td>';
                                        echo '<td>' . $row['feedback_date'] . '</td>';
                                        echo '<td>' . $row['user_name'] . '</td>';
                                        echo '<td><a href="#" class="btn" href="admin_dashboard.php?posts_editing_id=' . $row['feedback_id'] . '">View</a></td>';
                                        echo '<td onclick="archive('. $row['feedback_id'] .')"><a href="#" class="btn text-danger" href="admin_dashboard.php?posts_deleting_id=' . $row['feedback_id'] . '">Archive</a></td>';
                                    echo '</tr>';
                                }
                            }
                            #If sort is set but not search
                            if(!isset($_GET['search']) && isset($_GET['sort']))
                            {
                                include '../db_connect.php';
                                $sort = $_GET['sort'];

                                $users = $conn->query("SELECT f.feedback_id, f.feedback_rate, f.feedback_message, f.feedback_date, CONCAT(u.user_first_name , ' ', u.user_last_name) as user_name FROM `tbl_feedback` f JOIN `tbl_user_account` u ON f.user_id = u.user_id where f.feedback_rate = '$sort' AND NOT feedback_archive_status = 0");
                                while($row = $users->fetch_assoc())
                                {
                                    (!empty($row['feedback_message'])) ? $fdbk_msg = $row['feedback_message'] : $fdbk_msg = "User did not leave any message.";
                                    echo '<tr>';
                                        echo '<td>' . $row['feedback_id'] . '</td>';
                                        echo '<td>' . $row['feedback_rate'] . ' <i class="fas fa-star" style="color: #f3da35"></i></td>';
                                        echo '<td>' . $fdbk_msg . '</td>';
                                        echo '<td>' . $row['feedback_date'] . '</td>';
                                        echo '<td>' . $row['user_name'] . '</td>';
                                        echo '<td><a href="#" class="btn" href="admin_dashboard.php?posts_editing_id=' . $row['feedback_id'] . '">View</a></td>';
                                        echo '<td onclick="archive('. $row['feedback_id'] .')"><a href="#" class="btn text-danger" href="admin_dashboard.php?posts_deleting_id=' . $row['feedback_id'] . '">Archive</a></td>';
                                    echo '</tr>';
                                }
                            }
                            #If both are not set
                            if(!isset($_GET['search']) && !isset($_GET['sort']))
                            {
                                getAllFeedback();
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
                            url:"admin_ajax.php?action=archive_feedback",
                            method: 'POST',
                            data: {feedback_id:id},
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
        function showFeedbackInfo($id)
        {
            include '../db_connect.php';
            $fdbk = $conn->query("SELECT f.* , CONCAT(u.user_first_name , ' ', u.user_last_name) as user_name from tbl_feedback f inner join tbl_user_account u on u.user_id = f.user_id where f.feedback_id = $id");
            while($row = $fdbk->fetch_assoc()):
                foreach($row as $k => $v)
                {
                    # 0 = feedback_id, 1 = feedback_rate, 2 = feedback_message, 3 = feedback_date
                    # 4 = user_id, 5 = lensman_id, 6 = product_id, 7 = feedback_archive_status, 8 = user_name
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
                                \'<h3 style="margin-bottom: 15px">'.$arr[8].'</h3>\' +
                                \'<h4 style="margin-bottom: 15px">'.$arr[1].' <i class="fas fa-star" style="color: #f3da35"></i> rating</h4>\' +
            ';
                (!empty($arr[2])) ? $fdbk_msg = $arr[2] : $fdbk_msg = "User did not leave any message.";
                $date = date("F d, Y", strtotime($arr[3]));
                $time = date("h:i A", strtotime($arr[3]));
                $datetime = $date . ' (' . $time . ' )';
            echo '
                                \'<h4 style="margin-bottom: 15px">'.$fdbk_msg.'</h4>\' +
                                \'<h4 style="margin-bottom: 15px">'.$datetime.'</h4>\' +
                            "</div>",
                    }).then((result) => {
                        if (result.isConfirmed) {
                            location.href = "admin_feedback.php"
                        }
                    })
                </script>
            ';
        }
    
        if (isset($_GET['feedback_id']))
        {
            showFeedbackInfo($_GET['feedback_id']);
        }
    ?>
    </html>