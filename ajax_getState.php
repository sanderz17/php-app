<?php
	// include "connect.php";
	include("connect.php");
	$shipping_state_id = $_REQUEST['shipping_state'];

	$state_d = $db->getData("states_ex", "*", "country_id=".$country_id,"name");

	foreach ($state_d as $state_r) {
		?>
		<option <?php if($state_r['id']==$shipping_state){echo "selected"; } ?> value="<?php echo $state_r['id']; ?>"><?php echo $state_r['name']; ?></option>
		<?php
	}
?>