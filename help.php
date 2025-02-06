<?php
    include "connect.php";
?>
<!DOCTYPE html>
<html>
    <head>
        <title>Homepage | Help</title>
        <?php include 'front_include/css.php'; ?>
    </head>
    <body>
        <?php include 'front_include/header.php'; ?>
        <!--  header section start -->
        <section class="help-product-header-images">
            <div class="help-product-hero" style="background-image:url('<?php echo SITEURL; ?>img/home/help_page.png')">
                <div class="help-overlay"></div>
                <div class="help-container text-center">
                    <h3>help guide </h3></br>
                    <p>NEW TO OUR SITE? NO WORRIES. YOU’RE IN THE RIGHT SPOT.  </p>
                </div>
            </div>
        </section>
        <!-- header section end -->

        <!-- contact-page-section start-->
        <section class="help-contact_page-address">
            <div class="container">
                <div class="row">
                    <div class="col-md-4">
                        <div class="help-contact_page-address-box">
                            <h3>GENERAL</h3><hr>
                            <p><a href="<?php echo SITEURL; ?>faq/">FAQ</a></p>
                            <p><a href="<?php echo SITEURL; ?>contact/">CONTACT US</a></p>
                            <p><a href="<?php echo SITEURL; ?>shipping-returns/">SHIPPING & RETURNS</a></p>
                            <p><a href="<?php echo SITEURL; ?>profile/">YOUR ACCOUNT </a></p>
                            <p><a href="<?php echo SITEURL; ?>order-tracking/">ORDER STATUS </a></p>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="help-contact_page-address-box">
                            <h3>PRODUCT INFO </h3><hr>
                            <p><a href="<?php echo SITEURL; ?>10vs20-gelatin/">10% VS. 20% GELATIN </a></p>
                            <p><a href="<?php echo SITEURL; ?>remelting-instruction/">REMELTING INSTRUCTIONS </a></p>
                            <p><a href="<?php echo SITEURL; ?>img/MSDS-Clear-Ballistics.pdf" download>MSDS </a></p>
                            <p><a href="javascript:;">CALIBRATION CARD </a></p>
                            <p><a href="<?php echo SITEURL; ?>news/">NEWS </a></p>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="help-contact_page-address-box">
                            <h3>RETAILERS & PARTNERS</a></h3><hr>  
                            <p><a href="<?php echo SITEURL; ?>our-partners/">OUR PARTNERS </a></p>
                            <p><a href="<?php echo SITEURL; ?>our-retailers/">OUR RETAILERS </a></p>
                            <p><a href="<?php echo SITEURL; ?>marketing-requests/">MARKETING REQUEST </a></p>
                            <p><a href="<?php echo SITEURL; ?>gvt-quote/">GOVERNMENT QUOTE </a> </p>
                            <p><a href="<?php echo SITEURL; ?>video/">VIDEOS </a> </p>
                        </div>
                    </div>
                </div>
            
            <div class="help-button-section">
                <h2 class="help-last-text">NEED SOMETHING ELSE?</h2>
                <a href="<?php echo SITEURL; ?>contact/" class="help-contact-link">CONTACT US</a>
            </div>
            </div>
        </section>

        <!-- contact-page-section end-->
        <?php include 'front_include/footer.php'; ?>
        <?php include 'front_include/js.php'; ?>
        <script type="text/javascript">
            $('.loader').hide();
            
            $("#ContactForm").validate({
                rules: {
                    first_name:{required : true,email: true},
                    last_name:{required : true},
                    email:{required : true, email: true},
                    password:{required : true, minlength:8, maxlength:32},
                },
                messages: {
                    first_name:{required:"Please enter first name."},
                    last_name:{required:"Please enter last name."},
                    email:{required:"Please enter email.", email:"Please enter a valid username."},
                    password:{required:"Please enter password.", minlength:"Enter at least 8 characters.", maxlength:"No more than 32 characters allow."},
                }, 
                errorPlacement: function (error, element) 
                {
                    error.insertAfter(element);
                }
            });
            
        </script>
    </body>
</html>