<?php
    require ("../connection.php");
    session_start();

    if(isset($_GET['email']) && isset($_GET['v_code']))
    {
        
        //$query = "SELECT * FROM `tbl_lensmen_user` WHERE `email`= '$_GET[email]' AND `verification_code` = '$_GET[v_code]'";
        $query = "SELECT * FROM `tbl_user_account` WHERE `user_email`= '$_GET[email]' AND `user_verification_code` = '$_GET[v_code]'";
        $result = mysqli_query($con, $query);
        if($result)
        {
            if(mysqli_num_rows($result) == 1)
            {
                $result_fetch = mysqli_fetch_assoc($result);
                if($result_fetch['user_verified'] == 0)
                {
                    //$update = "UPDATE `tbl_lensmen_user` SET `is_verified` = '1' WHERE `email` = '$result_fetch[email]'";
                    $update = "UPDATE `tbl_user_account` SET `user_verified` = '1' WHERE `user_email` = '$result_fetch[user_email]'";
                    if(mysqli_query($con, $update))
                    {
                        $_SESSION['alert_session_lg']=true;
                        $_SESSION['alert_text_lg']="Email Verification Successful";
                        $_SESSION['result_lg']=true;
                        header("location: ../login.php");
                    }
                    else
                    {
                        $_SESSION['alert_session_lg']=true;
                        $_SESSION['alert_text_lg']="Something Went Wrong with Email Verification";
                        $_SESSION['result_lg']=false;
                        header("location: ../login.php");
                    }
                }
                else
                {
                    $_SESSION['alert_session_lg']=true;
                    $_SESSION['alert_text_lg']="This Account is Already Verified";
                    $_SESSION['result_lg']=false;
                    header("location: ../login.php");
                }
            }
        }
        else
        {
            $_SESSION['alert_session_lg']=true;
            $_SESSION['alert_text_lg']="Something Went Wrong with Email Verification";
            $_SESSION['result_lg']=false;
            header("location: ../login.php");
        }
    }

    