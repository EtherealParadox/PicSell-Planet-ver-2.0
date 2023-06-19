	<?php 
		session_start();
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

		$posts = $conn->query("SELECT p.* , u.user_profile_image, u.user_first_name, u.user_last_name, u.user_nickname from tbl_post p inner join tbl_user_account u on u.user_id = p.user_id  where p.post_id = {$_GET['id']}");
		foreach($posts->fetch_array() as $k => $v){
			$$k = $v;
		}
		$gal = scandir('../assets/uploads/'.$_GET['id']);
		unset($gal[0]);
		unset($gal[1]);
		$count =count($gal);
		$i = 0;
		$post_content = str_replace("\n","<br/>",$post_content);
		$is_liked =  $conn->query("SELECT * FROM tbl_post_likes where user_id = {$_SESSION['login_user_id']} and post_id = {$_GET['id']} ")->num_rows ? "text-danger" : "";
		$liked =  $conn->query("SELECT * FROM tbl_post_likes where post_id = {$_GET['id']} ")->num_rows;
		$commented =  $conn->query("SELECT * FROM tbl_post_comments where post_id = {$_GET['id']} ")->num_rows;
		($_SESSION['login_user_id'] === $user_id) ? $id_msg = "lensman_dashboard.php?page=profile" : $id_msg = "lensman_dashboard.php?page=messages&id=".$user_id;
	?>
	<style>
	.slide img,.slide video{
		max-width:100%;
		max-height:100%;
	}
	#uni_modal .modal-footer{
		display:none
	}
	</style>
	<div class="container-fluid" style="height:75vh">
	<div class="row h-100">
		<div class="col-md-7 bg-dark h-100">
			<div class="d-flex h-100 w-100 position-relative justify-content-between align-items-center">
				<a href="javascript:void(0)" id="prev" class="position-absolute d-flex justify-content-center align-items-center" style="left:0;width:calc(15%);z-index:1"><h4><div class="fa fa-angle-left"></div></h4></a>
				<?php
					foreach($gal as $k => $v):
						$mime = mime_content_type('../assets/uploads/'.$_GET['id'].'/'.$v);
						$i++;
				?>
				<div class="slide w-100 h-100 <?php echo ($i == 1) ? "d-flex" : 'd-none' ?> align-items-center justify-content-center" data-slide="<?php echo $i ?>">
				<?php if(strstr($mime,'image')): ?>
					<img src="../assets/uploads/<?php echo $_GET['id'].'/'.$v ?>" class="" alt="Image 1">
				<?php else: ?>
					<video id="nf_vid2" controls class="">
						<source src="../assets/uploads/<?php echo $_GET['id'].'/'.$v ?>" type="<?php echo $mime ?>">
					</video>
				<?php endif; ?>
				</div>
				<?php endforeach; ?>
				<a href="javascript:void(0)" id="next" class="position-absolute d-flex justify-content-center align-items-center" style="right:0;width:calc(15%);z-index:1"><h4><div class="fa fa-angle-right"></div></h4></a>
			</div>
		</div>
		<div class="col-md-5 h-100" style="overflow:auto">
			<div class="card card-widget post-card" data-id="<?php echo $post_id ?>">
				<div class="card-header">
					<div class="user-block w-100">
						<img class="img-circle" src="../../images/profile-images/<?php echo $user_profile_image ?>" alt="User Image">
						<span class="username"><a href="<?php echo $id_msg ?>"><?php echo ucwords($user_first_name) . ' ' . ucwords($user_last_name) .' ( '.$user_nickname.' )' ?></a></span>
						<span class="description">Posted - <?php echo time_elapsed_string($post_date) ?></span>
					</div>
				</div>
				<div class="card-body">
					<p id="content-field"><?php echo $post_content ?></p>
					<br>
					<button type="button" class="btn btn-default btn-sm like <?php echo $is_liked ?>" data-id="<?php echo $_GET['id'] ?>"><i class="fa fa-heart"></i> Like</button>
					<span class="float-right text-muted counts"><span class="like-count"><?php echo number_format($liked) ?></span> <?php echo $liked > 1 ? "likes" : "like" ?> - <span class="comment-count"><?php echo number_format($commented) ?></span> comments</span>
				</div>
				<div class="card-footer card-comments">
					<?php 
						
						$comments = $conn->query("SELECT c.*, u.user_first_name, u.user_last_name, u.user_profile_image, u.user_nickname FROM tbl_post_comments c inner join tbl_user_account u on u.user_id = c.user_id where c.post_id = {$_GET['id']} order by unix_timestamp(c.comment_date) ASC");
						while($crow = $comments->fetch_assoc()):
					?>
					<div class="card-comment">
						<!-- User image -->
						<img class="img-circle img-sm" src="../../images/profile-images/<?php echo $crow['user_profile_image'] ?>" alt="User Image">

						<div class="comment-text">
						<span class="username">
							<span class="uname"><?php echo ucwords($crow['user_first_name'] . ' ' . $crow['user_last_name']) .' ('.$crow['user_nickname'].')' ?></span>
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
					<form action="#" method="post">
					<i class="img-fluid img-circle img-sm fa fa-comment"></i>
					<!-- .img-push is used to add margin to elements next to floating images -->
					<div class="img-push">
						<textarea cols="30" rows="1" class="form-control comment-textfield-view" style="resize:none" placeholder="Press enter to post comment" data-id="<?php echo $_GET['id'] ?>"></textarea>
					</div>
					</form>
				</div>
				<!-- /.card-footer -->
			</div>
		
		</div>
	</div>
	</div>
	<script>
		var vid = document.getElementById('nf_vid2');

		function closeFunc(){
			vid.pause();
		}

		$('#next').click(function(){
			vid.pause();
			var cslide = $('.slide:visible').attr('data-slide')
			if(cslide == '<?php echo $i ?>'){
				return false;
			}
			$('.slide:visible').removeClass('d-flex').addClass("d-none")
			$('.slide[data-slide="'+(parseInt(cslide) + 1)+'"]').removeClass('d-none').addClass('d-flex')
		})
		$('#prev').click(function(){
			var cslide = $('.slide:visible').attr('data-slide')
			if(cslide == 1){
				return false;
			}
			$('.slide:visible').removeClass('d-flex').addClass("d-none")
			$('.slide[data-slide="'+(parseInt(cslide) - 1)+'"]').removeClass('d-none').addClass('d-flex')
		})
	
		$('.comment-textfield-view').on('keypress', function (e) {
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
		$('.comment-textfield-view').on('change keyup keydown paste cut', function (e) {
			if(this.scrollHeight <= 117)
			$(this).height(0).height(this.scrollHeight);
		})
	$('.like').click(function(){
			var _this = $(this)
			$.ajax({
				url:'ajax.php?action=like',
				method:'POST',
				data:{post_id:$(this).attr('data-id')},
				success:function(resp){
					if(resp == 1){
						$('.post-card[data-id="'+_this.attr('data-id')+'"]').find('.like').addClass('text-danger')
						var lc = $('.post-card[data-id="'+_this.attr('data-id')+'"]').find('.like-count').first().text();
								lc = lc.replace(/,/g,'');
								lc = parseInt(lc) + 1
						$('.post-card[data-id="'+_this.attr('data-id')+'"]').find('.like-count').text(lc)
					}else if(resp==0){
						$('.post-card[data-id="'+_this.attr('data-id')+'"]').find('.like').removeClass('text-danger')
						var lc = $('.post-card[data-id="'+_this.attr('data-id')+'"]').find('.like-count').first().text();
								lc = lc.replace(/,/g,'');
								lc = parseInt(lc) - 1
						$('.post-card[data-id="'+_this.attr('data-id')+'"]').find('.like-count').text(lc)
					}
				}
			})
		})
	</script>