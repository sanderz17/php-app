<?php
include "connect.php";
$db->checkLogin();

$profile = $db->getData("user", "*", "id=" . $_SESSION[SESS_PRE . '_SESS_USER_ID']);
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

   </section>
   <!-- header section end -->
   <!-- profile main section start  -->
   <section class="profile-section-main mt-5">
      <div class="container-fluid">
         <div class="row">
            <?php include 'front_include/account_leftmenu.php'; ?>
            <div class="col-md-8">
               <div class="primary-content">
                  <div class="dashboard-title show-for-large">ORDER HISTORY </div>
                  <hr>
                  <div class="data-table">

                     <?php
                     $where = "cart.isDelete=0 AND cart.customer_id='" . $_SESSION[SESS_PRE . '_SESS_USER_ID'] . "' ";
                     $ctable_order_history_r = $db->getJoinData('cart', 'user as u', 'u.id=' . 'cart' . '.customer_id', 'cart.*, u.first_name,u.last_name', $where, "order_no DESC");
                     //$ctable_order_history_r = $db->getData("cart", "*", "isDelete=0 AND uid='" . $_SESSION[SESS_PRE . '_SESS_USER_ID'] . "' ", "id DESC");
                     $shipStations = new Cart();
                     if (@count($ctable_order_history_r) > 0) {

                        foreach ($ctable_order_history_r as $ctable_order_history_d) {
                           $shipstation_tracking_number = $shipStations->getOrderTrackingFromShipStation($ctable_order_history_d['order_no']) ?: '';
                           $order_date = $ctable_order_history_d['adate'];
                           // echo date_format($order_date,"m/d/Y");
                           // echo DateTime::createFromFormat('d/m/Y', $order_date)->format('F d, y');

                           if ($ctable_order_history_d['order_status'] == 0) {
                              $order_status = "Cancelled";
                           }

                           if ($ctable_order_history_d['order_status'] == 1) {
                              $order_status = "In Progress";
                           }
                           if ($ctable_order_history_d['order_status'] == 2) {
                              $order_status = "Completed";
                           }
                           if ($ctable_order_history_d['order_status'] == 3) {
                              $order_status = "Shipped";
                           }
                           if ($ctable_order_history_d['order_status'] == 4) {
                              $order_status = "Delivered";
                           }

                           if ($ctable_order_history_d['order_status'] == 5) {
                              $order_status = "Awaiting Payment/Purchase Order";
                           }

                     ?>
                           <div class="data-box-orders-history">
                              <div class="data-table-orders-medium">
                                 <h4>Order Date</h4>
                                 <p><?php echo $order_date ?></p>
                              </div>
                              <div class="data-table-orders-medium">
                                 <h4>ORDER NUMBER</h4>
                                 <p><?php echo $ctable_order_history_d['order_no']; ?></p>
                              </div>

                              <div class="data-table-orders-medium">
                                 <h4>ORDER TOTAL</h4>
                                 <p>$<?php echo $ctable_order_history_d['grand_total']; ?></p>
                              </div>

                              <div class="data-table-orders-medium">
                                 <h4>ORDER STATUS</h4>
                                 <p><?= $order_status; ?></p>
                              </div>

                              <div class="data-table-orders-medium">
                                 <h4>TRACKING NUMBER</h4>
                                 <p> <a href="https://www.ups.com/track?HTMLVersion=5.0&Requester=NES&AgreeToTermsAndConditions=yes&loc=en_US&tracknum=<?php echo $shipstation_tracking_number ?>/trackdetails"  target="_blank"><?php echo $shipstation_tracking_number; ?></a> </p>
                              </div>
                           </div>
                     <?php
                        }
                     }

                     ?>

                  </div>
               </div>
            </div>
         </div>
      </div>
   </section>
   <!-- profile main section end  -->
   <?php include 'front_include/footer.php'; ?>
   <?php include 'front_include/js.php'; ?>
</body>

</html>