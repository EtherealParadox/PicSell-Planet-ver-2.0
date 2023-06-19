	<?php
		//include 'db_connect.php';
		include '../db_connect.php';
		function time_elapsed_string($datetime)
		{
			date_default_timezone_set('Asia/Manila');
			$time = strtotime($datetime);
			$nt = date("Y/m/d H:i:s", $time);
			$posted = new DateTime($nt);
			$current = new DateTime("NOW");
			$past = $posted->diff($current);
			if ($past->y > .9) {
				return '' . date('M d, Y h:i a', $time);
			}
			if ($past->s < 59 || $past->i > .9 || $past->h > .9 || $past->d > .9) {
				return '' . date('M d, h:i a', $time);
			}
		}
	
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
		.center-panel2{
			left: calc(25%);
			width: calc(55%);
			height: calc(100% - 3rem);
			overflow: auto;
			position: fixed;
		}
		.right-panel{
			left: calc(80%);
			width: calc(20%);
			height: calc(100% - 3rem);
			overflow: none;
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
	<?php
		(isset($_GET['fdbk_id']) || (isset($_GET['action']) && $_GET['action']=="manage_service") || !isset($_GET['l_id']) && !isset($_GET['fdbk_id']) || isset($_GET['l_id']) && !isset($_GET['srvc_id']) || isset($_GET['feedback']))
		? $tag = '<div class="center-panel py-2 px-2">' : $tag = '<div class="center-panel2 py-2 px-2">';
		echo $tag;
	?>
			<div class="container-fluid">
				<div class="col-md-12">
					<?php
							if(!isset($_GET['l_id']) && !isset($_GET['fdbk_id'])):
			//Start of showing lensman
					?>
							<style>
								.topPart {
									display: flex;
									justify-content: space-between;
								}

								.search input[type=button]
								{
									background-color: #114481;
									color:#fed136;
									border: none;
									border-radius: 5%;
									padding: 3px 5px 3px 5px;
								}

								.grid-container {
									display: grid;
									grid-template-columns: repeat(auto-fit, minmax(260px, auto));
									grid-gap: 10px;
									box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2), 0 6px 20px 0 rgba(0, 0, 0, 0.19);
									background-color: whitesmoke;
									border-radius: 5px 5px 5px 5px;
									padding: 10px;
									height: auto;
								}
							
								.grid-container > div {
									background-color: #114481;
									text-align: center;
									padding: 20px 0 0 0;
									font-size: 20px;
									font-weight: bolder;
								}
							
								.item {
									border-radius: 10px;
									height: fit-content;
								}

								.item:hover {
									transform: scale(1.03);
									transition: .5s;
									box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.5), 0 6px 20px 0 rgba(0, 0, 0, 0.19);
									background-color: #08204b;
								}
							
								.item p {
									color: #fed136;
								}
							
								.item button {
									border: none;
									border-radius: 15px 15px 15px 15px;
									padding: 5px 10px 5px 10px;
									background-color: #fed136;
									font-weight: bold;
								}
							
								.item > * {
									margin-bottom: 15px;
								}
							
								.item:last-child {
									margin-bottom: 0px;
								}
							</style>
							<div class="topPart">
								<div class="titlePart">
									<h4 style="text-align:center; font-weight: bold;">Lensman List</h4>
								</div>
								<div class="search">
									<input type="text" placeholder="Search..." id="text_input">
									<input type="button" value="Search" onclick="search()">
									<input type="button" value="&#x2715;" onclick="location.href='<?php echo $in_sess_link ?>_dashboard.php?page=service'">
								</div>
							</div>
							<script>
								function search()
								{
									var item = $('#text_input').val();
									//alert(item)
									location.href = '<?php echo $in_sess_link ?>_dashboard.php?page=service&search='+item+''
								}
							</script>
					<?php
				//Start of showing the lensman/s who has similar characters you typed in search
							if(isset($_GET['search'])):
					?>
							<div class="grid-container">
					<?php
							$item = $_GET['search'];
							$lens = $conn->query("SELECT * from tbl_user_account WHERE (user_first_name LIKE '%$item%' OR user_last_name LIKE '%$item%' OR user_studio_name LIKE '%$item%') AND user_type = 'Lensman' ORDER BY user_id ASC");
							while($row=$lens->fetch_assoc()):
							$reviews = $conn->query("SELECT AVG(feedback_rate) as average FROM tbl_feedback WHERE  `lensman_id` = {$row['user_id']}");
							while($r_rows=$reviews->fetch_assoc())
							{
								$ave = $r_rows['average'];
							}
					?>
							<div class="item">
							<img src="../../images/profile-images/<?php echo $row['user_profile_image'] ?>" alt="" style="max-width: 150px; max-height: 150px; width: 150px; height: 150px; background:center; background-size: cover; object-fit: cover; object-position: 0 -0%; border-radius: 50%">
							<div class="feedback_stars">
					<?php
							for($i=1; $i<=floor($ave); $i++)
							{
					?>
								<span class="fa fa-star star-light text-warning"></span>
					<?php
							}
							for($i=1; $i<=5-floor($ave); $i++)
							{
					?>
								<span class="fa fa-star star-light"></span>
					<?php
							}
					?>
							</div>
							<p><img src="../assets/icons/name-icon.png" alt="icon" style="width: 30px; height:auto; margin-right:5px; margin-bottom:5px;"><?php echo $row['user_first_name'].' '.$row['user_last_name'] ?></p>
							<p><img src="../assets/icons/studio-icon.png" alt="icon" style="width: 30px; height:auto; margin-right:5px; margin-bottom:5px;"><?php echo $row['user_studio_name'] ?></p>
							<div>
							<button onclick="location.href='<?php echo $in_sess_link ?>_dashboard.php?page=service&fdbk_id=<?php echo $row['user_id'] ?>'" type="button">Feedback</button>
							<button onclick="location.href='<?php echo $in_sess_link ?>_dashboard.php?page=service&l_id=<?php echo $row['user_id'] ?>'" type="button">View</button>
							</div>
							</div>
					<?php
							endwhile;
					?>
							</div>
					<?php
				//End of showing the lensman/s who has similar characters you typed in search
							else:
				//Start of showing all lensman
					?>
							<div class="grid-container">
					<?php
							$posts = $conn->query("SELECT * FROM tbl_user_account WHERE `user_type` = 'Lensman' ORDER BY CASE WHEN `user_id` = {$_SESSION['login_user_id']} THEN 0 ELSE 1 END");
							while($row=$posts->fetch_assoc()):
							$reviews = $conn->query("SELECT AVG(feedback_rate) as average FROM tbl_feedback WHERE  `lensman_id` = {$row['user_id']}");
							while($r_rows=$reviews->fetch_assoc())
							{
								$ave = $r_rows['average'];
							}
					?>
							<div class="item">
							<img src="../../images/profile-images/<?php echo $row['user_profile_image'] ?>" alt="" style="max-width: 150px; max-height: 150px; width: 150px; height: 150px; background:center; background-size: cover; object-fit: cover; object-position: 0 -0%; border-radius: 50%">
							<div class="feedback_stars">
					<?php
							for($i=1; $i<=floor($ave); $i++)
							{
					?>
								<span class="fa fa-star star-light text-warning"></span>
					<?php
							}
							for($i=1; $i<=5-floor($ave); $i++)
							{
					?>
								<span class="fa fa-star star-light"></span>
					<?php
							}
					?>
							</div>
							<p><img src="../assets/icons/name-icon.png" alt="icon" style="width: 30px; height:auto; margin-right:5px; margin-bottom:5px;"><?php echo $row['user_first_name'].' '.$row['user_last_name'] ?></p>
							<p><img src="../assets/icons/studio-icon.png" alt="icon" style="width: 30px; height:auto; margin-right:5px; margin-bottom:5px;"><?php echo $row['user_studio_name'] ?></p>
							<div>
							<button onclick="location.href='<?php echo $in_sess_link ?>_dashboard.php?page=service&fdbk_id=<?php echo $row['user_id'] ?>'" type="button">Review</button>
							<button onclick="location.href='<?php echo $in_sess_link ?>_dashboard.php?page=service&l_id=<?php echo $row['user_id'] ?>'" type="button">View</button>
							</div>
							</div>
					<?php
							endwhile;
					?>
							</div>
					<?php
				//End of showing all lensman
							endif;
			//End of showing lensman
							endif;
							if(isset($_GET['l_id']) && !isset($_GET['action']) && !isset($_GET['srvc_id'])):
			//Start of showing lensman
							if($_GET['l_id'] != $_SESSION['login_user_id']):
				//Start of part showing other lensman
							$user = $conn->query("SELECT * FROM tbl_user_account WHERE `user_id` = {$_GET['l_id']} ");
							while($row = $user->fetch_assoc()):
							$studio = $row['user_studio_name'];
							$new_lat = $row['user_lat'];
							$new_lng = $row['user_lng'];
					?>
							<style>
								.gm-style-iw button:focus {
									outline: none;
								}

								.mapStuff{
									color: black;
								}

								.user {
									box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.5), 0 6px 20px 0 rgba(0, 0, 0, 0.19);
									background: linear-gradient(90deg, rgba(2,0,36,1) 0%, rgba(20,102,193,1) 50%, rgba(0,224,255,1) 100%);
									border-radius: 5px 5px 5px 5px;
									font-weight: bold;
									align-items: center;
									padding: 5px 20px 5px 20px;
									font-size: 20px;
								}

								.user-container{
									width: 100%;
									display: flex;
									flex-direction: row;
									justify-content: space-evenly;
									margin: 30px 0 0 0;
									text-align: left;
									color: #fed136;
								}

								.user .user-pic{
									width: 170px; 
									height: 170px; 
									background:center; 
									background-size: cover; 
									object-fit: cover; 
									object-position: 0 -0%; 
									border-radius: 50%;
								}
							</style>
							<div style="display: flex; flex-direction: row; justify-content: space-between;">
							<h3>
								<a href="?page=service" style="float: left;"><i class="fa fa-arrow-left"></i></a>
								<br />
							</h3>
							<h2 style="width:60%;">Other Lensman</h2>
							</div>
								<div class="user">
								<div class="user-container">
									<div style="text-align: left;">
										<img src="../../images/profile-images/<?php echo $row['user_profile_image'] ?>" alt="" style="width: 170px; height: 170px; background:center; background-size: cover; object-fit: cover; object-position: 0 -0%; border-radius: 50%; margin-bottom: 10px; border: 2px solid black;">
										<p><img style="width:30px; height: auto;" src="https://cdn-icons-png.flaticon.com/512/7716/7716975.png" alt=""></a> <?php echo ucwords($row['user_first_name']) . ' ' . ucwords($row['user_last_name']) ?></p>
										<p><img style="width:30px; height: auto;" src="https://cdn-icons-png.flaticon.com/512/3719/3719116.png" alt=""> <?php echo $row['user_email'] ?></p>
										<p><img style="width:30px; height: auto;" src="https://cdn-icons-png.flaticon.com/512/2453/2453535.png" alt=""> <?php echo $row['user_studio_name'] ?></p>
										<p><img style="width:30px; height: auto;" src="https://cdn-icons-png.flaticon.com/512/1198/1198464.png" alt=""> <?php echo $row['user_address'] ?></p>
										<p><img style="width:30px; height: auto;" src="https://cdn-icons-png.flaticon.com/512/552/552489.png" alt=""> <?php echo $row['user_contact'] ?></p>						
									</div>
								<!--MAP SPECIFIC LOCATION PER USER-->
									<div style="width:65%; height:auto; margin-bottom: 20px; border-radius: 50px 50px 0 0" id="googleMap">
									</div>								
								</div>
								</div>
							<h2 style="margin-top: 15px; margin-bottom: 5px; text-align: center;">Service Packages</h2>
					<?php
							endwhile;
					?>
							
							<script>
								function showService(id)
								{
									uni_modal("<center><b>Service Details</b></center></center>",'show_service.php?srvc_id='+id+'')
								}
								function lensmanMap()
								{
									var map;
									var marker;
									var infowindow;
									var red_icon =  "gmaps/confirmed.png" ;
									var purple_icon =  'gmaps/pending.png' ;
					
									var lat = '<?php echo $new_lat ?>'
									var long = '<?php echo $new_lng ?>'
									var mapProp = {
										center:new google.maps.LatLng(lat, long),
										zoom:16,
									};
									map = new google.maps.Map(document.getElementById("googleMap"),	mapProp);

									var i ;
									marker = new google.maps.Marker({
										position: new google.maps.LatLng(lat, long),
										map: map,
										icon :  red_icon,
										html: `
											<div class="mapStuff"> 
											<h6><?php echo $studio ?></h6> 
											<div>
												<div style="font-size: 15px">
													`+lat+` 
												</div>
												<div style="font-size: 15px">
													`+long+` 
												</div>
											</div>
										</div>
										`
									});
									
									google.maps.event.addListener(marker, 'click', (function(marker, i) {
										return function() {
											infowindow = new google.maps.InfoWindow();
											infowindow.setContent(marker.html);
											infowindow.open(map, marker);
										}
									})(marker, i));
								}
							</script>
							<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDtXuNd8wbu-NaASSm5G16Rba7Xc-mvSFs&callback=lensmanMap"></script>
					<?php
				//End of part showing other lensman
							else:
				//Start of part current lensman
					?>
							<style>
								.tab {
									overflow: hidden;
									background-color: rgba(33, 150, 243, 0.4);
									border-radius: 50px 50px 50px 50px;
									display: grid;
									grid-template-columns: repeat(3, 1fr);
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

								.empty_serv {
									margin-top: 10px;
									height: 75vh !important;
								}
							</style>
							<h3>
								<a href="?page=service" style="float: left;"><i class="fa fa-arrow-left"></i></a>
								<br />
							</h3>
							<div class="tab">
								<button class="tablinks active" onclick="location.href='?page=service&l_id=<?php echo $_GET['l_id']?>';">My Services</button>
								<button class="tablinks" onclick="location.href='?page=service&l_id=<?php echo $_GET['l_id']?>&action=add_service';">Add Service</button>
								<button class="tablinks" onclick="location.href='?page=service&l_id=<?php echo $_GET['l_id']?>&action=manage_service';">Manage Service</button>
							</div>
					<?php
				//End of part current lensman
							endif;
							$services = $conn->query("SELECT * FROM tbl_service_packages WHERE `user_id` = {$_GET['l_id']} ");
				//Start of part showing lensman's services
							if($_GET['l_id'] != $_SESSION['login_user_id']):
					?>		
							<div class="services-container">
					<?php
							endif;
					?>
							<style>
								.grid-container-service {
									display: grid;
									grid-template-columns: repeat(auto-fit, minmax(425px, auto));
									grid-gap: 10px;
									box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.5), 0 6px 20px 0 rgba(0, 0, 0, 0.19);
									background-color: whitesmoke;
									border-radius: 5px 5px 5px 5px;
									padding: 10px;
								}
							
								.grid-container-service > div {
									background-color: #114481;
									text-align: center;
									padding: 20px 0 0 0;
									font-size: 20px;
									font-weight: bolder;
								}
							
								.item-service {
									border-radius: 15px 15px 15px 15px;
									height: fit-content;
								}

								.item-service:hover{
									transform: scale(1.02);
									transition: .5s;
									box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.5), 0 6px 20px 0 rgba(0, 0, 0, 0.19);
									background-color: #08204b;
								}
							
								.item-service p {
									color: #fed136;
								}
							
								.item-service button {
									border: none;
									border-radius: 15px 15px 15px 15px;
									padding: 5px 10px 5px 10px;
									background-color: #fed136;
									font-weight: bold;
								}
							
								.item-service > * {
									margin-bottom: 15px;
								}

								.item-service:last-child {
									margin-bottom: 0px;
								}
							</style>
					<?php
							$services_num = $conn->query("SELECT * FROM tbl_service_packages WHERE `user_id` = {$_GET['l_id']} ")->num_rows;
							if($services_num != 0):
					?>
							<div class="grid-container-service" style="margin-top: 10px;">
					<?php
							while($row=$services->fetch_assoc()):
							$txt = $row['service_description'];	
							//(strlen($txt) > 30) ? $txt = substr($txt, 0, 30).'...' : $txt = $txt;
							(empty($row['service_banner'])) ? $src = "../assets/banners/placeholder_image.png" : $src = "../assets/banners/" . $row['service_banner']; 
					?>
							<div class="item-service">
								<img onclick="showService(<?php echo $row['service_id'] ?>)" src="<?php echo $src ?>" alt="" style="width: calc(90%); height: 250px; background:center; background-size: 100%; object-fit: cover; border-radius: 5px 5px 5px 5px;">
								<div style="text-align:left;margin-left:25px;">
					<?php
							$reviews = $conn->query("SELECT AVG(feedback_rate) as average FROM tbl_feedback WHERE  `service_id` = {$row['service_id']}");
							while($r_rows=$reviews->fetch_assoc())
							{
								$ave = $r_rows['average'];
							}
					?>
								<div class="feedback_stars" style="margin-bottom: 10px;">
					<?php
							for($i=1; $i<=floor($ave); $i++)
							{
					?>
								<span class="fa fa-star star-light text-warning"></span>
					<?php
							}
							for($i=1; $i<=5-floor($ave); $i++)
							{
					?>
								<span class="fa fa-star star-light"></span>
					<?php
							}
							$ym = date('Y-m', time());
					?>
							</div>
								<p><img src="../assets/icons/service-icon.png" alt="icon" style="width: 30px;height:auto;margin-right:5px;margin-bottom:5px;"><?php echo $row['service_name'] ?></p>
								<p><img src="../assets/icons/price-icon.png" alt="icon" style="width: 30px;height:auto;margin-right:5px;margin-bottom:5px;">₱hp. <?php echo number_format($row['service_price']) ?></p>
								<p><img src="../assets/icons/hours.png" alt="icon" style="width: 30px;height:auto;margin-right:5px;margin-bottom:5px;"><?php echo $row['service_hours'] . ' Hours' ?></p>
								</div>
					<?php
							if($_SESSION['login_user_id'] == $_GET['l_id']):
							$ym = date('Y-m', time());
					?>
							<div class="service_btn">
								<button onclick="location.href='<?php echo $in_sess_link ?>_dashboard.php?page=service&l_id=<?php echo $row['user_id'] ?>&srvc_id=<?php echo $row['service_id'] ?>&feedback'" type="button">Review</button>
								<button onclick="location.href='<?php echo $in_sess_link ?>_dashboard.php?page=service&l_id=<?php echo $row['user_id'] ?>&srvc_id=<?php echo $row['service_id'] ?>&ym=<?php echo $ym ?>';" type="button">View Service</button>				
							</div>
								
					<?php
							else:
					?>
							<div class="service_btn">
								<button onclick="location.href='<?php echo $in_sess_link ?>_dashboard.php?page=service&l_id=<?php echo $row['user_id'] ?>&srvc_id=<?php echo $row['service_id'] ?>&feedback'" type="button">Review</button>
								<button onclick="showService(<?php echo $row['service_id'] ?>)" type="button">View Details</button>
							</div>
					<?php
							endif;
					?>
							</div>
					<?php
							endwhile;
					?>
							</div>
					<?php
							if($_GET['l_id'] != $_SESSION['login_user_id']):
					?>		
							</div>
					<?php
							endif;
							else:
					?>
							<div class="empty_serv" style="text-align: center; box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.5), 0 6px 20px 0 rgba(0, 0, 0, 0.19);; height: auto; position: relative; display: flex; flex-direction: column; justify-content: center;">
									<h3>No Services Yet...</h3>
							</div>
					<?php
							endif;
				
					?>
							<script>
								function showService(id)
								{
									uni_modal("<center><b>Service Details</b></center></center>",'show_service.php?srvc_id='+id+'')
								}
							</script>
					<?php
				//End of part showing lensman's services
			//End of part showing lensman
							endif;
							if((isset($_GET['l_id']) && isset($_GET['action'])) && !isset($_GET['srvc_id']) && !isset($_GET['avail_id'])):
			//Start of adding/managing lensman's services		
					?>
							<style>
								.tab {
									overflow: hidden;
									background-color: rgba(33, 150, 243, 0.4);
									border-radius: 50px 50px 50px 50px;
									display: grid;
									grid-template-columns: repeat(3, 1fr);
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
							</style>
					<?php
							if($_GET['action']=="add_service" && $_GET['action']!="manage_service" && !isset($_GET['srvc_id'])):
				//Start of adding lensman's services			
					?>
							<style>
								.add_service_form {
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

								.add_service {
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
							<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script> 
							<script>
					<?php
							if(isset($_SESSION['alert_text_type']) && isset($_SESSION['alert_text_serv']) && $_SESSION['alert_session_serv']==true):
					?>
							$type = $_SESSION['alert_text_type'];
							$serv = $_SESSION['alert_text_serv'];
							swal.fire({
								position: 'top',
								icon: '<?php echo $type ?>',
								title: '<?php echo $serv ?>',
								toast: true,
								showConfirmButton: false, 
								timer: 1500
							})


					<?php 
							unset($_SESSION['alert_text_serv']);
							unset($_SESSION['alert_text_type']);
							unset($_SESSION['alert_session_serv']);
							endif; 
					?>
							</script>
							<h3>
								<a href="?page=service" style="float: left;"><i class="fa fa-arrow-left"></i></a>
								<br />
							</h3>
							<div class="tab">
								<button class="tablinks" onclick="location.href='?page=service&l_id=<?php echo $_GET['l_id']?>';">My Services</button>
								<button class="tablinks active" onclick="location.href='?page=service&l_id=<?php echo $_GET['l_id']?>&action=add_service';">Add Service</button>
								<button class="tablinks" onclick="location.href='?page=service&l_id=<?php echo $_GET['l_id']?>&action=manage_service';">Manage Service</button>
							</div>
							<div class="add_service_form">
								<h3 class="label">New Service Package</h3>
								<form action="" id="add_service" >
									<div class="add_service">
										<div class="add_service_left">
											<p class="label">Service Name</p>
											<input class="input" type="text" id="service_name" name="service_name" required>
											<p class="label">Service Price</p> 
											<input class="input" type="text" id="service_price" name="service_price" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');" required>
											<p class="label">Service Description</p>
											<textarea class="input" name="service_description" id="service_description" cols="50" rows="8.5" required></textarea>
										</div>
										<div>
											<p class="label">Service Hour/s</p>
											<input class="input" type="text" id="service_hours" name="service_hours" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');" required>
											<!--<input class="input" type="number" id="service_hours" name="service_hours" required>-->
											<p class="label">Service Banner</p>
											<label>
												<img src="../../assets/img/logos/image.png" style="width: 40px">
												<input type="file" id="service_banner" name="service_banner" accept="image/*" onchange="loadFile(event)" style="display:none">
											</label>
											<br>
											<img id="output" />
											<center><input type="submit" id="service_submit" name="service_submit" value="Submit" style="margin-bottom: 5px; font-weight: 700;" form="add_service"></center>
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

							$('#add_service').submit(function(e){
								e.preventDefault()
								var name = document.getElementById('service_name').value
								var price = document.getElementById('service_price').value//$("#service_price").val()
								var description = document.getElementById('service_description').value
								var banner = document.getElementById('service_banner')

								const isEmpty = str => !str.trim().length;

								if( (!name || isEmpty(name)) || (!price || price <= 0) || !description || !banner ) {
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
										price_new = price.replace(/^0+/,'');
										name=name.trimStart();
										name_new=name.trimEnd();
										description=description.trimStart();
										description_new=description.trimEnd();
										var file = banner[0];
										
										start_load()
										$.ajax({
											url:"ajax.php?action=add_service",
											data: new FormData($(this)[0]),
											cache: false,
											contentType: false,
											processData: false,
											method: 'POST',
											type: 'POST',
											success:function(resp){
												console.log(resp)
												if(resp == 1){
													alert_toast("Successfully added service", "success")
													setTimeout(function(){
														location.reload()
													},1500)
													setTimeout(function(){
														location.href="?page=service&l_id=<?php echo $_GET['l_id'] ?>"
													},1500)
												}
												else
												{
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
								const file = document.querySelector('#service_banner').files[0];
								console.log(toBase64(file));*/
							})
						</script>
						<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
					<?php
				//End of adding lensman's services
							endif;
							if($_GET['action']=="manage_service" && $_GET['action']!="add_service" || isset($_GET['srvc_id'])):
				//Start of managing lensman's services
					?>
							<h3>
								<a href="?page=service" style="float: left;"><i class="fa fa-arrow-left"></i></a>
								<br />
							</h3>
							<div class="tab">
								<button class="tablinks" onclick="location.href='?page=service&l_id=<?php echo $_GET['l_id']?>';">My Services</button>
								<button class="tablinks" onclick="location.href='?page=service&l_id=<?php echo $_GET['l_id']?>&action=add_service';">Add Service</button>
								<button class="tablinks active" onclick="location.href='?page=service&l_id=<?php echo $_GET['l_id']?>&action=manage_service';">Manage Service</button>
							</div>
					<?php
							$services = $conn->query("SELECT * FROM tbl_service_packages WHERE `user_id` = {$_GET['l_id']} ");
					?>
							<style>
								.grid-container-m_service {
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
							
								.grid-container-m_service > div {
									background-color: #114481;
									padding: 20px 0 0 0;
									font-size: 20px;
									font-weight: bolder;
								}
							
								.item-m_service {
									border-radius: 5px 5px 5px 5px;
									height: fit-content;
									display: grid;
									grid-template-columns: repeat(2, 1fr);
								}
							
								.item-m_service p {
									color: #fed136;
									float: left;
									padding: 5px 10px 5px 150px;
								}
							
								.item-m_service button {
									border: none;
									border-radius: 15px 15px 15px 15px;
									padding: 5px 10px 5px 10px;
									margin-right: 100px;
									margin-left: 350px;
									background-color: #fed136;
									font-weight: bold;
								}
							
								.item-m_service > * {
									margin-bottom: 15px;
								}

								.item-m_service:last-child {
									margin-bottom: 0px;
								}

								.srvc_img_n_name {
									margin-left: 20px;
									display: flex;
									flex-direction: row;
								}

								.srvc_img_n_name > * {
									margin: auto 0px auto 0px;
								}

								.srvc_img_n_name img {
									margin-left: 30px;
								}

								.srvc_img_n_name:hover {
									cursor: pointer;
								}
							</style>
					<?php
							$services_num = $conn->query("SELECT * FROM tbl_service_packages WHERE `user_id` = {$_GET['l_id']} ")->num_rows;
							if($services_num != 0):
					?>
							<div class="grid-container-m_service">
					<?php
							while($row=$services->fetch_assoc()):
							$txt = $row['service_description'];	
							//(strlen($txt) > 30) ? $txt = substr($txt, 0, 30).'...' : $txt = $txt;
							(empty($row['service_banner'])) ? $src = "../assets/banners/placeholder_image.png" : $src = "../assets/banners/" . $row['service_banner']; 
					?>
							<div class="item-m_service">
								<div class="srvc_img_n_name" onclick="showService(<?php echo $row['service_id'] ?>)">
									<img src="../assets/banners/<?php echo $row['service_banner'] ?>" alt="srvc_banner" style="margin: 0; width: 120px; height: 70px; background: center; background-size: cover; object-fit: cover; border-radius: 5px 5px 5px 5px;">
									<p ><?php echo mb_convert_case($row['service_name'], MB_CASE_TITLE, 'UTF-8'); ?></p>
								</div>
								<button onclick="editService(<?php echo $row['service_id'] ?>)" type="button">Edit Service</button>
							</div>
					<?php
							endwhile;
					?>
							</div>
					<?php
							else:
					?>
							<div class="empty_serv" style="margin-top: 10px; text-align: center; box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.5), 0 6px 20px 0 rgba(0, 0, 0, 0.19);; height: auto; position: relative; display: flex; flex-direction: column; justify-content: center;">
									<h3>No Services Yet...</h3>
							</div>
					<?php
							endif;
					?>
							<script>
								function showService(id)
								{
									uni_modal("<center><b>Service Details</b></center></center>",'show_service.php?srvc_id='+id+'')
								}
								function editService(id)
								{
									uni_modal("<center><b>Edit Service Details</b></center></center>",'edit_service.php?srvc_id='+id+'')
								}
							</script>
					<?php
				//End of managing lensman's services
							endif;
			//End of adding/managing lensman's services
							endif;
							if(isset($_GET['l_id']) && isset($_GET['srvc_id']) && isset($_GET['feedback']) && !isset($_GET['action'])):
	//Start of showing specific lensman's services feedback
							$service = $conn->query("SELECT * FROM tbl_service_packages WHERE  `service_id` = {$_GET['srvc_id']}");
							while($srvc_row=$service->fetch_assoc())
							{
								$title = $srvc_row['service_name']; 
							}
					?>
							<style>
								.service {
									display: flex;
									background: linear-gradient(90deg, rgba(2,0,36,1) 0%, rgba(20,102,193,1) 50%, rgba(0,224,255,1) 100%);
									border-radius: 5px 5px 5px 5px;
									color: #fed136;
									font-weight: bold;
									align-items: center;
									padding: 20px;
									font-size: 50px;
								}

								.service_name {
									margin-left: 25px; 
									margin-top: auto;
									margin-bottom: auto;
									font-size: 30px;
								}

								.rating_stats {
									margin-left: 70px;
									display: flex;
									flex-direction: column;
									justify-content: space-evenly;
								}

								.rating_stats > * {
									text-align: center !important;
									margin: 0px !important;
								}

								.rating_stats p {
									font-size: 30px !important;
								}

								.rating_stats .stars {
									font-size: 20px !important;
									color: black !important;
								}

								.rating_stats h6 {
									padding: 7px;
									font-size: 20px !important;
								}

								.rating_count {
									margin-left: 70px; 
									font-size: 15px !important;
									display: flex;
									flex-direction: column;
									justify-content: space-evenly;
								}

								.rating_count > * {
									margin: auto;
									padding: 5px;
								}

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
							<div style="display: flex; flex-direction: row; justify-content: space-between;">
							<h3>
								<a href="?page=service&l_id=<?php echo $_GET['l_id'] ?>" style="float: left;"><i class="fa fa-arrow-left"></i></a>
								<br />
							</h3>
							<h3 style="width:60%;">Service/Package Ratings</h3>
							</div>
					<?php
							$service = $conn->query("SELECT * FROM tbl_service_packages WHERE `service_id` = {$_GET['srvc_id']} ");
							while($s_row = $service->fetch_assoc()):
					?>
							<div class="service">
								<img src="../assets/banners/<?php echo $s_row['service_banner'] ?>" alt="" style="margin-top: auto; margin-bottom: auto; width: 240px; height: 140px; background:center; background-size: cover; object-fit: cover; object-position: 0 -0%; border-radius: 5px;">
								<p class="service_name"><?php echo $s_row['service_name'] ?></p>
					<?php
							endwhile;
							$reviews_num = $conn->query("SELECT * FROM tbl_feedback WHERE  `service_id` = {$_GET['srvc_id']}")->num_rows;
							$reviews = $conn->query("SELECT AVG(feedback_rate) as average, SUM(if(feedback_rate = 5,1,0)) as r5, SUM(if(feedback_rate = 4,1,0)) as r4,
							SUM(if(feedback_rate = 3,1,0)) as r3, SUM(if(feedback_rate = 2,1,0)) as r2, SUM(if(feedback_rate = 1,1,0)) as r1 FROM tbl_feedback WHERE  `service_id` = {$_GET['srvc_id']}");
							while($r_rows=$reviews->fetch_assoc())
							{
								$average = $r_rows['average'];
								($r_rows['r1']!=0) ? $r1 = $r_rows['r1'] : $r1 = 0;
								($r_rows['r2']!=0) ? $r2 = $r_rows['r2'] : $r2 = 0;
								($r_rows['r3']!=0) ? $r3 = $r_rows['r3'] : $r3 = 0;
								($r_rows['r4']!=0) ? $r4 = $r_rows['r4'] : $r4 = 0;
								($r_rows['r5']!=0) ? $r5 = $r_rows['r5'] : $r5 = 0;
							}
					?>
							<div class="rating_stats">
								<p><?php echo number_format((float)$average, 2, '.', '')?></p>
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
								<h6><?php echo $reviews_num ?> review/s</h6>
							</div>
								<div class="rating_count">
					<?php
							for($i = 1; $i <= 5; $i++):
							if($i==1){$r_num = $r5; $n = 5;}
							if($i==2){$r_num = $r4; $n = 4;}
							if($i==3){$r_num = $r3; $n = 3;}
							if($i==4){$r_num = $r2; $n = 2;}
							if($i==5){$r_num = $r1; $n = 1;}
					?>
								<p><?php echo $n; ?> <i class="fas fa-star text-warning"></i> ( <?php echo $r_num; ?> )</p>
					<?php
							endfor;
					?>
								</div>
							</div>
							<div class="c_fdbk">
								<h2 style="padding-top: 10px;">Customer Feedback/s</h2>
								<div class="dropdownf">
									<button class="dropbtnf">Sort Ratings</button>
									<div class="dropdown-contentf">
									<a href="?page=service&l_id=<?php echo $_GET['l_id'] ?>&srvc_id=<?php echo $_GET['srvc_id'] ?>&feedback">All ( <?php echo $reviews_num ?> )</a>
										<a href="?page=service&l_id=<?php echo $_GET['l_id'] ?>&srvc_id=<?php echo $_GET['srvc_id'] ?>&feedback&sort=5">5 <i class="fas fa-star text-warning"></i> ( <?php echo $r5; ?> )</a>
										<a href="?page=service&l_id=<?php echo $_GET['l_id'] ?>&srvc_id=<?php echo $_GET['srvc_id'] ?>&feedback&sort=4">4 <i class="fas fa-star text-warning"></i> ( <?php echo $r4; ?> )</a>
										<a href="?page=service&l_id=<?php echo $_GET['l_id'] ?>&srvc_id=<?php echo $_GET['srvc_id'] ?>&feedback&sort=3">3 <i class="fas fa-star text-warning"></i> ( <?php echo $r3; ?> )</a>
										<a href="?page=service&l_id=<?php echo $_GET['l_id'] ?>&srvc_id=<?php echo $_GET['srvc_id'] ?>&feedback&sort=2">2 <i class="fas fa-star text-warning"></i> ( <?php echo $r2; ?> )</a>
										<a href="?page=service&l_id=<?php echo $_GET['l_id'] ?>&srvc_id=<?php echo $_GET['srvc_id'] ?>&feedback&sort=1">1 <i class="fas fa-star text-warning"></i> ( <?php echo $r1; ?> )</a>
									</div>
								</div>
							</div>
					<?php
							if($reviews_num != 0):
		//Start of if theres feedbacks taken from the db
							if(isset($_GET['sort'])):
			//Start of showing the sorted feedback according to their stars
							$fdbk_sort_num = $conn->query("SELECT * FROM tbl_feedback WHERE `feedback_archive_status` = '1' AND `service_id` = {$_GET['srvc_id']} AND `feedback_rate` = {$_GET['sort']}")->num_rows;	
							if($reviews_num != 0 && $fdbk_sort_num != 0):
				//Start of if theres feedbacks taken from the db according to their stars
							$reviews = $conn->query("SELECT * FROM tbl_feedback WHERE `feedback_archive_status` = '1' AND `service_id` = {$_GET['srvc_id']} AND `feedback_rate` = {$_GET['sort']} ORDER BY `feedback_date` DESC");
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
				//End of if theres feedbacks taken from the db according to their stars
							else:
					?>
							<div style="text-align: center; box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.5), 0 6px 20px 0 rgba(0, 0, 0, 0.19);; height: auto; position: relative; display: flex; flex-direction: column; justify-content: center;">
								<h3>No <?php echo $_GET['sort'] ?> Star Rating Reviews Yet...</h3>
							</div>
					<?php
							endif;
			//End of showing the sorted feedback according to their stars
							else:
			//Start of showing all feedbacks
							$reviews = $conn->query("SELECT * FROM tbl_feedback WHERE `feedback_archive_status` = '1' AND `service_id` = {$_GET['srvc_id']} ORDER BY `feedback_date` DESC");
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
									<h5 class="user_avail_info"><?php echo $u_row['user_first_name'].' '.$u_row['user_last_name']?></h5>
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
		//End of if theres feedbacks taken from the db
							else:
					?>
							<div style="text-align: center; box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.5), 0 6px 20px 0 rgba(0, 0, 0, 0.19);; height: auto; position: relative; display: flex; flex-direction: column; justify-content: center;">
									<h3>No Reviews Yet...</h3>
							</div>
					<?php
							endif;
	//End of showing specific lensman's services feedback
							endif;
							if(isset($_GET['l_id']) && isset($_GET['srvc_id']) && !isset($_GET['feedback']) && !isset($_GET['action'])):
			//Start of showing specific lensman's services avail calendar
							
					?>
							<style>
								.service_banner {
									background: #114481;
									border-radius: 5px 5px 60px 5px;
									color: #fed136; 
									padding: 20px;
									margin-bottom: 15px;
								}

								.table {
									table-layout: fixed;
									width: 100%;
								}

								.table th {
									height: 30px;
									text-align: center;
									font-weight: bolder;
									font-size: large;
									border-color: #0A2647 !important;
									border: 3px solid;
									background-color: #fed136;
								}
								.table td {
									height: 100px !important;
									width: 100px !important;
									font-weight: bold;
									border-color: #0A2647 !important;
									border: 3px solid;
								}
								.past { background-color: #B2B2B2; }
								.today { background-color: rgb(0, 0, 0, 0.5); }
								.downpayment { background-color: #FFC93C; }
								.confirmed { background-color: #FFC93C; }
								.empty { background-color: #B2B2B2; }
								.table th:nth-of-type(1), .table td:nth-of-type(1) { color: red; }
							</style>
					<?php
							$service = $conn->query("SELECT * FROM tbl_service_packages WHERE  `service_id` = {$_GET['srvc_id']}");
							while($srvc_row=$service->fetch_assoc())
							{
								$title = $srvc_row['service_name']; 
							}
							if(isset($_GET['l_id']) && isset($_GET['srvc_id']) && !isset($_GET['c_id'])):
				//Start of showing specific lensman's services avail calendar (All Pending, Downpayment, Confirmed, and Rescheduling)
							include '../calendar_function_lm_all_avail.php';
					?>
							<style>
								.availed, .downpayment, .confirmed, .resched, .availed_others { background-color: #FFC93C; }
							</style>
							<h3 class="service_banner">
								<a href="?page=service&l_id=<?php echo $_GET['l_id'] ?>" style="float: left; color:#fed136;"><i class="fa fa-arrow-left"></i>&nbsp;&nbsp;&nbsp;</a><?php echo $title?>
							</h3>
							<div style="display:flex; margin-bottom: 15px;">
								<h3 style="margin: auto 0px auto 0px;" >
									<?php
										$past_month = date('Y-m', strtotime("first day of -2 month"));
										if($ym != $past_month): 
									?>
										<a href="?page=service&l_id=<?php echo $_GET['l_id'] ?>&srvc_id=<?php echo $_GET['srvc_id'] ?>&ym=<?php echo $prev; ?>"><i class='fas fa-caret-left' style="font-size:30px;"></i></a> 
									<?php 
										endif;
										echo $html_title;
									?> 
										<a href="?page=service&l_id=<?php echo $_GET['l_id'] ?>&srvc_id=<?php echo $_GET['srvc_id'] ?>&ym=<?php echo $next; ?>"><i class='fas fa-caret-right' style="font-size:30px;"></i></a>

								</h3>
								&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
								<h3 style="margin: auto 0px auto 0px;">Please select a User on the list to show specific details</h3>
							</div>
							<table class="table">
								<tr>
									<th>Sun</th>
									<th>Mon</th>
									<th>Tue</th>
									<th>Wed</th>
									<th>Thu</th>
									<th>Fri</th>
									<th>Sat</th>
								</tr>
								<?php
									foreach ($weeks as $week) {
										echo $week;
									}
								?>
							</table>
					<?php
				//End of showing specific lensman's services avail calendar (All Pending, Downpayment, Confirmed, and Rescheduling)
							endif;
							if(isset($_GET['l_id']) && isset($_GET['srvc_id']) && isset($_GET['c_id']) && !isset($_GET['action'])):
				//Start of showing specific lensman's services avail calendar of specific customer avail
							$avail_specific = $conn->query("SELECT * FROM tbl_service_avail WHERE service_id = {$_GET['srvc_id']} AND avail_id = {$_GET['avail_id']} AND user_id = {$_GET['c_id']} ");
							while($a_row=$avail_specific->fetch_assoc())
							{
								$user_id = $a_row['user_id'];
							}
							include '../calendar_function_lm.php';
					?>
							<style>
								.availed { background-color: #2C74B3; }
								.availed_others { background-color: #FFC93C; }
							</style>
							<div>
								<h3 class="service_banner">
								<a href="?page=service&l_id=<?php echo $_GET['l_id'] ?>&srvc_id=<?php echo $_GET['srvc_id'] ?>&ym=<?php echo $ym ?>" style="float: left;color:#fed136;"><i class="fa fa-arrow-left"></i>&nbsp;&nbsp;&nbsp;</a><?php echo $title?>
								</h3>
							</div>
							
							<h3 style="margin-bottom: 15px;">
					<?php 
							if($ym == $end_month && !($start_month==$end_month)): 
					?>
							<a href="?page=service&l_id=<?php echo $_GET['l_id'] ?>&srvc_id=<?php echo $_GET['srvc_id'] ?>&avail_id=<?php echo $_GET['avail_id'] ?>&c_id=<?php echo $_GET['c_id'] ?>&ym=<?php echo $prev; ?>"><i class='fas fa-caret-left' style="font-size:30px;"></i></a> 
					<?php 
							endif;
							echo $html_title; 
							if($ym == $start_month && !($start_month==$end_month)): 
					?>
							<a href="?page=service&l_id=<?php echo $_GET['l_id'] ?>&srvc_id=<?php echo $_GET['srvc_id'] ?>&avail_id=<?php echo $_GET['avail_id'] ?>&c_id=<?php echo $_GET['c_id'] ?>&ym=<?php echo $next; ?>"><i class='fas fa-caret-right' style="font-size:30px;"></i></a>
					<?php 
							endif;
							
					?>
							</h3>
							<table class="table">
								<tr>
									<th>Sun</th>
									<th>Mon</th>
									<th>Tue</th>
									<th>Wed</th>
									<th>Thu</th>
									<th>Fri</th>
									<th>Sat</th>
								</tr>
								<?php
									foreach ($weeks as $week) {
										echo $week;
									}
								?>
							</table>
					<?php
				//End of showing specific lensman's services avail calendar of specific customer avail
							endif;
			//End of showing specific lensman's services avail calendar
							endif;
							if(isset($_GET['l_id']) && isset($_GET['srvc_id']) && isset($_GET['avail_id']) && isset($_GET['c_id']) && (isset($_GET['action']) && $_GET['action']!="manage_service")):
			//Start of showing specific avail print
					?>
							<style>
								.package_banner {
									background: #114481;
									border-radius: 5px 5px 60px 5px;
									color: #fed136;
									padding: 20px;
								}

								.receipt_div {
									height: 80%;
									overflow-y: auto;
								}

								.receipt_div::-webkit-scrollbar {
									display: none;
								}
							</style>
							<div>
								<h3 class="package_banner">
									<a href="?page=service&l_id=<?php echo $_GET['l_id'] ?>&srvc_id=<?php echo $_GET['srvc_id'] ?>&avail_id=<?php echo $_GET['avail_id'] ?>&c_id=<?php echo $_GET['c_id'] ?>" style="float: left; color:#fed136;"><i class="fa fa-arrow-left"></i></a>
									&nbsp;&nbsp;&nbsp;
									Avail Receipt
								</h3>
							</div>
							<div class="receipt_div">
					<?php
							include "../Print/print.php";
					?>
							</div>
					<?php
			//End of showing specific avail print
							endif;
							if(isset($_GET['fdbk_id'])):
	//Start of showing specific lensman feedback
					?>
							<style>
								.user {
									display: flex;
									background: linear-gradient(90deg, rgba(2,0,36,1) 0%, rgba(20,102,193,1) 50%, rgba(0,224,255,1) 100%);
									border-radius: 5px 5px 5px 5px;
									color: #fed136;
									font-weight: bold;
									align-items: center;
									padding: 20px;
									font-size: 50px;
								}

								.lensman_name {
									margin-left: 25px; 
									font-size: 30px;
								}

								.rating_stats {
									margin-left: 70px;
									display: flex;
									flex-direction: column;
									justify-content: space-evenly;
								}

								.rating_stats > * {
									text-align: center !important;
									margin: 0px !important;
								}

								.rating_stats p {
									font-size: 30px !important;
								}

								.rating_stats .stars {
									font-size: 20px !important;
									color: black !important;
								}

								.rating_stats h6 {
									padding: 7px;
									font-size: 20px !important;
								}

								.rating_count {
									margin-left: 70px; 
									font-size: 15px !important;
									display: flex;
									flex-direction: column;
									justify-content: space-evenly;
								}

								.rating_count > * {
									margin: auto;
									padding: 5px;
								}

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
							<div style="display: flex; flex-direction: row; justify-content: space-between;">
							<h3>
								<a href="?page=service" style="float: left;"><i class="fa fa-arrow-left"></i></a>
								<br />
							</h3>
							<h2 style="width:60%;">Lensman Ratings</h2>
							</div>
					<?php
							
							$lensman = $conn->query("SELECT `user_profile_image`, CONCAT(`user_first_name` , ' ', `user_last_name`) as user_name, `user_type` FROM tbl_user_account WHERE `user_id` = {$_GET['fdbk_id']} ");
							while($l_row = $lensman->fetch_assoc()):
					?>
								<div class="user">
									<img src="../../images/profile-images/<?php echo $l_row['user_profile_image'] ?>" alt="" style="width: 120px; height: 120px; background:center; background-size: cover; object-fit: cover; object-position: 0 -0%; border-radius: 50%;">
									<p class="lensman_name"><?php echo $l_row['user_name'] ?></p>
					<?php
							endwhile;
							$reviews_num = $conn->query("SELECT * FROM tbl_feedback WHERE  `lensman_id` = {$_GET['fdbk_id']}")->num_rows;
							$reviews = $conn->query("SELECT AVG(feedback_rate) as average, SUM(if(feedback_rate = 5,1,0)) as r5, SUM(if(feedback_rate = 4,1,0)) as r4,
							SUM(if(feedback_rate = 3,1,0)) as r3, SUM(if(feedback_rate = 2,1,0)) as r2, SUM(if(feedback_rate = 1,1,0)) as r1 FROM tbl_feedback WHERE  `lensman_id` = {$_GET['fdbk_id']}");
							while($r_rows=$reviews->fetch_assoc())
							{
								$average = $r_rows['average'];
								($r_rows['r1']!=0) ? $r1 = $r_rows['r1'] : $r1 = 0;
								($r_rows['r2']!=0) ? $r2 = $r_rows['r2'] : $r2 = 0;
								($r_rows['r3']!=0) ? $r3 = $r_rows['r3'] : $r3 = 0;
								($r_rows['r4']!=0) ? $r4 = $r_rows['r4'] : $r4 = 0;
								($r_rows['r5']!=0) ? $r5 = $r_rows['r5'] : $r5 = 0;
							}
					?>
							<div class="rating_stats">
							<p><?php echo number_format((float)$average, 2, '.', '')?></p>
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
							<h6><?php echo $reviews_num ?> review/s</h6>
							</div>
								<div class="rating_count">
					<?php
							for($i = 1; $i <= 5; $i++):
							if($i==1){$r_num = $r5; $n = 5;}
							if($i==2){$r_num = $r4; $n = 4;}
							if($i==3){$r_num = $r3; $n = 3;}
							if($i==4){$r_num = $r2; $n = 2;}
							if($i==5){$r_num = $r1; $n = 1;}
					?>
							<p><?php echo $n; ?> <i class="fas fa-star text-warning"></i> ( <?php echo $r_num; ?> )</p>
					<?php
							endfor;
					?>
								</div>
							</div>
							<div class="c_fdbk">
								<h2 style="padding-top: 10px;">Customer Feedback/s</h2>
								<div class="dropdownf">
									<button class="dropbtnf">Sort Ratings</button>
									<div class="dropdown-contentf">
									<a href="?page=service&fdbk_id=<?php echo $_GET['fdbk_id'] ?>">All ( <?php echo $reviews_num ?> )</a>
										<a href="?page=service&fdbk_id=<?php echo $_GET['fdbk_id'] ?>&sort=5">5 <i class="fas fa-star text-warning"></i> ( <?php echo $r5; ?> )</a>
										<a href="?page=service&fdbk_id=<?php echo $_GET['fdbk_id'] ?>&sort=4">4 <i class="fas fa-star text-warning"></i> ( <?php echo $r4; ?> )</a>
										<a href="?page=service&fdbk_id=<?php echo $_GET['fdbk_id'] ?>&sort=3">3 <i class="fas fa-star text-warning"></i> ( <?php echo $r3; ?> )</a>
										<a href="?page=service&fdbk_id=<?php echo $_GET['fdbk_id'] ?>&sort=2">2 <i class="fas fa-star text-warning"></i> ( <?php echo $r2; ?> )</a>
										<a href="?page=service&fdbk_id=<?php echo $_GET['fdbk_id'] ?>&sort=1">1 <i class="fas fa-star text-warning"></i> ( <?php echo $r1; ?> )</a>
									</div>
								</div>
							</div>
					<?php
							if($reviews_num != 0):
		//Start of if theres feedbacks taken from the db
							if(isset($_GET['sort'])):
			//Start of showing the sorted feedback according to their stars
							$fdbk_sort_num = $conn->query("SELECT * FROM tbl_feedback WHERE  `lensman_id` = {$_GET['fdbk_id']} AND `feedback_rate` = {$_GET['sort']}")->num_rows;	
							if($reviews_num != 0 && $fdbk_sort_num != 0):
				//Start of if theres feedbacks taken from the db according to their stars
							$reviews = $conn->query("SELECT * FROM tbl_feedback WHERE  `lensman_id` = {$_GET['fdbk_id']} AND `feedback_rate` = {$_GET['sort']} ORDER BY `feedback_date` DESC");
							while($row=$reviews->fetch_assoc()):
							$user = $conn->query("SELECT CONCAT(`user_first_name` , ' ', `user_last_name`) as user_name, `user_profile_image` from tbl_user_account WHERE `user_id` = {$row['user_id']}");
							while($u_row=$user->fetch_assoc()):
							$fdbk_date = date("M d, Y", strtotime($row['feedback_date']));
							$fdbk_time = date("h:i A", strtotime($row['feedback_date']));
							(!empty($row['feedback_message'])) ? $msg = true : $msg = false;
					?>
							<div class="feedback_container">
							<div>
								<img src="../../images/profile-images/<?php echo $u_row['user_profile_image'] ?>" style="float:left; border-radius: 90%; width:50px; height:50px; background: center; background-size: cover; object-fit: cover;"/> 
								<div class="user_info" style="display:inline-block;">
									<h5 class="user_avail_info"><?php echo $u_row['user_name'] ?></h5>
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
				//End of if theres feedbacks taken from the db according to their stars
							else:
					?>
							<div style="text-align: center; box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.5), 0 6px 20px 0 rgba(0, 0, 0, 0.19);; height: auto; position: relative; display: flex; flex-direction: column; justify-content: center;">
								<h3>No <?php echo $_GET['sort'] ?> Star Rating Reviews Yet...</h3>
							</div>
					<?php
							endif;
			//End of showing the sorted feedback according to their stars
							else:
			//Start of showing all feedbacks
							$reviews = $conn->query("SELECT * FROM tbl_feedback WHERE  `lensman_id` = {$_GET['fdbk_id']} ORDER BY `feedback_date` DESC");
							while($row=$reviews->fetch_assoc()):
							$user = $conn->query("SELECT CONCAT(`user_first_name` , ' ', `user_last_name`) as user_name, `user_profile_image` from tbl_user_account WHERE `user_id` = {$row['user_id']}");
							while($u_row=$user->fetch_assoc()):
							$fdbk_date = date("M d, Y", strtotime($row['feedback_date']));
							$fdbk_time = date("h:i A", strtotime($row['feedback_date']));
							(!empty($row['feedback_message'])) ? $msg = true : $msg = false;
					?>
							<div class="feedback_container">
							<div>
								<img src="../../images/profile-images/<?php echo $u_row['user_profile_image'] ?>" style="float:left; border-radius: 90%; width:50px; height:50px; background: center; background-size: cover; object-fit: cover;"/> 
								<div class="user_info" style="display:inline-block;">
									<h5 class="user_avail_info"><?php echo $u_row['user_name'] ?></h5>
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
		//End of if theres feedbacks taken from the db
							else:
					?>
							<div style="text-align: center; box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.5), 0 6px 20px 0 rgba(0, 0, 0, 0.19);; height: auto; position: relative; display: flex; flex-direction: column; justify-content: center;">
									<h3>No Reviews Yet...</h3>
							</div>
					<?php
							endif;
	//End of showing specific lensman feedback
							endif;
					?>
				</div>
			</div>
		</div>
	
	
		<?php 
			if(isset($_GET['l_id']) && isset($_GET['srvc_id']) && !isset($_GET['c_id']) && !isset($_GET['feedback']) && !isset($_GET['action'])):
	//Start of showing the list of avails
		?>
				<div class="right-panel py-2 px-2">
					<div class="container-fluid" style="height: inherit;">
						<div class="col-md-12" style="height: 100%;">
							<style>
								.top_banner {
									display: flex;
									justify-content: space-between;
									background: #114481;
									border-radius: 60px 5px 5px 5px;
									color: #fed136; 
									padding: 20px;
									text-align: right;
								}

								.avail_list_banner {
									overflow-y: auto;
								}

								.avail_list_container {
									height: 86%; 
									overflow-y: auto;
								}

								.avail_list_banner::-webkit-scrollbar, .avail_list_container::-webkit-scrollbar {
									display: none;
								}

								.user_link {
									color: black;
									background-color: rgba(33, 150, 243, 0.4);
									border-radius: 5px	;
									padding: 10px 20px 10px 20px;
									margin-bottom: 10px;
									display: block;font-weight: bolder !important;
								}

								.user_link:hover {
								background: #114481;
								color: #fed136; 
								}

								.user_avail_info {
								padding-left: 10px
								}

								.user_avail_info:nth-child(3) {
								margin: 0px !important;
								}

								.dropbtnf {
									background-color: #205295;
									color: #fed136;
									padding: 7.5px 15px 7.5px 15px;
									font-size: 16px;
									font-weight: 650;
									border: none !important;
									border-radius: 15px;
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
									font-size: 16px;
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
							<h3 class="top_banner">
						<?php
								if(isset($_GET['sort']))
								{
									if($_GET['sort']=='Pending'){ $sort_name = "Pending"; }
									if($_GET['sort']=='Downpayment'){ $sort_name = "Downpayment"; }
									if($_GET['sort']=='Confirmed'){ $sort_name = "Confirmed"; }
									if($_GET['sort']=='Completed'){ $sort_name = "Completed"; }
									if($_GET['sort']=='Cancelled'){ $sort_name = "Cancelled"; }
									if($_GET['sort']=='Resched'){ $sort_name = "Resched"; }
								}
								else
								{
									$sort_name = "Sort Avails";
								}
						?>
								<div class="dropdownf">
									<button class="dropbtnf"><?php echo $sort_name ?>&nbsp;&nbsp;<i class="fa fa-angle-down"></i></button>
									<div class="dropdown-contentf">
										<a href="?page=service&l_id=<?php echo $_GET['l_id'] ?>&srvc_id=<?php echo $_GET['srvc_id'] ?>&ym=<?php echo $ym ?>">All</a>
										<a href="?page=service&l_id=<?php echo $_GET['l_id'] ?>&srvc_id=<?php echo $_GET['srvc_id'] ?>&ym=<?php echo $ym ?>&sort=Pending">Pending</a>
										<a href="?page=service&l_id=<?php echo $_GET['l_id'] ?>&srvc_id=<?php echo $_GET['srvc_id'] ?>&ym=<?php echo $ym ?>&sort=Downpayment">Waiting for Downpayment</a>
										<a href="?page=service&l_id=<?php echo $_GET['l_id'] ?>&srvc_id=<?php echo $_GET['srvc_id'] ?>&ym=<?php echo $ym ?>&sort=Confirmed">Confirmed</a>
										<a href="?page=service&l_id=<?php echo $_GET['l_id'] ?>&srvc_id=<?php echo $_GET['srvc_id'] ?>&ym=<?php echo $ym ?>&sort=Completed">Completed</a>
										<a href="?page=service&l_id=<?php echo $_GET['l_id'] ?>&srvc_id=<?php echo $_GET['srvc_id'] ?>&ym=<?php echo $ym ?>&sort=Cancelled">Cancelled</a>
										<a href="?page=service&l_id=<?php echo $_GET['l_id'] ?>&srvc_id=<?php echo $_GET['srvc_id'] ?>&ym=<?php echo $ym ?>&sort=Resched">Resched</a>
									</div>
								</div>
								<p style="margin: 0 0 0 0 !important;">Avail List</p>
							</h3>
						<?php
								$avails_num = $conn->query("SELECT * FROM tbl_service_avail WHERE  `service_id` = {$_GET['srvc_id']}")->num_rows;
								
								if($avails_num != 0):
						?>
								<div class="avail_list_container">
						<?php
								if(isset($_GET['sort']))
								{
									if($_GET['sort']=='Pending')
									{
										$sort = "WHERE `avail_status` = 0 AND `service_id` = ".$_GET['srvc_id']." ORDER BY `avail_id` DESC";
									}
									if($_GET['sort']=='Downpayment')
									{
										$sort = "WHERE `avail_status` = 1 AND `service_id` = ".$_GET['srvc_id']." ORDER BY `avail_id` DESC";
									}
									if($_GET['sort']=='Confirmed')
									{
										$sort = "WHERE `avail_status` = 2 AND `service_id` = ".$_GET['srvc_id']." ORDER BY `avail_id` DESC";
									}
									if($_GET['sort']=='Completed')
									{
										$sort = "WHERE `avail_status` = 3 AND `service_id` = ".$_GET['srvc_id']." ORDER BY `avail_id` DESC";
									}
									if($_GET['sort']=='Cancelled')
									{
										$sort = "WHERE `avail_status` = 4 AND `service_id` = ".$_GET['srvc_id']." ORDER BY `avail_id` DESC";
									}
									if($_GET['sort']=='Resched')
									{
										$sort = "WHERE `avail_status` = 5 AND `service_id` = ".$_GET['srvc_id']." ORDER BY `avail_id` DESC";
									}
								}
								else
								{
									$sort = "WHERE  `service_id` = ".$_GET['srvc_id']." ORDER BY `avail_status` ASC";
								}
								$avails_specific_num = $conn->query("SELECT * FROM tbl_service_avail $sort ")->num_rows;
								if($avails_specific_num != 0):
								$avails = $conn->query("SELECT * FROM tbl_service_avail $sort ");
								while($row=$avails->fetch_assoc()):
								$user = $conn->query("SELECT `user_first_name`, `user_last_name`, `user_profile_image` from tbl_user_account WHERE `user_id` = {$row['user_id']}");
								while($u_row=$user->fetch_assoc()):
								$start = date("M d, Y", strtotime($row['avail_starting_date_time']));
								$end = date("M d, Y", strtotime($row['avail_ending_date_time']));
								$year_month = date("Y-m", strtotime($row['avail_starting_date_time']));
								($start == $end) ? $date = $start : $date = $start . ' - ' . $end;
								if($row['avail_status']==0){ $stat = "Pending"; }if($row['avail_status']==1){ $stat = "Waiting for downpayment proof"; }
								if($row['avail_status']==2){ $stat = "Confirmed"; }if($row['avail_status']==3){ $stat = "Completed"; }
								if($row['avail_status']==4){ $stat = "Cancelled"; }if($row['avail_status']==5){ $stat = "Request for Reschedule"; }
						?>
								<a class="user_link" href="?page=service&l_id=<?php echo $_GET['l_id'] ?>&srvc_id=<?php echo $_GET['srvc_id'] ?>&ym=<?php echo $year_month ?>&avail_id=<?php echo $row['avail_id'] ?>&c_id=<?php echo $row['user_id'] ?>">
									<img src="../../images/profile-images/<?php echo $u_row['user_profile_image'] ?>" style="float:left; border-radius: 90%; width:50px; height:50px; background: center; background-size: cover; object-fit: cover;"/> 
									<div class="user_avail_tab" style="display:inline-block;">
										<h5 class="user_avail_info"><?php echo ucwords($u_row['user_first_name'] . ' ' . $u_row['user_last_name']) ?></h5>
										<h6 class="user_avail_info"><?php echo $date ?></h6>
										<h6 class="user_avail_info"><?php echo $stat ?></h6>
									</div>
								</a>
						<?php
								endwhile;
								endwhile;
								else:
						?>
								<div class="avail_list_banner" style="text-align: center; box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.5), 0 6px 20px 0 rgba(0, 0, 0, 0.19);; height: auto; position: relative; display: flex; flex-direction: column; justify-content: center;">
									<h4>No Avails Yet...</h4>
								</div>
								
						<?php
								endif;
						?>
								</div>
						<?php
								else:
						?>
								<div class="avail_list_banner" style="text-align: center; box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.5), 0 6px 20px 0 rgba(0, 0, 0, 0.19);; height: auto; position: relative; display: flex; flex-direction: column; justify-content: center;">
									<h4>No Avails Yet...</h4>
								</div>
								
						<?php
								endif;
						?>	
						</div>
					</div>	
				</div>
		<?php
	//End of showing the list of avails
			endif;
			if(isset($_GET['l_id']) && isset($_GET['srvc_id']) && isset($_GET['c_id']) && !isset($_GET['feedback'])):
	//Start of showing the details of specific avail
		?>
				<div class="right-panel py-2 px-2">
					<div class="container-fluid" style="height: inherit">
						<div class="col-md-12" style="height: 100%; padding-bottom: 20px;">
							<style>
								.top_banner {
									background: #114481;
									border-radius: 60px 5px 5px 5px;
									color: #fed136; 
									padding: 20px;
									text-align: right;
								}

								.user_avail_container {
									height: 84%; 
									color: black;
									background-color: rgba(33, 150, 243, 0.4);
									border-radius: 5px;
									padding: 20px;
									margin-bottom: 10px;
									text-align: center;
									overflow-y: auto;
								}

								.user_avail_container::-webkit-scrollbar {
									display: none;
								}

								.user_avail_container img {
									float:left; 
									border-radius: 90%; 
									width:50px; 
									height:50px; 
									background: center; 
									background-size: cover; 
									object-fit: cover;
								}

								.user_avail_container {
									font-weight: 700;
								}

								.user_avail_details {
									margin-top: 20px;
								}

								.user_avail_details h6{
									margin-bottom: 20px;
								}

								.avail_note {
									word-wrap: break-word !important; 
									height: fit-content;
									background-color: rgba(33, 150, 243, 0.2);
									border-radius: 5px;
									padding: 10px;
									overflow-y: auto;
								}

								.avail_buttons {
									margin-top: 20px;
								}

								.avail_buttons button {
									border: none;
									border-radius: 5px;
									background: #114481;
									color: #fed136;
									padding: 5px 10px 5px 10px;
									font-size: 20px;
									font-weight: 500;
								}

								.avail_buttons button:not(button:first-child) {
									margin-left: 2rem;
								}

								.swal2-actions > * {font-weight: bolder !important;}
								.swal2-confirm:focus { box-shadow: none !important; }
								.swal2-confirm { background-color: #114481 !important;  padding: 10px !important;}
								.swal2-cancel { background-color: crimson !important; padding: 10px !important;}

								.showAvailSwalCont {
									font-family: 'Mulish' !important;
								}
							
								.showAvailSwalTitle{
									font-size: 22.5px;
									text-align: left !important; 
									color: black;
									margin-top: 0 !important;
								}

								#cancelReason {
									resize: none;
								}

								.down-payment{
									border: none;
									border-radius: 5px;
									background: #114481;
									color: #fed136;
									padding: 5px 10px 5px 10px;
									font-size: 20px;
									font-weight: 500;
								}
							</style>
							<h3 class="top_banner">Avail Details</h3>
						<?php
								$avails = $conn->query("SELECT * FROM tbl_service_avail WHERE  `avail_id` = {$_GET['avail_id']} AND `user_id` = {$_GET['c_id']}");
								while($row=$avails->fetch_assoc()):
								$user = $conn->query("SELECT `user_first_name`, `user_last_name`, `user_profile_image` from tbl_user_account WHERE `user_id` = {$_GET['c_id']}");
								while($u_row=$user->fetch_assoc()):
								$start = date("F d, Y", strtotime($row['avail_starting_date_time']));
								$start_time = date("h:i A", strtotime($row['avail_starting_date_time']));
								$end = date("F d, Y", strtotime($row['avail_ending_date_time']));
								$end_time = date("h:i A", strtotime($row['avail_ending_date_time']));
								if($row['avail_status']==0){ $stat = "Pending"; }if($row['avail_status']==1){ $stat = "Waiting for downpayment proof"; }
								if($row['avail_status']==2){ $stat = "Confirmed"; }if($row['avail_status']==3){ $stat = "Completed"; }
								if($row['avail_status']==4){ $stat = "Cancelled"; }if($row['avail_status']==5){ $stat = "Request for Reschedule"; }
								(!empty($row['avail_note'])) ? $avail_note = $row['avail_note'] : $avail_note = "n/a";
								(strlen($row['avail_note']) > 30) ? $note = "text-align: justify;" : $note = "";
								(strlen($row['avail_cancel_reason']) > 30) ? $reason = "text-align: justify;" : $reason = "";
						?>
								<div class="user_avail_container">
									<div class="user_avail_profile">
										<img src="../../images/profile-images/<?php echo $u_row['user_profile_image'] ?>"/> 
										<div class="user_avail_tab" style="display:inline-block; margin-top: 10px">
											<h5 style="padding-left: 10px; font-size:20px; font-weight: 650; word-wrap: break-word"><?php echo ucwords($u_row['user_first_name'] . ' ' . $u_row['user_last_name']) ?></h5>
										</div>
									</div>
									<div class="user_avail_details">
										<span>Avail Start Sched</span>
										<h6><?php echo $start ?> ( <?php echo $start_time ?> )</h6>
										<span>Avail End Sched</span>
										<h6><?php echo $end ?> ( <?php echo $end_time ?> )</h6>
										<span>Avail Status</span>
										<h6><?php echo $stat ?></h6>
										<span>Avail Note</span>
										<h6 class="avail_note" style="<?php echo $note ?>"><?php echo nl2br($avail_note) ?></h6>
						<?php
								if(($row['avail_status'] == 1 || $row['avail_status'] == 2 || $row['avail_status'] == 4 || $row['avail_status'] == 5) && !is_null($row['avail_downpayment_image'])): 
								$src = $row['avail_downpayment_image'];
								$cust_name = ucwords($u_row['user_first_name'] . ' ' . $u_row['user_last_name']);
						?>
										<div id="downpayment_img_src" style="display: none;"><?php echo $src ?></div>
										<div id="customer_name" style="display: none;"><?php echo $cust_name ?></div>
										<p>Downpayment Image:</p>
										<button class="down-payment" onclick="showDownpaymentImage()">Show Image</button><br />
						<?php
								endif;
								if($row['avail_status'] == 4)
								{
						?>
									<span>Avail Cancel Reason</span>
									<h6 class="avail_note" style="<?php echo $reason ?>"><?php echo nl2br($row['avail_cancel_reason']) ?></h6>
						<?php
								}
						?>
									</div>
									<div class="avail_buttons">
						<?php
								if(!isset($_GET['action'])):
								if($row['avail_status'] == 0):
						?>
									<button onclick="actionBtnPending(<?php echo $row['avail_id'] ?>)">Actions</button>
						<?php
								endif;
								if($row['avail_status'] == 1 && !is_null($row['avail_downpayment_image'])):
						?>
									<button onclick="actionBtnDownPaymentPaid(<?php echo $row['avail_id'] ?>)">Confirm</button>
						<?php
								endif;
								if($row['avail_status'] == 2):
						?>
									<button onclick="actionBtnComplete(<?php echo $row['avail_id'] ?>)">Complete</button>
						<?php
								endif;
								if($row['avail_status'] == 3):
						?>
									<button onclick="location.href='?page=service&l_id=<?php echo $_GET['l_id'] ?>&srvc_id=<?php echo $_GET['srvc_id'] ?>&avail_id=<?php echo $row['avail_id'] ?>&c_id=<?php echo $row['user_id'] ?>&action=showreceipt';">Receipt</button>
						<?php
								endif;
								if($row['avail_status'] == 4 && !is_null($row['avail_downpayment_image'])):
						?>
									<button onclick="location.href='?page=service&l_id=<?php echo $_GET['l_id'] ?>&srvc_id=<?php echo $_GET['srvc_id'] ?>&avail_id=<?php echo $row['avail_id'] ?>&c_id=<?php echo $row['user_id'] ?>&action=showreceipt';">Receipt</button>
						<?php
								endif;
								if($row['avail_status'] == 5):
						?>
									<button onclick="actionBtnResched(<?php echo $row['avail_id'] ?>)">Actions</button><br />
						<?php
								endif;
								else:
						?>
									<button onclick="var p = window.open('../Print/Invoice.php?avail_id=<?php echo $_GET['avail_id'] ?>&srvc_id=<?php echo $_GET['srvc_id'] ?>');">Print</button>
						<?php
								endif;
						?>
										</div>
									</div>
						<?php
								endwhile;
								endwhile;
						?>	
							<script>
								function actionBtnPending(id)
								{
									Swal.fire({
										title: 'Which Action you want to perform?',
										showCancelButton: true,
										showCloseButton: true,
										confirmButtonText: 'Proceed to Downpayment',
										cancelButtonText: 'Cancel Avail',
									}).then((result) => {
										if (result.isConfirmed) {
											Swal.fire({
												title: 'Accept this Availed Schedule?',
												confirmButtonText: `Continue`,
												showCancelButton: true,
											}).then((result) => {
												if (result.isConfirmed) {
													var formData = {
														avail_id: id,
														//receiver is the one who gonna receive the notification, 
														//in this case it will be the customer who will receive the notification
														notification_receiver: '<?php echo $_GET['c_id'] ?>',
													};
													start_load()
													$.ajax({
														url:'ajax.php?action=proceed_to_downpayment',
														method:'POST',
														data: formData,
														success:function(resp){
															if(resp==1){
																alert_toast("Avail successfully updated",'success')
																setTimeout(function(){
																	location.reload()
																},1500)
															}
														}
													})
												}
											})
										}
										if (result.dismiss == 'cancel') {
											Swal.fire({
												customClass: {
													container: 'showAvailSwalCont',
													title: 'showAvailSwalTitle',
												},
												title: "Avail Cancellation",
												confirmButtonText: "Submit",
												showCloseButton: true,
												allowOutsideClick: false,
												html:
													'<textarea id="cancelReason" rows=10 cols=40 placeholder="Please enter your reason here for your cancellation...">'+
													'</textarea>',
												preConfirm: () => {
													var text = document.getElementById("cancelReason");
													var value = text.value;
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
													//alert(fvalue)
													var formData = {
														avail_id: id,
														//receiver is the one who gonna receive the notification, 
														//in this case it will be the customer who will receive the notification
														notification_receiver: '<?php echo $_GET['c_id'] ?>',
														avail_cancel_reason: value,
													};
													start_load()
													$.ajax({
														url:"ajax.php?action=cancel_avail_lm",
														method: 'POST',
														data: formData,
														success:function(resp){
															console.log(resp)
															end_load()
															if(resp == 1){
																alert_toast("Avail successfully updated",'success')
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
									})
								}

								function actionBtnDownPaymentPaid(id)
								{
									Swal.fire({
										title: 'Fully Confirm this Availed Schedule?',
										confirmButtonText: `Continue`,
										showCloseButton: true,
									}).then((result) => {
										if (result.isConfirmed) {
											var formData = {
												avail_id: id,
												//receiver is the one who gonna receive the notification, 
												//in this case it will be the customer who will receive the notification
												notification_receiver: '<?php echo $_GET['c_id'] ?>',
											};
											start_load()
											$.ajax({
												url:'ajax.php?action=confirm_avail',
												method:'POST',
												data: formData,
												success:function(resp){
													if(resp==1){
														alert_toast("Avail successfully updated",'success')
														setTimeout(function(){
															location.reload()
														},1500)
													}
												}
											})
										}
									})
								}

								function actionBtnComplete(id)
								{
									Swal.fire({
										title: 'Complete this Availed Schedule?',
										confirmButtonText: `Continue`,
										showCloseButton: true,
									}).then((result) => {
										if (result.isConfirmed) {
											var formData = {
												avail_id: id,
												//receiver is the one who gonna receive the notification, 
												//in this case it will be the customer who will receive the notification
												notification_receiver: '<?php echo $_GET['c_id'] ?>',
											};
											start_load()
											$.ajax({
												url:'ajax.php?action=complete_avail',
												method:'POST',
												data: formData,
												success:function(resp){
													if(resp==1){
														alert_toast("Avail successfully updated",'success')
														setTimeout(function(){
															location.reload()
														},1500)
													}
												}
											})
										}
									})
								}

								function actionBtnResched(id)
								{
									Swal.fire({
										title: 'Which Action you want to perform?',
										showCancelButton: true,
										showCloseButton: true,
										confirmButtonText: 'Accept Resched',
										cancelButtonText: 'Deny Resched',
									}).then((result) => {
										if (result.isConfirmed) {
											Swal.fire({
												title: 'Accept this Rescheduled Avail request?',
												confirmButtonText: `Continue`,
												showCloseButton: true,
											}).then((result) => {
												if (result.isConfirmed) {
													var formData = {
														avail_id: id,
														//receiver is the one who gonna receive the notification, 
														//in this case it will be the customer who will receive the notification
														notification_receiver: '<?php echo $_GET['c_id'] ?>',
													};
													start_load()
													$.ajax({
														url:'ajax.php?action=resched_avail_lm',
														method:'POST',
														data: formData,
														success:function(resp){
															if(resp==1){
																alert_toast("Avail successfully updated",'success')
																setTimeout(function(){
																	location.reload()
																},1500)
															}
														}
													})
												}
											})
										}
										if (result.dismiss == 'cancel') {
											Swal.fire({
												title: 'Deny this Rescheduled Avail request?',
												confirmButtonText: `Continue`,
												showCloseButton: true,
											}).then((result) => {
												if (result.isConfirmed) {
													var formData = {
														avail_id: id,
														//receiver is the one who gonna receive the notification, 
														//in this case it will be the customer who will receive the notification
														notification_receiver: '<?php echo $_GET['c_id'] ?>',
													};
													start_load()
													$.ajax({
														url:'ajax.php?action=deny_resched_avail_lm',
														method:'POST',
														data: formData,
														success:function(resp){
															if(resp==1){
																alert_toast("Avail successfully updated",'success')
																setTimeout(function(){
																	location.reload()
																},1500)
															}
														}
													})
												}
											})
										}
									})
								}

								function actionBtnConfirmResched(id)
								{
									Swal.fire({
										title: 'Accept this Rescheduled Avail request?',
										confirmButtonText: `Continue`,
										showCloseButton: true,
									}).then((result) => {
										if (result.isConfirmed) {
											var formData = {
												avail_id: id,
												//receiver is the one who gonna receive the notification, 
												//in this case it will be the customer who will receive the notification
												notification_receiver: '<?php echo $_GET['c_id'] ?>',
											};
											start_load()
											$.ajax({
												url:'ajax.php?action=resched_avail_lm',
												method:'POST',
												data: formData,
												success:function(resp){
													if(resp==1){
														alert_toast("Avail successfully updated",'success')
														setTimeout(function(){
															location.reload()
														},1500)
													}
												}
											})
										}
									})
								}

								function showDownpaymentImage()
								{
									var src = document.getElementById('downpayment_img_src').innerHTML;
									var name = document.getElementById('customer_name').innerHTML;
									Swal.fire({
										title: name+"\'s downpayment proof",
										html: "<img src='../assets/payment/"+src+"' style='border: 2px solid black; width: 400px; height: 400px; object-fit:contain;'>",
										showConfirmButton: false,
										showCloseButton: true,
									});
								}
							</script>

						</div>
					</div>	
				</div>
		<?php
	//End of showing the details of specific avail
			endif;
		?>
	
	
		
		