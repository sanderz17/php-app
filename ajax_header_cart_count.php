<?php
    include "connect.php";

    $cart_id = 0;

    if( isset($_SESSION[SESS_PRE.'_SESS_CART_ID']) && $_SESSION[SESS_PRE.'_SESS_CART_ID'] > 0 )
    {
        $cart_id = $_SESSION[SESS_PRE.'_SESS_CART_ID'];
    }

    echo $total_header_cart = $db->getValue("cart_detail","IFNULL(SUM(qty), 0)","cart_id=".$_SESSION[SESS_PRE.'_SESS_CART_ID']." AND isDelete = 0");

?>


<script type="text/javascript">
    $(document).ready(function() {
    	// var total_header_cart = <?php echo $total_header_cart; ?>

        // alert(total_header_cart);

        // $("#total_header_cart").text(total_header_cart);
        // $("#total_header_cart").html(total_header_cart);
    });
</script>