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

                     $ctable_order_history_r = $db->getData("payment_history", "*", "isDelete=0 AND uid='" . $_SESSION[SESS_PRE . '_SESS_USER_ID'] . "' ", "id DESC");

                     if (@count($ctable_order_history_r) > 0) {

                        foreach ($ctable_order_history_r as $ctable_order_history_d) {
                           $order_date = $ctable_order_history_d['create_at'];
                           // echo date_format($order_date,"m/d/Y");
                           // echo DateTime::createFromFormat('d/m/Y', $order_date)->format('F d, y');

                           if ($ctable_order_history_d['payment_status'] == 0) {
                              $order_status = "Cancelled";
                           }

                           if ($ctable_order_history_d['payment_status'] == 1) {
                              $order_status = "In Progress";
                           }
                           if ($ctable_order_history_d['payment_status'] == 2) {
                              $order_status = "Completed";
                           }
                           if ($ctable_order_history_d['payment_status'] == 3) {
                              $order_status = "Shipped";
                           }
                           if ($ctable_order_history_d['payment_status'] == 4) {
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

                              <div class="data-table-orders-medium">
                                 <h4>ORDER STATUS</h4>
                                 <p><?= $order_status; ?></p>
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