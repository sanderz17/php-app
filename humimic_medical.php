<?php
   include "connect.php";
   ?>
<!DOCTYPE html>
<html>
   <head>
      <title>Homepage | Clear Ballistics</title>
      <?php include 'front_include/css.php'; ?>
   </head>
   <body>
      <?php include 'front_include/header.php'; ?>
      <!--  header section start -->
      <section class="product-header-images">
      </section>
      <!-- header section end -->

      <!-- about section stat -->
      <section class="about-section">
         <div class="container">
            <div class="about-main-img">
               <h1>Humimic Medical</h1>
               <img src="<?php echo SITEURL; ?>img/leg gel.jpg" width="800">
            </div>
            <div class="about-section-content">
               <p> A branch of Clear Ballistics, Humimic Medical was created in 2018 to offer our customers more medical-grade products in a separate industry. Of course, you can still expect the same quality and customer satisfaction that you know and love all while shopping through our reusable and re-moldable medical gels and phantoms.</p>

               <p>Through many years of testing and feedback from our valued customers, we have created medical simulation devices that not only are able to fit within your budget but provide you with the most realism that is available on the market today. Our team of bioengineers and healthcare professionals have gone above and beyond to design and create the best gels and phantoms that feel and react just like real human tissue. Not only that, but it is all 100% reusable and removable which means that you will get more pokes, scans, and tests without having to spend a fortune.</p>

               <p>Our hope here at Humimic Medical is to be able to give you the most valuable products and resources that we can in order to train and practice for real-life situations with confidence. No matter your goals or purpose, we aim to give you all of the necessary tools to build up your own skills and medical products while seeing that nothing quite compares to Humimic!</p>

             	<div class="row" style="text-align: center;">
	            	<div class="col-md-12">
	            		<img src="<?php echo SITEURL; ?>img/4 Vessel.jpg" style="width: 814px;margin-top: 50px;">
	            	</div>
            	</div>
            </div>
         </div>
      </section>
      <!-- about section end -->
      <?php include 'front_include/footer.php'; ?>
      <?php include 'front_include/js.php'; ?>
   </body>
</html>