<?php
    session_start();

    if(isset($_SESSION['user_id_lm']) && $_SESSION['logged_in_lm'] == true)
    {
        session_destroy();
        header("location: ../login.php");
    }
    else if(isset($_SESSION['user_id_cm']) && $_SESSION['logged_in_cm'] == true)
    {
        session_destroy();
        header("location: ../login.php");
    }
    else{
        header("location: ../login.php");
    }