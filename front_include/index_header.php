<?php
$admin_phone = $db->getValue("site_setting", "mnumber", "isDelete=0");
?>
<style>
    .top-drawer {
        position: absolute;
        background: #cf3e2e;
        margin-left: 0;
        width: 99vw;
        z-index: 1000;
        transition: height .2s ease;
    }

    .top-drawer.active {
        height: 200px;
    }

    .wrapper {
        display: grid;
        grid-template-rows: 0fr;
        transition: grid-template-rows 0.5s ease-out;
    }

    .wrapper.is-open {
        grid-template-rows: 1fr;
    }

    .inner {
        overflow: hidden;
    }

    .accordion-body {
        display: grid;
        grid-template-rows: 0fr;
        transition: 250ms grid-template-rows ease;
    }

    .accordion:hover .accordion-body {
        grid-template-rows: 1fr;
    }

    .accordion-body>div {
        overflow: hidden;
    }

    .card {
        border: none;
        /* Remove border */
        border-radius: 0;
        /* Remove border radius */
        background: transparent;
        /* Remove background */
    }

    .card-body {
        padding: 20px;
        /* Adjust padding inside card */
    }
</style>
<input type="hidden" name="SITEURL" id="SITEURL" value="<?php echo SITEURL; ?>">
<!-- Desktop menu Start -->
<div class="preloader">
    <img class="rotate" src="<?php echo SITEURL; ?>img/home/CLEAR_new_logo_color_lg.png" alt="">
</div>

