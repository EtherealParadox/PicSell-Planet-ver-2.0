<?php 
		session_start(); 
		//include 'db_connect.php';
		include '../db_connect.php';
	?>
	<style>
		.column {
		float: left;
		width: 100%;
		padding: 10px;
		}

		.column img,.column video {
		margin-top: 12px;
		max-width: 100%;
		max-height: 20vh;
		}
		.c-row {
		display: flex;
		flex-wrap: wrap;
		padding: 0 4px;
		}

		.modal-dialog {
			margin-top: 150px !important;
		}

        #create_review {
            text-align: center
        }

        #create_review textarea {
            width: 100%;
            margin-top: 20px;
            padding: 15px;
            resize: none;
            text-align: justify;
        }

        #create_review input[type=button] {
            background: #114481; 
            color: #fed136; 
            border: none; 
            border-radius: 5px 5px 5px 5px; 
            padding: 5px 10px 5px 10px; 
            font-size: 20px;
            text-align: center;
			font-weight: bolder;
        }
	</style>
    <div class="container-fluid">
        <?php
            $pr_id = $_GET['prod_id'];
            $prod_fdbk = $conn->query("SELECT feedback_message FROM tbl_feedback WHERE user_id = {$_SESSION['login_user_id']} AND product_id = '$pr_id' ")->fetch_assoc();
            (isset($prod_fdbk['feedback_message'])) ? $fdbk_msg = $prod_fdbk['feedback_message'] : $fdbk_msg = '';
        ?>
        <form action="" id="create_review">
            <input type="hidden" name="product_id" id="product_id" value="<?php echo $pr_id ?>">
            <div id="star_container">
				<span class="fa fa-star fa-2x submit_star" id="submit_star_1" data-index="1"></span>
				<span class="fa fa-star fa-2x submit_star" id="submit_star_2" data-index="2"></span>
				<span class="fa fa-star fa-2x submit_star" id="submit_star_3" data-index="3"></span>
				<span class="fa fa-star fa-2x submit_star" id="submit_star_4" data-index="4"></span>
				<span class="fa fa-star fa-2x submit_star" id="submit_star_5" data-index="5"></span>
			</div>
            <textarea name="feedback_message" id="feedback_message" cols="50" rows="10"><?php echo (isset($fdbk_msg)) ? $fdbk_msg : '' ?></textarea>
            <input type="button" id="review_submit" value="Submit" style="margin-bottom: 5px" form="create_review">
        </form>
    </div>
    <script>
    $(document).ready(function () {
        var rating_data = 0;

        $(document).on('click', '.submit_star', function(){
            rating_data = parseInt($(this).data('index'));
            var rating = $(this).data('index');

            reset_background();

            for(var count = 1; count <= rating; count++)
            {
            
                $('#submit_star_'+count).addClass('text-warning');
            
            }
        });

        function reset_background()
        {
            for(var count = 1; count <= 5; count++)
            {
            
                $('#submit_star_'+count).addClass('star-light');
            
                $('#submit_star_'+count).removeClass('text-warning');
            
            }
        }

        $('#review_submit').click(function(){

            var formData = {
				feedback_message: $("#feedback_message").val(),
				feedback_rate:rating_data,
                product_id: $("#product_id").val(),
				user_id: $("#user_id").val(),
			};
            start_load()
            if(rating_data>0)
            {
                $.ajax({
                    url:"ajax.php?action=save_review_product",
                    method:"POST",
                    data: formData,
                    success:function(resp){
                        console.log(resp)
                        end_load()
                        if(resp == 1){
                            alert_toast("Review Successfully Updated", "success")
                            setTimeout(function(){
                                location.reload()
                            },1000)
                        }
                        if(resp == 2){
                            alert_toast("Review Successfully Inserted", "success")
                            setTimeout(function(){
                                location.reload()
                            },1000)
                        }
                        if(resp == 3){
                            alert_toast("Something went wrong", "error")
                            setTimeout(function(){
                                location.reload()
                            },1000)
                        }
                    }
                })
            }
            else
            {
                alert_toast("Star rating shouldn't be 0", "error")
				end_load()
            }
        
        });
    });
    </script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
    <style>
		#uni_modal .modal-footer{
			display: none;
		}
		#uni_modal .modal-footer.display{
			display: block !important;
		}

	</style>