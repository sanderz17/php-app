<?php
include "connect.php";
$cart_id = $_SESSION[SESS_PRE . '_SESS_CART_ID'];
?>
<!DOCTYPE html>
<html>

<head>
    <title>Homepage | Cart</title>
    <?php include 'front_include/css.php'; ?>
</head>

<body>
    <?php include 'front_include/header.php'; ?>
    <div class="loader"></div>
    <!--  header section start -->
    <section class="product-header-images">

    </section>
    <!-- header section end -->
    <!-- sign_in-page-section start-->
    <?php if ($cart_id) { ?>
        <div class="ps-section--shopping">
            <div class="section-header mb-2">
                <div class="alert alert-warning" role="alert">
                    <h5 class="alert-heading">NOTICE:</h5>
                    <p>The FBI Mold included in our kits is currently on backorder. Domestic orders will ship without the mold, which will follow separately once restocked. International orders will ship once the mold is available. Thank you for your patience.</p>
                </div>
                <h3>YOUR CART</h3>
                <p>Great choice. But remember, putting an item in your cart doesn't hold it. Check out now before it's gone.</p>
            </div>
            <div class="container-fluid p-0">
                <div class="row">
                    <div class="col-12 col-md-12 col-lg-8">
                        <div id="cart_detail_result" class="font-stratum-web-black"></div>
                        <!-- Compatible product start  -->
                        <section class="compatible-section Bought_Section">
                            <div class="container-fluid">
                                <div class="section-header text-center">
                                    <h3>Bought Together</h3>
                                </div>
                                <div class="compatible-slider">
                                    <?php
                                    $bought_d = $db->getData("product", "*", "isDelete=0");
                                    while ($bought_r = mysqli_fetch_assoc($bought_d)) {
                                    ?>
                                        <div class="slick-slide">
                                            <?php
                                            $src = SITEURL . "img/product/" . $bought_r['image'];
                                            if (!file_exists($src) && $src == "") {
                                                $src = SITEURL . "img/default.png";
                                            } else {
                                                $src = SITEURL . "img/product/" . $bought_r['image'];
                                            }
                                            ?>
                                            <!-- <a href="<?php echo SITEURL ?>product-details/<?php echo $bought_r['id']; ?>"><img src="<?php echo $src; ?>"></a> -->
                                            <a href="<?php echo SITEURL ?>shop/<?php echo $bought_r['slug']; ?>"><img src="<?php echo $src; ?>"></a>
                                            <h3><?php echo $bought_r['name']; ?></h3>
                                            <div class="product-pricing text-center">
                                                <span class="product-sales-price" title="product-sales-pricee"><?php echo CURR . $bought_r['price']; ?> </span>
                                            </div>
                                            <div class="product-actions">
                                                <a class="btn add-to-cart-btn" href="js:void();" onclick="add_to_cart(<?php echo $bought_r['id']; ?>,<?php echo $bought_r['price']; ?>);">Add To Cart</a>
                                            </div>
                                        </div>
                                    <?php
                                    }
                                    ?>
                                </div>
                            </div>
                        </section>
                        <!-- Compatible product end -->
                    </div>
                    <div class="col-lg-4 col-md-12">
                        <div id="tbody_totals"></div>

                    </div>
                    <div class="col-12">

                    </div>
                </div>
            </div>
            <div class="col-lg-4 col-md-12" style="display: none;">
                <div class="ps-form__total">
                    <div class="ps-block__content">
                        <div id="cfw-totals-list" class="cfw-module">

                            <table class="cfw-module">

                                <tbody id="tbody_totals"></tbody>

                            </table>
                            <div class="check_out">
                                <?php
                                $cart_id = 0;

                                if (isset($_SESSION[SESS_PRE . '_SESS_CART_ID']) && $_SESSION[SESS_PRE . '_SESS_CART_ID'] > 0) {
                                    $cart_id = $_SESSION[SESS_PRE . '_SESS_CART_ID'];
                                }
                                $where = "cd.isDelete=0 AND p.isDelete=0 AND cd.cart_id=" . $cart_id;
                                $join = " LEFT JOIN product p ON p.id = cd.product_id";
                                $rows = "cd.price, cd.sub_total, cd.qty, cd.id, p.name, p.image";
                                $cart_data = $db->getJoinData2("cart_detail cd", $join, $rows, $where);

                                $checkout_btn = "";
                                if (@mysqli_num_rows($cart_data) > 0) {
                                    $checkout_btn = "";
                                } else {
                                    $checkout_btn = "pointer-events: none;";
                                }
                                ?>
                                <a class="ps-btn w-100 text-center py-3" href="<?php echo SITEURL; ?>checkout/" style="<?= $checkout_btn; ?>"> CHECKOUT</a>
                                <a class="ps-btn w-100 text-center py-3" href="<?php echo SITEURL; ?>"> KEEP SHOPPING</a>
                            </div>
                        </div>
                        <div class="cart-reassurance-wrapper">
                            <div class="cart-reassurance">
                                <div class="cart-reassurance-icon">
                                    <img src="<?php echo SITEURL; ?>img/icon/free-returns-icon.svg">
                                </div>
                                <div class="cart-reassurance-content">
                                    <h4>RETURNS </h4>
                                    <p>Not satisfied? Returns for a full refund within 30 days. <a href="<?php echo SITEURL ?>shipping-returns/">Click here for details.</a>
                                    <p>
                                </div>
                            </div>
                            <div class="cart-reassurance">
                                <div class="cart-reassurance-icon">
                                    <img src="<?php echo SITEURL; ?>img/icon/need-help.png">
                                </div>
                                <div class="cart-reassurance-content">
                                    <h4>NEED hELP ? </h4>
                                    <p>Call us at <a href="tel:<?php echo SITEPHONE ?>"><?php echo SITEPHONE ?></a> MF or send us a message.
                                    <p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>

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

    </div>
    </div>
    <!--     <div class="col-lg-4 col-md-12">
            <h5>ORDER SUMMARY</h5>
            <div class="row mb-4">
                <div class="col-6">
                    <h6>Shipping Cost</h6>
                </div>
                <div class="col-6">
                <span>$78.98</span>
                </div>
            </div>
        </div> -->
    <!-- sign_in-page-section end-->
    <?php include 'front_include/footer.php'; ?>
    <?php include 'front_include/js.php'; ?>
    <script type="text/javascript">
        $('.loader').hide();
    </script>
</body>

</html>

<script type="text/javascript">
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
                }
                cart_totals();
            },
        });
    }

    function add_to_cart(product_id, price) {
        $.ajax({
            url: '<?php echo SITEURL; ?>product_db.php',
            method: 'post',
            data: 'mode=add_general&product_id=' + product_id + '&price=' + price,
            beforeSend: function() {
                $(".loader").show();
                header_cart_count();
            },
            success: function(res) {
                $(".loader").hide();
                header_cart_count();
                window.location = '<?php echo SITEURL; ?>cart/';
            }
        });
    }
</script>
<style>
    .item-header,
    .item-stock-status,
    .cart-font {
        /* font-family: LTCSquareFaceW00-SC !important; */
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

    .card {
        border-radius: .5rem !important;
    }

    .bg_yeti {
        background: #002b45;
    }

    .btn_yeti:hover {
        background: #002b45;
        color: white;
    }
</style>