<header class="header">
    <div class="header-topbar">
        <div class="container-fluid">
            <div class="row justify-content-end">
                <div class="col-lg-9">
                    <p class="m-3">
                    <!-- <a id="chevron-down" href="javascript:void(0)"><i class="fa fa-chevron-down text-white mr-3" data-toggle="collapse" href="#collapsibleTopBanner" role="button" aria-expanded="false" aria-controls="collapsibleTopBanner"><span class="ml-3 text-white font-stratum-web-med">Free Shipping on All Orders Through January 5th!</span></i> -->
                        <a id="chevron-down" href="<?php echo SITEURL; ?>login/"><span class="ml-3 text-white font-stratum-web-med">Join CB Nation for a sneak peek at new products, exclusive offers, and special events!</span>

                        </a>

                    </p>
                </div>
                <!--                 <div class="col-lg-6">
                    <div class="text-center">
                        <a href="<?php echo SITEURL ?>product/promotions" class="text-decoration-none text-white invisible">
                            <h5 style="padding: 8px 15px 8px 20px;margin-right: 70px;">INDEPENDENCE DAY SALE</h5>
                        </a>
                    </div>
                </div> -->
                <div class="col-lg-3">
                    <div class="pull-right font-stratum-web-med">
                        <ul> 
                            <!-- <li><a href="https://ballisticsguy.com/">LEGACY SITE</a></li> -->
                            <li style="padding: 8px 15px 8px 20px;"><a href="<?php echo SITEURL ?>our-retailers/">Retailers</a></li>
                            <?php if (isset($_SESSION[SESS_PRE . '_SESS_USER_ID']) && $_SESSION[SESS_PRE . '_SESS_USER_ID'] != "") { ?>
                                <li class="profile">
                                    <a href="javascript:void(0);">Account</a>
                                    <div class="profile-dropdown">
                                        <div class="profile-name">
                                            <img src="<?php echo SITEURL; ?>img/user_logo.png">
                                            <div class="profile-info">
                                                <h4>Hello</h4>
                                                <span><?php echo $_SESSION[SESS_PRE . '_SESS_USER_NAME']; ?></span>
                                            </div>
                                        </div>
                                        <div class="profile-menu">
                                            <ul>
                                                <!-- <li><a href="<?php echo SITEURL; ?>"> Account Settings</a></li>
                                            <li><a href="<?php echo SITEURL; ?>profile/"> My Profile </a></li> -->

                                                <li class="nav-title"><a href="<?php echo SITEURL; ?>profile">ACCOUNT DASHBOARD</a></li>
                                                <li class="nav-title"><a href="<?php echo SITEURL; ?>profile-update">PROFILE</a></li>
                                                <li class="nav-title"><a href="<?php echo SITEURL; ?>address-update">ADDRESS BOOK</a></li>
                                                <!-- <li class="nav-title"><a href="#">PAYMENT INFORMATION</a></li> -->
                                                <li class="nav-title"><a href="<?php echo SITEURL; ?>order-history">ORDER HISTORY</a></li>
                                                <!-- <li class="nav-title"><a href="#">MY WISHLIST</a></li> -->
                                                <!-- <li class="nav-title"><a href="#">PRODUCT REGISTRATION</a></li> -->
                                            </ul>
                                        </div>
                                        <div class="sign-out-btn">
                                            <a href="<?php echo SITEURL ?>logout/"><i class="fa fa-sign-out" aria-hidden="true"></i> Sign Out</a>
                                        </div>
                                    </div>
                                </li>
                            <?php } else { ?>
                                <li><a href="<?php echo SITEURL ?>login/">Sign in</a></li>
                            <?php } ?>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="top-drawer font-stratum-web-med collapse" id="collapsibleTopBanner">

        <div class="row p-5 text-white">
            <!-- Column 1 -->
            <div class="col-md-4">
                <div class="card">
                    <div class="card-title">
                        <h4 class="mb-4 text-uppercase">Exclusive Gifts on Us</h4>
                        <p class="mb-4">Spend $300 for a Yeti 20oz Rambler, $500 for an FBI Block, or $1000 for a Yeti Roadie 24 Cooler!</p>
                    </div>
                    <a href="<?php echo SITEURL; ?>product/ballistics-gel" class="text-white text-uppercase font-stratum-web-bold" style="text-decoration-line: underline;">SHOP NOW</a>
                    <p class="font-stratum-web-med"><small>Offer expires 12/20/24 at 11:59 PM EST.</small></p>
                </div>
            </div>

            <!-- Column 2 -->
            <div class="col-md-4">
                <div class="card">
                    <div class="card-title">
                        <h4 class="mb-4 text-uppercase">Top Gifts</h4>
                        <p class="mb-4 font-stratum-web-light">Gear up with ballistic gel blocks, dummies, and must-have hunting gifts!</p>
                    </div>
                    <a href="<?php echo SITEURL; ?>product/top-gifts" class="text-white text-uppercase font-stratum-web-bold" style="text-decoration-line: underline;">SHOP NOW</a>
                    <p class="font-stratum-web-reg"><small>Place orders by 12/18/24 (Ground) or 12/20/24 (Next Day Air) to ensure delivery by Christmas.</small></p>
                </div>
            </div>

            <!-- Column 3 -->
            <div class="col-md-4">
                <div class="card">
                    <div class="card-title">
                        <h4 class="mb-4 text-uppercase">Explore Every Gift Option</h4>
                        <p class="mb-4 font-stratum-web-light">Discover all ballistic gel holiday gifts.</p>
                    </div>
                    <a href="<?php echo SITEURL; ?>product/ballistics-gel" class="text-white text-uppercase font-stratum-web-bold" style="text-decoration-line: underline;">SHOP NOW</a>
                </div>
            </div>


            <div class="col text-center">
                <p class="m-3"><a id="chevron" href="javascript:void(0)"><i class="fa fa-chevron-up text-white" data-toggle="collapse" href="#collapsibleTopBanner" role="button" aria-expanded="false" aria-controls="collapsibleTopBanner"></i></a></p>
            </div>


        </div>
    </div>
    <div class="header-main me_sticky px-2">
        <div class="container-fluid">
            <div class="row align-items-center justify-content-between">
                <div class="header-logo">
                    <a href="<?php echo SITEURL; ?>">
                        <img src="<?php echo SITEURL; ?>img/main-logo.png">
                    </a>
                </div>
                <div class="header-menu">
                    <nav class="nav-main">
                        <ul>
                            <li class="primary-item-cb">
                                <a class="primary-nav-link-cb" href="<?php echo SITEURL ?>product/ballistics-gel">BALLISTICS GEL</a>
                                <div class="mega-menu">
                                    <div class="container-fluid">
                                        <div class="row justify-content-center">
                                            <div class="col-md-2 text-center">
                                                <h3 class="pb-3 text-center"><a href="
                                                    <?php echo SITEURL ?>product/10-ballistics-gel">10% BALLISTICS GEL</a></h3>
                                                <ul style="align-items :center">
                                                    <li><a href="<?php echo SITEURL ?>shop/fbi-block/1/">FBI BLOCK</a></li>
                                                    <li><a href="<?php echo SITEURL ?>shop/long-range-block/10/">LONG RANGE BLOCK</a></li>
                                                    <li><a href="<?php echo SITEURL ?>shop/joe-fit-torso/11/">JOE FIT TORSO</a></li>
                                                    <li><a href="<?php echo SITEURL ?>shop/starter-kit/7/">STARTER KIT</a></li>
                                                    <li><a href="<?php echo SITEURL ?>product/10-ballistics-gel">& MORE</a></li>
                                                </ul>
                                            </div>
                                            <div class="col-md-2 text-center">
                                                <h3 class="pb-3 text-center"><a href="
                                                    <?php echo SITEURL ?>product/20-ballistics-gel">20% BALLISTICS GEL</a></h3>
                                                <ul style="align-items :center">
                                                    <li><a href="<?php echo SITEURL ?>product/nato-block">NATO BLOCK</a></li>
                                                    <li><a href="<?php echo SITEURL ?>product/20-gel-long-range-block">LONG RANGE BLOCK</a></li>
                                                    <li><a href="<?php echo SITEURL ?>product/20-gel-joe-fit-torso-gel">JOE FIT TORSO</a></li>
                                                    <li><a href="<?php echo SITEURL ?>product/20-gel-starter-kit">STARTER KIT</a></li>
                                                    <li><a href="<?php echo SITEURL ?>product/20-ballistics-gel">& MORE</a></li>
                                                </ul>
                                            </div>
                                            <div class="col-md-2 text-center">
                                                <h3 class="pb-3 text-center"><a href="
                                                    <?php echo SITEURL ?>product/dummies">DUMMIES</a></h3>
                                                <ul style="align-items :center">
                                                    <li><a href="<?php echo SITEURL ?>product/joe-fit-head">JOE FIT HEAD</a></li>
                                                    <li><a href="<?php echo SITEURL ?>product/joe-fit-torso">JOE FIT TORSO</a></li>
                                                    <!-- <li><a href="<?php echo SITEURL ?>shop/loaded-ballistic-gel-ken-bust">Loaded Ken Bust</a></li> -->
                                                    <li><a href="<?php echo SITEURL ?>product/dummies">& MORE</a></li>
                                                </ul>
                                            </div>
                                            <div class="col-md-2 text-center">
                                                <h3 class="pb-3 text-center"><a href="
                                                    <?php echo SITEURL ?>product/testing-kits">TESTING KITS</a></h3>
                                                <ul style="align-items :center">
                                                    <li><a href="<?php echo SITEURL ?>product/guns">GUNS</a></li>
                                                    <li><a href="<?php echo SITEURL ?>shop/archery/55/">ARCHERY</a></li>
                                                    <li><a href="<?php echo SITEURL ?>product/testing-kits">& MORE</a></li>
                                                </ul>
                                            </div>
                                            <div class="col-md-2 text-center">
                                                <h3 class="pb-3 text-center"><a href="
                                                    <?php echo SITEURL ?>product/ballistic-animals">BALLISTICS ANIMALS</a></h3>
                                                <ul style="align-items :center">
                                                    <li><a href="<?php echo SITEURL ?>shop/squirrel/92/">Squirrel</a></li>
                                                    <li><a href="<?php echo SITEURL ?>shop/rabbit/91/">Rabbit</a></li>
                                                    <li><a href="<?php echo SITEURL ?>shop/gummy-bear/93/">Gummy Bear</a></li>
                                                    <li><a href="<?php echo SITEURL ?>shop/duck/97/">DUCK</a></li>
                                                    <li><a href="<?php echo SITEURL ?>product/ballistic-animals">& MORE</a></li>
                                                </ul>
                                            </div>
                                            <div class="col-md-2 text-center">
                                                <h3 class="pb-3 text-center"><a href="
                                                    <?php echo SITEURL; ?>shop/zombie-zed/">ZOMBIE</a></h3>
                                                <ul style="align-items :center">
                                                    <li><a href="<?php echo SITEURL; ?>shop/zombie-zed/">ZOMBIE ZED</a></li>
                                                </ul>
                                            </div>
                                            <div class="col-md-2">
                                                <div class="mega-img">
                                                    <img src="<?php echo SITEURL ?>img/mega-img.jpg">
                                                    <div class="mega-btn">
                                                        <a href="<?php echo SITEURL ?>product/10-ballistics-gel" class="btn-transparent">SHOP 10% BALLISTICS GEL </a>
                                                    </div>
                                                </div>
                                            </div>

                                        </div>
                                    </div>
                                </div>
                            </li>
                            <li class="primary-item-cb">
                                <a class="primary-nav-link-cb" href="<?php echo SITEURL ?>product/accessories">ACCESSORIES</a>
                                <div class="mega-menu">
                                    <div class="container-fluid">
                                        <div class="row justify-content-center">
                                            <div class="col-md-2 text-center">
                                                <h3 class="pb-3 text-center"><a href="
                                                    <?php echo SITEURL ?>product/accessories">ACCESSORIES</a></h3>
                                                <ul style="align-items :center">
                                                    <li><a href="<?php echo SITEURL ?>product/cookers">COOKERS</a></li>
                                                    <li><a href="<?php echo SITEURL ?>product/display-case">DISPLAY CASE</a></li>
                                                    <li><a href="<?php echo SITEURL ?>product/molds">MOLDS</a></li>
                                                    <li><a href="<?php echo SITEURL ?>product/remelting-kits">REMELTING KITS</a></li>
                                                    <li><a href="<?php echo SITEURL ?>product/supplies">SUPPLIES</a></li>
                                                    <li><a href="<?php echo SITEURL; ?>shop/fake-blood-1000ml/">FAKE BLOOD</a></li>
                                                </ul>
                                            </div>
                                            <div class="col-md-2 text-center">
                                                <h3 class="pb-3 text-center"><a href="
                                                    <?php echo SITEURL ?>apparel/">APPAREL</a></h3>
                                                <ul style="align-items :center">
                                                    <li><a href="<?php echo SITEURL ?>apparel/t-shirts">T-SHIRTS</a></li>
                                                    <li><a href="<?php echo SITEURL ?>apparel/hats">HATS</a></li>
                                                    <li><a href="<?php echo SITEURL ?>apparel/stickers">Stickers</a></li>
                                                </ul>
                                            </div>
                                            <div class="col-md-2">
                                                <div class="mega-img">
                                                    <img src="<?php echo SITEURL ?>img/cooker-mega-menu.jpg">
                                                    <div class="mega-btn">
                                                        <a href="<?php echo SITEURL ?>product/accessories" class="btn-transparent">THE ACCESSORIES YOU NEED </a>
                                                    </div>
                                                </div>
                                            </div>

                                        </div>
                                    </div>
                                </div>
                            </li>
