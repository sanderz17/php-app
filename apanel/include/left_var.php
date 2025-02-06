<?php
	// "$page" variable in the page should match with second element of the array		
	$left_pages_array0 = array(
		"0"=>array("User", "user", "manage-user/"),
		// "1"=>array("User Plans", "user_plan", "manage-user-plan/"),
	);

	$left_pages_array1 = array(
		"0"=>array("Static Page", "static_page", "manage-static-page/"),
	);

	$left_pages_array2 = array(
		"0"=>array("Manage Category", "manage-category", "manage-category/"),
		"1"=>array("Manage Product", "manage-product", "manage-product/"),
	);

	$left_pages_array3 = array(
		"0"=>array("FAQ", "faq", "manage-faq/"),
	);

	$left_pages_array4 = array(
		"0"=>array("Order", "order", "manage-order/"),
	);

	$left_pages_array5 = array(
		// "0"=>array("Category", "blog", "manage-blog-category/"),
		"1"=>array("Blog", "blog", "manage-blog/"),
	);

	$left_pages_array6 = array(
		// "0"=>array("Testimonial", "testimonial", "manage-testimonial/"),
		"1"=>array("Clients", "clients", "manage-client/"),
		"2"=>array("Review images", "medication", "manage-reviewImg/"),
		// "3"=>array("Contact", "contact", "manage-contact/"),
		"4"=>array("Manage Explore", "explore category", "manage-explore-category/"),
		//"5"=>array("Coupons", "coupon", "manage-coupon/"),
		"6"=>array("Video Library", "video library", "manage-video/"),
		// "7"=>array("Accessories Image", "accessories image", "manage-accessories/"),
	);

	$left_pages_array7 = array(
		// "0"=>array("Category", "blog", "manage-blog-category/"),
		"1"=>array("Quotations", "quotations", "manage-quotations/"),
	);

	$left_pages_array8 = array(
		// "0"=>array("Category", "blog", "manage-blog-category/"),
		"1"=>array("Order Report", "order_report", "manage-order-report/"),
	);
	$left_pages_array9 = array(
		// "0"=>array("Category", "blog", "manage-blog-category/"),
		"1"=>array("Promo", "promo", "manage-coupon/"),
	);
	$left_pages_array10 = array(
		// "0"=>array("Category", "blog", "manage-blog-category/"),
		"1"=>array("Subscribers", "subscribers", "manage-subscribers/"),
	);

	// "$main_page" variable in the page should match with second element of the array
	$left_head_array = array(
		0	=>array("User", "User", $left_pages_array0, "mdi-account"),
		1	=>array("Static Page", "Static Page", $left_pages_array1, "mdi-comment-question-outline"),
		2	=>array("Product", "product-master", $left_pages_array2, "mdi-product"),
		3	=>array("FAQ", "faq", $left_pages_array3, "mdi-information"),
		4	=>array("Order", "order", $left_pages_array4, "mdi-cart-plus"),
		5	=>array("Manage Blog", "blog", $left_pages_array5, "mdi-blogger"),
		6	=>array("General", "general", $left_pages_array6, "mdi mdi-star-circle"),
		7	=>array("Quotations", "quotations", $left_pages_array7, "mdi mdi-cart-plus"),
		8	=>array("Order Report", "order_report", $left_pages_array8, "mdi mdi-cart"),
		9	=>array("Promo", "promo", $left_pages_array9, "mdi mdi-ticket-percent"),
		10	=>array("Subscribers", "subscribers", $left_pages_array10, "mdi mdi-account-box-multiple")
	);

	$left_main_array = array(
		0	=> 	$left_head_array[0],
		1	=> 	$left_head_array[1],
		2	=> 	$left_head_array[2],
		3	=> 	$left_head_array[3],
		4	=> 	$left_head_array[4],
		5	=> 	$left_head_array[5],
		6	=> 	$left_head_array[6],
		7	=> 	$left_head_array[7],
		8	=> 	$left_head_array[8],
		9   =>  $left_head_array[9],
		10  =>  $left_head_array[10]
	);
?>