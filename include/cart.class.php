<?php
class Cart extends Functions
{
	private $shipCartData;
	private $purchaseOrderNumber = "";
	public function generateOrderNumber($cart_id = 0)
	{
		$max = 0;
		if ($cart_id <= 0) {
			$max = $this->getValue('cart', 'MAX(id)', 'isDelete=0');
			$max++;
		} else {
			$max = $cart_id;
		}
		$n = 7 - strlen($max);
		for ($i = 0; $i < $n; $i++)
			$max = '0' . $max;
		return 'SWUS-' . $max;
	}
	public function generateOrderNumber2($cart_id = 0)
	{
		$max = 0;
		if ($cart_id <= 0) {
			$max = $this->getValue('cart', 'MAX(id)', 'isDelete=0');
			$max++;
		} else {
			$max = $cart_id;
		}
		$n = 7 - strlen($max);
		for ($i = 0; $i < $n; $i++)
			$max = '0' . $max;
		return 'ORDER-' . $max;
	}

	public function items_in_cart($cart_id)
	{
		return (int) $this->getValue('cart_detail', 'COUNT(*)', 'cart_id=' . (int) $cart_id . ' AND isDelete=0');
	}

	public function add_to_cart($user_id, $product_id, $price, $qty, $color = null)
	{
		// print_r($_SESSION["token"]);
		$color = $color ?? '';
		$cart_id = 0;
		$cart_detail_id = 0;

		if (isset($_SESSION[SESS_PRE . '_SESS_CART_ID']) && $_SESSION[SESS_PRE . '_SESS_CART_ID'] > 0) {
			$cart_id = $_SESSION[SESS_PRE . '_SESS_CART_ID'];
		} else {

			if ($user_id != null && $user_id > 0) {
				$order_no = $this->generateOrderNumber();
				$rows = array(
					'customer_id' => $user_id,
					'order_status' => 1,
					'order_no' => $order_no,
				);
				cb_logger('inserting....');
				$cart_id = $this->insert('cart', $rows);
				cb_logger('b4=' . $_SESSION);
				$_SESSION[SESS_PRE . '_SESS_CART_ID'] = $cart_id;
				cb_logger('after= ' . $_SESSION);
			} else {
				$temp_useId = $this->generateOrderNumber();
				$rows = array(
					'customer_id' => 0,
					'order_status' => 1,
					'order_no' => $temp_useId
				);
				$_SESSION["token"] = $temp_useId;
				$cart_id = $this->insert('cart', $rows);
				$_SESSION[SESS_PRE . '_SESS_CART_ID'] = $cart_id;
			}
		}

		$cart_detail_id = $this->getValue('cart_detail', 'id', 'cart_id=' . (int) $cart_id . ' AND product_id=' . (int) $product_id . ' AND isDelete=0');
		if ($cart_detail_id > 0) {
			cb_logger('update');
			$existing_qty = (int) $this->getValue('cart_detail', 'qty', 'id=' . (int) $cart_detail_id);
			$qty += $existing_qty;

			$product_total = $this->num($price * $qty);

			$rows = array(
				'cart_id' => $cart_id,
				'product_id' => $product_id,
				'qty' => $qty,
				'price' => $price,
				'sub_total' => $product_total,
				'color' => $color ?? null
			);
			$this->update('cart_detail', $rows, 'id=' . (int) $cart_detail_id);
		} else {
			cb_logger('insert new');
			$product_total = $this->num($price * $qty);

			$rows = array(
				'cart_id' => $cart_id,
				'product_id' => $product_id,
				'qty' => $qty,
				'price' => $price,
				'sub_total' => $product_total,
				'color' => $color ?? null
			);
			$cart_detail_id = $this->insert('cart_detail', $rows);
			cb_logger('cart_id' . $cart_detail_id);
		}

		// update cart master table
		$this->update_cart_total($cart_id);
	}

	public function remove_from_cart($cart_id, $id)
	{
		$rows = array('isDelete' => 1);
		$this->update('cart_detail', $rows, 'cart_id=' . (int) $cart_id . ' AND id=' . (int) $id);
		// remove voucher
		$cr_arr = array(
			"discount_type" => "",
			"discount"		=> 0,
			"coupon_id"		=> 0,
			"coupon_code"	=> "",
		);

		$this->update("cart", $cr_arr, "isDelete=0 AND id=" . $cart_id);
		// update cart master table
		$this->update_cart_total($cart_id);
	}

	public function update_quantity($cart_id, $id, $qty)
	{
		$price = $this->getValue('cart_detail', 'price', 'id=' . (int) $id . ' AND isDelete=0');
		$product_total = $this->num($price * $qty);

		$rows = array(
			'qty' => $qty,
			'sub_total' => $product_total,
		);
		$this->update('cart_detail', $rows, 'cart_id=' . (int) $cart_id . ' AND id=' . (int) $id);

		// update cart master table
		$this->update_cart_total($cart_id);
	}

	public function update_cart_total($cart_id)
	{
		// echo "hy";
		// exit;
		$subtotal = $this->getValue('cart_detail', 'SUM(sub_total)', 'cart_id=' . (int)$cart_id . ' AND isDelete=0');
		$subtotal = $this->num($subtotal);

		/*$tax = $this->num(($subtotal * TAX_RATE) / 100);
			$grandtotal = $this->num($subtotal + $tax);*/

		$grandtotal = $this->getValue('cart_detail', 'SUM(sub_total)', 'cart_id=' . (int)$cart_id . ' AND isDelete=0');
		$grandtotal = $this->num($grandtotal);
		// $tax = $this->num(($grandtotal * TAX_RATE) / (100 + TAX_RATE) );
		//$subtotal = $this->num($grandtotal - $tax);

		$rows = array(
			'sub_total' => $subtotal,
			// 'tax_rate' => TAX_RATE, 
			// 'tax' => $tax, 
			'grand_total' => $grandtotal,
		);
		$this->update('cart', $rows, 'id=' . (int) $cart_id);
	}

	public function MultiSort($data, $sortCriteria, $caseInSensitive = true)
	{
		if (!is_array($data) || !is_array($sortCriteria))
			return false;
		$args = array();
		$i = 0;
		foreach ($sortCriteria as $sortColumn => $sortAttributes) {
			$colList = array();
			foreach ($data as $key => $row) {
				$convertToLower = $caseInSensitive && (in_array(SORT_STRING, $sortAttributes) || in_array(SORT_REGULAR, $sortAttributes));
				$rowData = $convertToLower ? strtolower($row[$sortColumn]) : $row[$sortColumn];
				$colLists[$sortColumn][$key] = $rowData;
			}
			$args[] = &$colLists[$sortColumn];

			foreach ($sortAttributes as $sortAttribute) {
				$tmp[$i] = $sortAttribute;
				$args[] = &$tmp[$i];
				$i++;
			}
		}
		$args[] = &$data;
		call_user_func_array('array_multisort', $args);
		return end($args);
	}

