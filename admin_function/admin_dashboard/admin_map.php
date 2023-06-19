    <?php
        session_start();
        require 'adminContent.php';

        if (!isset($_SESSION['login_admin_email']) && $_SESSION['logged_in_adm'] != true) {
            header("location: ../admin_login.php");
        }
    ?>

    <!DOCTYPE html>
    <html lang="en">

    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href="css/style_admin_pages.css">
        <link rel="shortcut icon" href="logo.png">
        <script src="https://kit.fontawesome.com/04bcc1e908.js" 
        crossorigin="anonymous"></script>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>

        <title>Pic-Sell Planet: Admin</title>
    </head>
    <style>
        .body-container{
            height: 750px;
            margin: 10px;
            padding: 0;
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
                <li><a href="admin_map.php"><i class="fa fa-map"></i> <span>2D Mapping</span></a></li>
                <li><a href="admin_accounts.php"><i class="fa fa-user"></i> <span>Accounts</span></a></li>
            </ul>
        </div>
        <div class="container">
        <div class="header">
            <div class="nav">
                <div class="user">
                    <div class="img-case">
                        <img src="<?php echo $_SESSION['login_admin_profile_image'] ?>" alt="">
                    </div>
                    <span class="user-name"><?php echo $_SESSION['login_admin_email'] ?></span>
                    <span class="user-name">/</span>
                    <a href="../logout.php"><span class="admin-logout">Logout</span></a>
                </div>
            </div>
        </div>
        <div class="content">
            <div class="content-2">
                    <div class="recent-payments">
                        <div class="title">
                            <h2>2D Mapping</h2>
                        </div>
                        <div class="body-container">
                        <?php
                        include 'gmaps/admin-map.php';
                        ?>
                        </div>
                    </div>
                </div>
                </div>
        </div>
    </body>
    </html>