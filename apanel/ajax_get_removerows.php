<?php

include("connect.php");
$db->checkAdminLogin();

// echo "<pre>";
// print_r($_REQUEST['rowid']);
// die;

$rows 	= array("isDelete" => "1");
$db->update("quote_detail", $rows, "id=".$_REQUEST['rowid']);

?>