	public function getAustraliaPostAccountInfo()
	{
		global $url, $headers;
		$curl = curl_init();
		curl_setopt_array(
			$curl,
			array(
				CURLOPT_URL => $url . "accounts/" . ACNO_EPARCEL_INTERNATIONAL,
				CURLOPT_HTTPHEADER => $headers,
				CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
				CURLOPT_RETURNTRANSFER => true,
				CURLOPT_ENCODING => "",
				CURLOPT_MAXREDIRS => 10,
				CURLOPT_TIMEOUT => 0,
				CURLOPT_FOLLOWLOCATION => true,
				CURLOPT_CUSTOMREQUEST => "GET",
			)
		);

		$response = curl_exec($curl);
		curl_close($curl);
		//echo $response;
		$response = json_decode($response);
		//print '<pre>'; print_r($response);

		$products = $response->postage_products;
		$arprod = array();
		foreach ($products as $product) {
			/* 
					3K55, 7E55 - TestBed ids
					3J85, 3D85 - Production ids
				*/
			if ($product->product_id == '3K55' || $product->product_id == '7E55' || $product->product_id == '3J85' || $product->product_id == '3D85') {
				$row = array(
					'product_id' => $product->product_id,
					'name' => $product->type,
					'rate' => $product->features->TRANSIT_COVER->attributes->rate,
					'included_cover' => $product->features->TRANSIT_COVER->attributes->included_cover,
					'maximum_cover' => $product->features->TRANSIT_COVER->attributes->maximum_cover,
					'calculated_gst' => $product->features->TRANSIT_COVER->price->calculated_gst,
					'calculated_price' => $product->features->TRANSIT_COVER->price->calculated_price,
					'calculated_price_ex_gst' => $product->features->TRANSIT_COVER->price->calculated_price_ex_gst,
					'valid_from' => $product->contract->valid_from,
					'valid_to' => $product->contract->valid_to,
					'expired' => $product->contract->expired,
				);
				array_push($arprod, $row);
			}
		}
		//$arprod = asort($arprod);
		//$arprod = array_multisort(array_column($arprod, 'key'), SORT_DESC, $arprod);

		//Set the sort criteria (add as many fields as you want)
		$sortCriteria =
			array(
				'name' => array(SORT_ASC),
				'rate' => array(SORT_DESC, SORT_NUMERIC)
			);
		$arprod = $this->MultiSort($arprod, $sortCriteria, true);
		//print '<pre>'; print_r($arprod);	
		return $arprod;
	}

	public function getItemPrice($cart_id, $method)
	{
		global $url, $headers;

		$from_zipcode = COMPANY_ZIPCODE;
		$to_zipcode = $this->getValue('billing_shipping', 'shipping_zipcode', 'cart_id=' . $cart_id);

		$arfrom = array('postcode' => $from_zipcode);
		$arto = array('postcode' => $to_zipcode);
		$aritems = array();

		$join = ' LEFT JOIN product p ON p.id = cd.product_id';
		$rows = 'cd.qty, p.name, p.height, p.width, p.length, p.weight';
		$where = 'cd.cart_id = 1 AND cd.isDelete=0';
		$rs = $this->getJoinData2('cart_detail cd', $join, $rows, $where);
		while ($row = @mysqli_fetch_assoc($rs)) {
			$item = array(
				'length' => $row['length'],
				'height' => $row['height'],
				'width' => $row['width'],
				'weight' => $row['weight'],
				'item_reference' => $row['name'],
				'features' => array('TRANSIT_COVER' => array('attributes' => array('cover_amount' => $row['qty']))),
			);
			array_push($aritems, $item);
		}

		$arjson = array('from' => $arfrom, 'to' => $arto, 'items' => $aritems);
		$json = json_encode($arjson);
		//echo $json;

		$curl = curl_init();
		curl_setopt_array(
			$curl,
			array(
				CURLOPT_URL => $url . "prices/items",
				CURLOPT_HTTPHEADER => $headers,
				CURLOPT_RETURNTRANSFER => true,
				CURLOPT_SSL_VERIFYHOST => false,
				CURLOPT_SSL_VERIFYPEER => false,
				CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
				CURLOPT_POST => count($arjson),
				CURLOPT_POSTFIELDS => $json,
			)
		);

		$response = curl_exec($curl);
		curl_close($curl);
		//echo $response;
		$response = json_decode($response);
		//print '<pre>'; print_r($response);

		//echo '====' . $method . '====';
		$arprice = array();
		foreach ($response->items as $item) {
			$arprice = $item->prices;
			foreach ($arprice as $price) {
				//echo $price->product_type . '<br />';
				if ($price->product_id == $method) {
					$feature = $price->features->TRANSIT_COVER;
					$arp = array(
						'calculated_gst' => $price->calculated_gst,
						'calculated_price' => $price->calculated_price,
						'calculated_price_ex_gst' => $price->calculated_price_ex_gst,
						'bundled_price' => $price->bundled_price,
						'bundled_price_ex_gst' => $price->bundled_price_ex_gst,
						'bundled_gst' => $price->bundled_gst,
						'cover_rate' => $feature->attributes->rate,
						'cover_amount' => $feature->attributes->cover_amount,
						'cover_gst' => $feature->price->calculated_gst,
						'cover_price' => $feature->price->calculated_price,
						'cover_price_ex_gst' => $feature->price->calculated_price_ex_gst,
					);
					array_push($arprice, $arp);
				}
			}
		}
		return $arprice;
	}

	public function getShipmentPrice($cart_id, $method)
	{
		global $url, $headers;

		$from_zipcode = COMPANY_ZIPCODE;
		$rs_to = $this->getData('billing_shipping', 'shipping_city, shipping_state, shipping_zipcode', 'cart_id=' . $cart_id);
		$row_to = @mysqli_fetch_assoc($rs_to);
		//$to_city = $this->getValue('city', 'name', 'id='.$row_to['shipping_city']);
		$to_city = $row_to['shipping_city'];
		$to_state = $this->getValue('states', 'code', 'id=' . $row_to['shipping_state']);
		$to_zipcode = $row_to['shipping_zipcode'];

		$arfrom = array('suburb' => COMPANY_CITY, 'state' => COMPANY_STATE, 'postcode' => COMPANY_ZIPCODE);
		$arto = array('suburb' => $to_city, 'state' => $to_state, 'postcode' => $to_zipcode);

		//print '<pre>'; print_r($arfrom); print_r($arto);

		$aritems = array();

		$join = ' LEFT JOIN product p ON p.id = cd.product_id';
		$rows = 'cd.qty, p.name, p.height, p.width, p.length, p.weight';
		$where = 'cd.cart_id = 1 AND cd.isDelete=0';
		$rs = $this->getJoinData2('cart_detail cd', $join, $rows, $where);
		while ($row = @mysqli_fetch_assoc($rs)) {
			$item = array(
				'product_id' => $method,
				'length' => $row['length'],
				'height' => $row['height'],
				'width' => $row['width'],
				'weight' => $row['weight'],
			);
			array_push($aritems, $item);
		}

		$shipment = array();
		$shipments = array('from' => $arfrom, 'to' => $arto, 'items' => $aritems);

		array_push($shipment, $shipments);
		$arjson = array('shipments' => $shipment);

		//print '<pre>'; print_r($shipments);
		$json = json_encode($arjson);
		//echo $json;

		$curl = curl_init();
		curl_setopt_array(
			$curl,
			array(
				CURLOPT_URL => $url . "prices/shipments",
				CURLOPT_HTTPHEADER => $headers,
				CURLOPT_RETURNTRANSFER => true,
				CURLOPT_SSL_VERIFYHOST => false,
				CURLOPT_SSL_VERIFYPEER => false,
				CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
				CURLOPT_POST => count($arjson),
				CURLOPT_POSTFIELDS => $json,
			)
		);

		$response = curl_exec($curl);
		curl_close($curl);
		//echo $response;
		$response = json_decode($response);
		//print '<pre>'; print_r($response);

		//echo '====' . $method . '====';
		$price = $response->shipments[0]->shipment_summary;
		$row = array(
			'total_cost' => $price->total_cost,
			'total_cost_ex_gst' => $price->total_cost_ex_gst,
			'shipping_cost' => $price->shipping_cost,
			'fuel_surcharge' => $price->fuel_surcharge,
			'total_gst' => $price->total_gst,
		);
		return $row;
	}

