<?php
include "connect.php";

$cart_id = 0;

if (isset($_SESSION[SESS_PRE . '_SESS_CART_ID']) && $_SESSION[SESS_PRE . '_SESS_CART_ID'] > 0) {
  $cart_id = $_SESSION[SESS_PRE . '_SESS_CART_ID'];
  //unset($_SESSION[SESS_PRE.'_SESS_CART_ID']);
}

// $cart_data = $db->getData("cart_detail","*",$where);


$where = "cd.isDelete=0 AND p.isDelete=0 AND cd.cart_id=" . $cart_id;
$join = " LEFT JOIN product p ON p.id = cd.product_id";
$rows = "cd.price, cd.sub_total, cd.qty, cd.id, p.name, p.image, p.id as pro_id, p.code as product_sku";
$cart_data = $db->getJoinData2("cart_detail cd", $join, $rows, $where);
if (@mysqli_num_rows($cart_data) > 0) {
  while ($cart_row = mysqli_fetch_assoc($cart_data)) {
    $product_url = $db->getValue('product', 'slug', "product.id=" . $cart_row['pro_id']);

?>



    <table class="table ps-block__products">
      <tbody>
        <?php
        $cart_id = 0;

        if (isset($_SESSION[SESS_PRE . '_SESS_CART_ID']) && $_SESSION[SESS_PRE . '_SESS_CART_ID'] > 0) {
          $cart_id = $_SESSION[SESS_PRE . '_SESS_CART_ID'];
        }

        $where = "cd.isDelete=0 AND p.isDelete=0 AND cd.cart_id=" . $cart_id;
        $join = " LEFT JOIN product p ON p.id = cd.product_id";
        $rows = "cd.sub_total, cd.qty, cd.id, p.name, p.image,p.id as product_id";
        $cart_data = $db->getJoinData2("cart_detail cd", $join, $rows, $where);
        while ($cart_row = @mysqli_fetch_assoc($cart_data)) {
          $product_url = $db->getValue('product', 'slug', "product.id=" . $cart_row['product_id']);
        ?>
          <tr>
            <td class="border-top-0">
              <div class="media">
                <img class="align-self-start mr-3 p-3 rounded" src="<?php echo SITEURL . PRODUCT . $cart_row['image']; ?>"
                  alt="Generic placeholder image" width="100" style="background-color: #f1f1f1;">
                <div class="media-body">
                  <div class="pro-name">
                    <a href="/shop/<?php echo $product_url ?>" class="mt-0"><?php echo $cart_row['name']; ?>
                    </a>
                    <a class="pull-right" href="#" onclick="remove_cart(<?php echo $cart_row['id']; ?>);">Remove</a>
                  </div>
                  <div>
                    <div class="form-group--number count pt-2 ml-1">
                      <button class="up header-up" id="up_header">+</button>
                      <button class="down header-down" id="done_header">-</button>
                      <input class="form-control" type="text" placeholder="1" value="<?php echo $cart_row['qty']; ?>"
                        onchange="qty_update(this.value,'<?php echo $cart_row['id']; ?>','<?php echo $cart_row['pro_id']; ?>')">
                    </div>
                    <b class="pull-right pt-3"><?php echo CURR . $cart_row['sub_total']; ?></b>
                  </div>




                </div>
              </div>
            </td>
          </tr>
        <?php } ?>
      </tbody>
    </table>


  <?php
  }
} else {
  ?>
  <!-- 	<div class="container text-center">
    <h1>OPPPPS! YOUR CART IS EMPTY!</h1>
    <div class="banner-btn">
      <a href="<?php echo SITEURL; ?><?php echo $db->getValue("site_setting", "btn_link", "isDelete=0"); ?>" class="btn-regular">BUY NOW</a>
    </div>
  </div> -->
<?php
}
?>

<script type="text/javascript">
  $(document).ready(function() {
    // $('#done_header').click(function () {
    $('.header-down').click(function() {
      // alert("Down");
      var $input = $(this).parent().find('input');
      var count = parseInt($input.val()) - 1;
      count = count < 1 ? 1 : count;
      $input.val(count);
      $input.change();
      return false;
    });
    // $('#up_header').click(function () {
    $('.header-up').click(function() {
      // alert("Up");
      var $input = $(this).parent().find('input');
      $input.val(parseInt($input.val()) + 1);
      $input.change();
      return false;
    });
  });
  var sub_total = <?php echo $db->getValue("cart", "sub_total", "id=" . $cart_id); ?>;
  var free_gift = '';
  var image_float = ''
  var diff =  (300 - parseFloat(sub_total)).toFixed(2)
  $('#image').show();
  console.log(sub_total)
/*   if (sub_total >= '300' && sub_total <= '499.99') {
    free_gift = "You've Earned Free Yeti Rambler (20 oz Tumbler)";
    image_float ="<?php echo SITEURL; ?>/img/gift_item/Yeti-Tumbler_Clear.png"
  } else if (sub_total >= '500' && sub_total <= '999.99') {
    free_gift = "You've Earned Free FBI Block";
    image_float = "https://clearballistics.com/img/product/1712147489_8327123_prod.png"
  } else if (sub_total >= '1000') {
    free_gift = "You've Earned Free Yeti Roadie 24 Hard Cooler ";
    image_float = "<?php echo SITEURL; ?>/img/gift_item/Yeti-Roadie_Brighter.png"
  } else {
    $('#image').hide();
    free_gift = `Spend More $${diff} To Get Free Gift`
    console.log(diff)
  } */
  $("#p-subtotal").text("$" + sub_total);
  $("#p-free-gift").text(free_gift);
 /*  $('#image').attr('src', image_float); */
</script>