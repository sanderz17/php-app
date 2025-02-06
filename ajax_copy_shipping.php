<?php  
    include 'connect.php';
    $use_billing_save = $_REQUEST['use_billing_save'];

    $cart_id = $_SESSION[SESS_PRE.'_SESS_CART_ID'];
    $user_id = $_SESSION[SESS_PRE.'_SESS_USER_ID'];

    $get_shipping_details = $db->getData("billing_shipping","*","isDelete=0 AND user_id=".$user_id." AND cart_id=".$cart_id,"id DESC");
    $get_shipping_details_r = mysqli_fetch_assoc($get_shipping_details);

    // $shipp_arr = array(
    //     // "user_id" => $user_id,
    //     // "cart_id" => $cart_id,
    //     "billing_first_name" => $get_shipping_details_r['shipping_first_name'],
    //     "billing_last_name" => $get_shipping_details_r['shipping_last_name'],
    //     "billing_street_addr" => $get_shipping_details_r['shipping_address'],
    //     "billing_addr2" => $get_shipping_details_r['shipping_address2'],
    //     "billing_country" => $get_shipping_details_r['shipping_country'],
    //     "billing_post" => $get_shipping_details_r['shipping_zipcode'],
    //     "billing_state" => $get_shipping_details_r['shipping_state'],
    //     "billing_city" => $get_shipping_details_r['shipping_city'],
    //     "billing_phone" => $get_shipping_details_r['shipping_phone']
    // );

    // $dupcheck = $db->dupCheck("billing_shipping","isDelete=0 AND user_id=".$user_id." AND cart_id=".$cart_id);
    // if ($dupcheck) 
    // {
    //     $db->update("billing_shipping",$shipp_arr,"isDelete=0 AND user_id=".$user_id." AND cart_id=".$cart_id,0);
    // }

    $json = array(
        "billing_first_name" => $get_shipping_details_r['shipping_first_name'],
        "billing_last_name" => $get_shipping_details_r['shipping_last_name'],
        "billing_street_addr" => $get_shipping_details_r['shipping_address'],
        "billing_addr2" => $get_shipping_details_r['shipping_address2'],
        "billing_country" => $get_shipping_details_r['shipping_country'],
        "billing_post" => $get_shipping_details_r['shipping_zipcode'],
        "billing_state" => $get_shipping_details_r['shipping_state'],
        "billing_city" => $get_shipping_details_r['shipping_city'],
        "billing_phone" => $get_shipping_details_r['shipping_phone'],
    );
    echo json_encode($json);
?>