	public function validate_address($city, $state, $zipcode)
	{
		global $url, $headers;

		// sample
		// "https://digitalapi.auspost.com.au/shipping/v1/address?suburb=Greensborough&state=VIC&postcode=3088"

		$state = $this->getValue('states', 'code', 'id=' . $state);
		//$city = $this->getValue('city', 'name', 'id='.$city);
		$city = urlencode($city);

		$curl = curl_init();
		curl_setopt_array(
			$curl,
			array(
				CURLOPT_URL => "https://digitalapi.auspost.com.au/shipping/v1/address?suburb=" . $city . "&state=" . $state . "&postcode=" . $zipcode,
				CURLOPT_HTTPHEADER => $headers,
				CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
				CURLOPT_RETURNTRANSFER => true,
				CURLOPT_ENCODING => "",
				CURLOPT_MAXREDIRS => 10,
				CURLOPT_TIMEOUT => 0,
				CURLOPT_FOLLOWLOCATION => true,
				CURLOPT_CUSTOMREQUEST => "GET",
			)
		);

		$response = curl_exec($curl);
		curl_close($curl);
		//echo $response;
		$response = json_decode($response);
		//print '<pre>'; print_r($response);
		return $response->found;
	}

	public function getTrackingDetails($track_id)
	{
		global $url, $headers;

		$curl = curl_init();
		curl_setopt_array(
			$curl,
			array(
				//CURLOPT_URL => "https://digitalapi.auspost.com.au/shipping/v1/address?suburb=Greensborough&state=VIC&postcode=3088", 
				CURLOPT_URL => $url . "track?tracking_ids=" . $track_id,
				CURLOPT_HTTPHEADER => $headers,
				CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
				CURLOPT_RETURNTRANSFER => true,
				CURLOPT_ENCODING => "",
				CURLOPT_MAXREDIRS => 10,
				CURLOPT_TIMEOUT => 0,
				CURLOPT_FOLLOWLOCATION => true,
				CURLOPT_CUSTOMREQUEST => "GET",
			)
		);

		$response = curl_exec($curl);
		curl_close($curl);
		//echo $response;

		$response = json_decode($response);
		//print '<pre>'; print_r($response);
		return $response;
	}

	public function getCartSubTotalPrice() // Total Price of cart
	{
		if (isset($_SESSION[SESS_PRE . '_SESS_CART_ID']) && $_SESSION[SESS_PRE . '_SESS_CART_ID'] > 0) {
			$coupon_code = parent::getValue("cart", "coupon_id", "id='" . $_SESSION[SESS_PRE . '_SESS_CART_ID'] . "'");
			$shop_cart_r = parent::getData("cart_detail", "*", "cart_id='" . $_SESSION[SESS_PRE . '_SESS_CART_ID'] . "' AND isDelete=0 ");
			if (@mysqli_num_rows($shop_cart_r) > 0) {
				$discount = 0;
				$sub_total = 0;
				$total_ship_charge = 0;
				$total_pro_w = 0;
				$total_pro_amt = 0;
				while ($shop_cart_d = @mysqli_fetch_array($shop_cart_r)) {
					$id			= $shop_cart_d['id'];
					$pid 		= $shop_cart_d['product_id'];
					$qty 		= $shop_cart_d['qty'];
					$unitprice 	= parent::num($shop_cart_d['price']);

					$coupon_code_type = parent::getValue("coupon", "type", "code='" . $coupon_code . "'");
					// if($coupon_code_type)
					// {$discount	+= $shop_cart_d['discount'];}
					// else
					// {$discount	= $shop_cart_d['discount'];}

					$id			= $shop_cart_d['id'];
					$pid 		= $shop_cart_d['product_id'];
					$pro_r 		= parent::getData("product", "*", "id='" . $pid . "'");

					// if(@mysqli_num_rows($pro_r)>0){
					// 	$pro_d 		= @mysqli_fetch_array($pro_r);
					// 	$cid 		= stripslashes($pro_d['cid']);
					// 	$sid 		= stripslashes($pro_d['sid']);
					// }
					// $pro_weight = $shop_cart_d['width'];
					$pro_weight = parent::getValue("product", "width", "id='" . $shop_cart_d['product_id'] . "'");
					$totalprice = parent::num($shop_cart_d['sub_total']);
					$sub_total 	+= $totalprice;

					// if( $cid == 1 && $sid == 1 )
					// {

					// 	$total_pro_w += ($pro_weight * $qty);
					// 	$total_pro_amt += $totalprice;
					// }
					$total_pro_w += ($pro_weight * $qty);
					$total_pro_amt += $totalprice;
				}
				//echo $discount;
				$final_discount_amount = 0;

				// $disc_check_r = parent::getData("discount","*"," cat_id=1 AND isDelete=0","min_w");
				// if(@@mysqli_num_rows($disc_check_r)>0){

				// 	while($disc_check_d = @@mysqli_fetch_array($disc_check_r))
				// 	{	

				// 		$discount_type 	= $disc_check_d['disc_type'];
				// 		$discount_amount= $disc_check_d['discount'];
				// 		$min_w			= $disc_check_d['min_w'];

				// 		if($total_pro_w>=$min_w)
				// 		{
				// 			//$final_discount_amount = 0;
				// 			if($discount_type==1){
				// 				$final_discount_amount = parent::rpnum(($total_pro_amt*$discount_amount)/100);
				// 			}else{
				// 				$final_discount_amount = parent::rpnum($discount_amount);
				// 			}
				// 		}
				// 	}	
				// }


				$sub_total 			= parent::num($sub_total);
				$shipping_charge 	= parent::num(0);
				$tax = parent::num(0.00);
				$final_total = parent::num(($sub_total + $shipping_charge + $tax) - $discount -  $final_discount_amount);
				return  $final_total;
			} else {
				return parent::num(0);
			}
		} else {
			return parent::num(0);
		}
	}

