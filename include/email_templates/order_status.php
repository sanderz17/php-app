<?php
try {
  include_once('../../connect.php');
  cb_logger('email_templete');
  $title = $this->title ?? "New Customer Order";
  $cart_id = $this->cart_id;
  $this->cart = new Cart();
  $cart_details = $this->cart->getCartDetailsFull($cart_id);
  $subtotal = 0;
  $rs_bs   = $this->cart->getData('billing_shipping', "*", 'cart_id=' . (int) $cart_id . ' AND isDelete=0');
  $row_bs   = @mysqli_fetch_assoc($rs_bs);
  $billing_first_name      =  stripslashes($row_bs['billing_first_name']);
  $billing_last_name      =  stripslashes($row_bs['billing_last_name']);
  $billing_email        =  stripslashes($row_bs['billing_email']);
  $billing_phone        =   stripslashes($row_bs['billing_phone']);
  $billing_address      =   stripslashes($row_bs['billing_address']);
  $billing_address2      =   stripslashes($row_bs['billing_address2']);
  $billing_city        =  stripslashes($row_bs['billing_city']);
  $billing_state_code        =  stripslashes($row_bs['billing_state']);
  $billing_state = $this->cart->getValue("states_ex", "name", " id='" . $billing_state_code . "' ");
  $billing_country_code      =  stripslashes($row_bs['billing_country']);
  $billing_country = $this->cart->getValue("countries", "iso2", "id='" . $billing_country_code . "'");
  $billing_zipcode      =  stripslashes($row_bs['billing_zipcode']);

  $shipping_first_name    =  stripslashes($row_bs['shipping_first_name']);
  $shipping_last_name      =  stripslashes($row_bs['shipping_last_name']);
  $shipping_email        =  stripslashes($row_bs['shipping_email']);
  $shipping_phone        = stripslashes($row_bs['shipping_phone']);
  $shipping_address      = stripslashes($row_bs['shipping_address']);
  $shipping_address2    = stripslashes($row_bs['shipping_address2']);
  $shipping_city        =  stripslashes($row_bs['shipping_city']);
  $shipping_state_code        =  stripslashes($row_bs['shipping_state']);
  $shipping_state = $this->cart->getValue("states_ex", "name", " id='" . $shipping_state_code . "' ");
  $shipping_country_code      =  stripslashes($row_bs['shipping_country']);
  $shipping_country = $this->cart->getValue("countries", "iso2", "id='" . $shipping_country_code . "'");
  $shipping_zipcode      =  stripslashes($row_bs['shipping_zipcode']);
} catch (\Throwable $th) {
  cb_logger('email template error!');
  cb_logger($th);
}

?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html>

<head>
  <!-- Compiled with Bootstrap Email version: 1.4.0 -->
  <meta http-equiv="x-ua-compatible" content="ie=edge">
  <meta name="x-apple-disable-message-reformatting">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta name="format-detection" content="telephone=no, date=no, address=no, email=no">
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
  <style type="text/css">
    body,
    table,
    td {
      font-family: Helvetica, Arial, sans-serif !important
    }

    .ExternalClass {
      width: 100%
    }

    .ExternalClass,
    .ExternalClass p,
    .ExternalClass span,
    .ExternalClass font,
    .ExternalClass td,
    .ExternalClass div {
      line-height: 150%
    }

    a {
      text-decoration: none
    }

    * {
      color: inherit
    }

    a[x-apple-data-detectors],
    u+#body a,
    #MessageViewBody a {
      color: inherit;
      text-decoration: none;
      font-size: inherit;
      font-family: inherit;
      font-weight: inherit;
      line-height: inherit
    }

    img {
      -ms-interpolation-mode: bicubic
    }

    table:not([class^=s-]) {
      font-family: Helvetica, Arial, sans-serif;
      mso-table-lspace: 0pt;
      mso-table-rspace: 0pt;
      border-spacing: 0px;
      border-collapse: collapse
    }

    table:not([class^=s-]) td {
      border-spacing: 0px;
      border-collapse: collapse
    }

    @media screen and (max-width: 600px) {

      .w-full,
      .w-full>tbody>tr>td {
        width: 100% !important
      }

      .w-56,
      .w-56>tbody>tr>td {
        width: 224px !important
      }

      .p-lg-4:not(table),
      .p-lg-4:not(.btn)>tbody>tr>td,
      .p-lg-4.btn td a {
        padding: 0 !important
      }

      .p-2:not(table),
      .p-2:not(.btn)>tbody>tr>td,
      .p-2.btn td a {
        padding: 8px !important
      }

      *[class*=s-lg-]>tbody>tr>td {
        font-size: 0 !important;
        line-height: 0 !important;
        height: 0 !important
      }

      .s-2>tbody>tr>td {
        font-size: 8px !important;
        line-height: 8px !important;
        height: 8px !important
      }

      .s-4>tbody>tr>td {
        font-size: 16px !important;
        line-height: 16px !important;
        height: 16px !important
      }

      .s-5>tbody>tr>td {
        font-size: 20px !important;
        line-height: 20px !important;
        height: 20px !important
      }

      .s-6>tbody>tr>td {
        font-size: 24px !important;
        line-height: 24px !important;
        height: 24px !important
      }

      .s-10>tbody>tr>td {
        font-size: 40px !important;
        line-height: 40px !important;
        height: 40px !important
      }
    }
  </style>
