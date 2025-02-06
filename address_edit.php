<?php
   include "connect.php";
  $db->checkLogin();

  $cart_id = $_SESSION[SESS_PRE.'_SESS_CART_ID'];

  $user_id = 0;
  if (!empty($_SESSION[SESS_PRE.'_SESS_USER_ID']) && $_SESSION[SESS_PRE.'_SESS_USER_ID'] ) 
    $user_id = $_SESSION[SESS_PRE.'_SESS_USER_ID'];

  if(isset($_REQUEST['address_change']))
  {

    $shipping_first_name     = $db->clean($_REQUEST['shipping_first_name']);
    $shipping_last_name      = $db->clean($_REQUEST['shipping_last_name']);
    $shipping_street_addr    = $db->clean($_REQUEST['shipping_street_addr']);
    $shipping_addr2          = $db->clean($_REQUEST['shipping_addr2']);
    $shipping_country        = $db->clean($_REQUEST['shipping_country']);
    $shipping_post           = $db->clean($_REQUEST['shipping_post']);
    $shipping_state          = $db->clean($_REQUEST['shipping_state']);
    $shipping_city           = $db->clean($_REQUEST['shipping_city']);
    $shipping_phone          = $db->clean($_REQUEST['shipping_phone']);  
   
    if($shipping_first_name!="" && $shipping_last_name!="" )
    {
      $shipp_arr = array(
        "user_id" => $user_id,

        "shipping_first_name"   => $shipping_first_name,
        "shipping_last_name"  => $shipping_last_name,
        "shipping_address"    => $shipping_street_addr,
        "shipping_address2"   => $shipping_addr2,
        "shipping_country"    => $shipping_country,
        "shipping_zipcode"    => $shipping_post,
        "shipping_state"    => $shipping_state,
        "shipping_phone"    => $shipping_phone,
        "shipping_city"     => $shipping_city,
      );
      
      // echo "<pre>";
      // print_r($shipp_arr);
      // die;

      // $db->update("billing_shipping",$shipp_arr,"id=".$_SESSION[SESS_PRE.'_SESS_USER_ID']);
      // $_SESSION['MSG'] = 'Update_profile_successfully';
      // $db->location(SITEURL."address-update");

      $dupcheck = $db->dupCheck("billing_shipping","isDelete=0 AND user_id=".$user_id." AND cart_id=".$cart_id);
      if ($dupcheck) 
      {
        $b_id = $db->update("billing_shipping",$shipp_arr,"isDelete=0 AND user_id=".$user_id." AND cart_id=".$cart_id);
        $_SESSION['MSG'] = 'Updated';
      }
      else
      {
        $b_id = $db->insert("billing_shipping",$shipp_arr);
        $_SESSION['MSG'] = 'Inserted';
      }
        
    }
    else
    {
      $_SESSION['MSG'] = 'Something_Wrong';
      $db->location(SITEURL);
    }
  }

   // $profile = $db->getData("user","*","id=".$_SESSION[SESS_PRE.'_SESS_USER_ID']);
   // $profile_data = mysqli_fetch_assoc($profile);

  // echo "<pre>";
  // print_r("user_id".$user_id);
  // print_r("cart_id".$cart_id);
  // die;

   $user = $_REQUEST['userType'];
    $user_id = $_SESSION[SESS_PRE.'_SESS_USER_ID'];
    $cart_id = $_SESSION[SESS_PRE.'_SESS_CART_ID'];

    $billing_first_name = "";
    $billing_last_name  = "";
    $billing_email = "";
    $billing_phone = "";
    $billing_address = "";
    $billing_address2 = "";
    $billing_city = "";
    $billing_state = "";
    $billing_country = "";
    $billing_zipcode = "";
    $shipping_first_name = "";
    $shipping_last_name = "";
    $shipping_email = "";
    $shipping_phone = "";
    $shipping_address = "";
    $shipping_address2 = "";
    $shipping_city = "";
    $shipping_state = "";
    $shipping_country = "";
    $shipping_zipcode = "";

    // if (isset($user_id) && $user_id != "" && $cart_id != 0 && isset($cart_id)) {    
    if (isset($user_id) && $user_id != "") {    
        // $shipping_d = $db->getData("billing_shipping","*","isDelete=0 AND user_id=".$user_id." AND cart_id=".$cart_id,"id DESC");
      $shipping_d = $db->getData("billing_shipping","*","isDelete=0 AND user_id=".$user_id." ","id DESC");
        $shipping_r = mysqli_fetch_assoc($shipping_d);
            $billing_first_name = $shipping_r['billing_first_name'];
            $billing_last_name  = $shipping_r['billing_last_name'];
            $billing_email = $shipping_r['billing_email'];
            $billing_phone = $shipping_r['billing_phone'];
            $billing_address = $shipping_r['billing_address'];
            $billing_address2 = $shipping_r['billing_address2'];
            $billing_city = $shipping_r['billing_city'];
            $billing_state = $shipping_r['billing_state'];
            $billing_country = $shipping_r['billing_country'];
            $billing_zipcode = $shipping_r['billing_zipcode'];

            $shipping_first_name = $shipping_r['shipping_first_name'];
            $shipping_last_name = $shipping_r['shipping_last_name'];
            $shipping_email = $shipping_r['shipping_email'];
            $shipping_phone = $shipping_r['shipping_phone'];
            $shipping_address = $shipping_r['shipping_address'];
            $shipping_address2 = $shipping_r['shipping_address2'];
            $shipping_city = $shipping_r['shipping_city'];
            $shipping_state = $shipping_r['shipping_state'];
            $shipping_country = $shipping_r['shipping_country'];
            $shipping_zipcode = $shipping_r['shipping_zipcode'];
        // echo $shipping_country;
    }

   ?>
