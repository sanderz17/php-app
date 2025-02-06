<?php
error_reporting(0);
//error_reporting(E_ALL);
session_start();
date_default_timezone_set('America/Los_Angeles');
ini_set('default_charset', 'UTF-8');
ini_set('max_execution_time', 0);
ini_set('post_max_size', '80M');
ini_set('upload_max_filesize', '80M');

include("include/define.php");
include("include/function.class.php");

$db = new Cart();


$get_site_setting_d = $db->getData("site_setting", "*", "isDelete=0");
$get_site_setting_r = mysqli_fetch_assoc($get_site_setting_d);


$tommorow_date = date('Y-m-d', strtotime(' +7 day'));
$today_date = date('Y-m-d');
$theme_date = date('Y-m-d', (strtotime($get_site_setting_r['theme_date'])));

if ($theme_date == $today_date) {
	$current_theme = $get_site_setting_r['theme_id'];
	$new_theme = $db->getValue("site_theme", "id", "isDelete=0 AND Id > " . $current_theme . " ORDER BY Id ASC LIMIT 1");
	if (!empty($new_theme) && $new_theme != "") {
		$change_arr = array(
			"theme_id" => $new_theme,
			"theme_date" => $tommorow_date,
		);
		$db->update("site_setting", $change_arr, "id=1");
	} else {
		$starter_theme = $db->getValue("site_theme", "id", "isDelete=0 AND Id > 0 ORDER BY Id ASC LIMIT 1");
		$change_arr = array(
			"theme_id" => $starter_theme,
			"theme_date" => $tommorow_date,
		);
		$db->update("site_setting", $change_arr, "id=1");
	}
}

function cb_logger($log_msg)
{
	try {
		$log_msg = is_array($log_msg) ? json_encode($log_msg) : $log_msg;
		$log_filename = dirname(__FILE__) . '/log';;
		if (!file_exists($log_filename)) {
			// create directory/folder uploads.
			mkdir($log_filename, 0777, true);
		}
		$log_file_data = $log_filename . '/log_' . date('d-M-Y') . '.log';
		file_put_contents($log_file_data, $log_msg . "\n", FILE_APPEND);
	} catch (\Throwable $th) {
		throw $th;
	}
}
?>