<?php
   include "connect.php";
   $db->checkLogin();
   
   $profile = $db->getData("user","*","id=".$_SESSION[SESS_PRE.'_SESS_USER_ID']);
   $profile_data = mysqli_fetch_assoc($profile);

   // address details start

   $user_id = $_SESSION[SESS_PRE.'_SESS_USER_ID'];
   $cart_id = $_SESSION[SESS_PRE.'_SESS_CART_ID'];

   // if (isset($user_id) && $user_id != "" && $cart_id != 0 && isset($cart_id)) { 
   if (isset($user_id) && $user_id != "") {    
        // $shipping_d = $db->getData("billing_shipping","*","isDelete=0 AND user_id=".$user_id." AND cart_id=".$cart_id,"id DESC");
      $shipping_d = $db->getData("billing_shipping","*","isDelete=0 AND user_id=".$user_id." ","id DESC");
        $shipping_r = mysqli_fetch_assoc($shipping_d);

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

   // address details end
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
      <section class="profile-section-main mt-3">
         <div class="container-fluid">
            <div class="row">
               <?php include 'front_include/account_leftmenu.php'; ?>
               <div class="col-md-8">
                  <div class="primary-content">
                     <div class="account-title">HI, <?php echo $_SESSION[SESS_PRE.'_SESS_USER_NAME']; ?></div>
                     <div class="account-description">Welcome to your Profile Dashboard, where you can check out your recent account activity and update your account information. Select a link below to view or edit information.</div>
                     <div class="dashboard-title show-for-large">ACCOUNT Overview</div>

                     <div class="account-dashboard">
                        <div class="data-header">
                          <!--  <div class="data-title">ORDER HISTORY</div> -->
                           <h4>ORDER HISTORY</h4>
                           <div class="data-action">
                              <a href="<?php echo SITEURL; ?>order-history">VIEW ALL</a>
                           </div>
                        </div>
                        <div class="data-table">

                           <?php

                              $ctable_order_history_r = $db->getData("payment_history", "*", "isDelete=0 AND uid='".$_SESSION[SESS_PRE.'_SESS_USER_ID']."' ","id DESC");

                              if(@count($ctable_order_history_r)>0){

                                 foreach ($ctable_order_history_r as $ctable_order_history_d) {
                                    $order_date = $ctable_order_history_d['create_at'];
                                    // echo date_format($order_date,"m/d/Y");
                                    // echo DateTime::createFromFormat('d/m/Y', $order_date)->format('F d, y');

                                    if($ctable_order_history_d['payment_status'] == 0)
                                    {
                                       $order_status = "Cancelled";
                                    }
                                    if($ctable_order_history_d['payment_status'] == 1) {
                                       $order_status = "In Progress";
                                    }
                                    if($ctable_order_history_d['payment_status'] == 2) {
                                       $order_status = "Awaiting Shipment";
                                    }
                                    if($ctable_order_history_d['payment_status'] == 3) {
                                       $order_status = "Shipped";
                                    }
                                    if($ctable_order_history_d['payment_status'] == 4) {
                                       $order_status = "Delivered";
                                    }

                                    ?>
                                    <div class="data-box-orders-history">
                                       <div class="data-table-orders-medium">
                                          <h4>Order Date</h4>
                                          <p><?php echo $ctable_order_history_d['create_at']; ?></p>
                                       </div>
                                       <div class="data-table-orders-medium">
                                          <h4>ORDER NUMBER</h4>
                                          <p><?php echo $ctable_order_history_d['order_number']; ?></p>
                                       </div>

                                       <div class="data-table-orders-medium">
                                          <h4>ORDER TOTAL</h4>
                                          <p>$<?php echo $ctable_order_history_d['price']; ?></p>
                                       </div>

                                       <!-- <div class="data-table-orders-medium">
                                          <h4>SHIPPING STATUS</h4>
                                          <p>Shipped</p>
                                       </div> -->

                                       <div class="data-table-orders-medium">
                                          <h4>ORDER STATUS</h4>
                                          <p><?=$order_status;?></p>
                                       </div>
                                    </div>
                                    <?php
                                 }
                              }

                           ?>

                           <!-- <div class="data-box-orders-history">
                              <div class="data-table-orders-medium">
                                   <h4>Order Date</h4>
                                   <p>11/16/2020</p>
                              </div>
                              <div class="data-table-orders-medium">
                                   <h4>ORDER NUMBER</h4>
                                   <p>205780507</p>
                              </div>

                              <div class="data-table-orders-medium">
                                   <h4>ORDER TOTAL</h4>
                                   <p>$285.52</p>
                              </div>

                              <div class="data-table-orders-medium">
                                   <h4>SHIPPING STATUS</h4>
                                   <p>Shipped</p>
                              </div>

                              <div class="data-table-orders-medium">
                                   <h4>ORDER STATUS</h4>
                                   <p>Completed</p>
                              </div>
                           </div> -->
                         
                        </div>
                     </div>

                     <div class="account-dashboard">
                        <div class="data-header">
                           <div class="data-title">ITEMS LEFT ON YOU CART</div>
                        </div>
                        <div class="data-table">
                           <div class="compatible-slider">

                              <?php

                              $cart_id = 0;

                              if (isset($_SESSION[SESS_PRE . '_SESS_CART_ID']) && $_SESSION[SESS_PRE . '_SESS_CART_ID'] > 0) {
                                 $cart_id = $_SESSION[SESS_PRE . '_SESS_CART_ID'];
                              }


                              $where = "cd.isDelete=0 AND p.isDelete=0 AND cd.cart_id=" . $cart_id;
                              $join = " LEFT JOIN product p ON p.id = cd.product_id";
                              $rows = "cd.price, cd.sub_total, cd.qty, cd.id, p.name, p.image, p.id as pro_id";
                              $cart_data = $db->getJoinData2("cart_detail cd", $join, $rows, $where);
                  
                              if (mysqli_num_rows($cart_data)>0) {
                                 while ($product_cart_data = mysqli_fetch_assoc($cart_data)) {
                                    ?>
                                       <div class="slick-slide">
                                          <a href="javascript:void(0);"><img src="<?php echo SITEURL; ?>img/product/<?php echo $product_cart_data['image']; ?>"></a>
                                          <h3><?php echo $product_cart_data['name']; ?></h3>
                                          <div class="product-pricing text-center">
                                             <span class="product-sales-price" title="product-sales-pricee">$<?php echo $product_cart_data['price']; ?> </span>
                                          </div>
                                       </div>
                                    <?php
                                 }
                              }
                              ?>
                     
                           </div>
                        </div>
                        <a class="btn w-100 view-cart" href="<?php echo SITEURL ?>cart/">View Cart</a>
                     </div>

                     <div class="account-dashboard">
                        <div class="data-header">
                           <div class="data-title">PICKED JUST FOR YOU</div>
                        </div>
                        <div class="data-table">
                        <div class="compatible-slider">

                           <?php
                           $join = 'SELECT DISTINCT(product_accessories.related_pid),product.name,product.price,product.image FROM `product_accessories` LEFT JOIN product ON product.id = product_accessories.related_pid AND product.isDelete=0';
                           // echo $join;
                           // exit();
                           $product = mysqli_query($GLOBALS['myconn'],$join);
                           if (mysqli_num_rows($product)>0) {
                              while ($product_data = mysqli_fetch_assoc($product)) {
                                 ?>
                                    <div class="slick-slide">
                                       <a href="javascript:void(0);"><img src="<?php echo SITEURL; ?>img/product/<?php echo $product_data['image']; ?>"></a>
                                       <h3><?php echo $product_data['name']; ?></h3>

                                       <div class="product-pricing text-center">
                                          <span class="product-sales-price" title="product-sales-pricee">$<?php echo $product_data['price']; ?> </span>
                                       </div>
                                       <div class="product-actions">
                                          <a class="btn add-to-cart-btn" href="javascript:void(0);" onclick="add_to_cart_accessories(<?php echo $product_data['related_pid']; ?>,<?php echo $product_data['price']; ?>);">Add To Cart</a>
                                       </div>
                                    </div>
                                 <?php
                              }
                           }
                           ?>
					   
					        </div>
                         
                        </div>
                     </div>

                     <div class="row">
                         <!-- <div class="col-lg-6"> -->
                        <div class="col-lg-12">
                           <div class="account-dashboard">
                              <div class="data-header">
                                 <div class="data-title">Profile</div>
                                 <div class="data-action">
                                    <a href="<?php echo SITEURL; ?>profile-update/">Edit</a>
                                 </div>
                              </div>
                              <div class="data-table">
                                 <div class="data-table-row_profile">
                                    <div class="row-title">FIRST NAME</div>
                                    <div class="profile-details-name"><?php echo $profile_data['first_name']; ?></div>
                                 </div>
                                 <div class="data-table-row_profile">
                                    <div class="row-title">LAST NAME</div>
                                    <div class="profile-details-name"><?php echo $profile_data['last_name']; ?></div>
                                 </div>
                                 <div class="data-table-row_profile">
                                    <div class="row-title">EMAIL</div>
                                    <div class="profile-details-name"><?php echo $profile_data['email']; ?></div>
                                 </div>
                                 <div class="data-table-row_profile">
                                    <div class="row-title">Phone</div>
                                    <!-- <div class="profile-details-name"><?php echo $profile_data['phone']; ?></div> -->
                                    <div class="profile-details-name"><?php echo $shipping_phone; ?></div>
                                 </div>
                              </div>
                           </div>
                        </div>

                        <!-- <div class="col-lg-6">
                           <div class="account-dashboard">
                                 <div class="data-header">
                                    <div class="data-title">SAVED CREDIT CARDS (0)</div>
                                    <div class="data-action">
                                       <a href="#">VIEW ALL</a>
                                    </div>
                                 </div>
                                 <div class="data-table">
                                     <div class="no-saved-box">
                                          NO SAVED CC
                                      </div> 
                                 </div>
                            </div>
                        </div> -->
                     </div>

                     <div class="account-dashboard">
                        <div class="data-header">
                           <div class="data-title">ADDRESS </div>
                           <div class="data-action">
                              <a href="<?php echo SITEURL; ?>address-update">MANAGE ADDRESS</a>
                           </div>
                        </div>
                        <div class="data-table">
                           <!-- <div class="data-table-row_profile saved-address-title">DEFAULT ADDRESS - Kensington Palace</div> -->
                           <div class="mini-address-location">
                              <address>
                                 <b><?=$shipping_first_name;?> - <?=$shipping_last_name;?></b>
                                 <br>
                                 <?=$shipping_address;?>
                                 <br>
                                 <?=$shipping_address2;?>
                                 <br>
                                 <?=$shipping_city;?>, <?php echo $db->getValue("states_ex","name","id='".$shipping_state."' "); ?>
                                 <br>
                                 <span class="miniaddress-country-name">
                                 <?php echo $db->getValue("countries","name","id='".$shipping_country."' "); ?> <?php echo $shipping_zipcode; ?>
                                 </span>
                              </address>
                           </div>
                        </div>
                     </div>

                     <!-- <div class="account-dashboard">
                        <div class="data-header">
                           <div class="data-title">MY REGISTERED PRODUCTS </div>
                           <div class="data-action">
                              <a href="javascript:void(0)">Edit</a>
                           </div>
                        </div>
                        <div class="data-table">
                            <div class="no-saved-box">
                                YOU HAVE NO REGISTERED PRODUCTS
                                <span><a href="#">REGISTER MY CB</a></span>
                             </div> 
                        </div>
                     </div> -->

                  </div>
               </div>
            </div>
         </div>
      </section>
      <!-- profile main section end  -->
      <?php include 'front_include/footer.php'; ?>
      <?php include 'front_include/js.php'; ?>

      <script type="text/javascript">
         function add_to_cart_accessories(id,price)
         {
         // alert(id);
            var qty = 1
            // var price = $('#price').val();
         
            $.ajax({
               url: '<?php echo SITEURL; ?>product_db.php', 
               method: 'post', 
               data: 'mode=add_to_cart&product_id='+id+'&qty='+qty+'&price='+price, 
                    beforeSend: function(){
                        $(".loader").show(); 
                    },
               success: function(res) {
                        $(".loader").hide();
                  window.location = '<?php echo SITEURL; ?>cart/';
               }
            });
         }
      </script>
   </body>
</html>