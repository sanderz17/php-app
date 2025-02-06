<?php
	include("connect.php");
	$db->checkAdminLogin();

	$ctable 	= "product_accessories";
	$ctable1 	= "compatible accessories";
	$page 		= "product";
	$main_page 	= "product";
	$page_title = $ctable1;

	$product_id = 0;
    if( isset($_REQUEST['mode']) && $_REQUEST['mode'] == 'delete' )
	{
       // print_r($_REQUEST);
     //   print_r($_REQUEST['mode']);
       // echo "hy";
        //exit;
        
		$id = $_REQUEST['product_id'];
		$rows = array('isDelete' => '1');
		
		$db->update($ctable, $rows, 'id='.$id);
		
		$_SESSION['MSG'] = 'Deleted';
		// $db->location(ADMINURL.'manage-'.$page.'/');
		// exit;
	}
    if(isset($_REQUEST['submit']))
	{
        // print_r($_REQUEST);
        $db->delete($ctable, 'product_id='.$_REQUEST['MainProductId']);
        //$rows12 	= array("isDelete" => "1");

        // print_r($_REQUEST['product_id']);
        // exit;
        foreach ($_REQUEST['product_id'] as $pId) 
        {
        
            $rows1 	= array(
                'product_id'    => $_REQUEST['MainProductId'],
                'isDelete'  	=> 0,
                'related_pid'   =>$pId
            );
             $db->insert($ctable, $rows1 );
        }
        $_SESSION['MSG'] = 'Inserted';
        $db->location(ADMINURL.'manage-'.$page.'/');
             exit;
    }
    $sel_cate ="SELECT * from product_accessories WHERE product_id=".$_REQUEST['product_id']." AND isDelete=0";

	$query_sel_cate = mysqli_query($GLOBALS['myconn'],$sel_cate);
	$List = array();
	if(@mysqli_num_rows($query_sel_cate)>0){
		while($row_sel_cate = @mysqli_fetch_array($query_sel_cate)){
			 array_push($List, $row_sel_cate['related_pid']);
		}
	}
    // print_r($List);
    // exit;
    function category($product_id = 0, $sub_mark = '')
	{
     //   global $List;
	    $sql = "SELECT * from product WHERE isDelete=0";
	    $query = mysqli_query($GLOBALS['myconn'],$sql);

	    
	    if(@mysqli_num_rows($query)>0){
	        while($row = @mysqli_fetch_array($query)){
	            echo '<option  value="'.$row['id'].'">'.$row['name'].'</option>';

    //             echo '<option value="'.$row['id'].'" ';
				// if (in_array($row['id'],$List))
				// 	echo 'selected="selected"';
				// echo '>'.$row['name'].'</option>';
	         
	        }
	    }
	}

    
    if(isset($_REQUEST['id']) && $_REQUEST['id']>0 && $_REQUEST['mode']=="delete")
    {
        $id = $_REQUEST['id'];
        $rows = array("isDelete" => "1");
        
        $_SESSION['MSG'] = 'Deleted';
        $db->rpupdate('rsvp_questions_options', $rows, "id=".$id);
        exit;
    }
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <title>
        <?php echo $page_title . ' | ' . ADMINTITLE; ?>
    </title>
    <?php include('include/css.php'); ?>
    <link rel="stylesheet" href="<?php echo ADMINURL; ?>include/compatible-acc.css">
</head>

