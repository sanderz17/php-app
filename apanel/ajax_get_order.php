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

$ctable_where .= "cart.payment_method IS NOT NULL AND cart.isDelete=0 AND cart.order_status<>1";
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
	//$db->getAddButton($page, $ctable1);
	?>
	<table id="example" class="table table-striped table-colored">
		<thead style="background-color: #6c7ae0;color: white;">
			<tr>
				<th><input type="checkbox" name="chkall" id="chkall" onclick="javascript:check_all();"></th>
				<th>No.</th>
				<th>Tracking #</th>
				<th>Order #</th>
				<th>User</th>
				<th>Payment method</th>
				<th>Amount</th>
				<th>Status</th>
				<th>Date</th>
				<th>Action</th>
			</tr>
		</thead>
		<tbody>
			<?php
			$shipStations = new Cart();
			if (@mysqli_num_rows($ctable_r) > 0) {
				$count = 0;
				while ($ctable_d = @mysqli_fetch_assoc($ctable_r)) {
					//$shipstation_tracking_number = $shipStations->getOrderTrackingFromShipStation($ctable_d['order_no']) ?: '';
					$shipstation_tracking_number =  '';
					$shipping_first_name = $db->getValue('billing_shipping', 'shipping_first_name', "cart_id=" . $ctable_d['id']) ?? "";
					$shipping_last_name = $db->getValue('billing_shipping', 'shipping_last_name', "cart_id=" . $ctable_d['id']) ?? "";
					$shipping_email = $db->getValue('billing_shipping', 'shipping_email', "cart_id=" . $ctable_d['id']) ?? "";
					$user_guest = $ctable_d['first_name'] == '' && $ctable_d['last_name'] == '' ? 'GUEST' . "/$shipping_first_name $shipping_last_name" . "/$shipping_email" : $ctable_d['first_name'] . ' ' . $ctable_d['last_name'];
					$count++;
			?>
					<tr>
						<td><input type="checkbox" name="chkid[]" value="<?php echo $ctable_d['id']; ?>"></td>
						<td><?php echo $count + $page_position; ?></td>
						<td><a href="https://www.ups.com/track?HTMLVersion=5.0&Requester=NES&AgreeToTermsAndConditions=yes&loc=en_US&tracknum=<?php echo $shipstation_tracking_number ?>/trackdetails"><?php echo $shipstation_tracking_number; ?></a></td>
						<td><?php echo $ctable_d['order_no']; ?></td>
						<td><?php echo $user_guest; ?></td>
						<td><?php echo $ctable_d['payment_method']; ?></td>
						<td class="text-right"><?php echo CUR . $db->num($db->num($ctable_d['discount']) + ($db->num($ctable_d['shipping']) + $db->num($ctable_d['sub_total'])), 2); ?></td>
						<td><?php

								try {
									$shipstation_status = $ctable_d['order_status'];
									switch ($shipstation_status) {
										case 'awaiting_payment':
											$ctable_d['order_status'] = '5';
											break;
										case 'awaiting_shipment':
											$ctable_d['order_status'] = '2';
											break;
										case 'shipped':
											$ctable_d['order_status'] = '3';
											break;
										case 'cancelled':
											$ctable_d['order_status'] = '0';
											break;
										default:
											$ctable_d['order_status'] = '1';
											break;
									}
									cb_logger("shipstation_status=$shipstation_status");
								} catch (\Throwable $th) {
									cb_logger($th);
								}


								switch ($ctable_d['order_status']) {
									case 0:
										echo '<span class="badge badge-pill badge-danger">Cancelled</span>';
										break;
									case 1:
										echo '<span class="badge badge-pill badge-success text-dark">In Progress</span>';
										break;
									case 2:
										echo '<span class="badge badge-pill badge-primary">Awaiting Shipment</span>';
										break;
									case 3:
										echo '<span class="badge badge-pill badge-info">Shipped</span>';
										break;
									case 4:
										echo '<span class="badge badge-pill badge-dark">Delivered</span>';
										break;
									case 5:
										echo '<span class="badge badge-pill badge-secondary">Pending Payment</span>';
										break;
									default:
										break;
								}
								?>
						</td>
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
	//$db->getAddButton($page, $ctable1);
	$db->getTablePaginationBlock($pagiArr);
	?>
</form>