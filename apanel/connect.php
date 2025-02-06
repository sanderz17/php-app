<?php
	error_reporting(0);
	session_start();
	date_default_timezone_set('America/Los_Angeles');
	ini_set('default_charset', 'UTF-8');
	ini_set('max_execution_time', 0);
	ini_set('post_max_size', '80M');
	ini_set('upload_max_filesize', '80M');

	include("../include/define.php");
	include("../include/function.class.php");

	$db = new Admin();

	$bg_img = SITEURL."mailbody/images/bg1.jpg";
	$re = "margin:0 auto;background-image:url(".$bg_img.");background-repeat: no-repeat;background-size: cover; padding: 20px 20px; color: #404040; font-family: lato";
	// print_r("<pre>");
	// print_r($_SESSION);die();

	function cb_logger($log_msg)
	{
		try {
			$log_filename = "log";
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