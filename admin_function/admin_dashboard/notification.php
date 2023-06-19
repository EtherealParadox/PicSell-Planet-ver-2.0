    <?php
        include '../db_connect.php';
        $notif_num_total = $conn->query("SELECT * FROM `tbl_notification` WHERE `notification_receiver` = 'Admin' ")->num_rows;
        $notif_unread_num = $conn->query("SELECT * FROM `tbl_notification` WHERE `notification_status` = 0 AND `notification_receiver` = 'Admin' ")->num_rows;
        ($notif_unread_num==0) ? $notif_unread_num = '' : $notif_unread_num = $notif_unread_num;
    ?>
    
    <div class="dropdown-notif">
        <button onclick="showNotif()" class="dropbtn-notif fa-solid fa-bell"><sup style="font-size: 20px;"><?php echo $notif_unread_num ?></sup></button>
        <div id="myDropdown-notif" class="dropdown-content-notif">
        <?php  
            if($notif_num_total!=0):
            $notif = $conn->query("SELECT * FROM tbl_notification WHERE notification_receiver = 'Admin' ORDER BY notification_date DESC LIMIT 30");
            while($n_row=$notif->fetch_assoc()):
        
            ($n_row['notification_status'] == 1) ? $notif_class = "" : $notif_class = " unread-notif";
            $datetime = date('F d, Y (h:i A)', strtotime($n_row['notification_date']));

            if(!is_null($n_row['post_reported']))
            {
            $post_id_notif = $n_row['post_reported'];
            $report_details = $conn->query("SELECT r.post_id, r.report_reason, CONCAT(u.user_first_name , ' ' , u.user_last_name) AS notification_sender FROM tbl_reports r LEFT JOIN tbl_user_account u ON r.user_id = u.user_id  WHERE r.report_id = '$post_id_notif' ");
            while($r_row=$report_details->fetch_assoc())
            {
                $reported_post_id = $r_row['post_id'];
                $reason_notif = $r_row['report_reason'];
                $sender_name = $r_row['notification_sender'];
            }
            $post_details = $conn->query("SELECT CONCAT(u.user_first_name , ' ' , u.user_last_name) AS reported_user FROM tbl_post p LEFT JOIN tbl_user_account u ON p.user_id = u.user_id  WHERE p.post_id = '$reported_post_id' ");
            while($p_row=$post_details->fetch_assoc())
            {
                $reported_name = $p_row['reported_user'];
            }
        ?>
            <div class="card-notif<?php echo $notif_class ?>">
                <div style="width: 80px; margin: auto;">
                    <img src="../assets/img/reported-logo.png" style="width: 50px; height: 50px; margin-left: 10px;  margin-right: 20px;" alt="">
                </div>
                <div style="width: 350px;">
                    <h6><?php echo $datetime ?></h6>
                    <p><?php echo $sender_name .' reported ' . $reported_name . '\'s post due to reason of "' . $reason_notif . '"'?></p>
                    <a  class="notif-btn" onclick="location.href='admin_newsfeed.php?reports';">Go</a>
                </div>
            </div>
        <?php
        //
            }
            endwhile;
            else:
        ?>
            <div class="card-notif">
                <div class="no-notif"  style="margin: auto; padding: 10px; color: gray;">
                    <h4>No Notifications Yet...</h4>
                </div>
            </div>
        <?php
            endif;
            
        ?>
        </div>
    </div>