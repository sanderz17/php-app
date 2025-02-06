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
            <div class="request-product-hero" style="background-image:url('<?php echo SITEURL; ?>img/contact-bg.png')">
                <div class="overlay"></div>
                <div class="container">
                    <h3>REQUEST QUOTE </h3>
                </div>
            </div>
        </section>
        <!-- header section end -->
        <div class="form-contact">
            <section class="form-section-contact">
            <div class="container">
                <div class="title-request">
                    <h1>YOUR INFORMATION</h1>
                </div>
                <form class="row g-3" id="ContactForm" name="ContactForm" method="post" action="<?php echo SITEURL ?>process_contact.php">
                    <div class="col-md-12">
                        <label for="inputPassword4" class="form-label">Company*</label>
                        <input type="text" class="form-control" name="company_name" id="company_name">
                    </div>
                    <div class="col-md-6">
                        <label for="inputEmail4" class="form-label">Name*</label>
                        <input type="text" class="form-control" id="first_name" name="first_name">
                        <snap class="saparate-text">
                        First Name</span>
                    </div>
                    <div class="col-6">
                        <input type="text" class="form-control input-differ" id="last_name" name="last_name">
                        <snap class="saparate-text">
                        Last Name</span>
                    </div>
                    <div class="col-12">
                        <label for="inputAddress2" class="form-label">Email*</label>
                        <input type="email" class="form-control" id="email" name="email">
                    </div>
                    <div class="col-md-12">
                        <label for="inputZip" class="form-label">Phone*</label>
                        <input type="text" class="form-control" id="phone" name="phone">
                    </div>
                    <div class="col-md-6">
                        <label for="inputZip" class="form-label">Address*</label>
                        <input type="text" class="form-control" id="address" name="address">
                    </div>
                    <div class="col-md-6">
                        <label for="inputZip" class="form-label">City*</label>
                        <input type="text" class="form-control" id="city" name="city">
                    </div>
                    <div class="col-md-6">
                        <label for="inputZip" class="form-label">State*</label>
                        <input type="text" class="form-control" id="state" name="state">
                    </div>
                    <div class="col-md-6">
                        <label for="inputZip" class="form-label">Zip Code*</label>
                        <input type="text" class="form-control" id="zip_code" name="zip_code">
                    </div>
                    <div class="col-md-12">
                        <label for="inputZip" class="form-label">Industry*</label>
                        <select class="form-control" name="industry" required="" id="industry" style="color:#002B45">
                            <option value="">SELECT INDUSTRY</option>
                            <option value="Conservation">CONSERVATION</option>
                            <option value="Construction">CONSTRUCTION</option>
                            <option value="Education">EDUCATION</option>
                            <option value="Energy">ENERGY</option>
                            <option value="Financial">FINANCIAL</option>
                            <option value="Food/Beverage">FOOD/BEVERAGE</option>
                            <option value="Healthcare">HEALTHCARE</option>
                            <option value="Hospitality">HOSPITALITY</option>
                            <option value="Manufacturing/Consumer Goods">MANUFACTURING/CONSUMER GOODS</option>
                            <option value="Non-Profit">NON-PROFIT</option>
                            <option value="Professional Services">PROFESSIONAL SERVICES</option>
                            <option value="Promotional">PROMOTIONAL</option>
                            <option value="Real Estate">REAL ESTATE</option>
                            <option value="Retail">RETAIL</option>
                            <option value="Sports/Entertainment">SPORTS/ENTERTAINMENT</option>
                            <option value="Technology">TECHNOLOGY</option>
                            <option value="Transportation">TRANSPORTATION</option>
                        </select>
                    </div>
                    <div class="col-md-5">
                        <label for="inputZip" class="form-label">Event Date</label>
                        <input type="date" class="form-control" name="event_date" id="event_date">
                    </div>
                    <div class="col-12 mt-4" align="center">
                        <button type="submit" class="btn btn-primary contact-btn">SUBMIT</button>
                    </div>
                </form>
</div>
            </section>
        </div>
        <!-- contact-page-section end-->
        <?php include 'front_include/footer.php'; ?>
        <?php include 'front_include/js.php'; ?>
        <script type="text/javascript">
            $('.loader').hide();
            
            $("#ContactForm").validate({
                rules: {
                    company_name:{required : true},
                    first_name:{required : true},
                    last_name:{required : true},
                    email:{required : true, email: true},
                    phone:{required : true},
                    address:{required : true},
                    city:{required : true},
                    state:{required : true},
                    zip_code:{required : true},
                    industry:{required : true},
                    event_date:{required : true},
                },
                messages: {
                    company_name:{required:"Please enter company name."},
                    first_name:{required:"Please enter first name."},
                    last_name:{required:"Please enter last name."},
                    email:{required:"Please enter email."},
                    phone:{required:"Please enter phone number."},
                    address:{required:"Please enter address."},
                    city:{required:"Please enter city."},
                    state:{required:"Please enter state."},
                    zip_code:{required:"Please enter zip code."},
                    industry:{required:"Please select industry"},
                    event_date:{required:"Please select event date."},
                }, 
                errorPlacement: function (error, element) 
                {
                    error.insertAfter(element);
                }
            });
            
        </script>
    </body>
</html>