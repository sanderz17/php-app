<?php
include("connect.php");
$ctable = "cart";
$ctable1 = "Order";
$page = "order";

//for sidebar active menu
$ctable_where = '';
if (isset($_REQUEST['searchName']) && $_REQUEST['searchName'] != "") {
	$ctable_where .= " (
					order_no like '%" . $_REQUEST['searchName'] . "%' OR
					order_date like '%" . $_REQUEST['searchName'] . "%' OR
					grand_total like '%" . $_REQUEST['searchName'] . "%'
		) AND ";
}

$ctable_where .= "cart.is_quote=1 AND cart.isDelete=0";
$item_per_page =  ($_REQUEST["show"] <> "" && is_numeric($_REQUEST["show"])) ? intval($_REQUEST["show"]) : 10;

if (isset($_REQUEST["page"]) && $_REQUEST["page"] != "") {
	$page_number = filter_var($_REQUEST["page"], FILTER_SANITIZE_NUMBER_INT, FILTER_FLAG_STRIP_HIGH); //filter number
	if (!is_numeric($page_number)) {
		die('Invalid page number!');
	} //incase of invalid page number
} else {
	$page_number = 1; //if there's no page number, set it to 1
}
cb_logger("where=$ctable_where");
$get_total_rows = $db->getTotalRecord($ctable, $ctable_where, 'order_no desc'); //hold total records in variable

//break records into pages
$total_pages = ceil($get_total_rows / $item_per_page);

//get starting position to fetch the records
$page_position = (($page_number - 1) * $item_per_page);
$pagiArr = array($item_per_page, $page_number, $get_total_rows, $total_pages);
$ctable_r = $db->getJoinData($ctable, 'user', 'user.id=' . $ctable . '.customer_id', $ctable . '.*, user.first_name,user.last_name', $ctable_where, "order_no DESC LIMIT $page_position, $item_per_page");
//$ctable_r = $db->getJoinData($ctable, 'employee', 'employee.id='.$ctable.'.employee_id', '*', $ctable_where, $ctable.".id DESC LIMIT $page_position, $item_per_page");
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
				<th>Order #</th>
				<th>User</th>
				<th>Amount</th>
				<th>Date</th>
				<th>Action</th>
			</tr>
		</thead>
		<tbody>
			<?php
			if (@count($ctable_r) > 0) {
				$count = 0;
				//while($ctable_d = @mysqli_fetch_assoc($ctable_r)){
				foreach ($ctable_r as $ctable_d) {
					$count++;
			?>
					<tr>
						<td><input type="checkbox" name="chkid[]" value="<?php echo $ctable_d['id']; ?>"></td>
						<td><?php echo $count + $page_position; ?></td>
						<td><?php echo $ctable_d['order_no']; ?></td>
						<td><?php echo $user_guest; ?></td>
						<td class="text-right"><?php echo CUR . $db->num($db->num($ctable_d['discount']) + ($db->num($ctable_d['shipping']) + $db->num($ctable_d['sub_total'])), 2); ?></td>
						<td><?php echo (!is_null($ctable_d['order_date'])) ? $db->date($ctable_d['order_date'], 'm/d/Y') : $db->date($ctable_d['adate'], 'm/d/Y'); ?></td>
						<td>
							<a style="color: #36b9cc;" href="<?php echo ADMINURL; ?>view-<?php echo $page; ?>/<?php echo $ctable_d['id']; ?>/" title="View"><i class="mdi mdi-eye"></i></a>
							<a style="color: #e74a3b;" onClick="del_conf('<?php echo $ctable_d['id']; ?>');" title="Delete"><i class="mdi mdi-delete"></i></a>
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