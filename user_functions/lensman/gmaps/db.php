<?php


$conn = new mysqli('localhost','root','','picsellplanet_database') or die("Could not connect to mysql".mysqli_error($con));

/*// Opens a connection to a MySQL server.
$connection=mysqli_connect ("localhost", 'root', '','picsellplanet_database');
if (!$connection) {
    die('Not connected : ' . mysqli_connect_error());
}*/

// Sets the active MySQL database.
/*$db_selected = mysqli_select_db($connection,'accounts');
if (!$db_selected) {
    die ('Can\'t use db : ' . mysqli_error($connection));
}*/