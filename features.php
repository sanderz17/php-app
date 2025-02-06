<?php
	include('connect.php');
	$header_white = 1;
?>
<!doctype html>
<html lang="en">
	<head>
		<title>Features</title>
		<?php include('front_include/css.php'); ?>
	</head>
	<body>
		<div class="loader"></div>
		<?php include('front_include/header.php'); ?>
		 
		<!-- subpage banner start -->
		<div class="inner-main-banner">
			<img src="<?php echo SITEURL; ?>assets/images/grd-banner.png" alt="banner-img" class="main-img">
			<div class="inner-content">
				<div class="container">
					<div class="row">
						<div class="col-lg-12">
							<h1>Features</h1>
							<div class="short-divider"></div>
							<p>Discover all the things that you can do to help make your day perfect</p>
						</div>
					</div>
				</div>
			</div>
		</div>
		<!-- subpage banner end -->

		<div class="content">
			<div class="feature-block-main ">
                <div class="container">
					<div class="row align-items-center">
						<div class="col-md-6">
							<div class="video-block">
								<iframe src="https://www.youtube.com/embed/yAoLSRbwxL8" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
							</div>
						</div>
						<div class="col-md-6">
                            <div class="content-img pl-content">
								<h2>Customized Website</h2>
								<p>Start with one of our beautifully designed themes or create your vision from scratch.</p>
							</div>
						</div>
						
					</div>
				</div>
			</div>
			<div class="feature-block-main background-feature flex-column-row">
                <div class="container">
					<div class="row align-items-center">
						<div class="col-md-6">
                            <div class="content-img pr-content">
								<h2>Wedding Checklist</h2>
								<p>Get a personalized wedding checklist from now until you say "I do!"</p>
								<a href="#" class="btn btn-border btn-white">Find out more</a>
							</div>
						</div>
						<div class="col-md-6">
							<div class="img-block">
								<img src="<?php echo SITEURL; ?>assets/images/Wedding Checklist.jpg" alt="img">
							</div>
						</div>
					</div>
				</div>
			</div>
			<div class="feature-block-main ">
                <div class="container">
					<div class="row align-items-center">
						<div class="col-md-6">
							<div class="img-block">
								<img src="<?php echo SITEURL; ?>assets/images/wedding-img.png" alt="img">
							</div>
						</div>
						<div class="col-md-6">
                            <div class="content-img pl-content">
								<h2>Wedding Invitations</h2>
								<p>Online and printed options available.</p>
								<a href="#" class="btn btn-border btn-white">Find out more</a>
							</div>
						</div>
					</div>
				</div>
			</div>
			<div class="feature-block-main background-feature flex-column-row">
                <div class="container">
					<div class="row align-items-center">
						<div class="col-md-6">
                            <div class="content-img pr-content">
								<h2>RSVP</h2>
								<p>Ask your guests dietary requirements, hotel, song choice... No need for the back-and-forth!</p>
								<a href="#" class="btn btn-border btn-white">Wedding Guest RSVP</a>
							</div>
						</div>
						<div class="col-md-6">
							<div class="video-block">
								<iframe src="https://www.youtube.com/embed/yAoLSRbwxL8" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
							</div>
						</div>
					</div>
				</div>
			</div>
			<div class="feature-block-main ">
                <div class="container">
					<div class="row align-items-center">
						<div class="col-md-6">
							<div class="video-block">
								<iframe src="https://www.youtube.com/embed/yAoLSRbwxL8" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
							</div>
						</div>
						<div class="col-md-6">
                            <div class="content-img pl-content">
								<h2>Seating Planner</h2>
								<p>Have your guests enter all their contact info straight into your guest list... easy!</p>
							</div>
						</div>
						
					</div>
				</div>
			</div>
			<div class="full-img-block">
				<img src="<?php echo SITEURL; ?>assets/images/feature-banner.png" alt="img-full">
			</div>
			<div class="services-block pt-diff">
                <div class="container">
					<div class="row">
						<div class="col-lg-4 col-md-4">
							<div class="icon-img-block img-one">
								<img src="<?php echo SITEURL; ?>assets/images/icon-information.png" alt="icon-img">
							</div>
							<div class="content-services">
								<h2>Guest Information</h2>
								<p>Guests can only add a +1 when you choose, so you can avoid that awkward conversation.</p>
							</div>
						</div>
						<div class="col-lg-4 col-md-4">
							<div class="icon-img-block img-two">
								<img src="<?php echo SITEURL; ?>assets/images/icon-ca.png" alt="icon-img">
							</div>
							<div class="content-services">
								<h2>Unique Address</h2>
								<p>Use your included Walk the Aisle address or upgrade for a Custom .ca Domain Name.</p>
							</div>
						</div>
						<div class="col-lg-4 col-md-4">
							<div class="icon-img-block img-three">
								<img src="<?php echo SITEURL; ?>assets/images/mail-icon.png" alt="icon-img">
								<div class="label-heart"><img src="<?php echo SITEURL; ?>assets/images/heart-icon.png" alt="heart-img"></div>
							</div>
							<div class="content-services">
								<h2>RSVP Alerts</h2>
								<p>Watch your RSVP attendees counter update in real time.</p>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
		<!-- home content end -->
		<?php include('front_include/footer.php'); ?>
		<?php include('front_include/js.php'); ?>
		<script type="text/javascript">
			$(document).ready(function(){
				$('.loader').hide();
			});
		</script>

	</body>
</html>