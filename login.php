<?php
include "connect.php";
if (isset($_SESSION[SESS_PRE . '_SESS_USER_ID']) && $_SESSION[SESS_PRE . '_SESS_USER_ID'] != "") {
   $db->location(SITEURL);
}
?>
<!DOCTYPE html>
<html>

<head>
   <title>Homepage | Login</title>
   <?php include 'front_include/css.php'; ?>
   <script src="https://www.google.com/recaptcha/enterprise.js" async defer></script>
</head>

<body>
   <?php include 'front_include/header.php'; ?>
   <div class="loader"></div>
   <!--  header section start -->
   <?php
   $url_data = $db->getData("site_setting", "*", "isDelete=0");
   $url_row = mysqli_fetch_assoc($url_data);
   ?>
   <section class="product-header-images">
      <div class="login-follows">
         <ul>
            <li><a href="<?= $url_row['facebook_link']; ?>"><i class="fa fa-facebook" aria-hidden="true"></i></a></li>
            <li><a href="https://twitter.com/ClearBallistics">
                  <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512" style="width: 1em;height: 1em;vertical-align: -0.125em;"><!--!Font Awesome Free 6.5.1 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free Copyright 2024 Fonticons, Inc.-->
                     <path fill="#1d1441" d="M389.2 48h70.6L305.6 224.2 487 464H345L233.7 318.6 106.5 464H35.8L200.7 275.5 26.8 48H172.4L272.9 180.9 389.2 48zM364.4 421.8h39.1L151.1 88h-42L364.4 421.8z" />
                  </svg>
               </a>
            </li>
            <li><a href="<?= $url_row['instagram_link']; ?>"><i class="fa fa-instagram" aria-hidden="true"></i></a></li>
            <li><a href="<?= $url_row['youtube_link']; ?>"><i class="fa fa-play" aria-hidden="true"></i></a></li>
         </ul>
      </div>
   </section>
   <!-- header section end -->
   <!-- sign_in-page-section start-->
   <div class="clearballistics-login d-flex flex-column">
      <div class="section-header text-center">
         <h1>WELCOME TO CB NATION</h1>
      </div>
      <div class="container-fluid my-auto">
         <div class="row">
            <div class="col-lg-5">
               <div class="bg-white shadow-md rounded p-4 mt-4">
                  <div class="login-create-nation">
                     <h2>SIGN IN</h2>
                  </div>
                  <hr class="mx-n4 mx-sm-n5">
                  <p class="lead">Welcome back. It’s good to see you again.</p>
                  <p class="lead mb-4">Required fields are marked with an asterisk (*).</p>
                  <form id="loginForm" method="post" action="<?php echo SITEURL; ?>process_login.php">
                     <div class="form-group">
                        <label for="emailAddress">Email </label><span>*</span>
                        <input type="email" class="form-control" id="email" name="email" required="" placeholder="Enter Your Email">
                     </div>
                     <div class="form-group">
                        <label for="loginPassword">Password</label><span>*</span>
                        <!-- <input type="password" class="form-control" id="password" name="password" required="" placeholder="Enter Password"> -->
                        <div id="password_signin">
                           <div class="input-group">
                              <input type="password" class="form-control" id="signUpPassword" name="password" placeholder="Enter Password" required />
                              <div class="input-group-append">
                                 <span class="input-group-text"><a href="javascript:void(0)" onclick="showHidePassword(this, signUpPassword)"><i class="fa fa-eye-slash" aria-hidden="true"></i></span>
                              </div>
                           </div>
                        </div>
                     </div>
                     <div class="row">
                        <div class="col-sm">
                           <div class="form-check custom-control custom-checkbox">
                              <input id="remember-me" name="remember" class="custom-control-input" type="checkbox">
                              <label class="custom-control-label" for="remember-me">Remember Me</label>
                           </div>
                        </div>
                        <div class="col-sm text-right"><a class="btn-link" href="<?php echo SITEURL; ?>forgot-password/">Forgot Password ?</a></div>
                     </div>
                     <a class="btn sign-btn" id="login_submit" href="javascript:void(0)">Sign In</a>
                  </form>
               </div>
            </div>
            <div class="offset-lg-1 col-lg-6">
               <div class="login-create-nation">
                  <h1>JOIN CB NATION</h1>
                  <p>You'll get a streamlined checkout and access to your registered products and warranties. You'll also receive sneak peek at new products and special events.</p>
                  <p>Required fields are marked with an asterisk (*).</p>
               </div>
               <form id="SignupForm" name="SignupForm" method="post" action="<?php echo SITEURL; ?>process_signup.php">
                  <div class="form-group mt-3">
                     <label for="emailAddress">First Name </label><span>*</span>
                     <input type="text" class="form-control" id="first_name" name="first_name" placeholder="Enter Your First Name" required />
                  </div>
                  <div class="form-group">
                     <label for="emailAddress">Last Name </label><span>*</span>
                     <input type="text" class="form-control" id="last_name" name="last_name" placeholder="Enter Your Last Name" required />
                  </div>
                  <div class="form-group">
                     <label for="emailAddress">Email </label><span>*</span>
                     <input type="email" class="form-control" id="email" name="email" placeholder="Enter Your Email" required />
                  </div>
                  <div class="form-group">
                     <label for="loginPassword">Password</label><span>*</span>
                     <!-- <input type="password" class="form-control" id="password" name="password" placeholder="Enter Password" required /> -->
                     <div id="password_signup">
                        <div class="input-group">
                           <input type="password" class="form-control" id="signupPassword" name="password" placeholder="Enter Password" required />
                           <div class="input-group-append">
                              <span class="input-group-text"><a href="javascript:void(0)" onclick="showHidePassword(this, signupPassword)"><i class="fa fa-eye-slash" aria-hidden="true"></i></span>
                           </div>
                        </div>
                     </div>
                  </div>
                  <div class="g-recaptcha" data-sitekey="6LeIel8pAAAAAHbSwk9CisClBbeYvQ6MdoQMFm3k" data-action="SIGNUP"></div>
                  <a class="btn sign-btn" id="signup_submit" href="javascript:void(0)">Sign Up</a>
               </form>
            </div>
         </div>
      </div>
   </div>
   <!-- sign_in-page-section end-->
   <?php include 'front_include/footer.php'; ?>
   <?php include 'front_include/js.php'; ?>
   <script type="text/javascript">
      $('.loader').hide();

      $("#SignupForm").validate({
         rules: {
            first_name: {
               required: true
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
            // password: {required: "Please enter password.",minlength: "Enter at least 8 characters.",maxlength: "No more than 8 characters allow."},
            password: {
               required: "Please enter password.",
               minlength: "Enter at least 8 characters.",
               maxlength: "No more than 8 characters allow."
            },
         },
         submitHandler: function(form) {
            form.submit();
         },
         errorPlacement: function(error, element) {
            error.insertAfter($('#password_signup'));
         }
      });

      $("#signup_submit").click(function(e) {
         e.preventDefault();
         const grecaptchaResponse = grecaptcha.enterprise.getResponse();
         if (!grecaptchaResponse.length > 0) {
            $.notify({
               message: 'The reCAPTCHA verification failed, please try again'
            }, {
               type: 'danger'
            });
         }
         $("#SignupForm").submit();
      });


      $("#loginForm").validate({
         rules: {
            email: {
               required: true,
               email: true
            },
            // password: {required: true,minlength: 6,maxlength: 8},
            password: {
               required: true,
               minlength: 8
            },
         },
         messages: {
            email: {
               required: "Please enter email.",
               email: "Please enter a valid username."
            },
            // password: {required: "Please enter password.",minlength: "Enter at least 8 characters.",maxlength: "No more than 8 characters allow."},
            password: {
               required: "Please enter password.",
               minlength: "Enter at least 8 characters."
            },
         },
         submitHandler: function(form) {
            form.submit();
         },
         errorPlacement: function(error, element) {
            error.insertAfter($('#password_signin'));
         }
      });

      $("#login_submit").click(function(e) {
         e.preventDefault();
         $("#loginForm").submit();
      });

      $(document).ready(function() {


      });

      function showHidePassword(element, id) {
         if ($(id).attr("type") == "text") {
            $(id).attr('type', 'password');
            $(element).find('i').addClass("fa-eye-slash");
            $(element).find('i').removeClass("fa-eye");
         } else if ($(id).attr("type") == "password") {
            $(id).attr('type', 'text');
            $(element).find('i').removeClass("fa-eye-slash");
            $(element).find('i').addClass("fa-eye");
         }
      }
   </script>
</body>

</html>