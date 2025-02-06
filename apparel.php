<?php
   include "connect.php";
// die('11');
   $img = "apparel.png";

   if ($slug == "hats") 
   {
      $img = "apparel3.png";
   }
   elseif ($slug == "stickers") 
   {
      $img = "apparel_sticker.png";
   }
   elseif ($slug == "t-shirts") 
   {
      $img = "apparel.png";         
   }
?>
<!DOCTYPE html>
<html>
   <head>
      <title>Apparel | Clear Ballistics</title>
      <?php include 'front_include/css.php'; ?>
   </head>
   <body>
      <?php include 'front_include/header.php'; ?>
      <!--  header section start -->
      <section class="product-header-images">
      </section>
      <!-- header section end -->

      <!-- about section stat -->
      <section class="about-section text-center">
         <img src="<?php echo SITEURL; ?>img/home/<?php echo $img; ?>" width="60%">
         <h4>Coming soon</h4>
      </section>
      <!-- about section end -->
      <?php include 'front_include/footer.php'; ?>
      <?php include 'front_include/js.php'; ?>
   </body>
</html>