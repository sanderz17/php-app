<?php
include "connect.php";
$product_id = $_REQUEST['id'];
$product_slug = $_REQUEST['slug'];

// echo $pr
// $product_details = $db->getData("product","*","id=".$product_id." AND isDelete=0");
$product_details = $db->getData("product", "*", "slug LIKE '%" . $product_slug . "%' AND isDelete=0", "", 0);
$prod_row = mysqli_fetch_assoc($product_details);

// echo "<pre>";
//print_r($prod_row);
//die;

$product_id = $prod_row['id'];
$additional_features = true;
$product_description_custom = false;
$isActive = $prod_row['isActive'];

if ($product_slug == 'fake-blood-1000ml') {
   $additional_features = false;
   $product_description_custom = true;
}

?>
<!DOCTYPE html>
<html>

<head>
   <title>Homepage | Product Details</title>
   <?php include 'front_include/css.php'; ?>
   <style>
      input[type=radio] {
         display: none;
      }

      input[type=radio]:checked+label span {
         transform: scale(1.25);
      }

      input[type=radio]:checked+label .red {
         border: 2px solid #711313;
      }

      input[type=radio]:checked+label .orange {
         border: 2px solid #873a08;
      }

      input[type=radio]:checked+label .yellow {
         border: 2px solid #816102;
      }

      input[type=radio]:checked+label .olive {
         border: 2px solid #505a0b;
      }

      input[type=radio]:checked+label .green {
         border: 2px solid #0e4e1d;
      }

      input[type=radio]:checked+label .teal {
         border: 2px solid #003633;
      }

      input[type=radio]:checked+label .blue {
         border: 2px solid #103f62;
      }

      input[type=radio]:checked+label .violet {
         border: 2px solid #321a64;
      }

      input[type=radio]:checked+label .purple {
         border: 2px solid #501962;
      }

      input[type=radio]:checked+label .pink {
         border: 2px solid #851554;
      }

      input[type=radio]:checked+label .white {
         border: 2px solid black;
      }

      label {
         display: inline-block;
         width: 25px;
         height: 25px;
         margin-right: 10px;
         cursor: pointer;
      }

      label:hover span {
         transform: scale(1.25);
      }

      label span {
         display: block;
         width: 100%;
         height: 100%;
         transition: transform 0.2s ease-in-out;
      }

      label span.red {
         background: #db2828;
      }

      label span.orange {
         background: #f2711c;
      }

      label span.yellow {
         background: #fbbd08;
      }

      label span.olive {
         background: #b5cc18;
      }

      label span.green {
         background: #21ba45;
      }

      label span.teal {
         background: #00b5ad;
      }

      label span.blue {
         background: #2185d0;
      }

      label span.violet {
         background: #6435c9;
      }

      label span.purple {
         background: #a333c8;
      }

      label span.pink {
         background: #e03997;
      }

      label span.white {
         background: white;
      }
   </style>
</head>

