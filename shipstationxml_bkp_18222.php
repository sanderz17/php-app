<?php
header("Content-Type: application/xml; charset=utf-8");
echo '<?xml version="1.0" encoding="UTF-8"?>';

include("connect.php");
$ctable = "cart";

$ctable_r = $db->getJoinData($ctable, 'user', 'user.id='.$ctable.'.customer_id', $ctable.'.*, user.first_name,user.last_name', "cart.isDelete=0 AND cart.id=18", $ctable.".id ASC ",0);

if(@mysqli_num_rows($ctable_r)>0){
  $count = 0;
  foreach ($ctable_r as $key => $ctable_d) {
    $count++;

    if($ctable_d['order_status']==2)
    {
      $order_status = "paid";
    }

    // shipping method
    $shipping_method = $db->getValue("shipping_method","name","id='".$ctable_d['shipping_method']."' ");

    // user data
    $user_email = $db->getValue("user","email","id='".$ctable_d['customer_id']."' ");

    // cart detail
    $where = "cd.isDelete=0 AND p.isDelete=0 AND cd.cart_id=".$ctable_d['id'];
    $join = " LEFT JOIN product p ON p.id = cd.product_id";
    $rows = "cd.price, cd.sub_total, cd.qty, cd.id, p.name, p.image, cd.product_id";
    $cart_data = $db->getJoinData2("cart_detail cd",$join,$rows,$where);

    if(@mysqli_num_rows($cart_data)>0)
    {
      // $cart_row = mysqli_fetch_assoc($cart_data);
        

      $items_arr = "";
      foreach ($cart_data as $cart_data_d){

          // echo "<pre>";
          // print_r($cart_data_d);
          // die;

        // $products_d = $db->getData("product","*","isDelete=0 AND id=".$cart_data_d['product_id'],"id DESC",0);

        // if(@mysqli_num_rows($products_d)>0)
        // {
        //   // $products_row_d = mysqli_fetch_assoc($products_d);

        //   foreach ($products_d as $products_row_d){

            if ($cart_data_d['image'] != "") 
            {
              $product_img = SITEURL."img/product/".$cart_data_d['image'];
            }
            else
            {
              $product_img = SITEURL."img/bi.jpeg";
            }

            $items_arr.= '
              <Item>
                <SKU><![CDATA[FD88821]]></SKU>
                <Name><![CDATA['.$cart_data_d['name'].']]></Name>
                <ImageUrl><![CDATA['.$product_img.']]></ImageUrl>
                <Weight>8</Weight>
                <WeightUnits>Ounces</WeightUnits>
                <Quantity>2</Quantity>
                <UnitPrice>'.$cart_data_d['price'].'</UnitPrice>
                <Location><![CDATA[A1-B2]]></Location>
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

        //   }
        // }
      }


    }

    echo '<Orders pages="'.$count.'">';
      echo '<Order>';
        echo '<OrderID><![CDATA['.$ctable_d['id'].']]></OrderID>';
        echo '<OrderNumber><![CDATA['.$ctable_d['order_no'].']]></OrderNumber>';
        echo '<OrderDate>'.date('m/d/Y g:i A', strtotime($ctable_d['order_date'])).'</OrderDate>';
        echo '<OrderStatus><![CDATA['.$order_status.']]></OrderStatus>';
        echo '<LastModified>'.date('m/d/Y g:i A', strtotime($ctable_d['updateDate'])).'</LastModified>';
        echo '<ShippingMethod><![CDATA['.$shipping_method.']]></ShippingMethod>';
        echo '<PaymentMethod><![CDATA[PayPal]]></PaymentMethod>';
        echo '<CurrencyCode>USD</CurrencyCode> ';
        echo '<OrderTotal>'.$ctable_d['grand_total'].'</OrderTotal>';
        echo '<TaxAmount>0.00</TaxAmount>';
        echo '<ShippingAmount>'.$ctable_d['shipping'].'</ShippingAmount>';
        echo '<CustomerNotes><![CDATA[Please make sure it gets here by Dec. 22nd!]]></CustomerNotes>';
        echo '<InternalNotes><![CDATA[Ship by December 18th via Priority Mail.]]></InternalNotes>';
        echo '<Gift>false</Gift>';
        echo '<GiftMessage></GiftMessage>';
        echo '<CustomField1></CustomField1>';
        echo '<CustomField2></CustomField2>';
        echo '<CustomField3></CustomField3>';
        echo '<Customer>';
          echo '<CustomerCode><![CDATA['.$user_email.']]></CustomerCode>';
          echo '<BillTo>';
            echo '<Name><![CDATA[The President]]></Name>';
            echo '<Company><![CDATA[US Govt]]></Company>';
            echo '<Phone><![CDATA[512-555-5555]]></Phone>';
            echo '<Email><![CDATA[customer@mystore.com]]></Email>';
          echo '</BillTo>';
          echo '<ShipTo>';
            echo '<Name><![CDATA[The President]]></Name>';
            echo '<Company><![CDATA[US Govt]]></Company>';
            echo '<Address1><![CDATA[1600 Pennsylvania Ave]]></Address1>';
            echo '<Address2></Address2>';
            echo '<City><![CDATA[Washington]]></City>';
            echo '<State><![CDATA[DC]]></State>';
            echo '<PostalCode><![CDATA[20500]]></PostalCode>';
            echo '<Country><![CDATA[US]]></Country>';
            echo '<Phone><![CDATA[512-555-5555]]></Phone>';
          echo '</ShipTo>';
        echo '</Customer>';
        echo '<Items>'.$items_arr;
        echo '</Items>';
      echo '</Order>';
    echo '</Orders>';

  }
}



?>