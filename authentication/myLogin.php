<?php

class myLogin
{
    private $host;
    private $username;
    private $password;
    private $database;
    private $link;

    function __construct()
    {
        $this->host = "localhost";
        $this->username = "root";
        $this->password = "";
        $this->database = "picsellplanet_database";

        $this->link = mysqli_connect(
            $this->host,
            $this->username,
            $this->password,
            $this->database
        );
        if (mysqli_connect_errno()) {
            $log = "MySQL Error: " . mysqli_connect_error();
            exit($log);
        }
    }

    function __destruct()
    {
        if (isset($this->link)) {
            mysqli_close($this->link);
        }
    }

    public function checkIfUserIsAdmin($data_type, $email)
    {
        $dt = 'admin_'.$data_type;
        $user_exist_query = "SELECT * FROM `tbl_admin_account` WHERE `$dt` = '$email' ";
        $result = mysqli_query($this->link, $user_exist_query);
        if($result)
        {
            if(mysqli_num_rows($result)==1)
            {
                return true;
            }
            else
            {
                return false;
            }
        }
        else
        {
            return "Something went wrong, Please try again";
        }
    }

    public function getAdminData($data_type, $email)
    {
        $dt = 'admin_'.$data_type;
        $query = "SELECT * FROM `tbl_admin_account` WHERE `admin_email` = '$email' ";
        $result = mysqli_query($this->link, $query);
        if($result)
        {
            $result_fetch = mysqli_fetch_assoc($result);
            return $result_fetch[$dt];
        }
        else
        {
            return "Something went wrong, Please try again";
        }
    }

    public function getAllAdminData($email)
    {
        $query = "SELECT * FROM `tbl_admin_account` WHERE `admin_email` = '$email' ";
        $result = mysqli_query($this->link, $query);
        if($result)
        {
            $result_fetch = mysqli_fetch_assoc($result);
            return $result_fetch;
        }
        else
        {
            return "Something went wrong, Please try again";
        }
    }

    public function checkIfUserExist($data_type, $email)
    {
        $dt = 'user_'.$data_type;
        $user_exist_query = "SELECT * FROM `tbl_user_account` WHERE `$dt` = '$email' ";
        $result = mysqli_query($this->link, $user_exist_query);
        if($result)
        {
            if(mysqli_num_rows($result)==1)
            {
                return true;
            }
            else
            {
                return false;
            }
        }
        else
        {
            return "Something went wrong, Please try again";
        }
    }

    public function checkIfUserVerified($email)
    {
        $query = "SELECT * FROM `tbl_user_account` WHERE `user_email` = '$email' ";
        $result = mysqli_query($this->link, $query);
        if($result)
        {
            $result_fetch = mysqli_fetch_assoc($result);
            if($result_fetch['user_verified'] == 1)
            {
                return true;
            }
            else
            {
                return false;
            }
        }
        else
        {
            return "Something went wrong, Please try again";
        }
    }

    public function getData($data_type, $email)
    {
        $dt = 'user_'.$data_type;
        $query = "SELECT * FROM `tbl_user_account` WHERE `user_email` = '$email' ";
        $result = mysqli_query($this->link, $query);
        if($result)
        {
            $result_fetch = mysqli_fetch_assoc($result);
            return $result_fetch[$dt];
        }
        else
        {
            return "Something went wrong, Please try again";
        }
    }

    public function getAllData($email)
    {
        $query = "SELECT * FROM `tbl_user_account` WHERE `user_email` = '$email' ";
        $result = mysqli_query($this->link, $query);
        if($result)
        {
            $result_fetch = mysqli_fetch_assoc($result);
            return $result_fetch;
        }
        else
        {
            return "Something went wrong, Please try again";
        }
    }

    public function updateActiveStatus($email)
    {
        $query = "UPDATE `tbl_user_account` SET user_active_status = 1 WHERE `user_email` = '$email' ";
        $result = mysqli_query($this->link, $query);
    }
}