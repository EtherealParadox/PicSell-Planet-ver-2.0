<?php
session_start();
ini_set('display_errors', 1);
Class myLocation {
    private $db;

    public function __construct() {
        ob_start();
    include '../db_connect.php';
    
    $this->db = $conn;
    }
    function __destruct() {
        $this->db->close();
        ob_end_flush();
    }

    function add_location($lat, $lng, $user)
    {
        $studio_name = $this->db->query("SELECT `user_studio_name` FROM tbl_user_account WHERE `user_id` = '$user'")->fetch_assoc();
        $studio_name = $studio_name['user_studio_name'];
        $data = "";
        $data .= " location_studio_name='$studio_name' ";
        $data .= ", location_lat='$lat' ";
        $data .= ", location_long='$lng' ";
        $data .= ", user_id='$user' ";
        $data .= ", location_status=0 ";

        $save = $this->db->query("INSERT INTO tbl_map_location set $data");
		if($save)
		{
			return 1;
		}
    }
}