<?php
    function fook($v1, $v2)
    {
        require "db.php";

        $rows = array();

        $near_loca = $connection->query("SELECT user_first_name, user_last_name, user_lat, user_lng, user_studio_name, ( 3959 * acos( cos( radians($v1) ) * cos( radians( `user_lat` ) ) * cos ( radians ( `user_lng` ) - radians($v2) ) + sin( radians($v1) ) * sin( radians( `user_lat` ) ) ) ) AS Distance FROM `tbl_user_account` HAVING Distance < 74 ORDER BY Distance LIMIT 0 , 20");
        while($n_row=$near_loca->fetch_assoc())
        {
            //echo $n_row['user_first_name'] . ' ' .$n_row['Distance'] . '';
            
                $rows[] = $n_row;
            
        }
        $indexed = array_map('array_values', $rows);
        echo json_encode($indexed);
    }