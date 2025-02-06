<?php
include "connect.php";

$page = "Product";
$ctable = "product";

$p_id = $db->clean($_REQUEST['p_id']);

$ctable_where = "isDelete=0 AND isActive=1";

if ($_REQUEST['height'] == "")
{
    $height = 'height IS NULL';
}
else
{
    $height = $_REQUEST['height'];
}
if ($_REQUEST['width'] == "")
{
    $width = 'width IS NULL';
}
else
{
    $width = $_REQUEST['width'];
}
if ($_REQUEST['length'] == "")
{
    $length = 'length IS NULL';
}
else
{
    $length = $_REQUEST['length'];
}

if (isset($_REQUEST['searchName']) && !empty($_REQUEST['searchName']))
{
    $ctable_where .= " AND (name like '%" . $_REQUEST['searchName'] . "%')";
}
// if (isset($_REQUEST['CaliberName']) && !empty($_REQUEST['CaliberName']))
// {
//     $ctable_where .= " AND caliber_id = " . $_REQUEST['CaliberName'] . "";
// }
// if (isset($_REQUEST['length']) && !empty($_REQUEST['length']))
// {
//     $ctable_where .= " AND unit='in' AND length = " . $length . "";
// }
// if (isset($_REQUEST['height']) && !empty($_REQUEST['height']))
// {
//     $ctable_where .= " AND  height = " . $height . "";
// }
// if (isset($_REQUEST['width']) && !empty($_REQUEST['width']))
// {
//     $ctable_where .= " AND   width = " . $width . "";
// }
// if (isset($_REQUEST['page']) && !empty($_REQUEST['page']))
// {
//     $ctable_where .= $_REQUEST["page"];
// }
if (isset($_REQUEST['page']) && !empty($_REQUEST['page']))
{
    $current_page = $_REQUEST["page"];
}
else
{
    $current_page = 1;
}
    // $current_page = 1;

$num_show = 9;
if (isset($_REQUEST['main_search']) && !empty($_REQUEST['main_search'])){

	$total_records;

	if (isset($_REQUEST['main_search']) && !empty($_REQUEST['main_search']))
	{
	    $ctable_where .= " AND (name like '%" . $_REQUEST["main_search"] . "%')";
	}

	$start_from = ($current_page - 1) * $num_show;
	$limit = " LIMIT $start_from , $num_show";

	$ctable_r = $db->getData($ctable, "*", $ctable_where);
	$total_records = @mysqli_num_rows($ctable_r);

	$total_pages = ceil($total_records / $num_show);

	if ($total_records < $start_from)
	{
	    $start_from = 0;
	    $current_page = 1;
	    $limit = " LIMIT $start_from , $num_show";
	}

	
	$ctable_where .= $limit;

	$pass = 3;
	$count = 1;
	$product = $db->getData($ctable, "*", $ctable_where);

	// echo "<pre>";
	// print_r($_REQUEST);
	// die;
}


	// if (isset($_REQUEST['searchName']) && !empty($_REQUEST['searchName']))
	// {
	// 	echo "3asdadas";
	// 	exit();
	// }
// $num_show = 9;


