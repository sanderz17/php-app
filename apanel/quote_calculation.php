<?php
include("connect.php");
$db->checkAdminLogin();
include("../include/notification.class.php");


$ctable 	= 'quote';
$ctable1 	= 'Quotations';
$main_page 	= 'Quotations'; //for sidebar active menu
$page		= 'quotations';
$page_title = ucwords($_REQUEST['mode'])." ".$ctable1;


// echo "<pre>";
// print_r($_REQUEST);
// die;

$cart_id = $_REQUEST['id'];

$zipcode = $db->getValue("quote","zipcode","id='".$cart_id."' ");
$country = $db->getValue("quote","country","id='".$cart_id."' ");

$rs_cart = $db->getData($ctable, '*', 'id=' . (int) $cart_id . ' AND isDelete=0');
$row_cart = @mysqli_fetch_assoc($rs_cart);

$customer_id 			= $row_cart['customer_id'];
$order_no 				= $row_cart['order_no'];
$shipping_tracking_id 	= $row_cart['shipping_tracking_id'];


$shop_cart_r = $db->getData("quote_detail","*","quote_id='".$cart_id."' AND isDelete=0","");
if(@mysqli_num_rows($shop_cart_r)>0)
{			
	$total_tot = 0;
	while($shop_cart_d = @mysqli_fetch_array($shop_cart_r))
	{
		$total_tot 	+= $shop_cart_d['price'];
	}
}

$shop_cart_order_r = $db->getData("quote_detail","*","quote_id='".$cart_id."' AND isDelete=0","");
if(@mysqli_num_rows($shop_cart_order_r)>0)
{			
	$total_order_tot = 0;
	while($shop_cart_d = @mysqli_fetch_array($shop_cart_order_r))
	{
		$total_order_tot 	+= $shop_cart_d['sub_total'];
	}
}

// echo "<pre>";
// print_r($row_cart);
// die;

$rs_bs 	= $db->getData('quote', "*", 'id='.(int) $cart_id . ' AND isDelete=0');
$row_bs 	= @mysqli_fetch_assoc($rs_bs);

$billing_first_name			=	stripslashes($row_bs['name']);
$billing_email				=	stripslashes($row_bs['billing_email']);
$billing_phone				= 	stripslashes($row_bs['billing_phone']);
$billing_address			= 	stripslashes($row_bs['address1']);
$billing_address2			= 	stripslashes($row_bs['address2']);
$billing_city				=	stripslashes($row_bs['city']);
$billing_state				=	stripslashes($row_bs['state']);
$billing_country			=	stripslashes($row_bs['country']);
$billing_zipcode			=	stripslashes($row_bs['zipcode']);


$rs_user = $db->getData('user', 'CONCAT(first_name, last_name) as name, email', 'id='. (int) $row_cart['customer_id']);
$row_user = @mysqli_fetch_assoc($rs_user);

?>