	public function getDiscountAmount($disc_type, $discount, $totalprice)
	{ // $disc_type : 0=flat, 1=perc
		if ($disc_type == 0) {
			return $discount;
		} else {
			$discount_amt = $totalprice * ($discount / 100);
			return $discount_amt;
		}
	}
	public function getCartDetailsFull($cart_id)
	{
		try {
			cb_logger("getCartDetailsFull=$cart_id");
			$findCart = $this->getData("cart", "*", "id='{$cart_id}'", null);
			$findCartData = mysqli_fetch_assoc($findCart);
			//$get_shipping_details = $this->getData("billing_shipping", "*", "isDelete=0 AND cart_id=" . $cart_id);
			//$get_shipping_details_r = mysqli_fetch_assoc($get_shipping_details);
			$items_arr = [];
			// cart detail
			$where = "cd.isDelete=0 AND p.isDelete=0 AND cd.cart_id=" . $cart_id;
			$join = " LEFT JOIN product p ON p.id = cd.product_id";
			$rows = "cd.price, cd.sub_total, cd.qty, cd.id, cd.color as 'item_color', p.name, p.image, p.weight, p.code, cd.product_id, cd.qty";
			$cart_data = $this->getJoinData2("cart_detail cd", $join, $rows, $where);
			$totalWeight = 0;
			$cart_sub_total = 0;
			$free_gift_weight = 0;
			if (@mysqli_num_rows($cart_data) > 0) {
				foreach ($cart_data as $cart_data_d) {
					$cart_sub_total += $cart_data_d['price'] * $cart_data_d['qty'];
					$totalWeight += $cart_data_d['weight'];
					if ($cart_data_d['image'] != "") {
						$product_img = SITEURL . "img/product/" . $cart_data_d['image'];
					} else {
						$product_img = SITEURL . "img/bi.jpeg";
					}

					if ($cart_data_d['qty'] != 0) {
						$quantity = $cart_data_d['qty'];
					} else {
						$quantity = 0;
					}
					$options = [];
					$item_color = [];
					if ($cart_data_d['item_color']) {
						$item_color = [
							"name" => "color",
							"value" => $cart_data_d['item_color']
						];
						$options = [$item_color];
					}


					$items_arr[] = array(
						'sku' => $cart_data_d['code'],
						'name' => $cart_data_d['name'],
						'imageUrl' => $product_img,
						'quantity' => $quantity,
						'weight' => [
							'value' =>  $cart_data_d['weight'] ?? 5,
							'units' => "lbs",
							'WeightUnits' => 1
						],
						"unitPrice" => $cart_data_d['price'],
						"taxAmount" => null,
						"shippingAmount" => null,
						"warehouseLocation" => null,
						"options" => $options,
						"productId" => $cart_data_d['id'],
						"fulfillmentSku" => null,
						"adjustment" => false,
						"upc" => null,
						"createDate" => $cart_data_d['createdDate'] ?? date("Y-m-d H:i:s"),
						"modifyDate" => $cart_data_d['lastModified'] ?? date("Y-m-d H:i:s")
					);
				}
			}

			$free_gift = '';
			$image_float = '';
			$qualify = false;
			if ($cart_sub_total >= '300' && $cart_sub_total <= '499.99') {
				$free_gift = "Yeti Rambler (20 oz Tumbler)";
				$image_float = SITEURL . "/img/gift_item/Yeti-Tumbler_Clear.png";
				$free_gift_weight = .9;
			} else if ($cart_sub_total >= '500' && $cart_sub_total <= '999.99') {
				$free_gift = "10% FBI Block";
				$image_float = "https://clearballistics.com/img/product/1712147489_8327123_prod.png";
				$free_gift_weight = 17.2;
			} else if ($cart_sub_total >= '1000') {
				$free_gift = "Yeti Roadie 24 Hard Cooler ";
				$image_float = SITEURL . "/img/gift_item/Yeti-Roadie_Brighter.png";
				$free_gift_weight = 13.1;
			} else {
				$qualify = false;
			}
			if ($qualify) {
				$items_arr[] = array(
					'sku' => '00000000000',
					'name' => $free_gift,
					'imageUrl' => $image_float,
					'quantity' => 1,
					'weight' => [
						'value' =>  $free_gift_weight,
						'units' => "lbs",
						'WeightUnits' => 1
					],
					"unitPrice" => 0.00,
					"taxAmount" => null,
					"shippingAmount" => null,
					"warehouseLocation" => null,
					"options" => [],
					"fulfillmentSku" => null,
					"adjustment" => false,
					"upc" => null,
					"createDate" => $cart_data_d['createdDate'] ?? date("Y-m-d H:i:s"),
					"modifyDate" => $cart_data_d['lastModified'] ?? date("Y-m-d H:i:s")
				);
			}
			$totalWeight = $totalWeight + $free_gift_weight;
			$billing_shipping_tbl_r = $this->getData("billing_shipping", "*", "isDelete=0 AND cart_id=" . $cart_id);
			$billing_shipping_tbl_d = mysqli_fetch_assoc($billing_shipping_tbl_r);
			$billTo = [
				'name'     => $billing_shipping_tbl_d['billing_first_name'] . " " . $billing_shipping_tbl_d['billing_last_name'],
				'company'      => null,
				'street1'          => $billing_shipping_tbl_d['billing_address'] ?? null,
				'street2'       => $billing_shipping_tbl_d['billing_address2'] ?? null,
				'street3'      =>  null,
				'city'          => $billing_shipping_tbl_d['billing_city'] ?? null,
				'state'         => $this->getValue("states_ex", "name", "id='" . $billing_shipping_tbl_d['billing_state'] . "' ") ?? null,
				'postalCode'       => $billing_shipping_tbl_d['billing_zipcode'] ?? null,
				'country'       => $this->getValue("countries", "iso2", "id='" . $billing_shipping_tbl_d['billing_country'] . "' ") ?? null,
				"phone" => $billing_shipping_tbl_d['billing_phone'] ?? 0000000,
				'email'         => $billing_shipping_tbl_d['billing_email'] ?? null,
			];
			$shipTo = [
				'name'    => $billing_shipping_tbl_d['shipping_first_name'] . " " . $billing_shipping_tbl_d['shipping_last_name'] ?? null,
				'company'     => null,
				'street1'       => $billing_shipping_tbl_d['shipping_address'] ?? null,
				'street2'      => $billing_shipping_tbl_d['shipping_address2'] ?? null,
				'street3'      => null,
				'city'          => $billing_shipping_tbl_d['shipping_city'] ?? null,
				'state'         => $this->getValue("states_ex", "name", "id='" . $billing_shipping_tbl_d['shipping_state'] . "' ") ?? null,
				'postalCode'       => $billing_shipping_tbl_d['shipping_zipcode'] ?? null,
				'country'       => $this->getValue("countries", "iso2", "id='" . $billing_shipping_tbl_d['shipping_country'] . "' ") ?? null,
				'phone'         => $billing_shipping_tbl_d['shipping_phone'] ?? null,
				'email'         => $billing_shipping_tbl_d['shipping_email'] ?? null,
			];

			$response = [
				'orderNumber' => $findCartData['order_no'],
				'customerEmail' => $shipTo['email'] ?? $billTo['email'] ?? "",
				'orderDate' => $findCartData['order_date'] ?? date("Y-m-d H:i:s"),
				'orderStatus' => '',
				'billTo' => $billTo,
				'shipTo' => $shipTo,
				'orderTotal' => number_format($findCartData['grand_total'], 2),
				'amountPaid' => number_format($findCartData['grand_total'], 2),
				'taxAmount' => 0.00,
				'shippingAmount' => number_format($findCartData['shipping'], 2),
				'items' => $items_arr,
				"weight" =>  [
					"value" => $totalWeight,
					"units" => "pounds",
					"WeightUnits" => 1
				],
				'requestedShippingService' => $findCartData['shipping_method'],
				'paymentMethod' => $findCartData['payment_method'],
				'discount' => $findCartData['discount'],
				'shipping_email' => $shipTo['email'] ?? $billTo['email'] ?? ""
			];
			$this->shipCartData = $response;
			return $response;
		} catch (\Throwable $th) {
			throw $th;
		}
	}
	public function getCartDetails($cart_id)
	{
		try {
			$findCart = $this->getData("cart", "*", "id='{$cart_id}'", null);
			$findCartData = mysqli_fetch_assoc($findCart);
			//$get_shipping_details = $this->getData("billing_shipping", "*", "isDelete=0 AND cart_id=" . $cart_id);
			//$get_shipping_details_r = mysqli_fetch_assoc($get_shipping_details);
			$items_arr = [];
			// cart detail
			$where = "cd.isDelete=0 AND p.isDelete=0 AND cd.cart_id=" . $cart_id;
			$join = " LEFT JOIN product p ON p.id = cd.product_id";
			$rows = "cd.price, cd.sub_total, cd.qty, cd.id, p.name, p.image, p.weight, p.code, cd.product_id, cd.qty";
			$cart_data = $this->getJoinData2("cart_detail cd", $join, $rows, $where);
			$totalWeight = 0;
			if (@mysqli_num_rows($cart_data) > 0) {
				foreach ($cart_data as $cart_data_d) {
					$totalWeight += $cart_data_d['weight'];
					if ($cart_data_d['image'] != "") {
						$product_img = SITEURL . "img/product/" . $cart_data_d['image'];
					} else {
						$product_img = SITEURL . "img/bi.jpeg";
					}

					if ($cart_data_d['qty'] != 0) {
						$quantity = $cart_data_d['qty'];
					} else {
						$quantity = 0;
					}

					$items_arr[] = array(
						'sku' => $cart_data_d['code'],
						'name' => $cart_data_d['name'],
						'imageUrl' => $product_img,
						'quantity' => $quantity,
						'weight' => [
							'value' =>  $cart_data_d['weight'] ?? 5,
							'units' => "lbs",
							'WeightUnits' => 1
						],
						"unitPrice" => $cart_data_d['price'],
						"taxAmount" => null,
						"shippingAmount" => null,
						"warehouseLocation" => null,
						"options" => [],
						"productId" => $cart_data_d['id'],
						"fulfillmentSku" => null,
						"adjustment" => false,
						"upc" => null,
						"createDate" => $cart_data_d['createdDate'] ?? date("Y-m-d H:i:s"),
						"modifyDate" => $cart_data_d['lastModified'] ?? date("Y-m-d H:i:s")

					);
				}
			}

			$billing_shipping_tbl_r = $this->getData("billing_shipping", "*", "isDelete=0 AND cart_id=" . $cart_id);
			$billing_shipping_tbl_d = mysqli_fetch_assoc($billing_shipping_tbl_r);
			$billTo = [
				'name'     => $billing_shipping_tbl_d['billing_first_name'] . " " . $billing_shipping_tbl_d['billing_last_name'],
				'company'      => null,
				'street1'          => $billing_shipping_tbl_d['billing_address'] ?? null,
				'street2'       => $billing_shipping_tbl_d['billing_address2'] ?? null,
				'street3'      =>  null,
				'city'          => $billing_shipping_tbl_d['billing_city'] ?? null,
				'state'         => $this->getValue("states_ex", "name", "id='" . $billing_shipping_tbl_d['billing_state'] . "' ") ?? null,
				'postalCode'       => $billing_shipping_tbl_d['billing_zipcode'] ?? null,
				'country'       => $this->getValue("countries", "iso2", "id='" . $billing_shipping_tbl_d['billing_country'] . "' ") ?? null,
				"phone" => $billing_shipping_tbl_d['billing_phone'] ?? 0000000,
				'email'         => $billing_shipping_tbl_d['billing_email'] ?? null
			];
			$shipTo = [
				'name'    => $billing_shipping_tbl_d['shipping_first_name'] . " " . $billing_shipping_tbl_d['shipping_last_name'] ?? null,
				'company'     => null,
				'street1'       => $billing_shipping_tbl_d['shipping_address'] ?? null,
				'street2'      => $billing_shipping_tbl_d['shipping_address2'] ?? null,
				'street3'      => null,
				'city'          => $billing_shipping_tbl_d['shipping_city'] ?? null,
				'state'         => $this->getValue("states_ex", "name", "id='" . $billing_shipping_tbl_d['shipping_state'] . "' ") ?? null,
				'postalCode'       => $billing_shipping_tbl_d['shipping_zipcode'] ?? null,
				'country'       => $this->getValue("countries", "iso2", "id='" . $billing_shipping_tbl_d['shipping_country'] . "' ") ?? null,
				'phone'         => $billing_shipping_tbl_d['shipping_phone'] ?? null,
				'email'         => $billing_shipping_tbl_d['shipping_email'] ?? null,
			];

			$response = [
				'orderNumber' => $findCartData['order_no'],
				'customerEmail' => $shipTo['email'] ?? $billTo['email'] ?? "",
				'orderDate' => date("Y-m-d H:i:s"),
				'orderStatus' => '',
				'billTo' => $billTo,
				'shipTo' => $shipTo,
				'orderTotal' => number_format($findCartData['grand_total'], 2),
				'amountPaid' => number_format($findCartData['grand_total'], 2),
				'taxAmount' => 0.00,
				'shippingAmount' => number_format($findCartData['shipping'], 2),
				'items' => $items_arr,
				"weight" =>  [
					"value" => $totalWeight,
					"units" => "pounds",
					"WeightUnits" => 1
				],
				'requestedShippingService' => $findCartData['shipping_method']
			];
			$this->shipCartData = $response;
			return $response;
		} catch (\Throwable $th) {
			throw $th;
		}
	}
	public function shipPaidCart()
	{
		try {
			$shipPaidCartData = $this->shipCartData;
			$shipPaidCartData['orderStatus'] = "awaiting_shipment";
			$shipPaidCartData['paymentDate'] = date("Y-m-d H:i:s");
			$postFieldData = json_encode($shipPaidCartData);
			cb_logger('ShipPaidCardReq=' . $postFieldData);
			$curl = curl_init();
			curl_setopt_array($curl, array(
				CURLOPT_URL => 'https://ssapi.shipstation.com/orders/createorder',
				CURLOPT_RETURNTRANSFER => true,
				CURLOPT_ENCODING => '',
				CURLOPT_MAXREDIRS => 10,
				CURLOPT_TIMEOUT => 0,
				CURLOPT_FOLLOWLOCATION => true,
				CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
				CURLOPT_SSL_VERIFYHOST => false,
				CURLOPT_SSL_VERIFYPEER => false,
				CURLOPT_CUSTOMREQUEST => 'POST',
				CURLOPT_POSTFIELDS => $postFieldData,
				CURLOPT_HTTPHEADER => array(
					'Authorization: Basic YzAwMTliNjUzNWNkNDU1MWEyZTdkNTEyN2Q1MWNjNmM6NmE0M2U1Yjg5MDFiNDlmOWJiM2MzMzc2MDI4OGMzN2M=',
					'Content-Type: application/json'
				),
			));
			$response = curl_exec($curl);
			cb_logger(json_encode($response));
			curl_close($curl);

			//return $response;



			//return $postFieldData;
		} catch (\Throwable $th) {
			cb_logger($th);
		}
	}

