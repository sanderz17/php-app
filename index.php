<?php
include "connect.php";
//	$db->checkLogin();
// echo $_SESSION[SESS_PRE.'_SESS_CART_ID'];
// exit();
?>
<!DOCTYPE html>
<html>

<head>
   <title>Homepage | Clear Ballistics</title>
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <meta name="msvalidate.01" content="D0C2C82DA6E5D8A503A3C2EA89D61095" />
   <?php include 'front_include/css.php'; ?>
   <script async src="https://www.googletagmanager.com/gtag/js?id=UA-33022613-1"></script>
   <script>
      window.dataLayer = window.dataLayer || [];

      function gtag() {
         dataLayer.push(arguments);
      }
      gtag('js', new Date());

      gtag('config', 'UA-33022613-1');
   </script>
   <script type="text/javascript">
      $('.loader').hide();
   </script>
</head>

<body>
   <?php include 'front_include/index_header.php'; ?>
   <!-- categories  -->
   <div class="quick-nav-buttons-m d-lg-none">
      <ul class="quick-nav-buttons-list mx-2  px-0 py-3 mb-0">
         <li><a class="btn btn-cb" href="/product/10-ballistics-gel">10% Gelatin</a></li>
         <li><a class="btn btn-cb" href="/product/20-ballistics-gel">20% Gelatin</a></li>
         <li><a class="btn btn-cb" href="/product/ballistic-animals">Ballistic Animals</a></li>
         <li><a class="btn btn-cb" href="/product/testing-kits">Testing Kits</a></li>
         <li><a class="btn btn-cb" href="/product/dummies">Dummies</a></li>
         <li><a class="btn btn-cb" href="/shop/zombie-zed/">Zombie</a></li>
      </ul>
   </div>

   <!--  -->
   <!-- Hero Banner Start -->
   <section class="hero-banner-sec">
      <div class="container-fluid text-center">
         <div class="hero-banner-inner parallax_scroll">
            <!-- <h1>“ <?php echo $db->getValue("site_setting", "banner_title", "isDelete=0"); ?> ”</h1> -->
            <a href="product/ballistics-gel">
               <img src="/img/home/hero1_header.png?v=<?php echo time(); ?>" width="60%" />
            </a>
            <div class="banner-btn">
               <a href="<?php echo SITEURL; ?><?php echo $db->getValue("site_setting", "btn_link", "isDelete=0"); ?>" class="btn-regular">SHOP NOW</a>
            </div>
         </div>
      </div>
   </section>
   <!-- Hero Banner End -->


   <!-- Front Page first Pics section start -->
   <section class="FrontPage-first-pics-section">
      <!-- <a href="<?php echo SITEURL; ?>/product-details/7/"> -->
      <a href="<?php echo SITEURL; ?>product/ballistics-gel">
         <div class="container-fluid">
            <div class="FrontPage-first-pics-section-box">
               <img src="<?php echo SITEURL; ?>img/home/2nd_image.png?v=<?php echo time(); ?>" class="FrontPage-first-pics-images" alt="" />
               <div class="FrontPage-first-pics-section_title">
                  <h2>FROM TESTING TO TRAINING</h2>
                  <p>Clarity, Performance, and Durability You Can Rely On</p>
               </div>
               <div class="FrontPage-first-pics-section-overlay"></div>
            </div>
         </div>
      </a>
   </section>
   <section class="FrontPage-first-pics-section">
      <!-- <a href="<?php echo SITEURL; ?>/product-details/1/"> -->
      <a href="<?php echo SITEURL; ?>product/20-ballistics-gel">
         <div class="container-fluid">
            <div class="FrontPage-first-pics-section-box">
               <img src="<?php echo SITEURL; ?>img/home/3rd_image.png?v=<?php echo time(); ?>" class="FrontPage-first-pics-images" alt="" />
               <div class="FrontPage-first-pics-section_title">
                  <!-- <h2>TRAIN LIKE THE PROFESSIONS</h2> -->
                  <h2>FIELD-TESTED PRECISION</h2>
                  <p>The #1 Partner for Ballistics Testing Professionals</p>
               </div>
               <div class="FrontPage-first-pics-section-overlay"></div>
            </div>
         </div>
      </a>
   </section>
   <section class="FrontPage-first-pics-section">
      <a href="<?php echo SITEURL; ?>product/ballistic-animals">
         <div class="container-fluid">
            <div class="FrontPage-first-pics-section-box">
               <img src="<?php echo SITEURL; ?>img/home/4th_image.png?v=<?php echo time(); ?>" class="FrontPage-first-pics-images" alt="" />
               <div class="FrontPage-first-pics-section_title">
                  <h2>ON THE RANGE OR IN THE WILD</h2>
                  <p>Train on Realistic Targets and Master the Wild</p>
               </div>
               <div class="FrontPage-first-pics-section-overlay"></div>
            </div>
         </div>
      </a>
   </section>
   <!-- Front first Page Pics  section end -->

   <!-- Front Page two Pics section start -->
   <section class="FrontPage-two-pics-section">
      <div class="container-fluid">
         <div class="row">
            <div class="col-lg-6 col-md-12">
               <div class="FrontPage-two-pics-section-box">
                  <img src="<?php echo SITEURL; ?>img/home/5th_image.png?v=<?php echo time(); ?>" class="FrontPage-two_img" alt="" />
                  <div class="FrontPage-two-pics-section_title">
                     <h2>SEE WHAT YOU SHOOT</h2>
                     <p>Experience Unmatched Clarity with Every Shot</p>
                  </div></a>
                  <a href="<?php echo SITEURL; ?>product/ballistics-gel">
                     <div class="FrontPage-two-pics-section-overlay"></div>
                  </a>
               </div>
            </div>
            <div class="col-lg-6 col-md-12">
               <a href="<?php echo SITEURL; ?>product/10-ballistics-gel">
                  <div class="FrontPage-two-pics-section-box">
                     <img src="<?php echo SITEURL; ?>img/home/6th_image.png" class="FrontPage-two_img" alt="" />
                     <div class="FrontPage-two-pics-section_title">
                        <h2>OUR FLAGSHIP PRODUCT</h2>
                        <p>Trusted by Professionals, Hunters, and Enthusiasts Worldwide</p>
                     </div>

                     <div class="FrontPage-two-pics-section-overlay"></div>
               </a>
            </div>
         </div>
      </div>
      </div>
   </section>
   <!-- Front Page two Pics section end -->

   <!-- why choose section start -->
   <section class="why-choose-section">
      <div class="section-header text-center">
         <h5>Why are we the</h5>
         <h2>Better Choice?</h2>
      </div>
      <div class="container-fluid">
         <div class="row padding-bottom-200">
            <div class="col-md-4">
               <div class="new-index-block-2 text-center">
                  <img src="<?php echo SITEURL; ?>img/Ballistic2.png?v=<?php echo time(); ?>">
               </div>
            </div>
            <div class="col-md-8">
               <div class="new-index-block">
                  <div class="new-index-block-content">
                     <a href="<?php echo SITEURL ?>remelting-instruction/">
                        <div class="why-choose-index">
                           <h4>USAGE</h4>
                           <ul>
                              <li>Measurable Ballistic Data</li>
                              <li>Reusable</li>
                              <li>10 to 15 Recycles</li>
                              <li>Ready Upon Arrival</li>
                              <li>No Callibration Needed</li>
                           </ul>
                        </div>
                     </a>
                     <a href="<?php echo SITEURL ?>help/">
                        <div class="why-choose-index">
                           <h4>SUPPORT</h4>
                           <ul>
                              <li>Price-Match Guarantee</li>
                              <li>10,000 Blocks Sold Last Year</li>
                              <li>Made in the USA</li>
                              <li>World Class Support</li>
                           </ul>
                        </div>
                     </a>
                     <a href="<?php echo SITEURL ?>10vs20-gelatin/">
                        <div class="why-choose-index">
                           <h4>QUALITY</h4>
                           <ul>
                              <li>Clear as Glass</li>
                              <li>No Smell</li>
                              <li>Synthetic</li>
                              <li>Inorganic</li>
                           </ul>
                        </div>
                     </a>
                     <a href="<?php echo SITEURL ?>product/ballistics-gel">
                        <div class="why-choose-index">
                           <h4>AVAILABLE NOW</h4>
                           <ul>
                              <li>10% Gelatin</li>
                              <li>20% Gelatin</li>
                              <li>Ballistic Dummies</li>
                              <li>Ballistic Animals</li>
                           </ul>
                        </div>
                     </a>
                  </div>
               </div>
            </div>
         </div>
      </div>
   </section>
   <!-- why choose section end -->

   <!-- client logo section start -->
   <section class="clientLogo-section">
      <div class="section-header text-center mb-3">
         <h2>Clients </h2>
      </div>
      <div class="container-fluid">
         <div class="row">
            <?php
            $clients = $db->getData("clients", "*", "isDelete=0 AND type=0");
            while ($client_data = mysqli_fetch_assoc($clients)) {
            ?>
               <div class="col-lg-2 col-md-3 col-sm-4 col-6 text-center brd2 aos-init aos-animate" data-aos="flip-left" data-aos-duration="3000">
                  <a href="<?php if ($client_data['link'] != null || $client_data['link'] != "") echo $client_data['link'];
                           else echo "javascript:void(0)" ?>"><img src="<?php echo SITEURL; ?>img/client/<?php echo $client_data['logo']; ?>?v=<?php echo time(); ?>" class="img-p1"></a>
               </div>
            <?php } ?>
         </div>
      </div>
   </section>
   <!-- client logo section end -->


   <!-- module-card-about section  -->

   <section class="module-card-about-section">
      <div class="container">
         <div class="module-card-about-box">
            <img src="<?php echo SITEURL; ?>img/home/SeeWhatYouShoot2.png?v=<?php echo time(); ?>">
            <p>Clear Ballistics was founded in 2010. We take great pride and care in developing a product of the highest possible quality at the best price for our customers. We are continually expanding our product line and continue to improve our business to better serve our customers. Our mission is to provide you with professional-grade gelatin that caters to all your ballistic needs.</p>

            <p>We combine our firsthand experience with the latest technology to produce clear, reusable, synthetic gelatin for your needs. From our ballistic gel to our custom molds, every product from Clear Ballistics is made to perform according to your needs!</p>
         </div>
      </div>
   </section>
   <!-- module-card-about section  -->
   <script>

   </script>
   <?php include 'front_include/footer.php'; ?>
   <?php include 'front_include/js.php'; ?>

</body>

</html>