<!--                             <li class="primary-item-cb">
                                <a class="primary-nav-link-cb" href="<?php echo SITEURL ?>product/top-gifts">GIFTS</a>
                            </li> -->
                            <li class="primary-item-cb">
                                <a class="primary-nav-link-cb" href="https://www.humimic.com">MEDICAL</a>
                                <div class="mega-menu">
                                    <div class="container-fluid">
                                        <div class="row justify-content-center">
                                            <div class="col-md-2 text-center">
                                                <h3 class="pb-3 text-center"><a href="
                                                    <?php echo SITEURL ?>humimic-medical/">MEDICAL</a></h3>
                                                <ul style="align-items :center">
                                                    <li><a href="https://humimic.com/product-category/medical-gels/medical-gels-medical-gels/">Medical Gels</a></li>
                                                    <li><a href="https://humimic.com/product-category/phantoms/">Task Trainers</a></li>
                                                </ul>
                                            </div>
                                            <div class="col-md-2">
                                                <div class="mega-img">
                                                    <img src="<?php echo SITEURL ?>img/home/Medical-Gels-menu.png">
                                                    <div class="mega-btn">
                                                        <a href="https://humimic.com/" class="btn-transparent">CHECK OUT HUMIMIC MEDICAL </a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </li>
                            <li class="primary-item-cb"><a class="primary-nav-link-cb" href="<?php echo SITEURL ?>custom-form/">CUSTOM </a>
                                <div class="mega-menu">
                                    <div class="row justify-content-center">
                                        <div class="col-md-3">
                                            <!-- <h3 class="pb-3"><a href="<?php echo SITEURL ?>custome">LEARN MORE</a></h3> -->
                                            <h3 class="pb-3"><a href="<?php echo SITEURL ?>custom-form">CUSTOM</a></h3>
                                            <ul>
                                                <!-- <li><a href="<?php echo SITEURL ?>custome">custom projects</a></li> -->
                                                <!-- <li><a href="<?php echo SITEURL ?>product/learn-more">LEARN MORE </a></li> -->
                                                <!-- <li><a href="<?php echo SITEURL ?>marketing-requests/">Get a custom quote  </a></li> -->
                                                <li><a href="<?php echo SITEURL ?>custom-form/">Get a custom quote </a></li>
                                            </ul>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="mega-img">
                                                <img src="<?php echo SITEURL ?>img/custom_img.jpg">
                                                <p>LEARN MORE </p>
                                                <div class="mega-btn">
                                                    <a href="<?php echo SITEURL ?>contact/" class="btn-transparent">LEARN MORE</a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </li>
                            <li class="primary-item-cb"><a class="primary-nav-link-cb" href="<?php echo SITEURL ?>about/">THIS IS CB </a>
                                <div class="mega-menu">
                                    <div class="row justify-content-center">
                                        <div class="col-md-3">
                                            <h3 class="pb-3"><a href="<?php echo SITEURL ?>product/this-is-clear-ballistics/">This is Clear Ballistics </a></h3>
                                            <ul>
                                                <li><a href="<?php echo SITEURL ?>about/">OUR STORY </a></li>
                                                <li><a href="<?php echo SITEURL ?>our-partners/">OUR PARTNERS </a></li>
                                                <li><a href="<?php echo SITEURL ?>see-what-you-shoot/">#SEEWHATYOUSHOOT </a></li>
                                                <li><a href="<?php echo SITEURL ?>news/">NEWS </a></li>
                                                <li><a href="<?php echo SITEURL ?>blog/">BLOG </a></li>
                                                <li><a href="<?php echo SITEURL ?>video/">VIDEOS </a></li>
                                            </ul>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="mega-img">
                                                <img src="<?php echo SITEURL ?>img/home/this-is-cb-mega-menu.png">
                                                <div class="mega-btn">
                                                    <a href="<?php echo SITEURL ?>10vs20-gelatin/" class="btn-transparent">THE DIFFERENCE IS CLEAR </a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </li>
                        </ul>
                    </nav>
                </div>
                <div class="cart-search">
                    <ul>
                        <li id="search-btn" class="search-bar"><a href="#">SEARCH <i class="fa fa-search"></i></a></li>
                        <div id="search-overlay" class="block">
                            <div class="search-modal-centered">
                                <div id='search-box'>
                                    <i id="close-btn" class="fa fa-times fa-2x"></i>
                                    <form action='<?php echo SITEURL ?>product_search/' id='search-form' method='get' target='_top'>
                                        <input id='search-text' name='main_search' id="main_search" placeholder='Search' type='text' required />
                                        <button id='search-button' type='submit'>
                                            <span>Search</span>
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                        <li class="header-cart">
                            <a href="<?php echo SITEURL; ?>cart/">CART<span class="total_header_cart">
                                    <?php
                                    if (isset($_SESSION[SESS_PRE . '_SESS_CART_ID'])) {
                                        echo $db->getValue("cart_detail", "IFNULL(SUM(qty), 0)", "cart_id=" . $_SESSION[SESS_PRE . '_SESS_CART_ID'] . " AND isDelete = 0");
                                    } else {
                                        echo "0";
                                    }
                                    ?> </span><i class="fa fa-caret-down"></i></a>
                            <div class="mini-cart-content-wrap" id="header_cart_result"></div>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</header>
