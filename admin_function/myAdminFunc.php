<?php

class myAdminFunc
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
    public function loginAdmin($admin_email, $admin_password)
    {
        $admin_email = mysqli_real_escape_string($this->link, $admin_email);
        $admin_password = mysqli_real_escape_string($this->link, $admin_password);

        $query = "SELECT * FROM `tbl_admin_account` WHERE `admin_email` = '$admin_email' ";
        $result = mysqli_query($this->link, $query);
        if($result)
        {
            if(mysqli_num_rows($result)==1)
            {
                $result_fetch = mysqli_fetch_assoc($result);                 
                if(password_verify($admin_password, $result_fetch['admin_password']))
                {
                        $records[] =
                        [
                            'admin_id' => $result_fetch['admin_id'],
                            'admin_name' => $result_fetch['admin_name'],
                            'admin_email' => $result_fetch['admin_email'],
                            'admin_type' => $result_fetch['admin_type'],
                            'admin_profile_image' => $result_fetch['admin_profile_image'],
                        ];
                    return array(true, $records);
                }
                else
                {
                    return array(false, "You've entered a wrong password");
                }
            }
            else
            {
                return array(false, "Email Not Registered");  
            }
        }
        else
        {
            return array(false, "Cannot Run Query");
        }
    }

    public function checkIfUserExist($email)
    {
        $user_exist_query = "SELECT * FROM `tbl_admin_account` WHERE `admin_email` = '$email' ";
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

    public function getData($data_type, $email)
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

    public function getAllData($email)
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
}