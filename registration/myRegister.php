<?php

class myRegister
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

    public function checkIfDataExist($data_type, $data)
    {
        $dt = 'user_'.$data_type;
        $user_exist_query = "SELECT * FROM `tbl_user_account` WHERE `$dt` = '$data' ";
        $result = mysqli_query($this->link, $user_exist_query);
        if($result)
        {
            if(mysqli_num_rows($result)>0)
            {
                $result_fetch = mysqli_fetch_assoc($result);
                if($result_fetch[$dt] == $data)
                {
                    #error if the data already exist
                    return true;
                }
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

    public function insertLensmanData($user_type, $lastname , $firstname, $middlename, $nickname,
    $email, $address, $birthday, $user_sex, $studio_name, $id_file, $permit_file, $tin,
    $contact_num, $pfp_file, $hashed_password, $lat, $lng, $v_code)
    {
        $user_type = mysqli_real_escape_string($this->link, $user_type);
        $lastname = mysqli_real_escape_string($this->link, $lastname);
        $firstname = mysqli_real_escape_string($this->link, $firstname);
        $middlename = mysqli_real_escape_string($this->link, $middlename);
        $nickname = mysqli_real_escape_string($this->link, $nickname);
        $email = mysqli_real_escape_string($this->link, $email);
        $address = mysqli_real_escape_string($this->link, $address);
        $birthday = mysqli_real_escape_string($this->link, $birthday);
        $user_sex = mysqli_real_escape_string($this->link, $user_sex);
        $studio_name = mysqli_real_escape_string($this->link, $studio_name);
        $id_file = mysqli_real_escape_string($this->link, $id_file);
        $permit_file = mysqli_real_escape_string($this->link, $permit_file);
        $tin = mysqli_real_escape_string($this->link, $tin);
        $contact_num = mysqli_real_escape_string($this->link, $contact_num);
        $pfp_file = mysqli_real_escape_string($this->link, $pfp_file);
        $hashed_password = mysqli_real_escape_string($this->link, $hashed_password);
        $lat = mysqli_real_escape_string($this->link, $lat);
        $lng = mysqli_real_escape_string($this->link, $lng);
        $v_code = mysqli_real_escape_string($this->link, $v_code);


        /*$qstr = "INSERT INTO `tbl_user_account`(`user_type`, `user_last_name`, `user_first_name`, `user_middle_name`, 
        `user_nickname`, `user_email`, `user_address`, `user_birthday`, `user_sex`, `user_studio_name`, `user_id_image`, 
        `user_permit_image`, `user_tin`, `user_contact`, `user_profile_image`, `user_password`, `user_lat`, 
        `user_lng`, `user_archive_status`) 
        VALUES ('$user_type', '$lastname', '$firstname', '$middlename', '$nickname', '$email', '$address', '$birthday', 
        '$user_sex', '$studio_name', '$id_file', '$permit_file', '$tin', '$contact_num', '$pfp_file' ,'$hashed_password',
        '$lat', '$lng', '0')";*/
        $data = "user_type='$user_type', user_last_name='$lastname', user_first_name='$firstname', user_middle_name='$middlename',
        user_nickname='$nickname', user_email='$email', user_address='$address', user_birthday='$birthday', user_sex='$user_sex', 
        user_studio_name='$studio_name', user_id_image='$id_file', user_permit_image='$permit_file', user_tin='$tin', 
        user_contact='$contact_num', user_profile_image='$pfp_file', user_password='$hashed_password', user_lat='$lat', 
        user_lng='$lng', user_verification_code='$v_code'";
        
        $qstr = "INSERT INTO tbl_user_account set $data ";
        return mysqli_query($this->link, $qstr);
    }

    public function insertCustomerData($user_type, $lastname , $firstname, $middlename, $nickname,
    $email, $address, $birthday, $user_sex, $contact_num, $pfp_file, $hashed_password, $v_code)
    {
        $user_type = mysqli_real_escape_string($this->link, $user_type);
        $lastname = mysqli_real_escape_string($this->link, $lastname);
        $firstname = mysqli_real_escape_string($this->link, $firstname);
        $middlename = mysqli_real_escape_string($this->link, $middlename);
        $nickname = mysqli_real_escape_string($this->link, $nickname);
        $email = mysqli_real_escape_string($this->link, $email);
        $address = mysqli_real_escape_string($this->link, $address);
        $user_sex = mysqli_real_escape_string($this->link, $user_sex);
        $birthday = mysqli_real_escape_string($this->link, $birthday);
        $email = mysqli_real_escape_string($this->link, $email);
        $address = mysqli_real_escape_string($this->link, $address);
        $birthday = mysqli_real_escape_string($this->link, $birthday);
        $user_sex = mysqli_real_escape_string($this->link, $user_sex);
        $contact_num = mysqli_real_escape_string($this->link, $contact_num);
        $pfp_file = mysqli_real_escape_string($this->link, $pfp_file);
        $hashed_password = mysqli_real_escape_string($this->link, $hashed_password);
        $v_code = mysqli_real_escape_string($this->link, $v_code);

        $qstr = "INSERT INTO `tbl_user_account`(`user_type`, `user_last_name`, `user_first_name`, `user_middle_name`, 
        `user_nickname`, `user_email`, `user_address`, `user_birthday`, `user_sex`, `user_studio_name`, `user_id_image`, 
        `user_permit_image`, `user_tin`, `user_contact`, `user_profile_image`, `user_password`, `user_lat`, 
        `user_lng`, `user_verification_code`,`user_archive_status`) 
        VALUES ('$user_type', '$lastname', '$firstname', '$middlename', '$nickname', '$email', '$address', '$birthday', 
        '$user_sex', NULL, NULL, NULL, NULL, '$contact_num', '$pfp_file' , '$hashed_password',
        NULL, NULL, '$v_code', '1')";
        return mysqli_query($this->link, $qstr);
    }
}