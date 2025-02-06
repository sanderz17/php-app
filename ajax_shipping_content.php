<?php
include 'connect.php';
$user = $_REQUEST['userType'];
$user_id = $_SESSION[SESS_PRE . '_SESS_USER_ID'];
$cart_id = $_SESSION[SESS_PRE . '_SESS_CART_ID'];

$billing_first_name = "";
$billing_last_name  = "";
$billing_email = "";
$billing_phone = "";
$billing_address = "";
$billing_address2 = "";
$billing_city = "";
$billing_state = "";
$billing_country = "";
$billing_zipcode = "";
$shipping_first_name = "";
$shipping_last_name = "";
$shipping_email = "";
$shipping_phone = "";
$shipping_address = "";
$shipping_address2 = "";
$shipping_city = "";
$shipping_state = "";
$shipping_country = "0";
$shipping_zipcode = "";

if (isset($user_id) && $user_id != "" && $cart_id != 0 && isset($cart_id)) {
    $shipping_d = $db->getData("billing_shipping", "*", "isDelete=0 AND user_id=" . $user_id . " AND cart_id=" . $cart_id, "id DESC");
    $shipping_r = mysqli_fetch_assoc($shipping_d);
    $billing_first_name = $shipping_r['billing_first_name'];
    $billing_last_name  = $shipping_r['billing_last_name'];
    $billing_email = $shipping_r['billing_email'];
    $billing_phone = $shipping_r['billing_phone'];
    $billing_address = $shipping_r['billing_address'];
    $billing_address2 = $shipping_r['billing_address2'];
    $billing_city = $shipping_r['billing_city'];
    $billing_state = $shipping_r['billing_state'];
    $billing_country = $shipping_r['billing_country'];
    $billing_zipcode = $shipping_r['billing_zipcode'];

    $shipping_first_name = $shipping_r['shipping_first_name'];
    $shipping_last_name = $shipping_r['shipping_last_name'];
    $shipping_email = $shipping_r['shipping_email'];
    $shipping_phone = $shipping_r['shipping_phone'];
    $shipping_address = $shipping_r['shipping_address'];
    $shipping_address2 = $shipping_r['shipping_address2'];
    $shipping_city = $shipping_r['shipping_city'];
    $shipping_state = $shipping_r['shipping_state'];
    $shipping_country = $shipping_r['shipping_country'];
    $shipping_zipcode = $shipping_r['shipping_zipcode'];
    // echo $shipping_country;
}

?>

