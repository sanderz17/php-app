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

        <div class="form-contact container">
            <center class="cantact-img">
                <img src="<?php echo SITEURL; ?>img/imgpsh_fullsize_anim.png" width="200">
            </center>

            <section class="form-section-contact">
                <form class="row g-3" id="ContactForm" name="ContactForm" method="post" action="<?php echo SITEURL ?>process_contact.php">
                  <div class="col-md-12">
                    <label for="inputPassword4" class="form-label">What can we help you with today?*</label>
                    <input type="text" class="form-control" name="question_input" id="question_input">
                  </div>
                  <div class="col-md-6">
                    <label for="inputEmail4" class="form-label">Name*</label>
                    <input type="text" class="form-control" id="input_name" name="input_name">
                    <snap class="saparate-text">First Name</span>
                  </div>
                  <div class="col-6">
                    <input type="text" class="form-control input-differ" id="input_lastname" name="input_lastname">
                    <snap class="saparate-text">Last Name</span>
                  </div>
                  <div class="col-12">
                    <label for="inputAddress2" class="form-label">Email*</label>
                    <input type="text" class="form-control" id="input_email" name="input_email">
                  </div>
                  <div class="col-md-12">
                    <label for="inputCity" class="form-label">Confirm Email *</label>
                    <input type="text" class="form-control" id="input_confirm" name="input_confirm">
                  </div>
                  <div class="col-md-12">
                    <label for="inputZip" class="form-label">Phone*</label>
                    <input type="text" class="form-control" id="input_phone" name="input_phone">
                  </div>
                  <div class="col-md-12">
                    <label for="inputZip" class="form-label">Street Address*</label>
                    <input type="text" class="form-control" id="input_address" name="input_address">
                  </div>
                  <div class="col-md-12">
                    <label for="inputZip" class="form-label">City*</label>
                    <input type="text" class="form-control" id="input_city" name="input_city">
                  </div>
                  <div class="col-md-12">
                    <label for="inputZip" class="form-label">Country*</label>
                    <input type="text" class="form-control" id="input_country" name="input_country">
                  </div>
                  <div class="col-md-12">
                    <label for="inputZip" class="form-label">State*</label>
                    <input type="text" class="form-control" id="input_state" name="input_state">
                  </div>
                  <div class="col-md-12">
                    <label for="inputZip" class="form-label">Zip/Postal Code*</label>
                    <input type="text" class="form-control" id="input_zip" name="input_zip">
                  </div>
                  <div class="col-md-12">
                    <label for="inputZip" class="form-label">Please provide details on the issue or question:*</label>
                    <!-- <input type="text" class="form-control" id="inputZip"> -->
                    <textarea class="form-control" rows="5" name="descr_ques" id="descr_ques"></textarea>
                  </div>

                  <div class="col-12 mt-4" align="center">
                    <button type="submit" class="btn btn-primary contact-btn">SUBMIT</button>
                  </div>
                </form>
            </section>
            
        </div>

        <?php include 'front_include/js.php'; ?>
        <script type="text/javascript">
            $('.loader').hide();
            
            $("#ContactForm").validate({
                rules: {
                    question_input:{required : true},
                    input_name:{required : true},
                    input_lastname:{required : true},
                    input_email:{required : true, email:true},
                    input_confirm:{required : true, equalTo: "#input_email", email:true},
                    input_phone:{required : true},
                    input_address:{required : true},
                    input_city:{required : true},
                    input_country:{required : true},
                    input_state:{required : true},
                    input_zip:{required : true},
                    descr_ques:{required : true},
                },
                messages: {
                    question_input:{required:"Please enter question."},
                    input_name:{required:"Please enter first name."},
                    input_lastname:{required:"Please enter last name."},
                    input_email:{required:"Please enter email address.", email:"Email address not valid."},
                    input_confirm:{required:"Please enter confirm email.", equalTo:"email not match", email:"Email address not valid."},
                    input_phone:{required:"Please enter phone number."},
                    input_address:{required:"Please enter address."},
                    input_city:{required:"Please enter city."},
                    input_country:{required:"Please enter country."},
                    input_state:{required:"Please enter state."},
                    input_zip:{required:"Please enter zip."},
                    descr_ques:{required:"Please description."},
                }, 
                errorPlacement: function (error, element) 
                {
                    error.insertAfter(element);
                }
            });
            
        </script>
    </body>
</html>