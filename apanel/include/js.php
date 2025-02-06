	<script type="text/javascript" src="https://code.jquery.com/jquery-3.3.1.js"></script>
   <!-- plugins:js -->
	<script src="<?php echo ADMINURL; ?>assets/vendors/js/vendor.bundle.base.js"></script>
	<!-- endinject -->
	<!-- Plugin js for this page -->
	<script src="<?php echo ADMINURL; ?>assets/vendors/chart.js/Chart.min.js"></script>
	<!-- End plugin js for this page -->
	<!-- inject:js -->
	<script src="<?php echo ADMINURL; ?>assets/js/off-canvas.js"></script>
	<script src="<?php echo ADMINURL; ?>assets/js/hoverable-collapse.js"></script>
	<script src="<?php echo ADMINURL; ?>assets/js/misc.js"></script>
	<!-- endinject -->
	<!-- Custom js for this page -->
	<script src="<?php echo ADMINURL; ?>assets/js/dashboard.js"></script>
	<script src="<?php echo ADMINURL; ?>assets/js/todolist.js"></script>

	<script src="<?php echo ADMINURL; ?>assets/js/bootstrap-notify.js"></script>
	<script src="<?php echo ADMINURL; ?>assets/js/jquery.validate.js"></script>

	<script src="https://cdn.datatables.net/1.10.20/js/jquery.dataTables.min.js"></script>
	<script src="https://cdn.datatables.net/1.10.20/js/dataTables.bootstrap4.min.js"></script>

	<script type="text/javascript">
		$(document).ready(function(){
			// Set theme color
			$('.background-color').css('background-color' , '<?php echo $_SESSION[SESS_PRE.'_ADMIN_THEME_COLOR']  ?>')

			setTimeout(function(){
			<?php if(isset($_SESSION['MSG']) && $_SESSION['MSG'] == 'Something_Wrong') { ?>
				 $.notify({message: 'Something went wrong, Please try again!' },{type: 'danger'});
			<?php unset($_SESSION['MSG']); } else if(isset($_SESSION['MSG']) && $_SESSION['MSG'] == 'INVALID_DATA') { ?>
				 $.notify({message: 'Invalid data. Please enter valid data.' },{type: 'danger'});
			<?php unset($_SESSION['MSG']); } else if(isset($_SESSION['MSG']) && $_SESSION['MSG'] == 'Inserted') { ?>
				 $.notify({message: 'Record added successfully.' },{type: 'success'});
			<?php unset($_SESSION['MSG']); } else if(isset($_SESSION['MSG']) && $_SESSION['MSG'] == 'Updated') { ?>
				 $.notify({message: 'Record updated successfully.' },{type: 'success'});
			<?php unset($_SESSION['MSG']); } else if(isset($_SESSION['MSG']) && $_SESSION['MSG'] == 'Deleted') { ?>
				$.notify({message: 'Record deleted successfully.'},{type: 'success'});
			<?php unset($_SESSION['MSG']); } else if(isset($_SESSION['MSG']) && $_SESSION['MSG'] == 'Restored') { ?>
				$.notify({message: 'Record restored successfully.'},{type: 'success'});
			<?php unset($_SESSION['MSG']); } else if(isset($_SESSION['MSG']) && $_SESSION['MSG'] == 'Activate_account_success') { ?>
				$.notify({message: 'Account activated successfully.'},{type: 'success'});
			<?php unset($_SESSION['MSG']); } else if(isset($_SESSION['MSG']) && $_SESSION['MSG'] == 'UPDATE_AC') { ?>
				$.notify({message: 'Your account information has been updated successfully.' },{type: 'success'});
			<?php unset($_SESSION['MSG']); } else if(isset($_SESSION['MSG']) && $_SESSION['MSG'] == 'PASS_NOT_MATCH') { ?>
				$.notify({message: 'Old password did not match.' },{type: 'danger'});
			<?php unset($_SESSION['MSG']); } else if(isset($_SESSION['MSG']) && $_SESSION['MSG'] == 'CURRENT_PASS_MATCH') { ?>
				$.notify({message: 'New and Confirm passwords must be different.' },{type: 'danger'});
			<?php unset($_SESSION['MSG']); } else if(isset($_SESSION['MSG']) && $_SESSION['MSG'] == 'PASS_CHANGED') { ?>
				$.notify({message: 'Password has been updated successfully.' },{type: 'success'});
			<?php unset($_SESSION['MSG']); } else if(isset($_SESSION['MSG']) && $_SESSION['MSG'] == 'Duplicate') { ?>
				$.notify({message: 'The record already exists. Please try another.'},{type: 'danger'});
			<?php unset($_SESSION['MSG']); } else if(isset($_SESSION['MSG']) && $_SESSION['MSG'] == 'Invalid_Email_Password') { ?>
				 $.notify({message: 'Invalid login details. Please try again!' },{type: 'danger'});
			<?php unset($_SESSION['MSG']); } else if(isset($_SESSION['MSG']) && $_SESSION['MSG'] == 'Success_Fsent') { ?>
				$.notify({message: 'Your reset password link is successfully sent to your registered email address.'},{type: 'success'});
			<?php unset($_SESSION['MSG']); } else if(isset($_SESSION['MSG']) && $_SESSION['MSG'] == 'Update_Pass') { ?>
				$.notify({message: 'Your password has been updated successfully.'},{type: 'success'});
			<?php unset($_SESSION['MSG']); } else if(isset($_SESSION['MSG']) && $_SESSION['MSG'] == 'No_Data_Found') { ?>
				$.notify({message: 'Your email address is not registered with us.'},{ type: 'danger'});
			<?php unset($_SESSION['MSG']); } else if(isset($_SESSION['MSG']) && $_SESSION['MSG'] == 'Link_Expired') { ?>
				$.notify({message: 'Your link to reset the password is expired.'},{type: 'danger'});
			<?php unset($_SESSION['MSG']); } else if(isset($_SESSION['MSG']) && $_SESSION['MSG'] == 'Success_login') { ?>
				$.notify({message: 'You have successfully logged in!'},{type: 'success'});
			<?php unset($_SESSION['MSG']); } else if(isset($_SESSION['MSG']) && $_SESSION['MSG'] == 'Activate_account') { ?>
				$.notify({message: 'Please activate your account.'},{type: 'danger'});
			<?php unset($_SESSION['MSG']); } else if(isset($_SESSION['MSG']) && $_SESSION['MSG'] == 'Same_Member_added_Multiple_Time') { ?>
				$.notify({message: 'Same team member added multiple time.'},{type: 'danger'});
			<?php unset($_SESSION['MSG']); } else if(isset($_SESSION['MSG']) && $_SESSION['MSG'] == 'Comapny_changed') { ?>
				$.notify({message: 'Company Changed.'},{type: 'danger'});
			<?php unset($_SESSION['MSG']); } else if(isset($_SESSION['MSG']) && $_SESSION['MSG'] == 'No_Matching_Data') { ?>
				$.notify({message: 'You have passed wrong details.'},{type: 'danger'});
			<?php unset($_SESSION['MSG']); } else if(isset($_SESSION['MSG']) && $_SESSION['MSG'] == 'Refund_order') { ?>
				$.notify({message: 'You have successfully refund.'},{type: 'success'});
			<?php unset($_SESSION['MSG']); } else if(isset($_SESSION['MSG']) && $_SESSION['MSG'] == 'OrderUpdated') { ?>
				$.notify({message: 'Order Updated.'},{type: 'success'});
			<?php unset($_SESSION['MSG']); } else if(isset($_SESSION['MSG']) && $_SESSION['MSG'] == 'Select_package') { ?>
				$.notify({message: 'Please select package.'},{type: 'danger'});
			<?php unset($_SESSION['MSG']); } else if(isset($_SESSION['MSG']) && !empty($_SESSION['MSG'])) { ?>
				$.notify({message: '<?php echo $_SESSION['MSG']; ?>'},{type: 'danger'});
			<?php unset($_SESSION['MSG']); } 
			?>
			},1000);
		});

		function check_all()
		{
			var chk = $("#chkall").prop("checked");
			if( chk )
			{
				$(document).find('input[name="chkid[]"]').each(function() {
					$(this).prop('checked', true);
				});         
			}
			else
			{
				$(document).find('input[name="chkid[]"]').each(function() {
					$(this).prop('checked', false);
				});         
			}
		}

		function bulk_delete()
		{
			var flg = 0;
			$('input[name="chkid[]"]').each(function () {
			   if (this.checked) {
				   flg = 1;
				   //break; 
			   }
			});

			if( flg )
			{
				if( confirm("Are you sure you want to remove selected records?") )
				{
					$('#hdnmode').val('delete');
					$.ajax({
						url: "<?php echo ADMINURL; ?>ajax_bulk_remove.php",
						type: "post",
						data : $('#frm').serialize(),
						success: function(response) {
							displayRecords(10,1);
						}
					});
				}
			}
			else
			{
				$.notify({message: "Please select at least one record."}, {type: "danger"});
				return false;
			}
			return false;
		}
		function bulk_restore()
		{
			var flg = 0;
			$('input[name="chkid[]"]').each(function () {
			   if (this.checked) {
				   flg = 1;
				   //break; 
			   }
			});

			if( flg )
			{
				if( confirm("Are you sure you want to restore selected records?") )
				{
					$('#hdnmode').val('restore');
					$.ajax({
						url: "<?php echo ADMINURL; ?>ajax_bulk_remove.php",
						type: "post",
						data : $('#frm').serialize(),
						success: function(response) {
							displayRecords(10,1);
						}
					});
				}
			}
			else
			{
				$.notify({message: "Please select at least one record."}, {type: "danger"});
				return false;
			}
			return false;
		}
		function bulk_archieve()
		{
			var flg = 0;
			$('input[name="chkid[]"]').each(function () {
			   if (this.checked) {
				   flg = 1;
				   //break; 
			   }
			});

			if( flg )
			{
				if( confirm("Are you sure you want to remove selected records?") )
				{
					$('#hdnmode').val('archieve');
					$.ajax({
						url: "<?php echo ADMINURL; ?>ajax_bulk_remove.php",
						type: "post",
						data : $('#frm').serialize(),
						success: function(response) {
							displayRecords(10,1);
						}
					});
				}
			}
			else
			{
				$.notify({message: "Please select at least one record."}, {type: "danger"});
				return false;
			}
			return false;
		}

		$('.num').keypress(function(event) {
			//alert(event.which);
			if( (event.which < 48 || event.which > 57) && event.which != 46)
				event.preventDefault();

			if( $(this).val().length >= 6 )
				event.preventDefault();
			else if( $(this).val() <= 0 && event.which == 48)
			{
				alert("Value cannot be zero.");
				return false;
			}
			else
			{
				if( (event.which < 48 || event.which > 57) && event.which != 46)
				   event.preventDefault();
			}
		});
	</script>   
	<script type="text/javascript">
				$(function(){
					$("#subscribe").validate({
						ignore: "",
						rules: {
							email:{required:true,email:true}
						},
						messages: {
							email:{required:"Please enter email",email:"Please enter valid email."}
						},
						errorPlacement: function(error, element) {
							error.insertAfter(element);
						}
					});
				});
			</script>