<div class="row">
    <div class="col-md-6">
        <div class="from-group">
            <input type="text" name="shipping_first_name" id="shipping_first_name" placeholder="First Name" class="form-control" value="<?php echo $shipping_first_name; ?>">
        </div>
    </div>
    <div class="col-md-6">
        <div class="from-group">
            <input type="text" name="shipping_last_name" id="shipping_last_name" placeholder="Last Name" class="form-control" value="<?php echo $shipping_last_name; ?>">
        </div>
    </div>
    <div class="col-md-12">
        <div class="from-group">
            <input type="text" name="shipping_street_addr" id="shipping_street_addr" placeholder="Street address" class="form-control" value="<?php echo $shipping_address; ?>">
        </div>
    </div>
    <div class="col-md-12">
        <div class="from-group">
            <input type="text" name="shipping_addr2" id="shipping_addr2" placeholder="Apartment, suite, unit, etc." class="form-control" value="<?php echo $shipping_address2; ?>">
        </div>
    </div>
    <div class="col-md-6">
        <div class="from-group">
            <select class="form-control" required="" aria-required="true" onchange="getState(this.value);" name="shipping_country" id="shipping_country">
                <option value="">Country / Region</option>
                <option value="233">United States</option>
                <?php
                $country_d = $db->getData("countries", "*", "id !='233'");
                foreach ($country_d as $key => $country_r) {
                ?>
                    <option <?php echo ($country_r['id'] == 233) ? "selected" : ""; ?> value="<?php echo $country_r['id'] ?>" <?php if ($country_r['id'] == $shipping_country) {
                                                                                                                                    echo "Selected";
                                                                                                                                } ?>><?php echo $country_r['name']; ?></option>
                <?php
                }
                ?>
            </select>
            <div class="filter__icon"><i class="fa fa-caret-down"></i></div>
        </div>
    </div>
    <!-- <div class="col-md-6">
                <div class="from-group">
                    <select class="form-control" required="" aria-required="true" onchange="getState(this.value);" name="" id="">
                        <option value="">Shipping option</option>
                        <option value="">UPS Ground</option>
                        <option value="">UPS 3 Day Select</option>
                        <option value="">Free USPS Shipping</option>
                    </select>
                    
                </div>
            </div> -->
    <div class="col-md-6">
        <div class="from-group">
            <input type="text" name="shipping_post" id="shipping_post" placeholder="Postcode" class="form-control" value="<?php echo $shipping_zipcode; ?>" onchange=getShippingCharges()>
        </div>
    </div>
    <div class="col-md-6">
        <div class="from-group">
            <!-- <input type="text" name="shipping_state" id="shipping_state" placeholder="State" class="form-control"> -->
            <select name="shipping_state" id="shipping_state" class="form-control" onchange="getShippingCharges()">
                <option value="">State</option>
            </select>
            <div class="filter__icon"><i class="fa fa-caret-down"></i></div>
        </div>
    </div>
    <div class="col-md-6">
        <div class="from-group">
            <input type="text" name="shipping_city" id="shipping_city" placeholder="City" class="form-control" value="<?php echo $shipping_city; ?>" onchange=cityname()>
        </div>
    </div>

    <!-- <div class="col-md-6">
                <div class="from-group">
                    <select class="form-control" name="shipping_method" id="shipping_method" onChange="rpAddShippingCharge(this.value);">
                        <option value="">Please Select Shipping Method</option>
                        <?php
                        $shipping_method_d = $db->getData("shipping_method", "*", "isDelete=0", "");
                        if (@mysqli_num_rows($shipping_method_d) > 0) {
                            while ($shipping_d = @mysqli_fetch_array($shipping_method_d)) {
                        ?>
                                <option 
                                <?php //echo ($shipping_d['service_code']==03)?"selected":""; 
                                ?>
                                value="<?php //echo $shipping_d['service_code']; 
                                        ?>"><?php //echo $shipping_d['name']; 
                                            ?></option>
                                <?php
                            }
                        }
                                ?>
                    </select>
                </div>
            </div> -->

    <div class="col-md-12">
        <div class="from-group">

            <input type="text" name="shipping_phone" id="shipping_phone" class="form-control" value="<?php echo $shipping_phone; ?>" maxlength="30" style="padding-left: 50px;">

            <!-- <input type="text" name="shipping_phone" id="shipping_phone" placeholder="Phone" class="form-control" value="<?php echo $shipping_phone; ?>" maxlength="14" onkeydown="javascript:backspacerDOWN(this,event);" onkeyup="javascript:backspacerUP(this,event);"> -->

        </div>
    </div>
    <?php
    //if (!empty($user) && $user != "" && $user == "guest") {
    ?>
    <div class="col-md-12">
        <div class="from-group">
            <input type="email" name="shipping_email" id="shipping_email" placeholder="Email" class="form-control" value="<?php echo $shipping_email; ?>">
        </div>
    </div>
    <?php //} 
    ?>
    <div class="col-md-12">
        <div class="save-address-form">
            <input type="checkbox" id="save_addr_from" name="save_addr_from">
            <label for="save_addr_from">Save to Address Book</label>
        </div>
    </div>
    <div class="col-md-12">
        <div class="save-address-form">
            <input type="checkbox" id="use_billing_save" name="use_billing_save">
            <label for="use_billing_save">Use this address for Billing</label>
        </div>
    </div>
    <div class="col-md-12">
        <div class="shipping_methods_section" id="shipping_methods_section">
            <h3>SHIPPING METHOD</h3>

            <div class="col-md-6 p-0">
                <select class="form-control" name="shipping_method" id="shipping_method" onChange="rpAddShippingCharge(this.value);">
                    <option value="">Please Select Shipping Method</option>
                    <!--                     <option value="11" id="ups_standard">UPS Standard</option> -->
                    <!-- <option value="03" id="ups_ground">UPS Ground</option> -->
                    <!-- <option value="12" id="ups_3day_select">UPS 3 Day Select</option> -->
                    <!-- <option value="02" id="ups_2nd_day_air">UPS 2nd Day Air</option> -->
                    <!--   <option value="59" id="ups_2nd_day_air_am">UPS 2nd Day Air AM</option> -->
                    <!-- <option value="13" id="ups_next_day_air_saver">UPS Next Day Air Saver</option> -->
                    <!--   <option value="01" id="ups_next_day_air">UPS Next Day Air</option> -->
                    <!--  <option value="08" id="ups_worldwide_expedited">UPS Worldwide Expedited</option> -->
                    <!--                     <option value="14" id="ups_next_day_air_early_am">UPS Next Day Air Early A.M.</option>
                    <option value="07" id="ups_wsorldwide_express">UPS Worldwide Express</option>
                    <option value="54" id="ups_worldwide_express_plus">UPS Worldwide Express Plus</option>

                    <option value="65" id="ups_world_wide_saver">UPS World Wide Saver</option> -->
                    <!--  <option value="DHL" id="dhl_express" >DHL Express</option> -->
                    <?php
                    /*$shipping_method_d = $db->getData("shipping_method","*","isDelete=0","");
                            if(@mysqli_num_rows($shipping_method_d)>0){
                                while($shipping_d = @mysqli_fetch_array($shipping_method_d)){
                                    ?>
                                    <option 
                                    <?php echo ($shipping_d['service_code']==03)?"selected":""; ?>
                                    value="<?php echo $shipping_d['service_code']; ?>"><?php echo $shipping_d['name']; 
                                    ?></option>
                                    <?php 
                                } 
                            } */
                    ?>
                </select>

            </div>

            <!-- <div class="col-md-12 p-0">
                        <input id="standard" type="radio" class="shipping_methods" name="shipping_method_select" value="standard" checked="">
                        <label for="standard"><span></span>Standard </label>
                    </div>
                    <div class="col-md-12 p-0">
                        <input id="premium" type="radio" class="shipping_methods" name="shipping_method_select" value="premium">
                        <label for="premium"><span></span>Premium </label>
                    </div>
                    <div class="col-md-12 p-0">
                        <input id="express" type="radio" class="shipping_methods" name="shipping_method_select" value="express">
                        <label for="express"><span></span>Express </label>
                    </div> -->
        </div>
    </div>
    <?php
    if (!empty($user) && $user != "" && $user == "guest") {
    ?>
        <div class="col-md-12">
            <div class="checkout-signup-section">
                <h3>CREATE ACCOUNT</h3>
                <label>Enter a password to generate your own CB Account. Store addresses, payment information and register your CB. It's that easy!</label>
                <input type="password" name="check_out_signup_password" id="check_out_signup_password" placeholder="Password">
            </div>
        </div>
    <?php
    } ?>

