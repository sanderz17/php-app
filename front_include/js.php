<?php
include_once 'connect.php';

$theme_id = $db->getvalue("site_setting", "theme_id", "isDelete=0");
$theme_name = $db->getvalue("site_theme", "theme_name", "isDelete=0 AND id=" . $theme_id);

$theme_id = $theme_name;
// echo $theme;
// exit;
if (!empty($theme_id) && $theme_id != "") {
	$theme = $theme_id;
}
?>


<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/2.2.2/jquery.min.js" type="text/javascript"></script>
<!-- <script src="<?php echo SITEURL; ?>js/jquery-3.6.0.min.js"></script> -->

<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js"></script>
<script src="<?php echo SITEURL; ?>js/bootstrap.js"></script>
<script src="<?php echo SITEURL; ?>js/slick.min.js"></script>
<script src="<?php echo SITEURL; ?>js/jquery.validate.js"></script>
<script src="<?php echo SITEURL; ?>js/bootstrap-notify.js"></script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.13.1/js/bootstrap-select.min.js"></script>
<script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>

<script src="<?php echo SITEURL . $theme; ?>/js/jquery.fancybox.min.js"></script>
<script src="<?php echo SITEURL . $theme; ?>/js/custom.js?"></script>
<script src="<?php echo SITEURL . $theme; ?>/js/slide-out-panel.js"></script>

