<?php
include('connect.php');
include('config.php');
include_once "include/notification.class.php";
// require_once "config.php";

// include('AuthorizeNetPayment.php');


if (isset($_SESSION[SESS_PRE . '_SESS_USER_ID'])) {
    $user_id = $_SESSION[SESS_PRE . '_SESS_USER_ID'];
} else {
    $user_id = 0;
}

$cart_det_id     = $_SESSION[SESS_PRE . '_SESS_CART_ID'];
$log_time = date('Y-m-d h:i:sa');
$log_msg = "how to create log file in php?";

cb_logger("************** Start Log For Day : '" . $log_time . "'**********");
cb_logger($cart_det_id);
cb_logger("************** END Log For Day : '" . $log_time . "'**********");

try {
    $cart_row = $db->getData('cart', '*', 'id=' . $cart_det_id . ' AND isDelete = 0');
    $cart_data = mysqli_fetch_assoc($cart_row);

    $qty = $db->getValue('cart_detail', 'SUM(qty)', 'id=' . $cart_det_id . ' AND isDelete = 0');
    $adate    =  date("Y-m-d H:i:s");

    $billing_shipping_tbl_r = $db->getData("billing_shipping", "*", "isDelete=0 AND cart_id=" . $cart_det_id);
    $billing_shipping_tbl_d = mysqli_fetch_assoc($billing_shipping_tbl_r);

    $billTo = [
        'firstName'     => $billing_shipping_tbl_d['billing_first_name'],
        'lastName' => $billing_shipping_tbl_d['billing_last_name'],
        'company'      => "",
        'address'          => $billing_shipping_tbl_d['billing_address'] . " " . $billing_shipping_tbl_d['billing_address2'] ?? "",
        'city'          => $billing_shipping_tbl_d['billing_city'] ?? "",
        'state'         => $db->getValue("states_ex", "name", "id='" . $billing_shipping_tbl_d['billing_state'] . "' ") ?? "",
        'postalCode'       => $billing_shipping_tbl_d['billing_zipcode'] ?? "",
        'country'       => $db->getValue("countries", "iso2", "id='" . $billing_shipping_tbl_d['billing_country'] . "' ") ?? ""
    ];
    $shipTo = [
        'firstName'     => $billing_shipping_tbl_d['shipping_first_name'],
        'lastName' => $billing_shipping_tbl_d['shipping_last_name'],
        'company'      => "",
        'address'          => $billing_shipping_tbl_d['shipping_address'] . " " . $billing_shipping_tbl_d['shipping_address2'] ?? "",
        'city'          => $billing_shipping_tbl_d['shipping_city'] ?? "",
        'state'         => $db->getValue("states_ex", "name", "id='" . $billing_shipping_tbl_d['shipping_state'] . "' ") ?? "",
        'postalCode'       => $billing_shipping_tbl_d['shipping_zipcode'] ?? "",
        'country'       => $db->getValue("countries", "iso2", "id='" . $billing_shipping_tbl_d['shipping_country'] . "' ") ?? ""
    ];
    $shipping_email = $billing_shipping_tbl_d['shipping_email'] ?? $billing_shipping_tbl_d['billing_email'] ?? "";


    // limit address characters
    if (strlen($shipTo['address']) > 50) {
        $shipTo['address'] = substr($shipTo['address'], 0, 40);
    }
    if (strlen($billTo['address']) > 50) {
        $billTo['address'] = substr($billTo['address'], 0, 40);
    }

    cb_logger("good connection");
} catch (\Throwable $th) {
    cb_logger($th);
}

$type = "";
$message = "";
// if (!empty($_POST["pay_now"])) {
// require_once 'AuthorizeNetPayment.php';

