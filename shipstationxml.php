<?php
header("Content-Type: application/xml; charset=utf-8");
echo '<?xml version="1.0" encoding="UTF-8"?>';

include("connect.php");
$ctable = "cart";

$ctable_r = $db->getJoinData($ctable, 'user', 'user.id='.$ctable.'.customer_id', $ctable.'.*, user.first_name,user.last_name', "cart.isDelete=0 AND cart.id=5", $ctable.".id ASC ",0);

if(@mysqli_num_rows($ctable_r)>0){
  $count = 0;
  foreach ($ctable_r as $key => $ctable_d) {
    $count++;

    if($ctable_d['order_status']==0)
    {
      $order_status = "cancelled";
    }
    if($ctable_d['order_status']==1)
    {
      $order_status = "on_hold";
    }
    if($ctable_d['order_status']==2)
    {
      $order_status = "shipped";
    }
    if($ctable_d['order_status']==3)
    {
      $order_status = "paid";
    }
    if($ctable_d['order_status']==4)
    {
      $order_status = "shipped";
    }

    // shipping method
    $shipping_method = $db->getValue("shipping_method","name","id='".$ctable_d['shipping_method']."' ");

    // user data
    // $user_email = $db->getValue("user","email","id='".$ctable_d['customer_id']."' ");
    $user_tbl_r = $db->getData("user","*","id='".$ctable_d['customer_id']."' ");
    $user_tbl_d = mysqli_fetch_assoc($user_tbl_r);
    $user_email = $user_tbl_d['email'];

    // billing and shipping
    $billing_shipping_tbl_r = $db->getData("billing_shipping","*","user_id='".$ctable_d['customer_id']."' AND cart_id=5 ");
    $billing_shipping_tbl_d = mysqli_fetch_assoc($billing_shipping_tbl_r);
    $billing_first_name     = $billing_shipping_tbl_d['billing_first_name'];
    $billing_last_name      = $billing_shipping_tbl_d['billing_last_name'];
    $billing_phone          = $billing_shipping_tbl_d['billing_phone'];

    $shipping_first_name    = $billing_shipping_tbl_d['shipping_first_name'];
    $shipping_last_name     = $billing_shipping_tbl_d['shipping_last_name'];
    $shipping_address       = $billing_shipping_tbl_d['shipping_address'];
    $shipping_address2      = $billing_shipping_tbl_d['shipping_address2'];
    $shipping_city          = $billing_shipping_tbl_d['shipping_city'];
    $shipping_state         = $db->getValue("states","name","id='".$billing_shipping_tbl_d['shipping_state']."' ");
    $shipping_zipcode       = $billing_shipping_tbl_d['shipping_zipcode'];
    $shipping_country       = $db->getValue("country","name","id='".$billing_shipping_tbl_d['shipping_country']."' ");
    $shipping_phone         = $billing_shipping_tbl_d['shipping_phone'];

    // cart detail
    $where = "cd.isDelete=0 AND p.isDelete=0 AND cd.cart_id=".$ctable_d['id'];
    $join = " LEFT JOIN product p ON p.id = cd.product_id";
    $rows = "cd.price, cd.sub_total, cd.qty, cd.id, p.name, p.image, cd.product_id";
    $cart_data = $db->getJoinData2("cart_detail cd",$join,$rows,$where);

    if(@mysqli_num_rows($cart_data)>0)
    {
      $items_arr = "";
      foreach ($cart_data as $cart_data_d){

        if ($cart_data_d['image'] != "") 
        {
          $product_img = SITEURL."img/product/".$cart_data_d['image'];
        }
        else
        {
          $product_img = SITEURL."img/bi.jpeg";
        }

        if ($cart_data_d['quantity'] != 0) {
          $quantity = $cart_data_d['quantity'];
        }
        else{
          $quantity = 0;
        }

        $items_arr.= '
          <Item>
            <SKU><![CDATA['.$cart_data_d['id'].']]></SKU>
            <Name><![CDATA['.$cart_data_d['name'].']]></Name>
            <ImageUrl><![CDATA['.$product_img.']]></ImageUrl>
            <Quantity>'.$quantity.'</Quantity>
            <UnitPrice>'.$cart_data_d['price'].'</UnitPrice>
            <Options>
              <Option>
                <Name><![CDATA[Size]]></Name>
                <Value><![CDATA[Large]]></Value>
                <Weight>10</Weight>
              </Option>
              <Option>
                <Name><![CDATA[Color]]></Name>
                <Value><![CDATA[Green]]></Value>
                <Weight>5</Weight>
              </Option>
            </Options>
          </Item>
        ';
      }
    }

    echo '<Orders pages="'.$count.'">';
      echo '<Order>';
        echo '<OrderID><![CDATA['.$ctable_d['id'].']]></OrderID>';
        echo '<OrderNumber><![CDATA['.$ctable_d['order_no'].']]></OrderNumber>';
        echo '<OrderDate>'.date('m/d/Y g:i A', strtotime($ctable_d['order_date'])).'</OrderDate>';
        echo '<OrderStatus><![CDATA['.$order_status.']]></OrderStatus>';
        echo '<LastModified>'.date('m/d/Y g:i A', strtotime($ctable_d['updateDate'])).'</LastModified>';
        echo '<ShippingMethod><![CDATA[UPS]]></ShippingMethod>';
        echo '<PaymentMethod><![CDATA[PayPal]]></PaymentMethod>';
        echo '<CurrencyCode>USD</CurrencyCode> ';
        echo '<OrderTotal>'.$ctable_d['grand_total'].'</OrderTotal>';
        echo '<TaxAmount>0.00</TaxAmount>';
        echo '<ShippingAmount>'.$ctable_d['shipping'].'</ShippingAmount>';
        echo '<CustomerNotes><![CDATA[test]]></CustomerNotes>';
        echo '<InternalNotes><![CDATA[test]]></InternalNotes>';
        echo '<Customer>';
          echo '<CustomerCode><![CDATA['.$user_email.']]></CustomerCode>';
          echo '<BillTo>';
            echo '<Name><![CDATA['.$billing_first_name.' '.$billing_last_name.']]></Name>';
            echo '<Phone><![CDATA['.$billing_phone.']]></Phone>';
            echo '<Email><![CDATA['.$user_email.']]></Email>';
          echo '</BillTo>';
          echo '<ShipTo>';
            echo '<Name><![CDATA['.$shipping_first_name.' '.$shipping_last_name.']]></Name>';
            echo '<Address1><![CDATA['.$shipping_address.']]></Address1>';
            echo '<Address2>'.$shipping_address2.'</Address2>';
            echo '<City><![CDATA['.$shipping_city.']]></City>';
            echo '<State><![CDATA['.$shipping_state.']]></State>';
            echo '<PostalCode><![CDATA['.$shipping_zipcode.']]></PostalCode>';
            echo '<Country><![CDATA['.$shipping_country.']]></Country>';
            echo '<Phone><![CDATA['.$shipping_phone.']]></Phone>';
          echo '</ShipTo>';
        echo '</Customer>';
        echo '<Items>'.$items_arr;
        echo '</Items>';
      echo '</Order>';
    echo '</Orders>';

  }
}

?>