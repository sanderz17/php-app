<?php
	// include "connect.php";
	include("connect.php");

	$country_id = $_REQUEST['country_id'];

	$state_d = $db->getData("states_ex", "*", "country_id=".$country_id,"",0);

	foreach ($state_d as $state_r) {
		?>
		<option value="<?php echo $state_r['id']; ?>"><?php echo $state_r['name']; ?></option>
		<?php
	}
?>