</head>

<body class="bg-light" style="outline: 0; width: 100%; min-width: 100%; height: 100%; -webkit-text-size-adjust: 100%; -ms-text-size-adjust: 100%; font-family: Helvetica, Arial, sans-serif; line-height: 24px; font-weight: normal; font-size: 16px; -moz-box-sizing: border-box; -webkit-box-sizing: border-box; box-sizing: border-box; color: #000000; margin: 0; padding: 0; border-width: 0;" bgcolor="#f7fafc">
  <table class="bg-light body" valign="top" role="presentation" border="0" cellpadding="0" cellspacing="0" style="outline: 0; width: 100%; min-width: 100%; height: 100%; -webkit-text-size-adjust: 100%; -ms-text-size-adjust: 100%; font-family: Helvetica, Arial, sans-serif; line-height: 24px; font-weight: normal; font-size: 16px; -moz-box-sizing: border-box; -webkit-box-sizing: border-box; box-sizing: border-box; color: #000000; margin: 0; padding: 0; border-width: 0;" bgcolor="#f7fafc">
    <tbody>
      <tr>
        <td valign="top" style="line-height: 24px; font-size: 16px; margin: 0;" align="left" bgcolor="#f7fafc">
          <table class="s-5 w-full" role="presentation" border="0" cellpadding="0" cellspacing="0" style="width: 100%;" width="100%">
            <tbody>
              <tr>
                <td style="line-height: 20px; font-size: 20px; width: 100%; height: 20px; margin: 0;" align="left" width="100%" height="20">
                  &#160;
                </td>
              </tr>
            </tbody>
          </table>
          <table class="ax-center" role="presentation" align="center" border="0" cellpadding="0" cellspacing="0" style="margin: 0 auto;">
            <tbody>
              <tr>
                <td style="line-height: 24px; font-size: 16px; margin: 0;" align="left">
                  <img class="w-56" src="https://www.clearballistics.com/img/home/CLEAR_new_logo_color_lg.png" alt="Some Image" style="height: auto; line-height: 100%; outline: none; text-decoration: none; display: block; width: 224px; border-style: none; border-width: 0;" width="224">
                </td>
              </tr>
            </tbody>
          </table>
          <table class="container" role="presentation" border="0" cellpadding="0" cellspacing="0" style="width: 100%;">
            <tbody>
              <tr>
                <td align="center" style="line-height: 24px; font-size: 16px; margin: 0; padding: 0 16px;">
                  <!--[if (gte mso 9)|(IE)]>
                      <table align="center" role="presentation">
                        <tbody>
                          <tr>
                            <td width="600">
                    <![endif]-->
                  <table align="center" role="presentation" border="0" cellpadding="0" cellspacing="0" style="width: 100%; max-width: 600px; margin: 0 auto;">
                    <tbody>
                      <tr>
                        <td style="line-height: 24px; font-size: 16px; margin: 0;" align="left">
                          <table class="s-10 w-full" role="presentation" border="0" cellpadding="0" cellspacing="0" style="width: 100%;" width="100%">
                            <tbody>
                              <tr>
                                <td style="line-height: 40px; font-size: 40px; width: 100%; height: 40px; margin: 0;" align="left" width="100%" height="40">
                                  &#160;
                                </td>
                              </tr>
                            </tbody>
                          </table>
                          <table class="card" role="presentation" border="0" cellpadding="0" cellspacing="0" style="border-radius: 6px; border-collapse: separate !important; width: 100%; overflow: hidden; border: 1px solid #e2e8f0;" bgcolor="#ffffff">
                            <tbody>
                              <tr>
                                <td style="line-height: 24px; font-size: 16px; width: 100%; margin: 0;" align="left" bgcolor="#ffffff">
                                  <table class="card-body" role="presentation" border="0" cellpadding="0" cellspacing="0" style="width: 100%;">
                                    <tbody>
                                      <tr>
                                        <td style="line-height: 24px; font-size: 16px; width: 100%; margin: 0; padding: 20px;" align="left">
                                          <table class="s-4 w-full" role="presentation" border="0" cellpadding="0" cellspacing="0" style="width: 100%;" width="100%">
                                            <tbody>
                                              <tr>
                                                <td style="line-height: 16px; font-size: 16px; width: 100%; height: 16px; margin: 0;" align="left" width="100%" height="16">
                                                  &#160;
                                                </td>
                                              </tr>
                                            </tbody>
                                          </table>
                                          <table class="card" role="presentation" border="0" cellpadding="0" cellspacing="0" style="border-radius: 6px; border-collapse: separate !important; width: 100%; overflow: hidden; border: 1px solid #e2e8f0;" bgcolor="#ffffff">
                                            <tbody>
                                              <tr>
                                                <td style="line-height: 24px; font-size: 16px; width: 100%; margin: 0;" align="left" bgcolor="#ffffff">
                                                  <table class="card-body bg-primary" role="presentation" border="0" cellpadding="0" cellspacing="0" style="width: 100%;" bgcolor="#0d6efd">
                                                    <tbody>
                                                      <tr>
                                                        <td style="line-height: 24px; font-size: 16px; width: 100%; margin: 0; padding: 20px;" align="left" bgcolor="#0d6efd">
                                                          <table class="ax-center" role="presentation" align="center" border="0" cellpadding="0" cellspacing="0" style="margin: 0 auto;">
                                                            <tbody>
                                                              <tr>
                                                                <td style="line-height: 24px; font-size: 16px; margin: 0;" align="left">
                                                                  <h1 class="h6 fw-700  text-white" style="color: #ffffff; padding-top: 0; padding-bottom: 0; font-weight: 700 !important; vertical-align: baseline; font-size: 16px; line-height: 19.2px; margin: 0;" align="left">
                                                                    <?php echo $title; ?>
                                                                  </h1>
                                                                </td>
                                                              </tr>
                                                            </tbody>
                                                          </table>
                                                        </td>
                                                      </tr>
                                                    </tbody>
                                                  </table>
                                                </td>
                                              </tr>
                                            </tbody>
                                          </table>
                                          <table class="s-4 w-full" role="presentation" border="0" cellpadding="0" cellspacing="0" style="width: 100%;" width="100%">
                                            <tbody>
                                              <tr>
                                                <td style="line-height: 16px; font-size: 16px; width: 100%; height: 16px; margin: 0;" align="left" width="100%" height="16">
                                                  &#160;
                                                </td>
                                              </tr>
                                            </tbody>
                                          </table>
                                          <table class="card p-2 p-lg-4 space-y-2" role="presentation" border="0" cellpadding="0" cellspacing="0" style="border-radius: 6px; border-collapse: separate !important; width: 100%; overflow: hidden; border: 1px solid #e2e8f0;" bgcolor="#ffffff">
                                            <tbody>
                                              <tr>
                                                <td style="line-height: 24px; font-size: 16px; width: 100%; margin: 0; padding: 16px;" align="left" bgcolor="#ffffff">
                                                  <h1 class="h5 fw-700" style="padding-top: 0; padding-bottom: 0; font-weight: 700 !important; vertical-align: baseline; font-size: 20px; line-height: 24px; margin: 0;" align="left">
                                                    Summary:
                                                  </h1>
                                                  <table class="s-2 w-full" role="presentation" border="0" cellpadding="0" cellspacing="0" style="width: 100%;" width="100%">
                                                    <tbody>
                                                      <tr>
                                                        <td style="line-height: 8px; font-size: 8px; width: 100%; height: 8px; margin: 0;" align="left" width="100%" height="8">
                                                          &#160;
                                                        </td>
                                                      </tr>
                                                    </tbody>
                                                  </table>
                                                  <div class="row" style="margin-right: -24px;">
                                                    <table class="" role="presentation" border="0" cellpadding="0" cellspacing="0" style="table-layout: fixed; width: 100%;" width="100%">
                                                      <tbody>
                                                        <tr>
                                                          <td class="col-4" style="line-height: 24px; font-size: 16px; min-height: 1px; font-weight: normal; padding-right: 24px; width: 33.333333%; margin: 0;" align="left" valign="top">
                                                            <p class="h6 fw-600" style="line-height: 19.2px; font-size: 16px; padding-top: 0; padding-bottom: 0; font-weight: 600 !important; vertical-align: baseline; width: 100%; margin: 0;" align="left">Order #:</p>
                                                            <p style="line-height: 24px; font-size: 16px; width: 100%; margin: 0;" align="left"></p>
                                                          </td>
                                                          <td class="col-8" style="line-height: 24px; font-size: 16px; min-height: 1px; font-weight: normal; padding-right: 24px; width: 75%; margin: 0;" align="left" valign="top">
                                                            <p class="h6 fw-600" style="line-height: 19.2px; font-size: 16px; padding-top: 0; padding-bottom: 0; font-weight: 600 !important; vertical-align: baseline; width: 100%; margin: 0;" align="left"><?php echo $cart_details['orderNumber']; ?></p>
                                                            <p style="line-height: 24px; font-size: 16px; width: 100%; margin: 0;" align="left"></p>
                                                          </td>
                                                        </tr>
                                                      </tbody>
                                                    </table>
                                                  </div>
                                                  <table class="s-2 w-full" role="presentation" border="0" cellpadding="0" cellspacing="0" style="width: 100%;" width="100%">
                                                    <tbody>
                                                      <tr>
                                                        <td style="line-height: 8px; font-size: 8px; width: 100%; height: 8px; margin: 0;" align="left" width="100%" height="8">
                                                          &#160;
                                                        </td>
                                                      </tr>
                                                    </tbody>
                                                  </table>
                                                  <div class="row" style="margin-right: -24px;">
                                                    <table class="" role="presentation" border="0" cellpadding="0" cellspacing="0" style="table-layout: fixed; width: 100%;" width="100%">
                                                      <tbody>
                                                        <tr>
                                                          <td class="col-4" style="line-height: 24px; font-size: 16px; min-height: 1px; font-weight: normal; padding-right: 24px; width: 33.333333%; margin: 0;" align="left" valign="top">
                                                            <p class="h6 fw-600" style="line-height: 19.2px; font-size: 16px; padding-top: 0; padding-bottom: 0; font-weight: 600 !important; vertical-align: baseline; width: 100%; margin: 0;" align="left">Order Date:</p>
                                                            <p style="line-height: 24px; font-size: 16px; width: 100%; margin: 0;" align="left"></p>
                                                          </td>
                                                          <td class="col-8" style="line-height: 24px; font-size: 16px; min-height: 1px; font-weight: normal; padding-right: 24px; width: 75%; margin: 0;" align="left" valign="top">
                                                            <p class="h6 fw-600" style="line-height: 19.2px; font-size: 16px; padding-top: 0; padding-bottom: 0; font-weight: 600 !important; vertical-align: baseline; width: 100%; margin: 0;" align="left"><?php echo date("F j, Y", strtotime($cart_details['orderDate'])); ?></p>
                                                            <p style="line-height: 24px; font-size: 16px; width: 100%; margin: 0;" align="left"></p>
                                                          </td>
                                                        </tr>
                                                      </tbody>
                                                    </table>
                                                  </div>
                                                  <table class="s-2 w-full" role="presentation" border="0" cellpadding="0" cellspacing="0" style="width: 100%;" width="100%">
                                                    <tbody>
                                                      <tr>
                                                        <td style="line-height: 8px; font-size: 8px; width: 100%; height: 8px; margin: 0;" align="left" width="100%" height="8">
                                                          &#160;
                                                        </td>
                                                      </tr>
                                                    </tbody>
                                                  </table>
                                                  <div class="row" style="margin-right: -24px;">
                                                    <table class="" role="presentation" border="0" cellpadding="0" cellspacing="0" style="table-layout: fixed; width: 100%;" width="100%">
                                                      <tbody>
                                                        <tr>
                                                          <td class="col-4" style="line-height: 24px; font-size: 16px; min-height: 1px; font-weight: normal; padding-right: 24px; width: 33.333333%; margin: 0;" align="left" valign="top">
                                                            <p class="h6 fw-600" style="line-height: 19.2px; font-size: 16px; padding-top: 0; padding-bottom: 0; font-weight: 600 !important; vertical-align: baseline; width: 100%; margin: 0;" align="left">Order Total:</p>
                                                            <p style="line-height: 24px; font-size: 16px; width: 100%; margin: 0;" align="left"></p>
                                                          </td>
                                                          <td class="col-8" style="line-height: 24px; font-size: 16px; min-height: 1px; font-weight: normal; padding-right: 24px; width: 75%; margin: 0;" align="left" valign="top">
                                                            <p class="h6 fw-600" style="line-height: 19.2px; font-size: 16px; padding-top: 0; padding-bottom: 0; font-weight: 600 !important; vertical-align: baseline; width: 100%; margin: 0;" align="left"><?php echo '$' . $cart_details['orderTotal'] ?></p>
                                                            <p style="line-height: 24px; font-size: 16px; width: 100%; margin: 0;" align="left"></p>
                                                          </td>
                                                        </tr>
                                                      </tbody>
                                                    </table>
                                                  </div>
                                                  <table class="s-2 w-full" role="presentation" border="0" cellpadding="0" cellspacing="0" style="width: 100%;" width="100%">
                                                    <tbody>
                                                      <tr>
                                                        <td style="line-height: 8px; font-size: 8px; width: 100%; height: 8px; margin: 0;" align="left" width="100%" height="8">
                                                          &#160;
                                                        </td>
                                                      </tr>
                                                    </tbody>
                                                  </table>
                                                  <div class="row" style="margin-right: -24px;">
                                                    <table class="" role="presentation" border="0" cellpadding="0" cellspacing="0" style="table-layout: fixed; width: 100%;" width="100%">
                                                      <tbody>
                                                        <tr>
                                                          <td class="col-4" style="line-height: 24px; font-size: 16px; min-height: 1px; font-weight: normal; padding-right: 24px; width: 33.333333%; margin: 0;" align="left" valign="top">
                                                            <p class="h6 fw-600" style="line-height: 19.2px; font-size: 16px; padding-top: 0; padding-bottom: 0; font-weight: 600 !important; vertical-align: baseline; width: 100%; margin: 0;" align="left">Payment Method:</p>
                                                            <p style="line-height: 24px; font-size: 16px; width: 100%; margin: 0;" align="left"></p>
                                                          </td>
                                                          <td class="col-8" style="line-height: 24px; font-size: 16px; min-height: 1px; font-weight: normal; padding-right: 24px; width: 75%; margin: 0;" align="left" valign="top">
                                                            <p class="h6 fw-600" style="line-height: 19.2px; font-size: 16px; padding-top: 0; padding-bottom: 0; font-weight: 600 !important; vertical-align: baseline; width: 100%; margin: 0;" align="left"><?php echo ucwords(strtolower($cart_details['paymentMethod'])); ?></p>
                                                            <p style="line-height: 24px; font-size: 16px; width: 100%; margin: 0;" align="left"></p>
                                                          </td>
                                                        </tr>
                                                      </tbody>
                                                    </table>
                                                  </div>
                                                </td>
                                              </tr>
                                            </tbody>
                                          </table>
                                          <table class="s-4 w-full" role="presentation" border="0" cellpadding="0" cellspacing="0" style="width: 100%;" width="100%">
                                            <tbody>
                                              <tr>
                                                <td style="line-height: 16px; font-size: 16px; width: 100%; height: 16px; margin: 0;" align="left" width="100%" height="16">
                                                  &#160;
                                                </td>
                                              </tr>
                                            </tbody>
                                          </table>
                                          <div class="row" style="margin-right: -24px;">
                                            <table class="" role="presentation" border="0" cellpadding="0" cellspacing="0" style="table-layout: fixed; width: 100%;" width="100%">
                                              <tbody>
                                                <tr>
                                                  <td class="col-8" style="line-height: 24px; font-size: 16px; min-height: 1px; font-weight: normal; padding-right: 24px; width: 66.666667%; margin: 0;" align="left" valign="top">
                                                    <p class="fw-700 text-left" style="line-height: 24px; font-size: 16px; font-weight: 700 !important; width: 100%; margin: 0;" align="left">ITEMS</p>
                                                  </td>
                                                  <td class="col-2" style="line-height: 24px; font-size: 16px; min-height: 1px; font-weight: normal; padding-right: 24px; width: 16.666667%; margin: 0;" align="left" valign="top">
                                                    <p class="fw-700 text-center" style="line-height: 24px; font-size: 16px; font-weight: 700 !important; width: 100%; margin: 0;" align="center">QTY</p>
                                                  </td>
                                                  <td class="col-2" style="line-height: 24px; font-size: 16px; min-height: 1px; font-weight: normal; padding-right: 24px; width: 16.666667%; margin: 0;" align="left" valign="top">
                                                    <p class="fw-700 text-center" style="line-height: 24px; font-size: 16px; font-weight: 700 !important; width: 100%; margin: 0;" align="center">PRICE</p>
                                                  </td>
                                                </tr>
                                              </tbody>
                                            </table>
                                          </div>
                                          <table class="s-5 w-full" role="presentation" border="0" cellpadding="0" cellspacing="0" style="width: 100%;" width="100%">
                                            <tbody>
                                              <tr>
                                                <td style="line-height: 20px; font-size: 20px; width: 100%; height: 20px; margin: 0;" align="left" width="100%" height="20">
                                                  &#160;
                                                </td>
                                              </tr>
                                            </tbody>
                                          </table>
                                          <table class="hr" role="presentation" border="0" cellpadding="0" cellspacing="0" style="width: 100%;">
                                            <tbody>
                                              <tr>
                                                <td style="line-height: 24px; font-size: 16px; border-top-width: 1px; border-top-color: #e2e8f0; border-top-style: solid; height: 1px; width: 100%; margin: 0;" align="left">
                                                </td>
                                              </tr>
                                            </tbody>
                                          </table>
                                          <table class="s-5 w-full" role="presentation" border="0" cellpadding="0" cellspacing="0" style="width: 100%;" width="100%">
                                            <tbody>
                                              <tr>
                                                <td style="line-height: 20px; font-size: 20px; width: 100%; height: 20px; margin: 0;" align="left" width="100%" height="20">
                                                  &#160;
                                                </td>
                                              </tr>
                                            </tbody>
                                          </table>

                                          <!-- Start Loop Items -->
                                          <?php foreach ($cart_details['items'] as $items) { ?>
                                            <div class="row" style="margin-right: -24px;">
                                              <table class="" role="presentation" border="0" cellpadding="0" cellspacing="0" style="table-layout: fixed; width: 100%;" width="100%">
                                                <tbody>
                                                  <tr>
                                                    <td class="col-2" style="line-height: 24px; font-size: 16px; min-height: 1px; font-weight: normal; padding-right: 24px; width: 16.666667%; margin: 0;" align="left" valign="top">
                                                      <img class="" src="<?php echo $items['imageUrl'] ?>" alt="Generic placeholder image" width="50" style="height: auto; line-height: 100%; outline: none; text-decoration: none; display: block; border-style: none; border-width: 0;">
                                                    </td>
                                                    <td class="col-6" style="line-height: 24px; font-size: 16px; min-height: 1px; font-weight: normal; padding-right: 24px; width: 50%; margin: 0;" align="left" valign="top">
                                                      <p class="fw-700 text-left" style="line-height: 24px; font-size: 16px; font-weight: 700 !important; width: 100%; margin: 0;" align="left"><?php echo $items['name'] ?></p>
                                                    </td>
                                                    <td class="col-2" style="line-height: 24px; font-size: 16px; min-height: 1px; font-weight: normal; padding-right: 24px; width: 16.666667%; margin: 0;" align="left" valign="top">
                                                      <p class="fw-700 text-center" style="line-height: 24px; font-size: 16px; font-weight: 700 !important; width: 100%; margin: 0;" align="center"><?php echo $items['quantity'] ?></p>
                                                    </td>
                                                    <td class="col-2" style="line-height: 24px; font-size: 16px; min-height: 1px; font-weight: normal; padding-right: 24px; width: 16.666667%; margin: 0;" align="left" valign="top">
                                                      <p class="fw-700 text-center text-danger" style="line-height: 24px; font-size: 16px; color: #dc3545; font-weight: 700 !important; width: 100%; margin: 0;" align="center"><?php echo '$' . $items['unitPrice'] ?></p>
                                                    </td>
                                                  </tr>
                                                </tbody>
                                              </table>
                                            </div>
                                            <table class="s-5 w-full" role="presentation" border="0" cellpadding="0" cellspacing="0" style="width: 100%;" width="100%">
                                              <tbody>
                                                <tr>
                                                  <td style="line-height: 20px; font-size: 20px; width: 100%; height: 20px; margin: 0;" align="left" width="100%" height="20">
                                                    &#160;
                                                  </td>
                                                </tr>
                                              </tbody>
                                            </table>
                                            <table class="hr" role="presentation" border="0" cellpadding="0" cellspacing="0" style="width: 100%;">
                                              <tbody>
                                                <tr>
                                                  <td style="line-height: 24px; font-size: 16px; border-top-width: 1px; border-top-color: #e2e8f0; border-top-style: solid; height: 1px; width: 100%; margin: 0;" align="left">
                                                  </td>
                                                </tr>
                                              </tbody>
                                            </table>
                                            <table class="s-5 w-full" role="presentation" border="0" cellpadding="0" cellspacing="0" style="width: 100%;" width="100%">
                                              <tbody>
                                                <tr>
                                                  <td style="line-height: 20px; font-size: 20px; width: 100%; height: 20px; margin: 0;" align="left" width="100%" height="20">
                                                    &#160;
                                                  </td>
                                                </tr>
                                              </tbody>
                                            </table>
                                            <?php $subtotal += $items['quantity'] * $items['unitPrice']; ?>
                                          <?php }; ?>
                                          <!-- End Loop Items -->
                                          <!-- Start Subtotal -->
                                          <div class="row" style="margin-right: -24px;">
                                            <table class="" role="presentation" border="0" cellpadding="0" cellspacing="0" style="table-layout: fixed; width: 100%;" width="100%">
                                              <tbody>
                                                <tr>
                                                  <td class="col-8" style="line-height: 24px; font-size: 16px; min-height: 1px; font-weight: normal; padding-right: 24px; width: 66.666667%; margin: 0;" align="left" valign="top">
                                                    <p class="fw-700 text-right" style="line-height: 24px; font-size: 16px; font-weight: 700 !important; width: 100%; margin: 0;" align="right">Subtotal:</p>
                                                  </td>
                                                  <td class="col-4" style="line-height: 24px; font-size: 16px; min-height: 1px; font-weight: normal; padding-right: 24px; width: 33.333333%; margin: 0;" align="left" valign="top">
                                                    <p class="fw-700 text-left" style="line-height: 24px; font-size: 16px; font-weight: 700 !important; width: 100%; margin: 0;" align="left"><?php echo '$' . $subtotal; ?></p>
                                                  </td>
                                                </tr>
                                              </tbody>
                                            </table>
                                          </div>
                                          <div class="row" style="margin-right: -24px;">
                                            <table class="" role="presentation" border="0" cellpadding="0" cellspacing="0" style="table-layout: fixed; width: 100%;" width="100%">
                                              <tbody>
                                                <tr>
                                                  <td class="col-8" style="line-height: 24px; font-size: 16px; min-height: 1px; font-weight: normal; padding-right: 24px; width: 66.666667%; margin: 0;" align="left" valign="top">
                                                    <p class="fw-700 text-right" style="line-height: 24px; font-size: 16px; font-weight: 700 !important; width: 100%; margin: 0;" align="right">Discount:</p>
                                                  </td>
                                                  <td class="col-4" style="line-height: 24px; font-size: 16px; min-height: 1px; font-weight: normal; padding-right: 24px; width: 33.333333%; margin: 0;" align="left" valign="top">
                                                    <p class="fw-700 text-left" style="line-height: 24px; font-size: 16px; font-weight: 700 !important; width: 100%; margin: 0;" align="left"><?php echo '$' . $cart_details['discount']; ?></p>
                                                  </td>
                                                </tr>
                                              </tbody>
                                            </table>
                                          </div>
                                          <div class="row" style="margin-right: -24px;">
                                            <table class="" role="presentation" border="0" cellpadding="0" cellspacing="0" style="table-layout: fixed; width: 100%;" width="100%">
                                              <tbody>
                                                <tr>
                                                  <td class="col-8" style="line-height: 24px; font-size: 16px; min-height: 1px; font-weight: normal; padding-right: 24px; width: 66.666667%; margin: 0;" align="left" valign="top">
                                                    <p class="fw-700 text-right" style="line-height: 24px; font-size: 16px; font-weight: 700 !important; width: 100%; margin: 0;" align="right">Shipping:</p>
                                                  </td>
                                                  <td class="col-4" style="line-height: 24px; font-size: 16px; min-height: 1px; font-weight: normal; padding-right: 24px; width: 33.333333%; margin: 0;" align="left" valign="top">
                                                    <p class="fw-700 text-left" style="line-height: 24px; font-size: 16px; font-weight: 700 !important; width: 100%; margin: 0;" align="left"><?php echo '$' . $cart_details['shippingAmount']; ?></p>
                                                  </td>
                                                </tr>
                                              </tbody>
                                            </table>
                                          </div>
                                          <div class="row" style="margin-right: -24px;">
                                            <table class="" role="presentation" border="0" cellpadding="0" cellspacing="0" style="table-layout: fixed; width: 100%;" width="100%">
                                              <tbody>
                                                <tr>
                                                  <td class="col-8" style="line-height: 24px; font-size: 16px; min-height: 1px; font-weight: normal; padding-right: 24px; width: 66.666667%; margin: 0;" align="left" valign="top">
                                                    <p class="fw-700 text-right" style="line-height: 24px; font-size: 16px; font-weight: 700 !important; width: 100%; margin: 0;" align="right">Total:</p>
                                                  </td>
                                                  <td class="col-4" style="line-height: 24px; font-size: 16px; min-height: 1px; font-weight: normal; padding-right: 24px; width: 33.333333%; margin: 0;" align="left" valign="top">
                                                    <p class="fw-700 text-left" style="line-height: 24px; font-size: 16px; font-weight: 700 !important; width: 100%; margin: 0;" align="left"><?php echo '$' . $cart_details['orderTotal']; ?></p>
                                                  </td>
                                                </tr>
                                              </tbody>
                                            </table>
                                          </div>
                                          <!-- End Total -->
                                          <table class="s-5 w-full" role="presentation" border="0" cellpadding="0" cellspacing="0" style="width: 100%;" width="100%">
                                            <tbody>
                                              <tr>
                                                <td style="line-height: 20px; font-size: 20px; width: 100%; height: 20px; margin: 0;" align="left" width="100%" height="20">
                                                  &#160;
                                                </td>
                                              </tr>
                                            </tbody>
                                          </table>
                                          <table class="hr" role="presentation" border="0" cellpadding="0" cellspacing="0" style="width: 100%;">
                                            <tbody>
                                              <tr>
                                                <td style="line-height: 24px; font-size: 16px; border-top-width: 1px; border-top-color: #e2e8f0; border-top-style: solid; height: 1px; width: 100%; margin: 0;" align="left">
                                                </td>
                                              </tr>
                                            </tbody>
                                          </table>
                                          <table class="s-5 w-full" role="presentation" border="0" cellpadding="0" cellspacing="0" style="width: 100%;" width="100%">
                                            <tbody>
                                              <tr>
                                                <td style="line-height: 20px; font-size: 20px; width: 100%; height: 20px; margin: 0;" align="left" width="100%" height="20">
                                                  &#160;
                                                </td>
                                              </tr>
                                            </tbody>
                                          </table>
                                          <table class="table thead-default table-bordered bg-gray-100" border="0" cellpadding="0" cellspacing="0" style="width: 100%; max-width: 100%; border: 1px solid #e2e8f0;" bgcolor="#f7fafc">
                                            <tbody>
                                              <tr>
                                                <td style="line-height: 24px; font-size: 16px; margin: 0; padding: 12px; border: 1px solid #e2e8f0;" align="left" bgcolor="#f7fafc" valign="top">
                                                  <p class="fw-700" style="line-height: 24px; font-size: 16px; font-weight: 700 !important; width: 100%; margin: 0;" align="left">Shipping Address:</p>
                                                  <p style="line-height: 24px; font-size: 16px; width: 100%; margin: 0;" align="left"><?php echo "$billing_first_name $billing_last_name"; ?></p>
                                                  <p style="line-height: 24px; font-size: 16px; width: 100%; margin: 0;" align="left"><?php echo "$shipping_address $shipping_address2"; ?></p>
                                                  <p style="line-height: 24px; font-size: 16px; width: 100%; margin: 0;" align="left"><?php echo "$shipping_state, $shipping_zipcode"; ?></p>
                                                  <?php echo "$shipping_phone"; ?> <br>
                                                  <?php echo "$shipping_email"; ?>
                                                </td>
                                                <td style="line-height: 24px; font-size: 16px; margin: 0; padding: 12px; border: 1px solid #e2e8f0;" align="left" bgcolor="#f7fafc" valign="top">
                                                  <p class="fw-700" style="line-height: 24px; font-size: 16px; font-weight: 700 !important; width: 100%; margin: 0;" align="left">Billing Address:</p>
                                                  <p style="line-height: 24px; font-size: 16px; width: 100%; margin: 0;" align="left"><?php echo "$shipping_first_name $shipping_last_name"; ?></p>
                                                  <p style="line-height: 24px; font-size: 16px; width: 100%; margin: 0;" align="left"><?php echo "$billing_address $billing_address2"; ?></p>
                                                  <p style="line-height: 24px; font-size: 16px; width: 100%; margin: 0;" align="left"><?php echo "$billing_state, $billing_zipcode"; ?></p>
                                                  <?php echo "$billing_phone"; ?> <br>
                                                  <?php echo "$billing_email"; ?>
                                                </td>
                                              </tr>
                                            </tbody>
                                          </table>
                                          <table class="s-6 w-full" role="presentation" border="0" cellpadding="0" cellspacing="0" style="width: 100%;" width="100%">
                                            <tbody>
                                              <tr>
                                                <td style="line-height: 24px; font-size: 24px; width: 100%; height: 24px; margin: 0;" align="left" width="100%" height="24">
                                                  &#160;
                                                </td>
                                              </tr>
                                            </tbody>
                                          </table>
                                          <div class="row" style="margin-right: -24px;">
                                            <table class="" role="presentation" border="0" cellpadding="0" cellspacing="0" style="table-layout: fixed; width: 100%;" width="100%">
                                              <tbody>
                                                <tr>
                                                  <td class="col-12" style="line-height: 24px; font-size: 16px; min-height: 1px; font-weight: normal; padding-right: 24px; width: 100%; margin: 0;" align="left" valign="top">
                                                    <p class="text-center" style="line-height: 24px; font-size: 16px; width: 100%; margin: 0;" align="center">Clear Ballistics | See What You Shoot | <a href="https://clearballistics.com/wp-content/uploads/2016/11/Instructions_4x6postcard_verB_Metal_and_Plastic.pdf" style="color: #0d6efd;">Melting Instructions </a> </p>
                                                  </td>
                                                </tr>
                                              </tbody>
                                            </table>
                                          </div>
                                          <table class="s-0 w-full" role="presentation" border="0" cellpadding="0" cellspacing="0" style="width: 100%;" width="100%">
                                            <tbody>
                                              <tr>
                                                <td style="line-height: 0; font-size: 0; width: 100%; height: 0; margin: 0;" align="left" width="100%" height="0">
                                                  &#160;
                                                </td>
                                              </tr>
                                            </tbody>
                                          </table>
                                          <table class="hr" role="presentation" border="0" cellpadding="0" cellspacing="0" style="width: 100%;">
                                            <tbody>
                                              <tr>
                                                <td style="line-height: 24px; font-size: 16px; border-top-width: 1px; border-top-color: #e2e8f0; border-top-style: solid; height: 1px; width: 100%; margin: 0;" align="left">
                                                </td>
                                              </tr>
                                            </tbody>
                                          </table>
                                          <table class="s-0 w-full" role="presentation" border="0" cellpadding="0" cellspacing="0" style="width: 100%;" width="100%">
                                            <tbody>
                                              <tr>
                                                <td style="line-height: 0; font-size: 0; width: 100%; height: 0; margin: 0;" align="left" width="100%" height="0">
                                                  &#160;
                                                </td>
                                              </tr>
                                            </tbody>
                                          </table>
                                          <div class="row" style="margin-right: -24px;">
                                            <table class="" role="presentation" border="0" cellpadding="0" cellspacing="0" style="table-layout: fixed; width: 100%;" width="100%">
                                              <tbody>
                                                <tr>
                                                  <td class="col-12" style="line-height: 24px; font-size: 16px; min-height: 1px; font-weight: normal; padding-right: 24px; width: 100%; margin: 0;" align="left" valign="top">
                                                    <p class="text-center" style="line-height: 24px; font-size: 16px; width: 100%; margin: 0;" align="center">888.271.0461 &#8211; 110 Augusta Arbor Way,
                                                      Greenville, SC 29605</p>
                                                  </td>
                                                </tr>
                                              </tbody>
                                            </table>
                                          </div>
                                        </td>
                                      </tr>
                                    </tbody>
                                  </table>
                                </td>
                              </tr>
                            </tbody>
                          </table>
                          <table class="s-10 w-full" role="presentation" border="0" cellpadding="0" cellspacing="0" style="width: 100%;" width="100%">
                            <tbody>
                              <tr>
                                <td style="line-height: 40px; font-size: 40px; width: 100%; height: 40px; margin: 0;" align="left" width="100%" height="40">
                                  &#160;
                                </td>
                              </tr>
                            </tbody>
                          </table>
                        </td>
                      </tr>
                    </tbody>
                  </table>
                  <!--[if (gte mso 9)|(IE)]>
                    </td>
                  </tr>
                </tbody>
              </table>
                    <![endif]-->
                </td>
              </tr>
            </tbody>
          </table>
        </td>
      </tr>
    </tbody>
  </table>
</body>

</html>