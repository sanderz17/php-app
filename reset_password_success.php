<?php
include "connect.php";
?>

<!DOCTYPE html>
<html>

<head>
	<title>Homepage | Login</title>
	<?php include 'front_include/css.php'; ?>
</head>

<body>
	<?php include 'front_include/header.php'; ?>
	<div class="loader"></div>
	<section class="product-header-images">
	</section>
	<div class="set-new-password-page">
		<h1 class="dashboard-title">PASSWORD CHANGED</h1>
		<form id="forgot_frm" name="forgot_frm">
			<div class="field-wrapper">
				<p>SUCCESS! YOU HAVE CHANGED THE PASSWORD FOR YOUR ACCOUNT.</p>
			</div>
		</form>
	</div>

	<?php include 'front_include/footer.php'; ?>
	<?php include 'front_include/js.php'; ?>
</body>

</html>