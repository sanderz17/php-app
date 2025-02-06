<?php
	include "connect.php";
?>

<!DOCTYPE html>
<html>
	<head>
		<title>Homepage | Profile</title>
		<?php include 'front_include/css.php'; ?>
	</head>
	<body>
		<?php include 'front_include/header.php'; ?>
	
		<!--  header section start -->
         <section class="product-header-images">
				<div class="product-hero" style="background-image:url('<?php echo SITEURL; ?>img/seewhat_img.jpg')">
					<div class="overlay"></div>
					<div class="container">
					<h3>LET'S TAG TEAM </h3>
					<p>The next time a Clear Ballistics makes the cut in one of your epic shots, feel free to tag us on Instagram or Twitter using #SeeWhatYouShoot. You keep us inspired.</p>
					
					</div>
				</div>
					<div class="pl-breadcrumb">
						<div class="container">
							<ul class="breadcrumb">
								<li><a href="#">Home /</a></li>
								<li>#SeeWhatYouShoot</li>
							</ul>
						</div>
					</div>
		 </section>
		<!-- header section end -->
        
		<!-- SeeWhatYouShoot main section start  -->
        
		<section class="seeWhatYouShoot-section">
	     	<div class="section-header text-center">
				<h4 class="mb-2">Follow Us <br>@ClearBallistics </h4>
				<h3><i class="fa fa-instagram"></i></h3>
			</div>
			<div class="container-fluid mt-2">
                  <div class="row">
					   	<?php
					   		$review = $db->getdata("review_img","*","isDelete=0");
					   		while($review_row = mysqli_fetch_assoc($review)){
						    	$img_status = 'img/home/'.$review_row['image_path'];
						    	if ($review_row['image_path']!="" && file_exists($img_status) ) {
					   			
								   	?>
								   <div class="col-lg-3 col-md-4">
									    <div class="image-grid">
			                                 <div class="image-grid__item">
											    <a href="#" data-toggle="modal" data-id="<?php echo $review_row['id'] ; ?>" class='userinfo' class="grid-item">
											        <div class="grid-item__image" style="background-image: url(<?php echo SITEURL; ?>img/home/<?php echo $review_row['image_path']; ?>)"></div>
											        <div class="grid-item__hover"></div>
											        <div class="grid-item__name"><i class="fa fa-instagram"></i>&nbspCB</div>
				                            	</a>
			                                 </div>
			                            </div>
			                       </div>
			                   		<?php
								}
                   			} 
                   		?>
                  </div>
            </div>
        </section>

		<!-- SeeWhatYouShoot main section end  -->


		<!-- thank-you modal start  -->

		<div class="modal fade social-insta-modal" id="social-insta-modal">
          <div class="modal-dialog modal-dialog-centered" role="document">
          <div class="modal-content">
              <div class="modal-header">
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                       <span aria-hidden="true">&times;</span>
                  </button>
              </div>
              <div class="modal-body">
                
                 
              </div>
          </div>
          </div>
      </div>

      <!-- thank-you modal end  -->
	
	<?php include 'front_include/footer.php'; ?>
	<?php include 'front_include/js.php'; ?>

<script>
$(document).ready(function(){
	$('.userinfo').click(function(){
  	var prouct_id = $(this).data('id');
	//	alert(prouct_id);
  // AJAX request
  $.ajax({
   url: '<?php echo SITEURL; ?>ajax_get_see_what.php',
   type: 'post',
   data: {prouct_id: prouct_id},
   success: function(response){ 
	//   alert(response);
	 // console.log(response);
	 $('.modal-body').html(response);
	 $('#social-insta-modal').modal('show'); 
   }
 });
});
});

	</script>


</body>
</html>