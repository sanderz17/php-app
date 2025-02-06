<?php
include('connect.php');
//include('config.php');
include("include/notification.class.php");
$response = [];
try {
    // check if user id exists
    $user_id = 0;
    if (!empty($_SESSION[SESS_PRE . '_SESS_USER_ID']) && $_SESSION[SESS_PRE . '_SESS_USER_ID'])
        $user_id = $_SESSION[SESS_PRE . '_SESS_USER_ID'];

    $cart_id = $_SESSION[SESS_PRE . '_SESS_CART_ID'];
    $payment_method = "PURCHASE ORDER";
    if ((isset($_POST['purchase_number']))) {
        $rows = array('payment_method' => $payment_method, 'order_status' => 5);
        $where    = "id='" .  $cart_id . "'";
        // update payment method
        $db->update("cart", $rows, $where);
        $db->getCartDetailsFull($cart_id);

         if (ISMAIL) {
            try {
                $shipping_email_where_query = "cart_id =$cart_id";
                $shipping_email_where_query .= !empty($user_id) ? " AND user_id=$user_id" : "";
                $shipping_email = $db->getValue('billing_shipping', 'shipping_email', $shipping_email_where_query);
                $nt = new Notification($db);
                $nt->sendMailWithTemplates($cart_id, $shipping_email, 'New Order Confirmed', 'new_confirmation_order_template');
            } catch (\Throwable $th) {
                cb_logger($th);
                cb_logger('email having problem');
                throw new Error('Failed');
            }
        } 
        $db->purchaseOrderCart($_POST['purchase_number']);
		//$db->sendToQB();

        // remove cart session ID 
        unset($_SESSION[SESS_PRE . '_SESS_CART_ID']);
        $response = [
            "ok" => true,
            "message" => "success",
            "order_id" => $cart_id
        ];
    } else {
        $response = [
            "ok" => false,
            "message" => "Something wrong happened"
        ];
    }
} catch (\Throwable $th) {
    $response = [
        "ok" => false,
        "message" => "$th"
    ];
} finally {
    echo json_encode($response);
}