<body>
   <?php include 'front_include/header.php'; ?>
   <!--  product header section start -->
   <section class="product-header-images"> </section>
   <!-- product header section end -->

   <?php if ($isActive == '1') { ?>
      <!-- product section start -->
      <section class="product-detail-section">
         <div class="container-fluid">
            <div class="alert alert-warning" role="alert">
               <h5 class="alert-heading">NOTICE:</h5>
               <p>The FBI Mold included in our kits is currently on backorder. Domestic orders will ship without the mold, which will follow separately once restocked. International orders will ship once the mold is available. Thank you for your patience.</p>
            </div>
            <div class="product-ds-box">
               <div class="row">
                  <div class="col-lg-8 col-md-12">
                     <section class="module-gallery">
                        <div class="maxWidth900 padLR15">
                           <div class="padTB20">
                              <div class="slider-wrapper">
                                 <div class="container">
                                    <ul class="slider-thumb noPad noMar">
                                       <li class="type-image"><img src="<?php echo SITEURL; ?>img/product/<?php echo $prod_row['image']; ?>" alt=""></li>
                                       <?php
                                       $alt_img = $db->getData("product_alt_image", "*", "isDelete=0 AND product_id=" . $product_id);
                                       while ($alt_row = mysqli_fetch_assoc($alt_img)) {
                                       ?>
                                          <li class="type-image"><img src="<?php echo SITEURL; ?>img/product/<?php echo $alt_row['image_path'] . "?v=" . time(); ?>" alt=""></li>
                                       <?php } ?>
                                    </ul>
                                 </div>

                                 <ul class="slider-preview slide-main-show noPad noMar">
                                    <li class="type-image">
                                       <div class="ver-img-thub">
                                          <a href="<?php echo SITEURL; ?>img/product/<?php echo $prod_row['image']; ?>" data-fancybox="gallery" title="">
                                             <img class="img-full" src="<?php echo SITEURL; ?>img/product/<?php echo $prod_row['image'] . "?v=" . time(); ?>" alt="">
                                          </a>
                                       </div>
                                    </li>
                                    <?php
                                    $alt_img = $db->getData("product_alt_image", "*", "isDelete=0 AND product_id=" . $product_id);
                                    while ($alt_row = mysqli_fetch_assoc($alt_img)) {
                                    ?>
                                       <li class="type-image">
                                          <div class="ver-img-thub">
                                             <a href="<?php echo SITEURL; ?>img/product/<?php echo $alt_row['image_path']; ?>" data-fancybox="gallery" title="">
                                                <img class="img-full" src="<?php echo SITEURL; ?>img/product/<?php echo $alt_row['image_path'] . "?v=" . time(); ?>" alt="">
                                             </a>
                                          </div>
                                       </li>
                                    <?php } ?>
                                 </ul>
                              </div>
                           </div>
                        </div>
                     </section>
                  </div>
                  <div class="col-lg-4 col-md-12">
                     <div class="product-detail-right">
                        <div class="product-detail-right-content text-center text-lg-left">
                           <h2><?php echo $prod_row['name']; ?></h2>
                           <?php echo $prod_row['short_description']; ?>
                           <?php if ($product_slug == 'zombie-zed') { ?>
                              <div class="row no-gutters">
                                 <div class="col-md-12">
                                    <h4>COLOR : </h3>
                                       <!--                                        <input type="radio" name="color" id="white" value="white" checked />
                                       <label for="white"><span class="white"></span></label> -->

                                       <input type="radio" name="color" id="green" value="green" checked />
                                       <label for="green"><span class="green"></span></label>

                                 </div>
                              </div>
                           <?php } ?>
                           <div class="product-price-row">
                              <input type="hidden" name="price" id="price" value="<?php echo $prod_row['price']; ?>">
                              <h3><?php echo CURR . $prod_row['price']; ?> <?php if ($prod_row['sell_price'] <> 0) echo "<del>" . CURR . $prod_row['sell_price'] . "</del>";  ?>
                                 <span>
                                    <?php
                                    if ($prod_row['new'] == 1) {
                                       echo "New";
                                    }
                                    if ($prod_row['onSale'] == 1) {
                                       echo 'On Sale';
                                    }
                                    if ($prod_row['out_of_stock'] == 1) {
                                       echo "Out of Stock ";
                                    }
                                    ?>
                                 </span>
                              </h3>
                           </div>
                           <div class="add-to-cart">
                              <div class="number">
                                 <button class="minus">-</button>
                                 <input type="text" value="1" id="quantity_value" name="quantity_value" />
                                 <button class="plus">+</button>
                              </div>
                              <?php
                              if ($prod_row['new'] == 1) {
                              ?>
                                 <div class="cb-cart-btn">
                                    <!-- <a href="javascript:void(0);" class="btn" onclick="add_to_cart();">Add To Cart</a> -->
                                    <a data-toggle="modal" id="<?php echo $prod_row['id']; ?>" href="javascript:void(0);" class="btn" onclick="add_to_cart(<?php echo $prod_row['id']; ?>,<?php echo $prod_row['price']; ?>);">Add To Cart</a>
                                 </div>
                              <?php
                              } elseif ($prod_row['onSale'] == 1) {
                              ?>
                                 <div class="cb-cart-btn">
                                    <!-- <a href="javascript:void(0);" class="btn" onclick="add_to_cart();">Add To Cart</a> -->
                                    <a data-toggle="modal" id="<?php echo $prod_row['id']; ?>" href="javascript:void(0);" class="btn" onclick="add_to_cart(<?php echo $prod_row['id']; ?>,<?php echo $prod_row['price']; ?>);">Add To Cart</a>
                                 </div>
                              <?php
                              } elseif ($prod_row['out_of_stock'] == 1) {
                              ?>
                                 <div class="cb-cart-btn">
                                    <a href="javascript:void(0);" class="btn">Out of Stock</a>
                                 </div>
                              <?php
                              } elseif ($prod_row['new'] == 0) {
                              ?>
                                 <div class="cb-cart-btn">
                                    <a data-toggle="modal" id="<?php echo $prod_row['id']; ?>" href="javascript:void(0);" class="btn" onclick="add_to_cart(<?php echo $prod_row['id']; ?>,<?php echo $prod_row['price']; ?>);">Add To Cart</a>
                                 </div>
                              <?php } ?>
                              <!-- <div class="cb-cart-btn">
                                 <a href="javascript:void(0);" class="btn" onclick="add_to_cart();">Add To Cart</a>
                                 </div> -->
                           </div>
                           <div class="product-location">
                              <span class="lcly-location-prompt-label">SKU:<?php echo $prod_row['code']; ?></span>
                              <!--                            <a id="lcly-location-prompt-link-0" class="lcly-location-prompt-link" href="javascript:;">Change</a>
                           <a id="lcly-link-0" href="#" class="lcly-anchor lcly-toggleable-0">Find Rambler Bottle Sling Small - Charcoal. Locally.</a> -->
                           </div>
                           <?php
                           $url_data = $db->getData("site_setting", "*", "isDelete=0");
                           $url_row = mysqli_fetch_assoc($url_data);
                           ?>
                           <div class="product-free-shipping">
                              <div class="product-detail-proposition-container">
                                 <div class="product-detail-proposition-icon"><img src="<?php echo SITEURL; ?>img/free-shipping-icon.svg"></div>
                                 <a class="product-detail-proposition-link" href="<?php echo SITEURL; ?>shipping-returns">Fast Shipping</a>
                              </div>
                              <div class="product-detail-proposition-container">
                                 <div class="product-detail-proposition-icon"><img src="<?php echo SITEURL; ?>img/free-returns-icon.svg"></div>
                                 <a class="product-detail-proposition-link" href="<?php echo SITEURL; ?>shipping-returns">Easy Returns </a>
                              </div>
                              <div class="product-detail-proposition-container">
                                 <div class="product-detail-proposition-icon"><img src="<?php echo SITEURL; ?>img/warranty-icon.svg"></div>
                                 <!-- <a class="product-detail-proposition-link" href="<?php echo SITEURL; ?>shipping-returns">Bulletproof Guarantee </a> -->
                                 <a class="product-detail-proposition-link" href="<?php echo SITEURL; ?>bulletproof-guarantee">Price Match Guarantee</a>
                              </div>
                           </div>
                           <div class="share-icon">
                              <ul class="list-inline">
                                 <li><a href="mailto:<?= $url_row['email']; ?>"><i class="fa fa-envelope" aria-hidden="true" target="_blank"></i></a></li>
                                 <li><a href="<?= $url_row['facebook_link']; ?>" target="_blank"><i class="fa fa-facebook" aria-hidden="true"></i></a></li>
                                 <li>
                                    <a href="https://twitter.com/ClearBallistics">
                                       <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512" style="width: 1em;height: 1em;vertical-align: -0.125em;"><!--!Font Awesome Free 6.5.1 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free Copyright 2024 Fonticons, Inc.-->
                                          <path fill="#1d1441" d="M389.2 48h70.6L305.6 224.2 487 464H345L233.7 318.6 106.5 464H35.8L200.7 275.5 26.8 48H172.4L272.9 180.9 389.2 48zM364.4 421.8h39.1L151.1 88h-42L364.4 421.8z" />
                                       </svg>
                                    </a>
                                 </li>
                              </ul>
                           </div>
                        </div>
                     </div>
                  </div>
               </div>
            </div>
            <!-- Compatible product start  -->
            <section class="compatible-section">
               <?php
               $join = 'SELECT DISTINCT(product_accessories.related_pid),product.name,product.price,product.image FROM `product_accessories` LEFT JOIN product ON product.id = product_accessories.related_pid WHERE product_accessories.product_id = ' . $product_id . ' AND product.isDelete=0';
               //echo $join;
               // exit();
               $product = mysqli_query($GLOBALS['myconn'], $join);
               if (mysqli_num_rows($product) > 0) {
               ?>
                  <div class="container-fluid">
                     <div class="section-header text-center">
                        <h3>Compatible Accessories</h3>
                     </div>
                     <div class="compatible-slider">
                        <?php
                        while ($product_data = mysqli_fetch_assoc($product)) {
                        ?>
                           <div class="slick-slide">
                              <a href="#"><img src="<?php echo SITEURL; ?>img/product/<?php echo $product_data['image']; ?>"></a>
                              <h3><?php echo $product_data['name']; ?></h3>
                              <div class="product-pricing text-center">
                                 <span class="product-sales-price" title="product-sales-pricee">$<?php echo $product_data['price']; ?> </span>
                              </div>
                              <div class="product-actions">
                                 <a class="btn add-to-cart-btn" href="j:void(0);" onclick="add_to_cart_accessories(<?php echo $product_data['related_pid']; ?>,<?php echo $product_data['price']; ?>);">Add To Cart</a>
                              </div>
                           </div>
                        <?php } ?>
                     </div>
                  </div>
               <?php } ?>
            </section>
            <!-- Compatible product end -->

            <!-- product description start  -->
            <?php if (!$product_description_custom) { ?>
               <div class="product-description">
                  <ul class="nav nav-tabs md-tabs" id="myTabMD" role="tablist">
                     <li class="nav-item">
                        <a class="nav-link active" id="profile-tab-md" data-toggle="tab" href="#profile-md" role="tab" aria-controls="profile-md" aria-selected="false">Technology & Description </a>
                     </li>
                     <li class="nav-item">
                        <a class="nav-link" id="dimensions-tab-md" data-toggle="tab" href="#dimensions-md" role="tab" aria-controls="dimensions-md" aria-selected="false">DIMENSIONS & SPECS</a>
                     </li>
                     <li class="nav-item">
                        <a class="nav-link" id="contact-tab-md" data-toggle="tab" href="#contact-md" role="tab" aria-controls="contact-md" aria-selected="false">Videos</a>
                     </li>
                  </ul>
                  <div class="tab-content card pt-3 py-4 px-4" id="myTabContentMD">
                     <div class="tab-pane fade show active" id="profile-md" role="tabpanel" aria-labelledby="profile-tab-md">
                        <div class="py-3">
                           <h4 class="mb-2">TECHNICAL SPECIFICATIONS</h4>
                           <div class="row technical-description align-items-center">
                              <div class="col-md-<?php if ($product_slug != "accessories") {
                                                      echo '5';
                                                   } else {
                                                      echo '12';
                                                   } ?> image-box">
                                 <img src="<?php echo SITEURL; ?>img/product/<?php echo $prod_row['image']; ?>">
                              </div>
                              <?php
                              if ($product_slug != "accessories") {
                              ?>
                                 <div class="col-md-7 content-box">
                                    <div class="inner-box">
                                       <div><img alt="Icon" src="<?php echo SITEURL; ?>img/icon/1.png" /></div>
                                       <div class="content-right">
                                          <h3>Crystal Clear</h3>
                                          <p>Able To See Exactly What Your Round Is Doing</p>
                                       </div>
                                    </div>

                                    <?php
                                    if ($prod_row['isRemelt'] == 1) {
                                    ?>
                                       <div class="inner-box">
                                          <div><img alt="Icon" src="<?php echo SITEURL; ?>img/icon/4.png" /></div>
                                          <div class="content-right">
                                             <h3>Remelt and Reuse</h3>
                                             <p>Easy Remolding Instructions To Make a New Block</p>
                                          </div>
                                       </div>
                                    <?php
                                    }
                                    ?>

                                    <div class="inner-box">
                                       <div><img alt="Icon" src="<?php echo SITEURL; ?>img/icon/6.png" /></div>
                                       <div class="content-right">
                                          <h3>Temperature Stable</h3>
                                          <p>Able to Use In Temperatures from 32-100F</p>
                                       </div>
                                    </div>
                                 </div>
                              <?php
                              }
                              ?>
                           </div>

                           <div class="pdp-aditional-features">
                              <h3>ADDITIONAL FEATURES</h3>
                              <div class="row">
                                 <?php
                                 if ($product_slug != "accessories") {
                                 ?>
                                    <div class="col-md-4">
                                       <div class="texh-features-list">
                                          <div class="tech-item-left">
                                             <img alt="Icon" src="<?php echo SITEURL; ?>img/icon/3.png" />
                                          </div>
                                          <div class="tech-item-right">
                                             <h4>Able To Shoot With All Different Calibers</h4>
                                             <p>Test your Different Rounds</p>
                                          </div>
                                       </div>
                                    </div>
                                    <div class="col-md-4">
                                       <div class="texh-features-list">
                                          <div class="tech-item-left">
                                             <img alt="Icon" src="<?php echo SITEURL; ?>img/icon/5.png" />
                                          </div>
                                          <div class="tech-item-right">
                                             <h4>Accurate Represents Tissue</h4>
                                             <p>Prevents condensation, keeping hands dry.</p>
                                          </div>
                                       </div>
                                    </div>
                                    <div class="col-md-4">
                                       <div class="texh-features-list">
                                          <div class="tech-item-left">
                                             <img alt="Icon" src="<?php echo SITEURL; ?>img/icon/7.png" />
                                          </div>
                                          <div class="tech-item-right">
                                             <h4>The Ultimate Target</h4>
                                             <p>Be Responsible For Your Round</p>
                                          </div>
                                       </div>
                                    </div>
                                    <div class="col-md-4">
                                       <div class="texh-features-list">
                                          <div class="tech-item-left">
                                             <img alt="Icon" src="<?php echo SITEURL; ?>img/icon/8.png" />
                                          </div>
                                          <div class="tech-item-right">
                                             <h4>Able to Shoot With A Bow & Arrow</h4>
                                             <p>Calibrated To Follow FBI Protocol</p>
                                          </div>
                                       </div>
                                    </div>
                                    <div class="col-md-4">
                                       <div class="texh-features-list">
                                          <div class="tech-item-left">
                                             <img alt="Icon" src="<?php echo SITEURL; ?>img/icon/9.png" />
                                          </div>
                                          <div class="tech-item-right">
                                             <h4>Reuse Reduce Recycle</h4>
                                             <p>Recycle your block upto 10 times</p>
                                          </div>
                                       </div>
                                    </div>
                                 <?php
                                 } ?>
                                 <div class="col-md-12">
                                    <div class="pro-des-details">
                                       <h4 class="mb-2">DESCRIPTION</h4>
                                       <div style="font-size: 20px;"><?php echo $prod_row['description']; ?></div>
                                       <div style="font-size: 20px;"><?php echo $prod_row['technical']; ?></div>
                                    </div>
                                 </div>
                              </div>
                           </div>

                        </div>
                     </div>



                     <div class="tab-pane fade" id="dimensions-md" role="tabpanel" aria-labelledby="dimensions-tab-md">
                        <div class="dimensions-space">
                           <div class="container">
                              <div class="row" align="center">
                                 <div class="col-md-12">
                                    <div class="image-box">
                                       <?php
                                       $url = "img/product/" . $prod_row['dimen_image'];
                                       if (file_exists($url) && $prod_row['dimen_image'] != "") {
                                       ?>
                                          <img src="<?php echo SITEURL . "img/product/" . $prod_row['dimen_image']; ?>">
                                       <?php
                                       } else {
                                       ?>
                                          <img src="<?php echo SITEURL; ?>img/bi.jpeg">
                                       <?php } ?>
                                    </div>
                                 </div>
                              </div>
                              <div class="row">
                                 <div class="col-md-12" align="center">
                                    <div class="dimension-box">
                                       <?php echo $prod_row['dimen_descr']; ?>

                                    </div>
                                 </div>
                              </div>
                           </div>
                        </div>
                     </div>
                     <div class="tab-pane fade" id="contact-md" role="tabpanel" aria-labelledby="contact-tab-md">
                        <div class="cb-video-section text-center" id="corporatevideo">
                           <?php
                           $url = "img/product/" . $prod_row['video'];
                           if (file_exists($url) && $prod_row['video'] != "") {
                           ?>
                              <video playsinline="playsinline" autoplay="" muted="muted" controls="" loop="">
                                 <source src="<?php echo SITEURL; ?>img/product/<?php echo $prod_row['video']; ?>" type="video/mp4">
                              </video>
                           <?php
                           } else {
                           ?>
                              <iframe width="860" height="500" src="https://www.youtube.com/embed/aUPqqWDv30I" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
                           <?php
                           } ?>
                        </div>
                     </div>
                  </div>
               </div>
            <?php } else { ?>
               <!-- product description end  -->

               <!-- product description start  -->
               <div class="product-description">
                  <ul class="nav nav-tabs md-tabs" id="myTabMD" role="tablist">
                     <li class="nav-item">
                        <a class="nav-link active" id="profile-tab-md" data-toggle="tab" href="#profile-md" role="tab" aria-controls="profile-md" aria-selected="false">Technology & Description </a>
                     </li>
                  </ul>
                  <div class="tab-content card pt-3 py-4 px-4" id="myTabContentMD">
                     <div class="tab-pane fade show active" id="profile-md" role="tabpanel" aria-labelledby="profile-tab-md">
                        <div class="py-3">
                           <h4 class="mb-2">TECHNICAL SPECIFICATIONS</h4>
                           <div class="row technical-description align-items-center">
                              <div class="col-md-<?php if ($product_slug != "accessories") {
                                                      echo '5';
                                                   } else {
                                                      echo '12';
                                                   } ?> image-box">
                                 <img src="<?php echo SITEURL; ?>img/product/<?php echo $prod_row['image']; ?>">
                              </div>
                              <?php
                              if ($product_slug != "accessories") {
                              ?>
                                 <div class="col-md-7 content-box">
                                    <div class="inner-box">
                                       <div><img alt="Icon" src="<?php echo SITEURL; ?>img/icon/10.png" /></div>
                                       <div class="content-right">
                                          <h3>High Quality</h3>
                                          <p>Formulated to meet medical industry standards</p>
                                       </div>
                                    </div>
                                    <div class="inner-box">
                                       <div><img alt="Icon" src="<?php echo SITEURL; ?>img/icon/11.png" /></div>
                                       <div class="content-right">
                                          <h3>Realistic</h3>
                                          <p>Lifelike texture and viscosity</p>
                                       </div>
                                    </div>


                                    <div class="inner-box">
                                       <div><img alt="Icon" src="<?php echo SITEURL; ?>img/icon/12.png" /></div>
                                       <div class="content-right">
                                          <h3>Safe for Skin</h3>
                                          <p>Uses food coloring that is skin-safe but may stain</p>
                                       </div>
                                    </div>
                                 </div>
                              <?php
                              }
                              ?>
                           </div>

                           <div class="pdp-aditional-features dnone">
                              <div class="col-md-12">
                                 <div class="pro-des-details">
                                    <h4 class="mb-2">DESCRIPTION</h4>
                                    <div style="font-size: 20px;"><?php echo $prod_row['description']; ?></div>
                                    <div style="font-size: 20px;"><?php echo $prod_row['technical']; ?></div>
                                 </div>
                              </div>
                           </div>
                        </div>

                     </div>
                  </div>
               </div>
         </div>
         <!-- product description end  -->
      <?php }  ?>
      </div>
      </section>
      <!-- product section end -->



      <!-- Alternate usage images slider start -->
      <!--       <section class="Alternate-images-section">
         <div class="container-fluid">
            <div class="alternate-images-slider">
               <?php
               $big_img = $db->getData("product_picture_large", "*", "isDelete=0 AND product_id=" . $product_id);
               foreach ($big_img as $value) {
               ?>
                  <div class="slick-slide">
                     <img src="<?php echo SITEURL . "img/accessorie_img/" . $value['image_path']; ?>">
                  </div>
               <?php
               }
               ?>
            </div>
         </div>
      </section> -->
      <!-- Alternate usage images slider end -->
   <?php } else { ?>
      <div class="container mt-5">
         <!-- Check if there are products -->
         <div class="row">
            <div class="col-12 text-center">
               <h2>Product Not Found</h2>
               <p>Sorry, the product you're looking for is not available at the moment.</p>
               <a href="/" class="btn btn-primary">Back to Home</a>
            </div>
         </div>
      </div>

   <?php } ?>


   <!-- mini-cart-mobile modal start  -->
   <div class="modal fade d-lg-none d-md-none d-none" id="mini-cart-mobile">
      <div class="modal-dialog" role="document">
         <div class="modal-content">
            <div class="modal-header">
               <div class="last-item-name">
                  <h3 id="product_name_data"></h3>
                  <p>Product been added to your cart</p>
               </div>
               <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
               </button>
            </div>
            <div class="modal-body">
               <div class="mini-cart-cta">
                  <a href="<?php echo SITEURL ?>product/ballistics-gel" class="mini-cart-keep-shopping button-outline">KEEP SHOPPING</a>
                  <a href="<?php echo SITEURL ?>cart/" class="mini-cart-mobile-checkout button-dark">VIEW CART</a>
               </div>
            </div>
         </div>
      </div>
   </div>

   <!-- Alternate usage images slider end -->
   <?php include 'front_include/footer.php'; ?>
   <?php include 'front_include/js.php'; ?>
   <script type="text/javascript">
      // function add_to_cart()
      // {
      // 	var qty = $('#quantity_value').val();
      // 	var price = $('#price').val();

      // 	$.ajax({
      // 		url: '<?php echo SITEURL; ?>product_db.php', 
      // 		method: 'post', 
      // 		data: 'mode=add_to_cart&product_id=<?php echo $product_id; ?>&qty='+qty+'&price='+price, 
      //            beforeSend: function(){
      //                $(".loader").show(); 
      //            },
      // 		success: function(res) {
      //                $(".loader").hide();
      // 			// window.location = '<?php echo SITEURL; ?>cart/';
      //          mini_header_modal(product_id);
      //          header_cart();
      //          $('.mini-cart-content-wrap').css({
      //             'opacity': '1',
      //             'visibility': 'visible',
      //          });
      // 		}
      // 	});
      // }

      function add_to_cart(product_id, price) {
         var qty = $('#quantity_value').val();
         var color = $('input[name="color"]:checked').val() ?? '';
         $.ajax({
            url: '<?php echo SITEURL; ?>product_db.php',
            method: 'post',
            data: 'mode=add_to_cart&product_id=' + product_id + '&qty=' + qty + '&price=' + price + '&color=' + color,
            beforeSend: function() {
               $(".loader").show();
            },
            success: function(res) {
               /*                      var dd = JSON.parse(res);
                                    console.log(dd['zero']);
                                    // alert(res);
                                    if (dd['zero'] == "0") {
                                       alert("Value must be less than or equal to "+dd['pro_qty']);
                                    }
                                    if (dd['zero'] == "2") {
                                       alert("Out of Stock ");
                                    } */
               $(".loader").hide();
               header_cart_count();
               mini_header_modal(product_id);
               header_cart();
               cart_drawer_details();
               slideOutPanel.open();
               /*                $('.mini-cart-content-wrap').css({
                                 'opacity': '1',
                                 'visibility': 'visible',
                              }); */
            }
         });
      }

      function add_to_cart_accessories(id, price) {
         //	alert(id);
         var qty = 1
         // var price = $('#price').val();

         $.ajax({
            url: '<?php echo SITEURL; ?>product_db.php',
            method: 'post',
            data: 'mode=add_to_cart&product_id=' + id + '&qty=' + qty + '&price=' + price,
            beforeSend: function() {
               $(".loader").show();
               header_cart_count();
            },
            success: function(res) {
               $(".loader").hide();
               header_cart_count();
               window.location = '<?php echo SITEURL; ?>cart/';
            }
         });
      }

      $('.minus').click(function() {
         // alert("minus");
         var $input = $(this).parent().find('input');
         var count = parseInt($input.val()) - 1;
         count = count < 1 ? 1 : count;
         $input.val(count);
         $input.change();
         return false;
      });
      $('.plus').click(function() {
         // alert("plus");
         var $input = $(this).parent().find('input');
         $input.val(parseInt($input.val()) + 1);
         $input.change();
         return false;
      });
   </script>
   <script src="https://cdn.jsdelivr.net/gh/thelevicole/youtube-to-html5-loader@2.0.0/dist/YouTubeToHtml5.js"></script>
   <script>
      new YouTubeToHtml5();
   </script>
</body>

</html>