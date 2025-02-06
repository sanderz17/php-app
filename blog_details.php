<?php
	include "connect.php";
	$one_blog = $db->getData("blog","*","isDelete=0 AND id=".$_REQUEST['id']);
	$one_blog_r = mysqli_fetch_assoc($one_blog);

?>
<!DOCTYPE html>
<html>
	<head>
		<title>Homepage | Blog Details</title>
		<link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
		<?php include 'front_include/css.php'; ?>
		<style>
			.submit-btn a {
			background: #292d31;
			border-radius: 5px;
			padding: 14px 35px;
			color: #ffffff;
			font-weight: 300;
			font-size: 16px;
			text-transform: uppercase;
			}
			.view-btn-news a {
				background: rgb(219 219 219);
				color: #292d31;
				font-weight: 400;
			}
			.blog-details-section-box .img-box {
				width: 100%;
				height: 600px;
			}
		</style>
	</head>
	<body>
		<?php include 'front_include/header.php'; ?>
		<!--  header section start -->
         <section class="product-header-images">
			
		 </section>
		<!-- header section end -->


		<!-- Blog Details section stat -->

		<section class="blog-details-section mt-2">
             <div class="container-fluid">
				 <div class="row">
					 <!-- <div class="col-md-7"> -->
					 <div class="col-md-12">
						<div class="blog-details-section-box">
							<h2><?php echo $one_blog_r['title']; ?></h2>
							  <img src="<?php echo SITEURL.BLOG.$one_blog_r['image_path']; ?>" class="img-box">
							  <div class="container"> 
							  <div class="blog-details-content mt-5">
								   <?php echo $one_blog_r['descr']; ?>
							  </div>
							  </div>
						  </div>
					 </div>

					 <!-- <div class="col-md-5">
						<div class="blog_sidebar">
							<div class="content_sidebar">
								<p>The Clear Ballistics event is a place of regular pondering of all things trend-led. Our team of stylists, designers, marketers and product managers are always posting something interesting, relevant and worth a read.</p>
								<ol class="push--small">
									<?php
                                        $blog_d = $db->getData("blog","*","isDelete=0");
                                        while ($blog_r = mysqli_fetch_assoc($blog_d)) {
                                    ?>
									<li><a href="<?php echo SITEURL ?>blog-details/<?php echo $blog_r['id']; ?>/" class="nav__item active">
										<span class="h--upper small nav__inner"><?php echo $blog_r['title']; ?></span></a>
									</li>
									<?php
                                        }
                                    ?>						
								</ol>
							</div>
						</div>
					 </div> -->
				</div>

				<!-- <div class="blog-product-images">
					<div class="row">
						<div class="col-xl-3 col-sm-6">
							<a href="#">
							 <div class="product-images-box">
								<img src="<?php echo SITEURL ?>img/product-slid-img-01.png" alt="">
								<h4>10% Synthetic Ballistic Gelatin</h4>
							 </div> 
							</a>
						</div>

						<div class="col-xl-3 col-sm-6">
							<a href="#">
							 <div class="product-images-box">
								<img src="<?php echo SITEURL ?>img/product-slid-img-01.png" alt="">
								<h4>10% Synthetic Ballistic Gelatin</h4>
							 </div> 
							</a>
						</div>
					</div>		
				</div> -->

				<div class="blog-des-btn">
                    <div class="row">
	                    <div class="col-lg-4">
	                    	<?php
	                    	$pre_blog_id = $db->getValue("blog","id","id=(select max(id) from blog where id < ".$_REQUEST['id'].") AND isDelete=0 ",0);
	                    	if ($pre_blog_id>0 && $pre_blog_id!="") {
		                    	?>
	                            <div class="submit-btn mt-5">
	                                <a href="<?php echo SITEURL ?>blog-details/<?php echo $pre_blog_id; ?>">Previous</a>
	                            </div>
		                        <?php
	                    	}
	                        ?>
	                    </div>
                        <div class="col-lg-4">
	                        <div class="submit-btn mt-5 text-center view-btn-news">
	                            <a href="<?php echo SITEURL ?>blog">VIEW ALL BLOGS</a>
	                        </div>
                      	</div>
	                    <div class="col-lg-4">
	                      	<?php
	                      	$next_blog_id = $db->getValue("blog","id","id=(select min(id) from blog where id > ".$_REQUEST['id'].") AND isDelete=0 ",0);

	                      	if ($next_blog_id>0 && $next_blog_id!="") {
	                      		?>
	                            <div class="submit-btn mt-5 text-right">
	                                <a href="<?php echo SITEURL ?>blog-details/<?php echo $next_blog_id; ?>">Next</a>
	                            </div>
		                      	<?php
	                  		}
	                      	?>
		                </div>
                    </div>
                </div>

			 </div>
	    </section>
       
		<!-- Blog Details Section end -->
	
		<?php include 'front_include/footer.php'; ?>
		<?php include 'front_include/js.php'; ?>
	
	</body>
</html>