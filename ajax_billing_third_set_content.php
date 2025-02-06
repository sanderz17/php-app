<?php  
    include 'connect.php';
    $use_billing_save = $_REQUEST['use_billing_save'];

    $cart_id = $_SESSION[SESS_PRE.'_SESS_CART_ID'];
    $user_id = $_SESSION[SESS_PRE.'_SESS_USER_ID'];

    $get_shipping_details = $db->getData("billing_shipping","*","isDelete=0 AND cart_id=".$cart_id,"id DESC");
    $get_shipping_details_r = mysqli_fetch_assoc($get_shipping_details);
?>

<div class="faq-content-main"> 
    <h3>Shipping address</h3>
    <div class="row billing-tag-details">
        <div class="col-md-4">
            <h4>SHIPPING ADDRESS</h4>
            <p><?php echo $get_shipping_details_r['shipping_address'] ?></p>
            <p><?php echo $get_shipping_details_r['shipping_address2'] ?></p>
            <p><?php echo $get_shipping_details_r['shipping_city'] ?></p>
            <!-- <p><?php echo $get_shipping_details_r['shipping_state'] ?>,<?php echo $get_shipping_details_r['shipping_zipcode'] ?></p>
            <p><?php echo $get_shipping_details_r['shipping_country'] ?></p> -->
            <p><?php echo $db->getValue("states_ex","name"," id='".$get_shipping_details_r['shipping_state']."' "); ?>,<?php echo $get_shipping_details_r['shipping_zipcode'] ?></p>
                <p><?php echo $db->getValue("countries","name"," id='".$get_shipping_details_r['shipping_country']."' ");  ?></p>
        </div>
        <div class="col-md-4">
            <h4>CONTACT INFO</h4>
            <p><?php echo $get_shipping_details_r['shipping_phone'] ?></p>
            <p><?php echo $db->getValue("user","email","id='".$get_shipping_details_r['user_id']."' "); ?></p>
        </div>
        <div class="col-md-4">
            <h4>SHIPPING METHOD</h4>
            <p id="dis_shipping_method"><?php echo $db->getValue("cart","shipping_method","id='".$cart_id."' "); ?></p>
            <!-- <p>UPS SurePost</p> -->
        </div>
    </div>
</div>
<hr>
<div class="faq-content-main" id="billing_detail_section_step2">
    <h3>BILLING</h3>
    <div class="row billing-tag-details">
        <div class="col-md-4">
            <h4>SHIPPING ADDRESS</h4>
            <p><?php echo $get_shipping_details_r['billing_address'] ?></p>
            <p><?php echo $get_shipping_details_r['billing_address2'] ?></p>
            <p><?php echo $get_shipping_details_r['billing_city'] ?></p>
            <!-- <p><?php echo $get_shipping_details_r['billing_state'] ?></p>
            <p><?php echo $get_shipping_details_r['billing_country'].",".$get_shipping_details_r['billing_zipcode']; ?></p> -->
            <p><?php echo $db->getValue("states_ex","name"," id='".$get_shipping_details_r['billing_state']."' "); ?>,<?php echo $get_shipping_details_r['billing_zipcode'] ?></p>
            <p><?php echo $db->getValue("countries","name"," id='".$get_shipping_details_r['billing_country']."' ");  ?></p>
        </div>
    </div>
</div>