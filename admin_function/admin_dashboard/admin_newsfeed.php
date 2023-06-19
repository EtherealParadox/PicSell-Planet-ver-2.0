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
                        <?php
                            if((isset($_GET['post_id']) || !isset($_GET['post_id'])) && !isset($_GET['reports'])):
                        ?>
                            <div class="title">
                                <div class="titlePart" style="display: flex;">
                                    <h2 style="text-align:center; font-weight: bold;">Table in Newsfeed</h2>
                                    &nbsp;&nbsp;&nbsp;&nbsp;
                                    <button onclick="location.href='?reports';">Reported</button>
                                </div>
                                <div class="search">
                                    <input type="text" placeholder="Search..." id="text_input">
                                    <input type="button" id="searchBtn" value="Search" onclick="search()">
                                    <input type="button" id="cancelSearchBtn" value="&#x2715;" onclick="location.href='admin_newsfeed.php'">
                                </div>
                            </div>
                            <table>
                            <tr>
                                <th>Post Id</th>
                                <th>Post Content</th>
                                <th>Post Date</th>
                                <th>User Name</th>
                                <th colspan=2>Action</th>
                            </tr>
                            <?php
                                if(isset($_GET['search']))
                                {
                                    include '../db_connect.php';
                                    $item = $_GET['search'];
                                    $post = $conn->query("SELECT  p.post_id, p.post_content, p.post_date, CONCAT(u.user_first_name , ' ', u.user_last_name) as user_name FROM `tbl_post` p JOIN `tbl_user_account` u ON p.user_id = u.user_id where (u.user_first_name like '%$item%' or u.user_last_name like '%$item%') AND NOT post_archive_status = 0;");
                                    while($row = $post->fetch_assoc())
                                    {
                                        (!empty($row['post_content'])) ? $post_content = $row['post_content'] : $post_content = "-User did not put any message-";
                                        echo '<tr>';
                                            echo '<td>' . $row['post_id'] . '</td>';
                                            echo '<td>' . $post_content . '</td>';
                                            echo '<td>' . $row['post_date'] . '</td>';
                                            echo '<td>' . $row['user_name'] . '</td>';
                                            echo '<td><a href="?search=' . $_GET['search'] . '&post_id=' . $row['post_id'] . '" class="btn" /*href="admin_dashboard.php?posts_editing_id=' . $row['post_id'] . '"*/>View</a></td>';
                                            echo '<td onclick="archive('. $row['post_id'] .')"><a href="#" class="btn text-danger" href="admin_dashboard.php?posts_deleting_id=' . $row['post_id'] . '">Archive</a></td>';
                                        echo '</tr>';
                                    }
                                }
                                else
                                {
                                    getAllPost();
                                }
                            ?>
                            </table>
                        <?php
                            endif;
                            if(isset($_GET['reports'])):
                        ?>
                            <div class="title">
                                <div class="titlePart" style="display: flex;">
                                    <h2 style="text-align:center; font-weight: bold;">
                                    <a href="admin_newsfeed.php"style="float: left; color:#114383"><i class="fa fa-arrow-left"></i>&nbsp;&nbsp;&nbsp;</a>
                                    Table in Newsfeed (Reported Posts)
                                    </h2>
                                </div>
                            </div>
                            <table>
                            <tr>
                                <th>Post Id</th>
                                <th>Post Content</th>
                                <th>Post Date</th>
                                <th>User Name</th>
                                <th># of Reports</th>
                                <th>Action</th>
                            </tr>
                        <?php
                            include '../db_connect.php';
                            $post = $conn->query("SELECT  p.post_id, p.post_content, p.post_date, CONCAT(u.user_first_name , ' ', u.user_last_name) as user_name FROM `tbl_post` p JOIN `tbl_user_account` u ON p.user_id = u.user_id");
                            while($row = $post->fetch_assoc())
                            {
                                $post_id = $row['post_id'];
                                $report_num = $conn->query("SELECT * FROM tbl_reports WHERE post_id = '$post_id' ")->num_rows;
                                if($report_num!=0):
                                    (!empty($row['post_content'])) ? $post_content = $row['post_content'] : $post_content = "-User did not put any message-";
                                    echo '<tr>';
                                        echo '<td>' . $row['post_id'] . '</td>';
                                        echo '<td>' . $post_content . '</td>';
                                        echo '<td>' . $row['post_date'] . '</td>';
                                        echo '<td>' . $row['user_name'] . '</td>';
                                        echo '<td>' . $report_num . '</td>';
                                        $report_detail = $conn->query("SELECT report_id FROM `tbl_reports` WHERE post_id = '$post_id'")->fetch_assoc();
                                        echo '<td onclick="remove('. $row['post_id'] .', '.$report_detail['report_id'].')"><a href="#" class="btn text-danger" href="admin_dashboard.php?posts_deleting_id=' . $row['post_id'] . '">Remove</a></td>';
                                    echo '</tr>';
                                else:
                                    continue;
                                endif;
                            }
                        ?>
                            </table>
                        <?php
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
                                url:"admin_ajax.php?action=archive_post",
                                method: 'POST',
                                data: {post_id:id},
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

            function remove(post_id, report_id)
            {
                Swal.fire({
                    confirmButtonText: "Proceed",
                    showCancelButton: true,
                    html:
                        '<h4>Proceed to remove this row from the database?</h4>'
                }).then((result) => {
                        if (result.isConfirmed) {
                            $.ajax({
                                url:"admin_ajax.php?action=remove_post",
                                method: 'POST',
                                data: {post_id:post_id, report_id:report_id},
                                success:function(resp){
                                    console.log(resp)
                                    if(resp == 1){
                                        Swal.fire({
                                            position: 'top',
                                            icon: 'success',
                                            title: 'Successfully Removed',
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

            function showPostImage($id) {
                include '../db_connect.php';
                $post = $conn->query("SELECT p.post_id, CONCAT(u.user_first_name , ' ', u.user_last_name) as user_name from tbl_post p inner join tbl_user_account u on u.user_id = p.user_id where p.post_id = $id");
                while($row = $post->fetch_assoc()):
                    $p_id = $row['post_id'];
                    $name = $row['user_name'];
                endwhile;
                if(is_dir('../../user_functions/assets/uploads/'.$p_id)):
                    $gal = scandir('../../user_functions/assets/uploads/'.$p_id);
                    unset($gal[0]);
                    unset($gal[1]);
                    foreach($gal as $k => $v):
                        $mime = mime_content_type('../../user_functions/assets/uploads/'.$p_id.'/'.$v);
                        if(strstr($mime,'image')):
                            $img[] = '"../../user_functions/assets/uploads/'.$p_id.'/'.$v.'"';
                        else:
                            $vid[] = '"../../user_functions/assets/uploads/'.$p_id.'/'.$v.'" type="video/mp4"';
                        endif;
                    endforeach;
                endif;
                //var_dump($img);
                echo '
                    <script>
                        Swal.fire({
                            confirmButtonText: \'Close\',
                            html:
                                "<style>" +
                                    ".uploadContainer{" +
                                        "display: grid;" +
                                        "grid-template-columns: repeat(auto-fit	, minmax(220px, auto));" +
                                        "grid-gap: 10px;" +
                                    "}" +
                                "</style>" +
                                "<div>" +
                                    \'<h3 style="margin-bottom: 15px">'.$name.'</h3>\' +
                                    \'<div class="uploadContainer">\' +
                ';
                if(isset($img))
                {
                    foreach($img as $v):
                    echo '
                                    \'<img src='.strval($v).'  style="width:220px">\' +
                    ';
                    endforeach; 
                }
                if(isset($vid))
                {
                    foreach($vid as $v):
                    echo '
                                    \'<video controls width=220px>\' +
                                        \'<source src='.strval($v).'>\' +
                                    \'</video>\' +
                    ';
                    endforeach; 
                }
                if(!isset($img) && !isset($vid))
                {
                    echo '
                        \'<h3>No Multimedia Files...</h3>\' +
                    ';
                }
                echo '
                                    "</div>" +
                                "</div>",
                        }).then((result) => {
                            if (result.isConfirmed) {
                                location.href = "admin_newsfeed.php"
                            }
                        })
                    </script>
                ';
            }

            if (isset($_GET['post_id'])) {
                showPostImage($_GET['post_id']);
            }
        ?>
    </html>