<body>

    <div class="container-scroller">
    <div class="container-scroller">

        <?php include("include/header.php"); ?>

        <div class="container-fluid page-body-wrapper">
            <?php include('include/left.php'); ?>

            <div class="main-panel">
                <div class="content-wrapper">
                    <div class="page-header">
                        <h3 class="page-title">
                            <span class="page-title-icon bg-gradient-dark text-white mr-2">
                                <i class="mdi mdi-contacts"></i>
                            </span>
                            <?php echo $page_title; ?>
                        </h3>
                    </div>
                    <div class="row">
                        <div class="col-md-12 ">
                            <div class="box border-top-info">
                                <form class="forms-sample" role="form" action="." method="post">
                                    <div class="card">
                                        <div class="card-body">
                                            <div class="field_wrapper">
                                                
                                                <div class="row align-items-center">
													<div class="col-md-6">
														<input type="hidden" name="MainProductId" value="<?php echo $_REQUEST['product_id']; ?>">
														<div class="form-group">
															<label>
																Select Product 
																<span class="text-danger">*</span>
															</label>
															<select class="form-control" name="product_id[]"
																	id="product_id" onChange="getSubCat(this.value);">
																	<option value="0">-- Select --</option>
																	<?php category(); ?>
															</select>
															
														</div>
													</div>
													<div class="col-md-6">
														<a href="javascript:void(0);" class="add_button"
														title="Add field"><i
															class="mdi mdi-library-plus"></i></a>
													</div>
                                                </div>
												
												<?php
												$count = 0;
												$rs = $db->getData($ctable , '*', 'product_id="'.$_REQUEST['product_id'].'" AND isDelete=0');
												while( $row = @mysqli_fetch_assoc($rs) )
												{
													$count++;
													?>
													<div id="row_<?php echo $count; ?>" class="row append-data-list align-items-center">
														<div class="col-md-6">
															<select class="form-control" name="product_id[]" id="product_id<?php echo $count; ?>">
																<?php
																	$prod_rs = $db->getData("product" , '*', 'isDelete=0');
																	while( $prod_row = @mysqli_fetch_assoc($prod_rs) )
																	{
																	?>
																<option <?php if($row['related_pid'] == $prod_row['id']){ echo "Selected"; } ?> value="<?php echo $prod_row['id']; ?>" ><?php echo $prod_row['name']; ?></option>

																<?php } ?>
															</select>
														</div>
														<div class="col-md-6">
															<a href="javascript:void(0);" onclick="remove_block(<?php echo $row['id']; ?>, <?php echo $count; ?>);"class="remove_button">
																<i class="mdi mdi-delete"></i>
															</a>
														</div>
													</div>
													<?php
												} ?>
												<input type="hidden" name="hdncount" id="hdncount" value="<?php echo $count; ?>">
											</div>
										</div>
                                        <div class="card-footer">
                                            <button type="submit" name="submit" id="submit" title="Submit"
                                                class="btn btn-gradient-success btn-icon-text"><i
                                                    class="mdi mdi-content-save-all"></i> </button>
                                            <button type="button" title="Back"
                                                class="btn btn-gradient-light btn-icon-text"
                                                onClick="window.location.href='<?php echo ADMINURL; ?>manage-<?php echo $page; ?>/'"><i
                                                    class="mdi mdi-step-backward"></i> </button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>

                <?php include("include/footer.php"); ?>
            </div>

        </div>

    </div>
    <?php include('include/js.php'); ?>
</body>
<script type="text/javascript">
    $(document).ready(function () {
        // var maxField = 1000; //Input fields increment limitation
        // var addButton = $('.add_button'); //Add button selector
        // var wrapper = $('.field_wrapper'); //Input field wrapper
        // var fieldHTML = '<div class="row append-data-list align-items-center"><div class="col-md-6"><select class="form-control" name="product_id[]" id="product_id" onChange="getSubCat(this.value);"><option value="0">-- Select --</option><?php category(); ?></select></div><div class="col-md-6"><a href="javascript:void(0);" class="remove_button"><i class="mdi mdi-delete"></i></a></div></div>';

        // var x = 1;

        // //Once add button is clicked
        // $(addButton).click(function () {
        //     //Check maximum number of input fields
        //     if (x < maxField) {
        //         x++; //Increment field counter
        //         $(wrapper).append(fieldHTML); //Add field html
        //     }
        // });

        $('.add_button').click(function(){  
            i = $("#hdncount").val();
            i++;  
            $('.field_wrapper').append('<div id="row_'+i+'" class="row append-data-list align-items-center"><div class="col-md-6"><select class="form-control" name="product_id[]" id="product_id'+i+'" onChange="getSubCat(this.value);"><option value="0">-- Select --</option><?php category(); ?></select></div><div class="col-md-6"><a href="javascript:void(0);" onclick="remove_block(0,2);"  class="remove_button"><i class="mdi mdi-delete"></i></a></div></div> ');  
        });

        //Once remove button is clicked
        // $(wrapper).on('click', '.remove_button', function (e) {
        //     e.preventDefault();
        //     $(this).parent('div').parent('div').remove(); //Remove field html
        //     x--; //Decrement field counter
        // });

        
    });

    function remove_block(id, ctrlid){
		if( confirm('Are you sure you want to delete the record?') )
		{
			$.ajax({
				type: "POST",
				url: "<?php echo ADMINURL; ?>compatible-accessories/delete/"+id,
				//data: 'mode=delete&id='+id,
				success: function(res) {
					$("#row_"+ctrlid).remove();
					$.notify({message: "Record deleted successfully."}, {type: "success"});
				}
			}); 
		}
	}
</script>

</html>