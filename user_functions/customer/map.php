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
			<div class="center-panel py-2 px-2" style="padding: 0 10px 60px 25px !important;">
				<script>
					$(document).ready(function() {
						document.getElementById("near").onclick=getLocation;

						function getLocation() 
						{
							if(navigator.geolocation)
							{
								navigator.geolocation.getCurrentPosition(showPosition);
							}
						}

						function showPosition(position)
						{
							var lat = position.coords.latitude;
							var long = position.coords.longitude;
							location.href='?page=map&lat='+ lat +'&long='+ long +''
						}
					});
				</script>
			<?php 
					if(!isset($_GET['lat']) && !isset($_GET['long'])):
					
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
					</style>
					<div class="tab">
						<button class="tablinks active" onclick="location.href='?page=map';">Map</button>
						<button id="near" class="tablinks" >Nearest Studio</button>
					</div>
			<?php
					include 'gmaps/user-map.php'; 

					endif;
					if(isset($_GET['lat']) && isset($_GET['long'])):
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
					
						#mapNear {
							height: 90%;
						}
					</style>
					<div class="tab">
						<button class="tablinks" onclick="location.href='?page=map';">Map</button>
						<button id="near" class="tablinks active" >Nearest Studio</button>
					</div>
            <?php
                    //include 'gmaps/near_forms.php';
                    
            ?>
					<div id="mapNear"></div>
					<script>
                        

						function myNearMap()
						{
                            var marker;
                            var infowindow;
                            var red_icon =  "gmaps/confirmed.png" ;
                            var purple_icon =  'gmaps/pending.png' ;

							const defaultLatLng = { lat: <?php echo $_GET['lat'] ?>, lng: <?php echo $_GET['long'] ?> };
							const map = new google.maps.Map(document.getElementById("mapNear"), {
								zoom: 12,
								center: defaultLatLng,
							});

                            const currentLatLng = { lat: <?php echo $_GET['lat'] ?> , lng: <?php echo $_GET['long'] ?> };

                            var myMarker = new google.maps.Marker({
                                position: currentLatLng,
                                map,
                                html: 
									'<div class="stuff""><br>' +   
                                    '</div>' +
                                    '<div><h5 style="font-weight:bold;">My Current Location</h5></div>'
                                    
                            });
                            google.maps.event.addListener(myMarker, 'click', function() {
                                infowindow = new google.maps.InfoWindow();
                                infowindow.setContent(myMarker.html);
                                infowindow.open(map, myMarker);
                            });

            <?php
                    require "gmaps/db.php";

                    $rows = array();

                    $v1 = $_GET['lat'];
                    $v2 = $_GET['long'];
            
                    $near_loca = $connection->query("SELECT user_first_name, user_last_name, user_lat, user_lng, user_studio_name, ( 3959 * acos( cos( radians($v1) ) * cos( radians( `user_lat` ) ) * cos ( radians ( `user_lng` ) - radians($v2) ) + sin( radians($v1) ) * sin( radians( `user_lat` ) ) ) ) AS Distance FROM `tbl_user_account` HAVING Distance < 45 ORDER BY Distance LIMIT 0 , 20");
                    while($n_row=$near_loca->fetch_assoc())
                    {
                        //echo $n_row['user_first_name'] . ' ' .$n_row['Distance'] . '';
                        
                            $rows[] = $n_row;
                        
                    }
                    $indexed = array_map('array_values', $rows);
                    $arrr =  json_encode($indexed);
            ?>

                            var near_locations = <?php echo $arrr ?>;

                            var i ; 
                            for (i = 0; i < near_locations.length; i++) {
                                marker = new google.maps.Marker({
                                    position: new google.maps.LatLng(near_locations[i][2], near_locations[i][3]),
                                    map: map,
                                    icon :  red_icon,
                                    html: 
                                    '<div><h6>'+near_locations[i][4]+'</h6></div>' +
                                    '<div class="stuff">' +
                                        '<div style="font-size: 15px">' +
                                            near_locations[i][0] + ' ' + near_locations[i][1] + 
                                        '</div>' +
                                        '<div style="font-size: 15px; margin-top:10px;">' +
                                            'Distance: ' + Math.round(near_locations[i][5] * 100) / 100 + ' km' +
                                        '</div>' +
                                    '</div>'
                                });
                                google.maps.event.addListener(marker, 'click', (function(marker, i) {
                                    return function() {
                                        infowindow = new google.maps.InfoWindow();
                                        /*confirmed =  locations[i][4] === '1' ?  'checked'  :  0;
                                        $("#confirmed").prop(confirmed,locations[i][4]);
                                        $("#id").val(locations[i][0]);
                                        $("#description").val(locations[i][3]);
                                        $("#form").show();*/
                                        infowindow.setContent(marker.html);
                                        infowindow.open(map, marker);
                                    }
                                })(marker, i));
                            }
						}
					
					</script>
					<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDtXuNd8wbu-NaASSm5G16Rba7Xc-mvSFs&callback=myNearMap"></script>
			<?php
					endif;
			?>
            </div>
        </div>

		
		