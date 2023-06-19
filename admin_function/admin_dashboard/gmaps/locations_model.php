<?php
require("db.php");

// Gets data from URL parameters.
if(isset($_GET['add_location'])) {
    add_location();
}
if(isset($_GET['confirm_location'])) {
    confirm_location();
}

if(isset($_GET['update_location'])) {
    update_location();
}



function add_location(){
    $con=mysqli_connect ("localhost", 'root', '','picsellplanet_database');
    if (!$con) {
        die('Not connected : ' . mysqli_connect_error());
    }
    $lat = $_GET['lat'];
    $lng = $_GET['lng'];
    $description =$_GET['description'];
    // Inserts new row with place data.
    $query = sprintf("INSERT INTO locations "
        . " (lat, lng, description) "
        . " VALUES ('%s', '%s', '%s');",
        mysqli_real_escape_string($con,$lat),
        mysqli_real_escape_string($con,$lng),
        mysqli_real_escape_string($con,$description));

    $result = mysqli_query($con,$query);
    echo"Inserted Successfully";
    if (!$result) {
        die('Invalid query: ' . mysqli_error($con));
    }
}
function confirm_location(){
    $con=mysqli_connect ("localhost", 'root', '','picsellplanet_database');
    if (!$con) {
        die('Not connected : ' . mysqli_connect_error());
    }
    $id =$_GET['id'];
    $confirmed =$_GET['confirmed'];
    // update location with confirm if admin confirm.
    $query = "update locations set location_status = $confirmed WHERE id = $id ";
    $result = mysqli_query($con,$query);
    echo "Inserted Successfully";
    if (!$result) {
        die('Invalid query: ' . mysqli_error($con));
    }
}
function update_location(){
    $con=mysqli_connect ("localhost", 'root', '','picsellplanet_database');
    if (!$con) {
        die('Not connected : ' . mysqli_connect_error());
    }
    $loc_id =$_GET['loc_id'];
    $user_id =$_GET['user_id'];
    // update location with confirm if admin confirm.
    $query = "update tbl_map_location set location_status = 1 WHERE location_id = $loc_id AND user_id = $user_id ";
    $result = mysqli_query($con,$query);
    echo "Updated Successfully";
    if (!$result) {
        die('Invalid query: ' . mysqli_error($con));
    }
}
function get_confirmed_locations(){
    $con=mysqli_connect ("localhost", 'root', '','picsellplanet_database');
    if (!$con) {
        die('Not connected : ' . mysqli_connect_error());
    }
    // update location with location_status if admin location_status.
    $sqldata = mysqli_query($con,"
select id ,lat,lng,description,location_status as isconfirmed
from locations WHERE  location_status = 1
  ");

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