	public function purchaseOrderCart($purchase_number)
	{
		try {
			$this->purchaseOrderNumber = $purchase_number;
			$shipPaidCartData = $this->shipCartData;
			$shipPaidCartData['orderStatus'] = "awaiting_payment";
			$shipPaidCartData['orderNumber'] = $purchase_number;
			$postFieldData = json_encode($shipPaidCartData);
			cb_logger('purchaseOrderCartReq=' . $postFieldData);
			$curl = curl_init();
			curl_setopt_array($curl, array(
				CURLOPT_URL => 'https://ssapi.shipstation.com/orders/createorder',
				CURLOPT_RETURNTRANSFER => true,
				CURLOPT_ENCODING => '',
				CURLOPT_MAXREDIRS => 10,
				CURLOPT_TIMEOUT => 0,
				CURLOPT_FOLLOWLOCATION => true,
				CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
				CURLOPT_SSL_VERIFYHOST => false,
				CURLOPT_SSL_VERIFYPEER => false,
				CURLOPT_CUSTOMREQUEST => 'POST',
				CURLOPT_POSTFIELDS => $postFieldData,
				CURLOPT_HTTPHEADER => array(
					'Authorization: Basic YzAwMTliNjUzNWNkNDU1MWEyZTdkNTEyN2Q1MWNjNmM6NmE0M2U1Yjg5MDFiNDlmOWJiM2MzMzc2MDI4OGMzN2M=',
					'Content-Type: application/json'
				),
			));
			$response = curl_exec($curl);
			cb_logger('PO=' . json_encode($response));
			curl_close($curl);
		} catch (\Throwable $th) {
			cb_logger($th);
		}
	}

