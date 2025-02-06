 <?php
    include "connect.php";
    //echo var_dump($_REQUEST['json']);

    $json = $_REQUEST['json'];
    $cart_id = 0;

    if (isset($_SESSION[SESS_PRE . '_SESS_CART_ID']) && $_SESSION[SESS_PRE . '_SESS_CART_ID'] > 0) {
        $cart_id = $_SESSION[SESS_PRE . '_SESS_CART_ID'];
    }


    $where = "cd.isDelete=0 AND p.isDelete=0 AND cd.cart_id=" . $cart_id;
    $join = " LEFT JOIN product p ON p.id = cd.product_id";
    $rows = "cd.price, cd.sub_total, cd.qty, cd.id, p.name, p.image, p.id as pro_id";
    $cart_data = $db->getJoinData2("cart_detail cd", $join, $rows, $where);

    ?>

 <?php
    if (@mysqli_num_rows($cart_data) > 0) {
        $json_data = [];
        $json_data['cart_id'] = $cart_id;
    ?>
     <?php

        while ($cart_row = mysqli_fetch_assoc($cart_data)) {
            $json_data['data'][] = $cart_row;
            if ($json == 'true') {
                continue;
            }
        ?>
         <!-- <div class="mini-cart-content-wrap p-0"> -->

         <div class="mini-cart-inner-container">
             <div class="summary-item-image">
                 <?php
                    $src = SITEURL . PRODUCT . $cart_row['image'];
                    if (!file_exists($src) && $cart_row['image'] == "") {
                    ?>
                     <img src="<?php echo SITEURL; ?>img/home/this-is-cb-mega-menu.png">
                 <?php } else { ?>
                     <img src="<?php echo SITEURL; ?>img/product/<?php echo $cart_row['image']; ?>">
                 <?php } ?>
             </div>
             <div class="summary-item-details">
                 <div class="summary-item-name">
                     <h4><?php echo $cart_row['name']; ?></h4>
                 </div>
                 <div class="form-group--number count">
                     <button class="up header-up" id="up_header">+</button>
                     <button class="down header-down" id="done_header">-</button>
                     <input class="form-control" type="text" placeholder="1" value="<?php echo $cart_row['qty']; ?>" onchange="qty_update(this.value,'<?php echo $cart_row['id']; ?>','<?php echo $cart_row['pro_id']; ?>')">
                 </div>
                 <div class="summary-item-right">
                     <div class="mini-cart-price"><?php echo CURR . $cart_row['sub_total']; ?></div>
                     <a class="summary-remove" href="#" onclick="remove_cart(<?php echo $cart_row['id']; ?>);">Remove</a>
                 </div>
             </div>
         </div>
     <?php
        }
        if ($json == 'true') {
            echo json_encode($json_data);
            return;
        }
        ?>
     <div class="mini-cart-buttons">
         <div class="mini-cart-subtotals">
             <p class="label">Subtotal</p>
             <p class="value"><?php echo $db->getValue("cart", "sub_total", "id=" . $cart_id); ?></p>
         </div>
         <a class="view_btn" href="<?php echo SITEURL ?>cart/">View Cart</a>
         <a class="btn w-100 shop-cart" href="<?php echo SITEURL ?>checkout/">Check out</a>
     </div>
     <!-- </div> -->
 <?php
    } else {
        if ($json == 'true') {
            echo 'cart is empty';
        }
    ?>
     <!-- <div class="mini-cart-content-wrap"> -->
     <div class="mini-cart-content-wrap-box">
         <h1>YOUR CART IS EMPTY LIKE THIS CLEAR BALLISTICS BOX
         </h1>
         <img src="<?php echo SITEURL; ?>img/empty_cart.png">
         <a class="btn w-100 shop-cart" href="<?php echo SITEURL ?>">Continue Shopping</a>
     </div>
     <!-- </div> -->
 <?php
    }
    ?>


 <script type="text/javascript">
     $(document).ready(function() {
         // $('#done_header').click(function () {
         $('.header-down').click(function() {
             // alert("Down");
             var $input = $(this).parent().find('input');
             var count = parseInt($input.val()) - 1;
             count = count < 1 ? 1 : count;
             $input.val(count);
             $input.change();
             return false;
         });
         // $('#up_header').click(function () {
         $('.header-up').click(function() {
             // alert("Up");
             var $input = $(this).parent().find('input');
             $input.val(parseInt($input.val()) + 1);
             $input.change();
             return false;
         });
     });
 </script>