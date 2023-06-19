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

			.gm-style-iw button:focus {
				outline: none;
			}

			#googleMap {
				height: 100%;
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
							<?php //include 'gmaps/user-map.php'; ?>
				<div class="map" id="googleMap">

				</div>
            </div>
			<script>
				function myMap() {
					
					const myLatlng = { lat: 14.6499, lng: 120.4311 };
					const map = new google.maps.Map(document.getElementById("googleMap"), {
						zoom: 10,
						center: myLatlng,
					});
				
					var marker;
				
					google.maps.event.addListener(map, 'click', function(event) {
						placeMarker(event.latLng);
						var lat = event.latLng.lat(); // lat of clicked point
						var lng = event.latLng.lng(); // lng of clicked point
					});

					function placeMarker(location) {
						if ( marker ) {
							marker.setPosition(location);
						} else {
							const lat = location.lat();
							const lng = location.lng();
							marker = new google.maps.Marker({
								position: location,
								map: map,
								html: 
									'<style>' +
										'textarea {' +
											'padding: 3px;' +
											'font-size: 20px;' +
											'resize: none;' +
										'}' +
										'.markerBtn input{' +
											'font-size: 15px;' +
										'}' +
									'</style>' +
									'<div style="text-align:center">' +
										'<h5>Save this location?</h5>' +
										'<div class="markerBtn">' +
											'<input type="button" value="Save" onclick="updateLocation('+lat+','+lng+')"/>' +
										'</div>' +
									'</div>' 
							});
							bindMarkerinfo(marker);
						}
					}

					var bindMarkerinfo = function(marker) {
						google.maps.event.addListener(marker, "rightclick", function (point) {
							infowindow = new google.maps.InfoWindow();
							infowindow.setContent(marker.html);
							infowindow.open(map, marker);
						});
					};
				
			<?php
					$coords = $conn->query("SELECT user_lat, user_lng FROM tbl_user_account WHERE user_id = {$_SESSION['login_user_id']}");
					while($coo_row=$coords->fetch_assoc()):
			?>
					const currentUserLatLng = { lat: <?php echo $coo_row['user_lat'] ?>, lng: <?php echo $coo_row['user_lng'] ?> };
			<?php
					endwhile;
			?>
					var myMarker = new google.maps.Marker({
						position: currentUserLatLng,
						map,
						html: 
							'<div><h4 style="font-weight:bold;"><?php echo ucwords($_SESSION['login_user_first_name'] . ' ' . $_SESSION['login_user_last_name']) . ' location' ?></h4></div>'
							
					});
					google.maps.event.addListener(myMarker, 'click', function() {
						infowindow = new google.maps.InfoWindow();
						infowindow.setContent(myMarker.html);
						infowindow.open(map, myMarker);
					});
				}

				function updateLocation(lat, lng)
				{
					Swal.fire({
						confirmButtonText: "Proceed",
						showCancelButton: true,
						html:
							'<h4>Proceed adding this marker to the database?</h4>'
					}).then((result) => {
							if (result.isConfirmed) {
								start_load()
								$.ajax({
									url:"ajax.php?action=update_location_lm",
									data: {user_id: '<?php echo $_SESSION['login_user_id'] ?>' ,lat: lat, lng: lng},
									method: 'POST',
									type: 'POST',
									success:function(resp){
										console.log(resp)
										if(resp == 1){
											alert_toast("Successfully updated location", "success")
											setTimeout(function(){
												location.reload()
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
					})
				}
			</script>
			<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDtXuNd8wbu-NaASSm5G16Rba7Xc-mvSFs&callback=myMap"></script>
        </div>
