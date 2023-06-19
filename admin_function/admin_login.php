<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
    <title>Admin_Panel</title>
    <link rel="stylesheet" href="assets/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Kaushan+Script&amp;display=swap">
    <link rel="stylesheet" href="assets/css/-Login-form-Page-BS4--Login-form-Page-BS4.css">
    <link rel="stylesheet" href="assets/css/untitled-1.css">
    <link rel="stylesheet" href="assets/css/untitled-2.css">
    <link rel="stylesheet" href="assets/css/untitled.css">
</head>

<body>
<?php
    session_start();
    if (isset($_POST['signin'])) {
        require 'myAdminFunc.php';
        $admin_email = $_POST['admin_email'];
        $trimmed_password = trim($_POST['admin_password']);
        $final_password = str_replace(' ', '', $trimmed_password);
        $myAdminFunc = new myAdminFunc();
        /*list($suc_fai, $err_sess) = $myAdminFunc->loginAdmin($admin_email, $final_password);
        if ($suc_fai) {
            if(isset($err_sess))
            {
                $_SESSION['logged_in_adm'] = true;
                foreach($err_sess as $key => $value)
                {
                    if($key=="admin_email")
                    {
                        $_SESSION['admin_email'] = strstr($row['admin_email'], '@', true);
                    }
                    if($key=="admin_profile_image")
                    {
                        $_SESSION['login_admin_profile_image'] = $value;    
                    }
                }
                header('Location: admin_dashboard/admin_dashboard.php');
            }
        } else {
            echo '
                    <script>
                        alert ("'. $err_sess .'");
                        window.location.href="admin_login.php";
                    </script>
                ';
        }*/
        if($myAdminFunc->checkIfUserExist($admin_email))
        {
            $hashed_password = $myAdminFunc->getData("password", $admin_email);
            if(password_verify($final_password, $hashed_password))
            {
                $type = $myAdminFunc->getData("type", $admin_email);
                $id = $myAdminFunc->getData("id", $admin_email);
                echo '
                    <script>
                        alert ("Welcome User");
                    </script>
                ';
                $_SESSION['logged_in_adm']= true;
                $_SESSION['user_id_adm']= $id;
                $data = $myAdminFunc->getAllData($admin_email);
                foreach($data as $key => $value)
                {
                    if(($key == 'admin_email' || $key == 'admin_profile_image') && !is_numeric($key))
                        if($key=="admin_email")
                        {
                            $_SESSION['login_'.$key] = strstr($value, '@', true);
                        }
                        else
                        {
                            $_SESSION['login_'.$key] = $value;    
                        }
                }
                header("location: admin_dashboard/admin_dashboard.php");
            }
            else
            {
                echo '
                    <script>
                        alert ("Wrong password");
                        window.location.href="admin_login.php";
                    </script>
                ';
            }
        }
        else
        {
            echo '
                <script>
                    alert ("Wrong email");
                    window.location.href="admin_login.php";
                </script>
            ';
        }
    }
?>
    <div class="container-fluid">
        <div class="row mh-100vh">
            <div class="col-10 col-sm-8 col-md-6 col-lg-6 offset-1 offset-sm-2 offset-md-3 offset-lg-0 align-self-center d-lg-flex align-items-lg-center align-self-lg-stretch bg-white p-5 rounded rounded-lg-0 my-5 my-lg-0" id="login-block">
                <div class="m-auto w-lg-75 w-xl-50"><img id="admin-logo-login" src="assets/img/shortcut-icon.png">
                    <h1 id="heading-one" style="font-family: 'Kaushan Script', serif;">Pic-Sell Planet</h1>
                    <form method="POST" enctype="multipart/form-data">
                        <div class="form-group mb-3"><label class="form-label text-secondary"><strong>Email</strong></label><input name="admin_email" class="form-control" type="text" required="" pattern="[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,15}$" inputmode="email"></div>
                        <div class="form-group mb-3"><label class="form-label text-secondary"><strong>Password</strong></label><input name="admin_password" class="form-control" type="password" required=""></div><button class="btn mt-2" type="submit" name="signin" style="background: rgb(254,209,54);"><strong>Log In</strong></button>
                    </form>
                    <p class="mt-3 mb-0"><a href="#" style="color: rgb(254,209,54);">Forgot your password?</a></p>
                    <p class="mt-3 mb-0"><a href="../index.php" style="color: rgb(254,209,54);">Go back to Home Page</a></p>
                </div>
            </div>
            <div class="col-lg-6 d-flex align-items-end" id="bg-block" style="background-image: url(&quot;assets/img/admin_bg.png&quot;);background-size: cover;background-position: center center;">
                <p class="ms-auto small text-dark mb-2"><em>Photo by&nbsp;</em><a class="text-dark" href="https://unsplash.com/photos/v0zVmWULYTg?utm_source=unsplash&amp;utm_medium=referral&amp;utm_content=creditCopyText" target="_blank"><em>Aldain Austria</em></a><br></p>
            </div>
        </div>
    </div>
    <script src="assets/bootstrap/js/bootstrap.min.js"></script>
</body>

</html>