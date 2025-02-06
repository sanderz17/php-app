<?php
    include "connect.php";
    ?>
<!DOCTYPE html>
<html>
    <head>
        <title>Homepage | Video</title>
        <?php include 'front_include/css.php'; ?>
    </head>
    <body>
        <?php include 'front_include/header.php'; ?>
        <!--  header section start -->
        <section class="product-header-images">
        </section>
        <!-- header section end -->
        <!-- video-page-section start-->
        <section class="video-page-section">
            <div class="section-header text-center">
                <h2 class="pb-5">CB Video Library </h2>
            </div>
            <div class="container-fluid">
                <div class="row">
                    <?php
                        $video_library_d = $db->getData("video_library","*","isDelete=0");
                        foreach ($video_library_d as $video_library_r) {
                    ?>
                    <div class="col-md-6">
                        <div class="video-page-section-box">
                            <?php echo $video_library_r['video_link']; ?>
                            <div class="video-title-box">
                                <h4><?php echo $video_library_r['title']; ?></h4>
                            </div>
                        </div>
                    </div>
                    <?php
                        }
                    ?>
                </div>
            </div>
        </section>
        <!-- video-page-section end-->
        <?php include 'front_include/footer.php'; ?>
        <?php include 'front_include/js.php'; ?>
        <script src="https://cdn.jsdelivr.net/gh/thelevicole/youtube-to-html5-loader@4.0.1/dist/YouTubeToHtml5.js"></script>
        <script type="text/javascript">
            new YouTubeToHtml5();
        </script>
    </body>
</html>