<!DOCTYPE html>
<html lang="en">
	<head>
		<title><?php echo $page_title . ' | ' . ADMINTITLE; ?></title>
		<?php include('include/css.php'); ?>
	</head>
	<body>
		<div class="container-scroller">
			<?php include("include/header.php"); ?>
			<div class="container-fluid page-body-wrapper">
				<?php include("include/left.php"); ?>
				<div class="main-panel" style="max-width: 100%;">
					<div class="content-wrapper">
						<div class="page-header">
							<h3 class="page-title">
							<span class="page-title-icon bg-gradient-dark text-white mr-2">
								<i class="mdi mdi-contacts"></i>
							</span> <?php echo $page_title; ?> </h3>
						</div>
						<div class="row">
							<div class="col-md-12 grid-margin stretch-card">
								<div class="card">
										<input type="hidden" name="mode" id="mode" value="<?php echo $_REQUEST['mode']; ?>">
										<input type="hidden" name="id" id="id" value="<?php echo $_REQUEST['id']; ?>">
										<div class="card-body">
											<div class="row">
												<div class="col-md-6">
													<div class="form-group">
														<label for="state">SHIPPING METHOD <code>*</code></label>
									                    <div class="col-md-12 p-0">
									                        <select class="form-control" name="shipping_method" id="shipping_method" onChange="rpAddShippingCharge(this.value);">
									                            <option value="">Please Select Shipping Method</option>
									                            <?php 
									                            $shipping_method_d = $db->getData("shipping_method","*","isDelete=0","");
									                            if(@mysqli_num_rows($shipping_method_d)>0){
									                                while($shipping_d = @mysqli_fetch_array($shipping_method_d)){
									                                    ?>
									                                    <option 
									                                    <?php echo ($shipping_d['service_code']==03)?"selected":""; ?>
									                                    value="<?php echo $shipping_d['service_code']; ?>"><?php echo $shipping_d['name']; 
									                                    ?></option>
									                                    <?php 
									                                } 
									                            } 
									                            ?>
									                        </select>
									                    </div>
													</div>
													<div class="form-group payshipping">
														<span class="cfw-small">Enter your address to view shipping options.</span>
													</div>
													<div class="form-group payfinaltot">
														<strong>
		                                                    <span>
		                                                    <bdi><?php //echo CUR.$db->getCartSubTotalPrice(); ?></bdi>
		                                                    </span>
		                                                   </strong>
													</div>
												</div>
												<div class="col-md-6">
												</div>
											</div>

										</div>


								</div>
							</div>
						</div>

						<div class="page-header mb-3 mt-2">
							<h3 class="page-title">
								 <a class="btn btn-gradient-success btn-icon-text" href="javascript:void(0);" onclick="createPDF();"> Get Quotations</a>
							</h3>
						</div>
						<div class="row quotations-pdf" id="pdf_section">
							<div class="col-lg-12">
								<div class="card mb-4  border-left-info">
									<form role="form" name="frm" id="frm" action="." method="post" enctype="multipart/form-data">
										<input type="hidden" name="mode" id="mode" value="update">
										<input type="hidden" name="id" id="id" value="<?php echo $_REQUEST['id']; ?>">

										<div class="card-body col-lg-12">
											<div class="table-responsive">
											<table class="table table-space-admin table-bordered table-striped">
												<tbody>
													<tr>
														<td><strong>Customer Name</strong></td>
														<td><?php echo $billing_first_name; ?></td>
														<td colspan="2"></td>
													</tr>
													<tr>
														<td><strong>Sub Total</strong></td>
														<td><?php echo CUR.$db->num($total_tot); ?></td>
													</tr>
													<tr>
														<td><strong>Order Date</strong></td>
														<td><?php echo (!is_null($row_cart['order_date']))?$db->date($row_cart['order_date'], 'm/d/Y'):$db->date($row_cart['adate'], 'm/d/Y'); ?></td>
														<td><strong>Tax</strong></td>
														<td><?php echo CUR.$db->num($row_cart['tax']); ?></td>
													</tr>
													<tr>
														<td><strong>Order Status</strong></td>
														<td><?php 
																	switch( $row_cart['order_status'] )
																	{
																		case 0:
																			echo 'Cancelled';
																			break; 
																		case 2:
																			echo 'Awaiting Shipment';
																			break; 
																		case 3:
																			echo 'Shipped';
																			break; 
																		case 4:
																			echo 'Delivered';
																			break; 
																		default:
																			echo 'In Progress';
																			break; 
																	}
																?>
														</td>
														<td><strong>Shipping</strong></td>
														<td><?php echo CUR.$db->num($row_cart['shipping']); ?></td>
													</tr>
													<tr>
														<td><strong>Shipping Method</strong></td>
														<!-- <td><?php //echo $row_cart['shipping_method'] . ' : ' . $row_cart['shipping_method_name']; ?></td> -->
														<td><?php 

															echo $db->getValue("shipping_method","name","service_code='".$row_cart['shipping_method']."' ");
															?></td>
														<td><strong>Order Amount</strong></td>
														<!-- <td><?php echo CUR.$db->num($row_cart['grand_total']); ?></td> -->
														<td><?php
															// $counter1 = 0;
														    
							    								// $counter1++;
															 	echo CUR.$db->num($total_order_tot); 
															 ?>
															 	
														</td>
														
													</tr>
												</tbody>
											</table>
													
											<table id="user" class="table table-space-admin table-bordered table-striped">
												<tbody>
													<tr>
														<th>Details</th>
														<th>Billing Details</th>
														<th>Shipping Details</th>
													</tr>

													<tr>
														<td>Name</td>
														<td><span class="text-muted"> <?php echo $billing_first_name.' '.$billing_last_name; ?></span></td>
														<td><span class="text-muted"> <?php echo $shipping_first_name.' '.$shipping_last_name; ?></span></td>
													</tr>
													<tr>
														<td>Address1</td>
														<td><span class="text-muted"> <?php echo $billing_address; ?></span></td>
														<td><span class="text-muted"> <?php echo $shipping_address; ?></span></td>
													</tr>
													<tr>
														<td>Address2</td>
														<td><span class="text-muted"> <?php echo $billing_address2; ?></span></td>
														<td><span class="text-muted"> <?php echo $shipping_address2; ?></span></td>
													</tr>
													<tr>
														<td>City</td>
														<td><span class="text-muted"> <?php echo $billing_city; ?></span></td>
														<td><span class="text-muted"> <?php echo $shipping_city; ?></span></td>
													</tr>
													<tr>
														<td>State</td>
														<td><span class="text-muted"> <?php echo $db->getValue('states', 'name', 'id=' .$billing_state); ?></span></td>
														<td><span class="text-muted"> <?php echo $db->getValue('states', 'name', 'id=' .$shipping_state); ?></span></td>
													</tr>
													<tr>
														<td>Country</td>
														<td><span class="text-muted"> <?php echo $billing_country; ?></span></td>
														<td><span class="text-muted"> <?php echo $shipping_country; ?></span></td>
													</tr>
													<tr>
														<td>Zipcode</td>
														<td><span class="text-muted"> <?php echo $billing_zipcode; ?></span></td>
														<td><span class="text-muted"> <?php echo $shipping_zipcode; ?></span></td>
													</tr>
													
												
												</tbody>
											</table>
											
											<table class="table table-space-admin table-bordered">
												<thead>
													<tr>
														<th class="text-center">#</th>
														<th class="text-center">Image</th>
														<th>Product Name</th>
														<th class="text-center">Quantity</th>
														<!-- <th class="text-center">Tax</th> -->
														<th class="text-center">Subtotal</th>
														<th class="text-center">Total</th>
													</tr>
												</thead>
												<tbody>
												<?php
													$counter = 0;
												    $strquery = 'SELECT ct.*, p.name AS product_name, p.image 
												                 FROM quote_detail ct 
												                 LEFT JOIN product p ON p.id = ct.product_id 
												                 WHERE ct.quote_id = ' . (int) $cart_id . ' AND ct.isDelete=0 AND p.isDelete=0';
												    // print $strquery;
												    $rs_detail = @mysqli_query($myconn, $strquery);
					    							while( $row_detail = @mysqli_fetch_assoc($rs_detail) )
					    							{
					    								$counter++;
											
														$tt = $db->num($row_detail['price']);
														$tax = $db->num(($tt * TAX_RATE) / (100 + TAX_RATE) );
														$tt = $db->num($tt - $tax);
					    						?>
													<tr>
														<td class="text-center"><?php echo $counter; ?></td>
														<td class="text-center"><img src="<?php echo SITEURL.PRODUCT.$row_detail['image']; ?>" class="img-fluid" width="70"></td>
														<td><?php echo $row_detail['product_name']; ?>
									                       
														</td>
														<td class="text-center"><?php echo $row_detail['qty']; ?></td>
														<!-- <td class="text-center"><?php echo CUR.$db->num($tax); ?></td> -->
														<td class="text-center"><?php echo CUR.$db->num($tt); ?></td>
														<td class="text-center"><?php echo CUR.$db->num($row_detail['sub_total']); ?></td>
													</tr>
					    						<?php
					    							}
												?>
												</tbody>
											</table>
												</div>
										</div>
									</form>
								</div>
							</div>
						</div>
					</div>
					<!-- content-wrapper ends -->
					<?php include("include/footer.php"); ?>
				</div>
				
				<!-- main-panel ends -->
			</div>
			<!-- page-body-wrapper ends -->
		</div>
	</body>
	<?php include('include/js.php'); ?>
	<script src="https://cdn.bootcss.com/html2pdf.js/0.9.1/html2pdf.bundle.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.9.1/html2pdf.bundle.min.js"></script>
	<script type="text/javascript">
		function rpAddShippingCharge(s){
            var zip = <?php echo $billing_zipcode; ?>;
            var country = <?php echo $billing_country; ?>;
            var quote_id = <?php echo $cart_id; ?>;

            // alert(zip);
            if(s==undefined){
                var s = $("#shipping_method").val();
            }

            $.ajax({
                type: "POST",
                url: "<?php echo ADMINURL; ?>ajax_add_quoteshipping_charge.php",
                data: 's='+s+'&zip='+zip+'&c='+country+'&quote_id='+quote_id,
                beforeSend: function() {
                    $(".preloader").show();
                },
                dataType : 'Json',
                success: function(result){
                	// alert(result);
                    if(result['is_blank_arr'] == 1)
                    {
                        rpAddShippingCharge(s);
                    }
                    else
                    {
                        $(".payshipping").html(result['shipping']);
                        $(".payfinaltot").html(result['finaltot']);
                    }
                    $(".preloader").hide();
                }
            });
        }
        function createPDF(){

                var element = document.getElementById('pdf_section');
                html2pdf(element, {
                    margin:0,
                    padding:0,
                    filename: 'myfile.pdf',
                    image: { type: 'jpeg', quality: 1 },
                    html2canvas: { scale: 2,  logging: true },
                    jsPDF: { unit: 'in', format: 'A4', orientation: 'P' },
                    class: createPDF
                });
            };
	</script>
</html>