// if ($_REQUEST['main_search'])
if (isset($_REQUEST['slug']) && !empty($_REQUEST['slug']) && empty($_REQUEST['main_search']))
{
    $total_records;

    $num_show = 9;
    if (isset($_REQUEST['page']) && !empty($_REQUEST['page']))
    {
        $current_page = $_REQUEST["page"];
    }
    else
    {
        $current_page = 1;
    }
    $rsdupli = $db->getData('category', '*', 'slug = "' . $_REQUEST["slug"] . '" AND isDelete=0');

    $Cid;
    while ($rsdupli_data = mysqli_fetch_assoc($rsdupli))
    {
        $Cid = $rsdupli_data['id'];
    }


	// $join = 'SELECT DISTINCT * FROM `prod_cate` LEFT JOIN product ON product.id = prod_cate.product_id WHERE prod_cate.cate_id  = ' . $Cid . ' AND product.isDelete=0 AND prod_cate.isDelete=0 AND (product.name LIKE "%'.$searchName .'%") ';	

	$join = " LEFT JOIN product ON product.id = prod_cate.product_id";
	$where = ' prod_cate.cate_id  = ' . $Cid . ' AND product.isDelete=0 AND prod_cate.isDelete=0';
	$row = " DISTINCT *";
	$order = "";

	if (isset($_REQUEST['searchName']) && !empty($_REQUEST['searchName']))
	{
	    $where .= " AND (product.name like '%" . $_REQUEST['searchName'] . "%')";
	}
	if (isset($_REQUEST['CaliberName']) && !empty($_REQUEST['CaliberName']))
	{
	    $where .= " AND FIND_IN_SET(" . $_REQUEST['CaliberName'] . ", product.caliber_id)";
	}
	if (isset($_REQUEST['height']) && !empty($_REQUEST['height']))
	{
		$height_size = $_REQUEST['height'];
		$height_plus = $height_size + 5; 
		$height_minus = $height_size - 5; 
	    $where .= " AND product.height BETWEEN ". $height_minus . " AND ".$height_plus."";
	}
	if (isset($_REQUEST['length']) && !empty($_REQUEST['length']))
	{
		$length_size = $_REQUEST['length'];
		$length_plus = $length_size + 5; 
		$length_minus = $length_size - 5; 
	    $where .= " AND product.length BETWEEN ". $length_minus . " AND ".$length_plus."";
	}
	if (isset($_REQUEST['width']) && !empty($_REQUEST['width']))
	{
		$width_size = $_REQUEST['width'];
		$width_plus = $width_size + 5; 
		$width_minus = $width_size - 5; 
	    $where .= " AND product.width BETWEEN ". $width_minus . " AND ".$width_plus."";
	}

    $start_from = ($current_page - 1) * $num_show;

    $limit = " LIMIT $start_from , $num_show";
    $total_records = $db->getTotalRecord_JoinData2("prod_cate",$join,$where);
    $total_pages = ceil($total_records / $num_show);

    if ($total_records < $start_from)
    {
        $start_from = 0;
        $current_page = 1;
        $limit = " LIMIT $start_from , $num_show";
    }
    $order .= " product.id DESC". $limit;

    $product = $db->getJoinData2("prod_cate",$join,$row,$where,$order);

    $pass = 3;
    $count = 1;
    

}

?>
<div class="row">
<?php
if (@mysqli_num_rows($product) > 0)
{
    while ($product_data = mysqli_fetch_assoc($product))
    {
        // $product_data['id'];

        $where = "pc.isDelete=0 AND p.isDelete=0 AND p.id=".$product_data['id'];
        $join = " LEFT JOIN product p ON p.id = pc.product_id";
        $rows = "pc.cate_id";
        $join_result_q = @mysqli_fetch_assoc($db->getJoinData2("prod_cate pc",$join,$rows,$where,"",0));

        $cat_slug = $db->getValue("category","slug","id='".$join_result_q['cate_id']."' ",0);

		?>
		<div class="col-lg-4 col-md-6 <?php echo $count; ?>" >
			<div class="product-section-box">
				<div class="product-section-inner">
				<div class="product-title">
					<a href="#"><h5><?php echo $product_data['name']; ?></h5></a>
				
					<div class="product-pricing">
						<span class="product-sales-price" title="product-sales-pricee"><?php echo CURR.$product_data['price']; ?><!-- <del><?php echo CURR.$product_data['sell_price']; ?></del> --></span>
					</div>
				</div>
				<?php
					if ($product_data['new'] == 1) {
						?>
						<div class="tag_new">
							New 
						</div>
						<?php
					}
				elseif ($product_data['onSale'] == 1) {
					?>
						<div class="tag_new on_sale">
							On Sale 
						</div>
					<?php
				}
				elseif ($product_data['out_of_stock'] == 1) {
					?>
						<div class="tag_new Outof_Stock">
							Out of Stock 
						</div>
					<?php
				}
				?>
				</div>
				
				<div class="product-images">

					<?php 
					$url = "img/product/".$product_data['image'];
					if (file_exists($url) && $product_data['image'] != "") { ?>
					<a href="javascript:void(0);"><img src="<?php echo SITEURL.$url; ?>"></a>  
					<?php } else { ?>
					<a href="javascript:void(0);"><img src="<?php echo SITEURL; ?>img/noavailable2.png"></a>
					<?php } ?>
					<!-- <a href="<?php echo SITEURL; ?>product-details/<?php echo $cat_slug; ?>/<?php echo $product_data['id']; ?>/"> -->
					<a href="<?php echo SITEURL; ?>shop/<?php echo $product_data['slug']; ?>/">
					<div class="overlay"></div>
					<div class="button"> view product </div></a>
				</div>

					<?php
					if ($product_data['new'] == 1) {
						?>
						<div class="product_view-btn">
							<a data-toggle="modal"  id="<?php echo $product_data['id']; ?>" href="javascript:void(0);" class="cart-btn" onclick="add_to_cart(<?php echo $product_data['id']; ?>,<?php echo $product_data['price']; ?>);">add to cart</a>
						</div>
						<?php
					}
					elseif ($product_data['onSale'] == 1) {
						?>
							<div class="product_view-btn">
								<a data-toggle="modal" id="<?php echo $product_data['id']; ?>" href="javascript:void(0);" class="cart-btn" onclick="add_to_cart(<?php echo $product_data['id']; ?>,<?php echo $product_data['price']; ?>);">add to cart</a>
							</div>
						<?php
					}
					elseif ($product_data['out_of_stock'] == 1) {
						?>
							<div class="product_view-btn">
								<a href="javascript:void(0);" class="cart-btn">Out Of Stock</a>
							</div>
						<?php
					}
					elseif ($product_data['new'] == 0) {
						?>
						<div class="product_view-btn">
							<a data-toggle="modal" id="<?php echo $product_data['id']; ?>" href="javascript:void(0);" class="cart-btn" onclick="add_to_cart(<?php echo $product_data['id']; ?>,<?php echo $product_data['price']; ?>);">add to cart</a>
						</div>
						<?php 
					} ?>
			</div>
		</div>

			<?php
			if(!empty($product_data['random_image']) && $count == $pass) {
				$pass = $pass+4;
				
				?>
				<div class="col-lg-4 col-md-6 <?php echo $count.' '.$pass; ?>">
					<div class="product-section-box">
						<a href="#"><img src="<?php echo SITEURL; ?>img/product/<?php echo $product_data['random_image']; ?>" class="product-hightlight"></a>
					</div>
				</div>


				<?php
			}
			$count++;
	}

	?>
	</div>

	<?php
	if ($total_pages > 1) {
		?>
		<div class="ps-pagination">
			<ul class="pagination">
				<?php for($i=0; $i<$total_pages; $i++) { ?>
				<li class="<?php if($current_page == $i+1){ echo 'active'; } ?>"><a href="javascript:void(0)" onclick="search_paginate(<?php echo $i+1; ?>);" ><?php echo ($i+1) ?></a></li>
				<?php } ?>
				<!-- <li><a href="javascript:void(0)" onclick="search_paginate(<?php echo ($current_page+1); ?>);">Next Page<i class="icon-chevron-right"></i></a></li> -->
			</ul>
		</div>
		<?php
	}

}
else
{
	?>
    <div class="noProduct-sec">
	   <h1>No Product</h1>
    </div>


	<?php 
} ?>

