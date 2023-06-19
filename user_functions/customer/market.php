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
                    if(!isset($_GET['product']) && !isset($_GET['cart']) && !isset($_GET['my_orders']) && !isset($_GET['history'])): /*location.href='?page=service&l_id=<?php //echo $_GET['l_id']?>&action=add_service';*/
        //Start of showing all products
            ?>
                    <style>
                        .tab {
                            overflow: hidden;
                            background-color: rgba(33, 150, 243, 0.4);
                            border-radius: 50px 50px 50px 50px;
                            display: grid;
                            grid-template-columns: repeat(4, 1fr);
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
                            cursor: pointer;
                        }
                        .item-products:hover {
                            transform: scale(1.03);
                            transition: .5s;
                            box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.5), 0 6px 20px 0 rgba(0, 0, 0, 0.19);
                            background-color: #08204b;
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
                        <button class="tablinks" onclick="location.href='?page=market&cart';">My Cart</button>
                        <button class="tablinks" onclick="location.href='?page=market&my_orders';">My Order/s</button>
                        <button class="tablinks" onclick="location.href='?page=market&history';">History</button>
                    </div>  
                    <div class="grid-container-products">
            <?php
                    $products = $conn->query("SELECT * FROM `tbl_product`");
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
                        <p style="font-size: 18px;"><img src="../assets/icons/stock-icon.png" style="width: 30px; height:auto; margin-right: 5px;"><?php echo $stock ?></p>
                    </div>
            <?php
                    endwhile;
            ?>
                        </div>
            <?php
        //End of showing all products
                    endif;
                    if(isset($_GET['product']) && !isset($_GET['cart']) && !isset($_GET['my_orders']) && !isset($_GET['history'])): /*location.href='?page=service&l_id=<?php //echo $_GET['l_id']?>&action=add_service';*/
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
                            <form id="manage_cart" action="javascript:void(0);" class="addToCartForm">
                                <input type="hidden" name="seller_id" id="seller_id" value="<?php echo $row['user_id'] ?>">
                                <input type="hidden" name="user_id" id="user_id" value="<?php echo $_SESSION['login_user_id'] ?>">
                                <div class="cartInput">
                                    <label for="cart_quantity">Quantity</label>
                                    <input type="number" name="cart_quantity" id="cart_quantity">
                                </div>
                                <div class="cartButtons">
                                    <button id="cart_submit" form="manage_cart">Add to Cart</button>
                                    <button id="order_submit" form="manage_cart">Buy Now</button>
                                </div>
                            </form>
                        </div>
                        <div class="p_review">
            <?php
                            $order_num = $conn->query("SELECT * FROM `tbl_order` WHERE product_id = {$_GET['product']} AND user_id = {$_SESSION['login_user_id']} AND order_status = 2")->num_rows;
                            ($order_num==0) ? $btn_state = '<button type="button" onclick="noInfo()">Review</button>' : $btn_state = '<button type="button" onclick="reviewProduct('.$_GET['product'].')">Review</button>';
                            echo $btn_state;
            ?>
                            <button onclick="location.href='customer_dashboard.php?page=messages&id=<?php echo $row['user_id'] ?>';">Chat Seller</button>
                        </div>
                    </div>
                    <script>
                        function inRange(x, min, max) {
                            return ((x-min)*(x-max) <= 0);
                        }
                        $('#cart_submit').click(function(){
                            cart_quantity = $("#cart_quantity").val();
                            var content = document.getElementById('product' + <?php echo $_GET['product'] ?>).textContent;
                            current_stock = content;
                            if(cart_quantity.trim() != "")
                            {
                                if(current_stock != 0)
                                {
                                    if(inRange(cart_quantity, 1, content))
                                    {
                                        var formData = {
                                            cart_quantity: $("#cart_quantity").val(),
                                            user_id: $("#user_id").val(),
                                            product_id: '<?php echo $_GET['product'] ?>',
                                        };
                                        start_load()
                                        $.ajax({
                                            url:"ajax.php?action=save_cart",
                                            method: 'POST',
                                            data: formData,
                                            success:function(resp){
                                                console.log(resp)
                                                end_load()
                                                if(resp == 1){
                                                    alert_toast("Added to cart", "success", "top")
                                                }
                                                if(resp == 2){
                                                    alert_toast("Item is already in the cart", "error", "top")
                                                }
                                            }
                                        })
                                    }
                                    else
                                    {
                                        alert_toast("Quantity given exceeded current stock", "error", "top")
                                    }
                                }
                                else
                                {
                                    alert_toast("No more stocks left", "error", "top")
                                }
                            }
                            else 
                            {
                                alert_toast("Please provide quantity", "error", "top")
                            }
                        })
                        $('#order_submit').click(function(){
                            cart_quantity = $("#cart_quantity").val();
                            var content = document.getElementById('product' + <?php echo $_GET['product'] ?>).textContent;
                            current_stock = content;
                            if(cart_quantity.trim() != "")
                            {
                                if(current_stock != 0)
                                {
                                    if(inRange(cart_quantity, 1, content))
                                    {
                                        Swal.fire({
                                            confirmButtonText: "Proceed",
                                            showCancelButton: true,
                                            html:
                                                '<h4>Proceed to order the item?</h4>'
                                        }).then((result) => {
                                                if (result.isConfirmed) {
                                                    var formData = { 
                                                        user_id: <?php echo $_SESSION['login_user_id'] ?>,
                                                        order_quant:$("#cart_quantity").val(),
                                                        prod_id: <?php echo $_GET['product'] ?>,
                                                        //receiver is the one who gonna receive the notification, 
                                            	        //in this case it will be the customer who will receive the notification
                                                        notification_receiver: $("#seller_id").val(),
                                                    };
                                                    $.ajax({
                                                        url:"ajax.php?action=buy_now",
                                                        method: 'POST',
                                                        data: formData,
                                                        success:function(resp){
                                                            console.log(resp)
                                                            if(resp == 1){
                                                                alert_toast("Added to your Order", "success", "top")
                                                                setTimeout(function(){
                                                                    location.href='customer_dashboard.php?page=market&my_orders';
                                                                },1500)
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
                                    else
                                    {
                                        alert_toast("Quantity given exceeded current stock", "error", "top")
                                    }
                                }
                                else
                                {
                                    alert_toast("No more stocks left", "error", "top")
                                }
                            }
                            else 
                            {
                                alert_toast("Please provide quantity", "error", "top")
                            }
                        })
                        function noInfo()
                        {
                            alert_toast("No review privileges, please buy one first", "error", "top-end")
                        }
                        function reviewProduct(id)
                        {
                            uni_modal("<center><b>Review Product</b></center></center>",'create_review_prod.php?prod_id='+id+'')
                        }
                    </script>
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
                                    <img src="../../images/profile-images/<?php echo $u_row['user_profile_image'] ?>" style="float:left; border-radius: 90%; width:50px; height:50px; background: center; background-size: cover; object-fit: cover;"/> 
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
                        <img src="../../images/profile-images/<?php echo $u_row['user_profile_image'] ?>" style="float:left; border-radius: 90%; width:50px; height:50px; background: center; background-size: cover; object-fit: cover;"/> 
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
        //End of showing all feedbacks
                        endif;
        
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
                    if(!isset($_GET['product']) && isset($_GET['cart']) && !isset($_GET['my_orders']) && !isset($_GET['history'])):
        //Start of showing current user's cart
            ?>
                    <style>
                        .tab {
                            overflow: hidden;
                            background-color: rgba(33, 150, 243, 0.4);
                            border-radius: 50px 50px 50px 50px;
                            display: grid;
                            grid-template-columns: repeat(4, 1fr);
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
                    
                        .cart_catalogue {
                            height: 35vw;
                            overflow-y: auto;
                            margin-bottom: 20px;
                        }
                        .cart_catalogue::-webkit-scrollbar {
                            display: none;
                        }
                    
                        .store_name {
                            display: flex;
                            background-color: #114481;
                            color: #fed136;
                            padding: 10px 20px 10px 20px;
                            border-radius: 10px;
                        }
                    
                        .store_name > * {
                            margin-right: 15px;
                        }
                    
                        .store_name input {
                            accent-color: #fed136;
                            transform : scale(1.5);
                        }
                    
                        .store_name h3 {
                            font-weight: 600;
                            margin: 0px;
                        }
                    
                        .cart_items {
                            display: flex;
                            padding: 5px;
                            border-radius: 5px;
                            margin: 10px 10px 10px 50px;
                        }
                    
                        .cart_items > * {
                            margin-top: auto;
                            margin-bottom: auto;
                            margin-right: 15px;
                        }
                    
                        .cart_items .cart_img_name {
                            display: flex;
                            width: calc(45%);
                        }
                    
                        .cart_img_name > * {
                            margin-top: auto;
                            margin-bottom: auto;
                            margin-right: 30px;
                        }
                    
                        .cart_img_name input {
                            margin-left: 30px;
                            accent-color: #114481;
                            transform : scale(1.5);
                        }
                    
                        .cart_img_name input:hover {
                            cursor: pointer;
                        }
                    
                        .cart_img_name img {
                            width: 70px;
                            height: 70px;
                            object-fit: cover;
                            border: 1px solid grey;
                        }
                    
                        .cart_img_name .pr_name {
                            width: calc(45%);
                            font-size: 20px;
                            font-weight: 600;
                        }
                        .cart_img_name .pr_price {
                            width: calc(20%);
                            font-size: 20px;
                            font-weight: 600;
                        }
                    
                        .cart_items .pr_stock {
                            font-weight:  bold;
                            font-size: 20px;
                            width: calc(10%);
                            text-align: center;
                        }
                    
                        .cart_items .addminus_cont {
                            text-align: center;
                            width: calc(15%);
                        }
                    
                        .addminus {
                            display: flex;
                        }
                    
                        .addminus > * {
                            font-weight: bold;
                            margin-top: auto;
                            margin-bottom: auto;
                            font-size: 20px;
                            width: 45px;
                        }
                        
                        .minus, .plus {
                            font-weight: 600;
                            
                        }
                    
                        .addminus .minus:hover, .addminus .plus:hover {
                            cursor: pointer;
                            color: #114481;
                            background-color: rgba(0, 0, 0, 0.05);
                        }
                    
                        .cart_items .total_price {
                            display: flex;
                            font-size: 20px;
                            font-weight: 600;
                            width: calc(20%);
                            text-align: center;
                        }
                    
                        .total_price > * {
                            margin-top: auto;
                            margin-bottom: auto;
                        }
                    
                        .total_price p:nth-child(1) {
                            margin-right: 30px;
                        }
                    
                        .confirm_order {
                            display: flex;
                            flex-direction: row;
                            justify-content: space-between;
                            background-color: #114481;
                            color: #fed136;
                            padding: 10px 20px 10px 20px;
                            border-radius: 5px;
                        }
                    
                        .confirm_order h3 {
                            margin: auto;
                        }
                    
                        .no_stock {
                            background-color: rgba(0, 0, 0, 0.19);
                        }
                    
                        .confirm_order button {
                            background-color: #fed136;
                            color: #114481;
                            border: none;
                            border-radius: 5px;
                            font-size: 20px;
                            font-weight: 600;
                        }
                    </style>
                    <div class="tab">
                        <button class="tablinks" onclick="location.href='?page=market';">Products</button>
                        <button class="tablinks active" onclick="location.href='?page=market&cart';">My Cart</button>
                        <button class="tablinks" onclick="location.href='?page=market&my_orders';">My Order/s</button>
                        <button class="tablinks" onclick="location.href='?page=market&history';">History</button>
                    </div>  
                    <div class="cart_catalogue">
            <?php
                    $store = $conn->query("SELECT pr.user_id as seller, u.user_studio_name FROM tbl_cart as c LEFT JOIN tbl_product as pr ON c.product_id = pr.product_id RIGHT JOIN tbl_user_account as u ON pr.user_id = u.user_id WHERE c.user_id = {$_SESSION['login_user_id']} AND c.cart_status = 0 GROUP BY pr.user_id");
                    while($store_row=$store->fetch_assoc()):
            ?>
                    <div class="cart">
                        <div class="store_name">
                            <!--<input type="checkbox" id="store_<?php echo $store_row['seller'] ?>" name="store_<?php echo $store_row['seller'] ?>">-->
                            <h3 ><?php echo $store_row['user_studio_name'] ?></h3>
                        </div>
            <?php
                    $cart_prod = $conn->query("SELECT c.cart_id, c.cart_quantity, c.product_id, pr.product_name, pr.product_price, pr.product_stock, pr.product_banner FROM tbl_cart as c LEFT JOIN tbl_product as pr ON c.product_id = pr.product_id WHERE pr.user_id = {$store_row['seller']} AND c.user_id = {$_SESSION['login_user_id']} AND c.cart_status = 0"); 
                    while($row=$cart_prod->fetch_assoc()):
                    $total = $row['product_price'] * $row['cart_quantity'];
                    if($row['product_stock'] >= $row['cart_quantity']):
            ?>
                    <div class="cart_items">
                        <div class="cart_img_name">
                            <input id="chkbox<?php echo $row['cart_id'] ?>" class="custom-checkbox cart_check" type="checkbox" data-cart_id="<?php echo $row['cart_id'] ?>" data-cart_quantity="<?php echo $row['cart_quantity'] ?>" data-product_id="<?php echo $row['product_id'] ?>" data-notification_receiver_id="<?php echo $store_row['seller'] ?>" value="<?php echo $total ?>">
                            <img src="../assets/banners/products/<?php echo $row['product_banner'] ?>" alt="">
                            <p class="pr_name"><?php echo $row['product_name'] ?></p>
                            <p class="pr_price"><?php echo '₱ ' . number_format($row['product_price']) ?></p>
                        </div>
                        <div class="addminus_cont">
                            <div class="addminus">
                                <p class="minus" id="minus<?php echo $row['cart_id'] ?>" onclick="minusQuant(<?php echo $row['product_stock']?>, <?php echo $row['product_id']?>, <?php echo $row['cart_id'] ?>);">-</p>
                                <p id="current_cart_quant<?php echo $row['cart_id'] ?>"><?php echo $row['cart_quantity'] ?></p>
                                <p class="plus" id="plus<?php echo $row['cart_id'] ?>" onclick="plusQuant(<?php echo $row['product_id']?>, <?php echo $row['cart_id'] ?>);">+</p>
                            </div>
                        </div>
                        <div class="total_price">
                            <p>Sub Total: </p>
                            <p id="current_cart_total<?php echo '₱ ' . $row['cart_id'] ?>">₱ <?php echo number_format($total) ?></p>
                        </div>
            <?php
                        ($row['product_stock'] <= 10) ? (($row['product_stock'] < 1) ? $stock = $row['product_stock'] . ' left ( Sold Out )' : $stock = $row['product_stock'] . ' left ( Low Stock )') : $stock = '( ' . $row['product_stock'] . ' left )';
            ?>
                        <p class="pr_stock"><?php echo $stock ?></p>
                    
                        <img style="width: 40px; height: 40px; cursor: pointer;" onclick="deleteCartItem(<?php echo $row['cart_id'] ?>)" src="../assets/icons/remove.png" alt="">
                    </div>
            <?php
                    else:
            ?>
                    <div class="cart_items no_stock">
                        <div class="cart_img_name">
                            <input id="chkbox<?php echo $row['cart_id'] ?>" class="custom-checkbox cart_check" type="checkbox" data-cart_quantity="<?php echo $row['cart_quantity'] ?>" disabled>
                            <img src="../assets/banners/products/<?php echo $row['product_banner'] ?>" alt="">
                            <p class="pr_name"><?php echo $row['product_name'] ?></p>
                        </div>
                        <div class="addminus_cont">
                            <div class="addminus">
                                <p class="minus" id="minus<?php echo $row['cart_id'] ?>" onclick="minusQuant(<?php echo $row['product_stock']?>, <?php echo $row['product_id']?>, <?php echo $row['cart_id'] ?>);">-</p>
                                <p id="current_cart_quant<?php echo $row['cart_id'] ?>"><?php echo $row['cart_quantity'] ?></p>
                                <p class="plus" id="plus<?php echo $row['cart_id'] ?>" onclick="plusQuant(<?php echo $row['product_id']?>, <?php echo $row['cart_id'] ?>);">+</p>
                            </div>
                        </div>
                        <div class="total_price">
                            <p>Total Price:</p>
                            <p id="current_cart_total<?php echo $row['cart_id'] ?>">₱ <?php echo number_format($total) ?></p>
                        </div>
                        
                        <p class="pr_stock">( <?php echo $row['product_stock'] ?> left )</p>
                        <img style="width: 40px; height: 40px; cursor: pointer;" onclick="deleteCartItem(<?php echo $row['cart_id'] ?>)" src="../assets/icons/trash.png" alt="">
                    </div>
            <?php
                    endif;
                    endwhile;
            ?>
                    </div>
                    
            <?php
                    endwhile;
            ?>
                    </div>
                    <div class="confirm_order">
                        <div>
                            
                            <div style="display: none;" id="customProductPricing">0</div>
                            <h3 id="priceSection">Overall Total: </h3>
                        </div>
                        <div>
                            <form id="manage_order" action="javascript:void(0);" class="confirmOrderForm">
                                <input type="hidden" id="cart_id_list" name="cart_id_list" value="" />
                                <input type="hidden" id="cart_quantity_list" name="cart_quantity_list" value="" />
                                <input type="hidden" id="product_id_list" name="product_id_list" value="" />
                                <input type="hidden" id="notification_receiver_id_list" name="notification_receiver_id_list" value="" />
                                <button id="order_submit" form="manage_order">Confirm Order</button>
                            </form>
                        </div>
                    </div>
                    <script>
                        function minusQuant(product_stock, product_id, cart_id)
                        {
                            //alert("minus "+id)
                            $.ajax({
                                url:"ajax.php?action=minus_quant",
                                method: 'POST',
                                data: {product_id: product_id, cart_id:cart_id,},
                                success:function(resp){
                                    console.log(resp)
                                    res = JSON.parse(resp)
                                    if(res.result == 1){
                                        //setTimeout(function(){
                                            location.reload()
                                        //},1500)
                                        /*document.getElementById("chkbox"+cart_id+"").setAttribute('data-cart_quantity', res.cart_quantity);
                                        document.getElementById("current_cart_quant"+cart_id+"").innerHTML = res.cart_quantity;
                                        document.getElementById("current_cart_total"+cart_id+"").innerHTML = "₱ " + res.subtotal;
                                        document.getElementById("chkbox"+cart_id+"").value = res.subtotal;
                                        if(product_stock == res.cart_quantity)
                                        {
                                            location.reload()
                                        }*/
                                    }
                                    if(res.result == 2){
                                        Swal.fire({
                                            position: 'top',
                                            icon: 'error',
                                            title: 'Something went wrong',
                                            toast: true,
                                            showConfirmButton: false, 
                                            timer: 2000
                                        })
                                    }
                                    if(res.result == 3){
                                        Swal.fire({
                                            position: 'top',
                                            icon: 'error',
                                            title: 'Quantity shouldnt be zero',
                                            toast: true,
                                            showConfirmButton: false, 
                                            timer: 2000
                                        })
                                    }
                                }
                            })
                        }
                    
                            function plusQuant(product_id, cart_id)
                            {
                                //alert("plus "+id)
                                $.ajax({
                                    url:"ajax.php?action=plus_quant",
                                    method: 'POST',
                                    data: {product_id: product_id, cart_id:cart_id,},
                                    success:function(resp){
                                        console.log(resp)
                                        res = JSON.parse(resp)
                                        if(res.result == 1){
                                            //setTimeout(function(){
                                                location.reload()
                                            //},1500)
                                            /*document.getElementById("chkbox"+cart_id+"").setAttribute('data-cart_quantity', res.cart_quantity);
                                            document.getElementById("current_cart_quant"+cart_id+"").innerHTML = res.cart_quantity;
                                            document.getElementById("current_cart_total"+cart_id+"").innerHTML = "₱ " + res.subtotal;
                                            document.getElementById("chkbox"+cart_id+"").value = res.subtotal;*/
                                        }
                                        if(res.result == 2){
                                            Swal.fire({
                                                position: 'top',
                                                icon: 'error',
                                                title: 'Something went wrong',
                                                toast: true,
                                                showConfirmButton: false, 
                                                timer: 2000
                                            })
                                        }
                                        if(res.result == 3){
                                            Swal.fire({
                                                position: 'top',
                                                icon: 'error',
                                                title: 'Quantity shouldnt be greater than current stock',
                                                toast: true,
                                                showConfirmButton: false, 
                                                timer: 2000
                                            })
                                        }
                                }
                            })
                        }
                        function numberWithCommas(x) {
                            return x.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
                        }
                        (function() {
                            let addonCheckboxes = document.querySelectorAll(".custom-checkbox");
                            function update()
                            {
                            let total = parseInt(document.getElementById("customProductPricing").textContent);
                            for(let i = 0 ; i < addonCheckboxes.length ; ++i)
                                if(addonCheckboxes[i].checked == true)
                                total += parseInt(addonCheckboxes[i].value);
                            document.getElementById("priceSection").innerHTML = "Overall Total: ₱ " + numberWithCommas(total);
                            }
                            
                            for(let i = 0 ; i < addonCheckboxes.length ; ++i)
                            addonCheckboxes[i].addEventListener("change", update);
                        })();
                    
                        $(".cart_check").change(function()
                        {
                            var arr_cart_id = new Array();
                            var arr_cart_quantity = new Array();
                            var arr_prod_id = new Array();
                            var arr_notification_receiver_id = new Array();
                            $(".cart_check").each(function()
                            {
                                if( $(this).is(':checked') )
                                {
                                    var currentIndex = parseInt($(this).data('cart_id'));
                                    arr_cart_id.push(currentIndex);
                                
                                    var currentIndex1 = parseInt($(this).data('cart_quantity'));
                                    arr_cart_quantity.push(currentIndex1);
                                
                                    var currentIndex2 = parseInt($(this).data('product_id'));
                                    arr_prod_id.push(currentIndex2);
                                    var currentIndex3 = parseInt($(this).data('notification_receiver_id'));
                                    arr_notification_receiver_id.push(currentIndex3);
                                }
                            });
                            console.log('cart_id['+arr_cart_id+']');
                            console.log('cart_quantity['+arr_cart_quantity+']');
                            console.log('product_id['+arr_prod_id+']');
                            console.log('notification_receiver_id['+arr_notification_receiver_id+']');
                            //$("input[name=order_list]").val(arr_sort.join(', '));
                            $("input[name=cart_id_list]").val(JSON.stringify(arr_cart_id));
                            $("input[name=cart_quantity_list]").val(JSON.stringify(arr_cart_quantity));
                            $("input[name=product_id_list]").val(JSON.stringify(arr_prod_id));
                            $("input[name=notification_receiver_id_list]").val(JSON.stringify(arr_notification_receiver_id));
                        });
                    
                        $('#order_submit').click(function(){
                            var checkboxes = document.querySelectorAll('input[type="checkbox"]');
                            var checkedOne = Array.prototype.slice.call(checkboxes).some(x => x.checked);
                            console.log(checkedOne)
                            if (!checkedOne) {
                                Swal.fire({
                                    position: 'top',
                                    icon: 'error',
                                    title: "There's no item ticked",
                                    toast: true,
                                    showConfirmButton: false, 
                                    timer: 2000
                                })
                            }
                            else
                            {
                                Swal.fire({
                                    confirmButtonText: "Proceed",
                                    showCancelButton: true,
                                    html:
                                        '<h4>Proceed to order the item/s?</h4>'
                                }).then((result) => {
                                        if (result.isConfirmed) {
                                            var formData = { 
                                                user_id: <?php echo $_SESSION['login_user_id'] ?>,
                                                cart_id_arr:$('#cart_id_list').val(),
                                                cart_quant_arr:$('#cart_quantity_list').val(),
                                                prod_id_arr:$('#product_id_list').val(),
                                                notif_rcvr_id_arr: $('#notification_receiver_id_list').val(),
                                            };
                                            $.ajax({
                                                url:"ajax.php?action=confirm_order",
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
                        })
                        
                    
                            function deleteCartItem(cart_id)
                            {
                                Swal.fire({
                                        confirmButtonText: "Proceed",
                                        showCancelButton: true,
                                        html:
                                            '<h4>Proceed to delete the item?</h4>'
                                    }).then((result) => {
                                            if (result.isConfirmed) {
                                                $.ajax({
                                                    url:"ajax.php?action=delete_cart",
                                                    method: 'POST',
                                                    data: {cart_id:cart_id},
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
        //End of showing current user's cart
                    endif;
                    if(!isset($_GET['product']) && !isset($_GET['cart']) && isset($_GET['my_orders']) && !isset($_GET['history'])): /*location.href='?page=service&l_id=<?php //echo $_GET['l_id']?>&action=add_service';*/
    //Start of showing specific order details
            ?>
                    <style>
                            .tab {
                                overflow: hidden;
                                background-color: rgba(33, 150, 243, 0.4);
                                border-radius: 50px 50px 50px 50px;
                                display: grid;
                                grid-template-columns: repeat(4, 1fr);
                                margin-bottom: 20px;
                            }
                        
                            .tab2 {
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
                        
                            .order_item {
                                display: flex;
                                flex-direction: row;
                                justify-content: space-between;
                                width: 100%;
                                padding: 10px;
                                border-radius: 5px;
                                background-color: rgba(33, 150, 243, 0.2);
                            }
                        
                            .order_item_sub1, .order_item_sub2 {
                                display: flex;
                                flex-direction: row;
                            }
                        
                            .order_item_sub1 > *, .order_item_sub2 > * {
                                margin-top: auto;
                                margin-bottom: auto;
                            }
                        
                            .order_item img {
                                margin-right: 20px;
                                width: 70px;
                                height: 70px;
                                object-fit: cover;
                                border: 1px solid grey;
                            }
                        
                            .order_item p:first-of-type {
                                font-size: 25px;
                                width: 220px;
                            }
                        
                            .order_item p:not(p:first-of-type) {
                                text-align: center;
                                font-size: 20px;
                                width: 200px;
                            }
                        
                            .order_item_sub2 button {
                                border: none;
                                background-color: #fed136;
                                font-size: 20px;
                                padding: 5px 15px 5px 15px;
                                border-radius: 20px;
                                font-weight: 600;
                                margin-right: 10px;
                            }
                        
                    </style>
                    <div class="tab">
                        <button class="tablinks" onclick="location.href='?page=market';">Products</button>
                        <button class="tablinks" onclick="location.href='?page=market&cart';">My Cart</button>
                        <button class="tablinks active" onclick="location.href='?page=market&my_orders';">My Order/s</button>
                        <button class="tablinks" onclick="location.href='?page=market&history';">History</button>
                    </div> 
            <?php
                    
                    if(!isset($_GET['confirmed']) && !isset($_GET['product_id']) && !isset($_GET['order_id']) && !isset($_GET['print'])):
        //Start of showing specific order details where its pending
            ?>
                    <style>
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
                            color: #fed136;
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
                    <div class="tab2">
                        <button class="tablinks active" onclick="location.href='?page=market&my_orders';">Pending</button>
                        <button class="tablinks" onclick="location.href='?page=market&my_orders&confirmed';">Processing</button>
                    </div>
                    
                    <div class="order_list">
                    
                        
            <?php
                    $orders_num = $conn->query("SELECT * FROM `tbl_order`as o INNER JOIN `tbl_product` as pr ON o.product_id = pr.product_id WHERE o.user_id = {$_SESSION['login_user_id']} AND o.order_status = 0")->num_rows;
                    if($orders_num > 0):
            ?>
                    <div class="order-container">
            <?php
                    $orders = $conn->query("SELECT *, pr.user_id as seller_id FROM `tbl_order`as o INNER JOIN `tbl_product` as pr ON o.product_id = pr.product_id WHERE o.user_id = {$_SESSION['login_user_id']} AND o.order_status = 0");
                    while($row=$orders->fetch_assoc()):
                    (strlen($row['product_name']) > 20) ? $name = substr($row['product_name'], 0, 20).'...' : $name = $row['product_name'];
            ?>
                    <div class="order_item">
                        <div class="order_item_sub1">
                            <img src="../assets/banners/products/<?php echo $row['product_banner'] ?>" alt="">
                            <p><?php echo $name ?></p>
                            <p>Quantity: <?php echo $row['order_quantity'] ?></p>
                            <p>Status: Pending</p>
                            <p>Total price: <?php echo '₱ ' . number_format(($row['order_quantity'] * $row['product_price'])) ?></p>
                        </div>
                        <div class="order_item_sub2">
                            <button onclick="location.href='?page=market&my_orders&product_id=<?php echo $row['product_id'] ?>&order_id=<?php echo $row['order_id'] ?>&print';">Show Receipt</button>
                            <button onclick="cancelOrder(<?php echo $row['order_id'] ?>, <?php echo $row['seller_id'] ?>)">Cancel</button>
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
							<h3>No Pending Orders Yet...</h3>
					</div>
            <?php
                    endif;
            ?>
                    </div>
                    
                    <script>
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
                                	//in this case it will be the lensman who will receive the notification
                                    notification_receiver: user_id,
                                    order_cancel_reason: value,
                                };
                                start_load()
                                $.ajax({
                                    url:"ajax.php?action=cancel_order_cm",
                                    method: 'POST',
                                    data: formData,
                                    success:function(resp){
                                        console.log(resp)
                                        end_load()
                                        if(resp == 1){
                                            alert_toast("Order successfully updated",'success')
                                            setTimeout(function(){
                                                location.href='?page=market&history&cancelled';
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
                    </script>
            <?php
        //End of showing specific order details where its pending
                    endif;
                    if(isset($_GET['confirmed']) && !isset($_GET['product_id']) && !isset($_GET['order_id']) && !isset($_GET['print'])):
        //Start of showing specific order details where its processing
            ?>
            <style>
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
                        color: #fed136;
					}
            </style>
                    <div class="tab2">
                        <button class="tablinks" onclick="location.href='?page=market&my_orders';">Pending</button>
                        <button class="tablinks active" onclick="location.href='?page=market&my_orders&confirmed';">Processing</button>
                    </div>
                    <div class="order_list">
            <?php
                    $orders_num = $conn->query("SELECT * FROM `tbl_order`as o INNER JOIN `tbl_product` as pr ON o.product_id = pr.product_id WHERE o.user_id = {$_SESSION['login_user_id']} AND o.order_status = 1")->num_rows;
                    if($orders_num > 0):
            ?>
                    <div class="order-container">
            <?php
                    $orders = $conn->query("SELECT *, pr.user_id as seller_id FROM `tbl_order`as o INNER JOIN `tbl_product` as pr ON o.product_id = pr.product_id WHERE o.user_id = {$_SESSION['login_user_id']} AND o.order_status = 1");
                    while($row=$orders->fetch_assoc()):
                    (strlen($row['product_name']) > 20) ? $name = substr($row['product_name'], 0, 20).'...' : $name = $row['product_name'];
            ?>
                    <div class="order_item">
                        <div class="order_item_sub1">
                            <img src="../assets/banners/products/<?php echo $row['product_banner'] ?>" alt="">
                            <p><?php echo $name ?></p>
                            <p>Quantity: <?php echo $row['order_quantity'] ?></p>
                            <p>Status: Processing</p>
                            <p>Total price: <?php echo '₱ ' . number_format(($row['order_quantity'] * $row['product_price'])) ?></p>
                        </div>
                        <div class="order_item_sub2">
                            <button onclick="location.href='?page=market&my_orders&product_id=<?php echo $row['product_id'] ?>&order_id=<?php echo $row['order_id'] ?>&print';">Show Receipt</button>
                            <button onclick="cancelOrder(<?php echo $row['order_id'] ?>, <?php echo $row['seller_id'] ?>)">Cancel</button>
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
							<h3>No Processing Orders Yet...</h3>
					</div>
            <?php
                    endif;
            ?>
                    </div>

                    <script>
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
                                	//in this case it will be the lensman who will receive the notification
                                    notification_receiver: user_id,
                                    order_cancel_reason: value,
                                };
                                start_load()
                                $.ajax({
                                    url:"ajax.php?action=cancel_order_cm",
                                    method: 'POST',
                                    data: formData,
                                    success:function(resp){
                                        console.log(resp)
                                        end_load()
                                        if(resp == 1){
                                            alert_toast("Order successfully updated",'success')
                                            setTimeout(function(){
                                                location.href='?page=market&history&cancelled';
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
                    </script>
            <?php
        //End of showing specific order details where its processing
                    endif;
                    if( (isset($_GET['confirmed']) || !isset($_GET['confirmed'])) && isset($_GET['product_id']) && isset($_GET['order_id']) && isset($_GET['print'])):
        //Start of showing printing of invoice for a specific order
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
            <?php
                    if(isset($_GET['confirmed'])):
            ?>
                                <a href="?page=market&my_orders&confirmed" style="float: left; color: #fed136;"><i class="fa fa-arrow-left"></i></a>
            <?php
                    elseif(!isset($_GET['confirmed'])):
            ?>
                                <a href="?page=market&my_orders" style="float: left; color: #fed136;"><i class="fa fa-arrow-left"></i></a>
            <?php
                    endif;
            ?>
                                
                                <?php echo '&nbsp;&nbsp;&nbsp;' . $product_name?> Receipt, Order No. <?php echo $_GET['order_id'] ?>
                            </h3>
                            <button onclick="var p = window.open('../Print/invoice_prod.php?product_id=<?php echo $_GET['product_id'] ?>&order_id=<?php echo $_GET['order_id'] ?>');">Print</button>
                        </div>
                        <h3>Avail Receipt</h3>
                        
                        <div class="receipt_div">
            <?php
                        include "../Print/print_prod.php";
            ?>
                        </div>
            <?php
        //End of showing printing of invoice for a specific order
                    endif;
    //End of showing specific order details
                    endif;  
                    
                    if(!isset($_GET['product']) && !isset($_GET['cart']) && !isset($_GET['my_orders']) && isset($_GET['history'])):
    //Start of showing current user's purchase history
                ?>
                        <style>
                            .tab {
                                overflow: hidden;
                                background-color: rgba(33, 150, 243, 0.4);
                                border-radius: 50px 50px 50px 50px;
                                display: grid;
                                grid-template-columns: repeat(4, 1fr);
                                margin-bottom: 20px;
                            }
                        
                            .tab2 {
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
                        
                            .order_item {
                                display: flex;
                                flex-direction: row;
                                justify-content: space-between;
                                width: 100%;
                                padding: 10px;
                                border-radius: 5px;
                                background-color: rgba(33, 150, 243, 0.2);
                            }
                        
                            .order_item_sub1, .order_item_sub2 {
                                display: flex;
                                flex-direction: row;
                                margin-left: 30px;
                            }
                        
                            .order_item_sub1 > *, .order_item_sub2 > * {
                                margin-top: auto;
                                margin-bottom: auto;
                            }
                        
                            .order_item img {
                                margin-right: 20px;
                                width: 70px;
                                height: 70px;
                                object-fit: cover;
                                border: 1px solid grey;
                            }
                        
                            .order_item p:first-of-type {
                                font-size: 25px;
                                width: 270px;
                            }
                        
                            .order_item p:not(p:first-of-type) {
                                text-align: center;
                                font-size: 20px;
                                width: 200px;
                            }
                        
                            .order_item_sub2 button {
                                border: none;
                                background-color: #fed136;
                                font-size: 20px;
                                padding: 5px 15px 5px 15px;
                                border-radius: 20px;
                                font-weight: 600;
                                margin-right: 10px;
                            }
                            .order-container {
						    	display: grid;
						    	grid-auto-rows: 1fr;
						    	grid-gap: 10px;
						    	box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2), 0 6px   20px 0 rgba(0, 0, 0, 0.19);
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
                                color: #fed136;
						    }
                        </style>
                        <div class="tab">
                            <button class="tablinks" onclick="location.href='?page=market';">Products</button>
                            <button class="tablinks" onclick="location.href='?page=market&cart';">My Cart</button>
                            <button class="tablinks" onclick="location.href='?page=market&my_orders';">My Order/s</button>
                            <button class="tablinks active" onclick="location.href='?page=market&history';">History</button>
                        </div>
                <?php
                        if(!isset($_GET['cancelled']) && !isset($_GET['product_id']) && !isset($_GET['order_id']) && !isset($_GET['print'])):
            //Start of showing current user's purchase history where its completed
                ?>
                        <div class="tab2">
                            <button class="tablinks active" onclick="location.href='?page=market&history';">Completed</button>
                            <button class="tablinks" onclick="location.href='?page=market&history&cancelled';">Cancelled</button>
                        </div>
                        <div class="order_list">
                <?php
                        $orders_num = $conn->query("SELECT * FROM `tbl_order`as o INNER JOIN `tbl_product` as pr ON o.product_id = pr.product_id WHERE o.user_id = {$_SESSION['login_user_id']} AND o.order_status = 2")->num_rows;
                        if($orders_num > 0):
                ?>
                        <div class="order-container">
                <?php
                        $orders = $conn->query("SELECT *, pr.user_id as seller_id FROM `tbl_order`as o INNER JOIN `tbl_product` as pr ON o.product_id = pr.product_id WHERE o.user_id = {$_SESSION['login_user_id']} AND o.order_status = 2");
                        while($row=$orders->fetch_assoc()):
                        (strlen($row['product_name']) > 20) ? $name = substr($row['product_name'], 0, 20).'...' : $name = $row['product_name'];
                ?>
                        <div class="order_item">
                            <div class="order_item_sub1">
                                <img src="../assets/banners/products/<?php echo $row['product_banner'] ?>" alt="">
                                <p><?php echo $name ?></p>
                                <p>Quantity: <?php echo $row['order_quantity'] ?></p>
                                <p>Status: Completed</p>
                                <p>Total price: <?php echo '₱ ' . number_format(($row['order_quantity'] * $row['product_price'])) ?></p>
                            </div>
                            <div class="order_item_sub2">
                                <button onclick="location.href='?page=market&my_orders&product_id=<?php echo $row['product_id'] ?>&order_id=<?php echo $row['order_id'] ?>&print';">Show Receipt</button>
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
                                <h3>No Completed Orders Yet...</h3>
                        </div>
                <?php
                        endif;
                ?>
                        </div>
                <?php
            //End of showing current user's purchase history where its completed
                        endif;
                        if(isset($_GET['cancelled']) && !isset($_GET['product_id']) && !isset($_GET['order_id']) && !isset($_GET['print'])):
            //Start of showing current user's purchase history where its cancelled
                ?>
                        <div class="tab2">
                            <button class="tablinks" onclick="location.href='?page=market&history';">Completed</button>
                            <button class="tablinks active" onclick="location.href='?page=market&history&cancelled';">Cancelled</button>
                        </div>
                        <div class="order_list">
                <?php
                        $orders_num = $conn->query("SELECT * FROM `tbl_order`as o INNER JOIN `tbl_product` as pr ON o.product_id = pr.product_id WHERE o.user_id = {$_SESSION['login_user_id']} AND o.order_status = 3")->num_rows;
                        if($orders_num > 0):
                ?>
                        <div class="order-container">
                <?php
                        $orders = $conn->query("SELECT *, pr.user_id as seller_id FROM `tbl_order`as o INNER JOIN `tbl_product` as pr ON o.product_id = pr.product_id WHERE o.user_id = {$_SESSION['login_user_id']} AND o.order_status = 3");
                        while($row=$orders->fetch_assoc()):
                        (strlen($row['product_name']) > 20) ? $name = substr($row['product_name'], 0, 20).'...' : $name = $row['product_name'];
                ?>
                        <div class="order_item">
                            <div class="order_item_sub1">
                                <img src="../assets/banners/products/<?php echo $row['product_banner'] ?>" alt="">
                                <p><?php echo $name ?></p>
                                <p>Quantity: <?php echo $row['order_quantity'] ?></p>
                                <p>Status: Cancelled</p>
                                <p>Total price: <?php echo '₱ ' . number_format(($row['order_quantity'] * $row['product_price'])) ?></p>
                            </div>
                            <div class="order_item_sub2">
                                <p id="order<?php echo $row['order_id'] ?>" style="display: none;"><?php echo $row['order_cancel_reason'] ?></p>
                                <button onclick="showReason(<?php echo $row['order_id'] ?>)">Show Reason</button>
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
                                <h3>No Cancelled Orders Yet...</h3>
                        </div>
                <?php
                        endif;
                ?>
                        </div>
                        <script>
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
            //End of showing current user's purchase history where its cancelled
                        endif;
                        if( !isset($_GET['cancelled']) && isset($_GET['product_id']) && isset($_GET['order_id']) && isset($_GET['print'])):
                //Start of showing printing of invoice for a specific order
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
                                    <a href="?page=market&history" style="float: left; color: #fed136;"><i class="fa fa-arrow-left"></i></a>
                                    <?php echo '&nbsp;&nbsp;&nbsp;' . $product_name?> Receipt, Order No. <?php echo $_GET['order_id'] ?>
                                </h3>
                                <button onclick="var p = window.open('../Print/invoice_prod.php?product_id=<?php echo $_GET['product_id'] ?>&order_id=<?php echo $_GET['order_id'] ?>');">Print</button>
                            </div>
                            <h3>Avail Receipt</h3>
                            
                            <div class="receipt_div">
                <?php
                            include "../Print/print_prod.php";
                ?>
                            </div>
                <?php
            //End of showing printing of invoice for a specific order
                        endif;
    //End of showing current user's purchase history
                    endif;
            ?>
                    </div> 
                </div>
            </div>
        </div>