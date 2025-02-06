<?php
include("connect.php");
$db->checkAdminLogin();
$tmp_image_path = PRODUCT_T;

if (isset($_REQUEST['submit'])) {

  if ($_REQUEST['bg_filename'] != "") {
    $bg_image_path = "../theme5/img/new-hero-banner.jpg";
    $tmp_image = $tmp_image_path . $_REQUEST['bg_filename'];
    if (copy($tmp_image, $bg_image_path)) {
      //die("copied!");
    } else {
      die(print_r(error_get_last()));
    };
    unlink($tmp_image);
  }

  if ($_REQUEST['center_image_filename'] != "") {
    $center_image_path = "../img/home/hero1_header.png";
    $tmp_center_image = $tmp_image_path . $_REQUEST['center_image_filename'];
    if (copy($tmp_center_image, $center_image_path)) {
      //die("copied!");
    } else {
      die(print_r(error_get_last()));
    };
    unlink($tmp_center_image);
  }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <?php include('include/css.php'); ?>
</head>
<link href="<?php echo ADMINURL; ?>assets/js/crop/css/demo.html5imageupload.css?v1.3" rel="stylesheet">

<body>
  <div class="loader" style="display: none;">
    <div><img src="<?php echo ADMINURL; ?>assets/images/loader.svg"></div>
  </div>
  <div class="container-scroller">
    <?php include('include/header.php'); ?>
    <div class="container-fluid page-body-wrapper">
      <?php include('include/left.php'); ?>
      <div class="main-panel">
        <div class="content-wrapper">
          <div class="row">
            <div class="col-md-12 grid-margin stretch-card">
              <div class="card">
                <form class="forms-sample" role="form" name="frm" id="frm" action="." method="post" enctype="multipart/form-data">
                  <input type="hidden" name="mode" id="mode" value="<?php echo $_REQUEST['mode']; ?>">
                  <input type="hidden" name="id" id="id" value="<?php echo $_REQUEST['id']; ?>">
                  <div class="card-body">
                    <div class="row">
                      <div class="col-md-12">
                        <label for="rand_image_path">Background Image <code>*</code>
                          <br />
                          <small>minimum image size 1200 x 800 px</small>
                        </label><br />
                        <input name="bg_filename" id="bg_filename" class="form-control" hidden />
                        <div id="rand_dropzone_img" class="dropzone" data-width="1200" data-height="800" data-ghost="false" data-cropwidth="550" data-originalsize="false" data-url="<?php echo ADMINURL; ?>crop_image.php?img=prodimg" style="width: 1200px;height:800px;" data-image="/theme5/img/new-hero-banner.jpg">
                          <input type="file" id="rand_image_path" name="rand_image_path">

                        </div>
                      </div>
                      <div class="col-md-12 mt-3">
                        <label for="rand_image_path">Center Image <code>*</code>
                          <br />
                          <small>minimum image size 1671 x 875 px</small>
                        </label><br />
                        <input name="center_image_filename" id="center_image_filename" class="form-control" hidden />
                        <div id="center_image" class="dropzone" data-width="800" data-height="405" data-ghost="false" data-cropwidth="550" data-originalsize="false" data-url="<?php echo ADMINURL; ?>crop_image.php?img=prodimg" style="width: 800px;height:405px;" data-image="/img/home/hero1_header.png">
                          <input type="file" id="center_image" name="center_image">

                        </div>
                      </div>
                    </div>
                  </div>
                  <div class="card-footer">
                    <button type="submit" name="submit" id="submit" title="Submit" class="btn btn-gradient-success btn-icon-text"><i class="mdi mdi-content-save-all"></i> </button>
                    <button type="button" title="Back" class="btn btn-gradient-light btn-icon-text" onClick="window.location.href='<?php echo ADMINURL; ?>manage-<?php echo $page; ?>/<?php echo $product_id; ?>/'"><i class="mdi mdi-step-backward"></i> </button>
                  </div>
                </form>
              </div>
            </div>
          </div>
        </div>
        <!-- content-wrapper ends -->
        <?php include('include/footer.php'); ?>
      </div>
      <!-- main-panel ends -->
    </div>
    <!-- page-body-wrapper ends -->
  </div>
  <!-- container-scroller -->
  <?php include('include/js.php'); ?>
</body>
<script src="<?php echo ADMINURL; ?>assets/js/crop/js/commonfile_html5imageupload.js?v1.3.4"></script>
<script>
  var custom_img_width = '454';
  $('#rand_dropzone_img').html5imageupload({
    onAfterProcessImage: function() {
      var imgName = $('#bg_filename').val($(this.element).data('imageFileName'));
      console.log(imgName);
    },
    onAfterCancel: function() {
      $('#bg_filename').val('');
    }
  });
  $('#center_image').html5imageupload({
    onAfterProcessImage: function() {
      var imgName = $('#center_image_filename').val($(this.element).data('imageFileName'));
      console.log(imgName);
    },
    onAfterCancel: function() {
      $('#bg_filename').val('');
    }
  });
</script>

</html>