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
        <!-- Blog section stat -->
        <section class="blog-section-main">
            <div class="section-header text-center py-4 mb-3">
                <h2>Clear Ballistics Blog </h2>
            </div>
            <div class="container-fluid">
                <div class="row">
                    <div class="col-md-3">
                        <div class="blog_sidebar">
                            <div class="content_sidebar">
                                <p>The Clear Ballistics event is a place of regular pondering of all things trend-led. Our team of stylists, designers, marketers and product managers are always posting something interesting, relevant and worth a read.</p>
                                <ol class="push--small">
                                    <?php
                                        $blog_d = $db->getData("blog","*","isDelete=0 AND isPublished=1");
                                        while ($blog_r = mysqli_fetch_assoc($blog_d)) {
                                    ?>
                                    <li><a href="<?php echo SITEURL ?>blog-details/<?php echo $blog_r['id']; ?>/" class="nav__item">
                                        <span class="h--upper small nav__inner"><?php echo $blog_r['title']; ?></span></a>
                                    </li>
                                    <?php
                                        }
                                    ?>
                                </ol>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-9">
                        <div class="main_event-blog">
                        	<?php
                                $blog_d = $db->getData("blog","*","isDelete=0 AND isPublished=1");
                                while ($blog_r = mysqli_fetch_assoc($blog_d)) {
                            ?>
                            <div class="main_event-blog-box">
                                <a href="<?php echo SITEURL ?>blog-details/<?php echo $blog_r['id']; ?>/">
                                    <div class="main_event-blog-sec">
                                        <img src="<?php echo SITEURL.BLOG.$blog_r['image_path']; ?>">
                                    </div>
                                    <div class="blog_title">
                                        <p class="date"><?php echo date("M d,Y",strtotime($blog_r['createdDate'])); ?></p>
                                        <h2 class="h-alt-serif"><?php echo $blog_r['title']; ?></h2>
                                    </div>
                                </a>
                            </div>
                            <?php
                                }
                            ?>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!-- Blog section end -->
        <?php include 'front_include/footer.php'; ?>
        <?php include 'front_include/js.php'; ?>
    </body>
</html>