	public function getCartShippingDetails($cart_id = null)
	{
		$billing_shipping_tbl_r = $this->getData("billing_shipping", "*", "isDelete=0 AND cart_id=" . $cart_id);
		$billing_shipping_tbl_d = mysqli_fetch_assoc($billing_shipping_tbl_r);
		$billTo = [
			'billing_name'     => $billing_shipping_tbl_d['billing_first_name'] . " " . $billing_shipping_tbl_d['billing_last_name'],
			'billing_company'      => null,
			'billing_street1'          => $billing_shipping_tbl_d['billing_address'] ?? null,
			'billing_street2'       => $billing_shipping_tbl_d['billing_address2'] ?? null,
			'billing_street3'      =>  null,
			'billing_city'          => $billing_shipping_tbl_d['billing_city'] ?? null,
			'billing_state'         => $this->getValue("states_ex", "name", "id='" . $billing_shipping_tbl_d['billing_state'] . "' ") ?? null,
			'billing_postalCode'       => $billing_shipping_tbl_d['billing_zipcode'] ?? null,
			'billing_country'       => $this->getValue("countries", "iso2", "id='" . $billing_shipping_tbl_d['billing_country'] . "' ") ?? null,
			"billing_phone" => $billing_shipping_tbl_d['billing_phone'] ?? 0000000,
			'billing_email' => $billing_shipping_tbl_d['billing_email']
		];
		$shipTo = [
			'shipping_name'    => $billing_shipping_tbl_d['shipping_first_name'] . " " . $billing_shipping_tbl_d['shipping_last_name'] ?? null,
			'shipping_company'     => null,
			'shipping_street1'       => $billing_shipping_tbl_d['shipping_address'] ?? null,
			'shipping_street2'      => $billing_shipping_tbl_d['shipping_address2'] ?? null,
			'shipping_street3'      => null,
			'shipping_city'          => $billing_shipping_tbl_d['shipping_city'] ?? null,
			'shipping_state'         => $this->getValue("states_ex", "name", "id='" . $billing_shipping_tbl_d['shipping_state'] . "' ") ?? null,
			'shipping_postalCode'       => $billing_shipping_tbl_d['shipping_zipcode'] ?? null,
			'shipping_country'       => $this->getValue("countries", "iso2", "id='" . $billing_shipping_tbl_d['shipping_country'] . "' ") ?? null,
			'shipping_phone'         => $billing_shipping_tbl_d['shipping_phone'] ?? null,
			'shipping_email' => $billing_shipping_tbl_d['shipping_email']
		];

		return array_merge($billTo, $shipTo);
	}

	public function getOrderStatusFromShipStation($shipstation_order_number = null)
	{
		try {
			$curl = curl_init();
			curl_setopt_array($curl, array(
				CURLOPT_URL => "https://ssapi.shipstation.com/orders?orderNumber=$shipstation_order_number",
				CURLOPT_RETURNTRANSFER => true,
				CURLOPT_ENCODING => '',
				CURLOPT_MAXREDIRS => 10,
				CURLOPT_TIMEOUT => 0,
				CURLOPT_FOLLOWLOCATION => true,
				CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
				CURLOPT_SSL_VERIFYHOST => false,
				CURLOPT_SSL_VERIFYPEER => false,
				CURLOPT_CUSTOMREQUEST => 'GET',
				CURLOPT_HTTPHEADER => array(
					'Authorization: Basic YzAwMTliNjUzNWNkNDU1MWEyZTdkNTEyN2Q1MWNjNmM6NmE0M2U1Yjg5MDFiNDlmOWJiM2MzMzc2MDI4OGMzN2M=',
					'Content-Type: application/json'
				),
			));
			$response = curl_exec($curl);
			curl_close($curl);
			return json_decode($response)->orders[0]->orderStatus;
		} catch (\Throwable $th) {
			cb_logger($th);
		}
	}

	public function getOrderTrackingFromShipStation($shipstation_order_number = null)
	{
		try {
			$curl = curl_init();
			curl_setopt_array($curl, array(
				CURLOPT_URL => "https://ssapi.shipstation.com/shipments?orderNumber=$shipstation_order_number",
				CURLOPT_RETURNTRANSFER => true,
				CURLOPT_ENCODING => '',
				CURLOPT_MAXREDIRS => 10,
				CURLOPT_TIMEOUT => 0,
				CURLOPT_FOLLOWLOCATION => true,
				CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
				CURLOPT_SSL_VERIFYHOST => false,
				CURLOPT_SSL_VERIFYPEER => false,
				CURLOPT_CUSTOMREQUEST => 'GET',
				CURLOPT_HTTPHEADER => array(
					'Authorization: Basic YzAwMTliNjUzNWNkNDU1MWEyZTdkNTEyN2Q1MWNjNmM6NmE0M2U1Yjg5MDFiNDlmOWJiM2MzMzc2MDI4OGMzN2M=',
					'Content-Type: application/json'
				),
			));
			$response = curl_exec($curl);
			curl_close($curl);
			return json_decode($response)->shipments[0]->trackingNumber;
		} catch (\Throwable $th) {
			cb_logger($th);
		}
	}

	public function getOrderShipmentFromShipStation($shipstation_order_number = null)
	{
		try {
			$curl = curl_init();
			curl_setopt_array($curl, array(
				CURLOPT_URL => "https://ssapi.shipstation.com/shipments?orderNumber=$shipstation_order_number",
				CURLOPT_RETURNTRANSFER => true,
				CURLOPT_ENCODING => '',
				CURLOPT_MAXREDIRS => 10,
				CURLOPT_TIMEOUT => 0,
				CURLOPT_FOLLOWLOCATION => true,
				CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
				CURLOPT_SSL_VERIFYHOST => false,
				CURLOPT_SSL_VERIFYPEER => false,
				CURLOPT_CUSTOMREQUEST => 'GET',
				CURLOPT_HTTPHEADER => array(
					'Authorization: Basic YzAwMTliNjUzNWNkNDU1MWEyZTdkNTEyN2Q1MWNjNmM6NmE0M2U1Yjg5MDFiNDlmOWJiM2MzMzc2MDI4OGMzN2M=',
					'Content-Type: application/json'
				),
			));
			$response = curl_exec($curl);
			curl_close($curl);
			return json_decode($response)->shipments[0];
		} catch (\Throwable $th) {
			cb_logger($th);
		}
	}

