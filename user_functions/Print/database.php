<?php
$con = mysqli_connect('localhost', 'root', '', 'picsellplanet_database');

if(mysqli_connect_error()){
  echo 'Failed'.mysqli_connect_error();
}
?>