<!DOCTYPE html>
<html>
   <head>
      <title>Homepage | Address</title>
      <?php include 'front_include/css.php'; ?>
	
   </head>
   <body>
      <?php include 'front_include/header.php'; ?>
      <!--  header section start -->
      <section class="product-header-images">
      </section>
      <!-- header section end -->
      <!-- profile main section start  -->
	  <section class="profile-section-main mt-5">
         <div class="container-fluid">
            <div class="row">
               <?php include 'front_include/account_leftmenu.php'; ?>
			   <div class="col-md-8">
            <div class="primary-content">
              
			   <div class="dashboard-title show-for-large">Address </div>
			   <hr>
               <div class="account-dashboard">
                  <div class="data-table">
                     <div class="form-group">
                     	<form id="shipping_form_step" method="post" action="<?php echo SITEURL; ?>address-update">
							 <div class="row">

								 <div class="col-md-12">
										<div class="row_profile_edit">
                      <label class="row-title" for="shipping_first_name">FIRST NAME</label>
										  	<input type="text" class="form-control" id="shipping_first_name" name="shipping_first_name" placeholder="Enter Your first name" value="<?php echo $shipping_first_name; ?>">
										</div>
                  </div>
								  <div class="col-md-12">
										<div class="row_profile_edit">
                      <label class="row-title" for="shipping_last_name">LAST NAME</label>
											<input type="text" class="form-control" id="shipping_last_name" name="shipping_last_name" placeholder="Enter Your last name" value="<?php echo $shipping_last_name; ?>">
										</div>
                  </div>

                  <div class="col-md-12">
                    <div class="row_profile_edit">
                      <label class="row-title" for="shipping_street_addr">Shipping Address</label>
                      <input type="text" class="form-control" id="shipping_street_addr" name="shipping_street_addr" placeholder="Enter Your Shipping Address" value="<?php echo $shipping_address; ?>" >
                    </div>
                  </div>

                  <div class="col-md-12">
                    <div class="row_profile_edit">
                      <label class="row-title" for="shipping_addr2">Shipping Address 2</label>
                      <input type="text" class="form-control" id="shipping_addr2" name="shipping_addr2" placeholder="Enter Your Shipping Address" value="<?php echo $shipping_address2; ?>" >
                    </div>
                  </div>

                  <div class="col-md-6">
                    <div class="row_profile_edit">
                        <select class="form-control" required="" aria-required="true" onchange="getState(this.value);" name="shipping_country" id="shipping_country">
                            <option value="">Country / Region</option>
                            <?php 
                                $country_d = $db->getData("countries","*");
                                foreach ($country_d as $key => $country_r) {
                            ?>
                                <option value="<?php echo $country_r['id'] ?>" <?php if($country_r['id'] == $shipping_country){ echo "Selected"; } ?>><?php echo $country_r['name']; ?></option>
                            <?php
                                }
                            ?>
                        </select>
                    </div>
                  </div>

                  <div class="col-md-6">
                    <div class="row_profile_edit">
                      <input type="text" name="shipping_post" id="shipping_post" placeholder="Postcode" class="form-control" value="<?php echo $shipping_zipcode; ?>">
                    </div>
                  </div>

                  <div class="col-md-6">
                    <div class="row_profile_edit">
                      <select name="shipping_state" id="shipping_state" class="form-control"></select>
                    </div>
                  </div>
                  <div class="col-md-6">
                    <div class="row_profile_edit">
                      <input type="text" name="shipping_city" id="shipping_city" placeholder="City" class="form-control" value="<?php echo $shipping_city; ?>">
                    </div>
                  </div>
   									
								  

								  <div class="col-md-12">
										<div class="row_profile_edit">
                      <label class="row-title" for="shipping_phone">Phone</label>
  										<!-- <input type="text" class="form-control" id="shipping_phone" name="shipping_phone" placeholder="Enter Your Phone" value="<?php echo $shipping_phone; ?>"> -->
                      <input type="text" name="shipping_phone" id="shipping_phone" placeholder="Enter Your Phone" class="form-control" value="<?php echo $shipping_phone; ?>" maxlength="14" >
										</div>
                  </div>

                <div class="col-md-12">
									<div class="row_profile_edit">
									 <!-- <button class="button-save" type="submit" name="address_change">Edits</button> -->
                   <button class="button-save" type="submit" name="address_change">Update</button>
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
        // $(function(){
        //   $("#profile_form_edit").validate({
        //     rules: {
        //       first_name:{required:true},
        //       last_name:{required:true},
        //       email:{required:true},
        //       con_email:{required:true,equalTo: "#email"},
        //       password:{required:true,minlength: 6},
        //       new_password:{required:true,minlength: 6},
        //       password_confirm:{required:true,minlength: 6,equalTo: "#new_password"},
        //     },
        //     messages: {
        //       first_name:{required:"Please enter first name."},
        //       last_name:{required:"Please enter last name."},
        //       email:{required:"Please enter email."},
        //       con_email:{required:"Please enter confirm email."},
        //       password:{required:"Please enter password."},
        //       new_password:{required:"Please enter new password."},
        //       password_confirm:{required:"Please enter confirm password."},
        //     },
        //     errolacement: function(error, element) {
        //     },
        //   });
        // });

        $(function(){
          $("#shipping_form_step").validate({
            rules: {
              shipping_first_name:{required : true},
              shipping_last_name:{required : true},
              shipping_street_addr:{required : true},
              //shipping_addr2:{required : true},
              shipping_country:{required : true},
              shipping_post:{required : true},
              shipping_state:{required : true},
              shipping_phone:{required : true},
              shipping_city:{required : true},
            },
            messages: {
              shipping_first_name:{required:"Please enter first name."},
              shipping_last_name:{required:"Please enter last name."},
              shipping_street_addr:{required:"Please enter street address."},
              //shipping_addr2:{required:"Please enter other address."},
              shipping_country:{required:"Please enter country."},
              shipping_post:{required:"Please enter post code."},
              shipping_state:{required:"Please enter state."},
              shipping_phone:{required:"Please enter phone number."},
              shipping_city:{required:"Please enter city name."},
            },
            errolacement: function(error, element) {
            },
          });
        });

        function getState(country_id)
        {
            // var country_id = $('#shipping_country :selected').text();
            // var country_id = $("#shipping_country").val();
            var shipping_state = <?=json_encode($shipping_state)?>;
            // alert(shipping_state);
            $.ajax({
                type: "POST",
                url: "<?php echo SITEURL; ?>ajax_state.php",
                data: {country_id:country_id,shipping_state:shipping_state},
                success: function(options)
                {
                    $('#shipping_state').empty().append(options);
                }
            });
        }

        $(document).ready(function(){
          $(".preloader").show();

          getState('233');
        });

        // phone number formate start
            let telEl = document.querySelector('#shipping_phone');
            telEl.addEventListener('keyup', (e) => {
              let val = e.target.value;
              e.target.value = val
                .replace(/\D/g, '')
                .replace(/(\d{1,3})(\d{1,3})?(\d{1,4})?/g, function(txt, f, s, t) {
                  if (t) {
                    return `(${f}) ${s}-${t}`
                  } else if (s) {
                    return `(${f}) ${s}`
                  } else if (f) {
                    return `(${f})`
                  }
                });
            });
      </script>

   </body>
</html>