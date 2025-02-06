<?php
include_once 'connect.php';

$theme_id = $db->getvalue("site_setting", "theme_id", "isDelete=0");
$theme_name = $db->getvalue("site_theme", "theme_name", "isDelete=0 AND id=" . $theme_id);

$theme_id = $theme_name;
// echo $theme;
// exit;
if (!empty($theme_id) && $theme_id != "") {
	$theme = $theme_id;
}
?>

<meta charset="UTF-8" />
<meta name="viewport" content="width=device-width, initial-scale=1.0">

<link rel="shortcut icon" href="<?php echo SITEURL; ?>img/favicon.png" />

<link rel="stylesheet" href="<?php echo SITEURL . $theme; ?>/css/bootstrap.css">
<link rel="stylesheet" href="<?php echo SITEURL . $theme; ?>/css/slick.css">
<link rel="stylesheet" href="<?php echo SITEURL . $theme; ?>/css/slick-theme.css">
<link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
<link href="<?php echo SITEURL . $theme; ?>/css/jquery.fancybox.min.css" rel="stylesheet">
<link rel="stylesheet" href="<?php echo SITEURL . $theme; ?>/css/font-awesome.css">
<link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-select/1.13.1/css/bootstrap-select.min.css">
<link href="https://cdnjs.cloudflare.com/ajax/libs/flag-icon-css/3.5.0/css/flag-icon.min.css" rel="stylesheet" type="text/css" />

<link rel="stylesheet" type="text/css" href="<?php echo SITEURL . $theme; ?>/css/style.css?=v310522">
<link rel="stylesheet" type="text/css" href="<?php echo SITEURL . $theme; ?>/css/mobile_menu.css">
<link rel="stylesheet" type="text/css" href="<?php echo SITEURL . $theme; ?>/css/slide-out-panel.css">
<!-- <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@700&display=swap" rel="stylesheet"> -->
<style>
	.quick-nav-buttons-m ul {
		list-style-type: none;
		display: -webkit-box;
		display: -ms-flexbox;
		display: flex;
		-ms-flex-wrap: nowrap;
		flex-wrap: nowrap;
		overflow: auto;
	}

	.quick-nav-buttons-m li {
		margin-right: 10px;
	}

	.quick-nav-buttons-m li a {
		border-width: 1px;
		font-size: .9rem;
		padding: .5rem 3rem;
		height: 40px;
		white-space: nowrap;
		text-transform: uppercase;
		font-family: stratum-web-med;
	}

	.btn-cb {
		color: #fff;
		background-color: #000e4a;
		border-color: #000e4a;
	}

	.btn-cb:hover {
		color: #000e4a;
		/* text-decoration: none; */
		background-color: #eeeeee;
	}
</style>