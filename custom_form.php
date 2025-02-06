<?php
include "./connect.php";


// if (isset($_SESSION[SESS_PRE.'_SESS_USER_ID']) && $_SESSION[SESS_PRE.'_SESS_USER_ID'] != "") {
//    $db->location(SITEURL);
// }
try {
   include("./include/notification.class.php");
   if (isset($_REQUEST['name']) && isset($_REQUEST['email'])) {

      $name             = $db->clean($_REQUEST['name']);
      $email_address    = $db->clean($_REQUEST['email']);
      $phone_number     = $db->clean($_REQUEST['phone_number']);
      $company_name     = $db->clean($_REQUEST['company_name']);
      $qoute_request     = str_replace(array("\n\r", "\n", "\r"),' ',$_REQUEST['qoute_request']);
      $bussiness_website = $db->clean($_REQUEST['bussiness_website']);

      if ($name == "" && $email == "" && $phone_number == "") {
         $_SESSION['MSG'] = "FILL_ALL_DATA";
         $db->location(SITEURL . "custom-form/");
      } else {
         if (ISMAIL) {
            $subject = "Request a Quotation";
            $nt = new Notification($db);
            include("./mailbody/order_requirement_mail.php");
            //$toemail = 'philip31th@gmail.com';
            $toemail = 'sales@clearballistics.com';
            $nt->sendMail($toemail, $subject, $body);
            //$_SESSION['MSG'] = "Email_Sent";
            $db->location(SITEURL . "custom-form/");
         }
      }
   }
} catch (\Throwable $th) {
   throw $th;
}
?>
<!DOCTYPE html>
<html>

<head>
   <title>Homepage | Login</title>
   <?php include 'front_include/css.php'; ?>
   <script src="https://www.google.com/recaptcha/enterprise.js" async defer></script>
   <style>
      .custom_req_form {
         color: #002b45;
      }

      .asterisk_red {
         color: red;
      }
   </style>
</head>

<body>
   <?php include 'front_include/header.php'; ?>
