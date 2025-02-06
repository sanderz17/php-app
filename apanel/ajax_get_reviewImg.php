<?php
	include("connect.php");

	$ctable 	= 'review_img';
	$ctable1 	= 'Review image';
	$main_page 	= 'Review image'; //for sidebar active menu
	$page		= 'reviewImg';

	//for sidebar active menu
	$ctable_where = '';
	if(isset($_REQUEST['searchName']) && $_REQUEST['searchName']!=""){
		$ctable_where .= " (
			first_name like '%".$_REQUEST['searchName']."%' OR 
			last_name like '%".$_REQUEST['searchName']."%' OR 
			email like '%".$_REQUEST['searchName']."%' OR 
			phone like '%".$_REQUEST['searchName']."%'
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

	$get_total_rows = $db->getTotalRecord($ctable, $ctable_where); //hold total records in variable

	//break records into pages
	$total_pages   = ceil($get_total_rows/$item_per_page);

	//get starting position to fetch the records
	$page_position = (($page_number-1) * $item_per_page);
	$pagiArr       = array($item_per_page, $page_number, $get_total_rows, $total_pages);
	$ctable_r = $db->getData($ctable, "*", $ctable_where, "id DESC limit $page_position, $item_per_page");

	// $ctable_r      = $db->getData($ctable, "*", $ctable_where, "id DESC limit $page_position, $item_per_page");
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
					<th>Title</th>
					<!-- <th>Verified?</th> -->
					<th>Action</th>
				</tr>
			</thead>
			<tbody>
				<?php
				if(@count($ctable_r)>0){
					$count = 0;
					//while($ctable_d = @mysqli_fetch_assoc($ctable_r)){
					foreach ($ctable_r as $ctable_d) {
						$count++;
					?>
					<tr>
						<td><input type="checkbox" name="chkid[]" value="<?php echo $ctable_d['id']; ?>"></td>
						<td><?php echo $count+$page_position; ?></td>
						<td><?php echo $ctable_d['name'] ; ?></td>
						<td><?php echo $ctable_d['title']; ?></td>
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
		<?php 
			$db->getDeleteButton();
			$db->getAddButton($page, $ctable1);
			$db->getTablePaginationBlock($pagiArr);			
		?>
		<br />
</form>