try {

    try {
        include('./AuthorizeNetPayment.php');
        // instantiate authorizepayment
        cb_logger('order_number' . $cart_data);
        $authorizeNetPayment = new AuthorizeNetPayment();
        $_POST["amount"] = $cart_data["grand_total"];
        $response = $authorizeNetPayment->chargeCreditCard($_POST, $shipTo, $billTo, $cart_data['order_no']);
        cb_logger('goods authorize payment');
        cb_logger('response' . json_encode($response));
        cb_logger('POST' . json_encode($_POST));
    } catch (\Throwable $th) {
        cb_logger($th);
    }

    if ($response != null) {

        cb_logger('response is not null starting to get transaction response');
        $tresponse = $response->getTransactionResponse();
        if ($tresponse) cb_logger('$tresponse_getResponseCode=' . $tresponse->getResponseCode());

        $response = [];

        if (($tresponse != null) && ($tresponse->getResponseCode() == "1")) {
            $authCode = $tresponse->getAuthCode();
            $paymentResponse = $tresponse->getMessages()[0]->getDescription();
            $transactionId = $tresponse->getTransId();
            $responseCode = $tresponse->getResponseCode();
            $paymentStatus = $authorizeNetPayment->responseText[$tresponse->getResponseCode()];
            $reponseType = "success";
            $message = "This transaction has been approved. <br/> Charge Credit Card AUTH CODE : " . $tresponse->getAuthCode() .  " <br/>Charge Credit Card TRANS ID  : " . $tresponse->getTransId() . "\n";
            // $result = "1";
            cb_logger('success_message' . $paymentResponse);
            cb_logger('_SESS_CART_ID' . $_SESSION[SESS_PRE . '_SESS_CART_ID']);




            $payment_method = "CARD";
            $rows = array('payment_method' => $payment_method, 'order_status' => 2);
            $where    = "id='" . $_SESSION[SESS_PRE . '_SESS_CART_ID'] . "'";
            // update payment method
            $db->update("cart", $rows, $where);
			
			// shipstation sending of order
			$newOrder = new Cart();
            $newOrder->getCartDetailsFull($_SESSION[SESS_PRE . '_SESS_CART_ID']);
            $newOrder->shipPaidCart();
			$newOrder->sendToQB();
            if (ISMAIL) {
                try {
                    cb_logger('sending mail');
                    $order_d = $db->getData("payment_history", "*", "isDelete=0 AND id=" . $history_id);
                    $order_r = mysqli_fetch_assoc($order_d);
                    $user_name = $_SESSION[SESS_PRE . '_SESS_USER_NAME'];
                    $order_number = $order_r['order_number'];
                    $ammount_price = $order_r['price'];
                    $paid_date = $order_r['payment_date'];

                    $nt = new Notification($db);
                    $nt->sendMailWithTemplates($cart_det_id, $shipping_email, 'New Order Confirmed', 'new_confirmation_order_template');
                } catch (\Throwable $th) {
                    cb_logger($th);
                    cb_logger('email having problem');
                }
            }

            // remove cart session ID 
            unset($_SESSION[SESS_PRE . '_SESS_CART_ID']);
            $response = [
                "code" => "1",
                "order_id" => $cart_det_id
            ];
            echo json_encode($response);
        } else {
            cb_logger('$tresponse is null');
            $authCode = "";
            try {
                cb_logger('payment response');
                $paymentResponse = $tresponse->getErrors()[0]->getErrorText();
            } catch (\Throwable $th) {
                cb_logger('error getting payement response');
            }

            $reponseType = "error";
            $message = "Charge Credit Card ERROR :  Invalid response\n";
            //$new_message = $tresponse->getMessages()[0]->getDescription();
            //cb_logger('new_message' . $new_message);
            $response = [
                "code" => "0",
                "message" => $message
            ];
            echo json_encode($response);
            exit;
        }

        //payment_history data
        $rows = array(
            "uid"             => $user_id,
            "cart_det_id"     => $cart_det_id,
            "payment_type"     => 1,
            "price"         => $cart_data['grand_total'],
            "order_number"     => $cart_data['order_no'],
            "payment_status" => 2,
            "payment_date"     => $adate,
            "txn_id"         => $transactionId,
            "err_msg"         => 'success',
            "isDelete"     => 0
        );
        try {
            cb_logger('history');
            $history_id =    $db->insert('payment_history', $rows);
        } catch (\Throwable $th) {
            cb_logger('problem with history');
        }

        try {
            cb_logger('rows cart');
            $rows_cart = array(
                "order_status"    => 2,
                "order_date"        => date('Y-m-d H:i:s')
            );
        } catch (\Throwable $th) {
            cb_logger('rows cart error');
        }

        // echo $db->update("cart", $rows_cart, "customer_id=" . $user_id . " AND id = " . $cart_det_id,0);
        try {
            cb_logger('updating cart...');
            $db->update("cart", $rows_cart, "id = " . $cart_det_id, 0);
        } catch (\Throwable $th) {
            cb_logger("problem with updating cart");
            cb_logger($th);
        }

        $param_value_array = array(
            "transaction_id"     => $transactionId,
            "user_id"             => $user_id,
            "auth_code"         => $authCode,
            "response_code"     => $responseCode,
            "amount"             => $cart_data['grand_total'],
            "payment_status"    => $paymentStatus,
            "payment_response"     => $paymentResponse
        );
        try {
            cb_logger('inserting history');
            $history_id = $db->insert('tbl_authorizenet_payment', $param_value_array, 0);
        } catch (\Throwable $th) {
            cb_logger('problem inserting history');
        }


        // echo "<PRE>";
        // print_r($param_value_array);
        // exit; 
        // echo $history_id;

        unset($_SESSION[SESS_PRE . '_SESS_CART_ID']);
        unset($_SESSION[SESS_PRE . '_SESS_GUEST_ID']);
        die;
    } else {
        cb_logger("response is null");
        $reponseType = "error";
        $message = "Charge Credit Card Null response returned";
        $result = "0";
        echo "0";
        die;
    }
} catch (\Throwable $th) {
    cb_logger('error');
    cb_logger($th);
}

  //   echo json_encode($result);
 	// die();
// }
