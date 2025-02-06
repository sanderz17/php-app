<?php
    include "connect.php";
    ?>
<!DOCTYPE html>
<html>
    <head>
        <title>Homepage | FAQs</title>
        <?php include 'front_include/css.php'; ?>
    </head>
    <body>
        <?php include 'front_include/header.php'; ?>
        <!--  header section start -->
        <section class="product-header-images">
        </section>
        <!-- header section end -->
        <!-- Faq Page Section start-->
        <section class="faq-section">
            <div class="section-header text-center">
                <h3>CLEAR BALLISTICS FAQ</h3>
            </div>
            <div class="container">
                <div id="accordion" class="accordion-container">
                    <?php
                        $faq = $db->getData("faq", "*", "isDelete=0");
                        while ($faq_data = mysqli_fetch_assoc($faq)) { ?>
                    <div class="accordion-container-content-box">
                        <h4 class="article-title"><?php echo $faq_data['question'] ?></h4>
                        <div class="accordion-content" style="cursor: auto;">
                            <p><?php echo $faq_data['answer'] ?></p>
                        </div>
                    </div>
                    <?php } ?>
                </div>
            </div>
        </section>
        <!-- Faq Page Section End-->
        <?php include 'front_include/footer.php'; ?>
        <?php include 'front_include/js.php'; ?>
        <script>
            jQuery(function ($) {
            	$('.article-title').on('click', function () {
            		$(this).next().slideToggle(200);
            		$(this).toggleClass('open');
            	});
            	
            	});
            
        </script>
    </body>
</html>