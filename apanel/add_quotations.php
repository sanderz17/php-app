<?php
	include("connect.php");
	$db->checkAdminLogin();
	include("../include/notification.class.php");
	
	$ctable 	= 'quote';
	$ctable1 	= 'Quotations';
	$main_page 	= 'Quotations'; //for sidebar active menu
	$page		= 'quotations';
	$page_title = ucwords($_REQUEST['mode'])." ".$ctable1;

	$name = "";
	$from_date	= "";
	$to_date	= "";
	$address1	= "";
	$address2	= "";
	$city		= "";
	$state		= "";
	$country	= "";
	$zipcode	= "";
	$quote_status = "";
	$isVerified = "";

	if(isset($_REQUEST['submit']))
	{
		// print_r($_REQUEST); exit;
		$name = $db->clean($_REQUEST['name']);
		$from_date 	= $db->clean($_REQUEST['from_date']);
		$to_date 	= $db->clean($_REQUEST['to_date']);
		$address1 	= $db->clean($_REQUEST['address1']);
		$address2 	= $db->clean($_REQUEST['address2']);
		$city 		= $db->clean($_REQUEST['city']);
		$state 		= $db->clean($_REQUEST['state']);
		$country 		= $db->clean($_REQUEST['country']);
		$zipcode 		= $db->clean($_REQUEST['zipcode']);
		$quote_status 		= $db->clean($_REQUEST['quote_status']);
		$notes 		= $db->clean($_REQUEST['notes']);

		$rows 	= array(
			'name'=> $name,
			'from_date' => $from_date,
			'to_date' 	=> $to_date,
			'address1'	=> $address1,
			'address2'	=> $address2,
			'city'		=> $city,
			'state'		=> $state,
			'country'	=> $country,
			'zipcode'	=> $zipcode,
			'quote_status'	=> $quote_status,
			'notes'	=> $notes,
		);


		if(isset($_REQUEST['mode']) && $_REQUEST['mode']=="add")
		{
			$user_id = $db->insert($ctable, $rows);

			$sub_total = 0;

			for($i = 0, $l = count($_REQUEST["pprodesc"]); $i < $l; $i++) { 
		    	$loc_info = array(
		    					'ppro_ids' => $_REQUEST["pprodesc"][$i],
		    					'pqtys' => $_REQUEST["pqty"][$i],
		    					'pprices' => $_REQUEST["pprice"][$i]
		    				);

		    	$sub_total = $loc_info['pprices'] * $loc_info['pqtys'];

		    	$pro_rows 	= array(
					'quote_id'=> $user_id,
					'product_id' => $loc_info['ppro_ids'],
					'qty' 	=> $loc_info['pqtys'],
					'price'	=> $loc_info['pprices'],
					'sub_total' => $sub_total
				);
		    		$db->insert("quote_detail", $pro_rows,0);

		    }

			
			$_SESSION['MSG'] = 'Inserted';
			$db->location(ADMINURL.'manage-'.$page.'/');
			exit;
		}
		if(isset($_REQUEST['mode']) && $_REQUEST['mode']=="edit" && $_REQUEST['id'] != null)
		{
			$id = $_REQUEST['id'];
			$user_id = $db->update($ctable, $rows, 'id='.$id);

			$sub_total = 0;

			for($i = 0, $l = count($_REQUEST["pprodesc"]); $i < $l; $i++) { 
		    	$loc_info = array(
		    					'ppro_ids' => $_REQUEST["pprodesc"][$i],
		    					'pqtys' => $_REQUEST["pqty"][$i],
		    					'pprices' => $_REQUEST["pprice"][$i],
		    					'main_row_ids' => $_REQUEST["main_row_ids"][$i]
		    				);

		    	$sub_total = $loc_info['pprices'] * $loc_info['pqtys'];

		    	$pro_rows 	= array(
					'quote_id'=> $_REQUEST['id'],
					'product_id' => $loc_info['ppro_ids'],
					'qty' 	=> $loc_info['pqtys'],
					'price'	=> $loc_info['pprices'],
					'sub_total' => $sub_total
				);

				$r = $db->dupCheck("quote_detail", "id = '".$loc_info['main_row_ids']."' AND isDelete=0",0);
				if($r)
				{
					$db->update("quote_detail", $pro_rows, 'id='.$loc_info['main_row_ids']);
				}
				else
				{
		    		$db->insert("quote_detail", $pro_rows,0);
				}
			}
							
			$_SESSION['MSG'] = 'Updated';
			// $db->location(ADMINURL.'manage-'.$page.'/');
			$db->location(ADMINURL.'quote-calculation/'.$_REQUEST['mode'].'/'.$_REQUEST['id']);
			exit;
		}
	}

	if(isset($_REQUEST['id']) && $_REQUEST['id']>0 && $_REQUEST['mode']=='edit')
	{
		$where 		= ' id='.$_REQUEST['id'].' AND isDelete=0';
		$ctable_r 	= $db->getData($ctable, '*', $where);
		$ctable_d 	= @mysqli_fetch_assoc($ctable_r);

		$name = stripslashes($ctable_d['name']);
		$from_date =  $db->date($ctable_d['from_date'], 'm/d/Y');
		$to_date = stripslashes($ctable_d['to_date']);
		$address1 = stripslashes($ctable_d['address1']);
		$address2 = stripslashes($ctable_d['address2']);
		$city = htmlspecialchars_decode($ctable_d['city']);
		$state = htmlspecialchars_decode($ctable_d['state']);
		$country = htmlspecialchars_decode($ctable_d['country']);
		$zipcode = htmlspecialchars_decode($ctable_d['zipcode']);
		$quote_status = htmlspecialchars_decode($ctable_d['quote_status']);
		$notes = htmlspecialchars_decode($ctable_d['notes']);
		// $quote_status = htmlspecialchars_decode($ctable_d['quote_status']);

		// echo $from_date; die;
	}

	if(isset($_REQUEST['id']) && $_REQUEST['id']>0 && $_REQUEST['mode']=="delete")
	{
		$id = $_REQUEST['id'];
		$rows = array('isDelete' => '1');
		
		$db->update($ctable, $rows, 'id='.$id);
		
		$_SESSION['MSG'] = 'Deleted';
		$db->location(ADMINURL.'manage-'.$page.'/');
		exit;
	}
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
				<div class="main-panel">
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
									<form class="forms-sample" role="form" name="frm" id="frm" action="." method="post" enctype="multipart/form-data">
										<input type="hidden" name="mode" id="mode" value="<?php echo $_REQUEST['mode']; ?>">
										<input type="hidden" name="id" id="id" value="<?php echo $_REQUEST['id']; ?>">
										<div class="card-body">
											<div class="row">
												<div class="col-md-6">
													<div class="form-group">
														<label for="name">Name <code>*</code></label>
														<input maxlength="100" type="text" class="form-control" name="name" id="name" placeholder="Enter Name" value="<?php echo $name; ?>">
													</div>
													<div class="form-group">
														<label for="addres1">Address 1 <code>*</code></label>
														<input maxlength="250" type="text" class="form-control" name="address1" id="address1" placeholder="Enter Address1" value="<?php echo $address1; ?>">
													</div>
													<div class="form-group">
														<label for="addres2">Address 2 <code>*</code></label>
														<input maxlength="250" type="text" class="form-control" name="address2" id="address2" placeholder="Enter Address2" value="<?php echo $address2; ?>">
													</div>
													<div class="form-group">
														<label for="city">City <code>*</code></label>
														<input maxlength="100" type="text" class="form-control" name="city" id="city" placeholder="Enter City" value="<?php echo $city; ?>">
													</div>
													<div class="form-group">
														<label for="country">Country <code>*</code></label>
														<!-- <input maxlength="150" type="text" class="form-control" name="country" id="country" placeholder="Enter Country" value="<?php echo $country; ?>"> -->

														<select class="form-control" required="" aria-required="true" onchange="getState(this.value);" name="country" id="country">
									                        <option value="">Country / Region</option>
									                        <?php 
									                            $country_d = $db->getData("countries","*");
									                            foreach ($country_d as $key => $country_r) {
									                                ?>
									                                <option <?php echo ($country_r['id']==239)?"selected":""; ?> value="<?php echo $country_r['id'] ?>" <?php if($country_r['id'] == $country){ echo "Selected"; } ?>><?php echo $country_r['name']; ?></option>
									                                <?php
									                            }
									                        ?>
									                    </select>
													</div>
													<div class="form-group">
														<label for="state">State <code>*</code></label>
														<!-- <input maxlength="100" type="text" class="form-control" name="state" id="state" placeholder="Enter State" value="<?php echo $state; ?>"> -->

														<select name="state" id="state" class="form-control"></select>
													</div>
													<div class="form-group">
														<label for="zipcode">Zip Code <code>*</code></label>
														<input maxlength="10" type="number" class="form-control" name="zipcode" id="zipcode" placeholder="Enter Zip Code" value="<?php echo $zipcode; ?>">
													</div>
													<!-- <div class="form-group">
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
													</div> -->
												</div>
												<div class="col-md-6">
														<div class="row ml-1">
															<div class="form-group">
																<label for="from_date">From Date <code>*</code></label>
																<!-- <span><?php //echo $from_date; ?></span> -->
																<input  type="date" class="form-control" name="from_date" id="from_date" placeholder="From Date" value="<?php echo $from_date; ?>">
															</div>
															<div class="form-group ml-5">
																<label for="to_date">Expiry Date <code>*</code></label>
																<input type="date" class="form-control" name="to_date" id="to_date" placeholder="To Date" value="<?php echo $to_date; ?>">
															</div>
														</div>
													<div class="form-group">
														<label for="name">Notes<code>*</code></label>
														<textarea class="form-control" name="notes" id="notes"><?php echo $notes; ?></textarea>
													</div>
													<div class="form-group">
														<label for="name">Quotation Status<code>*</code></label>
														<select class="form-control" name="quote_status" id="quote_status">
															<option value="">Select Quotation Status</option>
															<option value="0" <?php if ($quote_status=="0") { echo "selected";} ?>>Cancelled</option>
															<option value="1" <?php if ($quote_status=="1") { echo "selected";} ?>>Sent</option>
															<option value="2" <?php if ($quote_status=="2") { echo "selected";} ?>>Converted</option>
														</select>
													</div>
												</div>
											</div>

											<div class="row">
												<div class="col-sm-12 add-newpro" style="border-top: 1px solid #ccc;border-bottom: 1px solid #ccc;margin: 15px 0px;padding: 15px;">
													<div class="row">
														<div class="col-sm-4">
														  	<div class="form-group">
														    	<label for="pprodesc">Product <span class="required">*</span></label>
														    </div>
														</div>
														<div class="col-sm-2 ">
														  	<div class="form-group">
														    	<label for="pqty">Quantity:<span class="required">*</span></label>
														    </div>
														</div>
														<div class="col-sm-2 ">
														  	<div class="form-group">
														    	<label for="pprice">Price:<span class="required">*</span></label>
														    </div>
														</div>
														<div class="col-sm-2 ">
															<div class="form-group">
															    <!-- <label >&nbsp;</label> -->
															    <button id="btnAdd" type="button" class="btn btn-primary form-control" data-toggle="tooltip" data-original-title="Add more controls">Add</button>
															</div>
														</div>
													</div>

													<div class="filed">
														<input type="hidden" name="deleted_row_ids" id="deleted_row_ids" value="">
														<?php 
														$ctable_c2 = 0;
														$auto_count=1;
														if(isset($_REQUEST['id']) && $_REQUEST['id']>0 && $_REQUEST['mode']=="edit")
														{
															$where2 	= "quote_id='".$_REQUEST['id']."' AND isDelete=0";
															$ctable_r2 	= $db->getData("quote_detail","*",$where2);
															$ctable_c2 	= @mysqli_num_rows($ctable_r2);

															if($ctable_c2 > 0)
															{
																while($ctable_d2 = @mysqli_fetch_array($ctable_r2)) 
																{
																	$addon_id = $ctable_d2['id'];
																	$product_id = $ctable_d2['product_id'];
																	$additional_field_val_ids = $ctable_d2['additional_field_val_ids'];
																	?>

																	<input type="hidden" name="main_row_ids[]" data-id="<?php echo $addon_id ?>" value="<?php echo $addon_id ?>">
																	<div class="row remove_row<?php echo $addon_id ?>">
																		<div class="col-sm-4">
																		  	<div class="form-group">																		    
																		     	<select name="pprodesc[]" id="pprodesc" class="form-control" >
																		       		<option value="">Please Select</option>
																			      	<?php
																				        $order_r = $db->getData("product", "*", "isDelete=0", "id ASC");

																				        if(@count($order_r)>0){
																				          	foreach ($order_r as $order_d) {
																				            	// echo "\t<option value='".$order_d['id']."'>".$order_d['name']."</option>\n\r";

																				            	?>
																				            	<option <?php if($order_d['id']==$product_id){?> selected <?php } ?> value="<?=$order_d['id']?>"><?=$order_d['name'];?></option>
																				            	<?php
																				          	}
																			      			?>

																				       		<?php
																				        }
																				       ?>
																		      	</select>
																		  	</div>
																		</div>
																		<div class="col-sm-2 ">
																		  	<div class="form-group">
																		    	<input type="text" class="form-control" id="pqty" name="pqty[]" value="<?=$ctable_d2['qty']?>" placeholder="">
																		  	</div>
																		</div>
																		<div class="col-sm-2 ">
																		  	<div class="form-group">
																		    	<input type="text" class="form-control" id="pprice" name="pprice[]" value="<?=$ctable_d2['price']?>" placeholder="">
																		  	</div>
																		</div>
																		<div class="col-sm-2 ">
																		  	<div class="form-group">
																				<button data-delete-id="<?php echo $addon_id ?>" type="button" class="btn btn-danger form-control remove remove_button" onclick="remove_row(<?php echo $addon_id ?>);" >Remove</button>

																		  	</div>
																		</div>
																	</div>
																	<?php
																	$auto_count++;
																}
															}
														}
														else
														{

														}

														?>
										              	<div id="ProductContainer"></div>
										            </div>
									          	</div>
								          	</div>

										</div>
										<div class="card-footer">
											<button type="submit" name="submit" id="submit" title="Submit" class="btn btn-gradient-success btn-icon-text"><i class="mdi mdi-content-save-all"></i> </button>
											<button type="button" title="Back" class="btn btn-gradient-light btn-icon-text" onClick="window.location.href='<?php echo ADMINURL; ?>manage-<?php echo $page; ?>/'"><i class="mdi mdi-step-backward"></i> </button>
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
		<?php include('include/js.php'); ?>
		<script type="text/javascript">

			$(function(){
				$("#frm").validate({
					ignore: "",
					rules: {
						name:{required:true}, 
						address1:{required: true},
						address2:{required: true},
						city:{required: true},
						state:{required: true},
						country:{required: true},
						zipcode:{required: true},
						from_date:{required:true},
						to_date:{required:true},
						notes:{required:true},
						quote_status:{required:true},
						// shipping_method:{required:true},
					},
					messages: {
						name:{required:"Please enter first name."},
						address1:{required: "Please enter address1."},
						address2:{required: "Please enter address2."},
						city:{required: "Please enter city."},
						state:{required: "Please enter state."},
						country:{required: "Please enter country."},
						zipcode:{required: "Please enter zipcode."},
						from_date:{required:"Please enter from date."},
						to_date:{required:"Please enter to date."},
						notes:{required:"Please enter notes."},
						quote_status:{required:"Please select status."},
						// shipping_method:{required:"Please select shipping method."},
					},
					errorPlacement: function(error, element) {
						error.insertAfter(element);
					}
				});
			});

		</script>
		<script type="text/javascript">
			$(function () {
				$("#btnAdd").bind("click", function () {
					// alert("====");
				  	var div = $("<div>");
				  	div.html(GetDynamicTextBox(""));
				  	$("#ProductContainer").append(div);
				});
				$("body").on("click", ".remove", function () {
				  	$(this).closest(".add-newpro").remove();
				});
			});

			function GetDynamicTextBox(value) {

				var inc_id = Math.floor((Math.random() * 100) + 1);
				html = '<div class="row add-newpro"><div class="col-sm-4 pro-add"><div class="form-group"><select name="pprodesc[]" id="pprodesc'+inc_id+'" class="form-control pprodesc" ><option value="">Please Select</option>';
				  <?php
				    $order_r = $db->getData("product", "*", "isDelete=0", "id ASC");

				    if(@count($order_r)>0){
				      foreach ($order_r as $order_d) {
				        echo "html = html + '<option value=\"".$order_d['id']."\">".$order_d['name']."</option>';";
				        $inc_id++;
				      }
				    }
				   ?>
				  // html = html + '';

				html = html + '</select></div></div><div class="col-sm-2 pro-add"><div class="form-group"><input type="text" class="form-control" id="" name="pqty[]" placeholder=""></div></div><div class="col-sm-2 "><div class="form-group"><input type="text" class="form-control" id="pprice" name="pprice[]" placeholder=""></div></div><div class="col-sm-2 "> <div class="form-group"><button type="button" class="btn btn-danger form-control remove">Remove</button></div></div></div>';

				return html;
			}

			function remove_row(rowid)
			{
				$.ajax({
                    url:"<?php echo ADMINURL; ?>ajax_get_removerows.php",
                    type:"POST",
                    data: "rowid="+rowid,

                    beforeSend  : function() 
                    {
                        $(".loader").hide();  
                    },
                    success: function(res){
                        // $("#PaymentCard_Step3").show();
                        // $("#BillingAddress_Step-2").hide();
                        // $("#step-3").addClass("active");
                        // $("#step-2").removeClass("active");
                        // alert(res);
                        // location.reload();
                        window.location.reload();
                    }
                });
			}

			function getState(country_id)
            {
                $.ajax({
                    type: "POST",
                    url: "<?php echo ADMINURL; ?>ajax_quotestate.php",
                    data: 'country_id='+country_id,
                    success: function(options)
                    {
                        $("#state").html(options);
                    }
                });
            }
			
		</script>
		<script type="text/javascript">
			$(document).ready(function(){

                getState('239');
                
            });

            function rpAddShippingCharge(s){
                var zip = $("#zipcode").val();
                var country = $("#country").val();
                var quote_id = <?php echo $_REQUEST['id']; ?>;

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
		</script>
	</body>
</html>