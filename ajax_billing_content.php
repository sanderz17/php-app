<?php  
    include 'connect.php';
    $use_billing_save = $_REQUEST['use_billing_save'];

    $cart_id = $_SESSION[SESS_PRE.'_SESS_CART_ID'];
    $user_id = $_SESSION[SESS_PRE.'_SESS_USER_ID'];

    $get_shipping_details = $db->getData("billing_shipping","*","isDelete=0 AND cart_id=".$cart_id,"id DESC");
    $get_shipping_details_r = mysqli_fetch_assoc($get_shipping_details);

    // echo "<pre>";
    // print_r(mysqli_fetch_assoc($get_shipping_details));
    // die;
?>

        <!-- <div class="faq-content-main"> 
            <div class="row billing-tag-details">
                <div class="col-md-4">
                    <h4>CHECKOUT WITH</h4>
                </div>
            </div>
        </div>
        <hr> -->
        <div class="faq-content-main"> 
            <div class="row billing-tag-details">
                <div class="col-md-4">
                    <h4>SHIPPING ADDRESS</h4>
                    <p><?php echo $get_shipping_details_r['shipping_address'] ?></p>
                    <p><?php echo $get_shipping_details_r['shipping_address2'] ?></p>
                    <p><?php echo $get_shipping_details_r['shipping_city'] ?></p>
                    <p><?php echo $db->getValue("states_ex","name"," id='".$get_shipping_details_r['shipping_state']."' "); ?>,<?php echo $get_shipping_details_r['shipping_zipcode'] ?></p>
                    <p><?php echo $db->getValue("countries","name"," id='".$get_shipping_details_r['shipping_country']."' ");  ?></p>
                </div>
                <div class="col-md-4">
                    <h4>CONTACT INFO</h4>
                    <p><?php echo $get_shipping_details_r['shipping_phone'] ?></p>
                    <p><?php echo $db->getValue("user","email","id='".$get_shipping_details_r['user_id']."' "); ?></p>
                </div>
                <div class="col-md-4">
                    <h4>SHIPPING METHOD</h4>
                    <!-- <p><?php //echo $db->getValue("cart","shipping_method_name") ?></p> -->
                    <p><?php echo $db->getValue("cart","shipping_method","id='".$cart_id."' "); ?></p>
                    <!-- <p>UPS SurePost</p> -->
                </div>
            </div>
        </div>
        <hr>
        <?php if (!empty($use_billing_save && $use_billing_save == "false")) { ?>
        <div class="faq-content-main" id="billing_section_step2">
            <h3 style="margin-bottom: 40px;">BILLING</h3>
            <div class="row">
                <div class="col-md-6">
                    <div class="save-address-form">
                        <input type="checkbox" id="copy_shipping_save" name="copy_shipping_save">
                        <label for="copy_shipping_save">Copy shipping address</label>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6">
                    <div class="from-group">
                        <input type="text" name="billing_first_name" id="billing_first_name" placeholder="First Name" class="form-control">
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="from-group">
                        <input type="text" name="billing_last_name" id="billing_last_name" placeholder="Last Name" class="form-control">
                    </div>
                </div>
                <div class="col-md-12">
                    <div class="from-group">
                        <input type="text" name="billing_street_addr" id="billing_street_addr" placeholder="Street address" class="form-control">
                    </div>
                </div>
                <div class="col-md-12">
                    <div class="from-group">
                        <input type="text" name="billing_addr2" id="billing_addr2" placeholder="Apartment, suite, unit, etc." class="form-control">
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="from-group">
                        <select class="form-control" required="" aria-required="true" name="billing_country" id="billing_country" onchange="getState(this.value);">
                            <option value="">Country / Region</option>
                            <!-- <option value="1" id="0">UK</option>
                            <option value="2" id="0">Qatar</option> -->
                            <?php 
                                $country_d = $db->getData("countries","*");
                                foreach ($country_d as $key => $country_r) {
                                    ?>
                                    <option value="<?php echo $country_r['id'] ?>" <?php if($country_r['id'] == $get_shipping_details_r['shipping_country']){ echo "Selected"; } ?>><?php echo $country_r['name']; ?></option>
                                    <?php
                                }
                            ?>
                        </select>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="from-group">
                        <input type="text" name="billing_post" id="billing_post" placeholder="Postcode" class="form-control">
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="from-group">
                        <!-- <input type="text" name="billing_state" id="billing_state" placeholder="State" class="form-control"> -->
                        <!-- <input type="text" name="billing_state" id="shipping_state" placeholder="State" class="form-control"> -->
                        <select name="billing_state" id="billing_state" class="form-control"></select>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="from-group">
                        <input type="text" name="billing_city" id="billing_city" placeholder="City" class="form-control">
                    </div>
                </div>
                <div class="col-md-12">
                    <div class="from-group">
                        <input type="tel" name="billing_phone" id="billing_phone" placeholder="Phone" class="form-control" maxlength="30" >
                    </div>
                </div>
            </div>
        </div>
        <?php } ?>
        <?php if (!empty($use_billing_save && $use_billing_save == "true")) { ?>
        <div class="faq-content-main" id="billing_detail_section_step2">
            <h3>BILLING</h3>
            <div class="row billing-tag-details">
                <div class="col-md-4">
                    <h4>SHIPPING ADDRESS</h4>
                    <p><?php echo $get_shipping_details_r['billing_address'] ?></p>
                    <p><?php echo $get_shipping_details_r['billing_address2'] ?></p>
                    <p><?php echo $get_shipping_details_r['billing_city'] ?></p>
                    <!-- <p><?php echo $get_shipping_details_r['billing_state'] ?></p>
                    <p><?php echo $get_shipping_details_r['billing_country'].",".$get_shipping_details_r['billing_zipcode']; ?></p> -->
                    <p><?php echo $db->getValue("states_ex","name"," id='".$get_shipping_details_r['shipping_state']."' "); ?>,<?php echo $get_shipping_details_r['shipping_zipcode'] ?></p>
                    <p><?php echo $db->getValue("countries","name"," id='".$get_shipping_details_r['shipping_country']."' ");  ?></p>
                </div>
            </div>
        </div>
        <?php } ?>

        <script>
            $(document).ready(function(){
                getState('<?= $get_shipping_details_r['shipping_country']; ?>');
            });
            function getState(country_id,shipping_state)
            {
                // var country_id = $('#shipping_country :selected').text();
                // var country_id = $("#shipping_country").val();
                // alert(country_id);
                $.ajax({
                    type: "POST",
                    url: "<?php echo SITEURL; ?>ajax_state.php",
                    // data: {country_id:country_id},
                    data: 'country_id='+country_id+'&shipping_state='+shipping_state,
                    success: function(options)
                    {
                        // alert(options);
                        // $('#shipping_state').empty().append(options);
                        $("#billing_state").html(options === "" ? "<option value=''>State</option>" : options);
                    }
                });
            }

            $("#copy_shipping_save").click(function() {
                if($('#copy_shipping_save').is(":checked")){
                    var use_billing_save = $('#copy_shipping_save').is(":checked");

                    $.ajax({
                        url: "<?php echo SITEURL ?>ajax_copy_shipping.php",
                        type: "POST",
                        data : {use_billing_save:use_billing_save},
                        dataType: 'json',
                        beforeSend  : function() 
                        {
                            $(".loader").fadeIn();  
                        },
                        success: function(data)
                        {
                            console.log(data);
                            $("#billing_first_name").val(data.billing_first_name ?? $('#shipping_first_name').val());
                            $("#billing_last_name").val(data.billing_last_name ?? $('#shipping_last_name').val());
                            $("#billing_street_addr").val(data.billing_street_addr ?? $('#shipping_street_addr').val());
                            $("#billing_addr2").val(data.billing_addr2 ?? $('#shipping_addr2').val());
                            $("#billing_country").val(data.billing_country ?? $('#shipping_country').val());
                            $("#billing_post").val(data.billing_post ?? $('#shipping_post').val());
                            $("#billing_state").val(data.billing_state ?? $('#shipping_state').val());
                            $("#billing_city").val(data.billing_city ?? $('#shipping_city').val());
                            $("#billing_phone").val(data.billing_phone ?? $('#shipping_phone').val());
                            $("#dis_shipping_method").val(data.dis_shipping_method ?? $('#dis_billing_method').val());
                            // $("#billing_phone").append(data.billing_phone);
                            console.log(getState($('#shipping_country').val(),$('#shipping_state').val()));

                        }
                    });
                    $("#billing_detail_section_step2").show();
                }   
                else{
                    $("#billing_first_name").val('');
                    $("#billing_last_name").val('');
                    $("#billing_street_addr").val('');
                    $("#billing_addr2").val('');
                    $("#billing_country").val('');
                    $("#billing_post").val('');
                    $("#billing_state").val('');
                    $("#billing_city").val('');
                    $("#billing_phone").val('');
                }
            });


            // phone number formate start
/*             let telEl = document.querySelector('#billing_phone');
            telEl.addEventListener('keyup', (e) => {
              let val = e.target.value;
              e.target.value = val
                .replace(/\D/g, '')
                .replace(/(\d{1,3})(\d{1,3})?(\d{1,4})?/g, function(txt, f, s, t) {
                  if (t) {
                    return `(${f}) ${s}-${t}`
                  } else if (s) {
                    return `(${f}) ${s}`
                  } else if (f) {
                    return `(${f})`
                  }
                });
            }); */
        </script>