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
						<div class="card card-widget">
							<div class="card-body">
								<div class="container-fluid">
									<div class="d-flex w-100">
										<div class="rounded-circle mr-1" style="width: 30px;height: 30px;top:-5px;left: -40px">
											<img src="../../images/profile-images/<?php echo $prof_img['user_profile_image'] ?>" class="image-fluid image-thumbnail rounded-circle" alt="" style="width: calc(100%);height: calc(100%); background:center; background-size: cover; object-fit: cover;">
										</div>
										<button class="btn btn-default ml-4 text-left" id="write_post" type="button" style="width:calc(100%);border-radius: 50px !important;"><span>What's on your mind, <?php echo ucwords($_SESSION['login_user_first_name'] . ' ' . $_SESSION['login_user_last_name']) ?>?</span></button>
									</div>
									<hr>
									<div class="d-flex w-100 justify-content-center">
										<a href="javascript:void(0)" id="upload_post" class="text-dark post-link px-3 py-1" style="border-radius: 50px !important;"><span class="fa fa-photo-video text-success"></span> Photo/Video</a>
									</div>
								</div>
							</div>
						</div>
					</div>
					<?php 

						//$posts = $conn->query("SELECT p.*,concat(u.firstname,' ',u.lastname) as name,u.profile_pic from posts p inner join users u on u.id = p.user_id  where p.type = 0 order by unix_timestamp(p.date_created) desc");
						$posts = $conn->query("SELECT p.* , u.user_profile_image, u.user_first_name, u.user_last_name, u.user_nickname from tbl_post p inner join tbl_user_account u on u.user_id = p.user_id where p.post_type = 0 order by unix_timestamp(p.post_date) desc");
						while($row=$posts->fetch_assoc()):
						$row['post_content'] = str_replace("\n","<br/>",$row['post_content']); 
						$is_liked =  $conn->query("SELECT * FROM tbl_post_likes where user_id = {$_SESSION['login_user_id']} and post_id = {$row['post_id']} ")->num_rows ? "text-danger" : "";
						$liked =  $conn->query("SELECT * FROM tbl_post_likes where post_id = {$row['post_id']} ")->num_rows;
						$commented =  $conn->query("SELECT * FROM tbl_post_comments where post_id = {$row['post_id']} ")->num_rows;
						($_SESSION['login_user_id'] === $row['user_id']) ? $id_msg = $in_sess_link."_dashboard.php?page=profile" : $id_msg = $in_sess_link."_dashboard.php?page=messages&id=".$row['user_id'];
					?>
					<div class="col-md-12">
						
						<div class="card card-widget post-card" data-id="<?php echo $row['post_id'] ?>">
						<div class="card-header">
							<div class="user-block">
							<img class="img-circle" src="../../images/profile-images/<?php echo $row['user_profile_image'] ?>" alt="User Image" style="object-fit: cover;">
							<span class="username"><a href="<?php echo $id_msg ?>"><?php echo ucwords($row['user_first_name'] . ' ' . $row['user_last_name']); echo "  (".$row['user_nickname'].")" ?></a></span>
							<span class="description">Posted - 
							<?php 
								//echo date("M d,Y h:i a",strtotime($row['post_date'])) 
								

							echo time_elapsed_string($row['post_date']);
							
							?></span>
							</div>
							<!-- /.user-block -->
							<div class="card-tools">
							<?php if($_SESSION['login_user_id'] == $row['user_id']): ?>
								<div class="dropdown">
								<button type="button" class="btn btn-tool" data-toggle="dropdown" title="Manage">
									<i class="fa fa-ellipsis-v"></i>
								</button>
								<div class="dropdown-menu">
									<a class="dropdown-item edit_post" data-id="<?php echo $row['post_id'] ?>" href="javascript:void(0)">Edit</a>
									<a class="dropdown-item delete_post" data-id="<?php echo $row['post_id'] ?>" href="javascript:void(0)">Delete</a>
								</div>
								</div>
							<?php else: ?>
								<div class="dropdown">
								<button type="button" class="btn btn-tool" data-toggle="dropdown" title="Manage">
									<i class="fa fa-ellipsis-v"></i>
								</button>
								<div class="dropdown-menu">
									<a class="dropdown-item report_post" data-id="<?php echo $row['post_id'] ?>" href="javascript:void(0)">Report</a>
								</div>
								</div>
							<?php endif; ?>
							</div>
							<!-- /.card-tools -->
						</div>
					<!-- /.card-header -->
						<div class="card-body">
							<!-- post text -->
							<p class="content-field"><?php echo $row['post_content'] ?></p>

							<a href="javascript:void(0)" class="d-none show-content" >Show More</a>
							<?php if(is_dir('../assets/uploads/'.$row['post_id'])): ?>
							<div class="gallery mb-2">
								<?php
									$gal = scandir('../assets/uploads/'.$row['post_id']);
									unset($gal[0]);
									unset($gal[1]);
									$count =count($gal);
									$i = 0;
									foreach($gal as $k => $v):
										$mime = mime_content_type('../assets/uploads/'.$row['post_id'].'/'.$v);
										$i++;
										if($i > 4)
										break;
										$style = '';
										if($count == 1){
											$style = "grid-column-start: 1;grid-column-end: 3;grid-row-start: 1;grid-row-end: 3;";
										}elseif($count == 2){
											// if($i==1)
											$style = "grid-column-start: {$i};grid-column-end: ".($i + 1).";grid-row-start: 1;grid-row-end: 3;";
										}elseif ($count == 3) {
											if($i == 1)
											$style = "grid-column-start: {$i};grid-column-end: ".($i + 1).";grid-row-start: 1;grid-row-end: 3;";
										}
								?>
									<figure class="gallery__item position-relative" style="<?php echo $style ?>">
								<?php if($i == 4 && $count > 4): ?>
									<div class="position-absolute d-flex justify-content-center align-items-center h-100 w-100" style="top:0;left:0;z-index:1" >
										<a href="javascript:void(0)" class="text-white view_more" data-id="<?php echo $row['post_id'] ?>"><h4 class="text-white text-center"><?php echo '+ '.($count-4) ?> More</h4></a>
									</div>
								<?php endif; ?>

								<?php if(strstr($mime,'image')): ?>
									<a href="../assets/uploads/<?php echo $row['post_id'].'/'.$v ?>" class="lightbox-items" data-toggle="lightbox<?php echo $row['post_id'] ?>" data-slide="<?php echo $k ?>" data-title="" data-gallery="gallery"  data-id="<?php echo $row['post_id'] ?>">
									<img src="../assets/uploads/<?php echo $row['post_id'].'/'.$v ?>" class="gallery__img" alt="Image 1">
									</a>
								<?php else: ?>

									<?php //if($count > 1): ?>
										<a href="../assets/uploads/<?php echo $row['post_id'].'/'.$v ?>" class="lightbox-items" data-toggle="lightbox<?php echo $row['post_id'] ?>" data-slide="<?php echo $k ?>" data-title="" data-gallery="gallery" data-id="<?php echo $row['post_id'] ?>">
									<?php //endif; ?>
										<video <?php echo $count == 1 ? " controls " : ' ' ?> id="nf_vid" class="gallery__img">
											<source src="../assets/uploads/<?php echo $row['post_id'].'/'.$v ?>" type="<?php echo $mime ?>">
										</video>
										</a>
									<?php if($count > 1): ?>
										
										<a href="javascript:void(0)" class="text-white view_more" data-id="<?php echo $row['post_id'] ?>" >
										<div class="position-absolute d-flex justify-content-center align-items-center h-100 w-100" style="top:0;left:0;z-index:1" >
										<h3 class="text-white text-center rounded-circle "><i class="fa fa-play-circle "></i></h3>
										</div>
										</a>
									<?php endif; ?>
									
								<?php endif; ?>
									<script>
										var nfvid = document.querySelectorAll('#nf_vid');
										nfvid.forEach(nfvid => nfvid.addEventListener('mousewheel', () => {
											nfvid.pause();
										}));
									</script>
								</figure>
								<?php endforeach; ?>
							</div>
					<?php endif; ?>

						<!-- Social sharing buttons -->
						<button type="button" class="btn btn-default btn-sm like <?php echo $is_liked ?>" data-id="<?php echo $row['post_id'] ?>"><i class="fa fa-heart"></i> Like</button>
						<span class="float-right text-muted counts"><span class="like-count"><?php echo number_format($liked) ?></span> <?php echo $liked > 1 ? "likes" : "like" ?> - <span class="comment-count"><?php echo number_format($commented) ?></span> comments</span>
					</div>
					<!-- /.card-body -->
					<div class="card-footer card-comments">
						<?php 
							$comment_num = $conn->query("SELECT COUNT(*) as total FROM tbl_post_comments WHERE post_id = {$row['post_id']}")->fetch_assoc();
							$comment_num_total = $comment_num['total'] - 3;
							($comment_num['total'] <= 3) ? $offset = '' : $offset = 'OFFSET ' . $comment_num_total;
							$comments = $conn->query("SELECT c.*, u.user_first_name, u.user_last_name, u.user_profile_image, u.user_nickname FROM tbl_post_comments c inner join tbl_user_account u on u.user_id = c.user_id where c.post_id = {$row['post_id']} order by c.comment_id ASC LIMIT 3 $offset");
							while($crow = $comments->fetch_assoc()):
						?>
						<div class="card-comment">
							<!-- User image -->
							<img class="img-circle img-sm" src="../../images/profile-images/<?php echo $crow['user_profile_image'] ?>" alt="User Image" style="object-fit: cover;">

							<div class="comment-text">
							<span class="username">
								<span class="uname"><?php echo $crow['user_first_name'] .' '. $crow['user_last_name'] . ' ('.$crow['user_nickname'].')' ?></span>
								<span class="text-muted float-right timestamp"><?php echo time_elapsed_string($crow['comment_date']) ?></span>
							</span><!-- /.username -->
							<span class="comment">
							<?php echo str_replace("\n","<br/>",$crow['comment_content']) ?>
							</span>
							</div>
							<!-- /.comment-text -->
						</div>
						<?php endwhile; ?>
					</div>
					<!-- /.card-footer -->
					<div class="card-footer">
						<i class="img-fluid img-circle img-sm fa fa-comment"></i>
						<!-- .img-push is used to add margin to elements next to floating images -->
						<div class="img-push">
							<textarea cols="30" rows="1" class="form-control comment-textfield-home" style="resize:none" placeholder="Press enter to post comment" data-id="<?php echo $row['post_id'] ?>"></textarea>
						</div>
					</div>
					<!-- /.card-footer -->
					</div>
					</div>
				<?php endwhile; ?>
					
				</div>
			</div>
		</div>
		<style>
			.gallery__img {
				width: 100%;
				height: 100%;
				object-fit: cover;
			}
			.gallery {
				display: grid;
				grid-template-columns: repeat(2, 50%);
				grid-template-rows: repeat(2, 30vh);
				grid-gap: 3px;
				grid-row-gap: 3px;
			}
			.gallery__item{
				margin: 0
			}
		</style>
		<div class="d-none " id="comment-clone">
		<div class="card-comment">
			<!-- User image -->
			<img class="img-circle img-sm" src="" alt="User Image">

			<div class="comment-text">
			<span class="username">
				<span class="uname">Maria Gonzales</span>
				<span class="text-muted float-right timestamp">8:03 PM Today</span>
			</span><!-- /.username -->
			<span class="comment">
			It is a long established fact that a reader will be distracted
			by the readable content of a page when looking at its layout.
			</span>
			</div>
			<!-- /.comment-text -->
		</div>
		</div>
		<script>
			
			$('.comment-textfield-home').on('keypress', function (e) {
				if(e.which == 13 && e.shiftKey == false){
					
					var post_id = $(this).attr('data-id')
					var comment_content = $(this).val()
					$(this).val('')
					if(comment_content.trim()==="" || comment_content==null )
					{
						alert_toast("Comment area shouldn\'t be empty","error");
					}
					else
					{
						start_load()
						$.ajax({
							url:'ajax.php?action=save_comment',
							method:'POST',
							data:{post_id:post_id,comment_content:comment_content},
							success:function(resp){
								console.log(resp)
								if(resp){
									resp = JSON.parse(resp)
									if(resp.status == 1){
										var cfield = $('#comment-clone .card-comment').clone()
										cfield.find('.img-circle').attr('src','../../images/profile-images/'+resp.data.user_profile_image)
										cfield.find('.uname').text(resp.data.name_type)
										cfield.find('.comment').html(resp.data.comment_content)
										cfield.find('.timestamp').text(resp.data.timestamp)
										
										$('.post-card[data-id="'+post_id+'"]').find('.card-comments').append(cfield)
										var cc = $('.post-card[data-id="'+post_id+'"]').find('.comment-count').text();
											cc = cc.replace(/,/g,'');
											cc = parseInt(cc) + 1
										$('.post-card[data-id="'+post_id+'"]').find('.comment-count').text(cc)
										end_load()
									}
									else
									{
										alert_toast("An error occured","error")
										end_load()
									}
									end_load()
								}
							}
						})
					}
					return false;
					end_load()
				}
			})
			$('.comment-textfield-home').on('change keyup keydown paste cut', function (e) {
				if(this.scrollHeight <= 117)
				$(this).height(0).height(this.scrollHeight);
			})
			
			$('#write_post').click(function(){
				uni_modal("<center><b>Create Post</b></center></center>","create_post.php");
			})
			$('.edit_post').click(function(){
				uni_modal("<center><b>Edit Post</b></center></center>","create_post.php?id="+$(this).attr('data-id'))
			})
			$('.delete_post').click(function(){
				_conf("Are you sure to delete this post?","delete_post",[$(this).attr('data-id')])
			})
			$('.report_post').click(function(){
				Swal.fire({
					html: `
						<h3 style="margin-bottom: 10px; font-weight: 600;">Report this post</h3>\
						<h5 style="margin-bottom: 20px;">Select the reason why you want to report this post:</h5>
						<div style="width: fit-content; margin: auto">
						<label class="container_report">Age-Inappropirate Content (SPG, R-18)
							<input type="radio" name="reportReason" checked value="Age-Inappropirate Content (SPG, R-18)">
							<span class="checkmark"></span>
						</label>
						<label class="container_report">Copyright (Picture stolen from original source)
							<input type="radio" name="reportReason" value="Copyright (Picture stolen from original source)">
							<span class="checkmark"></span>
						</label>
						<label class="container_report">Public Shaming (Someone is being harassed)
							<input type="radio" name="reportReason" value="Public Shaming (Someone is being harassed)">
							<span class="checkmark"></span>
						</label>
						<label class="container_report">Discrimination (Hate Speech, Vigilantism and Racism)
							<input type="radio" name="reportReason" value="Discrimination (Hate Speech, Vigilantism and Racism)">
							<span class="checkmark"></span>
						</label>
						<label class="container_report">Illegal Works or Materials (Drugs, Cigarettes, Alcohols and etc.)
							<input type="radio" name="reportReason" value="Illegal Works or Materials (Drugs, Cigarettes, Alcohols and etc.)">
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
					/* Read more about isConfirmed, isDenied below */
					if (result.isConfirmed) {
						var user_id = '<?php echo $_SESSION['login_user_id'] ?>';
						var post_id = $(this).attr('data-id');
						var rd = $('input[name="reportReason"]:checked').val();

						Swal.fire({
							html: `
								<h2>Are you sure you want to report this post?</h2>
							`,
							showCloseButton: true,
						}).then((result) => {
							if(result.isConfirmed)
							{
								start_load()
								$.ajax({
									url:'ajax.php?action=report_post',
									method:'POST',
									data:{user_id: user_id, post_id: post_id, report_reason: rd},
									success:function(resp){
										console.log(resp)
										if(resp==1){
											alert_toast("Post successfully reported",'success')
											end_load()
										}
										else if(resp==2){
											alert_toast("You've already reported this post",'error')
											end_load()
										}
										else
										{
											alert_toast("Something went wrong",'error')
											end_load()
										}
									}
								})
							}
						})
					} 
				})
			})
			function delete_post($id){
					start_load()
					$.ajax({
						url:'ajax.php?action=delete_post',
						method:'POST',
						data:{id:$id},
						success:function(resp){
							if(resp==1){
								alert_toast("Data successfully deleted",'success')
								setTimeout(function(){
									location.reload()
								},1500)

							}
						}
					})
				}
			$('#upload_post').click(function(){
				uni_modal("<center><b>Create Post</b></center></center>","create_post.php?upload=1")
			})
			$('.content-field').each(function(){
				var dom = $(this)[0]
				var divHeight = dom.offsetHeight
				if(divHeight > 117){
					$(this).addClass('truncate-5')
					$(this).parent().children('.show-content').removeClass('d-none')
				}
			})
			$('.show-content').click(function(){
				var txt = $(this).text()
				if(txt == "Show More"){
					$(this).parent().children('.content-field').removeClass('truncate-5')
					$(this).text("Show Less")
				}else{
					$(this).parent().children('.content-field').addClass('truncate-5')
					$(this).text("Show More")
				}
			})
			$('.lightbox-items').click(function(e){
				e.preventDefault()
				uni_modal("","view_attach.php?id="+$(this).attr('data-id'),"large")
			})
			$('.view_more').click(function(e){
				e.preventDefault()
				uni_modal("","view_attach.php?id="+$(this).attr('data-id'),"large")
			})
			$('.like').click(function(){
				var _this = $(this)
				$.ajax({
					url:'ajax.php?action=like',
					method:'POST',
					data:{post_id:$(this).attr('data-id')},
					success:function(resp){
						if(resp == 1){
							_this.addClass('text-danger')
							var lc = _this.siblings('.counts').find('.like-count').text();
									lc = lc.replace(/,/g,'');
									lc = parseInt(lc) + 1
							_this.siblings('.counts').find('.like-count').text(lc)
						}else if(resp==0){
							_this.removeClass('text-danger')
							var lc = _this.siblings('.counts').find('.like-count').text();
									lc = lc.replace(/,/g,'');
									lc = parseInt(lc) - 1
							_this.siblings('.counts').find('.like-count').text(lc)
						}
					}
				})
			})
			
		</script>