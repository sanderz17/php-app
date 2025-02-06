<?php
include("connect.php");
$ctable = "cart";
// $ctable1 = "Order";
// $page = "order";

//for sidebar active menu
$ctable_where = '';
if (isset($_REQUEST['searchName']) && $_REQUEST['searchName'] != "") {
	$ctable_where .= " (
					name like '%" . $_REQUEST['searchName'] . "%' OR
					order_no like '%" . $_REQUEST['searchName'] . "%' OR
					order_date like '%" . $_REQUEST['searchName'] . "%' OR
					grand_total like '%" . $_REQUEST['searchName'] . "%'
		) AND ";
}

if (isset($_REQUEST['startdate']) && $_REQUEST['startdate'] != "" && $_REQUEST['enddate'] && $_REQUEST['enddate'] != "") {
	// die('111');
	$ctable_where .= " ( date(order_date) BETWEEN '" . $_REQUEST['startdate'] . "' AND '" . $_REQUEST['enddate'] . "'
		) AND ";
}

$ctable_where .= "cart.isDelete=0 AND cart.order_status=2 AND cart.payment_method IS NOT NULL";
$item_per_page =  ($_REQUEST["show"] <> "" && is_numeric($_REQUEST["show"])) ? intval($_REQUEST["show"]) : 10;

if (isset($_REQUEST["page"]) && $_REQUEST["page"] != "") {
	$page_number = filter_var($_REQUEST["page"], FILTER_SANITIZE_NUMBER_INT, FILTER_FLAG_STRIP_HIGH); //filter number
	if (!is_numeric($page_number)) {
		die('Invalid page number!');
	} //incase of invalid page number
} else {
	$page_number = 1; //if there's no page number, set it to 1
}

$get_total_rows = $db->getTotalRecord($ctable, $ctable_where, 0); //hold total records in variable

//break records into pages
$total_pages = ceil($get_total_rows / $item_per_page);

//get starting position to fetch the records
$page_position = (($page_number - 1) * $item_per_page);
$pagiArr = array($item_per_page, $page_number, $get_total_rows, $total_pages);
$ctable_r = $db->getJoinData($ctable, 'user', 'user.id=' . $ctable . '.customer_id', $ctable . '.*, user.first_name,user.last_name', $ctable_where, $ctable . ".id DESC LIMIT $page_position, $item_per_page", 0);
//$ctable_r = $db->getJoinData($ctable, 'employee', 'employee.id='.$ctable.'.employee_id', '*', $ctable_where, $ctable.".id DESC LIMIT $page_position, $item_per_page");
$shipping_charges = $db->getValue("cart", "SUM(shipping)", $ctable_where, 0);
$sub_total = $db->getValue("cart", "SUM(sub_total)", $ctable_where, 0);
$grand_total = $db->getValue("cart", "SUM(grand_total)", $ctable_where, 0);



// xml report generat
// $xml = new DOMDocument("1.0");
// $xml->formatOutput=true;
// $fitness=$xml->createElement("users");
// $xml->appendChild($fitness);
?>

<div class="container mb-3">
	<!-- <div class="row"> -->
	<div class="">
		<span><strong>Shipping Charges: </strong><?php echo number_format($shipping_charges, 2); ?></span>
	</div>
	<div class="">
		<span><strong>Sub Total: </strong><?php echo number_format($sub_total, 2); ?></span>
	</div>
	<div class="">
		<span><strong>Grand Total: </strong><?php echo number_format($grand_total, 2); ?></span>
	</div>
	<!-- </div> -->
</div>
<form action="" name="frm" id="frm" method="post">
	<input type="hidden" name="hdnmode" id="hdnmode" value="">
	<input type="hidden" name="hdndb" id="hdndb" value="<?php echo $ctable; ?>">
	<?php
	// $db->getDeleteButton();
	//$db->getAddButton($page, $ctable1);
	?>
	<table id="example" class="table table-striped table-bordered table-colored">
		<thead>
			<tr>
				<th>No.</th>
				<th>Order #</th>
				<th>User</th>
				<th>Shipping Price</th>
				<th>Sub Total</th>
				<th>Grand Total</th>
				<th>Date</th>
			</tr>
		</thead>
		<tbody>
			<?php
			if (@mysqli_num_rows($ctable_r) > 0) {
				$count = 0;
				while ($ctable_d = @mysqli_fetch_assoc($ctable_r)) {
					$count++;
			?>
					<tr>
						<td><?php echo $count + $page_position; ?></td>
						<td><?php echo $ctable_d['order_no']; ?></td>
						<td><?php echo $ctable_d['first_name'] . ' ' . $ctable_d['last_name']; ?></td>
						<td><?php echo $ctable_d['shipping']; ?></td>
						<td><?php echo $ctable_d['sub_total']; ?></td>
						<td class="text-right"><?php echo CUR . $db->num($ctable_d['grand_total']); ?></td>
						<td><?php echo (!is_null($ctable_d['order_date'])) ? $db->date($ctable_d['order_date'], 'm/d/Y') : $db->date($ctable_d['adate'], 'm/d/Y'); ?></td>
					</tr>
			<?php

					// $no=$xml->createElement("No", $count+$page_position);
					// 			$user->appendChild($no);

					// 			$order_no=$xml->createElement("Order No", $ctable_d['order_no']);
					// 			$user->appendChild($order_no);

					// 			$customer_name=$xml->createElement("Order No", $ctable_d['first_name'].' '.$ctable_d['last_name']);
					// 			$user->appendChild($customer_name);

					// 			$shipping=$xml->createElement("Shipping", $ctable_d['shipping']);
					// 			$user->appendChild($shipping);

					// 			$sub_total=$xml->createElement("Order No", $ctable_d['sub_total']);
					// 			$user->appendChild($sub_total);
				}
			}
			?>
		</tbody>
	</table>
	<?php
	// echo "<xmp>".$xml->saveXML()."</xmp>";
	// $xml->save("report.xml");
	// $db->getDeleteButton();
	//$db->getAddButton($page, $ctable1);
	$db->getTablePaginationBlock($pagiArr);
	?>
</form>