<?php
    include "connect.php";
    if (isset($_SESSION[SESS_PRE.'_SESS_USER_ID']) && $_SESSION[SESS_PRE.'_SESS_USER_ID'] != "") {
    	$db->location(SITEURL);
    }
    ?>
<!DOCTYPE html>
<html>
    <head>
        <title>Homepage | Login</title>
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
        <div class=" d-flex flex-column mt-4 mb-5">
            <div class="section-header text-center">
            </div>
            <div class="container-fluid my-auto">
                <div class="row">
                	<div class="col-lg-2"></div>
                    <div class="col-lg-4">
                        <div class="bg-white shadow-md rounded checkout-form p-4 px-sm-5 mt-4">
                            <div class="login-create-nation">
                                <h2>CHECKOUT</h2>
                            </div>
                            <!-- <hr class="mx-n4 mx-sm-n5"> -->
                            <h4>SIGN IN</h4>
                            <p class="lead">or continue as a guest below.</p>
                            <p class="lead mb-4">Required fields are marked with an asterisk (*).</p>
                            <form id="loginCheckouForm" method="post" action="<?php echo SITEURL; ?>process_checkout_login.php">
                                <div class="form-group">
                                    <label for="emailAddress">Username </label>
                                    <input type="email" class="form-control" id="email" name="email" required="" placeholder="Enter Your Username">
                                </div>
                                <div class="form-group">
                                    <label for="loginPassword">Password</label>
                                    <input type="password" class="form-control" id="password" name="password" required="" placeholder="Enter Password">
                                </div>
                                <div class="row">
                                    <div class="col-sm">
                                    </div>
                                </div>
                                <button class="btn sign-btn" >Sign In</button>
                            </form>
                        </div>

                        <div class="bg-white shadow-md rounded checkout-form p-4 px-sm-5 mt-4">
                            <div class="login-create-nation">
                                <!-- <h2>CHECKOUT</h2> -->
                            </div>
                            <!-- <hr class="mx-n4 mx-sm-n5"> -->
                            <h4>CHECKOUT AS GUEST</h4>
                            <p class="lead">You’ll have a chance to create an account within the checkout experience.</p>
                            <a class="btn sign-btn" href="<?php echo SITEURL; ?>checkout/guest/">CHECKOUT AS GUEST</a>
                        </div>
                    </div>
                    <div class="col-lg-1 section-line"></div>
                    <div class="col-lg-4">
                        <!-- sign up start -->
                        <div class="bg-white shadow-md rounded checkout-form p-4 px-sm-5 mt-4">
                            <div class="login-create-nation">
                            </div>
                            <h4>JOIN CB NATION</h4>
                            <form id="SignupForm" name="SignupForm" method="post" action="<?php echo SITEURL; ?>process_signup_checkout.php">
                                <div class="form-group mt-3">
                                    <label for="emailAddress">First Name </label><span class="text-danger">*</span>
                                    <input type="text" class="form-control" id="first_name" name="first_name" placeholder="Enter Your First Name" required />
                                </div>
                                <div class="form-group">
                                    <label for="emailAddress">Last Name </label><span class="text-danger">*</span>
                                    <input type="text" class="form-control" id="last_name" name="last_name" placeholder="Enter Your Last Name" required />
                                </div>
                                <div class="form-group">
                                    <label for="emailAddress">Email </label><span class="text-danger">*</span>
                                    <input type="email" class="form-control" id="email" name="email" placeholder="Enter Your Email" required />
                                </div>
                                <div class="form-group">
                                    <label for="loginPassword">Password</label><span class="text-danger">*</span>
                                    <input type="password" class="form-control" id="password" name="password" placeholder="Enter Password" required />
                                </div>
                                <a class="btn sign-btn" id="signup_submit" href="javascript:void(0)">Sign Up</a>
                            </form>
                        </div>
                        <!-- sign up end -->
                    </div>

                </div>
            </div>
        </div>
        <!-- sign_in-page-section end-->
        <?php include 'front_include/footer.php'; ?>
        <?php include 'front_include/js.php'; ?>
        <script type="text/javascript">
            $('.loader').hide();
            
        	$("#loginCheckouForm").validate({
                rules: {
                 email:{required : true,email: true},
                 password:{required : true,minlength: 6},
                },
                messages: {
                 email:{required:"Please enter email address.", email:"Please enter valida email address."},
                 password:{required:"Please enter a password."},
                }, 
                errolacement: function(error, element) {
                }
            });


            $("#SignupForm").validate({
                rules: {
                    first_name: {required: true},
                    last_name: {required: true},
                    email: {required: true,email: true},
                    password: {required: true,minlength: 6,maxlength: 8},
                },
                messages: {
                    first_name: {required: "Please enter first name."},
                    last_name: {required: "Please enter last name."},
                    email: {required: "Please enter email.",email: "Please enter a valid username."},
                    password: {required: "Please enter password.",minlength: "Enter at least 6 characters.",maxlength: "No more than 8 characters allow."},
                },
                submitHandler: function(form) {
                    form.submit();
                },
                errorPlacement: function(error, element) {
                    error.insertAfter(element);
               }
            });
            
            $("#signup_submit").click(function(e) {
               e.preventDefault();
               $("#SignupForm").submit();
            });
            
        </script>
    </body>
</html>