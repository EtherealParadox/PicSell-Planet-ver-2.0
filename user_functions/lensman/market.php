<?php
        include '../db_connect.php';
    ?>

        
    <style>
        nav{
            background-color: #114481;
        }
    
        .left-panel{
            width: calc(25%);
            height: calc(100% - 3rem);
            overflow: auto;
            position: fixed;
        }
    
        .center-panel{
            left: calc(25%);
            width: calc(75%);
            height: calc(100% - 3rem);
            overflow: auto;
            position: fixed;
        }
    
        .side-nav:hover, .side-nav span:hover{
			background: #114481;
			color: #fed136;
		}

		.side-nav{
		    margin-right: 20px !important;
		    padding-left: 50px !important;
			color: black;
			border-radius: 50px 50px 50px 50px !important;
		}
    
        .col-md-12:last-child{ 
            padding-bottom: 50px;
        }
    
        .center-panel::-webkit-scrollbar {
            display: none;
        }
    </style>
    <div class="d-flex w-100 h-100"  onload="myFunction()">
        <div class="left-panel mt-2">
				<?php ($_SESSION['login_user_type'] === "Lensman") ? $in_sess_link = "lensman" : $in_sess_link = "customer"; ?>
				<a href="<?php echo $in_sess_link ?>_dashboard.php?page=profile" class="d-flex py-4 px-1 side-nav rounded">
					<?php if(isset($_SESSION['login_user_profile_image']) && !empty($_SESSION['login_user_profile_image'])): ?>
						<div class="rounded-circle mr-1" style="width: 30px;height: 30px;top:-5px;left: -40px">
						<img src="../../images/profile-images/<?php echo $prof_img['user_profile_image'] ?>" class="image-fluid image-thumbnail rounded-circle" alt="" style="width: calc(100%);height: calc(100%); background:center; background-size: cover; object-fit: cover;">
						</div>
					<?php else: ?>
					<span class="fa fa-user mr-2" style="width: 30px;height: 30px;top:-5px;left: -40px"></span>
					<?php endif; ?>
					<span class="ml-3" style="margin-top: 4px; font-size: 20px;"><b><?php echo ucwords($_SESSION['login_user_first_name'] . ' ' . $_SESSION['login_user_last_name'])?></b></span>
				</a>
				<a href="<?php echo $in_sess_link ?>_dashboard.php?page=home" class="d-flex py-4 px-1 side-nav rounded">
					<span class="fa fa-home mr-2" style="width: 30px;height: 30px;top:-5px;left: -40px"></span>

					<span class="ml-3" style="margin-top: -1px; font-size: 20px;"><b>Home</b></span>
				</a>
				<a href="<?php echo $in_sess_link ?>_dashboard.php?page=service" class="d-flex py-4 px-1 side-nav rounded">
					<span class="fa fa-camera mr-2" style="width: 30px;height: 30px;top:-5px;left: -40px"></span>

					<span class="ml-3" style="margin-top: -1px; font-size: 20px;"><b>Service</b></span>
				</a>
				<a href="<?php echo $in_sess_link ?>_dashboard.php?page=market" class="d-flex py-4 px-1 side-nav rounded">
					<span class="fa fa-store mr-2" style="width: 30px;height: 30px;top:-5px;left: -40px"></span>

					<span class="ml-3" style="margin-top: -1px; font-size: 20px;"><b>Marketplace</b></span>
				</a>
				<a href="<?php echo $in_sess_link ?>_dashboard.php?page=map" class="d-flex py-4 px-1 side-nav rounded">
					<span class="fa fa-map mr-2" style="width: 30px;height: 30px;top:-5px;left: -40px"></span>

					<span class="ml-3" style="margin-top: -1px; font-size: 20px;"><b>Map</b></span>
				</a>
				<a href="<?php echo $in_sess_link ?>_dashboard.php?page=messages" class="d-flex py-4 px-1 side-nav rounded">
					<span class="fa fa-envelope mr-2" style="width: 30px;height: 30px;top:-5px;left: -40px"></span>

					<span class="ml-3" style="margin-top: -1px; font-size: 20px;"><b>Messages</b></span>
				</a>
				<hr>
			</div>
    
        <div class="center-panel py-2 px-2">
            <div class="container-fluid">
                <div class="col-md-12">
            <?php
                    if(!isset($_GET['product']) && !isset($_GET['manage_products']) && !isset($_GET['cart']) && !isset($_GET['my_orders']) && !isset($_GET['history'])): /*location.href='?page=service&l_id=<?php //echo $_GET['l_id']?>&action=add_product';*/
        //Start of showing all products
            ?>
                    <style>
                        .tab {
                            overflow: hidden;
                            background-color: rgba(33, 150, 243, 0.4);
                            border-radius: 50px 50px 50px 50px;
                            display: grid;
                            grid-template-columns: repeat(2, 1fr);
                            margin-bottom: 20px;
                        }
                    
                        .tab button {
                            background-color: inherit;
                            border: none;
                            outline: none;
                            cursor: pointer;
                            padding: 14px 16px;
                            transition: 0.3s;
                            font-size: 20px;
                            font-weight: bolder;
                        }
                    
                        .tab button:hover {
                            background: #114481;
                            color: #fed136;
                        }
                    
                        .tab button.active {
                            background: #114481;
                            color: #fed136;
                        }
                    
                        .grid-container-products {
                            display: grid;
                            grid-template-columns: repeat(auto-fit, minmax(230px, auto));
                            grid-gap: 10px;
                            box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2), 0 6px 20px 0 rgba(0, 0, 0, 0.19);
                            background-color: whitesmoke;
                            border-radius: 5px 5px 5px 5px;
                            padding: 10px;
                            height: auto;
                        }
                    
                        .grid-container-products > div {
                            background-color: #114481;
                            text-align: center;
                            padding: 20px 0 0 0;
                            font-size: 20px;
                            font-weight: bolder;
                        }
                    
                        .item-products {
                            border-radius: 10px;
                            height: fit-content;
                        }
                        .item-products:hover {
                            transform: scale(1.03);
                            transition: .5s;
                            box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.5), 0 6px 20px 0 rgba(0, 0, 0, 0.19);
                            background-color: #08204b;
                            cursor: pointer;
                        }
                    
                        .item-products p, .stars{
                            margin-left: 20px;
                            color:#fed136;
                            text-align: start;
                        }
                        .item-products .stars {
                            color: black !important;
                        }
                    
                        .item-products button {
                            border: none;
                            border-radius: 15px 15px 15px 15px;
                            padding: 5px 10px 5px 10px;
                            background-color: #fed136;
                            font-weight: bold;
                        }
                    
	                    .item-products > * {
                            margin-bottom: 5px;
                        }
                    
                        .item-products:last-child {
                            margin-bottom: 0px;
                        }
                    
                        .stars {
                            font-size: 15px;
                        }
                    </style>
                    <div class="tab">
                        <button class="tablinks active" onclick="location.href='?page=market';">Products</button>
                        <button class="tablinks" onclick="location.href='?page=market&manage_products';">Manage Products</button>
                        <!--<button class="tablinks" onclick="location.href='?page=market&cart';">My Cart</button>
                        <button class="tablinks" onclick="location.href='?page=market&my_orders';">My Order/s</button>
                        <button class="tablinks" onclick="location.href='?page=market&history';">History</button>-->
                    </div>  

                    <div class="grid-container-products">
            <?php
                    $products = $conn->query("SELECT * FROM `tbl_product` WHERE user_id != {$_SESSION['login_user_id']} ");
                    while($row = $products->fetch_assoc()): //SELECT * FROM `tbl_product` WHERE `product_banner` = ''
                    $reviews = $conn->query("SELECT AVG(feedback_rate) as average, SUM(if(feedback_rate = 5,1,0)) as r5, SUM(if(feedback_rate = 4,1,0)) as r4,
					SUM(if(feedback_rate = 3,1,0)) as r3, SUM(if(feedback_rate = 2,1,0)) as r2, SUM(if(feedback_rate = 1,1,0)) as r1 FROM tbl_feedback WHERE  `product_id` = {$row['product_id']}");
					while($r_rows=$reviews->fetch_assoc())
					{
						(is_null($r_rows['average'])) ? $average = 0 :  $average = $r_rows['average'];
						/*($r_rows['r1']!=0) ? $r1 = $r_rows['r1'] : $r1 = 0;
						($r_rows['r2']!=0) ? $r2 = $r_rows['r2'] : $r2 = 0;
						($r_rows['r3']!=0) ? $r3 = $r_rows['r3'] : $r3 = 0;
						($r_rows['r4']!=0) ? $r4 = $r_rows['r4'] : $r4 = 0;
						($r_rows['r5']!=0) ? $r5 = $r_rows['r5'] : $r5 = 0;*/
					}
                    
                    (empty($row['product_banner'])) ? $banner = 'placeholder_image.png' : $banner = $row['product_banner']; 
            ?>
                    <div class="item-products" onclick="location.href='?page=market&product=<?php echo $row['product_id'] ?>';">
                        <img src="../assets/banners/products/<?php echo $banner ?>" alt="" style="width: 230px; height: 230px; object-fit: cover;">
                        <p><img src="../assets/icons/products-icon.png" style="width: 30px; height:auto; margin-right: 5px;"><?php echo $row['product_name'] ?></p>
                        <p><img src="../assets/icons/price-icon.png" style="width: 30px; height:auto; margin-right: 5px;">Php <?php echo $row['product_price'] ?></p>
                        <div class="stars">
            <?php
                        for($i=1; $i<=floor($average); $i++)
						{
			?>
							<span class="fa fa-star star-light text-warning"></span>
			<?php
						}
						for($i=1; $i<=5-floor($average); $i++)
						{
			?>
							<span class="fa fa-star star-light"></span>
			<?php
						}
            ?>
                        </div>
                        <p style="font-size: 15px;"><img src="../assets/icons/stock-icon.png" style="width: 30px; height:auto; margin-right: 5px;"><?php echo $row['product_stock'] ?> left</p>
                    </div>
            <?php
                    endwhile;
            ?>
                        </div>
            <?php
        //End of showing all products
                    endif;
                    if(isset($_GET['product']) && !isset($_GET['manage_products']) && !isset($_GET['cart']) && !isset($_GET['my_orders']) && !isset($_GET['history'])): /*location.href='?page=service&l_id=<?php //echo $_GET['l_id']?>&action=add_product';*/
//Start of showing specific product details
            ?>
                    <style>
                        .product_title {
							background: #114481;
							border-radius: 5px;
							color: #fed136; 
							padding: 20px;
                            font-weight: 600;
						}
                    
                        .product_info {
                            display: flex;
                            width: 100%;
                            margin-bottom: 20px;
                        }
                    
                        .product_info > *{
                            margin-left: 30px;
                        }
                    
                        .product_img {
                            width: 40vh;
                            border: 2px solid black;
                            object-fit: cover;
                        }
                        .p_info2{
                            width: 240px;
                        }
                    
                        .p_info2 > * {
                            font-size: 30px;
                            font-weight: bolder;
                        }
                    
                        .p_info2 > *:not(:last-child) {
                            margin-bottom: 1rem;
                        }
                        
                    
                        .stars {
                            font-size: 25px;
                            color: black !important;
                        }
                        .p_info3 {
                            width: 36%;
                            text-align: center;
                            font-size: 25px;
                            font-weight: bolder;
                        }
                        .p_info3 > * {
                            margin-bottom: 1rem !important;
                        }
                        .product_desc p {
                            margin-bottom: .5rem !important;
                        }
                        
                        .product_desc p:nth-child(2) {
                            height: 150px;
                            border: 2px solid black;
                            border-radius: 5px;
                            padding: 20px;
                            overflow-y: auto;
                            font-size: 20px;
                            text-align: justify;
                            word-wrap: break-word;
                        }
                    
                        .addToCartForm {
                            display: flex;
                            flex-direction: row;
                            justify-content: space-around;
                        }
                    
                        .addToCartForm > * {
                            margin-top: auto;
                            margin-bottom: auto;
                        }
                    
                        .cartInput > * {
                            margin-top: auto;
                            margin-bottom: auto;
                        }
                    
                        .addToCartForm input {
                            width: 75px
                        }
                    
                        .addToCartForm button {
                            background-color: #114481;
                            color: #fed136;
                            font-size: 20px;
                            font-weight: 600;
                            border: none;
                            border-radius: 50px;
                            padding: 10px 20px 10px 20px;
                        }
                        .p_review {
                            margin: 6.5vh auto 0 auto;
                            display: flex;
                            flex-direction: column;
                            
                        }
                        .p_review button{
                            background-color: #114481;
                            color: #fed136;
                            font-size: 20px;
                            font-weight: 600;
                            border: none;
                            border-radius: 50px;
                            padding: 10px 20px 10px 20px;
                        }
                        .p_review button:not(:last-of-type) {
                            margin-bottom: 20px;
                        }
                    
                        .c_fdbk {
							display: flex;
							justify-content: space-between;
						}
                    
						.dropbtnf {
							background-color: #114481;
							color: #fed136;
							padding: 7.5px 15px 7.5px 15px;
							font-size: 16px;
							font-weight: 650;
							border: none !important;
							border-radius: 5px;
							cursor: pointer;
						}
                    
						/* The container <div> - needed to position the dropdown content */
						.dropdownf {
							margin-top: auto;
							margin-bottom: auto;
							position: relative;
							display: inline-block;
						}
                    
						/* Dropdown Content (Hidden by Default) */
						.dropdown-contentf {
							right: 0;
							display: none;
							min-width: 140px;
							position: absolute;
							background-color: #f9f9f9;
							box-shadow: 0px 8px 16px 0px rgba(0,0,0,0.2);
							z-index: 1;
						}
                    
						/* Links inside the dropdown */
						.dropdown-contentf a {
							color: black;
							padding: 12px 16px;
							text-decoration: none;
							display: block;
							text-align: center;
							font-weight: 650;
						}
                    
						/* Change color of dropdown links on hover */
						.dropdown-contentf a:hover {background-color: #f1f1f1}
						/* Show the dropdown menu on hover */
						.dropdownf:hover .dropdown-contentf {
							display: block;
						}
                    
						/* Change the background color of the dropdown button when the dropdown content is shown */
						.dropdownf:hover .dropbtnf {
							border: none !important;
							background-color: #fed136;
							color: #114481;
						}
                    </style>
                    <div>
                    <h3 class="product_title">
                        <a href="?page=market" style="float: left; color:#fed136"><i class="fa fa-arrow-left"></i>&nbsp;&nbsp;&nbsp;</a>
                        Product Details
                    </h3>
					</div>
            <?php
                    $products = $conn->query("SELECT * FROM `tbl_product` WHERE product_id = {$_GET['product']} ");
                    while($row = $products->fetch_assoc()): //SELECT * FROM `tbl_product` WHERE `product_banner` = ''
                    $stock = $row['product_stock'];
                    $reviews_num = $conn->query("SELECT * FROM tbl_feedback WHERE  `product_id` = {$_GET['product']}")->num_rows;
                    $reviews = $conn->query("SELECT AVG(feedback_rate) as average, SUM(if(feedback_rate = 5,1,0)) as r5, SUM(if(feedback_rate = 4,1,0)) as r4,
                    SUM(if(feedback_rate = 3,1,0)) as r3, SUM(if(feedback_rate = 2,1,0)) as r2, SUM(if(feedback_rate = 1,1,0)) as r1 FROM tbl_feedback WHERE  `product_id` = {$_GET['product']}");
                    while($r_rows=$reviews->fetch_assoc())
                    {
                        (is_null($r_rows['average'])) ? $average = 0 :  $average = $r_rows['average'];
                        ($r_rows['r1']!=0) ? $r1 = $r_rows['r1'] : $r1 = 0;
                        ($r_rows['r2']!=0) ? $r2 = $r_rows['r2'] : $r2 = 0;
                        ($r_rows['r3']!=0) ? $r3 = $r_rows['r3'] : $r3 = 0;
                        ($r_rows['r4']!=0) ? $r4 = $r_rows['r4'] : $r4 = 0;
                        ($r_rows['r5']!=0) ? $r5 = $r_rows['r5'] : $r5 = 0;
                    }
                    (empty($row['product_banner'])) ? $banner = 'placeholder_image.png' : $banner = $row['product_banner']; 
            ?>
                    <div class="product_info">
                        <img class="product_img" src="../assets/banners/products/<?php echo $banner ?>" alt="">
                        <div class="p_info2">
                            <p><?php echo nl2br($row['product_name']) ?></p>
                            <p><img src="../assets/icons/price-icon.png" style="width: 30px; height:auto; margin-right: 5px;">₱ <?php echo number_format($row['product_price']) ?></p>
                            <div class="stars">
                            <?php
                    for($i=1; $i<=floor($average); $i++)
					{
			?>
							<span class="fa fa-star star-light text-warning"></span>
			<?php
					}
					for($i=1; $i<=5-floor($average); $i++)
					{
			?>
							<span class="fa fa-star star-light"></span>
			<?php
					}
            ?>
                            </div>
            <?php
                            ($row['product_stock'] <= 10) ? (($row['product_stock'] < 1) ? $stock = number_format($row['product_stock']) . ' left ( Sold Out )' : $stock = number_format($row['product_stock']) . ' left ( Low Stock )') : $stock = number_format($row['product_stock']) . ' left';
            ?>
                        <p style="font-size: 20px;"><img src="../assets/icons/stock-icon.png" style="width: 30px; height:auto; margin-right: 5px;"><?php echo $stock ?></p>
                        <p style="display: none" id="product<?php echo $row['product_id'] ?>" ><?php echo $row['product_stock'] ?></p>
                        </div>
                        <div class="p_info3">
                            <div class="product_desc">
                                <p><img src="../assets/icons/description-icon.png" style="width: 30px; height:auto; margin-right: 5px;">Description: </p>
                                <p><?php echo $row['product_description'] ?></p>
                            </div>
                        </div>
                    </div>
                    <section style="border-top: 7px solid #DCDCDC;">
                    <div class="c_fdbk">
						<h2 style="padding-top: 10px;">Customer Feedback/s</h2>
						<div class="dropdownf">
							<button class="dropbtnf">Sort Ratings</button>
							<div class="dropdown-contentf">
							<a href="?page=market&product=<?php echo $_GET['product'] ?>">All ( <?php echo $reviews_num ?> )</a>
								<a href="?page=market&product=<?php echo $_GET['product'] ?>&sort=5">5 <i class="fas fa-star text-warning"></i> ( <?php echo $r5; ?> )</a>
								<a href="?page=market&product=<?php echo $_GET['product'] ?>&sort=4">4 <i class="fas fa-star text-warning"></i> ( <?php echo $r4; ?> )</a>
								<a href="?page=market&product=<?php echo $_GET['product'] ?>&sort=3">3 <i class="fas fa-star text-warning"></i> ( <?php echo $r3; ?> )</a>
								<a href="?page=market&product=<?php echo $_GET['product'] ?>&sort=2">2 <i class="fas fa-star text-warning"></i> ( <?php echo $r2; ?> )</a>
								<a href="?page=market&product=<?php echo $_GET['product'] ?>&sort=1">1 <i class="fas fa-star text-warning"></i> ( <?php echo $r1; ?> )</a>
							</div>
						</div>
					</div>
                    
                    </section>
            <?php
                    endwhile;
            ?>
                    <style>
                        .feedback_container {
                            width: calc(100%);
                            margin-bottom: 20px;
                            background-color: rgba(255, 255, 255, 0.15);
                            box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.5), 0 6px 20px 0 rgba(0, 0, 0, 0.19);
                            border-radius: 5px 5px 5px 5px;
                            padding: 20px 20px 10px 20px;
                        }

                        .user_info {
                            padding-left: 20px;
                        }

                        .feedback_stars {
                            text-align: center;
                        }

                        .feedback_container p {
                            font-size: 20px;
                            text-align: center;
                        }

                        .color-star{
                            color: #fed136;
                        }

                        .c_fdbk {
                            display: flex;
                            justify-content: space-between;
                        }
                    </style>
            <?php
                    if($reviews_num > 0):
    //Start of Product feedback if theres feedbacks taken from the db
                        if(isset($_GET['sort'])):
        //Start of Product feedback with sorting
                            $fdbk_sort_num = $conn->query("SELECT * FROM tbl_feedback WHERE `feedback_archive_status` = '1' AND `product_id` = {$_GET['product']} AND `feedback_rate` = {$_GET['sort']}")->num_rows;	
                            if($reviews_num != 0 && $fdbk_sort_num != 0):
                                $reviews = $conn->query("SELECT * FROM tbl_feedback WHERE `feedback_archive_status` = '1' AND `product_id` = {$_GET['product']} AND `feedback_rate` = {$_GET['sort']} ORDER BY `feedback_date` DESC");
                                while($row=$reviews->fetch_assoc()):
                                $user = $conn->query("SELECT `user_first_name`, `user_last_name`, `user_profile_image` from tbl_user_account WHERE `user_id` = {$row['user_id']}");
                                while($u_row=$user->fetch_assoc()):
                                $fdbk_date = date("M d, Y", strtotime($row['feedback_date']));
                                $fdbk_time = date("h:i A", strtotime($row['feedback_date']));
                                (!empty($row['feedback_message'])) ? $msg = true : $msg = false;
            ?>
                                <div class="feedback_container">
                                    <div>
                                        <img src="../../<?php echo $u_row['user_profile_image'] ?>" style="float:left; border-radius: 90%; width:50px; height:50px; background: center; background-size: cover; object-fit: cover;"/> 
                                        <div class="user_info" style="display:inline-block;">
                                            <h5 class="user_avail_info"><?php echo $u_row['user_first_name'].' '.$u_row['user_last_name'] ?></h5>
                                            <h6 class="user_avail_info"><?php echo $fdbk_date . ' ( ' . $fdbk_time . ' )'?></h6>
                                        </div>

                                    </div>
                                <div class="feedback_stars">
            <?php
                                for($i=1; $i<=$row['feedback_rate']; $i++)
                                {
            ?>
                                    <span class="fa fa-star fa-2x star-light color-star"></span>
            <?php
                                }
                                for($i=1; $i<=5-$row['feedback_rate']; $i++)
                                {
            ?>
                                    <span class="fa fa-star fa-2x star-light"></span>
            <?php
                                }
            ?>
                            </div>
            <?php
                            ($msg) ? $msg_line = '<p>' . $row['feedback_message'] . '</p>' :  $msg_line = '';
                            echo $msg_line;
            ?>
                            </div>
            <?php
                            endwhile;
                            endwhile;
                            else:
            ?>
                                <div style="text-align: center; box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.5), 0 6px 20px 0 rgba(0, 0, 0, 0.19);; height: auto; position: relative; display: flex; flex-direction: column; justify-content: center;">
                                    <h3>No <?php echo $_GET['sort'] ?> Star Rating Reviews Yet...</h3>
                                </div>
            <?php
                            endif;
        //End of Product feedback with sorting
                        else:
        //Start of showing all feedbacks
                        $reviews = $conn->query("SELECT * FROM tbl_feedback WHERE `feedback_archive_status` = '1' AND `product_id` = {$_GET['product']} ORDER BY `feedback_date` DESC");
                        while($row=$reviews->fetch_assoc()):
                        $user = $conn->query("SELECT `user_first_name`, `user_last_name`, `user_profile_image` from tbl_user_account WHERE `user_id` = {$row['user_id']}");
                        while($u_row=$user->fetch_assoc()):
                        $fdbk_date = date("M d, Y", strtotime($row['feedback_date']));
                        $fdbk_time = date("h:i A", strtotime($row['feedback_date']));
                        (!empty($row['feedback_message'])) ? $msg = true : $msg = false;
            ?>
                        <div class="feedback_container">
                        <div>
                            <img src="../../<?php echo $u_row['user_profile_image'] ?>" style="float:left; border-radius: 90%; width:50px; height:50px; background: center; background-size: cover; object-fit: cover;"/> 
                            <div class="user_info" style="display:inline-block;">
                                <h5 class="user_avail_info"><?php echo $u_row['user_first_name'].' '.$u_row['user_last_name'] ?></h5>
                                <h6 class="user_avail_info"><?php echo $fdbk_date . ' ( ' . $fdbk_time . ' )'?></h6>
                            </div>
                            
                        </div>
                        <div class="feedback_stars">
            <?php
                        for($i=1; $i<=$row['feedback_rate']; $i++)
                        {
            ?>
                            <span class="fa fa-star fa-2x star-light color-star"></span>
            <?php
                        }
                        for($i=1; $i<=5-$row['feedback_rate']; $i++)
                        {
            ?>
                            <span class="fa fa-star fa-2x star-light"></span>
            <?php
                        }
            ?>
                        </div>
            <?php
                        ($msg) ? $msg_line = '<p>' . $row['feedback_message'] . '</p>' :  $msg_line = '';
                        echo $msg_line;
            ?>
                        </div>
            <?php
                        endwhile;
                        endwhile;

                            endif;
        //End of showing all feedbacks
    //End of Product feedback if theres feedbacks taken from the db
                    else:
			?>
					<div style="text-align: center; box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.5), 0 6px 20px 0 rgba(0, 0, 0, 0.19);; height: auto; position: relative; display: flex; flex-direction: column; justify-content: center;">
							<h3>No Reviews Yet...</h3>
					</div>
			<?php
					endif;

//End of showing specific product details
                    endif;
                    if(!isset($_GET['product']) && isset($_GET['manage_products']) && !isset($_GET['cart']) && !isset($_GET['my_orders']) && !isset($_GET['history'])): /*location.href='?page=service&l_id=<?php //echo $_GET['l_id']?>&action=add_product';*/
    //Start of showing adding/managing own products
            ?>
                    <style>
                        .tab {
                            overflow: hidden;
                            background-color: rgba(33, 150, 243, 0.4);
                            border-radius: 50px 50px 50px 50px;
                            display: grid;
                            grid-template-columns: repeat(2, 1fr);
                            margin-bottom: 20px;
                        }
                    
                        .tab2 {
                            overflow: hidden;
                            background-color: rgba(33, 150, 243, 0.4);
                            border-radius: 50px 50px 50px 50px;
                            display: grid;
                            grid-template-columns: repeat(3, 1fr);
                            margin-bottom: 20px;
                        }
                    
                        .tab button {
                            background-color: inherit;
                            border: none;
                            outline: none;
                            cursor: pointer;
                            padding: 14px 16px;
                            transition: 0.3s;
                            font-size: 20px;
                            font-weight: bolder;
                        }
                    
                        .tab2 button {
                            background-color: inherit;
                            border: none;
                            outline: none;
                            cursor: pointer;
                            padding: 5px 0 5px 0;
                            transition: 0.3s;
                            font-size: 20px;
                            font-weight: bolder;
                        }
                    
                        .tab button:hover, .tab2 button:hover {
                            background: #114481;
                            color: #fed136;
                        }
                    
                        .tab button.active, .tab2 button.active {
                            background: #114481;
                            color: #fed136;
                        }
                    
                        .add_product_form {
							margin-top: 10px;
							border-radius: 5px 5px 5px 5px;
							box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2), 0 6px 20px 0 rgba(0, 0, 0, 0.19);
							background-color: whitesmoke;
							padding: 20px 40px 20px 40px;
						}
						.label {
							font-weight: bolder;
							text-align: left;
						}
						.add_product {
							display: grid;
							grid-template-columns: repeat(2, 1fr);
							font-size: 20px;
							grid-gap: 20px;
						}
						
						.input {
							margin-bottom: 10px;
							width: 80%;
							padding: 10px;
						}
						textarea {
							resize: none;
							overflow-y: auto;
							padding: 10px;
						}
						label img:hover {
							cursor: pointer;
						}
						#output {
							border: 1px solid black;
							width: 85%;
							height: 322px;
							background:center; 
							background-size: cover; 
							object-fit: contain;
						}
						input[type=submit] {
							margin-top: 20px;
							background-color: rgba(0, 0, 0, 0.2);
							color: white;
							padding: 10px 20px 10px 20px;
							border: none;
							border-radius: 50px 50px 50px 50px;
						}
						input[type=submit]:hover {
							background: #114481;
							color: #fed136;
						}
                    </style>
                    <div class="tab">
                        <button class="tablinks" onclick="location.href='?page=market';">Products</button>
                        <button class="tablinks active" onclick="location.href='?page=market&manage_products';">Manage Products</button>
                        <!--<button class="tablinks" onclick="location.href='?page=market&cart';">My Cart</button>
                        <button class="tablinks" onclick="location.href='?page=market&my_orders';">My Order/s</button>
                        <button class="tablinks" onclick="location.href='?page=market&history';">History</button>-->
                    </div>  
            <?php
                    if(!isset($_GET['edit']) && !isset($_GET['my_products'])):
        //Start of showing adding products
            ?>
                    <div class="tab2">
                        <button class="tablinks active" onclick="location.href='?page=market&manage_products';">Add</button>
                        <button class="tablinks" onclick="location.href='?page=market&manage_products&edit';">Edit</button>
                        <button class="tablinks" onclick="location.href='?page=market&manage_products&my_products';">My Products</button>
                    </div>

                    <div class="add_product_form">
                        <h3 class="label">Adding New Product</h3>
						<form action="" id="add_product" >
							<div class="add_product">
								<div class="add_product_left">
									<p class="label">Product Name</p>
									<input class="input" type="text" id="product_name" name="product_name" required>
									<p class="label">Product Price</p> 
									<input class="input" type="text" id="product_price" name="product_price" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');" required>
									<p class="label">Product Description</p>
									<textarea class="input" name="product_description" id="product_description" cols="50" rows="8.5" required></textarea>
								</div>
								<div>
									<p class="label">Product Stock</p>
									<input class="input" type="text" id="product_stock" name="product_stock" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');" required>
									<p class="label">Product Banner</p>
									<label>
										<img src="../../assets/img/logos/image.png" style="width: 40px">
										<input type="file" id="product_banner" name="product_banner" accept="image/*" onchange="loadFile(event)" style="display:none">
									</label>
									<br>
									<img id="output" />
									<center><input type="submit" id="product_submit" name="product_submit" value="Submit" style="margin-bottom: 5px; font-weight: 700;" form="add_product"></center>
								</div>
							</div>
						</form>
					</div>
					<script src="http://code.jquery.com/jquery-1.9.1.js"></script>
					<script>
                        
                        var loadFile = function(event) {
                            var output = document.getElementById('output');
                                output.src = URL.createObjectURL(event.target.files[0]);
                                output.onload = function() {
					            URL.revokeObjectURL(output.src) // free memory
                            }
                        };
                        $('#add_product').submit(function(e){
                            e.preventDefault()
                            var name = document.getElementById('product_name').value
                            var price = document.getElementById('product_price').value
                            var description = document.getElementById('product_description').value
                            var banner = document.getElementById('product_banner')
                            const isEmpty = str => !str.trim().length;
                            if( (!name && isEmpty(name)) || (!price || price <= 0) || !description || !banner ) {
                                alert_toast("Some data needed is missing",'warning')
                            }
                            else 
                            {
                                if(isEmpty(name) || isEmpty(description))
                                {
                                    alert_toast("Some data needed is missing",'warning')
                                }
                                else
                                {
                                    start_load()
                                    $.ajax({
                                        url:"ajax.php?action=add_product",
                                        data: new FormData($(this)[0]),
                                        cache: false,
                                        contentType: false,
                                        processData: false,
                                        method: 'POST',
                                        type: 'POST',
                                        success:function(resp){
                                            console.log(resp)
                                            if(resp == 1){
                                                alert_toast("Successfully added product", "success")
                                                setTimeout(function(){
                                                    location.reload()
                                                },1500)
                                            }
                                            else if(resp == 2){
                                                alert_toast("Something went wrong", "warning")
                                                end_load()
                                            }
                                        }
                                    })
                                }
                            
                            }
                            /*const toBase64 = file => new Promise((resolve, reject) => {
                                const reader = new FileReader();
                                reader.readAsDataURL(file);
                                reader.onload = () => resolve(reader.result);
                                reader.onerror = error => reject(error);
                            });
                            const file = document.querySelector('#product_banner').files[0];
                            console.log(toBase64(file));*/
                        })
					</script>
					<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
            <?php
        //End of showing adding products
                    endif;
                    if(isset($_GET['edit']) && !isset($_GET['my_products'])):
        //Start of showing editing products
            ?>
                    <div class="tab2">
                        <button class="tablinks" onclick="location.href='?page=market&manage_products';">Add</button>
                        <button class="tablinks active" onclick="location.href='?page=market&manage_products&edit';">Edit</button>
                        <button class="tablinks" onclick="location.href='?page=market&manage_products&my_products';">My Products </button>
                    </div>

					<style>
						.grid-container-m_products {
							display: grid;
							grid-auto-rows: 1fr;
							grid-gap: 10px;
							box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2), 0 6px 20px 0 rgba(0, 0, 0, 0.19);
							background-color: whitesmoke;
							border-radius: 5px;
							padding: 10px;
							margin-top: 10px;
							height: auto;
						}
					
						.grid-container-m_products > div {
							background-color: #114481;
							font-size: 20px;
							font-weight: bolder;
                            padding: 10px;
                            
						}
					
						.item-m_products {
							border-radius: 5px 5px 5px 5px;
							height: fit-content;
                            display: flex;
                            flex-direction: row;
                            justify-content: space-between;
						}
                    
                        .item-m_products > div {
                            margin-top: auto; margin-bottom: auto; 
                            display: flex; flex-direction: row;
                        }
					
						.item-m_products p {
                            margin-top: auto; 
                            margin-bottom: auto; 
							color: #fed136;
							float: left;
                            width: 270px;
						}
                    
						.item-m_products p:hover {
							cursor: pointer;
						}
                    
                        .archive_product {
                            margin-top: auto; margin-bottom: auto; 
                            width: 30px; height: 30px;
                        }
                        
                        .archive_product:hover {
                            cursor: pointer;
                        }
					
						.item-m_products button {
							border: none;
							border-radius: 15px 15px 15px 15px;
							padding: 5px 10px 5px 10px;
							margin-right: 30px;
							background-color: #fed136;
							font-weight: bold;
						}
					
						.item-m_products > * {
							margin-bottom: 15px;
						}
                    
						.item-m_products:last-child {
							margin-bottom: 0px;
						}
					</style>
			<?php
					$products_num = $conn->query("SELECT * FROM tbl_product WHERE `user_id` = {$_SESSION['login_user_id']} AND `product_archive_status` = 1")->num_rows;
					if($products_num != 0):
			?>
					<div class="grid-container-m_products">
			<?php
                    $products = $conn->query("SELECT * FROM tbl_product WHERE `user_id` = {$_SESSION['login_user_id']} AND `product_archive_status` = 1");
					while($row=$products->fetch_assoc()):
					$txt = $row['product_description'];	
					//(strlen($txt) > 30) ? $txt = substr($txt, 0, 30).'...' : $txt = $txt;
					(empty($row['product_banner'])) ? $src = "../assets/banners/products/placeholder_image.png" : $src = "../assets/banners/products/" . $row['product_banner']; 
			?>
					<div class="item-m_products">
                        <div style="margin-left: 20px;">
                            <img src="<?php echo $src ?>" ids="<?php echo $row['product_id'] ?>" alt="" style=" width: 60px; height: 60px; background:center; background-size: cover; object-fit: cover; border-radius: 5px 5px 5px 5px;"> 
                            <p style="margin-left: 130px;" onclick="showProduct(<?php echo $row['product_id'] ?>)"><?php echo mb_convert_case($row['product_name'], MB_CASE_TITLE, 'UTF-8'); ?></p>
                        </div>
                        <div style="margin-right: 20px;"> 
            <?php
                    ($row['product_stock'] <= 10) ? (($row['product_stock'] < 1) ? $stock = $row['product_stock'] . ' left ( Sold Out )' : $stock = $row['product_stock'] . ' left ( Low Stock )') : $stock = '( ' . $row['product_stock'] . ' left )';
            ?>
                            <p class="pr_stock" style="text-align: right; margin-right: 20px"><?php echo $stock ?></p>
                            <button onclick="editProduct(<?php echo $row['product_id'] ?>)" type="button">Edit Product</button>
                            <img class="archive_product" src="../assets/icons/archive_yellow.png" onclick="archiveProduct(<?php echo $row['product_id'] ?>)" alt="archive">
                        </div>
					</div>
			<?php
					endwhile;
			?>
					</div>
			<?php
					else:
			?>
					<div class="empty_serv" style="text-align: center; box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.5), 0 6px 20px 0 rgba(0, 0, 0, 0.19);; height: auto; position: relative; display: flex; flex-direction: column; justify-content: center;">
							<h3>No Orders Yet...</h3>
					</div>
			<?php
					endif;
			?>
					<script>
						function showProduct(id)
						{
							uni_modal("<center><b>Product Details</b></center></center>",'show_product.php?prod_id='+id+'')
						}
						function editProduct(id)
						{
							uni_modal("<center><b>Edit Product Details</b></center></center>",'edit_product.php?prod_id='+id+'')
						}
                        function archiveProduct(id)
                        {
                            Swal.fire({
                                        confirmButtonText: "Proceed",
                                        showCancelButton: true,
                                        html:
                                            '<h4>Proceed to archive this product?</h4>'
                                    }).then((result) => {
                                            if (result.isConfirmed) {
                                                var formData = {
                                                    user_id: <?php echo $_SESSION['login_user_id'] ?>,
                                                    product_id: id,
                                                };
                                                $.ajax({
                                                    url:"ajax.php?action=archive_product",
                                                    method: 'POST',
                                                    data: formData,
                                                    success:function(resp){
                                                        console.log(resp)
                                                        if(resp == 1){
                                                            setTimeout(function(){
                                                                location.reload()
                                                            },1000)
                                                        }
                                                        if(resp == 2){
                                                            Swal.fire({
                                                                position: 'top',
                                                                icon: 'error',
                                                                title: 'Something went wrong',
                                                                toast: true,
                                                                showConfirmButton: false, 
                                                                timer: 2000
                                                            })
                                                        }
                                                    }
                                                })
                                            }
                            })
                        }
					</script>
            <?php
        //End of showing editing products
                    endif;
                    if(!isset($_GET['edit']) && isset($_GET['my_products']) && !isset($_GET['product_id'])):
        //Start of showing current lensman's products
            ?>
                    <div class="tab2">
                        <button class="tablinks" onclick="location.href='?page=market&manage_products';">Add</button>
                        <button class="tablinks" onclick="location.href='?page=market&manage_products&edit';">Edit</button>
                        <button class="tablinks active" onclick="location.href='?page=market&manage_products&my_products';">My Products </button>
                    </div>

					<style>
						.grid-container-m_products {
							display: grid;
							grid-auto-rows: 1fr;
							grid-gap: 10px;
							box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2), 0 6px 20px 0 rgba(0, 0, 0, 0.19);
							background-color: whitesmoke;
							border-radius: 5px;
							padding: 10px;
							margin-top: 10px;
							height: auto;
						}
					
						.grid-container-m_products > div {
							background-color: #114481;
							font-size: 20px;
							font-weight: bolder;
						}
					
						.item-m_products {
							border-radius: 5px 5px 5px 5px;
                            padding: 10px;
							height: fit-content;
                            display: flex;
                            flex-direction: row;
                            justify-content: space-between;
						}
                    
                        .item-m_products > div {
                            margin-top: auto; margin-bottom: auto; 
                            display: flex; flex-direction: row;
                        }
					
						.item-m_products p {
                            margin-top: auto; 
                            margin-bottom: auto; 
							color: #fed136;
							float: left;
                            width: 270px;
						}
                    
						.item-m_products p:hover {
							cursor: pointer;
						}
					
						.item-m_products button {
							border: none;
                            margin-top: auto; margin-bottom: auto; 
							border-radius: 15px 15px 15px 15px;
							padding: 5px 10px 5px 10px;
							margin-right: 20px;
							background-color: #fed136;
							font-weight: bold;
						}
                    
						.item-m_products:last-child {
							margin-bottom: 0px;
						}
					</style>
			<?php
					$products_num = $conn->query("SELECT * FROM tbl_product WHERE `product_archive_status` = 1 AND `user_id` = {$_SESSION['login_user_id']} ")->num_rows;
					if($products_num != 0):
			?>
					<div class="grid-container-m_products">
			<?php
                    $products = $conn->query("SELECT * FROM tbl_product WHERE `product_archive_status` = 1 AND `user_id` = {$_SESSION['login_user_id']} ");
					while($row=$products->fetch_assoc()):
					$txt = $row['product_description'];	
					//(strlen($txt) > 30) ? $txt = substr($txt, 0, 30).'...' : $txt = $txt;
					(empty($row['product_banner'])) ? $src = "../assets/banners/products/placeholder_image.png" : $src = "../assets/banners/products/" . $row['product_banner']; 
			?>
					<div class="item-m_products">
                        <div style="margin-left: 20px; display: flex; flex-direction: row;">
                            <img src="<?php echo $src ?>" ids="<?php echo $row['product_id'] ?>" alt="" style="margin: 0; width: 60px; height: 60px; background:center; background-size: cover; object-fit: cover; border-radius: 5px 5px 5px 5px;"> 
                            <p style="margin-left: 130px;" onclick="showProduct(<?php echo $row['product_id'] ?>)"><?php echo mb_convert_case($row['product_name'], MB_CASE_TITLE, 'UTF-8'); ?></p>
                        </div>
                        <div>
            <?php
                    ($row['product_stock'] <= 10) ? (($row['product_stock'] < 1) ? $stock = number_format($row['product_stock']) . ' left ( Sold Out )' : $stock = number_format($row['product_stock']) . ' left ( Low Stock )') : $stock = '( ' . number_format($row['product_stock']) . ' left )';
            ?>
                            <p class="pr_stock" style="text-align: right; margin-right: 20px"><?php echo $stock ?></p>
                            <button onclick="location.href='?page=market&manage_products&my_products&product_id=<?php echo $row['product_id'] ?>';" type="button">Show Orders</button>
                        </div>
					</div>
			<?php
					endwhile;
			?>
					</div>
			<?php
					else:
			?>
					<div class="empty_serv" style="text-align: center; box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.5), 0 6px 20px 0 rgba(0, 0, 0, 0.19);; height: auto; position: relative; display: flex; flex-direction: column; justify-content: center;">
							<h3>No Orders Yet...</h3>
					</div>
			<?php
					endif;
			?>
                    <script>
                        function showProduct(id)
						{
							uni_modal("<center><b>Product Details</b></center></center>",'show_product.php?prod_id='+id+'')
						}
                    </script>
            <?php
        //End of showing current lensman's products
                    endif;
                    if(!isset($_GET['edit']) && isset($_GET['my_products']) && isset($_GET['product_id']) && !isset($_GET['print'])):
    //Start of showing managing orders of products
            ?>
                    <style>
                        .product_banner {
							background: #114481;
							border-radius: 5px;
							color: #fed136; 
							padding: 20px;
						}

                        .tab2 {
                            overflow: hidden;
                            background-color: rgba(33, 150, 243, 0.4);
                            border-radius: 50px 50px 50px 50px;
                            display: grid;
                            grid-template-columns: repeat(4, 1fr);
                            margin-bottom: 0px !important;
                        }

                        .tab2 button {
                            background-color: inherit;
                            border: none;
                            outline: none;
                            cursor: pointer;
                            padding: 5px;
                            transition: 0.3s;
                            font-size: 20px;
                            font-weight: bolder;
                        }

                        .tab2 button:hover {
                            background: #114481;
                            color: #fed136;
                        }

                        .tab2 button.active {
                            background: #114481;
                            color: #fed136;
                        }

                        .order-container {
							display: grid;
							grid-auto-rows: 1fr;
							grid-gap: 10px;
							box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2), 0 6px 20px 0 rgba(0, 0, 0, 0.19);
							background-color: whitesmoke;
							border-radius: 5px;
							padding: 10px;
							margin-top: 10px;
							height: auto;
						}
					
						.order-container div {
							background-color: #114481;
							font-size: 20px;
							font-weight: bolder;
                            padding: 10px;
                            
						}
                    
                        .order_item {
                            display: flex;
                            flex-direction: row;
                            justify-content: space-between;
                            background-color: rgba(33, 150, 243, 0.4);
                            border-radius: 5px;
                            padding-top: 10px;
                            padding-bottom: 10px;
                        }
                    
                        .order_item > * {
                            margin-top: auto;
                            margin-bottom: auto;
                            margin-right: 20px;
                        }
                    
                        .order_item_left {
                            display: flex;
                        }
                    
                        .order_item_left > *{
                            margin-top: auto;
                            margin-bottom: auto;
                            margin-right: 16px;
                        }
                    
                        .order_item p:first-of-type {
                            font-size: 25px;
                            font-weight: 500;
                        }
                        
                        .order_item p:not(p:first-of-type) {
                            font-size: 20px;
                        }
                    
                        .order_item button {
                            border: none;
                            background-color: #fed136;
                            font-size: 20px;
                            padding: 5px 15px 5px 15px;
                            border-radius: 20px;
                            font-weight: 600;
                            margin-right: 10px;
                        }
                    
                        .swal2-actions > * {font-weight: bolder !important;}
						.swal2-confirm:focus { box-shadow: none !important; }
						.swal2-confirm { background-color: #114481 !important;  padding: 10px !important;}
						.swal2-cancel { background-color: crimson !important; padding: 10px !important;}
                    
						.showOrderSwalCont {
							font-family: 'Mulish' !important;
						}
					
						.showOrderSwalTitle{
							font-size: 22.5px;
							text-align: left !important;
							color: black;
							margin-top: 0 !important;
						}
                    
						#cancelReason {
							resize: none;
						}
                    </style>
                    <div class="pseudo_center_panel">
                        
                    
            <?php
                    $products = $conn->query("SELECT product_name, product_price FROM tbl_product WHERE `product_id` = {$_GET['product_id']} ");
                    while($row=$products->fetch_assoc())
                    {
                        $product_name = $row['product_name'];
                        $product_price = $row['product_price'];
                    }
            ?>
                    <div>
                        <h3 class="product_banner">
                            <a href="?page=market&manage_products&my_products" style="float: left; color:#fed136;"><i class="fa fa-arrow-left"></i></a>
                            <?php echo '&nbsp&nbsp&nbsp <b>'. $product_name . '</b>'?>
                        </h3>
                    </div>
            <?php
                    if(!isset($_GET['status'])):
            ?>
                        <div class="tab2">
							<button class="tablinks active" onclick="location.href='?page=market&manage_products&my_products&product_id=<?php echo $_GET['product_id']?>';">Pending</button>
							<button class="tablinks" onclick="location.href='?page=market&manage_products&my_products&product_id=<?php echo $_GET['product_id']?>&status=confirmed';">Confirmed</button>
							<button class="tablinks" onclick="location.href='?page=market&manage_products&my_products&product_id=<?php echo $_GET['product_id']?>&status=completed';">Completed</button>
                            <button class="tablinks" onclick="location.href='?page=market&manage_products&my_products&product_id=<?php echo $_GET['product_id']?>&status=cancelled';">Cancelled</button>
						</div>
                        <div class="main_panel" style="height: 84%; overflow-y: auto;">
                        <div class="order-container">
            <?php
                    $orders = $conn->query("SELECT * FROM tbl_order as o LEFT JOIN tbl_user_account as u ON o.user_id = u.user_id WHERE `product_id` = {$_GET['product_id']} AND order_status = 0");
                    while($o_rows=$orders->fetch_assoc()):
                    (empty($o_rows['user_profile_image'])) ? $src = "../assets/banners/products/placeholder_image.png" : $src = "../../" . $o_rows['user_profile_image']; 
            ?>  
                    
                        <div class="order_item">
                            <div class="order_item_left" style="color:#fed136; font-weight: normal;">
                                <img src="<?php echo $src?>" alt="" style="margin-left: 30px; border-radius: 50%; width: 60px; height: 60px; object-fit: cover;">
                                <p style="width: 240px;"><?php echo ucwords($o_rows['user_first_name'] . ' ' . $o_rows['user_last_name']) ?></p>
                                <p>Qty: <?php echo $o_rows['order_quantity'] ?></p>
                                <p>Total Price: <?php echo '₱ ' . number_format($product_price * $o_rows['order_quantity']) ?></p>
                                <p>Status: Pending</p>
                            </div>
                            <div class="order_item_right">
                                <button onclick="confirmOrder(<?php echo $o_rows['order_id'] ?>, <?php echo $o_rows['user_id'] ?>)">Confirm</button>
                                <button onclick="cancelOrder(<?php echo $o_rows['order_id'] ?>, <?php echo $o_rows['user_id'] ?>)">Cancel</button>
                            </div>
                        </div>
            <?php
                    endwhile;
            ?>
                        </div>
                        </div>
            <?php
                    endif;
                    if(isset($_GET['status'])):
                    if($_GET['status']=="confirmed"):
        //Start of showing orders in confirmed state
            ?>
                        <div class="tab2">
							<button class="tablinks" onclick="location.href='?page=market&manage_products&my_products&product_id=<?php echo $_GET['product_id']?>';">Pending</button>
							<button class="tablinks active" onclick="location.href='?page=market&manage_products&my_products&product_id=<?php echo $_GET['product_id']?>&status=confirmed';">Confirmed</button>
							<button class="tablinks" onclick="location.href='?page=market&manage_products&my_products&product_id=<?php echo $_GET['product_id']?>&status=completed';">Completed</button>
                            <button class="tablinks" onclick="location.href='?page=market&manage_products&my_products&product_id=<?php echo $_GET['product_id']?>&status=cancelled';">Cancelled</button>
						</div>
                        <div class="main_panel" style="height: 84%; overflow-y: auto;">
                        <div class="order-container">
            <?php
                    $orders = $conn->query("SELECT * FROM tbl_order as o LEFT JOIN tbl_user_account as u ON o.user_id = u.user_id WHERE `product_id` = {$_GET['product_id']} AND order_status = 1");
                    while($o_rows=$orders->fetch_assoc()):
                    (empty($o_rows['user_profile_image'])) ? $src = "../assets/banners/products/placeholder_image.png" : $src = "../../" . $o_rows['user_profile_image']; 
            ?>
                        <div class="order_item">
                            <div class="order_item_left" style="color:#fed136; font-weight: normal;">
                                <img src="<?php echo $src?>" alt="" style="margin-left: 30px; border-radius: 50%; width: 60px; height: 60px; object-fit: cover;">
                                <p style="width: 240px;"><?php echo ucwords($o_rows['user_first_name'] . ' ' . $o_rows['user_last_name']) ?></p>
                                <p>Qty: <?php echo $o_rows['order_quantity'] ?></p>
                                <p>Total Price: <?php echo '₱ ' . number_format($product_price * $o_rows['order_quantity']) ?></p>
                                <p>Status: Confirmed</p>
                            </div>
                            <div class="order_item_right">
                                <button onclick="location.href='?page=market&manage_products&my_products&product_id=<?php echo $_GET['product_id'] ?>&order_id=<?php echo $o_rows['order_id'] ?>&print';">Show Receipt</button>
                                <button onclick="completeOrder(<?php echo $o_rows['order_id'] ?>, <?php echo $o_rows['user_id'] ?>)">Complete</button>
                                <button onclick="cancelOrder(<?php echo $o_rows['order_id'] ?>, <?php echo $o_rows['user_id'] ?>)">Cancel</button>
                            </div>
                        </div>
            <?php
                    endwhile;
            ?>
                        </div>
                        </div>
            <?php
        //End of showing orders in confirmed state
                    endif;
                    if($_GET['status']=="completed"):
        //Start of showing orders in completed state
            ?>
                        <div class="tab2">
                            <button class="tablinks" onclick="location.href='?page=market&manage_products&my_products&product_id=<?php echo $_GET['product_id']?>';">Pending</button>
                            <button class="tablinks" onclick="location.href='?page=market&manage_products&my_products&product_id=<?php echo $_GET['product_id']?>&status=confirmed';">Confirmed</button>
                            <button class="tablinks active" onclick="location.href='?page=market&manage_products&my_products&product_id=<?php echo $_GET['product_id']?>&status=completed';">Completed</button>
                            <button class="tablinks" onclick="location.href='?page=market&manage_products&my_products&product_id=<?php echo $_GET['product_id']?>&status=cancelled';">Cancelled</button>
                        </div>
                        <div class="main_panel" style="height: 84%; overflow-y: auto;">
                        <div class="order-container">
            <?php
                    $orders = $conn->query("SELECT * FROM tbl_order as o LEFT JOIN tbl_user_account as u ON o.user_id = u.user_id WHERE `product_id` = {$_GET['product_id']} AND order_status = 2");
                    while($o_rows=$orders->fetch_assoc()):
                    (empty($o_rows['user_profile_image'])) ? $src = "../assets/banners/products/placeholder_image.png" : $src = "../../" . $o_rows['user_profile_image']; 
            ?>
                        <div class="order_item">
                            <div class="order_item_left" style="color:#fed136; font-weight: normal;">
                                <img src="<?php echo $src?>" alt="" style="margin-left: 30px; border-radius: 50%; width: 60px; height: 60px; object-fit: cover;">
                                <p style="width: 240px;"><?php echo ucwords($o_rows['user_first_name'] . ' ' . $o_rows['user_last_name']) ?></p>
                                <p>Qty: <?php echo $o_rows['order_quantity'] ?></p>
                                <p>Total Price: <?php echo '₱ ' . number_format($product_price * $o_rows['order_quantity']) ?></p>
                                <p>Status: Completed</p>
                            </div>
                            <div class="order_item_right">
                                <button onclick="location.href='?page=market&manage_products&my_products&product_id=<?php echo $_GET['product_id'] ?>&order_id=<?php echo $o_rows['order_id'] ?>&print';">Show Receipt</button>
                            </div>
                        </div>
            <?php
                    endwhile;
            ?>
                        </div>
                        </div>
            <?php
        //End of showing orders in completed state
                    endif;
                    if($_GET['status']=="cancelled"):
        //Start of showing orders in cancelled state
            ?>
                        <div class="tab2">
                            <button class="tablinks" onclick="location.href='?page=market&manage_products&my_products&product_id=<?php echo $_GET['product_id']?>';">Pending</button>
                            <button class="tablinks" onclick="location.href='?page=market&manage_products&my_products&product_id=<?php echo $_GET['product_id']?>&status=confirmed';">Confirmed</button>
                            <button class="tablinks" onclick="location.href='?page=market&manage_products&my_products&product_id=<?php echo $_GET['product_id']?>&status=completed';">Completed</button>
                            <button class="tablinks active" onclick="location.href='?page=market&manage_products&my_products&product_id=<?php echo $_GET['product_id']?>&status=cancelled';">Cancelled</button>
                        </div>
                        <div class="main_panel" style="height: 84%; overflow-y: auto;">
                        <div class="order-container">
            <?php
                    $orders = $conn->query("SELECT * FROM tbl_order as o LEFT JOIN tbl_user_account as u ON o.user_id = u.user_id WHERE `product_id` = {$_GET['product_id']} AND order_status = 3");
                    while($o_rows=$orders->fetch_assoc()):
                    (empty($o_rows['user_profile_image'])) ? $src = "../assets/banners/products/placeholder_image.png" : $src = "../../" . $o_rows['user_profile_image']; 
            ?>
                        <div class="order_item">
                            <div class="order_item_left" style="color:#fed136; font-weight: normal;">
                                <img src="<?php echo $src?>" alt="" style="margin-left: 30px; border-radius: 50%; width: 60px; height: 60px; object-fit: cover;">
                                <p style="width: 240px;"><?php echo ucwords($o_rows['user_first_name'] . ' ' . $o_rows['user_last_name']) ?></p>
                                <p>Qty: <?php echo $o_rows['order_quantity'] ?></p>
                                <p>Total Price: <?php echo '₱ ' . number_format($product_price * $o_rows['order_quantity']) ?></p>
                                <p>Status: Cancelled</p>
                            </div>
                            <div class="order_item_right">
                                <p id="order<?php echo $o_rows['order_id'] ?>" style="display: none;"><?php echo $o_rows['order_cancel_reason'] ?></p>
                                <button onclick="showReason(<?php echo $o_rows['order_id'] ?>)">Show Reason</button>
                            </div>
                        </div>
            <?php
                    endwhile;
            ?>
                        </div>
                        </div>
            <?php
        //End of showing orders in cancelled state
                    endif;
                    endif;
            ?>
                    </div>
                    <script>
                        function confirmOrder(order_id, user_id)
                        {
                            Swal.fire({
                                        confirmButtonText: "Proceed",
                                        showCloseButton: true,
                                        html:
                                            '<h4>Proceed to confirm this order?</h4>'
                                    }).then((result) => {
                                            if (result.isConfirmed) {
                                                var formData = {
                                                    order_id: order_id,
                                                	//receiver is the one who gonna receive the notification, 
                                                	//in this case it will be the customer who will receive the notification
                                                    notification_receiver: user_id,
                                                };
                                                $.ajax({
                                                    url:"ajax.php?action=confirm_order_lm",
                                                    method: 'POST',
                                                    data: formData,
                                                    success:function(resp){
                                                        console.log(resp)
                                                        if(resp == 1){
                                                            setTimeout(function(){
                                                                location.reload()
                                                            },1000)
                                                        }
                                                        if(resp == 2){
                                                            Swal.fire({
                                                                position: 'top',
                                                                icon: 'error',
                                                                title: 'Something went wrong',
                                                                toast: true,
                                                                showConfirmButton: false, 
                                                                timer: 2000
                                                            })
                                                        }
                                                    }
                                                })
                                            }
                            })
                        }

                        function completeOrder(order_id, user_id)
                        {
                            Swal.fire({
                                        confirmButtonText: "Proceed",
                                        showCloseButton: true,
                                        html:
                                            '<h4>Proceed to complete this order?</h4>'
                                    }).then((result) => {
                                            if (result.isConfirmed) {
                                                var formData = {
                                                    order_id: order_id,
                                                	//receiver is the one who gonna receive the notification, 
                                                	//in this case it will be the customer who will receive the notification
                                                    notification_receiver: user_id,
                                                };
                                                $.ajax({
                                                    url:"ajax.php?action=complete_order_lm",
                                                    method: 'POST',
                                                    data: formData,
                                                    success:function(resp){
                                                        console.log(resp)
                                                        if(resp == 1){
                                                            setTimeout(function(){
                                                                location.reload()
                                                            },1000)
                                                        }
                                                        if(resp == 2){
                                                            Swal.fire({
                                                                position: 'top',
                                                                icon: 'error',
                                                                title: 'Something went wrong',
                                                                toast: true,
                                                                showConfirmButton: false, 
                                                                timer: 2000
                                                            })
                                                        }
                                                    }
                                                })
                                            }
                            })
                        }

                        function cancelOrder(order_id, user_id)
                        {
                            /*Swal.fire({
                                        confirmButtonText: "Proceed",
                                        showCancelButton: true,
                                        html:
                                            '<h4>Proceed to cancel this order?</h4>'
                                    }).then((result) => {
                                            if (result.isConfirmed) {
                                                $.ajax({
                                                    url:"ajax.php?action=cancel_order_lm",
                                                    method: 'POST',
                                                    data: {order_id:id},
                                                    success:function(resp){
                                                        console.log(resp)
                                                        if(resp == 1){
                                                            setTimeout(function(){
                                                                location.reload()
                                                            },1000)
                                                        }
                                                        if(resp == 2){
                                                            Swal.fire({
                                                                position: 'top',
                                                                icon: 'error',
                                                                title: 'Something went wrong',
                                                                toast: true,
                                                                showConfirmButton: false, 
                                                                timer: 2000
                                                            })
                                                        }
                                                    }
                                                })
                                            }
                            })*/
                            Swal.fire({
                                customClass: {
                                    container: 'showOrderSwalCont',
                                    title: 'showOrderSwalTitle',
                                },
                                title: "Order Cancellation",
                                confirmButtonText: "Submit",
                                showCloseButton: true,
                                allowOutsideClick: false,
                                html:
                                    '<textarea id="cancelReason" rows=10 cols=40 placeholder="Please enter your reason here for your cancellation...">'+
									'</textarea>',
                                preConfirm: () => {
                                    var id = document.getElementById("cancelReason");
                                    var value = id.value;
                                    if (value.trim().length > 0) {

                                    } else { 
                                        Swal.showValidationMessage('Please do not leave the input empty') 
                                    }
                                }
                            }).then(function(result) {
                                if(result.isConfirmed)
                                {
                                    var text = document.getElementById("cancelReason");
									var value = text.value;
                                    //alert(value+' '+order_id+' '+user_id)
                                    
                                    var formData = {
                                        order_id: order_id,
                                    	//receiver is the one who gonna receive the notification, 
                                    	//in this case it will be the customer who will receive the notification
                                        notification_receiver: user_id,
                                        order_cancel_reason: value,
                                    };
                                    start_load()
                                    $.ajax({
                                        url:"ajax.php?action=cancel_order_lm",
                                        method: 'POST',
                                        data: formData,
                                        success:function(resp){
                                            console.log(resp)
                                            end_load()
                                            if(resp == 1){
                                                alert_toast("Order successfully updated",'success')
                                                setTimeout(function(){
                                                    location.reload()
                                                },1500)
                                            }
                                            if(resp == 2){
                                                alert_toast("Something went wrong..",'error')
                                                setTimeout(function(){
                                                    location.reload()
                                                },1500)
                                            }
                                        }
                                    })
                                }
                            })
                        }

                        function showReason(id)
                        {
                            var content = document.getElementById('order' + id).textContent;
                            Swal.fire({
                                showConfirmButton: false,
                                showCloseButton: true,
                                html:
                                    '<h2><b>Reason of Cancellation</b></h2>' +
                                    '<h3 style="font-size 30px;">"'+ content +'"</h3>'
                            })
                        }
                    </script>
            <?php
    //End of showing managing orders of products
                    endif;
                    if(!isset($_GET['edit']) && isset($_GET['my_products']) && isset($_GET['product_id']) && isset($_GET['order_id']) && isset($_GET['print'])):
        //Start of showing printing of invoice for the order
            ?>
                    <style>
						.print_banner {
                            display: flex;
                            flex-direction: row;
                            justify-content: space-between;
                            background: #114481;
                            border-radius: 5px;
                            color: #fed136;
                            padding: 10px 20px 10px 20px;
                            margin-bottom: 20px;
                        }
                        .print_banner h3 {
                            margin-top: auto;
                            margin-bottom: auto;
                            font-weight: 600;
                        }
                        .print_banner button {
                            border: none;
                            background-color: #fed136;
                            font-size: 20px;
                            padding: 5px 15px 5px 15px;
                            border-radius: 20px;
                            font-weight: 600;
                        }
						.receipt_div {
							height: 80%;
							overflow-y: auto;
						}
						.receipt_div::-webkit-scrollbar {
							display: none;
						}
					</style>
            <?php
                    $products = $conn->query("SELECT product_name, product_price FROM tbl_product WHERE `product_id` = {$_GET['product_id']} ");
                    while($row=$products->fetch_assoc())
                    {
                        $product_name = $row['product_name'];
                        $product_price = $row['product_price'];
                    }
            ?>
						<div class="print_banner">
							<h3>
                            <a href="?page=market&manage_products&my_products&product_id=<?php echo $_GET['product_id'] ?>" style="float: left; color:#fed136;"><i class="fa fa-arrow-left"></i></a>
								<?php echo '&nbsp&nbsp&nbsp'. $product_name?> Receipt, Order No. <?php echo $_GET['order_id'] ?>
							</h3>
                            <button onclick="var p = window.open('../Print/invoice_prod.php?product_id=<?php echo $_GET['product_id'] ?>&order_id=<?php echo $_GET['order_id'] ?>');">Print</button>
						</div>
                        
						<div class="receipt_div">
				<?php
						include "../Print/print_prod.php";
				?>
						</div>
            <?php
        //End of showing printing of invoice for the order
                    endif;
    //End of showing adding/managing own products
                    endif;
            ?>
                </div>
            </div>
        </div>
    </div>