</div>

<script>
    const phoneInputField = document.querySelector("#shipping_phone");
    const phoneInput = window.intlTelInput(phoneInputField, {
        utilsScript: "https://cdnjs.cloudflare.com/ajax/libs/intl-tel-input/17.0.8/js/utils.js",
    });

    function getUsZipCode(zipCode) {
        let stateCode = '';
        zipCode = parseFloat(zipCode);
        if (zipCode >= 35000 && zipCode <= 36999) {
            $('#shipping_state').val('1456')
            stateCode = 'AL';
        } else if (zipCode >= 99500 && zipCode <= 99999) {
            $('#shipping_state').val('1400')
            stateCode = 'AK';
        } else if (zipCode >= 85000 && zipCode <= 86999) {
            $('#shipping_state').val('1434')
            stateCode = 'AZ';
        } else if (zipCode >= 71600 && zipCode <= 72999) {
            $('#shipping_state').val('1444')
            stateCode = 'AR';
        } else if (zipCode >= 90000 && zipCode <= 96699) {
            $('#shipping_state').val('1416')
            stateCode = 'CA';
        } else if (zipCode >= 80000 && zipCode <= 81999) {
            $('#shipping_state').val('1450')
            stateCode = 'CO';
        } else if ((zipCode >= 6000 && zipCode <= 6389) || (zipCode >= 6391 && zipCode <= 6999)) {
            $('#shipping_state').val('1435')
            stateCode = 'CT';
        } else if (zipCode >= 19700 && zipCode <= 19999) {
            $('#shipping_state').val('1399')
            stateCode = 'DE';
        } else if (zipCode >= 32000 && zipCode <= 34999) {
            $('#shipping_state').val('1436')
            stateCode = 'FL';
        } else if ((zipCode >= 30000 && zipCode <= 31999) || (zipCode >= 39800 && zipCode <= 39999)) {
            $('#shipping_state').val('1455')
            stateCode = 'GA';
        } else if (zipCode >= 96700 && zipCode <= 96999) {
            $('#shipping_state').val('1411')
            stateCode = 'HI';
        } else if (zipCode >= 83200 && zipCode <= 83999) {
            $('#shipping_state').val('1460')
            stateCode = 'ID';
        } else if (zipCode >= 60000 && zipCode <= 62999) {
            $('#shipping_state').val('1425')
            stateCode = 'IL';
        } else if (zipCode >= 46000 && zipCode <= 47999) {
            $('#shipping_state').val('1440')
            stateCode = 'IN';
        } else if (zipCode >= 50000 && zipCode <= 52999) {
            $('#shipping_state').val('1459')
            stateCode = 'IA';
        } else if (zipCode >= 66000 && zipCode <= 67999) {
            $('#shipping_state').val('1406')
            stateCode = 'KS';
        } else if (zipCode >= 40000 && zipCode <= 42999) {
            $('#shipping_state').val('1419')
            stateCode = 'KY';
        } else if (zipCode >= 70000 && zipCode <= 71599) {
            $('#shipping_state').val('1457')
            stateCode = 'LA';
        } else if (zipCode >= 3900 && zipCode <= 4999) {
            $('#shipping_state').val('1453')
            stateCode = 'ME';
        } else if (zipCode >= 20600 && zipCode <= 21999) {
            $('#shipping_state').val('1401')
            stateCode = 'MD';
        } else if ((zipCode >= 1000 && zipCode <= 2799) || (zipCode >= 5501 && zipCode <= 5544)) {
            $('#shipping_state').val('1433')
            stateCode = 'MA';
        } else if (zipCode >= 48000 && zipCode <= 49999) {
            $('#shipping_state').val('1426')
            stateCode = 'MI';
        } else if (zipCode >= 55000 && zipCode <= 56899) {
            $('#shipping_state').val('1420')
            stateCode = 'MN';
        } else if (zipCode >= 38600 && zipCode <= 39999) {
            $('#shipping_state').val('1430')
            stateCode = 'MS';
        } else if (zipCode >= 63000 && zipCode <= 65999) {
            $('#shipping_state').val('1451')
            stateCode = 'MO';
        } else if (zipCode >= 59000 && zipCode <= 59999) {
            $('#shipping_state').val('1446')
            stateCode = 'MT';
        } else if (zipCode >= 27000 && zipCode <= 28999) {
            $('#shipping_state').val('1447')
            stateCode = 'NC';
        } else if (zipCode >= 58000 && zipCode <= 58999) {
            $('#shipping_state').val('1418')
            stateCode = 'ND';
        } else if (zipCode >= 68000 && zipCode <= 69999) {
            $('#shipping_state').val('1408')
            stateCode = 'NE';
        } else if (zipCode >= 88900 && zipCode <= 89999) {
            $('#shipping_state').val('1458')
            stateCode = 'NV';
        } else if (zipCode >= 3000 && zipCode <= 3899) {
            $('#shipping_state').val('1404')
            stateCode = 'NH';
        } else if (zipCode >= 7000 && zipCode <= 8999) {
            $('#shipping_state').val('1417')
            stateCode = 'NJ';
        } else if (zipCode >= 87000 && zipCode <= 88499) {
            $('#shipping_state').val('1423')
            stateCode = 'NM';
        } else if ((zipCode >= 10000 && zipCode <= 14999) || zipCode == 6390 || zipCode <= 501 || zipCode <= 544) {
            $('#shipping_state').val('1452')
            stateCode = 'NY';
        } else if (zipCode >= 43000 && zipCode <= 45999) {
            $('#shipping_state').val('4851')
            stateCode = 'OH';
        } else if ((zipCode >= 73000 && zipCode <= 73199) || (zipCode >= 73400 && zipCode <= 74999)) {
            $('#shipping_state').val('1421')
            stateCode = 'OK';
        } else if (zipCode >= 97000 && zipCode <= 97999) {
            $('#shipping_state').val('1415')
            stateCode = 'OR';
        } else if (zipCode >= 15000 && zipCode <= 19699) {
            $('#shipping_state').val('1422')
            stateCode = 'PA';
        } else if (zipCode >= 300 && zipCode <= 999) {
            $('#shipping_state').val('0')
        } else if (zipCode >= 2800 && zipCode <= 2999) {
            $('#shipping_state').val('1461')
            stateCode = 'RI';
        } else if (zipCode >= 29000 && zipCode <= 29999) {
            $('#shipping_state').val('1443')
            stateCode = 'SC';
        } else if (zipCode >= 57000 && zipCode <= 57999) {
            $('#shipping_state').val('1445')
            stateCode = 'SD';
        } else if (zipCode >= 37000 && zipCode <= 38599) {
            $('#shipping_state').val('1454')
            stateCode = 'TN';
        } else if ((zipCode >= 75000 && zipCode <= 79999) || (zipCode >= 73301 && zipCode <= 73399) || (zipCode >= 88500 && zipCode <= 88599)) {
            $('#shipping_state').val('1407')
            stateCode = 'TX';
        } else if (zipCode >= 84000 && zipCode <= 84999) {
            $('#shipping_state').val('1414')
            stateCode = 'UT';
        } else if (zipCode >= 5000 && zipCode <= 5999) {
            $('#shipping_state').val('1409')
            stateCode = 'VT';
        } else if ((zipCode >= 20100 && zipCode <= 20199) || (zipCode >= 22000 && zipCode <= 24699) || zipCode == 20598) {
            $('#shipping_state').val('1427')
            stateCode = 'VA';
        } else if ((zipCode >= 20000 && zipCode <= 20099) || (zipCode >= 20200 && zipCode <= 20599) || zipCode == 56900 || zipCode == 56999) {
            $('#shipping_state').val('0')
        } else if (zipCode >= 98000 && zipCode <= 99499) {
            $('#shipping_state').val('1462')
            stateCode = 'WA';
        } else if (zipCode >= 24700 && zipCode <= 26999) {
            $('#shipping_state').val('1429')
            stateCode = 'WV';
        } else if (zipCode >= 53000 && zipCode <= 54999) {
            $('#shipping_state').val('1441')
            stateCode = 'WI';
        } else if (zipCode >= 82000 && zipCode <= 83199) {
            $('#shipping_state').val('1442')
            stateCode = 'WY';
        }
        return stateCode;
    }

    function getShippingCharges() {

        let shipping_post = document.getElementById("shipping_post").value;
        let shipping_post_country_id = document.getElementById("shipping_country").value;
        let shipping_post_state_id = document.getElementById("shipping_state").value;

        if (!shipping_post) {
            $('#shipping_post').css('border-color', 'red');
            return
        } else {
            $('#shipping_post').css('border-color', '');
        }


        let stateCode = '';
        if (shipping_post_country_id == '233') {
            stateCode = getUsZipCode(shipping_post);
        }
        //if (shipping_post || shipping_post_country_id || shipping_post_state_id) {

        //30000ms = 5s
        //setTimeout(hideLoaderAfterSecs, 5000);
        shippingCharges(stateCode)

        //rpAddShippingChargeStandard('11', stateCode);
        //rpAddShippingChargeGround('03', stateCode);
        //rpAddShippingCharge3DaySelect('12', stateCode);
        //rpAddShippingCharge2ndDayAir('02', stateCode);
        //rpAddShippingCharge2ndDayAirAM('59', stateCode);
        //rpAddShippingChargeNextDayAirSaver('13', stateCode);
        //rpAddShippingChargeNextDayAir('01', stateCode);
        //rpAddShippingChargeNextDayAirEarly('14', stateCode);
        //rpAddShippingChargeWorldwideExpress('07', stateCode);
        //rpAddShippingChargeWorldwideExpressPlus('54', stateCode);
        //rpAddShippingChargeWorldwideExpedited('08', stateCode);
        //rpAddShippingChargeWorldWideSaver('65', stateCode);       
        //}

        //dhlExpress(shipping_post);
        //alert(shipping_post);

        // $.ajax({
        //     type: "POST",
        //     url: "<?php //echo SITEURL; 
                        ?>ajax_update_postcode.php",
        //     // data: {country_id:country_id},
        //     data: 'shipping_post='+shipping_post,
        //     success: function(data)
        //     {
        //         alert(data);
        //         $("#shipping_post").val(data);
        //     }
        // });

    }


    function hideLoaderAfterSecs() {
        $(".preloader").hide();
    }


    $(document).ready(function() {
        $(".preloader").show();
        // var ship_count = 0;
        // var ship_coun = <?php echo $shipping_country; ?>;
        // if(ship_coun == 0 || ship_count == 0)
        // {
        //     getState('239');
        // }
        // else
        // {
        //     getState('<?= $shipping_country; ?>');
        // }
        //alert(<?php echo $shipping_country; ?>;)
        //getState('233');

        //rpAddShippingChargeStandard('11');
        /*         rpAddShippingChargeGround('03');
                rpAddShippingCharge3DaySelect('12');
                rpAddShippingCharge2ndDayAir('02'); */
        //rpAddShippingCharge2ndDayAirAM('59');
        /*         rpAddShippingChargeNextDayAirSaver('13');
                rpAddShippingChargeNextDayAir('01'); */
        //rpAddShippingChargeNextDayAirEarly('14');
        /*      rpAddShippingChargeWorldwideExpress('07'); */
        //rpAddShippingChargeWorldwideExpressPlus('54');
        /*    rpAddShippingChargeWorldwideExpedited('08'); */
        //rpAddShippingChargeWorldWideSaver('65');
        $('#shipping_country').val('')
        $('#shipping_state').val('')
        //dhlExpress();

    });

    function shippingCharges(stateCode) {

        var zip = $("#shipping_post").val();
        var country = $("#shipping_country").val();
        $.ajax({
            type: "POST",
            beforeSend: function() {
                $(".preloader").show();
            },
            url: "<?php echo SITEURL; ?>ajax_shipping_charges.php",
            data: 'zip=' + zip + '&c=' + country + '&sc=' + stateCode,
            dataType: 'Json',
            success: function(result) {
                if (result['message'] == 'success') {
                    $('#shipping_method').empty().append(`<option value="">Please Select Shipping Method</option>`);
                    result['sr'].forEach(data => {
                        data['shipping_charge'] = (data['shipping_charge'] - 0).toFixed(2)
                        $('#shipping_method').append(`<option value="${data['shipping_charge']}" id="${data['desc']}">${data['desc']} - $${data['shipping_charge']} </option>`);
                    })
                    //  $("#ups_ground").html('UPS Ground' + result['shipping']);
                    $(".preloader").hide();
                } else {
                    $('#shipping_method').empty().append(`<option value="">Please Select Shipping Method</option>`);
                    $(".preloader").hide();
                }

                // $(".preloader").hide();
                //$(".preloader").show();
            }
        });
    }

    function getState(country_id) {
        // var country_id = $('#shipping_country :selected').text();
        // var country_id = $("#shipping_country").val();
        // alert(country_id);
        if (country_id == 0 || country_id == '') {
            $('#shipping_country').css('color', 'grey');
        }
        var shipping_state = <?= json_encode($shipping_state) ?>;
        $.ajax({
            type: "POST",
            url: "<?php echo SITEURL; ?>ajax_state.php",
            // data: {country_id:country_id},
            // data: 'country_id='+country_id,
            data: {
                country_id: country_id,
                shipping_state: shipping_state
            },
            success: function(options) {
                // alert(options);
                // $('#shipping_state').empty().append(options);
                $("#shipping_state").html(options === "" ? "<option value=''>State</option>" : options);
                let zipCode = $('#shipping_post').val();
                if (zipCode) {
                    $('#shipping_post').css('border-color', '');
                    getShippingCharges()
                } else {
                    $('#shipping_post').css('border-color', 'red');
                }

            }
        });
    }

    function cityname() {
        var shipping_city = document.getElementById("shipping_city").value;

        //dhlExpress(shipping_city);

    }

    function dhlExpress(shipping_code, shipping_city) {

        var postcode = '';
        //alert(postcode);
        if (postcode != '') {
            var zip = postcode;
            //alert(zip);
        } else {
            var zip = $("#shipping_post").val();
            //alert(zip);
        }

        var cityname = '';
        //alert(cityname);
        if (shipping_city) {
            var city = shipping_city;
            //alert(city);
        } else {
            var city = $("#shipping_city").val();
        }
        //var zip = $("#shipping_post").val();
        var country = $("#shipping_country").val();
        //var city = $("#shipping_city").val();
        // var s = $("#ups_ground").val();
        city = 'green ville'
        $.ajax({
            type: "POST",
            url: "<?php echo SITEURL; ?>dhl_express.php",
            data: '&zip=' + zip + '&c=' + country + '&city=' + city,
            dataType: 'Json',
            success: function(result) {
                //alert(result)
                if (result['price'] > 0) {
                    $("#dhl_express").html('DHL Express ' + result['price']);
                    $("#dhl_express").show();
                    // alert(result['shipping']);
                } else {
                    $("#dhl_express").hide();
                }

                // $(".preloader").hide();
                // $(".preloader").show();
            }
        });
    }

    function rpAddShippingChargeStandard(s, postcode, sc) {
        var postcode = '';
        //alert(postcode);
        if (postcode != '') {
            var zip = postcode;
        } else {
            var zip = $("#shipping_post").val();
        }

        var country = $("#shipping_country").val();
        // var s = $("#ups_standard").val();
        $.ajax({
            type: "POST",
            url: "<?php echo SITEURL; ?>ajax_add_shipping_charge_standard.php",
            data: 's=' + s + '&zip=' + zip + '&c=' + country + '&sc=' + sc,
            dataType: 'Json',
            success: function(result) {
                if (result['shipping_charge'] != 0) {
                    // $("#ups_standard").html('UPS Standard'+result['shipping']);
                    $("#ups_standard").html('UPS Standard' + result['shipping']);
                    $("#ups_standard").show();
                    // alert(result['shipping']);
                } else {
                    $("#ups_standard").hide();
                }

                // $(".preloader").hide();
                $(".preloader").show();
            }
        });
    }

    function rpAddShippingChargeGround(s, sc) {

        var zip = $("#shipping_post").val();
        var country = $("#shipping_country").val();
        // var s = $("#ups_ground").val();
        $.ajax({
            type: "POST",
            url: "<?php echo SITEURL; ?>ajax_add_shipping_charge_standard.php",
            data: 's=' + s + '&zip=' + zip + '&c=' + country + '&sc=' + sc,
            dataType: 'Json',
            success: function(result) {
                if (result['shipping_charge'] != 0) {
                    $("#ups_ground").html('UPS Ground' + result['shipping']);
                    $("#ups_ground").show();
                    // alert(result['shipping']);
                } else {
                    $("#ups_ground").hide();
                }

                // $(".preloader").hide();
                $(".preloader").show();
            }
        });
    }

    function rpAddShippingCharge3DaySelect(s, sc) {
        var zip = $("#shipping_post").val();
        var country = $("#shipping_country").val();
        // var s = $("#ups_3day_select").val();
        $.ajax({
            type: "POST",
            url: "<?php echo SITEURL; ?>ajax_add_shipping_charge_standard.php",
            data: 's=' + s + '&zip=' + zip + '&c=' + country + '&sc=' + sc,
            dataType: 'Json',
            success: function(result) {
                if (result['shipping_charge'] > 0) {
                    // $("#ups_3day_select").empty().append('UPS 3 Day Select'+result['shipping']);
                    $('#shipping_method').append(`<option value="12">UPS 3 Day Select ${result['shipping']}</option>`);
                    //$("#ups_3day_select").html('UPS 3 Day Select' + result['shipping']);
                    //$("#ups_3day_select").show();
                } else {
                    //$("#ups_3day_select").hide();
                }

                // $(".preloader").hide();
                // $(".preloader").show();
            }
        });
    }

    function rpAddShippingCharge2ndDayAir(s, sc) {
        var zip = $("#shipping_post").val();
        var country = $("#shipping_country").val();
        // var s = $("#ups_2nd_day_air").val();
        $.ajax({
            type: "POST",
            url: "<?php echo SITEURL; ?>ajax_add_shipping_charge_standard.php",
            data: 's=' + s + '&zip=' + zip + '&c=' + country + '&sc=' + sc,
            dataType: 'Json',
            success: function(result) {
                if (result['shipping_charge'] > 0) {
                    // $("#ups_2nd_day_air").empty().append('UPS 2nd Day Air'+result['shipping']);
                    $("#ups_2nd_day_air").html('UPS 2nd Day Air' + result['shipping']);
                    $("#ups_2nd_day_air").show();
                } else {
                    $("#ups_2nd_day_air").hide();
                }

                // $(".preloader").hide();
                // $(".preloader").show();
            }
        });
    }

    function rpAddShippingCharge2ndDayAirAM(s, sc) {
        var zip = $("#shipping_post").val();
        var country = $("#shipping_country").val();
        // var s = $("#ups_2nd_day_air_am").val();
        $.ajax({
            type: "POST",
            url: "<?php echo SITEURL; ?>ajax_add_shipping_charge_standard.php",
            data: 's=' + s + '&zip=' + zip + '&c=' + country + '&sc=' + sc,
            dataType: 'Json',
            success: function(result) {
                if (result['shipping_charge'] > 0) {
                    $("#ups_2nd_day_air_am").empty().append('UPS 2nd Day Air AM' + result['shipping']);
                    $("#ups_2nd_day_air_am").show();
                } else {
                    $("#ups_2nd_day_air_am").hide();
                }
                // $(".preloader").hide();
                // $(".preloader").show();
            }
        });
    }

    function rpAddShippingChargeNextDayAirSaver(s, sc) {
        var zip = $("#shipping_post").val();
        var country = $("#shipping_country").val();
        // var s = $("#ups_next_day_air_saver").val();
        $.ajax({
            type: "POST",
            url: "<?php echo SITEURL; ?>ajax_add_shipping_charge_standard.php",
            data: 's=' + s + '&zip=' + zip + '&c=' + country + '&sc=' + sc,
            dataType: 'Json',
            success: function(result) {
                if (result['shipping_charge']) {
                    $("#ups_next_day_air_saver").empty().append('UPS Next Day Air Saver' + result['shipping']);
                    $("#ups_next_day_air_saver").show();
                } else {
                    $("#ups_next_day_air_saver").hide();
                }

                // $(".preloader").hide();
                // $(".preloader").show();
            }
        });
    }

    function rpAddShippingChargeNextDayAir(s, sc) {
        var zip = $("#shipping_post").val();
        var country = $("#shipping_country").val();
        // var s = $("#ups_next_day_air").val();
        $.ajax({
            type: "POST",
            url: "<?php echo SITEURL; ?>ajax_add_shipping_charge_standard.php",
            data: 's=' + s + '&zip=' + zip + '&c=' + country + '&sc=' + sc,
            dataType: 'Json',
            success: function(result) {
                if (result['shipping_charge'] > 0) {
                    $("#ups_next_day_air").empty().append('UPS Next Day Air' + result['shipping']);
                    $("#ups_next_day_air").show();
                } else {
                    $("#ups_next_day_air").hide();
                }

                $(".preloader").hide();
                // $(".preloader").show();
            }
        });
    }

    function rpAddShippingChargeNextDayAirEarly(s, sc) {
        var zip = $("#shipping_post").val();
        var country = $("#shipping_country").val();
        // var s = $("#ups_next_day_air_early_am").val();
        $.ajax({
            type: "POST",
            url: "<?php echo SITEURL; ?>ajax_add_shipping_charge_standard.php",
            data: 's=' + s + '&zip=' + zip + '&c=' + country + '&sc=' + sc,
            dataType: 'Json',
            success: function(result) {
                if (result['shipping_charge'] > 0) {
                    $("#ups_next_day_air_early_am").empty().append('UPS Next Day Air Early A.M.' + result['shipping']);
                    $("#ups_next_day_air_early_am").show();
                } else {
                    $("#ups_next_day_air_early_am").hide();
                }

                // $(".preloader").hide();
                // $(".preloader").show();
            }
        });
    }

    function rpAddShippingChargeWorldwideExpress(s, sc) {
        var zip = $("#shipping_post").val();
        var country = $("#shipping_country").val();
        // var s = $("#ups_wsorldwide_express").val();
        $.ajax({
            type: "POST",
            url: "<?php echo SITEURL; ?>ajax_add_shipping_charge_standard.php",
            data: 's=' + s + '&zip=' + zip + '&c=' + country + '&sc=' + sc,
            dataType: 'Json',
            success: function(result) {
                if (result['shipping_charge'] > 0) {
                    $("#ups_wsorldwide_express").empty().append('UPS Worldwide Express' + result['shipping']);
                    $("#ups_wsorldwide_express").show();
                } else {
                    $("#ups_wsorldwide_express").hide();
                }

                // $(".preloader").hide();
                // $(".preloader").show();
            }
        });
    }

    function rpAddShippingChargeWorldwideExpressPlus(s, sc) {
        var zip = $("#shipping_post").val();
        var country = $("#shipping_country").val();
        // var s = $("#ups_worldwide_express_plus").val();
        $.ajax({
            type: "POST",
            url: "<?php echo SITEURL; ?>ajax_add_shipping_charge_standard.php",
            data: 's=' + s + '&zip=' + zip + '&c=' + country + '&sc=' + sc,
            dataType: 'Json',
            success: function(result) {
                if (result['shipping_charge'] > 0) {
                    $("#ups_worldwide_express_plus").empty().append('UPS Worldwide Express Plus' + result['shipping']);
                    $("#ups_worldwide_express_plus").show();
                } else {
                    $("#ups_worldwide_express_plus").hide();
                }

                // $(".preloader").hide();
                // $(".preloader").show();
            }
        });
    }

    function rpAddShippingChargeWorldwideExpedited(s, sc) {
        var zip = $("#shipping_post").val();
        var country = $("#shipping_country").val();
        // var s = $("#ups_worldwide_expedited").val();
        $.ajax({
            type: "POST",
            url: "<?php echo SITEURL; ?>ajax_add_shipping_charge_standard.php",
            data: 's=' + s + '&zip=' + zip + '&c=' + country + '&sc=' + sc,
            dataType: 'Json',
            success: function(result) {
                if (result['shipping_charge'] > 0) {
                    $("#ups_worldwide_expedited").empty().append('UPS Worldwide Expedited' + result['shipping']);
                    $("#ups_worldwide_expedited").show();
                } else {
                    $("#ups_worldwide_expedited").hide();
                }

                // $(".preloader").hide();
                // $(".preloader").show();
            }
        });
    }

    function rpAddShippingChargeWorldWideSaver(s, sc) {
        var zip = $("#shipping_post").val();
        var country = $("#shipping_country").val();
        // var s = $("#ups_world_wide_saver").val();
        $.ajax({
            type: "POST",
            url: "<?php echo SITEURL; ?>ajax_add_shipping_charge_standard.php",
            data: 's=' + s + '&zip=' + zip + '&c=' + country + '&sc=' + sc,
            dataType: 'Json',
            success: function(result) {
                if (result['shipping_charge'] > 0) {
                    $("#ups_world_wide_saver").empty().append('UPS World Wide Saver' + result['shipping']);
                    $("#ups_world_wide_saver").show();
                } else {
                    $("#ups_world_wide_saver").hide();
                }
                $(".preloader").hide();
            }
        });
    }

    // phone number formate start
    /*     let telEl = document.querySelector('#shipping_phone');
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


    // var zChar = new Array(' ', '(', ')', '-', '.');
    // var maxphonelength = 13;
    // var phonevalue1;
    // var phonevalue2;
    // var cursorposition;

    // function ParseForNumber1(object) {
    //     phonevalue1 = ParseChar(object.value, zChar);
    // }

    // function ParseForNumber2(object) {
    //     phonevalue2 = ParseChar(object.value, zChar);
    // }

    // function backspacerUP(object, e) {
    //     if (e) {
    //         e = e
    //     } else {
    //         e = window.event
    //     }
    //     if (e.which) {
    //         var keycode = e.which
    //     } else {
    //         var keycode = e.keyCode
    //     }

    //     ParseForNumber1(object)

    //     if (keycode >= 48) {
    //         ValidatePhone(object)
    //     }
    // }

    // function backspacerDOWN(object, e) {
    //     if (e) {
    //         e = e
    //     } else {
    //         e = window.event
    //     }
    //     if (e.which) {
    //         var keycode = e.which
    //     } else {
    //         var keycode = e.keyCode
    //     }
    //     ParseForNumber2(object)
    // }

    // function GetCursorPosition() {

    //     var t1 = phonevalue1;
    //     var t2 = phonevalue2;
    //     var bool = false
    //     for (i = 0; i < t1.length; i++) {
    //         if (t1.substring(i, 1) != t2.substring(i, 1)) {
    //             if (!bool) {
    //                 cursorposition = i
    //                 bool = true
    //             }
    //         }
    //     }
    // }

    // function ValidatePhone(object) {

    //     var p = phonevalue1

    //     p = p.replace(/[^\d]*/gi, "")

    //     if (p.length < 3) {
    //         object.value = p
    //     } else if (p.length == 3) {
    //         pp = p;
    //         d4 = p.indexOf('(')
    //         d5 = p.indexOf(')')
    //         if (d4 == -1) {
    //             pp = "(" + pp;
    //         }
    //         if (d5 == -1) {
    //             pp = pp + ")";
    //         }
    //         object.value = pp;
    //     } else if (p.length > 3 && p.length < 7) {
    //         p = "(" + p;
    //         l30 = p.length;
    //         p30 = p.substring(0, 4);
    //         p30 = p30 + ")"

    //         p31 = p.substring(4, l30);
    //         pp = p30 + p31;

    //         object.value = pp;

    //     } else if (p.length >= 7) {
    //         p = "(" + p;
    //         l30 = p.length;
    //         p30 = p.substring(0, 4);
    //         p30 = p30 + ")"

    //         p31 = p.substring(4, l30);
    //         pp = p30 + p31;

    //         l40 = pp.length;
    //         p40 = pp.substring(0, 8);
    //         p40 = p40 + "-"

    //         p41 = pp.substring(8, l40);
    //         ppp = p40 + p41;

    //         object.value = ppp.substring(0, maxphonelength);
    //     }

    //     GetCursorPosition()

    //     if (cursorposition >= 0) {
    //         if (cursorposition == 0) {
    //             cursorposition = 2
    //         } else if (cursorposition <= 2) {
    //             cursorposition = cursorposition + 1
    //         } else if (cursorposition <= 5) {
    //             cursorposition = cursorposition + 2
    //         } else if (cursorposition == 6) {
    //             cursorposition = cursorposition + 2
    //         } else if (cursorposition == 7) {
    //             cursorposition = cursorposition + 4
    //             e1 = object.value.indexOf(')')
    //             e2 = object.value.indexOf('-')
    //             if (e1 > -1 && e2 > -1) {
    //                 if (e2 - e1 == 4) {
    //                     cursorposition = cursorposition - 1
    //                 }
    //             }
    //         } else if (cursorposition < 11) {
    //             cursorposition = cursorposition + 3
    //         } else if (cursorposition == 11) {
    //             cursorposition = cursorposition + 1
    //         } else if (cursorposition >= 12) {
    //             cursorposition = cursorposition
    //         }

    //         var txtRange = object.createTextRange();
    //         txtRange.moveStart("character", cursorposition);
    //         txtRange.moveEnd("character", cursorposition - object.value.length);
    //         txtRange.select();
    //     }

    // }

    // function ParseChar(sStr, sChar) {
    //     if (sChar.length == null) {
    //         zChar = new Array(sChar);
    //     } else zChar = sChar;

    //     for (i = 0; i < zChar.length; i++) {
    //         sNewStr = "";

    //         var iStart = 0;
    //         var iEnd = sStr.indexOf(sChar[i]);

    //         while (iEnd != -1) {
    //             sNewStr += sStr.substring(iStart, iEnd);
    //             iStart = iEnd + 1;
    //             iEnd = sStr.indexOf(sChar[i], iStart);
    //         }
    //         sNewStr += sStr.substring(sStr.lastIndexOf(sChar[i]) + 1, sStr.length);

    //         sStr = sNewStr;
    //     }

    //     return sNewStr;
    // }
    // var clipboard = new Clipboard('.btn');

    // clipboard.on('success', function(e) {
    //     console.log(e);
    // });

    // clipboard.on('error', function(e) {
    //     console.log(e);
    // });

    // phone number formate end
</script>
<style>
    .iti {
        width: 100%;
    }
</style>