	public function getOrderFromShipStation($shipstation_order_number = null)
	{
		try {
			$curl = curl_init();
			curl_setopt_array($curl, array(
				CURLOPT_URL => "https://ssapi.shipstation.com/orders?orderNumber=$shipstation_order_number",
				CURLOPT_RETURNTRANSFER => true,
				CURLOPT_ENCODING => '',
				CURLOPT_MAXREDIRS => 10,
				CURLOPT_TIMEOUT => 0,
				CURLOPT_FOLLOWLOCATION => true,
				CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
				CURLOPT_SSL_VERIFYHOST => false,
				CURLOPT_SSL_VERIFYPEER => false,
				CURLOPT_CUSTOMREQUEST => 'GET',
				CURLOPT_HTTPHEADER => array(
					'Authorization: Basic YzAwMTliNjUzNWNkNDU1MWEyZTdkNTEyN2Q1MWNjNmM6NmE0M2U1Yjg5MDFiNDlmOWJiM2MzMzc2MDI4OGMzN2M=',
					'Content-Type: application/json'
				),
			));
			$response = curl_exec($curl);
			curl_close($curl);
			return json_decode($response)->orders[0];
		} catch (\Throwable $th) {
			cb_logger($th);
		}
	}

	/* quickbooks integration */
	public function qbCreateOrderPrefix($order_no = null, $payment_method = null)
	{
		cb_logger("payment_method" . $payment_method);
		$prefix = "";
		switch ($payment_method) {
			case 'PURCHASE ORDER':
				$prefix = "PO";
				break;
			case 'CARD':
				$prefix = "CC";
				break;
			case 'PAYPAL':
				$prefix = "PP";
				break;

			default:
				# code...
				break;
		}
		return "$prefix-$order_no";
	}


	public function qbGetItemParenRefId($payment_method = null)
	{
		try {
			cb_logger("qbGetItemParenRefId" . $payment_method);
			$parentRefId = '0';
			switch ($payment_method) {
				case 'PURCHASE ORDER':
					$parentRefId = '0';
					break;
				case 'CARD':
					$parentRefId = '180';
					break;
				case 'PAYPAL':
					$parentRefId = '190';
					break;

				default:
					# code...
					break;
			}
			return $parentRefId;
		} catch (\Throwable $th) {
			cb_logger("qbGetItemParenRefId=$th");
		}
	}

	public function qbGetItemDiscountRefId($payment_method = null)
	{
		try {
			cb_logger("qbGetItemDiscountRefId" . $payment_method);
			$discountRefId = '0';
			switch ($payment_method) {
				case 'PURCHASE ORDER':
					$discountRefId = '116';
					break;
				case 'CARD':
					$discountRefId = '192';
					break;
				case 'PAYPAL':
					$discountRefId = '262';
					break;

				default:
					# code...
					break;
			}
			return $discountRefId;
		} catch (\Throwable $th) {
			cb_logger("qbGetItemDiscountRefId=$th");
		}
	}

	public function getQbToken()
	{
		$secretsPath = './config/secrets_qb.json';
		$jsonString = file_get_contents($secretsPath);
		$jsonData = json_decode($jsonString, true);
		$token = $jsonData['access_token'];
		cb_logger("getQbToken=$token");
		return $token;
	}

	public function sendToQB()
	{
		try {

			/* start */
			$items = [];
			$dateToday = date("Y-m-d");
			$this_data = $this->shipCartData;
			$shipping_fee = $this_data['shippingAmount'];
			$payment_method = $this_data['paymentMethod'];
			$order_date = date("Y-m-d", strtotime($this_data['orderDate']));
			$discount = $this_data['discount'];
			cb_logger("data=" . json_encode($this_data));
			foreach ($this_data['items'] as $items_data) {

				$name = $items_data['name'];
				$unit_price = $items_data['unitPrice'];
				$quantity = $items_data['quantity'];
				$sku = $items_data['sku'];
				$item = [
					'Description' => $name,
					"DetailType" => "SalesItemLineDetail",
					'SalesItemLineDetail' => [
						"ItemRef" => [
							'value' => $this->qbQueryitemRefId($sku, $payment_method)
						],
						'Qty' => $quantity,
						'UnitPrice' => $this->num($unit_price)
					],
					"Amount" => $this->num($quantity * $this->num($unit_price))
				];
				$items[] = $item;
			}

			// shipping fee 
			$items[] = [
				'Description' => 'Shipping',
				"DetailType" => "SalesItemLineDetail",
				'SalesItemLineDetail' => [
					"ItemRef" => [
						'value' => "7"
					],
				],
				"Amount" => $shipping_fee
			];

			//discount
			if ($discount != "0.00") {
				$items[] = [
					"DetailType" => "SalesItemLineDetail",
					'SalesItemLineDetail' => [
						"ItemRef" => [
							'value' => $this->qbGetItemDiscountRefId($payment_method)
						],
					],
					"Amount" => $shipping_fee
				];
			}


			$json_data = json_encode($items);
			cb_logger("items=$json_data");
			$curl = curl_init();
			$data = [
				"ShipMethodRef" => [
					'value' => $this_data['requestedShippingService']
				],
				"SalesTermRef" => [
					'value' => "3"
				],
				"Line" => $items,
				"BillEmail" => [
					"Address" => $this_data['billTo']['email']
				],
				"ShipAddr" => [
					"Line1" => $this_data['shipTo']['street1'],
					"Line2" => $this_data['shipTo']['street2'],
					"Line3" => $this_data['shipTo']['postalCode'] . " " . $this_data['shipTo']['city'] . " " . $this_data['shipTo']['state'] . " " . $this_data['shipTo']['country'],

				],
				"EmailStatus" => "NotSet",
				"BillAddr" => [
					"Line1" => $this_data['billTo']['street1'],
					"Line2" => $this_data['billTo']['street2'],
					"Line3" => $this_data['billTo']['postalCode'] . " " . $this_data['billTo']['city'] . " " . $this_data['billTo']['state'] . " " . $this_data['billTo']['country'],
				],
				"CustomerRef" => [
					"name" => $this_data['shipTo']['name'],
					"value" => $this->qbQueryCustomerId()
				],
				"CustomField" => [
					[
						"DefinitionId" => "1",
						"StringValue" => !empty($this->purchaseOrderNumber) ? $this->purchaseOrderNumber : "",
						"Type" => "StringType"
					]
				],
				"ShipDate" => $order_date,
				"DueDate" => $order_date,
				"DocNumber" => $this->qbCreateOrderPrefix($this_data['orderNumber'], $payment_method),
			];

			/* end */

			$data = json_encode($data);

			cb_logger("payload=$data");
			curl_setopt_array($curl, array(
				CURLOPT_URL => 'https://quickbooks.api.intuit.com/v3/company/123146116133394/invoice?minorversion=73',
				CURLOPT_RETURNTRANSFER => true,
				CURLOPT_ENCODING => '',
				CURLOPT_MAXREDIRS => 10,
				CURLOPT_TIMEOUT => 0,
				CURLOPT_FOLLOWLOCATION => true,
				CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
				CURLOPT_CUSTOMREQUEST => 'POST',
				CURLOPT_SSL_VERIFYHOST => false,
				CURLOPT_SSL_VERIFYPEER => false,
				CURLOPT_POSTFIELDS => $data,
				CURLOPT_HTTPHEADER => array(
					'Accept: application/json',
					'Content-Type: application/json',
					"Authorization: Bearer " . $this->getQbToken()
				),
			));

			$response = curl_exec($curl);

			curl_close($curl);
			cb_logger("success=$response");
		} catch (\Throwable $th) {
			cb_logger($th);
		}
	}