<script type="text/javascript">
	// google languages section start
	$(".google-trales > a").click(function() {
		$('#filters_select_store').css('display', 'block');
		$('.topbar-laft').removeClass('hidemenu')
	});

	$('#lan_tran_btn').click(function() {
		var goog_lang = $('#google_tran_lang').val();
		var current_flag = $(this).attr("data-content");
		$("#lan_tran_btn").val(goog_lang);
		$('#filters_select_store.filters-select-store').hide();
		translateLanguage(goog_lang)
	});
	// google languages section end
	const slideOutPanel = $('#slide-out-panel').SlideOutPanel({
		width: "500px",
		showScreen: true,
		screenClose: true,
		transition: 'ease',
		transitionDuration: '0.35s',
		closeBtn: '<i class="fa fa-times"></i>',
		closeBtnSize: '20px',
		afterClosed() {
			$('body').removeClass("modal-open");
		},
		beforeOpen() {
			$('body').addClass("modal-open");
		},

		//offsetTop: '10rem'

	});

	$(".loader").hide();

	/* 	$(".header-cart").mouseover(function() {
			//$('.mini-cart-content-wrap').css("opacity", "1");
		}, function() {
			$('.mini-cart-content-wrap').css("opacity", "0");
			$('.mini-cart-content-wrap').css("visibility", "hidden");
			$("#mini-cart-mobile").modal('hide');
		}); */

	function mini_header_modal(product_id) {
		$.ajax({
			type: "POST",
			url: SITEURL + 'product_db.php',
			data: {
				product_id: product_id,
				mode: 'Product_name_data',
			},
			beforeSend: function() {
				$(".loader").show();
			},
			success: function(data) {
				$(".loader").hide();
				$("#product_name_data").text(data);
				$("#mini-cart-mobile").modal('show');
				cart_details();
			},
		});
	}

	$(document).ready(function() {
		cart_details();
		//$('.loaders-main').addClass('hide');
		setTimeout(function() {
			<?php if (isset($_SESSION['MSG']) && $_SESSION['MSG'] == 'Something_Wrong') { ?>
				$.notify({
					message: 'Something went wrong, Please try again !'
				}, {
					type: 'danger'
				});

			<?php unset($_SESSION['MSG']);
			} else if (isset($_SESSION['MSG']) && $_SESSION['MSG'] == 'Invalid_Email_Password') { ?>
				$.notify({
					message: 'Invalid email or password.'
				}, {
					type: 'danger'
				});

			<?php unset($_SESSION['MSG']);
			} else if (isset($_SESSION['MSG']) && $_SESSION['MSG'] == 'Email_Sent') { ?>
				$.notify({
					message: 'Email Has been successfully sent.'
				}, {
					type: 'success'
				});

			<?php unset($_SESSION['MSG']);
			} else if (isset($_SESSION['MSG']) && $_SESSION['MSG'] == 'upgrade_plan') { ?>
				$.notify({
					message: 'Please upgrade your plan, user limit is over.'
				}, {
					type: 'danger'
				});

			<?php unset($_SESSION['MSG']);
			} else if (isset($_SESSION['MSG']) && $_SESSION['MSG'] == 'send_invitation') { ?>
				$.notify({
					message: 'Invitation sent successfully.'
				}, {
					type: 'success'
				});

			<?php unset($_SESSION['MSG']);
			} else if (isset($_SESSION['MSG']) && $_SESSION['MSG'] == 'Success_Login') { ?>
				$.notify({
					message: 'You have successfully logged in to the site.'
				}, {
					type: 'success'
				});

			<?php unset($_SESSION['MSG']);
			} else if (isset($_SESSION['MSG']) && $_SESSION['MSG'] == 'Domain_check') { ?>
				$.notify({
					message: 'Domain doesn\'t match.'
				}, {
					type: 'danger'
				});

			<?php unset($_SESSION['MSG']);
			} else if (isset($_SESSION['MSG']) && $_SESSION['MSG'] == 'Success_Plan') { ?>
				$.notify({
					message: 'You have successfully subscribed to the plan. Please check your email.'
				}, {
					type: 'success'
				});

			<?php unset($_SESSION['MSG']);
			} else if (isset($_SESSION['MSG']) && $_SESSION['MSG'] == 'subscribed') { ?>
				$.notify({
					message: 'You have successfully subscribed.'
				}, {
					type: 'success'
				});

			<?php unset($_SESSION['MSG']);
			} else if (isset($_SESSION['MSG']) && $_SESSION['MSG'] == 'group_accept') { ?>
				$.notify({
					message: 'Group invitation accepted successfully.'
				}, {
					type: 'success'
				});

			<?php unset($_SESSION['MSG']);
			} else if (isset($_SESSION['MSG']) && $_SESSION['MSG'] == 'Duplicate') { ?>
				$.notify({
					message: 'The record already exists. Please try another.'
				}, {
					type: 'danger'
				});

			<?php unset($_SESSION['MSG']);
			} else if (isset($_SESSION['MSG']) && $_SESSION['MSG'] == 'agency_accept') { ?>
				$.notify({
					message: 'Agency invitation accepted successfully.'
				}, {
					type: 'success'
				});

			<?php unset($_SESSION['MSG']);
			} else if (isset($_SESSION['MSG']) && $_SESSION['MSG'] == 'Acc_Not_Verified') { ?>
				$.notify({
					message: 'Sorry! your account is not verified. Please verify your account in order to login.'
				}, {
					type: 'danger'
				});

			<?php unset($_SESSION['MSG']);
			} else if (isset($_SESSION['MSG']) && $_SESSION['MSG'] == 'Invalid_Email_Password') { ?>
				$.notify({
					message: 'Invalid email or password.'
				}, {
					type: 'danger'
				});

			<?php unset($_SESSION['MSG']);
			} else if (isset($_SESSION['MSG']) && $_SESSION['MSG'] == 'Success_Signup') { ?>
				$.notify({
					message: 'You have successfully registered to <?php echo SITETITLE; ?>. Please check your email inbox and verify your account.'
				}, {
					type: 'success'
				});

			<?php unset($_SESSION['MSG']);
			} else if (isset($_SESSION['MSG']) && $_SESSION['MSG'] == 'FILL_ALL_DATA') { ?>
				$.notify({
					message: 'Fill all data.'
				}, {
					type: 'danger'
				});

			<?php unset($_SESSION['MSG']);
			} else if (isset($_SESSION['MSG']) && $_SESSION['MSG'] == 'Success_Fsent') { ?>
				$.notify({
					message: 'An email has been sent. Please click the link when you get it.'
				}, {
					type: 'success'
				});

			<?php unset($_SESSION['MSG']);
			} else if (isset($_SESSION['MSG']) && $_SESSION['MSG'] == 'Email_not_found') { ?>
				$.notify({
					message: 'Email not found.'
				}, {
					type: 'danger'
				});

			<?php unset($_SESSION['MSG']);
			} else if (isset($_SESSION['MSG']) && $_SESSION['MSG'] == 'Invalid_Email') { ?>
				$.notify({
					message: 'Invalid email.'
				}, {
					type: 'danger'
				});

			<?php unset($_SESSION['MSG']);
			} else if (isset($_SESSION['MSG']) && $_SESSION['MSG'] == 'Update_Pass') { ?>
				$.notify({
					message: 'Your password has been updated successfully.'
				}, {
					type: 'success'
				});

			<?php unset($_SESSION['MSG']);
			} else if (isset($_SESSION['MSG']) && $_SESSION['MSG'] == 'Update_desc') { ?>
				$.notify({
					message: 'Your information has been updated successfully.'
				}, {
					type: 'success'
				});

			<?php unset($_SESSION['MSG']);
			} else if (isset($_SESSION['MSG']) && $_SESSION['MSG'] == 'PASS_NOT_MATCH') { ?>
				$.notify({
					message: 'Your old password is not match.'
				}, {
					type: 'danger'
				});

			<?php unset($_SESSION['MSG']);
			} else if (isset($_SESSION['MSG']) && $_SESSION['MSG'] == 'PASS_CHANGED') { ?>
				$.notify({
					message: 'Your password is changed successfully.'
				}, {
					type: 'success'
				});

			<?php unset($_SESSION['MSG']);
			} else if (isset($_SESSION['MSG']) && $_SESSION['MSG'] == 'Renew_Account') { ?>
				$.notify({
					message: 'Your account has been renewed successfully.'
				}, {
					type: 'success'
				});

			<?php unset($_SESSION['MSG']);
			} else if (isset($_SESSION['MSG']) && $_SESSION['MSG'] == 'Link_Expired') { ?>
				$.notify({
					message: 'Your email verification link has expired, please enter your email and try again.'
				}, {
					type: 'danger'
				});

			<?php unset($_SESSION['MSG']);
			} else if (isset($_SESSION['MSG']) && $_SESSION['MSG'] == 'Grace_Expired') { ?>
				$.notify({
					message: 'Your grace period has been expired. Please contact site administrator.'
				}, {
					type: 'danger'
				});

			<?php unset($_SESSION['MSG']);
			} else if (isset($_SESSION['MSG']) && $_SESSION['MSG'] == 'INVALID_DATA') { ?>
				$.notify({
					message: 'Invalid data.'
				}, {
					type: 'danger'
				});

			<?php unset($_SESSION['MSG']);
			} else if (isset($_SESSION['MSG']) && $_SESSION['MSG'] == 'Success_contact_submit') { ?>
				$.notify({
					message: 'Contact request submitted successfully.'
				}, {
					type: 'success'
				});

			<?php unset($_SESSION['MSG']);
			} else if (isset($_SESSION['MSG']) && $_SESSION['MSG'] == 'Activate_account_success') { ?>
				$.notify({
					message: 'Your account is activated successfully.'
				}, {
					type: 'success'
				});

			<?php unset($_SESSION['MSG']);
			} else if (isset($_SESSION['MSG']) && $_SESSION['MSG'] == 'Subscribe_successfully') { ?>
				$.notify({
					message: 'You have subscribed successfully.'
				}, {
					type: 'success'
				});

			<?php unset($_SESSION['MSG']);
			} else if (isset($_SESSION['MSG']) && $_SESSION['MSG'] == 'Already_subscribe') { ?>
				$.notify({
					message: 'Already subscribed.'
				}, {
					type: 'danger'
				});

			<?php unset($_SESSION['MSG']);
			} else if (isset($_SESSION['MSG']) && $_SESSION['MSG'] == 'Update_profile_successfully') { ?>
				$.notify({
					message: 'Update profile successfully.'
				}, {
					type: 'success'
				});

			<?php unset($_SESSION['MSG']);
			} else if (isset($_SESSION['MSG']) && $_SESSION['MSG'] == 'Already_registred_email') { ?>
				$.notify({
					message: 'Email is already registerd. Please use another email.'
				}, {
					type: 'danger'
				});

			<?php unset($_SESSION['MSG']);
			} else if (isset($_SESSION['MSG']) && $_SESSION['MSG'] == 'Change_password_success') { ?>
				$.notify({
					message: 'Password changed successfully.'
				}, {
					type: 'success'
				});

			<?php unset($_SESSION['MSG']);
			} else if (isset($_SESSION['MSG']) && $_SESSION['MSG'] == 'Inserted') { ?>
				$.notify({
					message: 'Record added successfully.'
				}, {
					type: 'success'
				});

			<?php unset($_SESSION['MSG']);
			} else if (isset($_SESSION['MSG']) && $_SESSION['MSG'] == 'Updated') { ?>
				$.notify({
					message: 'Record updated successfully.'
				}, {
					type: 'success'
				});

			<?php unset($_SESSION['MSG']);
			} else if (isset($_SESSION['MSG']) && $_SESSION['MSG'] == 'Post_Edit') { ?>
				$.notify({
					message: 'Post updated successfully.'
				}, {
					type: 'success'
				});

			<?php unset($_SESSION['MSG']);
			} else if (isset($_SESSION['MSG']) && $_SESSION['MSG'] == 'Deleted') { ?>
				$.notify({
					message: 'Record deleted successfully.'
				}, {
					type: 'success'
				});

			<?php unset($_SESSION['MSG']);
			} else if (isset($_SESSION['MSG']) && $_SESSION['MSG'] == 'Update_profile_change_password') { ?>
				$.notify({
					message: 'Great, your new password has been set.'
				}, {
					type: 'success'
				});

			<?php unset($_SESSION['MSG']);
			} else if (isset($_SESSION['MSG']) && $_SESSION['MSG'] == 'Post_add') { ?>
				$.notify({
					message: 'Post added sccessfully.'
				}, {
					type: 'success'
				});

			<?php unset($_SESSION['MSG']);
			} else if (isset($_SESSION['MSG']) && $_SESSION['MSG'] == 'Not_Acceptable') { ?>
				$.notify({
					message: 'Please enter a valid code.'
				}, {
					type: 'success'
				});

			<?php unset($_SESSION['MSG']);
			} else if (isset($_SESSION['MSG']) && $_SESSION['MSG'] == 'no_match_old_password') { ?>
				$.notify({
					message: 'Sorry, the old password you entered does not match the password we have on record, please check and try again.'
				}, {
					type: 'danger'
				});

			<?php unset($_SESSION['MSG']);
			} else if (isset($_SESSION['MSG']) && !empty($_SESSION['MSG'])) { ?>
				$.notify({
					message: '<?php echo $_SESSION['MSG']; ?>'
				}, {
					type: 'danger'
				});

			<?php unset($_SESSION['MSG']);
			}
			?>
		}, 1000);


		//slideOutPanel.open();

	});

	function hover(element) {
		element.setAttribute('src', '<?php echo SITEURL; ?>images/pluse_sign_org.png');
	}

	function unhover(element) {
		element.setAttribute('src', '<?php echo SITEURL; ?>images/pluse_sign.png');
	}


	function qty_update(qty, id, pid) {
		// alert(qty);
		$.ajax({
			type: "POST",
			url: SITEURL + "cart_db.php",
			data: {
				mode: "update_qty",
				qty: qty,
				id: id,
				pid: pid,
			},
			beforeSend: function() {
				$(".loader").fadeIn();
			},
			success: function(data) {
				/* 				var dd = JSON.parse(data);
								console.log(dd['zero']);
								// alert(data);
								if(dd['zero'] == "0")
								{
								alert("Value must be less than or equal to "+dd['pro_qty']);
								}
								if (dd['zero'] == "2") {
				                    alert("Out of Stock ");
				                } */
				$(".loader").fadeOut();
				cart_details();
				header_cart();
				cart_totals();
				header_cart_count();
				cart_drawer_details();
			},
		});
	}

	function remove_cart(id) {
		$.ajax({
			type: "POST",
			url: SITEURL + "cart_db.php",
			data: {
				mode: "remove_cart",
				id: id,
			},
			beforeSend: function() {
				$(".loader").fadeIn();
			},
			success: function(data) {
				$(".loader").fadeOut();
				cart_details();
				header_cart();
				cart_totals();
				header_cart_count();
				cart_drawer_details();
				$.notify({
					message: 'Remove item sccessfully.'
				}, {
					type: 'success'
				});
			},
		});
	}

	function cart_details() {
		$(".loader").fadeIn();
		$.ajax({
			type: 'POST',
			url: SITEURL + 'ajax_get_cart_details.php',
			data: {},
			success: function(data) {
				$("#cart_detail_result").html(data);
				$(".loader").fadeOut();
			}
		});
	}
	cart_details();

	header_cart();

	function header_cart() {
		// alert('1');
		$.ajax({
			type: "POST",
			url: SITEURL + 'header_cart.php',
			data: {},
			beforeSend: function() {
				$(".loader").show();
			},
			success: function(data) {
				//console.log(data)
				// alert(data['total_header_cart']);
				$(".loader").hide();
				$("#header_cart_result").html(data);
				$("#header_cart_result2").html(data);
				// $("#total_header_cart").html(data['total_header_cart']);
				$(".mini-cart-mobile").addClass("active");
			},
		});
	}

	function cart_totals() {
		$(".loader").fadeIn();
		$.ajax({
			type: 'POST',
			url: SITEURL + 'ajax_cart_totals.php',
			data: {},
			success: function(data) {
				$(".loader").fadeOut();
				$("#tbody_totals").html(data);
			}
		});
	}
	cart_totals();

	function header_cart_count() {
		$(".loader").fadeIn();
		$.ajax({
			type: 'POST',
			url: SITEURL + 'ajax_header_cart_count.php',
			data: {},
			success: function(data) {
				$(".loader").fadeOut();
				$("#total_header_cart").html(data);
				$("#total_header_cart_mobile").html(data);
				$('.item-total-count').html(data + "Items")
			}
		});
	}
	// header_cart_count(); 

	function cart_drawer_details() {
		$(".loader").fadeIn();
		$.ajax({
			type: 'POST',
			url: SITEURL + 'ajax_get_drawer_cart.php',
			data: {},
			success: function(data) {
				$("#drawer-results").html(data);
				$(".loader").fadeOut();
			}
		});
	}
	cart_drawer_details();
</script>