<!-- Desktop menu End -->

<!-- mobile menu start -->
<div class="mobile-menu">
    <nav class="mobile-menu-device">
        <div class="row text-center d-lg-none d-none" style="background-color: #cf3e2e;">
            <div class="col-12 p-3">
                <!--   <a href="javascript:void(0)" class="text-decoration-none text-white">
                    <h5 class="text-white font-stratum-web-med"> <i class="fa fa-chevron-down mr-2" data-toggle="collapse" href="#mobileTop" role="button" aria-expanded="false" aria-controls="mobileTop"></i>HOLIDAY GIFT GUIDE</h5>
                </a> -->
                <a href="javascript:void(0)"><i class="fa fa-chevron-down text-white mr-3" data-toggle="collapse" href="#mobileTop" role="button" aria-expanded="false" aria-controls="mobileTop"><span class="ml-3 text-white font-stratum-web-med">Free Gifts with Holiday Orders!</span></i>

                </a>
            </div>
        </div>
        <div class=" p-5 collapse" style="position: absolute;z-index: 1000;background: rgb(207, 62, 46);width: 100vw;left: 0;right: 0;"
            id="mobileTop">
            <div class="row">
                <div class="col-12">
                    <div class="slick-slider-banner text-white">
                        <div class="slide">
                            <h3 class="mb-4 text-uppercase">Exclusive Gifts on Us</h4>
                                <p class="mb-4 font-stratum-web-med h5">Spend $300 for a Yeti 20oz Rambler, $500 for an FBI Block, or $1000 for a Yeti Roadie 24 Cooler!</p>
                                <a href="<?php echo SITEURL; ?>product/top-gifts" class="text-white text-uppercase font-stratum-web-bold" style="text-decoration-line: underline;">SHOP NOW</a>
                                <p class="font-stratum-web-reg"><small>Offer expires 12/20/24 at 11:59 PM EST.</small></p>
                        </div>
                        <div class="slide">
                            <h3 class="mb-4 text-uppercase">Top Gifts</h4>
                                <p class="mb-4 font-stratum-web-med h5">Gear up with ballistic gel blocks, dummies, and must-have hunting gifts!</p>
                                <a href="<?php echo SITEURL; ?>product/top-gifts" class="text-white text-uppercase font-stratum-web-bold" style="text-decoration-line: underline;">SHOP NOW</a>
                                <p class="font-stratum-web-reg"><small>Place orders by 12/18/24 (Ground) or 12/20/24 (Next Day Air) to ensure delivery by Christmas.</small></p>
                        </div>
                        <div class="slide">
                            <h3 class="mb-4 text-uppercase">Explore Every Gift Option</h3>
                            <p class="mb-4 font-stratum-web-med h5">Discover all ballistic gel holiday gifts.</p>
                            <a href="<?php echo SITEURL; ?>product/ballistics-gel" class="text-white text-uppercase font-stratum-web-bold" style="text-decoration-line: underline;">SHOP NOW</a>
                        </div>
                    </div>
                </div>

                <div class="col text-center">
                    <p class="m-3"><a id="chevron" href="javascript:void(0)"><i class="fa fa-chevron-up text-white" data-toggle="collapse" href="#mobileTop" role="button" aria-expanded="false" aria-controls="mobileTop"></i></a></p>
                </div>

            </div>
        </div>

        <div class="mobile-menu_nav">
            <div class="logo">
                <a href="<?php echo SITEURL; ?>"><img src="<?php echo SITEURL; ?>img/main-logo.png"></a>
            </div>
            <form id="search_mobile_form" name="search_mobile_form" method="POST" action="<?php echo SITEURL; ?>product_search/" enctype='multipart/form-data'>
                <div class="search-box">
                    <input type="text" class="search-text" name="search_mobile" id="search_mobile" placeholder="Search..." autocomplete="off" required="">
                    <button type="submit" name="search_submit" id="search_submit" class="search-btn">
                        <i class="fa fa-search"></i>
                    </button>
                </div>
                <?php if (!isset($_SESSION[SESS_PRE . '_SESS_USER_ID']) && $_SESSION[SESS_PRE . '_SESS_USER_ID'] == "") { ?>
                    <div class="signin-box">
                        <button class="search-btn" onclick="location.href='/login';">
                            <i class="fa fa-sign-in"></i>
                        </button>
                    </div>
                <?php
                }
                ?>
            </form>
            <div class="mobile-cart-item">
                <a href="<?php echo SITEURL ?>cart/">
                    <img src="<?php echo SITEURL; ?>img/icon/icon-bag-2.svg" style="height: 25px;color: white;width: auto;">
                    <span id="total_header_cart_mobile" style="
                                position: absolute;
                                left: 16px;
                                top: 7px;
                                font-family: 'stratum-web-bold';
                                font-size: 10px;
                            " class="inline-block">
                        <?php
                        if (isset($_SESSION[SESS_PRE . '_SESS_CART_ID'])) {
                            echo $db->getValue("cart_detail", "IFNULL(SUM(qty), 0)", "cart_id=" . $_SESSION[SESS_PRE . '_SESS_CART_ID'] . " AND isDelete = 0");
                        } else {
                            echo "0";
                        }
                        ?>
                    </span>
                    </img>
                </a>
            </div>
            <div class="header__actions">
                <a id="resp-menu" class="responsive-menu mobile-toggler" href="#">
                    <img src="<?php echo SITEURL; ?>theme1/img/menu.png" alt="" id="mobile-toggle" onclick="change();">
                </a>
            </div>
        </div>
        <div class="sidebar-navigation">
            <ul>
                <?php
                $category = $db->getData("category", "*", "parent_id = 0 AND isDelete=0");
                while ($category_data = mysqli_fetch_assoc($category)) {
                    if ($category_data['slug'] == 'clearance') {
                        continue;
                    }
                    if ($category_data['slug'] == 'zombie') {
                        continue;
                    }
                    if ($category_data['slug'] == 'promotions') {
                        continue;
                    }
                ?>
                    <li>
                        <?php if ($category_data['slug'] == 'black-friday-sale' || $category_data['slug'] == 'cyber-monday' || $category_data['slug'] == 'top-gifts') { ?>
                        <?php } else { ?>
                            <a href="javascript:void(0);"><?php echo $category_data['name']; ?> <i class="fa fa-chevron-down" aria-hidden="true"></i></a>
                        <?php } ?>
                        <ul>
                            <li>
                                <!-- <a href="<?php
                                                if ($category_data['slug'] == 'medical') {
                                                    echo 'https://www.humimic.com';
                                                } elseif ($category_data['slug'] == 'accessories') {
                                                    echo SITEURL . "accessories/";
                                                } elseif ($category_data['slug'] == 'fbi-block') {
                                                    echo SITEURL . "shop/1/";
                                                } else {
                                                    echo SITEURL . "product/" . $category_data["slug"] . "";
                                                }
                                                ?>"><?php echo $category_data['name']; ?></a> -->
                            </li>
                            <?php
                            $subCategory = $db->getData("category", "*", "parent_id = '" . $category_data['id'] . "' AND isDelete=0");
                            while ($subCategory_data = mysqli_fetch_assoc($subCategory)) {
                            ?>
                                <li>
                                    <a href="#"><?php echo $subCategory_data['name']; ?><i class="fa fa-chevron-down" aria-hidden="true"></i></a>
                                    <ul>
                                        <li>
                                            <a href="<?php
                                                        // dash name
                                                        if ($subCategory_data['slug']  == 'medical') {
                                                            echo SITEURL . "humimic-medical/";
                                                        } elseif ($subCategory_data['slug'] == 'apparel') {
                                                            echo SITEURL . "apparel/";
                                                        } elseif ($subCategory_data['slug'] == 'zombie') {
                                                            echo SITEURL . "shop/zombie-zed/";
                                                        } else {
                                                            echo SITEURL ?>product/<?php echo $subCategory_data['slug'];
                                                                                }
                                                                                    ?>"><?php

                                                                                        // this is for sub category in mobile
                                                                                        if ($subCategory_data['slug'] == 'zombie') {
                                                                                            echo 'ZOMBIE ZED';
                                                                                        } else {
                                                                                            echo $subCategory_data['name'];
                                                                                        }



                                                                                        ?></a>
                                        </li>
                                        <?php
                                        $childCategory = $db->getData("category", "*", "parent_id = '" . $subCategory_data['id'] . "' AND isDelete=0");
                                        while ($childCategory_data = mysqli_fetch_assoc($childCategory)) {
                                            if ($childCategory_data['slug'] == 'loaded-ken-bust') {
                                                continue;
                                            }

                                        ?>
                                            <li><a href="<?php
                                                            if ($childCategory_data['slug'] == 'fbi-block') {
                                                                echo SITEURL . "shop/" . $childCategory_data['slug'] . "/1/";
                                                            } elseif ($childCategory_data['slug'] == 'long-range-block') {
                                                                echo SITEURL . "shop/" . $childCategory_data['slug'] . "/10/";
                                                            } elseif ($childCategory_data['slug'] == 'joe-fit-torso' && $childCategory_data['parent_id'] == '6') {
                                                                echo SITEURL . "shop/" . $childCategory_data['slug'] . "/11/";
                                                            } elseif ($childCategory_data['slug'] == 'starter-kit') {
                                                                echo SITEURL . "shop/" . $childCategory_data['slug'] . "/7/";
                                                            } elseif ($childCategory_data['slug'] == 'loaded-ken-bust') {
                                                                echo SITEURL . "shop/" . "loaded-ballistic-gel-ken-bust";
                                                            } elseif ($childCategory_data['slug'] == 'medical-gels') {
                                                                echo 'https://humimic.com/product-category/medical-gels/medical-gels-medical-gels/';
                                                            } elseif ($childCategory_data['slug'] == 'task-trainers') {
                                                                echo 'https://humimic.com/product-category/phantoms/';
                                                            } elseif ($childCategory_data['slug'] == 'archery') {
                                                                echo SITEURL . "shop/" . $childCategory_data['slug'] . "/55/";
                                                            } elseif ($childCategory_data['slug'] == 'hats') {
                                                                echo SITEURL . "apparel/hats";
                                                            } elseif ($childCategory_data['slug'] == 'stickers') {
                                                                echo SITEURL . "apparel/stickers";
                                                            } elseif ($childCategory_data['slug'] == 't-shirts') {
                                                                echo SITEURL . "apparel/t-shirts";
                                                            } elseif ($childCategory_data['slug'] == 'rabbit') {
                                                                echo SITEURL . "shop/" . $childCategory_data['slug'] . "/91/";
                                                            } elseif ($childCategory_data['slug'] == 'squirrel') {
                                                                echo SITEURL . "shop/" . $childCategory_data['slug'] . "/92/";
                                                            } elseif ($childCategory_data['slug'] == 'gummy-bear') {
                                                                echo SITEURL . "shop/" . $childCategory_data['slug'] . "/93/";
                                                            } elseif ($childCategory_data['slug'] == 'duck') {
                                                                echo SITEURL . "shop/" . $childCategory_data['slug'] . "/97/";
                                                            } elseif ($childCategory_data['slug'] == 'fake-blood') {
                                                                echo SITEURL . "shop/fake-blood-1000ml/";
                                                            } else {
                                                                echo SITEURL . "product/" . $childCategory_data['slug'];
                                                            }
                                                            ?>"><?php echo $childCategory_data['name']; ?></a>
                                            </li>
                                        <?php
                                        } ?>
                                    </ul>
                                <?php
                            } ?>
                        </ul>
                    </li>
                <?php
                } ?>
                <li><a href="#">CUSTOM <i class="fa fa-chevron-down" aria-hidden="true"></i></a>
                    <ul>
                        <li><a href="<?php echo SITEURL ?>product/custom-projects">custom</a></li>
                        <li><a href="#">LEARN MORE</a>
                            <ul>
                                <!-- <li><a href="<?php echo SITEURL ?>product/custom-projects">LEARN MORE</a></li> -->
                                <li><a href="<?php echo SITEURL ?>product/custom-projects">CUSTOM</a></li>
                                <!-- <li><a href="<?php echo SITEURL ?>product/get-a-custom-quote">Get a custom quote</a></li> -->
                                <li><a href="<?php echo SITEURL ?>product/custom-form">Get a custom quote</a></li>
                            </ul>
                        </li>
                    </ul>
                </li>
                <li><a href="<?php echo SITEURL; ?>about/">THIS IS CB<i class="fa fa-chevron-down" aria-hidden="true"></i></a>
                    <ul>
                        <li>
                            <a href="<?php echo SITEURL; ?>about/">This is Clear Ballistics<i class="fa fa-chevron-down" aria-hidden="true"></i></a>
                            <ul>
                                <li><a href="<?php echo SITEURL; ?>about/<?php echo SITEURL; ?>about/">OUR STORY</a></li>
                                <li><a href="<?php echo SITEURL; ?>our-partners/">OUR PARTNERS </a></li>
                                <li><a href="<?php echo SITEURL; ?>see-what-you-shoot/">#SEEWHATYOUSHOOT </a></li>
                                <li><a href="<?php echo SITEURL; ?>news/">NEWS</a></li>
                                <li><a href="<?php echo SITEURL; ?>blog/">BLOG</a></li>
                                <li><a href="<?php echo SITEURL; ?>video/">VIDEOS</a></li>
                            </ul>
                        </li>
                    </ul>
                </li>
               <!--  <li><a href="<?php echo SITEURL ?>product/top-gifts">GIFTS</a></li> -->
                <li><a href="<?php echo SITEURL ?>our-retailers/">Retailers</a></li>
                <!-- <li><a href="<?php echo SITEURL ?>login/">Sign In</a></li> -->
                <?php if (isset($_SESSION[SESS_PRE . '_SESS_USER_ID']) && $_SESSION[SESS_PRE . '_SESS_USER_ID'] != "") { ?>
                    <li><a href="<?php echo SITEURL ?>profile/">Account Dashboard</a></li>
                    <li><a href="<?php echo SITEURL ?>logout/">Logout</a></li>
                <?php
                } else {
                ?>
                    <li><a href="<?php echo SITEURL ?>login/">Sign In</a></li>
                <?php
                }
                ?>
                <!-- <li><a href="#">Review <i class="fa fa-chevron-down" aria-hidden="true"></i></a>
                    <ul>
                        <li><a href="#">All Reviews</a></li>
                        <li><a href="#">Galleries</a></li>
                        <li><a href="#">Mobile</a></li>
                        <li><a href="#">Software</a></li>
                        <li><a href="#">Lists</a></li>
                        <li><a href="#">Game</a></li>
                        <li><a href="#">Technology</a></li>
                        <li><a href="#">Social Media</a></li>
                        <li><a href="#">Internet</a></li>
                        <li><a href="#">Security</a></li>
                        <li><a href="#">Comparison</a></li>
                        <li><a href="#">Campaign</a></li>
                        <li><a href="#">Hardware</a></li>
                    </ul>
                </li>
                <li><a href="#">Video</a></li>
                <li><a href="#">Q-A</a></li> -->
            </ul>
        </div>
    </nav>