<!--    <div class="loader"></div> -->
   <!--  header section start -->
   <?php
   $url_data = $db->getData("site_setting", "*", "isDelete=0");
   $url_row = mysqli_fetch_assoc($url_data);
   ?>
   <section class="product-header-images">
      <div class="login-follows">
         <ul>
         </ul>
      </div>
   </section>
   <!-- header section end -->
   <!-- quote-page-section start-->
   <div class="clearballistics-login d-flex flex-column">
      <div class="container my-auto">
         <div class="row">
            <div class="col-lg-12 col-md-12">
               <div class="login-create-nation">
                  <h3 class="custom_req_form text-center mb-3">Request a Quote</h3>
                  <p>Thank you for your interest in the Clear Ballistics. To Request a Quote, provide your company information
                     and select a product. Once you submit your request, we'll get back to you with a quote and next steps.</p>
                  <br>
                  <p> Keep in mind that lead times can fluctuate based on seasonality. Standard timeline for Gel Block is 10 -
                     15 business days, Molds 8-10 weeks, and shipping averages 5 days.</p>
                  <br>
                  <p>All personal information collected in this form will be used in accordance with our Privacy Policy.</p>
                  <br>
                  <p> By requesting a Quote, you acknowledge and agree to our Corporate Purchasing Terms and Conditions. Clear
                     Ballistics's offer to sell products to you is expressly conditioned upon your acceptance of Clear
                     Ballistics's terms and conditions.</p>
                  <br>
                  <p>Required fields are marked with an asterisk (<span class="text-danger">*</span>). </p>
               </div>
            </div>
            <div class="col-md-12">
               <form id="order_requiment_form" name="order_requiment_form" method="POST" action=".">
                  <div class="form-group mt-3">
                     <label for="name" class="font-weight-bold uppercase">COMPANY NAME </label>
                     <input type="text" class="form-control" id="name" name="name" placeholder="Enter Your Name" />
                  </div>
            </div>
            <div class="col-md-6">
               <div class="form-group">
                  <label for="bussiness_website" class="font-weight-bold">BUSINESS WEBSITE</label><span>
                     <input type="text" class="form-control" id="bussiness_website" name="bussiness_website" placeholder="http://" />
               </div>
            </div>
            <div class="col-md-6">
               <div class="form-group">
                  <label for="email" class="font-weight-bold">EMAIL</label><span><span><span class="text-danger">*</span></span>
                     <input type="text" class="form-control" id="email" name="email" placeholder="Enter Email Address" />
               </div>
            </div>
            <div class="col-md-6">
               <div class="form-group">
                  <label for="name" class="font-weight-bold">NAME</label><span><span class="text-danger">*</span></span>
                  <input type="text" class="form-control" id="name" name="name" placeholder="Enter Full Name" />
               </div>
            </div>

            <div class="col-md-6">
               <div class="form-group">
                  <label for="emailAddress" class="font-weight-bold">PHONE </label><span><span class="text-danger">*</span></span>
                  <input type="number" class="form-control" id="phone_number" name="phone_number" placeholder="Enter Your phone" />
               </div>
            </div>
            <div class="col-md-12">
               <div class="form-group">
                  <label for="qoute_request" class="font-weight-bold">Request Details</label><span><span class="text-danger">*</span></span>
                  <textarea type="text" rows="5" class="form-control" id="qoute_request" name="qoute_request" placeholder="Enter Request Details"></textarea>
               </div>

               <div class="g-recaptcha" data-sitekey="6LeIel8pAAAAAHbSwk9CisClBbeYvQ6MdoQMFm3k" data-action="SIGNUP"></div>
               <a class="btn sign-btn" id="custom_submit" href="javascript:void(0)">Submit</a>
               </form>
            </div>
         </div>
      </div>
   </div>

   <!-- quote-page-section end-->

   <!-- thank you modal -->
   <!-- Vertically centered scrollable modal -->
   <div id="thankYouModal" class=" modal fade">
      <div class="modal-dialog modal-dialog-centered">
         <div class="modal-content">
            <div class="modal-header">
               <button type="button" class="close" data-dismiss="modal" aria-label=""><span>×</span></button>
            </div>

            <div class="modal-body text-center">

               <div class="thank-you-pop">
               <img src="/img/round_check.png" alt="" height="100">
                  <h1>Thank You!</h1>
                  <p>Your submission is received and we will contact you soon</p>
               </div>

            </div>

         </div>
      </div>
   </div>
   <!-- thank you modal -->
   <?php include 'front_include/footer.php'; ?>
   <?php include 'front_include/js.php'; ?>
   <script type="text/javascript">
      $('.loader').hide();
      $("#order_requiment_form").validate({
         rules: {
            name: {
               required: true
            },
            email_address: {
               required: true,
               email: true
            },
            phone_number: {
               required: true
            },
            company_name: {
               required: true
            },
            order_requirement: {
               required: true
            },
            deadline: {
               required: true
            }
         },
         messages: {
            name: {
               required: "Please enter name."
            },
            email_address: {
               required: "Please enter email address.",
               email: 'Please enter valid email.'
            },
            phone_number: {
               required: "Please enter phone number."
            },
            company_name: {
               required: "Please enter company name."
            },
            order_requirement: {
               required: "Please enter order requirements."
            },
            deadline: {
               required: "Please enter deadline."
            }
         },
         errorPlacement: function(error, element) {
            error.insertAfter(element);
         }
      });

      $("#custom_submit").click(function(e) {
         e.preventDefault();
         const grecaptchaResponse = grecaptcha.enterprise.getResponse();
         if (!grecaptchaResponse.length > 0) {
            $.notify({
               message: 'The reCAPTCHA verification failed, please try again'
            }, {
               type: 'danger'
            });
         } else {
            $('#thankYouModal').modal('show')
         }
         /*          $.ajax({
                     type: 'post',
                     dataType: 'json',
                     url: "<?php echo SITEURL; ?>/api/request_quote.php",
                     data: $('form').serialize(),
                     success: function() {
                        alert('form was submitted');
                     }
                  }); */
         $("#order_requiment_form").submit();

      });
   </script>
</body>

</html>