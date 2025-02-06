<?php
// include "connect.php";
include("connect.php");

// echo "<pre>";
// print_r($_REQUEST);
// die;

$country_id = $_REQUEST['country_id'];
$shipping_state = $_REQUEST['shipping_state'];

$state_d = $db->getData("states_ex", "*", "country_id=" . $country_id, "name");
?>
<option value="">Select a State</option>
<?php
foreach ($state_d as $state_r) {
?>
	<option <?php if ($state_r['id'] == $shipping_state) {
				echo "selected";
			}
			?> value="<?php echo $state_r['id']; ?>"><?php echo $state_r['name']; ?>
	</option>
<?php
}
?>