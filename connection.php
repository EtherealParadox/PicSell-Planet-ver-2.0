<?php

    $con = mysqli_connect("localhost", "root", "", "picsellplanet_database");
    
    if (mysqli_connect_error()) {
        echo "<script>alert('Cannot connect to the database');</script>";
        exit();
    }