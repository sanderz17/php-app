<?php
   include "connect.php";
   // $db->checkLogin();
   
   $profile = $db->getData("user","*","id=".$_SESSION[SESS_PRE.'_SESS_USER_ID']);
   $profile_data = mysqli_fetch_assoc($profile);

   // address details start

   $user_id = $_SESSION[SESS_PRE.'_SESS_USER_ID'];
   $cart_id = $_SESSION[SESS_PRE.'_SESS_CART_ID'];
   // $cart_id = $ctable_order_history_r['cart_det_id'];

   if (isset($user_id) && $user_id != "" && $cart_id != 0 && isset($cart_id)) {    
    // if ($cart_id != 0 && isset($cart_id)) {    
        $shipping_d = $db->getData("billing_shipping","*","isDelete=0 AND user_id=".$user_id." AND cart_id=".$cart_id,"id DESC");
        // $shipping_d = $db->getData("billing_shipping","*","isDelete=0 AND cart_id=".$ctable_order_history_r['cart_det_id'],"id DESC",0);
        $shipping_r = mysqli_fetch_assoc($shipping_d);

          // echo "<pre>";
          // print_r($shipping_r);
          // die;

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


   $ctable_order_history_d = $db->getData("payment_history", "*", "isDelete=0 AND id='".$_REQUEST['order_id']."' ");
   $ctable_order_history_r = mysqli_fetch_assoc($ctable_order_history_d);

   if($ctable_order_history_r['payment_status'] == 0) { $order_status = "Cancelled"; }
   if($ctable_order_history_r['payment_status'] == 1) { $order_status = "In Progress"; }
   if($ctable_order_history_r['payment_status'] == 2) { $order_status = "Completed"; }
   if($ctable_order_history_r['payment_status'] == 3) { $order_status = "Shipped"; }
   if($ctable_order_history_r['payment_status'] == 4) { $order_status = "Delivered"; }

   ?>
<!DOCTYPE html>
<html>
   <head>
      <title>Homepage | Profile</title>
      <?php include 'front_include/css.php'; ?>
     
   </head>
   <body>
      <!--  header section start -->
      <header class="inner-page-bg">
         <div class="checkout-header">
            <div class="container-fluid">
                <div class="row align-items-center justify-content-between">
                    <div class="header-logo">
                        <a href="<?php echo SITEURL; ?>"><img src="<?php echo SITEURL; ?>img/main-logo.png"></a>
                    </div>
                </div>
            </div>
         </div>
      </header>
      
      <!-- header section end -->

      <!-- main section start  -->
      
       <div class="container">
           <div class="primary-content mb-4">
             <div class="dashboard-title-status show-for-large mt-4">ORDER STATUS</div>
              <hr>
                  <div class="account-dashboard">
                        <div class="data-table-status">
                           <p>Order Number: <?=$ctable_order_history_r['order_number'];?></p>
                        </div>
                        <br />
                        <div class="data-box-orders-history">
                           <div class="data-table-orders-stuts">
                              <h4>SHIPPING ADDRESS</h4>
                              <p><?php
                                    // $shipping_user_d = $db->getData("billing_shipping","*","isDelete=0 AND user_id=".$user_id." AND cart_id=".$ctable_order_history_r['cart_det_id'],"id DESC");
                                    $shipping_user_d = $db->getData("billing_shipping","*","isDelete=0 AND cart_id=".$ctable_order_history_r['cart_det_id'],"id DESC");
                                    $shipping_user_r = mysqli_fetch_assoc($shipping_user_d);

                                    echo $shipping_user_r['shipping_first_name']; ?> <?php echo $shipping_user_r['shipping_last_name'];
                                 ?><br>
                                 <?=$shipping_user_r['shipping_address'];?><br>
                                 <?=$shipping_user_r['shipping_address2'];?><br>
                                 <?=$shipping_user_r['shipping_city'];?>, 
                                 <?php echo $db->getValue("states_ex","name","id='".$shipping_user_r['shipping_state']."' "); ?>,
                                 <?php echo $db->getValue("countries","name","id='".$shipping_user_r['shipping_country']."' "); ?>, 
                                 <?php echo $shipping_user_r['shipping_zipcode']; ?>
                              </p>
                           </div>
                           <div class="data-table-orders-stuts">
                              <h4>CONTACT INFO</h4>
                              <p><?=$shipping_user_r['shipping_phone'];?>
                              </p>
                              <p><?php echo $db->getValue("user","email","id='".$shipping_user_r['user_id']."' "); ?></p>
                           </div>

                           <div class="data-table-orders-stuts">
                              <h4>ORDER TOTAL:</h4>
                              <p>$<?php echo $ctable_order_history_r['price']; ?></p>
                           </div>
                        </div>
                  </div>
            </div>
       </div>

       <div class="container">
           <div class="primary-content mb-4">
             <div class="dashboard-title-status show-for-large mt-4">ORDER SUMMARY</div>
              <hr>
                  <div class="account-dashboard">
                     <div class="row col-lg-12">
                           <h1 class="stock">STOCK</h1>
                           <label class="stock-btn">1</label>
                     </div>
                     <hr>
                        <div class="row">
                             <div class="col-lg-6">
                                <div class="data-table-status">
                                    <p>CUSTOM DRINKWARE SETUP FEE
                                    <span>50000000000</span></p>
                                 </div>
                              </div>
                              <div class="col-lg-6">
                                 <div class="row">
                                    <div class="offset-lg-4 col-lg-4">
                                    <div class="data-table-status float-right">
                                          <h6>QUANTITY</h6>
                                          <h6>STATUS</h6>
                                       </div>
                                    </div>
                                    <div class="col-lg-4">
                                    <div class="data-table-status float-right">
                                          <p>1 Unit</p>
                                          <p>Shipped</p>
                                       </div>
                                    </div>
                              </div>
                         </div>
                       </div>
                        <br />
                       
                  </div> 
            </div>
       </div>

       <div class="container">
           <div class="primary-content mb-4">
                  <div class="account-dashboard">
                     <div class="row col-lg-12">
                        <h1 class="stock">CUSTOM</h1>
                        <label class="stock-btn"><?php echo $db->getTotalRecord("cart_detail","isDelete=0 AND cart_id='".$ctable_order_history_r['cart_det_id']."'"); ?></label>
                     </div>

                     <?php
                        $ctable_cart_details_r = $db->getData("cart_detail", "*", "isDelete=0 AND cart_id='".$ctable_order_history_r['cart_det_id']."' ");
                        if(@count($ctable_cart_details_r)>0){
                           foreach ($ctable_cart_details_r as $ctable_cart_details_d){
                              ?>
                              <hr>
                              <div class="row">
                                 <div class="col-lg-3">
                                    <div class="data-table-status">
                                       <h6>
                                       <?php 
                                          echo $db->getValue("product","name","isDelete=0 AND id='".$ctable_cart_details_d['product_id']."' ");
                                       ?>
                                       </h6>
                                       <!-- <p> <span>21071300170</span></p> -->
                                    </div>
                                 </div>
                                 <div class="col-lg-3">
                                    <div class="data-table-status">
                                       <h6>FRONT</h6>

                                       <?php 
                                          $product_img_d = $db->getValue("product","image","isDelete=0 AND id='".$ctable_cart_details_d['product_id']."' ");

                                          if($product_img_d != "")
                                          {
                                             $product_img = SITEURL."img/product/".$product_img_d;
                                          }
                                          else
                                          {
                                             $product_img = SITEURL."img/noavailable2.png";
                                          }
                                       ?>
                                       <img class="product product-image zoom" src="<?php echo $product_img; ?>">
                                    </div>
                                 </div>
                                 <div class="col-lg-6">
                                    <div class="row">
                                       <div class="offset-lg-4 col-lg-4">
                                          <div class="data-table-status float-right">
                                             <h6>QUANTITY</h6>
                                             <h6>STATUS</h6>
                                          </div>
                                       </div>
                                       <div class="col-lg-4">
                                          <div class="data-table-status float-right">
                                                <p><?=$ctable_cart_details_d['qty'];?> Unit</p>
                                                <p><?=$order_status;?></p>
                                          </div>
                                       </div>
                                    </div>
                                 </div>
                              </div>
                              <br />
                        <?php
                           }
                        }
                     ?>
                     
                       
                  </div>
            </div>
       </div>

      <!-- main section end  -->

      <?php include 'front_include/footer.php'; ?>
      <?php include 'front_include/js.php'; ?>

      
   </body>
</html>