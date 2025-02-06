<?php
include('./connect.php');

function wooJsonApi( $url ){
	$ch = curl_init();
	curl_setopt($ch, CURLOPT_URL, $url);
	//curl_setopt($ch, CURLOPT_URL, 'https://www.clearballistics.com//wp-json/wc/v3/products/categories?per_page=100');
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
	curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'GET');
	curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
	curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
	curl_setopt($ch, CURLOPT_USERPWD, 'ck_20c47e5b83c5a87f462ad79c40ab2f59f4760b7e' . ':' . 'cs_4d2fe0e07523be7b73fea9b6c7d4e27dec0eca53');
	
	$result = curl_exec($ch);
	if (curl_errno($ch)) {
		echo 'Error:' . curl_error($ch);
	}
	curl_close($ch);

	return json_decode($result);
}




//echo "<pre>";
//print_r(json_decode($result));
$store_data_in = wooJsonApi('https://www.clearballistics.com//wp-json/wc/v3/products?per_page=100&page=2&orderby=date');
//$store_data_in;

$counter = 0;
/* foreach ($store_data_in as $index => $data) {
	$counter++;
	echo  $index . count($data->images);
	echo "<br>";
}; */
/* unset($store_data_in[8]->description);
unset($store_data_in[8]->price_html);
unset($store_data_in[8]->value); */
//print_r($store_data_in);
//echo $counter;
// count($)


foreach ($store_data_in as $data) {
	$row_arr  [] = array(
		'name' 	=> $data->name,
		'slug'		=> $data->slug,
		'image'			=> '',
		'sell_price'			=> $data->regular_price ?: 0,
		'price'			=> $data->sale_price ?: 0,
		//'description'			=> $db->clean($data->description),
		'short_description'			=> '',
		'specification'			=> '',
		'technical'			=> "",
		'quantity'			=> 0,
		'cal_qty'			=> 1,
		'video'			=> '',
		'new'		=> 0,
		'onSale'	=> 0,
		'out_of_stock'			=> 1,
		'isActive'			=> 1,
		'isRemelt'			=> 1,
		'random_image'			=> '',
		'dimen_image'			=> '',
		'height'			=> 17,
		'width'			=> 11,
		'length'			=> 11,
		'unit'			=> '',
		'caliber_id'	=> '',
		'weight'	=> 17,
		'woo_product_id' => $data->id
	);

	//$db->insert("product", $row_arr);
}  
//echo json_encode($row_arr);

// exit();



/*  foreach ($store_data_in as $data) {
	if($data->parent == 0 ){
		$row_arr [] = array(
			'name' 	=> $data->name,
			'category_slug'		=> $data->slug,
			'image_path'		=> "",
			'isDelete'		=> 0,
			'woo_cat_id'		=> $data->id,
			'parent' => $data->parent
		); 
	} */

 //}
	//$db->insert("explore_category", $row_arr);

echo json_encode($row_arr);