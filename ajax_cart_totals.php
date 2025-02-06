<?php
include "connect.php";

$cart_id = 0;

if (isset($_SESSION[SESS_PRE . '_SESS_CART_ID']) && $_SESSION[SESS_PRE . '_SESS_CART_ID'] > 0) {
    $cart_id = $_SESSION[SESS_PRE . '_SESS_CART_ID'];
    cb_logger(json_encode($_SESSION));
}

$cart_d = $db->getData("cart", "*", "isDelete=0 AND order_status<>2 AND id=" . $cart_id);
$cart_r = mysqli_fetch_assoc($cart_d);
$cart_subtotal = $cart_r['sub_total'];
?>
<div class="card mt-3 mt-md-0 mb-4 p-3 p-md-4 border-0">
    <div class="row">
        <div class="col-lg-12">
            <h3 class="mb-3">ORDER SUMMARY</h3>
            <div class="row mb-3">
                <div class="col-6 pr-0">
                    <h6>Shipping Cost</h6>
                </div>
                <div class="col-6 pl-0">
                    <h6 class="text-right shipping-cost"><?php echo CUR . number_format($cart_r['shipping'], 2); ?></h6>
                </div>
            </div>
            <div class="row mb-3">
                <div class="col-6 pr-0">
                    <h6>Sales Tax</h6>
                </div>
                <div class="col-6 pl-0">
                    <h6 class="text-right shipping-cost">-</h6>
                </div>
            </div>
            <div class="row mb-3">
                <div class="col-6 pr-0">
                    <h6>Discount</h6>
                </div>
                <div class="col-6 pl-0">
                    <h6 class="text-right shipping-cost <?php echo $cart_r['discount'] > 0 ? 'text-success': "" ?>"><?php echo $cart_r['discount'] > 0 ? CUR . "-" . number_format($cart_r['discount'], 2) . "<i class='fa fa-times text-danger' aria-hidden='true' style='margin-left: 10px;' onclick='Remove_Coupon($cart_id,$cart_subtotal);'></i>": "-" ?></h6>
 
                </div>
            </div>
            <hr>
            <div class="row mb-3">
                <div class="col-6 pr-0">
                    <h5>Estimated Total</h5>
                </div>
                <div class="col-6 pl-0">
                    <h5 class="text-right shipping-cost"><?php echo CUR . number_format($cart_r['grand_total'], 2); ?></h5>
                </div>
            </div>
            <div class="row mb-3">
                <div class="col-12">
                    <a class="btn bg_yeti text-white w-100 text-center py-3 font-stratum-web-black" href="<?php echo SITEURL; ?>checkout/" style="font-size: 1rem;"> CHECKOUT</a>
                </div>
            </div>
            <div class="row mb-3">
                <div class="col-12 text-center">
                    <a href="<?php echo SITEURL; ?>/product/ballistics-gel" style="text-decoration: underline;" class="text-dark text-center font-stratum-web-black">
                        <span style="font-size: 1rem;">CONTINUE SHOPPING</span>
                    </a>
                </div>
            </div>
            <div class="">
                <div id="accordion" class="accordion">
                    <div class="card mb-0 border-right-0 border-left-0">
                        <div class="card-header bg-white border-bottom-0 collapsed" data-toggle="collapse" href="#collapseOne">
                            <a class="card-title text-muted">
                                <h6>PROMO CODE</h6>
                            </a>
                        </div>
                        <div id="collapseOne" class="card-body p-0 collapse" data-parent="#accordion">
                            <div class="ps-promocode-section font-stratum-web-black">
                                <div class="row p-3">
                                    <div class="col-6">
                                        <div class="ps-promocode-section-left-side">
                                            <input type="text" class="form-control shadow-none font-stratum-web-reg" name="promo_code_input" id="promo_code_input" placeholder="Enter Promo Code ">
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
            <div class="row">
                <div class="col-12">
                    <div class="d-flex justify-content-around px-xl-4 pt-4 text-center">
                        <div class="product-detail-proposition-container">
                            <div class="product-detail-proposition-icon"><img src="<?php echo SITEURL; ?>img/free-shipping-icon.svg"></div>
                            <a class="product-detail-proposition-link" href="<?php echo SITEURL; ?>shipping-returns">Fast Shipping</a>
                        </div>
                        <div class="product-detail-proposition-container">
                            <div class="product-detail-proposition-icon"><img src="<?php echo SITEURL; ?>img/free-returns-icon.svg"></div>
                            <a class="product-detail-proposition-link" href="<?php echo SITEURL; ?>shipping-returns">Easy Returns </a>
                        </div>
                        <div class="product-detail-proposition-container">
                            <div class="product-detail-proposition-icon"><img src="<?php echo SITEURL; ?>img/warranty-icon.svg"></div>
                            <!-- <a class="product-detail-proposition-link" href="<?php echo SITEURL; ?>shipping-returns">Bulletproof Guarantee </a> -->
                            <a class="product-detail-proposition-link" href="<?php echo SITEURL; ?>bulletproof-guarantee">Price Match Guarantee</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- <tr class="cart-subtotal">
    <th>Shipping Cost:</th>
    <td>
        <span>
            <b><?php echo CUR . $cart_r['sub_total']; ?></b>
        </span>
    </td>
