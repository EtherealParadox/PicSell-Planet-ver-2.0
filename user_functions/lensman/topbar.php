    <!-- Navbar -->
    <script src="https://kit.fontawesome.com/67415cff19.js" crossorigin="anonymous"></script>
    <style>
        

        nav{
            background-color: #114481;
        }

        .dropdown {
				margin-top: auto;
				margin-bottom: auto;
				position: relative;
				display: inline-block; 
                margin-right: 10px;
                outline: none;
                border: 0;
			}

            .dropbtn {
                margin-top: 4px;
				color: #fed136;
                background: none;
				padding: 7px;
				font-size: 30px;
				border: 0;
				border-radius: 5%;
				cursor: pointer;
                width: 50px;
                font-family: "Font Awesome 6 Free" !important; 
			}
            
			
			.dropdown-content {
				right: 0;
				display: none;
				width: 450px;
                max-height: 300px;
                overflow-y: auto;
				position: absolute;
				background-color: #f9f9f9;
				box-shadow: 0px 8px 16px 0px rgba(0,0,0,0.2);
				z-index: 1;
                border-radius: 5px;
			}

			.dropdown-content a {
				color: black;
                font-size: 15px;
				padding: 5px;
				text-decoration: none;
				display: block;
				text-align: center;
				font-weight: 650;
			}
            
			.dropdown-content a:hover {
                background-color: #114481;  
                color: #fed136;
                cursor: pointer;
            }

            .show {display: block;}

            .card-notif{
                display: flex;
                flex-direction: row;
                padding: 10px;
                box-shadow: rgba(60, 64, 67, 0.3) 0px 1px 2px 0px, rgba(60, 64, 67, 0.15) 0px 1px 3px 1px;
                border-radius: 2%;
            }

            .card-notif h6{
                color: gray;
            }

            .card-notif p{
                word-wrap: break-word;
                margin-bottom: 5px;
            }

            .unread {
                background-color: rgb(211,211,211) !important;
                border-bottom: 3px solid #f1f1f1 !important;
            }
    </style>
    <nav class="main-header navbar navbar-expand py-2">
        <!-- Left navbar links -->
        <div class="container-fluid ml-5 mr-5">
        <ul class="navbar-nav">
            <?php //if(isset($_SESSION['login_user_id'])): ?>
            <li class="nav-item ">
            <div class="d-flex position-relative">
                <img src="../assets/icons/logo.png" style="width:100px;">
                </img>
                <h3 style="margin: 19px 0 0 5px; color:#fed136; font-family:'Trebuchet MS', 'Lucida Sans Unicode', 'Lucida Grande', 'Lucida Sans', Arial, sans-serif">Pic-Sell Planet</h3>
            </div>
            </li>
        <?php //endif; ?>
            <li>
            <!-- <a class="nav-link text-white"  href="./" role="button"> <large><b>Facebook</b></large></a> -->
            </li>
        </ul>

        <ul class="navbar-nav ml-auto">
            
                
            <li>
            <?php
                    include '../db_connect.php';
                    $notif_num_total = $conn->query("SELECT * FROM `tbl_notification` WHERE `notification_receiver` = {$_SESSION['login_user_id']} ")->num_rows;
                    $notif_unread_num = $conn->query("SELECT * FROM `tbl_notification` WHERE `notification_status` = 0 AND `notification_receiver` = {$_SESSION['login_user_id']} ")->num_rows;
                    ($notif_unread_num==0) ? $notif_unread_num = '' : $notif_unread_num = $notif_unread_num;
                ?>
                    <div class="dropdown">
                        <button onclick="myFunction()" class="dropbtn fa-solid fa-bell"><sup style="font-size: 20px;"><?php echo $notif_unread_num ?></sup></button>
                        <div id="myDropdown" class="dropdown-content">
                <?php  
                    if($notif_num_total!=0):
                    $notif = $conn->query("SELECT * FROM tbl_notification WHERE notification_receiver = {$_SESSION['login_user_id']} ORDER BY notification_date DESC LIMIT 30");
                    while($row=$notif->fetch_assoc()):

                    ($row['notification_status'] == 1) ? $notif_class = "" : $notif_class = " unread";
                    $datetime = date('F d, Y (h:i A)', strtotime($row['notification_date']));
                    
                    if(!is_null($row['avail_pending']) || !is_null($row['avail_proceed_downpayment']) || !is_null($row['avail_confirmed']) || !is_null($row['avail_completed']) || !is_null($row['avail_cancelled']) || !is_null($row['avail_reschedule']) || !is_null($row['avail_downpayment_sent']) )
                    {
                        if(!is_null($row['avail_pending'])){ $avail_id_notif = $row['avail_pending']; $avail_notif_status = 0; }
                        //if(!is_null($row['avail_proceed_downpayment'])){ $avail_id_notif = $row['avail_proceed_downpayment']; $avail_notif_status = 1; }
                        //if(!is_null($row['avail_confirmed'])){ $avail_id_notif = $row['avail_confirmed']; $avail_notif_status = 2; }
                        //if(!is_null($row['avail_completed'])){ $avail_id_notif = $row['avail_completed']; $avail_notif_status = 3; }
                        if(!is_null($row['avail_cancelled'])){ $avail_id_notif = $row['avail_cancelled']; $avail_notif_status = 4; }
                        if(!is_null($row['avail_reschedule'])){ $avail_id_notif = $row['avail_reschedule']; $avail_notif_status = 5; }
                        if(!is_null($row['avail_downpayment_sent'])){ $avail_id_notif = $row['avail_downpayment_sent']; $avail_notif_status = 6; }
                    
                        $avail_details =  $conn->query("SELECT a.avail_starting_date_time, a.avail_cancel_reason, a.avail_resched_reason, s.service_id, s.service_name, u.user_id as sender_id, CONCAT(u.user_first_name , ' ' , u.user_last_name) AS notification_sender FROM tbl_service_avail a LEFT JOIN tbl_service_packages s ON a.service_id = s.service_id RIGHT JOIN `tbl_user_account` u ON a.user_id = u.user_id WHERE a.avail_id = '$avail_id_notif' AND s.user_id = {$_SESSION['login_user_id']}");
                        while($row=$avail_details->fetch_assoc())
                        {
                            $year_month = $ym = date('Y-m', strtotime($row['avail_starting_date_time']));
                            $avail_reason_notif = $row['avail_cancel_reason'];
                            $resched_reason_notif = $row['avail_resched_reason'];
                            $service_id_notif = $row['service_id'];
                            $srvc_name_notif = $row['service_name'];
                            $sender_id_notif = $row['sender_id'];
                            $sender_name= $row['notification_sender'];
                        }
                    
                        if($avail_notif_status == 0)
                        { 
                            $src = "availing-logo.png";
                            $stat = "availed";
                            $sentence = $sender_name . ' ' . $stat . ' your ' . $srvc_name_notif . ' waiting for you to approve the schedule.';
                        }

                        if($avail_notif_status == 4)
                        { 
                            $src = "cancel-logo.png";
                            $stat = "cancelled";
                            $avail_reason_notif = 'due to reason of "' . $avail_reason_notif . '"';
                            $sentence = $sender_name . ' ' . $stat . ' their Availed Schedule in ' . $srvc_name_notif . ' ' . $avail_reason_notif;
                        }

                        if($avail_notif_status == 5)
                        { 
                            $src = "cancel-logo.png";
                            $stat = "is requesting for a reschedule ";
                            $resched_reason_notif = 'due to reason of "' . $resched_reason_notif . '"';
                            $sentence = $sender_name . ' ' . $stat . ' in ' . $srvc_name_notif . ' ' . $resched_reason_notif;
                        }

                        if($avail_notif_status == 6)
                        { 
                            $src = "downpayment.png";
                            $stat = "sent a proof of downpayment";
                            $sentence = $sender_name . ' ' . $stat . ' for the ' . $srvc_name_notif . ' waiting for you to confirm.';
                        }
                ?>
                        <div class="card-notif<?php echo $notif_class ?>">
                            <div style="height: 100%; margin: auto">
                                <img src="../assets/icons/<?php echo $src ?>" style="width: 50px; margin-left: 10px;  margin-right: 20px;" alt="">
                            </div>
                            <div>
                                <h6><?php echo $datetime ?></h6>
                                <p><?php echo $sentence ?></p>
                                <a  class="notif-btn" onclick="location.href='?page=service&l_id=<?php echo $_SESSION['login_user_id'] ?>&srvc_id=<?php echo $service_id_notif ?>&avail_id=<?php echo $avail_id_notif ?>&ym=<?php echo $year_month ?>&c_id=<?php echo $sender_id_notif ?>';">Go</a>
                            </div>
                        </div>
                <?php
                    }
                    else if(!is_null($row['order_pending']) || !is_null($row['order_confirmed']) || !is_null($row['order_completed']) || !is_null($row['order_cancelled']))
                    {
                        if(!is_null($row['order_pending'])){ $order_id_notif = $row['order_pending']; $order_notif_status = 0; }
                        //if(!is_null($row['order_confirmed'])){ $order_id_notif = $row['order_confirmed']; $order_notif_status = 1; }
                        //if(!is_null($row['order_completed'])){ $order_id_notif = $row['order_completed']; $order_notif_status = 2; }
                        if(!is_null($row['order_cancelled'])){ $order_id_notif = $row['order_cancelled']; $order_notif_status = 3; }

                        $order_details =  $conn->query("SELECT o.order_cancel_reason, o.order_quantity, pr.product_id, pr.product_name, u.user_id as sender_id, CONCAT(u.user_first_name , ' ' , u.user_last_name) AS notification_sender FROM tbl_order o LEFT JOIN tbl_product pr ON pr.product_id = o.product_id RIGHT JOIN `tbl_user_account` u ON o.user_id = u.user_id WHERE o.order_id = '$order_id_notif' AND pr.user_id = {$_SESSION['login_user_id']}");
                        while($row=$order_details->fetch_assoc())
                        {
                            $avail_reason_notif = $row['order_cancel_reason'];
                            $order_quant = $row['order_quantity'];
                            $product_id_notif = $row['product_id'];
                            $product_name_notif = $row['product_name'];
                            $sender_id_notif = $row['sender_id'];
                            $sender_name = $row['notification_sender'];
                        }

                        if($order_notif_status == 0)
                        { 
                            $src = "order-pending.png";
                            $stat = "ordered";
                            $sentence = $sender_name. ' ' . $stat . ' your product "' . $product_name_notif . '" x' . $order_quant;
                            $link = " ";
                        }
    
                        if($order_notif_status == 3)
                        { 
                            $src = "order-cancelled.png";
                            $stat = "cancelled";
                            $avail_reason_notif = 'due to reason of "' . $avail_reason_notif . '"';
                            $sentence = $sender_name. ' ' . $stat . ' their order of ' . $product_name_notif . ' x' . $order_quant . ' ' . $avail_reason_notif;
                            $link = "&status=cancelled";
                        }
                ?>
                    <div class="card-notif<?php echo $notif_class ?>" >
                        <div style="height: 100%; margin: auto">
                            <img src="../assets/icons/<?php echo $src ?>" style="width: 50px; margin-left: 10px;  margin-right: 20px;" alt="">
                        </div>
                        <div>
                            <h6><?php echo $datetime ?></h6>
                            <p><?php echo $sentence ?></p>
                            <a  class="notif-btn" onclick="location.href='lensman_dashboard.php?page=market&manage_products&my_products&product_id=<?php echo $product_id_notif . $link ?>';">Go</a>
                        </div>
                        
                    </div>
                <?php
                    }
                    endwhile;
                    else:
                ?>
                        <div class="card-notif">
                            <div class="no-notif"  style="margin: auto !important; color: gray !important;">
                                <h4>No Notifications Yet...</h4>
                            </div>
                        </div>
                <?php
                    endif
                ?>
                        </div>

                    </div>
            </li>
        
            <li class="nav-item dropdown" style="margin-bottom: 10px; font-size: 18px;">
                <a class="nav-link"  data-toggle="dropdown" aria-expanded="true" href="javascript:void(0)">
                <span>
                    <div class="d-flex badge-pill align-items-center bg-gradient-primary p-1" style="background: #337cca47 linear-gradient(180deg,#268fff17,#007bff66) repeat-x!important;border:50px; color:#fed136">
                    <?php 
                        $prof_img = $conn->query("SELECT user_profile_image FROM tbl_user_account WHERE user_id = {$_SESSION['login_user_id']}")->fetch_assoc();
                    ?>
                        <div class="rounded-circle mr-1" style="width: 25px; height: 25px; top: -3px; left: -40px">
                        <img src="../../images/profile-images/<?php echo $prof_img['user_profile_image'] ?>" class="image-fluid image-thumbnail rounded-circle" alt="" style="width: calc(100%);height: calc(100%); background:center; background-size: cover; object-fit: cover;">
                        </div>
                    <span ><b><?php echo ucwords($_SESSION['login_user_nickname']) . ' ( ' . ucwords($_SESSION['login_user_type']). ' )' ?></b></span>
                    <span class="fa fa-angle-down ml-2"></span>
                    </div>
                </span>
                </a>
                <div class="dropdown-menu" aria-labelledby="account_settings" style="left: -2.5em;">
                <a class="dropdown-item" href="javascript:void(0)" id="change_my_password"><i class="fa fa-cog"></i> Change Password</a>
                <a class="dropdown-item" href="ajax.php?action=logout3"><i class="fa fa-power-off"></i> Logout</a>
                </div>
            </li>
        </ul>
        </div>
    </nav>
    <style>
        .cart-img {
            width: calc(25%);
            max-height: 13vh;
            overflow: hidden;
            padding: 3px
        }
        .cart-img img{
            width: 100%;
            /*height: 100%;*/
        }
        .cart-qty {
            font-size: 14px
        }
    </style>
    <!-- /.navbar -->
    <script>
        

        /* When the user clicks on the button, 
        toggle between hiding and showing the dropdown content */
        function myFunction() {
            document.getElementById("myDropdown").classList.toggle("show");
            
            var dropdowns = document.getElementsByClassName("dropdown-content");
            var i;
            for (i = 0; i < dropdowns.length; i++) {
                var openDropdown = dropdowns[i];
                if (openDropdown.classList.contains('show')) {
                    $.ajax(
                    {
                        type: "GET",
                        url:"ajax.php?action=update_notif_status",
                        success: function (resp) {
                            console.log(resp);
                        }
                    });
                }
                else{
                    location.reload()
                }
            }
        }

        // Close the dropdown if the user clicks outside of it
        window.onclick = function(event) {
            if (!event.target.matches('.dropbtn')  && !event.target.matches('.notif-btn')) {
                var dropdowns = document.getElementsByClassName("dropdown-content");
                var i;
                for (i = 0; i < dropdowns.length; i++) {
                    var openDropdown = dropdowns[i];
                    if (openDropdown.classList.contains('show')) {
                        openDropdown.classList.remove('show');
                        location.reload();
                    }
                }
            }
        }

        $(document).ready(function(){
        var page = '<?php echo isset($_GET['page']) ? $_GET['page'] : 'home' ?>';
        if($('.nav-link.nav-'+page).length > 0){
            $('.nav-link.nav-'+page).addClass('active')
            console.log($('.nav-link.nav-'+page).hasClass('tree-item'))
            if($('.nav-link.nav-'+page).hasClass('tree-item') == true){
            $('.nav-link.nav-'+page).closest('.nav-treeview').siblings('a').addClass('active')
            $('.nav-link.nav-'+page).closest('.nav-treeview').parent().addClass('menu-open')
            }
            if($('.nav-link.nav-'+page).hasClass('nav-is-tree') == true){
            $('.nav-link.nav-'+page).parent().addClass('menu-open')
            }

        }
        $('#change_my_password').click(function(){
            uni_modal('Change Password','change_pass.php')
        })
        })
    </script>
