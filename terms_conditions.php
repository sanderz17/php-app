<?php
    include "connect.php";
    ?>
<!DOCTYPE html>
<html>
    <head>
        <title>Homepage | Terms & Conditions</title>
        <?php include 'front_include/css.php'; ?>
    </head>
    <body>
        <?php include 'front_include/header.php'; ?>
        <!--  header section start -->
        <section class="product-header-images">
            <!-- <div class="product-hero" style="background-image:url('img/product-hero.jpg')">
                <div class="overlay"></div>
                <div class="container">
                <h3>terms & conditions </h3>
                <p>Welcome to Clear Ballistics, a leading clear synthetic ballistics gelatin manufacturing company providing professional grade products for testing, investigating, and a variety of other applications and purposes. </p>
                </div>
                </div>
                <div class="pl-breadcrumb">
                	<div class="container">
                		<ul class="breadcrumb">
                			<li><a href="#">Home /</a></li>
                			<li>Terms & Conditions  </li>
                			
                		</ul>
                	</div>
                </div> -->
        </section>
        <!-- header section end -->
        <!-- terms conditions section stat -->
        <section class="shipping-returns-section">
            <div class="section-header text-center py-3">
                <h2><?php echo $db->getValue("static_page", "title", "id =1 AND isArchived=0"); ?></h2>
</div>
        	<!-- <h1  align="center" style="font-size: 60px; margin-bottom: 50px;"> ClearBallistics.com </br>Terms & Conditions of Use </h1> -->
            <div class="container">
                <div class="shipping-returns-section-box">
                    <?php
                        $faq = $db->getData("static_page", "*", "id =1 AND isArchived=0");
                        while ($faq_data = mysqli_fetch_assoc($faq)) { ?>
                    <p><?php echo $faq_data['descr']; ?> </p>
                    <?php } ?>
                </div>
            </div>
        </section>
        <!-- terms conditions section end -->
        <?php include 'front_include/footer.php'; ?>
        <?php include 'front_include/js.php'; ?>
    </body>
</html>