	public function qbQueryCustomerEmail($email = null)
	{
		try {
			$curl = curl_init();

			curl_setopt_array($curl, array(
				CURLOPT_URL => "https://quickbooks.api.intuit.com/v3/company/123146116133394/query?query=select%20*%20from%20Customer%20Where%20PrimaryEmailAddr%20%3D%20%27$email%27&minorversion=73",
				CURLOPT_RETURNTRANSFER => true,
				CURLOPT_ENCODING => '',
				CURLOPT_MAXREDIRS => 10,
				CURLOPT_TIMEOUT => 0,
				CURLOPT_FOLLOWLOCATION => true,
				CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
				CURLOPT_CUSTOMREQUEST => 'GET',
				CURLOPT_SSL_VERIFYHOST => false,
				CURLOPT_SSL_VERIFYPEER => false,
				CURLOPT_HTTPHEADER => array(
					'Accept: application/json',
					"Authorization: Bearer " . $this->getQbToken()
				),
			));

			$response = curl_exec($curl);

			curl_close($curl);

			cb_logger("qbQueryCustomerEmailResponse=$response");

			return json_decode($response);
		} catch (\Throwable $th) {
			cb_logger($th);
		}
	}

	public function qbQueryCustomerName($name = null)
	{
		try {
			$name = rawurlencode($name);
			$curl = curl_init();
			curl_setopt_array($curl, array(
				CURLOPT_URL => "https://quickbooks.api.intuit.com/v3/company/123146116133394/query?query=select%20*%20from%20Customer%20Where%20DisplayName%3D%20%27$name%27&minorversion=73",
				CURLOPT_RETURNTRANSFER => true,
				CURLOPT_ENCODING => '',
				CURLOPT_MAXREDIRS => 10,
				CURLOPT_TIMEOUT => 0,
				CURLOPT_FOLLOWLOCATION => true,
				CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
				CURLOPT_CUSTOMREQUEST => 'GET',
				CURLOPT_SSL_VERIFYHOST => false,
				CURLOPT_SSL_VERIFYPEER => false,
				CURLOPT_HTTPHEADER => array(
					'Accept: application/json',
					"Authorization: Bearer " . $this->getQbToken()
				),
			));
			$response = curl_exec($curl);
			curl_close($curl);
			cb_logger("qbQueryCustomerName=$response");
			return json_decode($response);
		} catch (\Throwable $th) {
			cb_logger($th);
		}
	}

	public function qbQueryCustomerId()
	{
		try {
			$this_data = $this->shipCartData;
			$customerName  = $this_data["shipTo"]['name'];
			$customerEmail = $this_data["shipTo"]['shipping_email'];

			$queryEmail = $this->qbQueryCustomerEmail($customerEmail);
			if ($queryEmail->QueryResponse->Customer) {
				return $queryEmail->QueryResponse->Customer[0]->Id;
			}

			$queryCustomerName = $this->qbQueryCustomerName($customerName);
			if ($queryCustomerName->QueryResponse->Customer) {
				return $queryCustomerName->QueryResponse->Customer[0]->Id;
			}

			$qbCreateCustomerResponse = $this->qbCreateCustomer();

			$qbCustomerId = $qbCreateCustomerResponse->Customer->Id;
			cb_logger("qbId=$qbCustomerId");
			return $qbCustomerId;
		} catch (\Throwable $th) {
			cb_logger($th);
		}
	}

	public function qbCreateCustomer()
	{
		try {

			$this_data = $this->shipCartData;
			$name = explode(" ", $this_data["shipTo"]["name"]);
			$firstName = $name[0];
			$lastName = $name[1];
			$postData = [
				"FullyQualifiedName" =>  $this_data["shipTo"]["name"],
				"PrimaryEmailAddr" => [
					"Address" => $this_data["shipping_email"]
				],
				"DisplayName" => $this_data["shipTo"]["name"],
				"Suffix" => "",
				"Title" => "",
				"MiddleName" => "",
				"Notes" => "",
				"FamilyName" => $lastName,
				"PrimaryPhone" => [
					"FreeFormNumber" => $this_data["phone"]
				],
				"CompanyName" => "",
				"BillAddr" => [
					"CountrySubDivisionCode" => "",
					"City" => $this_data["shipTo"]["city"],
					"PostalCode" => $this_data["shipTo"]["postalCode"],
					"Line1" => $this_data["shipTo"]["street1"],
					"Country" => $this_data["shipTo"]["country"]
				],
				"GivenName" => $firstName
			];

			$curl = curl_init();

			curl_setopt_array($curl, array(
				CURLOPT_URL => 'https://quickbooks.api.intuit.com/v3/company/123146116133394/customer?minorversion=73',
				CURLOPT_RETURNTRANSFER => true,
				CURLOPT_ENCODING => '',
				CURLOPT_MAXREDIRS => 10,
				CURLOPT_TIMEOUT => 0,
				CURLOPT_FOLLOWLOCATION => true,
				CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
				CURLOPT_CUSTOMREQUEST => 'POST',
				CURLOPT_SSL_VERIFYHOST => false,
				CURLOPT_SSL_VERIFYPEER => false,
				CURLOPT_POSTFIELDS => json_encode($postData),
				CURLOPT_HTTPHEADER => array(
					'Accept: application/json',
					'Content-Type: application/json',
					"Authorization: Bearer " . $this->getQbToken()
				),
			));

			$response = curl_exec($curl);
			curl_close($curl);
			cb_logger("qbCreateCustomer=$response");
			$decode_data = json_decode($response);
			cb_logger("Id=" . $decode_data->Customer->Id);
			return $decode_data;
		} catch (\Throwable $th) {
			cb_logger($th);
		}
	}

	public function qbQueryitemRefId($sku = null, $payment_method = null)
	{
		try {
			/* 
			refId = 180 (ECOMMERCE SALES)
			refId = 190 (PAYPAL SALES)
			refId = 0 (PO)
			*/
			$parentRefId = $this->qbGetItemParenRefId($payment_method);
			$curl = curl_init();
			curl_setopt_array($curl, array(
				CURLOPT_URL => "https://quickbooks.api.intuit.com/v3/company/123146116133394/query?query=select%20*%20from%20Item%20where%20SKU%3D%27$sku%27%20and%20ParentRef%3D%27$parentRefId%27&minorversion=73",
				CURLOPT_RETURNTRANSFER => true,
				CURLOPT_ENCODING => '',
				CURLOPT_MAXREDIRS => 10,
				CURLOPT_TIMEOUT => 0,
				CURLOPT_FOLLOWLOCATION => true,
				CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
				CURLOPT_CUSTOMREQUEST => 'GET',
				CURLOPT_SSL_VERIFYHOST => false,
				CURLOPT_SSL_VERIFYPEER => false,
				CURLOPT_HTTPHEADER => array(
					'Accept: application/json',
					"Authorization: Bearer " . $this->getQbToken()
				),
			));
			$response = curl_exec($curl);
			curl_close($curl);
			cb_logger("qbQueryitemRefId=$response");
			return json_decode($response)->QueryResponse->Item[0]->Id;;
		} catch (\Throwable $th) {
			cb_logger($th);
		}
	}
}
