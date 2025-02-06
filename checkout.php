<?php
include "connect.php";
//$_REQUEST['user'] = $_REQUEST['slug'] ?? ltrim($_SERVER['PATH_INFO'], $_SERVER['PATH_INFO'][0]);
@$user = $_REQUEST['user'];
//$user = "guest";
if (empty($user) && $user == "" && $user != "guest") {
    $db->CheckoutLogin();
}

$cart_id = $_SESSION[SESS_PRE . '_SESS_CART_ID'];
$user_id = $_SESSION[SESS_PRE . '_SESS_USER_ID'];
//echo $cart_id;
// die();

$get_shipping_details = $db->getData("billing_shipping", "*", "isDelete=0 AND cart_id=" . $cart_id);
$get_shipping_details_r = mysqli_fetch_assoc($get_shipping_details);
?>
<!DOCTYPE html>
<html>

<head>
    <title>Homepage | Clear Ballistics</title>
    <?php include 'front_include/css.php'; ?>
    <div class="preloader">
        <img class="rotate" src="<?php echo SITEURL; ?>img/home/CLEAR_new_logo_color_lg.png" alt="">
    </div>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.8/css/intlTelInput.css" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.8/js/intlTelInput.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.4/moment.min.js"></script>
    <style>
        .view-order-summary-mobile-title {
            padding: .975rem;
        }

        .card-header {
            padding: .75rem 0;
            margin-bottom: 0;
            background-color: #fff;
            border-bottom: 0 solid rgba(0, 0, 0, .125);
        }

        .card {
            border-radius: 6px;
            border: 0 solid rgba(0, 0, 0, .125) !important;
        }

        .shipping_method_border,
        .payment_method_box {
            background: #f1f1f1;
            border: 1px solid #ddd;
            border-radius: 4px;
            cursor: pointer;
        }

        .cursor_pointer {
            cursor: pointer;
        }

        .checked_payment {
            border: 2px solid #022c44;
        }

        .checked_payment .custom-radio .custom-control-label::before {
            border: 4px solid #007bff;
        }

        .step_number {
            background: #002b45;
            color: #fff;
            border-radius: 50%;
            text-align: center;
            line-height: 2rem;
            font-size: 1.125rem;
            font-family: "Proxima Nova ExCn Rg";
            font-weight: 900;
            width: 1.9375rem;
            height: 1.9375rem;
            margin-right: .625rem;
        }

        .bg_yeti {
            background: #002b45;
        }

        .from-group.input-group-lg>label {
            font-weight: 800;
            letter-spacing: .7px;
        }

        .bg-grey-yt {
            background: #d5d6d5;
        }

        .main-font {
            font-family: LTCSquareFaceW00-SC !important;
        }

        .font-proxima {
            font-family: "Proxima Nova ExCn Rg" !important;
        }

        .accordion .card-header:after {
            font-family: 'FontAwesome';
            content: "\f068";
            float: right;
            margin: -20px 0 0;
        }

        .accordion .card-header.collapsed:after {
            /* symbol for "collapsed" panels */
            content: "\f067";
            margin: -20px 0 0;
        }

        .media-body>a:hover {
            text-decoration: underline;
        }

        .step1_edit_text {
            cursor: pointer;
        }

        .step1_edit_text:hover {
            text-decoration: underline;
        }

        .bg_yeti {
            background: #002b45;
        }

        .btn_yeti:hover {
            background: #002b45;
            color: white;
        }
    </style>
</head>

