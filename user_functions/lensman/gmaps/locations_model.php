    <?php
    require 'db.php';

    // Gets data from URL parameters.
    if(isset($_GET['add_location'])) {
        add_location();
    }
    if(isset($_GET['delete_location'])) {
        delete_location();
    }
    if(isset($_GET['confirm_location'])) {
        confirm_location();
    }





    function add_location(){
        /*require 'myLocation.php';
        $myLocation = new myLocation();*/
        $connection=mysqli_connect ("localhost", 'root', '','picsellplanet_database');
        if (!$connection) {
            die('Not connected : ' . mysqli_connect_error());
        }
        $lat = $_GET['lat'];
        $lng = $_GET['lng'];
        $desc = $_GET['desc'];
        $user = $_GET['user'];
        
        // Inserts new row with place data.
        $query = sprintf("INSERT INTO tbl_map_location "
            . " (`location_description`, `location_lat`, `location_long`, `user_id`, `location_status`) "
            . " VALUES ('%s', '%s', '%s', '%s', '%s');",
            mysqli_real_escape_string($connection,$desc),
            mysqli_real_escape_string($connection,$lat),
            mysqli_real_escape_string($connection,$lng),
            mysqli_real_escape_string($connection,$user),
            mysqli_real_escape_string($connection,"0"));

        $result = mysqli_query($connection,$query);
        echo"Inserted Successfully";
        if (!$result) {
            die('Invalid query: ' . mysqli_error($connection));
        }
        else 
        {
            return 1;
        }
        /*$add_loc = $myLocation->add_location($lat, $lng, $user);
        if ($add_loc) {
            echo "Inserted Successfully";
        }
        else{
            echo "Inserting failed";
        }*/
    }
    function delete_location(){
        $connection=mysqli_connect ("localhost", 'root', '','picsellplanet_database');
        if (!$connection) {
            die('Not connected : ' . mysqli_connect_error());
        }

        $loc_id = $_GET['loc_id'];
        
        // Inserts new row with place data.
        $query = "DELETE FROM `tbl_map_location` WHERE location_id = $loc_id";

        $result = mysqli_query($connection,$query);
        echo"Inserted Successfully";
        if (!$result) {
            die('Invalid query: ' . mysqli_error($connection));
        }
        else 
        {
            return 1;
        }
    }
    function confirm_location(){
        $connection=mysqli_connect ("localhost", 'root', '','picsellplanet_database');
        if (!$connection) {
            die('Not connected : ' . mysqli_connect_error());
        }
        $id =$_GET['id'];
        $connectionfirmed =$_GET['confirmed'];
        // update location with confirm if admin confirm.
        $query = "update locations set location_status = $connectionfirmed WHERE id = $id ";
        $result = mysqli_query($connection,$query);
        echo "Inserted Successfully";
        if (!$result) {
            die('Invalid query: ' . mysqli_error($connection));
        }
    }
    function get_confirmed_locations(){
        $connection=mysqli_connect ("localhost", 'root', '','picsellplanet_database');
        if (!$connection) {
            die('Not connected : ' . mysqli_connect_error());
        }
        // update location with location_status if admin location_status.
        $sqldata = mysqli_query($connection,"select id ,lat,lng,description,location_status as isconfirmed from locations WHERE  location_status = 1 ");

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
        $sqldata = mysqli_query($connection,"SELECT l.location_id, l.location_description, l.location_lat, l.location_long, l.location_status, l.user_id, u.user_name, u.user_studio_name as item FROM tbl_map_location l inner join tbl_user_account u on l.user_id = u.user_id");

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
    function array_flatten($array) {
        if (!is_array($array)) {
            return FALSE;
        }
        $result = array();
        foreach ($array as $key => $value) {
            if (is_array($value)) {
                $result = array_merge($result, array_flatten($value));
            }
            else {
                $result[$key] = $value;
            }
        }
        return $result;
    }

    ?>
