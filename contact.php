<?php
include "connect.php";
?>
<!DOCTYPE html>
<html>

<head>
    <title>Homepage | Contact</title>
    <?php include 'front_include/css.php'; ?>
</head>

<body>
    <?php include 'front_include/header.php'; ?>
    <!--  header section start -->
    <section class="product-header-images">
        <div class="product-hero contact-hero-image" style="background-image:url('<?php echo SITEURL; ?>img/contact-bg.png')">
            <div class="overlay"></div>
            <div class="container">
                <h3>Contact Clear Ballistics </h3>
                <p>Welcome to Clear Ballistics, a leading clear synthetic ballistics gelatin manufacturing company providing professional grade products for testing, investigating, and a variety of other applications and purposes. </p>
            </div>
        </div>
    </section>
    <!-- header section end -->
    <!-- contact-page-section start-->
    <section class="contact-section-main">
        <div class="container">
            <div class="contact-section-main-link">
                <div class="row text-nowrap">
                    <div class="col-lg-3 col-md-6">
                        <div class="contact-us-page__link">
                            <div class="icon">
                                <img src="<?php echo SITEURL; ?>img/icon/icon-faq.svg">
                            </div>
                            <p class="contact-us-page__link-title">Product FAQs</p>
                            <a class="button-transparent-bg contact-us-page__link-button" href="<?php echo SITEURL ?>faq/">FIND ANSWERS NOW</a>
                        </div>
                    </div>
                    <div class="col-lg-2 col-md-6">
                        <div class="contact-us-page__link">
                            <div class="icon">
                                <img src="<?php echo SITEURL; ?>img/icon/icon-shipping.svg">
                            </div>
                            <p class="contact-us-page__link-title">Shipping & Returns</p>
                            <a class="button-transparent-bg contact-us-page__link-button" href="<?php echo SITEURL; ?>shipping-returns/">LEARN MORE</a>
                        </div>
                    </div>
                    <div class="col-lg-2 col-md-6">
                        <div class="contact-us-page__link">
                            <div class="icon">
                                <img src="<?php echo SITEURL; ?>img/icon/icon-warranty.svg">
                            </div>
                            <p class="contact-us-page__link-title">Warranty</p>
                            <a class="button-transparent-bg contact-us-page__link-button" href="<?php echo SITEURL ?>about/">LEARN MORE</a>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-6">
                        <div class="contact-us-page__link">
                            <div class="icon">
                                <img src="<?php echo SITEURL; ?>img/icon/200028-Privacy-Inquiry-Icon.svg">
                            </div>
                            <p class="contact-us-page__link-title">Privacy Inquiry</p>
                            <a class="button-transparent-bg contact-us-page__link-button" href="<?php echo SITEURL; ?>privacy-policy/">SUBMIT REQUEST</a>
                        </div>
                    </div>
                    <div class="col-lg-2 col-md-6">
                        <div class="contact-us-page__link">
                            <div class="icon">
                                <img src="<?php echo SITEURL; ?>img/icon/icon-quote.svg">
                            </div>
                            <p class="contact-us-page__link-title">QUOTE</p>
                            <a class="button-transparent-bg contact-us-page__link-button" href="<?php echo SITEURL; ?>custom-form/">GET A QUOTE</a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="page-with-heading">
                <h2 class="page-title text-center">STILL CAN'T FIND WHAT<br>
                    YOU'RE LOOKING FOR?
                </h2>
                <div class="find-button">
                    <a class="button-transparent-bg contact-us-page__link-button" href="mailto:<?php echo SITEMAIL; ?>">SEND US AN EMAIL</a>
                </div>
            </div>
        </div>
    </section>
    <section class="contact_page-address">
        <div class="container">
            <div class="row">
                <div class="col-md-4">
                    <div class="contact_page-address-box">
                        <h3>Customer Service Team</h3>
                        <p>ClearBallistics.com general inquiries,
                        <p>
                        <p>product questions or info </p>
                        <p><a href="<?php echo SITEURL; ?>contact-form/">Email Customer Service</a> </p>
                        <p> 8:00 AM – 6:00 PM EST </p>
                        <p><a href="tel:1-888-271-0461">1-888-271-0461 </a> </p>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="contact_page-address-box">
                        <h3>Corporate Office </h3>
                        <p>110 Augusta Arbor Way Suite B
                        <p>
                        <p>Greenville, SC 29605 </p>
                        <p>info@clearballistics.com </p>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="contact_page-address-box">
                        <h3>Corporate Sales Team </h3>
                        <p>Business to Business
                        <p>
                        <p><a href="<?php echo SITEURL; ?>custom-form"> Request a Quote </a> </p>
                        <p><a href="tel:1-888-271-0461">1-888-271-0461 </a> </p>
                    </div>
                </div>
            </div>
        </div>
    </section>


    <div class="contact-us-social_icon">
        <h3 class="text-center mb-3">Connect With Us</h3>
        <ul class="contact-us-social_icon-list">
            <li><a href="#"><i class="fa fa-facebook"></i></a></li>
            <li> <a href="https://twitter.com/ClearBallistics">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512" style="width: 1em;height: 1em;vertical-align: -0.125em;"><!--!Font Awesome Free 6.5.1 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free Copyright 2024 Fonticons, Inc.-->
                        <path fill="#1d1441" d="M389.2 48h70.6L305.6 224.2 487 464H345L233.7 318.6 106.5 464H35.8L200.7 275.5 26.8 48H172.4L272.9 180.9 389.2 48zM364.4 421.8h39.1L151.1 88h-42L364.4 421.8z" />
                    </svg>
                </a>
            </li>
            <li><a href="#"><i class="fa fa-instagram"></i></a></li>
        </ul>
    </div>



    <!-- contact-page-section end-->
    <?php include 'front_include/footer.php'; ?>
    <?php include 'front_include/js.php'; ?>
    <script type="text/javascript">
        $('.loader').hide();

        $("#ContactForm").validate({
            rules: {
                first_name: {
                    required: true,
                    email: true
                },
                last_name: {
                    required: true
                },
                email: {
                    required: true,
                    email: true
                },
                password: {
                    required: true,
                    minlength: 8,
                    maxlength: 32
                },
            },
            messages: {
                first_name: {
                    required: "Please enter first name."
                },
                last_name: {
                    required: "Please enter last name."
                },
                email: {
                    required: "Please enter email.",
                    email: "Please enter a valid username."
                },
                password: {
                    required: "Please enter password.",
                    minlength: "Enter at least 8 characters.",
                    maxlength: "No more than 32 characters allow."
                },
            },
            errorPlacement: function(error, element) {
                error.insertAfter(element);
            }
        });
    </script>
</body>

</html>