    <?php
    require("db.php");

    function get_all_locations(){
        $connection=mysqli_connect ("localhost", 'root', '','picsellplanet_database');
        if (!$connection) {
            die('Not connected : ' . mysqli_connect_error());
        }
        // update location with location_status if admin location_status.
        /*$sqldata = mysqli_query($connection,"
            select id ,lat,lng,description,location_status as isconfirmed
            from locations
        ");*/
        $sqldata = mysqli_query($connection,"SELECT `user_first_name`, `user_last_name`, `user_lat`, `user_lng`, `user_studio_name` FROM tbl_user_account WHERE user_type = 'Lensman' AND user_archive_status = 1 AND user_verified = 1");

        $rows = array();
        while($r = mysqli_fetch_assoc($sqldata)) {
            $rows[] = $r;

        }
        $indexed = array_map('array_values', $rows);
    //  $array = array_filter($indexed);

        echo json_encode($indexed);
        if (!$rows) {
            return null;
        }
    }

    ?>
