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
		((isset($_GET['fdbk_id']) || !isset($_GET['l_id']) && !isset($_GET['fdbk_id']) || isset($_GET['l_id']) && !isset($_GET['srvc_id'])) || (isset($_GET['l_id']) && isset($_GET['srvc_id']) && isset($_GET['avail_id']) && isset($_GET['action'])) || isset($_GET['feedback']))
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
							if(isset($_GET['search'])):
				//Start of showing the lensman/s who has similar characters you typed in search
					?>
							<div class="grid-container">
					<?php
							$item = $_GET['search'];
							$lens = $conn->query("SELECT * from tbl_user_account WHERE (user_first_name LIKE '%$item%' OR user_last_name LIKE '%$item%' OR user_nickname LIKE '%$item%' OR user_studio_name LIKE '%$item%') AND user_type = 'Lensman' AND user_archive_status = '1' ORDER BY user_id ASC");
							while($row=$lens->fetch_assoc()):
							$reviews = $conn->query("SELECT AVG(feedback_rate) as average FROM tbl_feedback WHERE  `lensman_id` = {$row['user_id']}");
							while($r_rows=$reviews->fetch_assoc())
							{
								$ave = $r_rows['average'];
							}
					?>
							<div class="item">
							<img src="../../images/profile-images/<?php echo $row['user_profile_image'] ?>" alt="" style="max-width: 150px; max-height: 150px; width: 150px; height: 150px; background:center; background-size: cover; object-fit: fit; object-position: 0 -0%; border-radius: 50%">
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
				//End of showing the lensman/s who has similar characters you typed in search
							else:
				//Start of showing all lensman
					?>
							<div class="grid-container">
					<?php
							$lens = $conn->query("SELECT A.*, AVG(F.feedback_rate) as average FROM tbl_feedback as F RIGHT JOIN tbl_user_account AS A ON F.lensman_id = A.user_id WHERE A.user_type='Lensman' AND A.user_verified = 1 AND A.user_archive_status = 1 GROUP BY A.user_id ORDER BY average DESC;");
							while($row=$lens->fetch_assoc()):
							$reviews = $conn->query("SELECT AVG(feedback_rate) as average FROM tbl_feedback WHERE  `lensman_id` = {$row['user_id']}");
							while($r_rows=$reviews->fetch_assoc())
							{
								$ave = $r_rows['average'];
							}
					?>
							<div class="item">
								<img src="../../images/profile-images/<?php echo $row['user_profile_image'] ?>" alt="" style="width: 150px; height: 150px;background:center; background-size: cover; object-fit: cover; object-position: 0 -0%; border-radius: 50%">
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
								<p><img src="../assets/icons/name-icon.png" alt="icon" style="width: 30px; height:auto; margin-right:5px; margin-bottom:5px;"><?php echo ucwords($row['user_first_name']) . ' ' . ucwords($row['user_last_name']) ?></p>
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
							if(isset($_GET['l_id']) && !isset($_GET['srvc_id'])):
			//Start of showing the lensman and his/her services
							$s_id = $_GET['l_id'];
							$user = $conn->query("SELECT * FROM tbl_user_account WHERE `user_id` = '$s_id' AND user_archive_status = '1' ");
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
							<div style="display: flex; flex-direction: row; justify-content: space-between;">
							<h3>
								<a href="?page=service" style="float: left;"><i class="fa fa-arrow-left"></i></a>
								<br />
							</h3>
							<h2 style="width:58%;">Hire Lensman</h2>
							</div>
							<div class="user">
								<div class="user-container">
									<div style="text-align: left;">
										<img src="../../images/profile-images/<?php echo $row['user_profile_image'] ?>" alt="" style="width: 170px; height: 170px; background:center; background-size: cover; object-fit: cover; object-position: 0 -0%; border-radius: 50%; margin-bottom: 10px; border: 2px solid black;">
										<p><img style="width:30px; height: auto;" src="https://cdn-icons-png.flaticon.com/512/7716/7716975.png" alt=""></a> <?php echo ucwords($row['user_first_name']) . ' ' . ucwords($row['user_last_name']) ?></p>
										<p><img style="width:30px; height: auto;" src="https://cdn-icons-png.flaticon.com/512/3719/3719116.png" alt=""> <?php echo $row['user_email'] ?></p>
										<p><img style="width:30px; height: auto;" src="https://cdn-icons-png.flaticon.com/512/2453/2453535.png" alt=""> <?php echo $row['user_studio_name'] ?></p>
										<p><img style="width:30px; height: auto;" src="https://cdn-icons-png.flaticon.com/512/1198/1198464.png" alt=""> <?php echo $row['user_address'] ?></p>
										<p><img style="width:30px; height: auto;" src="https://cdn-icons-png.flaticon.com/512/552/552489.png" alt=""> <?php echo 'G-Cash: '.$row['user_contact'] ?></p>						
									</div>
								<!--MAP SPECIFIC LOCATION PER USER-->
									<div style="width:65%; height:auto; margin-bottom: 20px; border-radius: 50px 50px 0 0" id="googleMap">
									</div>								
								</div>
							</div>
							<h2 style="padding-top: 10px; text-align:center; ">Service Packages</h2>
					<?php
							endwhile;
							$services_num = $conn->query("SELECT * FROM tbl_service_packages WHERE `user_id` = '$s_id' AND service_archive_status = '1' ")->num_rows;
							$services = $conn->query("SELECT * FROM tbl_service_packages WHERE `user_id` = '$s_id' AND service_archive_status = '1' ");
							if($services_num != 0):
					?>
							<div class="grid-container-service">
					<?php
							while($row=$services->fetch_assoc()):
							/*$txt = $row['service_description'];	
							(strlen($txt) > 30) ? $txt = substr($txt, 0, 30).'...' : $txt = $txt;*/
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
								<p><img src="../assets/icons/hours.png" alt="icon" style="width: 30px;height:auto;margin-right:5px;margin-bottom:5px;"><?php echo $row['service_hours'] .' Hours'?></p>
								</div>
								<div>
									<button onclick="location.href='<?php echo $in_sess_link ?>_dashboard.php?page=service&l_id=<?php echo $row['user_id'] ?>&srvc_id=<?php echo $row['service_id'] ?>&feedback'" type="button">Review</button>
									<button onclick="location.href='<?php echo $in_sess_link ?>_dashboard.php?page=service&l_id=<?php echo $row['user_id'] ?>&srvc_id=<?php echo $row['service_id'] ?>&ym=<?php echo $ym ?>'" type="button">Avail Service</button>
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
			//End of showing the lensman and his/her services
							endif;
							if(isset($_GET['l_id']) && isset($_GET['srvc_id']) && isset($_GET['feedback']) && !isset($_GET['action'])):
	//Start of showing specific services feedback
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

								#createRvwSrvcBtn {
									margin: auto;
									float: right;
									font-size: 35px;
									border: none;
									background-color: #fed136;
									color: #114481;
									padding: 10px 20px 10px 20px;
									font-weight: bold;
									border-radius: 15px;
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
					<?php
                            $avail_num = $conn->query("SELECT * FROM `tbl_service_avail` WHERE service_id = {$_GET['srvc_id']} AND user_id = {$_SESSION['login_user_id']} AND avail_status = 3")->num_rows;
                            ($avail_num==0) ? $btn_state = '<button id="createRvwSrvcBtn" onclick="noInfo()">Review</button>' : $btn_state = '<button id="createRvwSrvcBtn" onclick="createReviewService()">Review</button>';
                            echo $btn_state;
					?>
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
					?>
							<script>
								function noInfo()
								{
									alert_toast("No review privileges, please complete one availed service first", "error", "top-end")
								}
								function createReviewService()
								{
									uni_modal("<center><b>Review Service</b></center></center>",'create_review_srvc.php?srvc_id='+<?php echo $_GET['srvc_id'] ?>+'')
								}
							</script>
					<?php
	//End of showing specific services feedback
							endif;
							if((isset($_GET['l_id']) && isset($_GET['srvc_id']) || isset($_GET['avail_id'])) && !isset($_GET['feedback']) && !isset($_GET['action'])):
			//Start of showing specific avail calendar
							include '../calendar_function.php';
					?>
							<style>
								.service_title {
									display: flex;
									margin-bottom: 15px;
									background: #114481;
									border-radius: 5px;
									color: #fed136; 
									padding: 15px;
									font-weight: 600;
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

								.srvc_icn{
									width: 45px;	
								}

								.past { background-color: #B2B2B2; }
								.today { background-color: rgb(0, 0, 0, 0.5); }
								.availed { background-color: #2C74B3; }
								.availed_confirmed { background-color: #2C74B3; }
								.availed_downpayment { background-color: #2C74B3/*rgb(153, 0, 0, 0.4)*/; }
								.availed_cancelled { background-color: #E97777/*rgb(153, 0, 0, 0.4)*/; }
								.availed_others { background-color: #FFC93C/*rgb(254, 209, 54, 0.6)*/; }
								.empty { background-color: #B2B2B2; }
								.table th:nth-of-type(1), .table td:nth-of-type(1) { color: red; }
								/*th:nth-of-type(7), td:nth-of-type(7) {
									color: blue;
								}*/
							</style>
							<div class="tbl_container">
					<?php
							$service = $conn->query("SELECT * FROM tbl_service_packages WHERE user_id = {$_GET['l_id']} AND service_id = {$_GET['srvc_id']}");
							while($s_row=$service->fetch_assoc()):
							$service_hrs = $s_row['service_hours'];
					?>
								<h3 class="service_title">
									<a href="?page=service&l_id=<?php echo $_GET['l_id'] ?>"style="float: left; color:#fed136"><i class="fa fa-arrow-left"></i>&nbsp;&nbsp;&nbsp;</a>
									<?php echo ucwords($s_row['service_name']) . ' ( ' . $service_hrs . ' hour/s )' ?>
								</h3>
					<?php
							endwhile;
					?>
								<h3 style="margin-bottom: 15px;">
									<?php
										$past_month = date('Y-m', strtotime("first day of -1 month"));
										if($ym != $past_month): 
									?>
										<a href="?page=service&l_id=<?php echo $_GET['l_id'] ?>&srvc_id=<?php echo $_GET['srvc_id'] ?>&ym=<?php echo $prev; ?>"><i class='fas fa-caret-left' style="font-size:30px;"></i></a> 
									<?php 
										endif;
										echo $html_title;
									?> 
										<a href="?page=service&l_id=<?php echo $_GET['l_id'] ?>&srvc_id=<?php echo $_GET['srvc_id'] ?>&ym=<?php echo $next; ?>"><i class='fas fa-caret-right' style="font-size:30px;"></i></a>
								</h3>
								<div style="box-shadow: 0 4px 8px 0 rgb(0 0 0 / 50%), 0 6px 20px 0 rgb(0 0 0 / 19%)">
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
								</div>
							</div>
							<script>
								function showAvail(id)
								{
									uni_modal("<center><b>Availed Service</b></center></center>",'show_avail.php?l_id='+<?php echo $_GET['l_id'] ?>+'&srvc_id='+<?php echo $_GET['srvc_id'] ?>+'&ym='+'<?php echo $_GET['ym'] ?>'+'&avail_id='+id+'')
								}
							</script>
					<?php
			//End of showing specific avail calendar
							endif;
							if(isset($_GET['l_id']) && isset($_GET['srvc_id']) && isset($_GET['avail_id']) && !isset($_GET['feedback']) && isset($_GET['action'])):
			//Start of showing specific avail receipt
							$service = $conn->query("SELECT * FROM tbl_service_packages WHERE user_id = {$_GET['l_id']} AND service_id = {$_GET['srvc_id']}");
							while($s_row=$service->fetch_assoc()):
							$service_hrs = $s_row['service_hours'];
					?>
								<style>
									.print_title {
										display: flex;
										flex-direction: row;
										justify-content: space-between;
										background: #114481;
										border-radius: 5px;
										color: #fed136;
										padding: 10px 20px 10px 20px;
										margin-bottom: 20px;
									}
									.print_title h3 {
										margin-top: auto;
										margin-bottom: auto;
										font-weight: 600;
									}
									.print_title button {
										border: none;
										background-color: #fed136;
										font-size: 20px;
										padding: 5px 15px 5px 15px;
										border-radius: 20px;
										font-weight: 600;
									}
								</style>
								<div  class="print_title">
									<h3>
										<a href="?page=service&l_id=<?php echo $_GET['l_id'] ?>&srvc_id=<?php echo $_GET['srvc_id'] ?>&ym=<?php echo $_GET['ym'] ?>"style="float: left; color:#fed136"><i class="fa fa-arrow-left"></i>&nbsp;&nbsp;&nbsp;</a>
										<?php echo 'Service name: ' . ucwords($s_row['service_name']) ?>
										
									</h3>
									<button onclick="var p = window.open('../Print/invoice.php?avail_id=<?php echo $_GET['avail_id'] ?>&l_id=<?php echo $_GET['l_id'] ?>&srvc_id=<?php echo $_GET['srvc_id'] ?>');">Print</button>
								</div>
					<?php
							endwhile;
							include "../Print/print.php";
			//End of showing specific avail receipt
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

								#createRvwBtn {
									margin: auto;
									float: right;
									font-size: 35px;
									border: none;
									background-color: #fed136;
									color: #114481;
									padding: 10px 20px 10px 20px;
									font-weight: bold;
									border-radius: 15px;
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
							<h2 style="width:58%;">Rate Lensman</h2>
							</div>
					<?php
							$lensman = $conn->query("SELECT `user_profile_image`, `user_first_name`, `user_last_name`, `user_type` FROM tbl_user_account WHERE `user_id` = {$_GET['fdbk_id']} AND user_archive_status = '1'");
							while($l_row = $lensman->fetch_assoc()):
					?>
								<div class="user">
									<img src="../../images/profile-images/<?php echo $l_row['user_profile_image'] ?>" alt="" style="width: 120px; height: 120px; background:center; background-size: cover; object-fit: cover; object-position: 0 -0%; border-radius: 50%;">
									<p class="lensman_name"><?php echo $l_row['user_first_name'].' '.$l_row['user_last_name'] ?></p>
					<?php
							endwhile;
							$reviews_num = $conn->query("SELECT * FROM tbl_feedback WHERE  `lensman_id` = {$_GET['fdbk_id']} AND feedback_archive_status = '1'")->num_rows;
							$reviews = $conn->query("SELECT AVG(feedback_rate) as average, SUM(if(feedback_rate = 5,1,0)) as r5, SUM(if(feedback_rate = 4,1,0)) as r4,
							SUM(if(feedback_rate = 3,1,0)) as r3, SUM(if(feedback_rate = 2,1,0)) as r2, SUM(if(feedback_rate = 1,1,0)) as r1 FROM tbl_feedback WHERE feedback_archive_status = '1' AND `lensman_id` = {$_GET['fdbk_id']}");
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
								<button id="createRvwBtn" onclick="createReview()">Review</button>
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
							$fdbk_sort_num = $conn->query("SELECT * FROM tbl_feedback WHERE `feedback_archive_status` = '1' AND `lensman_id` = {$_GET['fdbk_id']} AND `feedback_rate` = {$_GET['sort']}")->num_rows;	
							if($reviews_num != 0 && $fdbk_sort_num != 0):
				//Start of if theres feedbacks taken from the db according to their stars
							$reviews = $conn->query("SELECT * FROM tbl_feedback WHERE `feedback_archive_status` = '1' AND `lensman_id` = {$_GET['fdbk_id']} AND `feedback_rate` = {$_GET['sort']} ORDER BY `feedback_date` DESC");
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
							$reviews = $conn->query("SELECT * FROM tbl_feedback WHERE `feedback_archive_status` = '1' AND `lensman_id` = {$_GET['fdbk_id']} ORDER BY `feedback_date` DESC");
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
					?>
							<script>
								function createReview()
								{
									uni_modal("<center><b>Review Lensman</b></center></center>",'create_review.php?fdbk_id='+<?php echo $_GET['fdbk_id'] ?>+'')
								}
							</script>
					<?php 	
	//End of showing specific lensman feedback
							endif;
					?>
			</div>
		</div>
	</div>
	
		<?php
				if((isset($_GET['l_id']) && isset($_GET['srvc_id']) || isset($_GET['avail_id'])) && !isset($_GET['feedback']) && !isset($_GET['action'])):
	//Start of Avail Form
		?>
		<div class="right-panel py-2 px-2" >
			<div class="container-fluid" >
				<style>
					.avail_form * { border-radius: 5px 5px 5px 5px; border: none }
					.label { text-align: left; padding: 10px; margin-bottom: 0px; }
					.avail_form { background-color: #114481; text-align: center; color: #fed136; }
					.dt_lcl { width: 95%; margin: 0px 5px 5px 5px; padding: 5px }
					textarea { width: 95%; height: 200px; margin: 5px; padding: 5px; resize: none; }
					input[type=button] { font-weight: bold; color: #114481; background: #fed136; border: none; border-radius: 5px 5px 5px 5px; padding: 5px 10px 5px 10px; margin: 10px 0px 20px 0px !important; font-size: 20px;}
					#edit_cancel {background: crimson !important; color: white !important; }
					.swal2-popup { width: 400px; }
					.swal2-checkbox { margin-top: 20px; }
					.swal2-actions { margin-top: 0px; }
					.swal2-confirm { background-color: #114481 !important; color: #fed136 !important; font-weight: bolder; }
					.swal2-cancel { background-color: crimson !important; font-weight: bolder; }
					.swal2-confirm:focus { box-shadow: none !important; }
				</style>
				<div class="col-md-12">
						<?php
								
								if(isset($_GET['avail_id'])){
									$qry = $conn->query("SELECT *, avail_id AS avail_id_edit FROM tbl_service_avail where `avail_id` = {$_GET['avail_id']}")->fetch_array();
									foreach($qry as $k => $v){
										$$k= $v;
									}
								}
						?>
								<div id="formCont" style="display: flex">
								
								<div class="avail_form"  style="width: 100%; margin-top: auto; margin-bottom: auto; border-radius: 5px 5px 5px 5px; box-shadow: 0 4px 8px 0 rgb(0 0 0 / 50%), 0 6px 20px 0 rgb(0 0 0 / 19%)">
									
									<h3 class="label"><b>Avail Service Form</b></h3>
									<form action="" id="manage_avail">
						<?php
								$current_day = date("Y-m-d\T00:00", strtotime('+3 days'));
						?>
										<input type="hidden" id="avail_id" name="avail_id" value="<?php echo isset($avail_id_edit) ? $avail_id_edit : '' ?>">
										<input type="hidden" id="user_id" name="user_id" value="<?php echo $_SESSION['login_user_id'] ?>">
										<input type="hidden" id="lensman_id" name="lensman_id" value="<?php echo $_GET['l_id'] ?>">
										<input type="hidden" id="srvc_id" name="srvc_id" value="<?php echo $_GET['srvc_id'] ?>">
										<p class="label">Start Date and Time</p>
										<input class="dt_lcl" type="datetime-local" id="srvc_start_date" name="srvc_start_date" min="<?php echo $current_day ?>" value="<?php echo isset($avail_starting_date_time) ? $avail_starting_date_time : '' ?>">
										<h5 class="label">Message (Note)</h5>
										<textarea  name="message" id="message"><?php echo isset($avail_note) ? $avail_note : '' ?></textarea>
						<?php
								$avl = $conn->query("SELECT `avail_status` FROM tbl_service_avail where `user_id` = {$_SESSION['login_user_id']} and `service_id`= {$_GET['srvc_id']} ORDER BY avail_id DESC LIMIT 1 OFFSET 1")->fetch_array();
								$avl_latest = $conn->query("SELECT `avail_status` FROM tbl_service_avail where `user_id` = {$_SESSION['login_user_id']} and `service_id`= {$_GET['srvc_id']} ORDER BY avail_id DESC LIMIT 1")->fetch_array();
								$avl_num = $conn->query("SELECT `avail_status` FROM tbl_service_avail where `user_id` = {$_SESSION['login_user_id']} and `service_id`= {$_GET['srvc_id']}")->num_rows;
								#Check if theres no records in DB
								($avl_num == 0) ? $no_data = true : $no_data = false;

								#Check if theres only one data in DB and check its Avail Status; make sure its not Pending (0) or Downpayment(1) or Confirmed (2) or Rescheduling (5) and check if its either Completed (3) or Cancelled (4)
								($avl_num == 1) ? $avail1 = ((($avl_latest['avail_status'] != 0 && $avl_latest['avail_status'] != 1 && $avl_latest['avail_status'] != 2 && $avl_latest['avail_status'] != 5 ) && ($avl_latest['avail_status'] == 3 || $avl_latest['avail_status'] == 4) ? true : false) ) : $avail1 = false ;
								
								#Check if theres many records in DB and see if the second latest is either Completed (3) or Cancelled (4) and same on latest;
								($avl_num > 1) ? $avail2 = ((($avl['avail_status'] == 3 || $avl['avail_status'] == 4) && ($avl_latest['avail_status'] == 3 || $avl_latest['avail_status'] == 4)) ? true : false) : $avail2 = false ;
								
								if(isset($_GET['avail_id']))
								{
									if($avl_latest['avail_status']=='0')
									{
						?>
											<input type="button" id="avail_submit" value="Edit" style="margin-bottom: 5px" form="manage_avail">
											<input type="button" id="edit_cancel" value="Cancel Edit" style="margin-bottom: 5px" onclick="window.location.href='?page=service&l_id=<?php echo $_GET['l_id'] ?>&srvc_id=<?php echo $_GET['srvc_id'] ?>&ym=<?php echo strval($_GET['ym']) ?>';" >
						<?php
									}
									if($avl_latest['avail_status']=='1' || $avl_latest['avail_status']=='2' || $avl_latest['avail_status']=='5')
									{
						?>
											<input type="button" id="resched_submit" value="Resched" style="margin-bottom: 5px" form="manage_avail">
											<input type="button" id="resched_cancel" value="Cancel Resched" style="margin-bottom: 5px" onclick="window.location.href='?page=service&l_id=<?php echo $_GET['l_id'] ?>&srvc_id=<?php echo $_GET['srvc_id'] ?>&ym=<?php echo strval($_GET['ym']) ?>';" >
						<?php
									}
								}
								if(!isset($_GET['avail_id']) && ($no_data || $avail1 || $avail2)) /*(($avl_latest['avail_status'] != 0 && $avl_latest['avail_status'] != 1) && ($avl['avail_status'] == 2 || $avl['avail_status'] == 3))*/
								{
						?>
											<input type="button" id="avail_submit" value="Submit" style="margin-bottom: 5px" form="manage_avail">
						<?php
								}
						?>
									</form>
								</div>
								</div>
								<script>
									$( document ).ready(function() {
										let h = window.innerHeight;
										document.getElementById("formCont").style.height = "calc("+h+"px - 8rem)";
									});

									$('#avail_submit').click(function(){
										//value start
										var start = Date.parse($("input#srvc_start_date").val()); //get timestamp
										console.log("avail");
										if(start)
										{
											if(checkStarting(start))
											{
												if(isSameDay(start))
												{
													var srvc_hrs = <?php echo $service_hrs ?>;

													var startDate = new Date(start);
													startDate.setMinutes(startDate.getMinutes() - startDate.getTimezoneOffset());
													//add the service hours to startDate to have the endDate
													var endDate = new Date(start);
													endDate.setHours(endDate.getHours() + srvc_hrs)
													endDate.setMinutes(endDate.getMinutes() - endDate.getTimezoneOffset());

													Swal.fire
													({
														html: 
															`
																<div>
																	<h3 style="margin-bottom: 10px !important;">Terms and Agreement</h3>
																	<p style="font-size: 20px; font-weight: Normal; text-align: justify; text-indent: 50px; ">The terms of the Transaction Agreement shall not have been amended or waived in a manner that materially and adversely affect both user in terms of harming, scamming and threats. Editing or Cancelling the schedule while pending is allowed, but Cancelling the Schedule when already Confirmed by the Lensman shall be paid 25% of the total amount of the chosen package. Present the receipt during the day of the transaction.</p>
																</div>
															`,
														confirmButtonText: 'Confirm',
														showCancelButton: true,
														input: 'checkbox',
														inputPlaceholder: 'I Accept the Terms and Conditions',
													
														// validator is optional
														inputValidator: function(result) {
															if (!result) {
																return 'Please tick the accept';
															}
														}
													}).then(function(result) {
															if(result.isConfirmed)
															{
																var formData = {
																	avail_id: $("#avail_id").val(),
																	user_id: $("#user_id").val(),
																	service_id: $("#srvc_id").val(),
																	avail_starting_date_time: startDate.toISOString("en-US", {timeZone: "Asia/Manila"}).slice(0,16),
																	avail_ending_date_time: endDate.toISOString("en-US", {timeZone: "Asia/Manila"}).slice(0,16),
																	avail_note: $("#message").val(),
																	//receiver is the one who gonna receive the notification, 
																	//in this case it will be the lensman who will receive the notification
																	notification_receiver: '<?php echo $_GET['l_id'] ?>',
																};
																start_load()
																$.ajax({
																	url:"ajax.php?action=save_avail",
																	method: 'POST',
																	data: formData,
																	success:function(resp){
																		console.log(resp)
																		end_load()
																		if(resp == 1){
																			location.reload()
																		}
																		if(resp == 2){
																			const l_id =  new URLSearchParams(window.location.search).get('l_id');
																			const srvc_id =  new URLSearchParams(window.location.search).get('srvc_id');
																			const d_id2 = String(startDate.toISOString("en-US", {timeZone: "Asia/Manila"}).slice(0,7));
																			window.location.href='?page=service&l_id='+l_id+'&srvc_id='+srvc_id+'&ym='+d_id2+'';
																		}
																		if(resp == 3){
																			alert_toast(`This day is already availed`, 'warning', 'top')
																		}
																		if(resp == 4){
																			alert_toast(`You can't avail the day again you cancelled beforehand`, 'warning', 'top')
																		}
																		if(resp == 5){
																			alert_toast(`Something went wrong...`, 'warning', 'top')
																		}
																	}
																})
															}
															else
															{
																Swal.close;
															}
													})
												}
												else
												{
													alert_toast(`Schedule shouldn't be between two different days`, 'warning', 'top')
													/*const Toast = Swal.mixin({
														toast: true,
														position: 'top-end',
														showConfirmButton: false,
														timer: 3000,
														timerProgressBar: true,
														didOpen: (toast) => {
															toast.addEventListener('mouseenter', Swal.stopTimer)
															toast.addEventListener('mouseleave', Swal.resumeTimer)
														}
													})

													Toast.fire({
														icon: 'warning',
														title: 'Signed in successfully'
													})*/
												}
											}
											else
											{
												alert_toast('Starting Schedule should be more than 3 days from now', 'warning', 'top')
											}
										}
										else
										{
											alert_toast("Starting DateTime input is empty", 'warning', 'top')
										}
									})
									
									$('#resched_submit').click(function(){
										//value start
										var start = Date.parse($("input#srvc_start_date").val()); //get timestamp

										if(start)
										{
											if(checkStarting(start))
											{
												if(isSameDay(start))
												{
													var srvc_hrs = <?php echo $service_hrs ?>;

													var startDate = new Date(start);
													startDate.setMinutes(startDate.getMinutes() - startDate.getTimezoneOffset());
													//add the service hours to startDate to have the endDate
													var endDate = new Date(start);
													endDate.setHours(endDate.getHours() + srvc_hrs)
													endDate.setMinutes(endDate.getMinutes() - endDate.getTimezoneOffset());

													Swal.fire({
														html: `
															<h3 style="margin-bottom: 10px; font-weight: 600;">Rescheduling Avail</h3>\
															<h5 style="margin-bottom: 20px;">Select a valid reason why you want to resched this avail:</h5>
															<div style="width: fit-content; margin: auto">
															<label class="container_report">Health Problem
																<input type="radio" name="reportReason" checked value="Health Problem">
																<span class="checkmark"></span>
															</label>
															<label class="container_report">Natural Phenomena (Storm, Floods, Landslide)
																<input type="radio" name="reportReason" value="Natural Phenomena (Storm, Floods, Landslide)">
																<span class="checkmark"></span>
															</label>
															<label class="container_report">Family Emergency
																<input type="radio" name="reportReason" value="Family Emergency">
																<span class="checkmark"></span>
															</label>
															<label class="container_report">Conflict of Personal Schedule
																<input type="radio" name="reportReason" value="Conflict of Personal Schedule">
																<span class="checkmark"></span>
															</label>
															</div>
															<style>
																/* The container */
																.container_report {
																	display: block;
																	position: relative;
																	padding-left: 35px;
																	margin-bottom: 12px;
																	cursor: pointer;
																	font-size: 19px;
																	font-weight: normal !important;
																	text-align: left;
																	-webkit-user-select: none;
																	-moz-user-select: none;
																	-ms-user-select: none;
																	user-select: none;
																}

																/* Hide the browser's default radio button */
																.container_report input {
																	position: absolute;
																	opacity: 0;
																	cursor: pointer;
																}

																/* Create a custom radio button */
																.checkmark {
																	position: absolute;
																	top: 0;
																	left: 0;
																	height: 25px;
																	width: 25px;
																	background-color: #eee;
																	border-radius: 50%;
																}

																/* On mouse-over, add a grey background color */
																.container_report:hover input ~ .checkmark {
																	background-color: #ccc;
																}

																/* When the radio button is checked, add a blue background */
																.container_report input:checked ~ .checkmark {
																	background-color: #2196F3;
																}

																/* Create the indicator (the dot/circle - hidden when not checked) */
																.checkmark:after {
																	content: "";
																	position: absolute;
																	display: none;
																}

																/* Show the indicator (dot/circle) when checked */
																.container_report input:checked ~ .checkmark:after {
																	display: block;
																}

																/* Style the indicator (dot/circle) */
																.container_report .checkmark:after {
																	top: 9px;
																	left: 9px;
																	width: 8px;
																	height: 8px;
																	border-radius: 50%;
																	background: white;
																}
															</style>
														`,
														showCloseButton: true,
														width: 600,
													}).then((result) => {
														if (result.isConfirmed) {
															var rd = $('input[name="reportReason"]:checked').val();
															Swal.fire
															({
																title: `Proceed to resched this avail?`,
																confirmButtonText: 'Confirm',
																showCloseButton: true,
															}).then(function(result) {
																	if(result.isConfirmed)
																	{
																		var formData = {
																			avail_id: $("#avail_id").val(),
																			user_id: $("#user_id").val(),
																			service_id: $("#srvc_id").val(),
																			avail_starting_date_time: startDate.toISOString("en-US", {timeZone: "Asia/Manila"}).slice(0,16),
																			avail_ending_date_time: endDate.toISOString("en-US", {timeZone: "Asia/Manila"}).slice(0,16),
																			avail_note: $("#message").val(),
																			avail_resched_reason: rd,
																			//receiver is the one who gonna receive the notification, 
																			//in this case it will be the lensman who will receive the notification
																			notification_receiver: '<?php echo $_GET['l_id'] ?>',
																		};
																		start_load()
																		$.ajax({
																			url:"ajax.php?action=resched_avail",
																			method: 'POST',
																			data: formData,
																			success:function(resp){
																				console.log(resp)
																				end_load()
																				if(resp == 1){
																					const l_id =  new URLSearchParams(window.location.search).get('l_id');
																					const srvc_id =  new URLSearchParams(window.location.search).get('srvc_id');
																					const d_id2 = String(startDate.toISOString("en-US", {timeZone: "Asia/Manila"}).slice(0,7));
																					alert_toast(`Reschedule Request Submitted`, 'success', 'top')
																					setInterval(function () {
																						window.location.href='?page=service&l_id='+l_id+'&srvc_id='+srvc_id+'&ym='+d_id2+'';
																					}, 1500);
																				}
																				if(resp == 2){
																					alert_toast(`This day is already availed`, 'warning', 'top')
																				}
																				if(resp == 3){
																					alert_toast(`You can't avail the day again you cancelled beforehand`, 'warning', 'top')
																				}
																				if(resp == 4){
																					alert_toast(`Something went wrong...`, 'warning', 'top')
																				}
																			}
																		})
																	}
																	else
																	{
																		Swal.close;
																	}
															})
														} 
													})
												}
												else
												{
													alert_toast(`Schedule shouldn't be between two different days`, 'warning', 'top')
													/*const Toast = Swal.mixin({
														toast: true,
														position: 'top-end',
														showConfirmButton: false,
														timer: 3000,
														timerProgressBar: true,
														didOpen: (toast) => {
															toast.addEventListener('mouseenter', Swal.stopTimer)
															toast.addEventListener('mouseleave', Swal.resumeTimer)
														}
													})

													Toast.fire({
														icon: 'warning',
														title: 'Signed in successfully'
													})*/
												}
											}
											else
											{
												alert_toast('Starting Schedule should be more than 3 days from now', 'warning', 'top')
											}
										}
										else
										{
											alert_toast("Starting DateTime input is empty", 'warning', 'top')
										}
									})

									function checkStarting(start)
									{
										var today = new Date();
										today.setDate(today.getDate() + 2);

										var start = new Date(start);

										//given starting sched from input should be 3 days from now
										//for example its Jan 8 today and we can only pick Jan 11 onwards
										if((start-today) >= (1000 * 3600 * 24))
										{
											return true;
										}
										else
										{
											return false;
										}
									}

									/*function daysDifference(d0, d1) {
										var diff = new Date(+d1).setHours(12) - new Date(+d0).setHours(12);
										return Math.round(diff/8.64e7);
									}*/

									function isSameDay(start)
									{
										var srvc_hrs = <?php echo $service_hrs ?>;

										var startDate = new Date(start);
										//add the service hours to startDate to have the endDate
										var startDate2 = new Date(start);
										startDate2.setHours(startDate2.getHours() + srvc_hrs)
										var endDate = new Date(startDate2);

										var diff = new Date(+endDate).setHours(12) - new Date(+startDate).setHours(12);
										return Math.round(diff/8.64e7) === 0;
									}
									
								//
									/*
									function checkHours(start, end)
									{
									var srvc_hrs = '<?php echo $service_hrs ?>';

									totalHours = NaN;

										totalHours = Math.floor((end - start) / 1000 / 60); //milliseconds: /1000 / 60 / 60
										
										var check_sched_interval = Boolean((srvc_hrs * 60 ) === totalHours)
										
										if(check_sched_interval)
										{
											return true;
										}
										else
										{
											return false;
										}
									
									}
								
								
									function isSameDate(a, b) {
										return Math.abs(a - b) < (1000 * 3600 * 24) && a.getDay() === b.getDay();
									}
									function timePassedFrom7(dateD, need)
									{
									var date1 = new Date(dateD.toDateString()+" 7:00:00");
									var date2 = new Date(dateD);
								
									var diff = date2.getTime() - date1.getTime();
								
									var msec = diff;
									if(need == "hours")
									{
										var data = Math.floor(msec / 1000 / 60 / 60);
										msec -= data * 1000 * 60 * 60;
									}
									if(need == "minutes")
									{
										var mmdata = Math.floor(msec / 1000 / 60);
										msec -= data * 1000 * 60;
									}
									if(need == "seconds")
									{
										var data = Math.floor(msec / 1000);
										msec -= data * 1000;
									}
								
									return data;
									}
									*/
								//
								</script>
				</div>
			</div>
		</div>
		<?php 
	//End of Avail Form
				endif;
		?>
		