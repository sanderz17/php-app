<?php
    include "connect.php";
    if (isset($_POST['track_button'])) 
    {
        $track_orderNumber  = $db->clean($_REQUEST['track_orderNumber']);
        $track_email        = $db->clean($_REQUEST['track_email']);
        $track_zipcode      = $db->clean($_REQUEST['track_zipcode']);
        $user_id            = $_SESSION[SESS_PRE.'_SESS_USER_ID'];

        if (!empty($track_orderNumber) && $track_orderNumber != "" && !empty($track_email) && $track_email != "") 
        {
            $order_data = $db->getData("cart","*","order_no='".$track_orderNumber."' AND isDelete=0 ","",0);
            $order_row = mysqli_fetch_assoc($order_data);

            if ($order_row>0) {
                if (@mysqli_num_rows($order_data) > 0){    
                    // $db->location(SITEURL."order-status/".md5($order_row['id']));
                    $db->location(SITEURL."order-status.php?order_no=".$order_row['order_no']);
                    $order_row = json_encode($order_row);
                }
            }
            else{
                $_SESSION['MSG'] = 'INVALID_DATA';
                //$db->location(SITEURL."order-tracking/");
            }

        }
        else
        {
            $_SESSION['MSG'] = 'FILL_ALL_DATA';
            //$db->location(SITEURL."order-tracking/");
        }
    }
?>
<!DOCTYPE html>
<html>
    <head>
        <title>Homepage | Order Tracking</title>
        <?php include 'front_include/css.php'; ?>
    </head>
    <body>
        <?php include 'front_include/header.php'; ?>
        <!--  header section start -->
        <section class="product-header-images">
        </section>
        <!-- header section end -->
        <!-- Faq Page Section start-->
        <section class="track-section">
            <div class="track-section-header track-text-center">
                <h1>ORDER TRACKING</h1>
            </div>
        </section>
        <section class="track-section-form">
            <div class="container">
            <h3>SEE YOUR ORDER EVEN IF YOU ARE NOT A REGISTERED USER. ENTER THE ORDER NUMBER, THE EMAIL ADDRESS FROM THE ORDER, AND THE BILLING ADDRESS ZIP CODE.</h3>
            <form class="row g-3" id="OrderTrackForm" name="OrderTrackForm" method="post">
                <div class="col-md-12 track-input">
                    <label for="inputPassword4" class="form-label">ORDER NUMBER*</label>
                    <input type="text" class="form-control" name="track_orderNumber" id="track_orderNumber">
                </div>
                <div class="col-md-12 track-input">
                    <label for="inputEmail4" class="form-label">ORDER EMAIL*</label>
                    <input type="text" class="form-control" id="track_email" name="track_email">
                </div>
                <div class="col-12 track-input">
                    <label for="inputAddress2" class="form-label">BILLING ZIP CODE</label>
                    <input type="text" class="form-control" id="track_zipcode" name="track_zipcode">
                </div>
                <div class="col-2 track-submit-btn">
                    <input type="submit" class="form-control" id="track_button" name="track_button" value="CHECK STATUS"></input>
                </div>
            </form>
            </div>
        </section>
        <!-- Faq Page Section End-->
        <?php include 'front_include/footer.php'; ?>
        <?php include 'front_include/js.php'; ?>
        <script></script>

        <script type="text/javascript">
            
            $("#OrderTrackForm").validate({
                rules:{
                    track_orderNumber: {required:true},
                    track_email: {required:true}
                },
                messages:{
                    track_orderNumber: {required:"Please enter order number."},
                    track_email: {required:"Please enter email address."}
                },
                errorPlacement: function (error, element) 
                {
                    error.insertAfter(element);
                }
            });

        </script>

    </body>
</html>

