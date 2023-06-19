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
    <link rel="stylesheet" href="css/style_admin.css">
    <link rel="stylesheet" href="css/style_notif.css">
    <link rel="shortcut icon" href="logo.png">
    <script type="text/javascript" src="js/notif.js"></script>
    <script src="https://kit.fontawesome.com/04bcc1e908.js" crossorigin="anonymous"></script>
    <title>Pic-Sell Planet: Admin</title>
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
            <div class="cards">
                <div class="card">
                    <div class="box">
                        <?php getTotalCustomer() ?>
                        <h3>Customers</h3>
                    </div>
                    <div class="icon-case">
                        <i class="fa-regular fa-user icon-head"></i>
                    </div>
                </div>
                <div class="card">
                    <div class="box">
                    <?php getTotalLensman() ?>
                        <h3>Lensman</h3>
                    </div>
                    <div class="icon-case">
                        <i class="fa-solid fa-user-tie icon-head"></i>
                    </div>
                </div>
                <div class="card">
                    <div class="box">
                    <?php getTotalPost() ?>
                        <h3>Posts</h3>
                    </div>
                    <div class="icon-case">
                        <i class="fa fa-home icon-head"></i>
                    </div>
                </div>
                <div class="card">
                    <div class="box">
                    <?php getTotalServices() ?>
                        <h3>Services</h3>
                    </div>
                    <div class="icon-case">
                        <i class="fa fa-camera icon-head"></i>
                    </div>
                </div>
                <div class="card">
                    <div class="box">
                    <?php getTotalProducts() ?>
                        <h3>Products</h3>
                    </div>
                    <div class="icon-case">
                        <i class="fa fa-store icon-head"></i>
                    </div>
                </div>
            </div>
            <div class="content-2">
                <div class="recent-payments">
                    <div class="title">
                        <h2>Recent Posts</h2>
                        <a href="#" class="btn">View All</a>
                    </div>
                    <?php
                    getAllDashPost();
                    ?>
                </div>
                <div class="new-customers">
                    <div class="title">
                        <h2>New Customers</h2>
                        <a href="#" class="btn">View All</a>
                    </div>
                    <?php
                    getAllDashCustomer();
                    ?>
                </div>
            </div>
        </div>
    </div>
    
</body>
<script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
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
                        location.href = "admin_dashboard.php"
                    }
                })
            </script>
        ';
    }

    if (isset($_GET['post_id'])) {
        showPostImage($_GET['post_id']);
    }

    function showCustomerInfo($id)
    {
        include '../db_connect.php';
        $user = $conn->query("SELECT * from tbl_user_account where user_id = $id");
        while($row = $user->fetch_assoc()):
            foreach($row as $k => $v)
            {
                if($row['user_type'] == "Customer")
                {
                    if(!in_array($k, array('user_tin', 'user_id_type', 'user_id_image', 'user_studio_name', 'user_cover_image', 'user_password', 'user_verification_code', 'user_verified')))
                    {
                        # 0 = user_id, 1 = user_name, 2 = user_email, 3 = user_type, 4 = user_address, 
                        # 5 = user_sex, 6 = user_birthday, 7 = user_contact, 8 = user_profile_image
                        $arr[] = $v;
                        $mwe = json_encode($arr);
                    }
                }
            }    
        endwhile;
        echo '
            <script>
                console.log('.$mwe.')
                console.log("mwe")
            </script>
        ';
        echo '
            <script>
                Swal.fire({
                    confirmButtonText: \'Close\',
                    html:
                        "<div>" +
                            \'<img src="../../'.$arr[11].'"  style="width:200px; height:200px; border: 2px solid black;border-radius: 50%; object-fit: cover;">\' +
                            \'<h3 style="margin-bottom: 15px">' . $arr[1] . '</h3>\' +
                            \'<h4 style="margin-bottom: 15px">'. $arr[2] . ', ' . $arr[3] . ' ' . $arr[4].'</h4>\' +
                            \'<h4 style="margin-bottom: 15px">'.$arr[5].'</h4>\' +
                            \'<h4 style="margin-bottom: 15px">'.$arr[6].'</h4>\' +
                            \'<h4 style="margin-bottom: 15px">'.$arr[7].'</h4>\' +
                        "</div>",
                }).then((result) => {
                    if (result.isConfirmed) {
                        location.href = "admin_dashboard.php"
                    }
                })
            </script>
        ';
    }

    if (isset($_GET['user_id']))
    {
        showCustomerInfo($_GET['user_id']);
    }
?>
</html>