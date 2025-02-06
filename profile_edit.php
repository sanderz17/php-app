<?php
   include "connect.php";
  $db->checkLogin();

  if(isset($_REQUEST['dwfrm_profile_confirm']))
  {
    $first_name     = $db->clean($_REQUEST['first_name']);
    $last_name      = $db->clean($_REQUEST['last_name']);
    $email          = $db->clean($_REQUEST['email']);
    $con_email      = $db->clean($_REQUEST['con_email']);
    $phone          = $db->clean($_REQUEST['phone']);
    $password       = $db->clean($_REQUEST['password']);
    $new_password       = $db->clean($_REQUEST['new_password']);
    $exampleCheck1  = $db->clean($_REQUEST['exampleCheck1']);


    $isMail = 0;
    if($exampleCheck1 !== "")
    {
      $isMail = 1;
    }    
   
    if($con_email!="" && $password!="" && !filter_var($con_email, FILTER_VALIDATE_EMAIL) === false)
    {

        $check_user_r = $db->getData("user","*","email = '".$con_email."' AND isDelete=0 ");

        if(@mysqli_num_rows($check_user_r)>0)
        {

          $row = array(
            "first_name"  => $first_name,
            "last_name"   => $last_name,
            "phone"       => $phone,
            "password"    => md5($new_password),
            "isMail"      => $isMail,
          );

    // echo "<pre>";
    // print_r($row);
    // die;
          $db->update("user",$row,"id=".$_SESSION[SESS_PRE.'_SESS_USER_ID']);
          $_SESSION['MSG'] = 'Update_profile_successfully';
            $db->location(SITEURL."profile-update");
        }
        else
        {
          $_SESSION['MSG'] = 'Invalid_Email_Password';
          $db->location(SITEURL."profile-update");
        }
    }
    else
    {
      $_SESSION['MSG'] = 'Something_Wrong';
      $db->location(SITEURL);
    }
  }

   $profile = $db->getData("user","*","id=".$_SESSION[SESS_PRE.'_SESS_USER_ID']);
   $profile_data = mysqli_fetch_assoc($profile);

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
         <!-- <div class="product-hero" style="background-image:url('../img/product-hero.jpg')">
            <div class="overlay"></div>
            <div class="container">
               <h3>Profile </h3>
               <p>Welcome to Clear Ballistics, a leading clear synthetic ballistics gelatin manufacturing company providing professional grade products for testing, investigating, and a variety of other applications and purposes. </p>
               <img src="<?php echo SITEURL; ?>img/hero-gelatinBlock.png" alt="">
            </div>
         </div>
         <div class="pl-breadcrumb">
            <div class="container">
               <ul class="breadcrumb">
                  <li><a href="#">Home /</a></li>
                  <li>Profile</li>
               </ul>
            </div>
         </div> -->
      </section>
      <!-- header section end -->
      <!-- profile main section start  -->
	  <section class="profile-section-main mt-5">
         <div class="container-fluid">
            <div class="row">
               <?php include 'front_include/account_leftmenu.php'; ?>
			   <div class="col-md-8">
            <div class="primary-content">
              
			   <div class="dashboard-title show-for-large">Profile </div>
			   <hr>
               <div class="account-dashboard">
                  <div class="data-table">
                     <div class="form-group">
                     	<form id="profile_form_edit" method="post" action="<?php echo SITEURL; ?>profile-update">
							 <div class="row">
								 <div class="col-md-6">
										<div class="row_profile_edit">
											<!-- <div class="row-title">FIRST NAME</div> -->
                      <label class="row-title" for="first_name">FIRST NAME<code>*</code></label>
										  	<input type="text" class="form-control" id="first_name" name="first_name" placeholder="Enter Your first name" value="<?php echo $profile_data['first_name']; ?>">
										</div>
                  </div>
								  <div class="col-md-6">
										<div class="row_profile_edit">
                      <label class="row-title" for="last_name">LAST NAME<code>*</code></label>
											<input type="text" class="form-control" id="last_name" name="last_name" placeholder="Enter Your last name" value="<?php echo $profile_data['last_name']; ?>">
										</div>
                  </div>
   									
								  <div class="col-md-12">
										<div class="row_profile_edit">
                      <label class="row-title" for="email">EMAIL<code>*</code></label>
											<input type="email" class="form-control" id="email" name="email" placeholder="Enter Your Email" value="<?php echo $profile_data['email']; ?>" readonly >
										</div>
                  </div>

                  <div class="col-md-12">
                    <div class="row_profile_edit">
                      <label class="row-title" for="con_email"> CONFIRM EMAIL<code>*</code></label>
                      <input type="email" class="form-control" id="con_email" name="con_email" placeholder="Enter Your Confirm Email" value="">
                    </div>
                  </div>

								  <div class="col-md-12">
										<div class="row_profile_edit">
                    <label class="row-title" for="phone">Phone</label>
										<input type="text" class="form-control" id="phone" name="phone" placeholder="Enter Your Phone" value="<?php echo $profile_data['phone']; ?>">
										</div>
                  </div>

   								<div class="col-md-12">
  									<div class="row_profile_edit">
                      <label class="row-title" for="password">Password<code>*</code></label>
  										<input type="password" class="form-control" id="password" name="password" placeholder="Enter Your Password" value="<?php echo $profile_data['password']; ?>" readonly>
  										<!-- <p class="account-description text-transform-none">
  											Your password must:<br>
  											- be at least 8 characters long<br>
  											- contain at least one uppercase letter<br>
  											- contain at least one number<br>
  											- contain at least one of the following symbols: $%/()[]{}=?!.,-_*|+~#@
  										</p> -->
  									</div>
                  </div>

								 <div class="col-md-12">
									<div class="row_profile_edit">
                    <label class="row-title" for="new_password">New Password<code>*</code></label>
										<input type="password" class="form-control" id="new_password" name="new_password" placeholder="Enter Your Confirm Password" value="">
							    </div>
                </div>

                <div class="col-md-12">
                  <div class="row_profile_edit">
                    <label class="row-title" for="password_confirm">Confirm Password<code>*</code></label>
                    <input type="password" class="form-control" id="password_confirm" name="password_confirm" placeholder="Enter Your Confirm Password" value="">
                  </div>
                </div>


								<div class="col-md-12">
									<div class="row_profile_edit">
										<div class="form-check">
											<input type="checkbox" class="form-check-input" id="exampleCheck1" name="exampleCheck1">
											<label class="form-check-label" for="exampleCheck1">Please add me to the CB email list.</label>
											<!-- <p>YETI is commited to protecting the privacy of your information. View our PRIVACY POLICY</p> -->
                      <p>Clear Ballistics is committed to protecting the privacy of your information. View our <a href="<?php echo SITEURL; ?>privacy-policy/">PRIVACY POLICY</a></p>
										</div>
                  </div>
                </div>

                <div class="col-md-12">
									<div class="row_profile_edit">
									 <button class="button-save" type="submit" value="Apply" name="dwfrm_profile_confirm">Save edits</button>
									</div>
                </div>

                                </div>
                           </div>
	                    </form>
                     </div>
                  </div>
               </div>
                 </div>
             </div>
           </div>
         </div>
            </div>
         </div>
      </section>
      <!-- profile main section end  -->
      <?php include 'front_include/footer.php'; ?>
      <?php include 'front_include/js.php'; ?>

      <script type="text/javascript">
        $(function(){
          $("#profile_form_edit").validate({
            rules: {
              first_name:{required:true},
              last_name:{required:true},
              email:{required:true},
              con_email:{required:true,equalTo: "#email"},
              password:{required:true,minlength: 6},
              new_password:{required:true,minlength: 6},
              password_confirm:{required:true,minlength: 6,equalTo: "#new_password"},
            },
            messages: {
              first_name:{required:"Please enter first name."},
              last_name:{required:"Please enter last name."},
              email:{required:"Please enter email."},
              con_email:{required:"Please enter confirm email."},
              password:{required:"Please enter password."},
              new_password:{required:"Please enter new password."},
              password_confirm:{required:"Please enter confirm password."},
            },
            errolacement: function(error, element) {
            },
          });
        });
      </script>

   </body>
</html>