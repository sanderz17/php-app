<?php
include "connect.php";
?>

<!DOCTYPE html>
<html>

<head>
	<title>Homepage | Sing Up</title>
	<?php include 'front_include/css.php'; ?>
	<script src="https://www.google.com/recaptcha/enterprise.js" async defer></script>
</head>

<body>
	<?php include 'front_include/header.php'; ?>
	<div class="loader"></div>
	<!--  header section start -->
	<section class="product-header-images">

	</section>
	<!-- header section end -->

	<!-- sign_in-page-section start-->

	<div class="clearballistics-login d-flex flex-column ">
		<div class="container my-auto">
			<div class="row">
				<div class="col-md-9 col-lg-7 col-xl-6 mx-auto">
					<div class="bg-white shadow-md rounded p-4 px-sm-5 mt-4">
						<div class="logo"> <a class="d-flex justify-content-center" href="index.html" title="clearballistics"><img src="<?php echo SITEURL; ?>img/imgpsh_fullsize_anim.png" alt="clearballistics"></a> </div>
						<hr class="mx-n4 mx-sm-n5">
						<p class="lead text-center">Welcome back. Let's get you sign up.</p>
						<form id="SignupForm" method="post" action="<?php echo SITEURL ?>   .php">
							<div class="form-group">
								<label for="emailAddress">First Name </label>
								<input type="text" class="form-control" name="first_name" id="first_name" required="" placeholder="Enter First name">
							</div>
							<div class="form-group">
								<label for="emailAddress">Last Name </label>
								<input type="text" class="form-control" name="last_name" id="last_name" required="" placeholder="Enter last name">
							</div>
							<div class="form-group">
								<label for="emailAddress">Email </label>
								<input type="email" class="form-control" name="email" id="email" required="" placeholder="Enter Your Email">
							</div>
							<div class="form-group">
								<label for="loginPassword">Password</label><span>*</span>
								<input type="password" class="form-control" name="password" id="password" required="" placeholder="Enter Password">
							</div>
							<div class="g-recaptcha" data-sitekey="6LeIel8pAAAAAHbSwk9CisClBbeYvQ6MdoQMFm3k" data-action="SIGNUP"></div>
							<a class="btn sign-btn" id="signup_submit" href="javascript:void(0)">Sign Up</a>
						</form>
					</div>
				</div>
			</div>
		</div>
	</div>
	<!-- sign_in-page-section end-->

	<?php include 'front_include/footer.php'; ?>
	<?php include 'front_include/js.php'; ?>


	<script type="text/javascript">
		$('.loader').hide();

		$("#SignupForm").validate({
			rules: {
				first_name: {
					required: true,
					email: true
				},
				last_name: {
					required: true
				},
				email: {
					required: true,
					email: true
				},
				password: {
					required: true,
					minlength: 8,
					maxlength: 32
				},
			},
			messages: {
				first_name: {
					required: "Please enter first name."
				},
				last_name: {
					required: "Please enter last name."
				},
				email: {
					required: "Please enter email.",
					email: "Please enter a valid username."
				},
				password: {
					required: "Please enter password.",
					minlength: "Enter at least 6 characters.",
					maxlength: "No more than 32 characters allow."
				},
			},
			errorPlacement: function(error, element) {
				error.insertAfter(element);
			}
		});

		$("#signup_submit").click(function(e) {
			e.preventDefault();
			const grecaptchaResponse = grecaptcha.enterprise.getResponse();
			if (!grecaptchaResponse.length > 0) {
				$.notify({
					message: 'The reCAPTCHA verification failed, please try again'
				}, {
					type: 'danger'
				});
			}
			$("#SignupForm").submit();
		});
	</script>


</body>

</html>