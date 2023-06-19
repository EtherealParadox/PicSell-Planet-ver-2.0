<?php

    session_start();

    if(isset($_POST['login']))
    {
        require_once 'myLogin.php';
        $myLogin = new myLogin();

        $email = $_POST['email'];
        $password = $_POST['password'];

        if($myLogin->checkIfUserIsAdmin("email", $email))
        {
            $hashed_password = $myLogin->getAdminData("password", $email);
            if(password_verify($password, $hashed_password))
            {
                $type = $myLogin->getAdminData("type", $email);
                $id = $myLogin->getAdminData("id", $email);

                $_SESSION['logged_in_adm']= true;
                $_SESSION['user_id_adm']= $id;
                $data = $myLogin->getAllAdminData($email);
                foreach($data as $key => $value)
                {
                    if($key != 'admin_password' && !is_numeric($key))
                    {
                        $_SESSION['login_'.$key] = $value;   
                    }
                }
                header("location: ../admin_function/admin_dashboard/admin_dashboard.php");
            }
            else
            {
                header("location: ../login.php");
            }
        }
        else
        {
            if($myLogin->checkIfUserExist("email", $email))
            {
                if($myLogin->checkIfUserVerified($email))
                {
                    $hashed_password = $myLogin->getData("password", $email);
                    if(password_verify($password, $hashed_password))
                    {
                        $type = $myLogin->getData("type", $email);
                        $id = $myLogin->getData("id", $email);
                        $myLogin->updateActiveStatus($email);
                        if($type === "Lensman")
                        {
                            $_SESSION['logged_in_lm']= true;
                            $_SESSION['user_id_lm']= $id;
                            $data = $myLogin->getAllData($email);
                            foreach($data as $key => $value)
                            {
                                if($key != 'user_password' && !is_numeric($key))
                                    $_SESSION['login_'.$key] = $value;
                            }
                            header("location: ../user_functions/lensman/lensman_dashboard.php?page=home");
                        }
                        if($type === "Customer")
                        {
                            $_SESSION['logged_in_cm']= true;
                            $_SESSION['user_id_cm']= $id;
                            $data = $myLogin->getAllData($email);
                            foreach($data as $key => $value)
                            {
                                if($key != 'user_password' && !is_numeric($key))
                                    $_SESSION['login_'.$key] = $value;
                            }
                            header("location: ../user_functions/customer/customer_dashboard.php?page=home");
                        }
                    }
                    else
                    {
                        $_SESSION['alert_session_lg']=true;
                        $_SESSION['alert_text_lg']="Wrong password";
                        $_SESSION['result_lg']=false;
                        $_SESSION['relogin_email']=$email;
                        header("location: ../login.php");
                    }
                }
                else
                {
                    $_SESSION['alert_session_lg']=true;
                    $_SESSION['alert_text_lg']="User is not verified";
                    $_SESSION['result_lg']=false;
                    $_SESSION['relogin_email']=$email;
                    header("location: ../login.php");
                }
            }
            else
            {
                $_SESSION['alert_session_lg']=true;
                $_SESSION['alert_text_lg']="User is not registered";
                $_SESSION['result_lg']=false;
                $_SESSION['relogin_email']=$email;
                header("location: ../login.php");
            }
        }
        
    }