<body>

    <input type="hidden" name="SITEURL" id="SITEURL" value="<?php echo SITEURL; ?>">
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
    <?php //include 'front_include/header.php'; 
    ?>
    <?php if ($cart_id) { ?>
        <!-- Checkout Page-section start-->
        <section class="checkout-section">
            <!--  <div class="container"> -->


            <div class="container-fluid">

                <div class="row">
                    <div class="col-12 col-md-8 order-1 order-md-0 mb-4 mb-md-6">

                        <!-- STEP 1 -->
                        <div class="row mb-3">
                            <div class="col-12">
                                <div class="card p-3">
                                    <div class="card-header p-0 pb-3 pb-md-4">
                                        <div class="row mx-0">
                                            <div class="col-12 px-0 my-3">
                                                <h2>CHECKOUT</h2>
                                            </div>
                                            <div class="col-6 px-0">
                                                <span class="step_number d-inline-block" id="step1logo">1</span>
                                                <div class="pt-1 d-inline-block">
                                                    <h3>EMAIL</h3>
                                                </div>
                                            </div>
                                            <div class="col-6 px-0 text-right" style="font-size: 1.5rem;">
                                                <span id="step1_text">Step 1 of 3</span>
                                                <span class="d-none step1_edit_text" id="step1_edit_text" onclick="step1_edit();">EDIT</span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="card-body p-0">

                                        <!--  CHECKOUT AS GUEST START -->
                                        <div class="row" id="guest_input_form">
                                            <div class="col-12 col-md-12 col-lg-9">
                                                <div class="form-group mb-3 mb-md-3">
                                                    <div class="input-group input-group-lg">
                                                        <input type="email" class="input-lg form-control mh-100 shadow-none" placeholder="Enter your email" id="shipping_email" name="shipping_email" data-bind="shipping_email">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-12 col-md-12 col-lg-3">
                                                <button class="btn btn-lg w-100 text-center bg_yeti text-white font-stratum-web-black" href="<?php echo SITEURL; ?>checkout/" style="font-size: 1rem;letter-spacing: 1px;<?= $checkout_btn; ?>" onclick="input_email_as_guest()"> NEXT</button>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-12">
                                                <span id="guest_email" style="font-size: 1.5rem;"></span>
                                            </div>
                                        </div>
                                        <!--  CHECKOUT AS GUEST END -->

                                        <!--  LOGIN START -->
                                        <div class="row" hidden>
                                            <div class="col-sm-12">
                                                <div class="form-group">
                                                    <label class="form-control-label font-weight-bold">
                                                        Email Address
                                                    </label>
                                                    <input type="text" class="form-control email" id="email" placeholder="ballistics@clearballistics.com" value="" name="dwfrm_coRegisteredCustomer_email" required="" aria-required="true" maxlength="50" pattern="^(([^\u003E\u003C\(\)\[\]\\.,;:\s@\u0022]+(\.[^\u003E\u003C\(\)\[\]\\.,;:\s@\u0022]+)*)|(\u0022.+\u0022))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$" aria-describedby="emailInvalidMessage">
                                                    <div class="invalid-feedback" id="emailInvalidMessage"></div>
                                                </div>
                                                <div class="form-group password-form">
                                                    <label class="form-control-label font-weight-bold">
                                                        Password
                                                    </label>
                                                    <input type="password" class="form-control password" id="password" name="dwfrm_coRegisteredCustomer_password" required="" aria-required="true" value="" maxlength="255" minlength="8" aria-describedby="passwordInvalidMessage">
                                                    <div class="invalid-feedback" id="passwordInvalidMessage"></div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="clearfix pb-4 pb-6" hidden>
                                            <div class="form-group custom-control custom-checkbox pull-left remember-me mb-0">
                                                <input type="checkbox" class="custom-control-input" id="rememberMe" name="loginRememberMe" value="true">
                                                <label class="custom-control-label" for="rememberMe">
                                                    Remember Me
                                                </label>
                                            </div>
                                            <div class="pull-right forgot-password text-right">
                                                <a id="password-reset" class="hidden-xs-down password-reset link2" title="Forgot Password?" data-toggle="modal" href="" data-target="#requestPasswordResetModal">
                                                    Forgot Password?
                                                </a>
                                            </div>
                                        </div>
                                        <!-- LOGIN END -->

                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- STEP 1 END -->

                        <!-- STEP 2 START-->
                        <div class="row" id="shipping_greyed">
                            <div class="col-12 col-md-12 order-1 order-md-0 mb-3 mb-md-6">
                                <div class="card p-3 bg-grey-yt">
                                    <div class="row mx-0">
                                        <div class="col-8 px-0">
                                            <span class="step_number d-inline-block">2</span>
                                            <h2 class="step__title d-inline-block">SHIPPING</h2>
                                        </div>
                                        <div class="col-4 px-0 text-right" style="font-size: 1.5rem;">
                                            <span class="d-inline-block"></span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row" id="shipping_details" style="display:none;">
                            <div class="col-12 col-md-12 order-1 order-md-0 mb-3 mb-md-6">
                                <div class="card p-3">
                                    <div class="card-header p-0 pb-3 pb-md-4">
                                        <div class="row mx-0">
                                            <div class="col-8 px-0">
                                                <span class="step_number d-inline-block" id="step2logo">2</span>
                                                <h2 class="step__title d-inline-block">SHIPPING</h2>
                                            </div>
                                            <div class="col-4 px-0 text-right" style="font-size: 1.5rem;">
                                                <span class="inline-block" id="step2_text">Step 2 of 3</span>
                                                <span class="d-none step1_edit_text" id="step2_edit_text" onclick="step2_edit();">EDIT</span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="card-body p-0">
                                        <form action="" id="shipping_form_step">
                                            <div class="row" id="shipping_input_form">
                                                <div class="col-md-6">
                                                    <div class="from-group input-group-lg">
                                                        <label for="shipping_first_name">FIRST NAME</label>
                                                        <input type="text" name="shipping_first_name" id="shipping_first_name" class="form-control" value="<?php echo $shipping_first_name; ?>" data-bind="shipping_first_name">
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="from-group input-group-lg">
                                                        <label for="shipping_last_name">LAST NAME</label>
                                                        <input type="text" name="shipping_last_name" id="shipping_last_name" class="form-control" value="<?php echo $shipping_last_name; ?>" data-bind="shipping_last_name">
                                                    </div>
                                                </div>
                                                <div class="col-md-12">
                                                    <div class="from-group input-group-lg">
                                                        <label for="shipping_street_addr">ADDRESS 1</label>
                                                        <input type="text" name="shipping_street_addr" id="shipping_street_addr" class="form-control" value="<?php echo $shipping_address; ?>" data-bind="shipping_street_addr">
                                                    </div>
                                                </div>
                                                <div class="col-md-12">
                                                    <div class="from-group input-group-lg">
                                                        <label for="shipping_addr2">ADDRESS 2</label>
                                                        <input type="text" name="shipping_addr2" id="shipping_addr2" class="form-control" value="<?php echo $shipping_address2; ?>" data-bind="shipping_addr2">
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="from-group input-group-lg">
                                                        <label for="shipping_country">COUNTRY</label>
                                                        <select class="form-control" required="" aria-required="true" onchange="getState(this.value);" name="shipping_country" id="shipping_country" data-bind-selector="shipping_country">
                                                            <option value="">Country / Region</option>
                                                            <option value="233">United States</option>
                                                            <?php
                                                            $country_d = $db->getData("countries", "*", "id !='233'");
                                                            foreach ($country_d as $key => $country_r) {
                                                            ?>
                                                                <option <?php echo ($country_r['id'] == 233) ? "selected" : ""; ?> value="<?php echo $country_r['id'] ?>" <?php if ($country_r['id'] == $shipping_country) {
                                                                                                                                                                                echo "Selected";
                                                                                                                                                                            } ?>><?php echo $country_r['name']; ?></option>
                                                            <?php
                                                            }
                                                            ?>
                                                        </select>

                                                    </div>
                                                </div>

                                                <div class="col-md-6">
                                                    <div class="from-group input-group-lg">
                                                        <!-- <input type="text" name="shipping_state" id="shipping_state" placeholder="State" class="form-control"> -->
                                                        <label for="shipping_state">STATE</label>
                                                        <select name="shipping_state" id="shipping_state" class="form-control" onchange="getShippingCharges()" data-bind-selector="shipping_state">
                                                            <option value="">State</option>
                                                        </select>

                                                    </div>
                                                </div>

                                                <div class="col-md-6">
                                                    <div class="from-group input-group-lg">
                                                        <label for="shipping_state">POSTCODE</label>
                                                        <input type="text" name="shipping_post" id="shipping_post" placeholder="Postcode" class="form-control" value="<?php echo $shipping_zipcode; ?>" onchange=getShippingCharges() data-bind="shipping_post">
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="from-group input-group-lg">
                                                        <label for="shipping_state">CITY</label>
                                                        <input type="text" name="shipping_city" id="shipping_city" placeholder="City" class="form-control" value="" onchange="cityname()" data-bind="shipping_city">
                                                    </div>
                                                </div>


                                                <div class="col-md-12">
                                                    <div class="from-group input-group-lg">
                                                        <label for="shipping_phone">PHONE NUMBER</label>
                                                        <input type="text" name="shipping_phone" id="shipping_phone" class="form-control" value="<?php echo $shipping_phone; ?>" maxlength="30" placeholder="(201) 555-0123" data-bind="shipping_phone">

                                                        <!-- <input type="text" name="shipping_phone" id="shipping_phone" placeholder="Phone" class="form-control" value="<?php echo $shipping_phone; ?>" maxlength="14" onkeydown="javascript:backspacerDOWN(this,event);" onkeyup="javascript:backspacerUP(this,event);"> -->

                                                    </div>
                                                </div>

                                                <div class="col-12 col-lg-6">
                                                    <h5 class="mb-3">SHIPPING METHOD</h5>
                                                    <div class="col-md-12 p-0">
                                                        <div class="from-group input-group-lg">
                                                            <select class="form-control" name="shipping_method" id="shipping_method" onchange="rpAddShippingCharge(this.value);" style="background: #f1f1f1" data-bind-selector="shipping_method">
                                                                <option value="">Please Select Shipping Method</option>

                                                            </select>
                                                        </div>
                                                    </div>
                                                    <!--                                         <div class="row mx-0 p3 border-1">
                                            <div class="px-0 col-12">
                                                <div class="shipping_method_border p-3 mb-3">
                                                    <div class="custom-control custom-radio">
                                                        <input type="radio" class="form-check-input custom-control-input" id="shipping_method_radio" name="shipping_method_radio" value="UPSGround" checked="checked">
                                                        <label class="custom-control-label w-100 p-1" for="shipping_method_radio">
                                                            <span class="row mx-0">
                                                                <span class="display-name col-6 px-0">Ground</span>
                                                                <span class="shipping-method-pricing col-6 px-0 text-right">
                                                                    <span class="shipping-cost strike-through">$10.00</span>
                                                                    <span class="shipping-cost-discounted"></span>
                                                                </span>
                                                            </span>

                                                        </label>
                                                    </div>
                                                </div>
                                            </div>
                                        </div> -->

                                                </div>

                                            </div>
                                        </form>
                                        <div class="row d-none" id="shipping_information">
                                            <div class="col-12 p-0">
                                                <span id="shipping_content_summary" style="font-size: 1.5rem;"></span>
                                                <div id="shipping_content_details">
                                                    <div class="col-md-4">
                                                        <h4>SHIPPING ADDRESS</h4>
                                                        <p data-update="shipping_street_addr"></p>
                                                        <p data-update="shipping_addr2"></p>
                                                        <p data-update="shipping_city"></p>
                                                        <p data-update="shipping_state"></p>
                                                        <p data-update="shipping_country"></p>
                                                    </div>
                                                    <div class="col-md-4">
                                                        <h4>CONTACT INFO</h4>
                                                        <p data-update="shipping_phone"><?php echo $get_shipping_details_r['shipping_phone'] ?></p>
                                                        <p data-update="shipping_email"></p>
                                                    </div>
                                                    <div class="col-md-4">
                                                        <h4>SHIPPING METHOD</h4>
                                                        <p data-update="shipping_method"></p>
                                                    </div>
                                                </div>

                                            </div>
                                        </div>


                                        <!--  -->
                                        <!--                                      <div class="row billing-tag-details">

                                        </div> -->
                                        <!--  -->
                                    </div>
                                </div>
                            </div>

                        </div>

                        <!--  PAYMENT BUTTON START-->
                        <div class="row mx-0" style="display:none;" id="payment_button">
                            <div class="col-12 col-md-12 col-lg-12 d-flex justify-content-center pb-3 px-0">
                                <button id="continue_to_payment1" class="btn btn-lg text-center bg_yeti text-white main-font d-md-none w-100" style="font-size: 1rem;letter-spacing: 1px;"> CONTINUE TO PAYMENT </button>
                                <button id="continue_to_payment" class="btn btn-lg text-center bg_yeti text-white main-font d-none d-md-block d-lg-block text-center" style="font-size: 1rem;letter-spacing: 1px;"> CONTINUE TO PAYMENT </button>
                            </div>
                        </div>

                        <!-- PAYMENT BUTTON END-->

                        <!-- STEP 2 END -->

                        <!-- STEP 3 START -->
                        <div class="row" id="payment_greyed">
                            <div class="col-12 col-md-12 order-1 order-md-0 mb-5 mb-md-6">
                                <div class="card p-3 bg-grey-yt">
                                    <div class="row mx-0">
                                        <div class="col-8 p-0">
                                            <span class="step_number d-inline-block">3</span>
                                            <h2 class="step__title d-inline-block">PAYMENT</h2>
                                        </div>
                                        <div class="col-4 px-0 text-right" style="font-size: 1.5rem;">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row" id="payment_details" style="display:none;">
                            <div class="col-12 col-md-12 order-1 order-md-0 mb-5 mb-md-6">
                                <div class="card p-3">
                                    <div class="card-header p-0 pb-3 pb-md-4">
                                        <div class="row mx-0">
                                            <div class="col-8 p-0">
                                                <span class="step_number d-inline-block">3</span>
                                                <h2 class="step__title d-inline-block">PAYMENT</h2>
                                            </div>
                                            <div class="col-4 px-0 text-right" style="font-size: 1.5rem;">
                                                <span class="d-inline-block">Step 3 of 3</span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="card-body p-0">
                                        <h6 class="mb-4">BILLING ADDRESS</h6>
                                        <div class="save-address-form">
                                            <input type="checkbox" id="use_billing_save" name="use_billing_save" checked>
                                            <label for="use_billing_save">SAME AS SHIPPING ADDRESS</label>
                                        </div>
                                        <hr>
                                        <h6 class="mb-4">PAYMENT METHOD</h6>
                                        <div class="row mx-0 p3 border-1">
                                            <div class="col-12 col-lg-4 pl-1 order-1g-1 order-1" id="col_cc">
                                                <a class="btn w-100 payment_method_box p-3 mb-3 checked_payment" onclick="click_payment(this,'cc');" id="anchor_cc">
                                                    <div class="text-center">
                                                        <span class="row mx-0">
                                                            <span class="display-name col-12 px-0">Credit Card <i class="fa fa-lock"></i>
                                                                <!--                                                             <span class="pull-right">
                                                                <img src="https://i.imgur.com/2ISgYja.png" width="30">
                                                                <img src="https://i.imgur.com/W1vtnOV.png" width="30">
                                                                <i class="fa fa-cc-amex fa-lg" aria-hidden="true" style="color: royalblue;"></i>
                                                                <img src="/img/icon/discover.svg" alt="Discover" width="32">
                                                                <img src="/img/icon/jcb.svg" alt="JCB" width="32">
                                                                <img src="/img/icon/diners.svg" alt="Diners Club" width="32">
                                                            </span> -->
                                                            </span>
                                                        </span>
                                                    </div>
                                                </a>
                                            </div>
                                            <div class="col-12 col-lg-4 pl-1 order-lg-2 order-3" id="col_pp">
                                                <a class="btn w-100 payment_method_box p-3 mb-3" onclick="click_payment(this,'pp');" id="anchor_pp">
                                                    <div class="text-center">
                                                        <div class="row">
                                                            <div class="col-4 mx-auto text-center">
                                                                <img src="/img/PayPal.svg" class="img-fluid" style="height:26px">
                                                            </div>
                                                        </div>
                                                    </div>
                                                </a>

                                            </div>
                                           <div class="col-12 col-lg-4 pl-1 order-lg-3 order-4" id="col_po">
                                                <a class="btn w-100 payment_method_box p-3 mb-3" onclick="click_payment(this,'po');" id="anchor_po">
                                                    <div class="text-center">
                                                        <span class="row mx-0">
                                                            <span class="display-name col-12 px-0">Purchase Order</span>
                                                        </span>
                                                    </div>
                                                </a>
                                            </div>
                                            <div class="col-12 order-lg-4 order-2" id="col_pm">
                                                <div class="card" id="card_cc">
                                                    <form id="frmPayment" action="" method="post">
                                                        <?php
                                                        // get grand total
                                                        $cart_row_card = $db->getData('cart', '*', 'id=' . $_SESSION[SESS_PRE . '_SESS_CART_ID'] . ' AND isDelete = 0');
                                                        $cart_data_card = mysqli_fetch_assoc($cart_row_card);
                                                        ?>
                                                        <input type='hidden' name='amount' value='<?php echo $cart_data_card["grand_total"]; ?>'>
                                                        <span class="font-weight-bold card-text">Card Number</span>
                                                        <div class="input-group-lg">
                                                            <input type="text" name="card_number" class="form-control" placeholder="0000 0000 0000 0000" id="card_number" maxlength="16">
                                                        </div>
                                                        <div class="row mt-3 mb-3">
                                                            <div class="col-6 col-md-6">
                                                                <span class="font-weight-bold card-text">Expiry Date</span>
                                                                <div class="input-group-lg">
                                                                    <input type="text" name="expiry_date" class="form-control" placeholder="MM/YY" maxlength="5" onkeyup="formatString(event)">
                                                                </div>
                                                            </div>
                                                            <div class="col-6 col-md-6">
                                                                <span class="font-weight-bold card-text">CVC/CVV</span>
                                                                <div class="input-group-lg">
                                                                    <input type="text" class="form-control" name="card_code" placeholder="000" maxlength="4">
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <span class="text-success certificate-text" style="letter-spacing: 1px;"><i class="fa fa-lock"></i> Your transaction is secured with ssl certificate</span>
                                                        <div class="row mt-3 mb-3">
                                                            <div class="col-md-12 text-center d-none">
                                                                <!-- <button type="button" id="submit-btn-pay" name="pay_now" class="btn btn-lg btn-block bg_yeti main-font" style="color: white" onclick="card_payment()">Pay for my order</button> -->
                                                                <!-- <input type="button" name="pay_now" value="Pay for my order" id="submit-btn" class="btnAction" onclick="card_payment()" style="background: #1d1441;padding: 15px 40px;color: #fff;text-transform: uppercase;margin-right: 15px;"> -->
                                                            </div>
                                                        </div>
                                                    </form>
                                                </div>

                                                <div class="card d-none" id="card_pp">
                                                    <div id="paypal-button-container"></div>
                                                </div>

                                                <div class="card d-none" id="card_po">
                                                    <form id="frmPO" action="" method="post">
                                                        <input type="text" class="form-control" name='purchase_number' placeholder="Enter P.O. Number">
                                                    </form>
                                                    <div class="row mt-3 mb-3">
                                                        <div class="col-md-12 text-center">
                                                            <button type="button" id="submit-btn" name="pay_now" class="btn btn-lg btn-block bg_yeti" style="color: white;" onclick="purchase_order()">Submit Order</button>
                                                        </div>
                                                    </div>
                                                </div>


                                            </div>
                                        </div>
                                        <div class="row mt-3 mb-3">
                                            <div class="col-md-12 text-center">
                                                <button type="button" id="submit-btn-pay" name="pay_now" class="btn btn-lg btn-block bg_yeti main-font" style="color: white" onclick="card_payment()">Pay for my order</button>
                                            </div>
                                        </div>

                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- STEP 3 END -->



                    </div>

                    <!-- ORDER SUMMARY START-->
                    <div class="col-12 col-md-4 order-0 order-md-1">
					
					    <div class="alert alert-warning" role="alert">
                            <h5 class="alert-heading">NOTICE:</h5>
                            <p>The FBI Mold included in our kits is currently on backorder. Domestic orders will ship without the mold, which will follow separately once restocked. International orders will ship once the mold is available. Thank you for your patience.</p>
                        </div>

                        <!-- ORDER SUMAMRY MOBILE START -->
                        <div class="view-order-summary-mobile-title d-block d-md-none card py-4 mb-3" data-hide-summary="Hide Order Summary" data-show-summary="View Order Summary">
                            <h6 class="float-left mb-0" style="text-decoration: underline; cursor:pointer;" onclick="view_order_summary(this);">VIEW ORDER SUMMARY</h6>
                            <span class="grand-total-sum grand-total-label-checkout float-right font-stratum-web-black"><b><span>$</span><?php echo $db->getValue("cart", "sub_total", "isDelete=0 AND id=" . $cart_id) ?></b></span>
                            <div class="clearfix"></div>
                        </div>
                        <!-- ORDER SUMMARY MOBILE START -->

                        <!-- ORDER SUMAMRY DESKTOP START-->
                        <div class="card p-3 mb-3 d-none d-md-block d-lg-block" id="order_summary_list">
                            <h1 class="pb-2">Order Summary</h1>
                            <div class="ps-block__content">
                                <div id="cfw-totals-list" class="cfw-module">
                                    <table class="cfw-module">
                                        <tbody class="font-stratum-web-black">
                                            <tr class="cart-subtotal">
                                                <th>Subtotal</th>
                                                <td>
                                                    <span>
                                                        <b><span>$</span><?php echo $db->getValue("cart", "sub_total", "isDelete=0 AND id=" . $cart_id) ?></b>
                                                    </span>
                                                </td>
                                            </tr>
                                            <tr>
                                                <th>
                                                    Shipping
                                                </th>
                                                <td class="payshipping">
                                                    <span class="cfw-small">Enter your address to view shipping options.</span>
                                                </td>
                                            </tr>
                                            <tr>
                                                <th>
                                                    Discount
                                                </th>
                                                <td class="finaldiscount">
                                                    <span class="cfw-small">Enter your address to view shipping options.</span>
                                                </td>
                                            </tr>
                                            <tr>
                                                <th>
                                                    Sales Tax
                                                </th>
                                                <td class="sales_tax">
                                                    <span class="cfw-small">-</span>
                                                </td>
                                            </tr>
                                            <tr class="order-total">
                                                <th>Total</th>
                                                <td class="payfinaltot">
                                                    <strong>
                                                        <span>
                                                            <bdi><?php
                                                                    $discount = 0;
                                                                    $discount = $db->num($db->getValue("cart", "discount", "id='" . $_SESSION[SESS_PRE . '_SESS_CART_ID'] . "'"));
                                                                    echo CUR . number_format($db->getValue("cart", "grand_total", "isDelete=0 AND id=" . $cart_id), 2)  ?><?php
                                                                                                                                                                            //$carttot = $db->getCartSubTotalPrice();
                                                                                                                                                                            // echo CUR.($carttot-$discount); 
                                                                                                                                                                            ?></bdi>
                                                        </span>
                                                    </strong>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            <hr class="m-0">
                            <div class="ps-promocode-section">
                                <div class="row">

                                    <div id="accordion" class="accordion col-12">
                                        <div class="card mb-0 border-right-0 border-left-0"> 
                                            <div class="card-header bg-white border-bottom-0 collapsed" data-toggle="collapse" href="#collapseOne">
                                                <a class="card-title text-muted">
                                                    <h6>COUPON</h6>
                                                </a>
                                            </div>
                                            <div id="collapseOne" class="card-body p-0 collapse" data-parent="#accordion">
                                                <div class="ps-promocode-section font-stratum-web-black">
                                                    <div class="row p-0">
                                                        <div class="col-6">
                                                            <div class="ps-promocode-section-left-side">
                                                                <input type="text" class="form-control shadow-none font-stratum-web-reg" name="promo_code_input" id="promo_code_input" placeholder="Enter coupon">
                                                            </div>
                                                        </div>
                                                        <div class="col-6">
                                                            <a class="btn btn-lg w-100 text-center btn_yeti" style="border-color: #555;" href="javascript:void(0);" onclick="Apply_Coupon();"> APPLY</a>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                </div>
                            </div>
                            <hr class="m-0">
                            <!--                             <div class="check_out">
                                <a class="ps-btn w-100 text-center py-3" href="<?php echo SITEURL; ?>cart/"> CART</a>
                            </div> -->
                        </div>
                        <!-- ORDER SUMMARY DESKTOP END-->

                        <div class="card p-3 d-none d-md-block d-lg-block font-stratum-web-bold" id="order_item_list">
                            <div class="card-body">
                                <div class="row mx-0">
                                    <div class="col-6 px-0">
                                        <span class="item-total-count grand-total-label-checkout font-weight-bold grand-total-label-checkout font-weight-bold" style="font-size: 1.4rem;"></span>
                                    </div>
                                    <div class="col-6 px-0 text-right">
                                        <span class="grand-total-sum grand-total-label-checkout" style="font-size: 1.4rem;"><b><span>$</span><?php echo $db->getValue("cart", "sub_total", "isDelete=0 AND id=" . $cart_id) ?></b></span>
                                    </div>
                                </div>
                                <hr>
                                <table class="table ps-block__products">
                                    <tbody>
                                        <?php
                                        $cart_id = 0;

                                        if (isset($_SESSION[SESS_PRE . '_SESS_CART_ID']) && $_SESSION[SESS_PRE . '_SESS_CART_ID'] > 0) {
                                            $cart_id = $_SESSION[SESS_PRE . '_SESS_CART_ID'];
                                        }

                                        $where = "cd.isDelete=0 AND p.isDelete=0 AND cd.cart_id=" . $cart_id;
                                        $join = " LEFT JOIN product p ON p.id = cd.product_id";
                                        $rows = "cd.sub_total, cd.price, cd.qty, cd.id, p.name, p.image,p.id as product_id";
                                        $cart_data = $db->getJoinData2("cart_detail cd", $join, $rows, $where);
                                        $cart_sub_total = 0;
                                        while ($cart_row = @mysqli_fetch_assoc($cart_data)) {
                                            $cart_sub_total += $cart_row['price'] * $cart_row['qty'];
                                            $product_url = $db->getValue('product', 'slug', "product.id=" . $cart_row['product_id']);
                                        ?>
                                            <tr>
                                                <td class="border-top-0">
                                                    <div class="media">
                                                        <img class="align-self-start mr-3 p-3 rounded" src="<?php echo SITEURL . PRODUCT . $cart_row['image']; ?>" alt="Generic placeholder image" width="100" style="background-color: #f1f1f1;">
                                                        <div class="media-body">
                                                            <a href="/shop/<?php echo $product_url ?>" class="mt-0"><?php echo $cart_row['name']; ?></a>
                                                            <p>QTY: <b><?php echo $cart_row['qty']; ?></b></p>
                                                            <p><b><?php echo CURR . $cart_row['sub_total']; ?></b></p>
                                                        </div>
                                                    </div>
                                                </td>
                                            </tr>
                                        <?php }

                                        $free_gift = '';
                                        $image_float = '';
                                        $qualify = false;
                                        if ($cart_sub_total >= '300' && $cart_sub_total <= '499.99') {
                                            $free_gift = "You've Earned a Free Yeti Rambler (20 oz Tumbler)";
                                            $image_float = SITEURL . "/img/gift_item/Yeti-Tumbler_Clear.png";
                                        } else if ($cart_sub_total >= '500' && $cart_sub_total <= '999.99') {
                                            $free_gift = "You've Earned a Free 10% FBI Block";
                                            $image_float = "https://clearballistics.com/img/product/1712147489_8327123_prod.png";
                                        } else if ($cart_sub_total >= '1000') {
                                            $free_gift = "You've Earned a Free Yeti Roadie 24 Hard Cooler ";
                                            $image_float = SITEURL . "/img/gift_item/Yeti-Roadie_Brighter.png";
                                        } else {
                                            $qualify = false;
                                        }
                                        ?>

                                        <!-- FREE GIFT CHECKOUT -->
                                        <?php if ($qualify) { ?>
                                            <tr class="rounded" style="border: solid #cf3e2e;">
                                                <td>
                                                    <div class="media">
                                                        <img class="ornament_overlay_checkout" src="<?php echo SITEURL; ?>/img/overlay/free_overlay.png" width="20%">
                                                        <img class="align-self-start mr-3 p-3 rounded" src="<?php echo $image_float ?>" alt="Generic placeholder image" width="100" style="background-color: #f1f1f1;">
                                                        <div class="media-body christmas_red">
                                                            <p><?php echo $free_gift ?></p>
                                                            <p>QTY: <b>1</b></p>
                                                            <p><b>$0.00</b></p>
                                                        </div>
                                                    </div>
                                                </td>
                                            </tr>
                                        <?php } ?>
                                        <!-- FREE GIFT CHECKOUT -->
                                    </tbody>
                                </table>
                            </div>

                        </div>


                        <!-- ORDER SUMMARY END -->
                        <!--                     <div class="col-12 col-md-4 order-0 order-md-1">
                        <div class="view-order-summary-mobile-title d-block d-md-none card py-4 mb-3" data-hide-summary="Hide Order Summary" data-show-summary="View Order Summary">
                            <h6 class="float-left mb-0" style="text-decoration: underline;">View Order Summary</h6>
                            <span class="grand-total-sum grand-total-label-checkout float-right">$365.00</span>
                            <div class="clearfix"></div>
                        </div>
                        </div> -->

                        <div class="col-12 col-md-4 order-1 order-md-2 mb-3">

                        </div>
                    </div>





                </div><!-- row -->
            </div><!-- container-fluid -->
        </section>
    <?php } else { ?>
        <section class="checkout-section">
            <div class="container-fluid text-center">
                <div class="row mb-3">
                    <div class="col-12">
                        <h1>OPPPPS! YOUR CART IS EMPTY!</h1>
                        <a href="<?php echo SITEURL; ?><?php echo $db->getValue("site_setting", "btn_link", "isDelete=0"); ?>" class="btn btn-primary btn-lg">BUY NOW</a>
                    </div>
                </div>
            </div>
        </section>
    <?php } ?>
    <!-- Checkout Page-section end-->
    <?php include 'front_include/footer.php'; ?>
    <?php include 'front_include/js.php'; ?>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/imask/3.4.0/imask.min.js"></script>

    <!-- Include the PayPal JavaScript SDK -->
    <script src="https://www.paypal.com/sdk/js?client-id=ATq0Pj9UNPpVbD8f67UjmDZnfo3KqWP5YucbLPH2OYd3fXbtoOa228R9Fma9lAiWtkpLSvhIIMt6QQia&currency=USD"></script>
    <script>
        // Render the PayPal button into #paypal-button-container
        paypal.Buttons({
            style: {
                layout: 'horizontal'
            },

            // Call your server to set up the transaction
            createOrder: function(data, actions) {
                return fetch('/paypal_create_order.php', {
                    method: 'POST',
                }).then(function(res) {
                    return res.json();
                }).then(function(orderData) {
                    console.log(orderData)
                    window.localStorage.setItem("paypal_order_id", orderData.id);
                    return orderData.id;
                });
            },

            // Call your server to finalize the transaction
            onApprove: function(data, actions) {
                let paypal_order_id = localStorage.getItem("paypal_order_id");
                return fetch('/paypal_capture_order.php', {
                    method: 'POST',
                    headers: {
                        'Accept': 'application/json, text/plain, */*',
                        'Content-Type': 'application/json'
                    },
                    body: JSON.stringify({
                        "paypal_order_id": paypal_order_id
                    })
                }).then(function(res) {
                    return res.json();
                }).then(function(orderData) {
                    // Three cases to handle:
                    //   (1) Recoverable INSTRUMENT_DECLINED -> call actions.restart()
                    //   (2) Other non-recoverable errors -> Show a failure message
                    //   (3) Successful transaction -> Show confirmation or thank you

                    // This example reads a v2/checkout/orders capture response, propagated from the server
                    // You could use a different API or structure for your 'orderData'
                    var errorDetail = Array.isArray(orderData.details) && orderData.details[0];

                    if (errorDetail && errorDetail.issue === 'INSTRUMENT_DECLINED') {
                        return actions.restart(); // Recoverable state, per:
                        // https://developer.paypal.com/docs/checkout/integration-features/funding-failure/
                    }

                    if (errorDetail) {
                        var msg = 'Sorry, your transaction could not be processed.';
                        if (errorDetail.description) msg += '\n\n' + errorDetail.description;
                        if (orderData.debug_id) msg += ' (' + orderData.debug_id + ')';
                        return alert(msg); // Show a failure message (try to avoid alerts in production environments)
                    }

                    // Successful capture! For demo purposes:
                    console.log('Capture result', orderData, JSON.stringify(orderData, null, 2));
                    var transaction = orderData.purchase_units[0].payments.captures[0];
                    //alert('Transaction ' + transaction.status + ': ' + transaction.id + '\n\nSee console for all available details');
                    let cart_id = <?php echo $cart_id ?>;
                    window.location.href = "<?php echo SITEURL; ?>thankyou.php?order_number=" + cart_id;
                    // Replace the above to show a success message within this page, e.g.
                    // const element = document.getElementById('paypal-button-container');
                    // element.innerHTML = '';
                    // element.innerHTML = '<h3>Thank you for your payment!</h3>';
                    // Or go to another URL:  actions.redirect('thank_you.html');
                });
            }
        }).render('#paypal-button-container');
    </script>
    <div id="paypal_frm_submit"></div>
    <script>
        // loder for page reload
        document.onreadystatechange = function() {
            var state = document.readyState
            if (state == 'interactive') {
                $(".preloader").show();
            } else if (state == 'complete') {
                setTimeout(function() {
                    document.getElementById('interactive');
                    $(".preloader").hide();
                }, 1000);
            }
        }

        /*         $("#shipping_next").click(function() {
                    if ($('#use_billing_save').is(":checked")) {
                        $("#billing_section_step2").hide();
                        $("#billing_detail_section_step2").show();
                        third_set_content();
                    } else {
                        // alert('11');
                        $("#billing_detail_section_step2").hide();
                        $("#billing_section_step2").show();
                        third_set_content();
                    }
                }); */
        var selected_payment = 2;


        function cityname() {
            var shipping_city = document.getElementById("shipping_city").value;
        }

        function shippingCharges(stateCode) {

            var zip = $("#shipping_post").val();
            var country = $("#shipping_country").val();
            $.ajax({
                type: "POST",
                beforeSend: function() {
                    $(".preloader").show();
                },
                url: "<?php echo SITEURL; ?>ajax_shipping_charges.php",
                data: 'zip=' + zip + '&c=' + country + '&sc=' + stateCode,
                dataType: 'Json',
                success: function(result) {
                    if (result['message'] == 'success') {
                        $('#shipping_method').empty().append(`<option value="">Please Select Shipping Method</option>`);
                        result['sr'].forEach(data => {
                            data['shipping_charge'] = (data['shipping_charge'] - 0).toFixed(2)
                            $('#shipping_method').append(`<option value="${data['shipping_charge']}" id="${data['desc']}">${data['desc']} - $${data['shipping_charge']} </option>`);
                        })
                        //  $("#ups_ground").html('UPS Ground' + result['shipping']);
                        $(".preloader").hide();
                    } else {
                        $('#shipping_method').empty().append(`<option value="">Please Select Shipping Method</option>`);
                        $(".preloader").hide();
                    }

                    // $(".preloader").hide();
                    //$(".preloader").show();
                }
            });
        }

        function getShippingCharges() {

            let shipping_post = document.getElementById("shipping_post").value;
            let shipping_post_country_id = document.getElementById("shipping_country").value;
            let shipping_post_state_id = document.getElementById("shipping_state").value;

            if (!shipping_post) {
                $('#shipping_post').css('border-color', 'red');
                return
            } else {
                $('#shipping_post').css('border-color', '');
            }


            let stateCode = '';
            if (shipping_post_country_id == '233') {
                stateCode = getUsZipCode(shipping_post);
            }
            //if (shipping_post || shipping_post_country_id || shipping_post_state_id) {

            //30000ms = 5s
            //setTimeout(hideLoaderAfterSecs, 5000);
            shippingCharges(stateCode)

            //rpAddShippingChargeStandard('11', stateCode);
            //rpAddShippingChargeGround('03', stateCode);
            //rpAddShippingCharge3DaySelect('12', stateCode);
            //rpAddShippingCharge2ndDayAir('02', stateCode);
            //rpAddShippingCharge2ndDayAirAM('59', stateCode);
            //rpAddShippingChargeNextDayAirSaver('13', stateCode);
            //rpAddShippingChargeNextDayAir('01', stateCode);
            //rpAddShippingChargeNextDayAirEarly('14', stateCode);
            //rpAddShippingChargeWorldwideExpress('07', stateCode);
            //rpAddShippingChargeWorldwideExpressPlus('54', stateCode);
            //rpAddShippingChargeWorldwideExpedited('08', stateCode);
            //rpAddShippingChargeWorldWideSaver('65', stateCode);       
            //}

            //dhlExpress(shipping_post);
            //alert(shipping_post);

            // $.ajax({
            //     type: "POST",
            //     url: "<?php //echo SITEURL; 
                            ?>ajax_update_postcode.php",
            //     // data: {country_id:country_id},
            //     data: 'shipping_post='+shipping_post,
            //     success: function(data)
            //     {
            //         alert(data);
            //         $("#shipping_post").val(data);
            //     }
            // });

        }
        $(document).ready(function() {

            // third_set_content();

            // $("#card_no,#card_cvv").numeric({ decimal: false, negative: false });
            // rpAddShippingCharge('03');


            // rpAddShippingChargeStandard('11');
            // rpAddShippingChargeGround('03');
            // rpAddShippingCharge3DaySelect('12');
            // rpAddShippingCharge2ndDayAir('02');
            // rpAddShippingCharge2ndDayAirAM('59');
            // rpAddShippingChargeNextDayAirSaver('13');
            // rpAddShippingChargeNextDayAir('01');
            // rpAddShippingChargeNextDayAirEarly('14');
            // rpAddShippingChargeWorldwideExpress('07');
            // rpAddShippingChargeWorldwideExpressPlus('54');
            // rpAddShippingChargeWorldwideExpedited('08');
            // rpAddShippingChargeWorldWideSaver('65');

            // getState();

            function initialize() {
                // on load shiffing fee blank
                $(".payshipping").html('-');
                $(".payfinaltot").html('-');
                $(".finaldiscount").html('-');
                // used for testing steps
                /*                 $("#PaymentCard_Step3").show();
                                $("#BillingAddress_Step-2").hide();
                                $("#Shipping_Address_Step1").hide(); */

                /* 
                                localStorage.setItem("cart_id", "<?php echo $cart_id; ?>");
                                const value = localStorage.getItem("key");
                                localStorage.removeItem("key");
                                console.log(<?php echo $cart_id; ?>); */

            }

            initialize()

            var user_type = "<?php echo $user ?>";
            if (user_type == "") {
                user_type = "user";
            }

            $.ajax({
                url: "<?php echo SITEURL ?>ajax_shipping_content.php",
                type: "POST",
                data: {
                    userType: user_type
                },
                beforeSend: function() {
                    $(".loader").fadeIn();
                },
                success: function(res) {
                    $(".loader").fadeOut();
                    $("#first_step_content").html(res);
                    third_set_content();
                }
            });

            third_set_content();

            $('#card_number').keypress(function(e) {
                if (e.which === 32)
                    return false;
            });

        });

        jQuery(document).ready(function($) {});

        function validateEmail(emailField) {
            var reg = /^([A-Za-z0-9_\-\.])+\@([A-Za-z0-9_\-\.])+\.([A-Za-z]{2,4})$/;

            if (reg.test(emailField.value) == false) {
                return false;
            }

            return true;

        }


        function click_payment(this_elem, anchor_id) {
            $(this_elem).addClass('checked_payment');
            switch (anchor_id) {
                case 'cc':
                    $('#anchor_pp').removeClass('checked_payment')
                    $('#anchor_po').removeClass('checked_payment')
                    $('#card_cc').removeClass('d-none')
                    $('#submit-btn-pay').removeClass('d-none')
                    $('#card_pp').addClass('d-none')
                    $('#card_po').addClass('d-none')

                    $('#col_pm').removeClass(`order-${selected_payment}`);
                    selected_payment = 1 + 1
                    $('#col_pm').addClass(`order-${selected_payment}`);
                    selected_payment = 'cc'
                    break;
                case 'pp':
                    $('#anchor_cc').removeClass('checked_payment')
                    $('#anchor_po').removeClass('checked_payment')
                    $('#card_cc').addClass('d-none')
                    $('#submit-btn-pay').addClass('d-none')

                    $('#card_pp').removeClass('d-none')
                    $('#card_po').addClass('d-none')

                    $('#col_pm').removeClass(`order-${selected_payment}`);
                    selected_payment = 2 + 1
                    $('#col_pm').addClass(`order-${selected_payment}`);
                    break;
                case 'po':
                    $('#anchor_cc').removeClass('checked_payment')
                    $('#anchor_pp').removeClass('checked_payment')
                    $('#card_cc').addClass('d-none')
                    $('#submit-btn-pay').addClass('d-none')
                    $('#card_pp').addClass('d-none')
                    $('#card_po').removeClass('d-none')

                    $('#col_pm').removeClass(`order-${selected_payment}`);
                    selected_payment = 3 + 1
                    $('#col_pm').addClass(`order-${selected_payment}`);
                    break;

                default:
                    break;
            }

        }

        function input_email_as_guest() {
            var email = $("#shipping_email").val();
            if ((!email && validateEmail(email))) {
                $('#shipping_email').css('border-color', 'red');
            } else {
                $("#step1logo").text("✔");
                $("#guest_input_form").hide();
                $("#step1_text").hide();
                var guest_email = $("#shipping_email").val();
                $("#guest_email").text(guest_email);
                $('#step1_edit_text').removeClass('d-none')
                $("#shipping_greyed").hide();
                $("#shipping_details").show();
                $("#payment_button").show();
                $('#shipping_information').addClass('d-none')
            }

        }

        function step1_edit() {
            $("#payment_greyed").show();
            $("#shipping_greyed").show();
            $("#payment_details").hide();
            $("#shipping_details").hide();
            $("#step1logo").text("1");
            $("#guest_input_form").show();
            $("#guest_email").text("");
            $('#step1_edit_text').addClass('d-none')
            $("#step1_text").show();
            $("#payment_button").hide();
            $("#shipping_input_form").show();
        }

        function step2_edit() {
            $("#payment_greyed").show();
            $("#shipping_input_form").show();
            $('#shipping_information').addClass('d-none')
            $("#step2_text").show()
            $('#step2_edit_text').addClass('d-none')
            $("#payment_details").hide();
            $("#step2logo").text("2");
            $("#payment_button").show();
            $("#payment_button1").show();
        }

        function view_order_summary(e) {
            if (e.innerHTML === "VIEW ORDER SUMMARY") {
                e.innerHTML = "HIDE ORDER SUMMARY"
            } else {
                e.innerHTML = "VIEW ORDER SUMMARY"
            }
            $("#order_summary_list").toggleClass("d-none");
            $("#order_item_list").toggleClass("d-none");
        }



        function rpAddShippingCharge(s) {
            // var zip = $("#zip").val();
            // var country = $("#country").val();
            var zip = $("#shipping_post").val();
            var country = $("#shipping_country").val();
            // alert(zip);
            if (s == undefined) {
                var s = $("#shipping_method").val();
            }
            let sm = $('#shipping_method option:selected').attr('id');
            $.ajax({
                type: "POST",
                url: "<?php echo SITEURL; ?>ajax_add_shipping_charge.php",
                // url: "<?php echo SITEURL; ?>ajax_add_address.php",
                data: 's=' + s + '&zip=' + zip + '&c=' + country + '&sm=' + sm,
                beforeSend: function() {
                    // $(".preloader").fadeIn(800);
                    $(".preloader").show();
                },
                dataType: 'Json',
                success: function(result) {
                    // alert(result['html']);
                    // $(".paymentBlock").html(result);

                    // $(".loader").fadeOut(800);
                    if (result['is_blank_arr'] == 1) {
                        rpAddShippingCharge(s);
                        // contact-btn-step1
                    } else {
                        // $(".paymentBlock").html(result['html']);

                        $(".payshipping").html(result['shipping']);
                        $(".payfinaltot").html(result['finaltot']);
                        $(".finaldiscount").html(result['finaldiscount']);
                        $(".grand-total-sum").html(result['finaltot'])
                    }

                    // if(result['SHIPPINGNOTABAI'] == 0)
                    // {
                    //     $(".contact-btn-step1").css("display", "none");
                    // }
                    // else
                    // {
                    //     $(".contact-btn-step1").css("display", "flex");
                    // }

                    // $(".preloader").fadeOut(800);
                    $(".preloader").hide();
                },
                error: function(XMLHttpRequest, textStatus, errorThrown) {
                    console.log(errorThrown);
                    $(".preloader").hide();
                }
            });

            /*            $.ajax({
                           type: "POST",
                           url: "<?php echo SITEURL; ?>ajax_get_dis_shipping_name.php",
                           // url: "<?php echo SITEURL; ?>ajax_add_address.php",
                           data: 's=' + s,
                           dataType: 'Json',
                           success: function(result) {
                               console.log(result);
                               $("#dis_shipping_method").html(result.dis_shipping_method);
                           }
                       }); */
        }

        function paypal_payment() {
            $.ajax({
                url: "<?php echo SITEURL; ?>paypal_checkout.php",
                type: "post",
                dataType: 'json',
                data: $('#stripe_form_submit').serialize(),
                beforeSend: function() {
                    $(".loading-div").removeClass("hide");
                },
                success: function(res) {
                    //	alert(res);
                    if (res == 2) {
                        $.alert({
                            title: 'Oops..',
                            type: 'red',
                            content: 'Your cart quantity and shipping quantity not matched'
                        });
                    } else {
                        $(".loading-div").addClass("hide");
                        $("#paypal_frm_submit").html(res);
                        setTimeout(function() {
                            document.frmPayPal.submit();
                        }, 1000);
                    }
                }
            });
        }

        function card_payment() {
            $.ajax({
                url: "<?php echo SITEURL; ?>card_checkout.php",
                type: "post",
                dataType: 'json',
                data: $('#frmPayment').serialize(),
                beforeSend: function() {
                    // $(".loading-div").removeClass("hide");
                    $(".preloader").show();
                },
                success: function(response) {
                    try {
                        if (response.code == 0) {
                            $(".preloader").hide();
                            // create alert if credit card is invalid 
                            $.notify({
                                message: 'The credit card number is invalid.'
                            }, {
                                type: 'danger'
                            });
                        }

                        if (response.code == 1) {
                            window.location.href = "<?php echo SITEURL; ?>thankyou.php?order_number=" + response.order_id;
                        } else {
                            $(".preloader").hide();
                            //window.location.href = "<?php echo SITEURL; ?>checkout";
                        }
                    } catch (error) {
                        $(".preloader").hide();
                    }
                    //res1 = JSON.parse(res1);


                }
            });
        }

        function purchase_order() {
            $.ajax({
                url: "<?php echo SITEURL; ?>purchase_order.php",
                type: "post",
                dataType: 'json',
                data: $('#frmPO').serialize(),
                beforeSend: function() {
                    // $(".loading-div").removeClass("hide");
                    $(".preloader").show();
                },
                success: function(response) {
                    try {

                        if (response.ok) {
                            window.location.href = "<?php echo SITEURL; ?>thankyou.php?order_number=" + response.order_id;
                        } else {
                            $(".preloader").hide();
                            $.notify({
                                message: 'Purchase order failed.'
                            }, {
                                type: 'danger'
                            });
                        }
                    } catch (error) {
                        $(".preloader").hide();
                    }
                }
            });
        }

        function show1() {
            document.getElementById('billing_section').style.display = 'none';
        }

        function show2() {
            document.getElementById('billing_section').style.display = 'block';
        }


        $('#continue_to_payment').click(function() {
            $("#shipping_form_step").validate({
                rules: {
                    shipping_first_name: {
                        required: true
                    },
                    shipping_last_name: {
                        required: true
                    },
                    shipping_street_addr: {
                        required: true
                    },
                    // shipping_addr2:{required : true},
                    shipping_country: {
                        required: true
                    },
                    shipping_post: {
                        required: true
                    },
                    shipping_state: {
                        required: true
                    },
                    shipping_phone: {
                        required: true
                    },
                    shipping_city: {
                        required: true
                    },
                    shipping_email: {
                        required: true
                    },
                    shipping_method: {
                        required: true
                    }
                    // check_out_signup_password:{required:true},
                },
                messages: {
                    shipping_first_name: {
                        required: "Please enter first name."
                    },
                    shipping_last_name: {
                        required: "Please enter last name."
                    },
                    shipping_street_addr: {
                        required: "Please enter street address."
                    },
                    // shipping_addr2:{required:"Please enter other address."},
                    shipping_country: {
                        required: "Please enter country."
                    },
                    shipping_post: {
                        required: "Please enter post code."
                    },
                    shipping_state: {
                        required: "Please enter state."
                    },
                    shipping_phone: {
                        required: "Please enter phone number."
                    },
                    shipping_city: {
                        required: "Please enter city name."
                    },
                    shipping_email: {
                        required: "Please enter email address."
                    },
                    shipping_method: {
                        required: "No rates selected!"
                    }
                    // check_out_signup_password:{required:"Enter password."},
                },
            });
            if ($('#shipping_form_step').valid()) // check if form is valid
            {
                $("#step2logo").text("✔");
                $("#shipping_input_form").hide();
                $("#payment_greyed").hide();
                $("#payment_details").show();
                $("#payment_button").hide();
                $('#shipping_information').removeClass('d-none')
                $("#step2_text").hide()
                $('#step2_edit_text').removeClass('d-none')
                // if($('#use_billing_save').is(":checked")){   
                var use_billing_save = $('#use_billing_save').is(":checked");
                var shipping_email = $('#shipping_email').val();
                // alert(use_billing_save);
                $.ajax({
                    url: "<?php echo SITEURL; ?>checkout_db.php",
                    type: "POST",
                    data: $('#shipping_form_step').serialize() +
                        "&mode=shipping_step" + `&shipping_email=${shipping_email}` + "&use_billing_save=on",

                    beforeSend: function() {
                        $(".loader").hide();
                    },
                    success: function(res) {
                        /*                         $("#Shipping_Address_Step1").hide();
                                                $("#BillingAddress_Step-2").show();
                                                $("#step-2").addClass("active");
                                                $("#step-1").removeClass("active"); */

                        /*                         $.ajax({
                                                    url: "<?php echo SITEURL ?>ajax_billing_content.php",
                                                    type: "POST",
                                                    data: {
                                                        use_billing_save: use_billing_save
                                                    },
                                                    beforeSend: function() {
                                                        $(".loader").fadeIn();
                                                    },
                                                    success: function(res) {
                                                        // alert(res);
                                                        $(".loader").fadeOut();
                                                        $("#second_step_content").html(res);
                                                        if ($('#use_billing_save').is(":checked")) {
                                                            $("#billing_section_step2").hide();
                                                            $("#billing_detail_section_step2").show();
                                                            third_set_content();
                                                        } else {
                                                            // alert('11');
                                                            $("#billing_detail_section_step2").hide();
                                                            $("#billing_section_step2").show();
                                                            third_set_content();
                                                        }
                                                    }
                                                }); */
                    }
                });
            }
        });

        $('#continue_to_payment1').click(function() {
            $("#shipping_form_step").validate({
                rules: {
                    shipping_first_name: {
                        required: true
                    },
                    shipping_last_name: {
                        required: true
                    },
                    shipping_street_addr: {
                        required: true
                    },
                    // shipping_addr2:{required : true},
                    shipping_country: {
                        required: true
                    },
                    shipping_post: {
                        required: true
                    },
                    shipping_state: {
                        required: true
                    },
                    shipping_phone: {
                        required: true
                    },
                    shipping_city: {
                        required: true
                    },
                    shipping_email: {
                        required: true
                    },
                    shipping_method: {
                        required: true
                    }
                    // check_out_signup_password:{required:true},
                },
                messages: {
                    shipping_first_name: {
                        required: "Please enter first name."
                    },
                    shipping_last_name: {
                        required: "Please enter last name."
                    },
                    shipping_street_addr: {
                        required: "Please enter street address."
                    },
                    // shipping_addr2:{required:"Please enter other address."},
                    shipping_country: {
                        required: "Please enter country."
                    },
                    shipping_post: {
                        required: "Please enter post code."
                    },
                    shipping_state: {
                        required: "Please enter state."
                    },
                    shipping_phone: {
                        required: "Please enter phone number."
                    },
                    shipping_city: {
                        required: "Please enter city name."
                    },
                    shipping_email: {
                        required: "Please enter email address."
                    },
                    shipping_method: {
                        required: "No rates selected!"
                    }
                    // check_out_signup_password:{required:"Enter password."},
                },
            });
            if ($('#shipping_form_step').valid()) // check if form is valid
            {
                $("#step2logo").text("✔");
                $("#shipping_input_form").hide();
                $("#payment_greyed").hide();
                $("#payment_details").show();
                $("#payment_button").hide();
                $('#shipping_information').removeClass('d-none')
                $("#step2_text").hide()
                $('#step2_edit_text').removeClass('d-none')
                // if($('#use_billing_save').is(":checked")){   
                var use_billing_save = $('#use_billing_save').is(":checked");
                var shipping_email = $('#shipping_email').val();
                // alert(use_billing_save);
                $.ajax({
                    url: "<?php echo SITEURL; ?>checkout_db.php",
                    type: "POST",
                    data: $('#shipping_form_step').serialize() +
                        "&mode=shipping_step" + `&shipping_email=${shipping_email}` + "&use_billing_save=on",

                    beforeSend: function() {
                        $(".loader").hide();
                    },
                    success: function(res) {
                        /*                         $("#Shipping_Address_Step1").hide();
                                                $("#BillingAddress_Step-2").show();
                                                $("#step-2").addClass("active");
                                                $("#step-1").removeClass("active"); */

                        /*                         $.ajax({
                                                    url: "<?php echo SITEURL ?>ajax_billing_content.php",
                                                    type: "POST",
                                                    data: {
                                                        use_billing_save: use_billing_save
                                                    },
                                                    beforeSend: function() {
                                                        $(".loader").fadeIn();
                                                    },
                                                    success: function(res) {
                                                        // alert(res);
                                                        $(".loader").fadeOut();
                                                        $("#second_step_content").html(res);
                                                        if ($('#use_billing_save').is(":checked")) {
                                                            $("#billing_section_step2").hide();
                                                            $("#billing_detail_section_step2").show();
                                                            third_set_content();
                                                        } else {
                                                            // alert('11');
                                                            $("#billing_detail_section_step2").hide();
                                                            $("#billing_section_step2").show();
                                                            third_set_content();
                                                        }
                                                    }
                                                }); */
                    }
                });
            }
        });

        function third_set_content() {
            var use_billing_save = $('#use_billing_save').is(":checked");
            $.ajax({
                url: "<?php echo SITEURL ?>ajax_billing_third_set_content.php",
                type: "POST",
                data: {
                    use_billing_save: use_billing_save
                },
                beforeSend: function() {
                    $(".loader").fadeIn();
                },
                success: function(res) {
                    // alert(res);
                    $(".loader").fadeOut();
                    $("#third_set_content").html(res);
                }
            });
        }

        $('#billing_step_btn').click(function() {
            if ($('#use_billing_save').is(":checked")) {
                $("#BillingAddress_Step-2").hide();
                $("#PaymentCard_Step3").show();
                $("#step-3").addClass("active");
                $("#step-2").removeClass("active");
                third_set_content();
            } else {
                $("#shipping_form_step").validate({
                    rules: {
                        billing_first_name: {
                            required: true
                        },
                        billing_last_name: {
                            required: true
                        },
                        billing_street_addr: {
                            required: true
                        },
                        billing_addr2: {
                            required: true
                        },
                        billing_country: {
                            required: true
                        },
                        billing_post: {
                            required: true
                        },
                        billing_state: {
                            required: true
                        },
                        billing_phone: {
                            required: true
                        },
                        billing_city: {
                            required: true
                        },
                    },
                    messages: {
                        billing_first_name: {
                            required: "Please enter first name."
                        },
                        billing_last_name: {
                            required: "Please enter last name."
                        },
                        billing_street_addr: {
                            required: "Please enter street address."
                        },
                        billing_addr2: {
                            required: "Please enter other address."
                        },
                        billing_country: {
                            required: "Please enter country."
                        },
                        billing_post: {
                            required: "Please enter post code."
                        },
                        billing_state: {
                            required: "Please enter state."
                        },
                        billing_phone: {
                            required: "Please enter phone number."
                        },
                        billing_city: {
                            required: "Please enter city name."
                        },
                    },
                });

                if ($('#shipping_form_step').valid()) {
                    $.ajax({
                        url: "<?php echo SITEURL; ?>checkout_db.php",
                        type: "POST",
                        data: $('#shipping_form_step').serialize() +
                            "&mode=billing_step",

                        beforeSend: function() {
                            $(".loader").hide();
                        },
                        success: function(res) {
                            $("#PaymentCard_Step3").show();
                            $("#BillingAddress_Step-2").hide();
                            $("#step-3").addClass("active");
                            $("#step-2").removeClass("active");
                            third_set_content();
                        }
                    });
                }
            }

        });

        $("#back").on("click", function() {
            $("#BillingAddress_Step-2").hide();
            $("#Shipping_Address_Step1").show();
            $("#step-1").addClass("active");
            $("#step-2").removeClass("active");
        });

        $("#step2-back").on("click", function() {
            $("#PaymentCard_Step3").hide();
            $("#BillingAddress_Step-2").show();
            $("#step-2").addClass("active");
            $("#step-3").removeClass("active");
        });


        $("#step3-back").on("click", function() {
            $("#question_areaFour").hide();
            $("#question_areaThird").show();
            $("#step-3").addClass("active");
            $("#step-4").removeClass("active");
        });

        function formatString(e) {
            var inputChar = String.fromCharCode(event.keyCode);
            var code = event.keyCode;
            var allowedKeys = [8];
            if (allowedKeys.indexOf(code) !== -1) {
                return;
            }

            event.target.value = event.target.value.replace(
                /^([1-9]\/|[2-9])$/g, '0$1/' // 3 > 03/
            ).replace(
                /^(0[1-9]|1[0-2])$/g, '$1/' // 11 > 11/
            ).replace(
                /^([0-1])([3-9])$/g, '0$1/$2' // 13 > 01/3
            ).replace(
                /^(0?[1-9]|1[0-2])([0-9]{2})$/g, '$1/$2' // 141 > 01/41
            ).replace(
                /^([0]+)\/|[0]+$/g, '0' // 0/ > 0 and 00 > 0
            ).replace(
                /[^\d\/]|^[\/]*$/g, '' // To allow only digits and `/`
            ).replace(
                /\/\//g, '/' // Prevent entering more than 1 `/`
            );
        }

        function Apply_Coupon() {
            $(".loader").hide();
            coupon_code = $("#promo_code_input").val();
            $.ajax({
                url: "<?php echo SITEURL; ?>checkout_db.php",
                type: "POST",
                data: {
                    mode: "coupon_apply",
                    coupon_code: coupon_code,
                },
                success: function(val) {
                    $(".loader").hide();
                    if (val == "Invalid_Coupon") {
                        $.notify({
                            message: 'Please enter a valid code.'
                        }, {
                            type: 'info'
                        });
                    } else if (val == "Not_Acceptable") {
                        $.notify({
                            message: "Sorry, this coupon is not applicable to your cart contents."
                        }, {
                            type: 'danger'
                        });
                    } else if (val == "Already_Apply") {
                        $.notify({
                            message: "Coupon code already applied!"
                        }, {
                            type: 'info'
                        });
                    } else if (val == "No coupon!") {
                        $.notify({
                            message: "Please enter a coupon!"
                        }, {
                            type: 'danger'
                        });
                    } else {
                        $.notify({
                            message: "Coupon applied!"
                        }, {
                            type: 'info'
                        });
                    }

                    rpAddShippingCharge();
                },
            });
        }

        /* GET STATE START*/
        function getState(country_id) {
            // var country_id = $('#shipping_country :selected').text();
            // var country_id = $("#shipping_country").val();
            // alert(country_id);
            if (country_id == 0 || country_id == '') {
                $('#shipping_country').css('color', 'grey');
            }
            var shipping_state = <?= json_encode($shipping_state) ?>;
            $.ajax({
                type: "POST",
                url: "<?php echo SITEURL; ?>ajax_state.php",
                // data: {country_id:country_id},
                // data: 'country_id='+country_id,
                data: {
                    country_id: country_id,
                    shipping_state: shipping_state
                },
                success: function(options) {
                    // alert(options);
                    // $('#shipping_state').empty().append(options);
                    $("#shipping_state").html(options === "" ? "<option value=''>State</option>" : options);
                    let zipCode = $('#shipping_post').val();
                    if (zipCode) {
                        $('#shipping_post').css('border-color', '');
                        getShippingCharges()
                    } else {
                        $('#shipping_post').css('border-color', 'red');
                    }

                }
            });
        }
        /* GET STATE END */

        /* ZIPCODE */
        function getUsZipCode(zipCode) {
            let stateCode = '';
            zipCode = parseFloat(zipCode);
            if (zipCode >= 35000 && zipCode <= 36999) {
                $('#shipping_state').val('1456')
                stateCode = 'AL';
            } else if (zipCode >= 99500 && zipCode <= 99999) {
                $('#shipping_state').val('1400')
                stateCode = 'AK';
            } else if (zipCode >= 85000 && zipCode <= 86999) {
                $('#shipping_state').val('1434')
                stateCode = 'AZ';
            } else if (zipCode >= 71600 && zipCode <= 72999) {
                $('#shipping_state').val('1444')
                stateCode = 'AR';
            } else if (zipCode >= 90000 && zipCode <= 96699) {
                $('#shipping_state').val('1416')
                stateCode = 'CA';
            } else if (zipCode >= 80000 && zipCode <= 81999) {
                $('#shipping_state').val('1450')
                stateCode = 'CO';
            } else if ((zipCode >= 6000 && zipCode <= 6389) || (zipCode >= 6391 && zipCode <= 6999)) {
                $('#shipping_state').val('1435')
                stateCode = 'CT';
            } else if (zipCode >= 19700 && zipCode <= 19999) {
                $('#shipping_state').val('1399')
                stateCode = 'DE';
            } else if (zipCode >= 32000 && zipCode <= 34999) {
                $('#shipping_state').val('1436')
                stateCode = 'FL';
            } else if ((zipCode >= 30000 && zipCode <= 31999) || (zipCode >= 39800 && zipCode <= 39999)) {
                $('#shipping_state').val('1455')
                stateCode = 'GA';
            } else if (zipCode >= 96700 && zipCode <= 96999) {
                $('#shipping_state').val('1411')
                stateCode = 'HI';
            } else if (zipCode >= 83200 && zipCode <= 83999) {
                $('#shipping_state').val('1460')
                stateCode = 'ID';
            } else if (zipCode >= 60000 && zipCode <= 62999) {
                $('#shipping_state').val('1425')
                stateCode = 'IL';
            } else if (zipCode >= 46000 && zipCode <= 47999) {
                $('#shipping_state').val('1440')
                stateCode = 'IN';
            } else if (zipCode >= 50000 && zipCode <= 52999) {
                $('#shipping_state').val('1459')
                stateCode = 'IA';
            } else if (zipCode >= 66000 && zipCode <= 67999) {
                $('#shipping_state').val('1406')
                stateCode = 'KS';
            } else if (zipCode >= 40000 && zipCode <= 42999) {
                $('#shipping_state').val('1419')
                stateCode = 'KY';
            } else if (zipCode >= 70000 && zipCode <= 71599) {
                $('#shipping_state').val('1457')
                stateCode = 'LA';
            } else if (zipCode >= 3900 && zipCode <= 4999) {
                $('#shipping_state').val('1453')
                stateCode = 'ME';
            } else if (zipCode >= 20600 && zipCode <= 21999) {
                $('#shipping_state').val('1401')
                stateCode = 'MD';
            } else if ((zipCode >= 1000 && zipCode <= 2799) || (zipCode >= 5501 && zipCode <= 5544)) {
                $('#shipping_state').val('1433')
                stateCode = 'MA';
            } else if (zipCode >= 48000 && zipCode <= 49999) {
                $('#shipping_state').val('1426')
                stateCode = 'MI';
            } else if (zipCode >= 55000 && zipCode <= 56899) {
                $('#shipping_state').val('1420')
                stateCode = 'MN';
            } else if (zipCode >= 38600 && zipCode <= 39999) {
                $('#shipping_state').val('1430')
                stateCode = 'MS';
            } else if (zipCode >= 63000 && zipCode <= 65999) {
                $('#shipping_state').val('1451')
                stateCode = 'MO';
            } else if (zipCode >= 59000 && zipCode <= 59999) {
                $('#shipping_state').val('1446')
                stateCode = 'MT';
            } else if (zipCode >= 27000 && zipCode <= 28999) {
                $('#shipping_state').val('1447')
                stateCode = 'NC';
            } else if (zipCode >= 58000 && zipCode <= 58999) {
                $('#shipping_state').val('1418')
                stateCode = 'ND';
            } else if (zipCode >= 68000 && zipCode <= 69999) {
                $('#shipping_state').val('1408')
                stateCode = 'NE';
            } else if (zipCode >= 88900 && zipCode <= 89999) {
                $('#shipping_state').val('1458')
                stateCode = 'NV';
            } else if (zipCode >= 3000 && zipCode <= 3899) {
                $('#shipping_state').val('1404')
                stateCode = 'NH';
            } else if (zipCode >= 7000 && zipCode <= 8999) {
                $('#shipping_state').val('1417')
                stateCode = 'NJ';
            } else if (zipCode >= 87000 && zipCode <= 88499) {
                $('#shipping_state').val('1423')
                stateCode = 'NM';
            } else if ((zipCode >= 10000 && zipCode <= 14999) || zipCode == 6390 || zipCode <= 501 || zipCode <= 544) {
                $('#shipping_state').val('1452')
                stateCode = 'NY';
            } else if (zipCode >= 43000 && zipCode <= 45999) {
                $('#shipping_state').val('4851')
                stateCode = 'OH';
            } else if ((zipCode >= 73000 && zipCode <= 73199) || (zipCode >= 73400 && zipCode <= 74999)) {
                $('#shipping_state').val('1421')
                stateCode = 'OK';
            } else if (zipCode >= 97000 && zipCode <= 97999) {
                $('#shipping_state').val('1415')
                stateCode = 'OR';
            } else if (zipCode >= 15000 && zipCode <= 19699) {
                $('#shipping_state').val('1422')
                stateCode = 'PA';
            } else if (zipCode >= 300 && zipCode <= 999) {
                $('#shipping_state').val('0')
            } else if (zipCode >= 2800 && zipCode <= 2999) {
                $('#shipping_state').val('1461')
                stateCode = 'RI';
            } else if (zipCode >= 29000 && zipCode <= 29999) {
                $('#shipping_state').val('1443')
                stateCode = 'SC';
            } else if (zipCode >= 57000 && zipCode <= 57999) {
                $('#shipping_state').val('1445')
                stateCode = 'SD';
            } else if (zipCode >= 37000 && zipCode <= 38599) {
                $('#shipping_state').val('1454')
                stateCode = 'TN';
            } else if ((zipCode >= 75000 && zipCode <= 79999) || (zipCode >= 73301 && zipCode <= 73399) || (zipCode >= 88500 && zipCode <= 88599)) {
                $('#shipping_state').val('1407')
                stateCode = 'TX';
            } else if (zipCode >= 84000 && zipCode <= 84999) {
                $('#shipping_state').val('1414')
                stateCode = 'UT';
            } else if (zipCode >= 5000 && zipCode <= 5999) {
                $('#shipping_state').val('1409')
                stateCode = 'VT';
            } else if ((zipCode >= 20100 && zipCode <= 20199) || (zipCode >= 22000 && zipCode <= 24699) || zipCode == 20598) {
                $('#shipping_state').val('1427')
                stateCode = 'VA';
            } else if ((zipCode >= 20000 && zipCode <= 20099) || (zipCode >= 20200 && zipCode <= 20599) || zipCode == 56900 || zipCode == 56999) {
                $('#shipping_state').val('0')
            } else if (zipCode >= 98000 && zipCode <= 99499) {
                $('#shipping_state').val('1462')
                stateCode = 'WA';
            } else if (zipCode >= 24700 && zipCode <= 26999) {
                $('#shipping_state').val('1429')
                stateCode = 'WV';
            } else if (zipCode >= 53000 && zipCode <= 54999) {
                $('#shipping_state').val('1441')
                stateCode = 'WI';
            } else if (zipCode >= 82000 && zipCode <= 83199) {
                $('#shipping_state').val('1442')
                stateCode = 'WY';
            }
            return stateCode;
        }
        /* ZIP CODE */


        /*         const phoneInputField = document.querySelector("#shipping_phone");
                const phoneInput = window.intlTelInput(phoneInputField, {
                    utilsScript: "https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.8/js/utils.js",
                }); */

        header_cart_count()


        /*  */

        // Declare a global object to store view data.
        var viewData;

        viewData = {};

        $(function() {
            // Update the viewData object with the current field keys and values.
            function updateViewData(key, value) {
                viewData[key] = value;
            }

            // Register all bindable elements
            function detectBindableElements() {
                var bindableEls, bindableElsSelector;

                bindableEls = $('[data-bind]');

                bindableElsSelector = $('[data-bind-selector]');

                // Add event handlers to update viewData and trigger callback event.
                bindableEls.on('change', function() {
                    var $this;

                    $this = $(this);

                    updateViewData($this.data('bind'), $this.val());

                    $(document).trigger('updateDisplay');
                });

                bindableElsSelector.on('change', function() {
                    var $this;

                    $this = $(this);
                    updateViewData($this.data('bind-selector'), $this.find(":selected").text());

                    $(document).trigger('updateDisplay');
                });

                // Add a reference to each bindable element in viewData.
                bindableEls.each(function() {
                    updateViewData($(this));
                });
                bindableElsSelector.each(function() {
                    updateViewData($(this));
                });
            }

            // Trigger this event to manually update the list of bindable elements, useful when dynamically loading form fields.
            $(document).on('updateBindableElements', detectBindableElements);

            detectBindableElements();
        });

        $(function() {
            // An example of how the viewData can be used by other functions.
            function updateDisplay() {
                var updateEls;

                updateEls = $('[data-update]');

                updateEls.each(function() {
                    $(this).html(viewData[$(this).data('update')]);
                });
            }

            // Run updateDisplay on the callback.
            $(document).on('updateDisplay', updateDisplay);
        });
        /*  */
    </script>

</body>

</html>