</tr>
<tr>
    <th>
        SALES TAX:
    </th>
    <td>
        <span class="cfw-small">-</span>
    </td>
</tr> -->
<?php if (!empty($cart_r['coupon_code'])) {
    /*     $cart_total_val = $cart_r['grand_total'];
    $discount = 0;
    $grand_total = 0;
    if ($coupon_r['type'] == "percent") {
        $discount = ($cart_total_val * $coupon_r['amount']) / 100;
        $grand_total = $cart_total_val - $discount;
    } elseif ($coupon_r['type'] == "flat") {
        $discount = $coupon_r['amount'];
        $grand_total = $cart_total_val - $coupon_r['amount'];
    } elseif ($coupon_r['type'] == "full") {
        $discount = $cart_total_val - 1;
        $grand_total = $cart_total_val - $discount;
    }

    $coupon_arr = array(
        "discount_type" => $coupon_r['type'],
        // "discount"		=> number_format($discount ,2),
        "discount"        => $discount,
        "coupon_id"        => $coupon_r['id'],
        "coupon_code"    => $coupon_r['code'],
        //"grand_total"	=> number_format($grand_total,2),
        "grand_total"    => $grand_total,
    );
    $db->update("cart", $coupon_arr, "id=" . $cart_id);
    $cart_r['discount'] = $discount;
    $cart_r['grand_total'] = $grand_total; */
?>

    <!--     <tr>
        <th>
            <span class="cfw-small">
                 <?php //echo $db->getValue("coupon", "name", "id=" . $cart_r['coupon_id']); 
                    ?> 
    DISCOUNT:
    </span>
    </th>
    <td>
        <span class="cfw-small">- <bdi><?php //echo CUR . $cart_r['discount']; 
                                        ?></bdi><i class="fa fa-times" aria-hidden="true" style="margin-left: 10px;" onclick="Remove_Coupon('<?php //echo $cart_id 
                                                                                                                                                                                    ?>','<?php //echo $cart_r['sub_total'] 
                                                                                                                                                                                                                ?>');"></i></span>
    </td>
    </tr> -->
<?php } ?>
<!-- <tr class="order-total pb-4">
    <th>CART TOTAL</th>
    <td>
        <strong>
            <span>
                <bdi><?php echo CUR . number_format($cart_r['grand_total'], 2); ?></bdi>
            </span>
        </strong>
    </td>
</tr> -->

<script type="text/javascript">
    function Remove_Coupon(cart_id, sub_val) {
        $(".loader").show();
        $.ajax({
            url: "<?php echo SITEURL ?>checkout_db.php",
            type: "POST",
            data: {
                mode: "coupon_remove",
                cart_id: cart_id,
                sub_val: sub_val,
            },
            success: function(val) {
                $(".loader").hide();
                $.notify({
                    message: "Coupon removed successfully."
                }, {
                    type: "success"
                });
                cart_totals();
            },
        });
    }
</script>