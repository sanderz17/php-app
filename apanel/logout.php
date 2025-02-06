<?php
	include("connect.php");
	//session_unset();
	session_destroy();
	$db->location(ADMINURL);
	exit;
?>