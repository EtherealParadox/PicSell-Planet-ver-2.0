<?php

class myCustomer
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

    public function getCustomerData($id)
    {
        /*$query = "SELECT * FROM `tbl_user_account` WHERE `user_id` = '$id' ";
        $result = mysqli_query($this->link, $query);
        $records = array();

        if (mysqli_num_rows($result) > 0) {
            while ($row = mysqli_fetch_assoc($result)) {
                $records[] =
                    [
                        'user_id' => $row['user_id'],
                        'user_name' => $row['user_name'],
                        'user_email' => $row['user_email'],
                        'user_type' => $row['user_type'],
                        'user_address' => $row['user_address'],
                        'user_birthday' => $row['user_birthday'],
                        'user_contact' => $row['user_contact'],
                        'user_id_type' => $row['post_date'],
                        'user_id_image' => $row['user_id_image'],
                        'user_business_license_image' => $row['user_business_license_image'],
                        'user_profile_image' => $row['user_profile_image'],
                    ];
            }
        } else {
            $records = null;
        }
        mysqli_free_result($result);
        return $records;*/
        $query = "SELECT * FROM `tbl_user_account` WHERE `user_id`='$id' ";
        $result = mysqli_query($this->link, $query);
        if (mysqli_num_rows($result) > 0) {
            $row = mysqli_fetch_assoc($result);
        } else {
            $row = null;
        }
        return $row;
    }
}