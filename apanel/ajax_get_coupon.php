<?php
	include("connect.php");

	$ctable 	= 'coupon';
	$ctable1 	= 'Coupon';
	$main_page 	= 'Coupon'; //for sidebar active menu
	$page		= 'coupon';

	//for sidebar active menu
	$ctable_where = '';
	if(isset($_REQUEST['searchName']) && $_REQUEST['searchName']!=""){
		$ctable_where .= " (
			name like '%".$_REQUEST['searchName']."%' OR 
			code like '%".$_REQUEST['searchName']."%' OR 
			days like '%".$_REQUEST['searchName']."%' OR 
			start_date like '%".$_REQUEST['searchName']."%' OR 
			expiration_date like '%".$_REQUEST['searchName']."%'
		) AND ";
	}

	$ctable_where .= "isDelete=0";
	$item_per_page =  ($_REQUEST["show"] <> "" && is_numeric($_REQUEST["show"]) ) ? intval($_REQUEST["show"]) : 10;

	if(isset($_REQUEST["page"]) && $_REQUEST["page"]!=""){
		$page_number = filter_var($_REQUEST["page"], FILTER_SANITIZE_NUMBER_INT, FILTER_FLAG_STRIP_HIGH); //filter number
		if(!is_numeric($page_number)){die('Invalid page number!');} //incase of invalid page number
	}else{
		$page_number = 1; //if there's no page number, set it to 1
	}

	$get_total_rows = $db->getTotalRecord($ctable,$ctable_where); //hold total records in variable

	//break records into pages
	$total_pages   = ceil($get_total_rows/$item_per_page);

	//get starting position to fetch the records
	$page_position = (($page_number-1) * $item_per_page);
	$pagiArr       = array($item_per_page, $page_number, $get_total_rows, $total_pages);
	$ctable_r      = $db->getData($ctable,"*",$ctable_where,"id DESC limit $page_position, $item_per_page");
?>
<form action="" name="frm" id="frm" method="post">
    <input type="hidden" name="hdnmode" id="hdnmode" value="">
    <input type="hidden" name="hdndb" id="hdndb" value="<?php echo $ctable; ?>">
		<?php
			$db->getDeleteButton();
			$db->getAddButton($page, $ctable1);
		?>
		<table id="example" class="table table-striped table-bordered table-colored mb-3">
			<thead>
				<tr>
					<th><input type="checkbox" name="chkall" id="chkall" onclick="javascript:check_all();"></th>
	                <th>No.</th>
	                <th>Name</th>
	                <th>Code</th>
	                <th>Type</th>
	                <th>Amount</th>
	                <th>Min Spend Amt.</th>
	                <th>Start Date</th>
	                <th>Expiration</th>
	                <th>Action</th>
				</tr>
			</thead>
			<tbody>
				<?php
				if(@mysqli_num_rows($ctable_r)>0){
					$count = 0;
					while($ctable_d = @mysqli_fetch_assoc($ctable_r)){
						$count++;
			            
			            if($ctable_d['type']=='percent')
			                $dis_amount = stripslashes($ctable_d['amount'])."%";
			            else
			                $dis_amount = CURR.stripslashes($ctable_d['amount']);
					?>
					<tr>
						<td><input type="checkbox" name="chkid[]" value="<?php echo $ctable_d['id']; ?>"></td>
						<td><?php echo $count+$page_position; ?></td>
		                <td><?php echo stripslashes($ctable_d['name']); ?></td>
		                <td><?php echo stripslashes($ctable_d['code']); ?></td>
		                <td><?php echo stripslashes($ctable_d['type']); ?></td>
		                <td><?php echo $dis_amount; ?></td>
		                <td><?php echo CURR.stripslashes($ctable_d['min_spend_amount']); ?></td>
						<td><?php echo $db->Date($ctable_d['start_date'], "M d, Y"); ?></td>
						<td><?php echo $db->Date($ctable_d['expiration_date'], "M d, Y"); ?></td>
						<td>
	                		<a href="<?php echo ADMINURL; ?>add-<?php echo $page; ?>/edit/<?php echo $ctable_d['id']; ?>/" title="Edit" class="btn-gradient-dark p-1"><i class="mdi mdi-lead-pencil"></i></a>
                    		<a onClick="del_conf('<?php echo $ctable_d['id']; ?>');" title="Delete" class="btn-gradient-danger p-1" style="color: #fff;"><i class="mdi mdi-delete"></i></a>
    					</td>
					</tr>
					<?php
					}
				}
				?>
			</tbody>
		</table>
		<input type="hidden" name="disp_count" value="<?php echo $count; ?>">
		<input type="hidden" name="submit" value="submit">
		<?php 
			$db->getDeleteButton();
			$db->getAddButton($page, $ctable1);
			$db->getTablePaginationBlock($pagiArr);			
		?>
		<br />
</form>