<!-- mini-cart-mobile modal start  -->
<div class="modal fade d-lg-none d-md-none d-none" id="mini-cart-mobile">
   <div class="modal-dialog" role="document">
      <div class="modal-content">
         <div class="modal-header">
            <div class="last-item-name">
               <h3 id="product_name_data"></h3>
               <p>Product been added to your cart</p>
            </div>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close" >
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

<script type="text/javascript">
	$("#total").html('<?php echo $total_records; ?>'+' results');

	// function mini_header_modal(product_id)
	// {
	// 	$.ajax({
	// 		type: "POST",
	// 		url: SITEURL+'product_db.php',
	// 		data: {
	// 			product_id:product_id,
	// 			mode:'Product_name_data',
	// 		},
	// 		beforeSend: function(){
	//             $(".loader").show(); 
	//         },
	// 		success: function(data)
	// 		{
	// 			$(".loader").hide(); 
	// 			$("#product_name_data").text(data);
	// 			$("#mini-cart-mobile").modal('show');
	// 		},
	// 	});	
	// }

	function add_to_cart(product_id,price)
	{
		$.ajax({
			url: '<?php echo SITEURL; ?>product_db.php', 
			method: 'post', 
			data: 'mode=add_general&product_id='+product_id+'&price='+price, 
            beforeSend: function(){
                $(".loader").show(); 
            },
			success: function(res) {
                $(".loader").hide();
                mini_header_modal(product_id);
                header_cart();
                $('.mini-cart-content-wrap').css({
			        'opacity': '1',
			        'visibility': 'visible',
			    });
			}
		});
	}

	function search_paginate(p_id) 
    {
    	var searchName  = $("#prod_search").val();
		searchName      = encodeURIComponent(searchName.trim());
		var slug 		= '<?php print_r($_REQUEST['slug']); ?>';
		var main_search = '<?php print_r($_REQUEST['main_search']) ?>';
		slug      		= encodeURIComponent(slug.trim());
		main_search     = encodeURIComponent(main_search.trim());
        if(p_id!='')
        {
            var data_url = "<?php echo SITEURL ?>ajax_get_main_search_<?php echo $ctable; ?>.php?page=" + p_id +"&main_search="+main_search;
            $("#results" ).html("");
            $(".loader").show();
            $("#pagi"+p_id).addClass('active');
            
            loadDataTable(data_url);
        }
    }

</script>