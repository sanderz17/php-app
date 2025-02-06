<?php
	$dashboard_main_array = array(
		0 => array("dark", $db->getTotalRecord("user", "isActive=1 AND isDelete=0"), "User(s)", "manage-user", "mdi mdi-account"),		
		1 => array("dark", $db->getTotalRecord("product", "isDelete=0"), "Product(s)", "manage-package", "mdi-package"),		
		2 => array("dark", $db->getTotalRecord("cart", "cart.payment_method IS NOT NULL AND cart.isDelete=0 AND cart.order_status<>1"), "Orders(s)", "manage-testimonial", "mdi-format-quote-open"),
	);
?>