</div>
<!-- mobile menu end -->
<!-- <script src="https://translate.google.com/translate_a/element.js?cb=googleTranslateElementInit" type="text/javascript"></script> -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/2.2.2/jquery.min.js" type="text/javascript"></script>
<script type="text/javascript">
    /*     function googleTranslateElementInit() {
        new google.translate.TranslateElement({
            pageLanguage: 'en',
            layout: google.translate.TranslateElement.InlineLayout.SIMPLE,
            autoDisplay: false
        }, 'google_translate_element');

    } */

    function translateLanguage(lang) {
        console.log(lang);
        // alert(lang);
        //googleTranslateElementInit();
        var $frame = $('.goog-te-menu-frame:first');
        if (!$frame.size()) {
            alert("Error: Could not find Google translate frame.");
            return false;
        }
        $frame.contents().find('.goog-te-menu2-item span.text:contains(' + lang + ')').get(0).click();


        // ----------------------------------------
        var class_name = "";
        class_name = document.getElementById('current_flag_dis').className;

        // alert(class_name);

        if (lang == "Afrikaans") {
            $("#current_flag_dis").removeClass(class_name);
            $("#current_flag_dis").addClass("flag-icon flag-icon-af");
            $(".lang-name").text(" " + lang);
        }
        if (lang == "Albanian") {
            $("#current_flag_dis").removeClass(class_name);
            $("#current_flag_dis").addClass("flag-icon flag-icon-al");
            $(".lang-name").text(" " + lang);
        }
        if (lang == "Arabic") {
            $("#current_flag_dis").removeClass(class_name);
            $("#current_flag_dis").addClass("flag-icon flag-icon-ar");
            $(".lang-name").text(" " + lang);
        }
        if (lang == "Armenian") {
            $("#current_flag_dis").removeClass(class_name);
            $("#current_flag_dis").addClass("flag-icon flag-icon-am");
            $(".lang-name").text(" " + lang);
        }
        if (lang == "Bulgarian") {
            $("#current_flag_dis").removeClass(class_name);
            $("#current_flag_dis").addClass("flag-icon flag-icon-bg");
            $(".lang-name").text(" " + lang);
        }
        if (lang == "Chinese (Simplified)") {
            $("#current_flag_dis").removeClass(class_name);
            $("#current_flag_dis").addClass("flag-icon flag-icon-cn");
            $(".lang-name").text(" " + lang);
        }
        if (lang == "Chinese (Traditional)") {
            $("#current_flag_dis").removeClass(class_name);
            $("#current_flag_dis").addClass("flag-icon flag-icon-tw");
            $(".lang-name").text(" " + lang);
        }
        if (lang == "Corsican") {
            $("#current_flag_dis").removeClass(class_name);
            $("#current_flag_dis").addClass("flag-icon flag-icon-co");
            $(".lang-name").text(" " + lang);
        }
        if (lang == "Croatian") {
            $("#current_flag_dis").removeClass(class_name);
            $("#current_flag_dis").addClass("flag-icon flag-icon-hr");
            $(".lang-name").text(" " + lang);
        }
        if (lang == "Danish") {
            $("#current_flag_dis").removeClass(class_name);
            $("#current_flag_dis").addClass("flag-icon flag-icon-dk");
            $(".lang-name").text(" " + lang);
        }
        if (lang == "Dutch") {
            $("#current_flag_dis").removeClass(class_name);
            $("#current_flag_dis").addClass("flag-icon flag-icon-nl");
            $(".lang-name").text(" " + lang);
        }
        if (lang == "English") {
            $("#current_flag_dis").removeClass(class_name);
            $("#current_flag_dis").addClass("flag-icon flag-icon-us");
            $(".lang-name").text(" " + lang);
        }
        if (lang == "Estonian") {
            $("#current_flag_dis").removeClass(class_name);
            $("#current_flag_dis").addClass("flag-icon flag-icon-et");
            $(".lang-name").text(" " + lang);
        }
        if (lang == "Finnish") {
            $("#current_flag_dis").removeClass(class_name);
            $("#current_flag_dis").addClass("flag-icon flag-icon-fi");
            $(".lang-name").text(" " + lang);
        }
        if (lang == "French") {
            $("#current_flag_dis").removeClass(class_name);
            $("#current_flag_dis").addClass("flag-icon flag-icon-fr");
            $(".lang-name").text(" " + lang);
        }
        if (lang == "Galician") {
            $("#current_flag_dis").removeClass(class_name);
            $("#current_flag_dis").addClass("flag-icon flag-icon-gl");
            $(".lang-name").text(" " + lang);
        }
        if (lang == "Georgian") {
            $("#current_flag_dis").removeClass(class_name);
            $("#current_flag_dis").addClass("flag-icon flag-icon-ge");
            $(".lang-name").text(" " + lang);
        }
        if (lang == "German") {
            $("#current_flag_dis").removeClass(class_name);
            $("#current_flag_dis").addClass("flag-icon flag-icon-de");
            $(".lang-name").text(" " + lang);
        }
        if (lang == "Greek") {
            $("#current_flag_dis").removeClass(class_name);
            $("#current_flag_dis").addClass("flag-icon flag-icon-gr");
            $(".lang-name").text(" " + lang);
        }
        if (lang == "Gujarati") {
            $("#current_flag_dis").removeClass(class_name);
            $("#current_flag_dis").addClass("flag-icon flag-icon-gu");
            $(".lang-name").text(" " + lang);
        }
        if (lang == "Hindi") {
            $("#current_flag_dis").removeClass(class_name);
            $("#current_flag_dis").addClass("flag-icon flag-icon-in");
            $(".lang-name").text(" " + lang);
        }
        if (lang == "Hungarian") {
            $("#current_flag_dis").removeClass(class_name);
            $("#current_flag_dis").addClass("flag-icon flag-icon-hu");
            $(".lang-name").text(" " + lang);
        }
        if (lang == "Icelandic") {
            $("#current_flag_dis").removeClass(class_name);
            $("#current_flag_dis").addClass("flag-icon flag-icon-is");
            $(".lang-name").text(" " + lang);
        }
        if (lang == "Indonesian") {
            $("#current_flag_dis").removeClass(class_name);
            $("#current_flag_dis").addClass("flag-icon flag-icon-id");
            $(".lang-name").text(" " + lang);
        }
        if (lang == "Irish") {
            $("#current_flag_dis").removeClass(class_name);
            $("#current_flag_dis").addClass("flag-icon flag-icon-ga");
            $(".lang-name").text(" " + lang);
        }
        if (lang == "Italian") {
            $("#current_flag_dis").removeClass(class_name);
            $("#current_flag_dis").addClass("flag-icon flag-icon-it");
            $(".lang-name").text(" " + lang);
        }
        if (lang == "Japanese") {
            $("#current_flag_dis").removeClass(class_name);
            $("#current_flag_dis").addClass("flag-icon flag-icon-jp");
            $(".lang-name").text(" " + lang);
        }
        if (lang == "Kannada") {
            $("#current_flag_dis").removeClass(class_name);
            $("#current_flag_dis").addClass("flag-icon flag-icon-kn");
            $(".lang-name").text(" " + lang);
        }
        if (lang == "Korean") {
            $("#current_flag_dis").removeClass(class_name);
            $("#current_flag_dis").addClass("flag-icon flag-icon-kr");
            $(".lang-name").text(" " + lang);
        }
        if (lang == "Portuguese (Portugal, Brazil)") {
            $("#current_flag_dis").removeClass(class_name);
            $("#current_flag_dis").addClass("flag-icon flag-icon-pt");
            $(".lang-name").text(" " + lang);
        }
        if (lang == "Romanian") {
            $("#current_flag_dis").removeClass(class_name);
            $("#current_flag_dis").addClass("flag-icon flag-icon-ro");
            $(".lang-name").text(" " + lang);
        }
        if (lang == "Russian") {
            $("#current_flag_dis").removeClass(class_name);
            $("#current_flag_dis").addClass("flag-icon flag-icon-ru");
            $(".lang-name").text(" " + lang);
        }
        if (lang == "Spanish") {
            $("#current_flag_dis").removeClass(class_name);
            $("#current_flag_dis").addClass("flag-icon flag-icon-es");
            $(".lang-name").text(" " + lang);
        }
        if (lang == "Swedish") {
            $("#current_flag_dis").removeClass(class_name);
            $("#current_flag_dis").addClass("flag-icon flag-icon-sv");
            $(".lang-name").text(" " + lang);
        }
        if (lang == "Ukrainian") {
            $("#current_flag_dis").removeClass(class_name);
            $("#current_flag_dis").addClass("flag-icon flag-icon-ua");
            $(".lang-name").text(" " + lang);
        }
        if (lang == "Urdu") {
            $("#current_flag_dis").removeClass(class_name);
            $("#current_flag_dis").addClass("flag-icon flag-icon-pk");
            $(".lang-name").text(" " + lang);
        }
        if (lang == "Vietnamese") {
            $("#current_flag_dis").removeClass(class_name);
            $("#current_flag_dis").addClass("flag-icon flag-icon-vi");
            $(".lang-name").text(" " + lang);
        }

        return false;
    }
    try {
        $(document).ready(function() {
            $('.selectpicker').selectpicker();

            try {
                const collapseContent = $("#collapsibleTopBanner");
                collapseContent.on('show.bs.collapse', function(e) {
                    $('#chevron-down').hide()
                })

                collapseContent.on('hidden.bs.collapse', function(e) {
                    $('#chevron-down').show()
                })
            } catch (error) {
                console.log(error)
            }

            /*             $(document).ready(function() {
                            // Initialize the slider only if the screen width is <= 768px (mobile devices)
                            if ($(window).width() <= 768) {
                                $('.slick-slider').slick({
                                    autoplay: true,
                                    autoplaySpeed: 3000,
                                    arrows: false,
                                    dots: false,
                                    infinite: true,
                                    speed: 100,
                                    swipe: true, // Enable swipe gestures on mobile
                                    touchMove: true, // Allow swiping by touch move
                                    draggable: true // Allow dragging the slides with mouse
                                });
                            }
                        }); */



            $('#mobileTop').on('shown.bs.collapse', function() {
                // Reinitialize the Slick Slider after it is shown
                if ($(window).width() <= 768) {
                    $('.slick-slider-banner').slick({
                        autoplay: false,
                        autoplaySpeed: 3000,
                        arrows: false,
                        dots: false,
                        infinite: true,
                        speed: 100,
                        swipe: true, // Enable swipe gestures on mobile
                        touchMove: true, // Allow swiping by touch move
                        draggable: true // Allow dragging the slides with mouse
                    });
                }
            });

            /*        // You can also destroy Slick when collapsing (optional)
                   $('#mobileTop').on('hidden.bs.collapse', function() {
                       $('.slick-slider').slick('unslick');
                   }); */

            var collapseThreshold = 100; // Scroll position to collapse

            $(window).on('scroll', function() {
                // Check if the scroll position is greater than the threshold
                if ($(this).scrollTop() > collapseThreshold) {
                    // Collapse the section if it is visible and scroll position is past threshold
                    if ($('#mobileTop').hasClass('show')) {
                        $('#mobileTop').collapse('hide');
                    }

                    if ($('#collapsibleTopBanner').hasClass('show')) {
                        $('#collapsibleTopBanner').collapse('hide');
                    }
                } else {
                    // Optionally show the section again if scrolling back to top
                    /*                  if (!$('#collapsibleSection').hasClass('show')) {
                                         $('#collapsibleSection').collapse('show');
                                     } */
                }
            });
        });

    } catch (error) {
        console.log(error)
    }
</script>