<?php
try {
	include("connect.php");
	$last_login = date('Y-m-d H:i:s');
	$last_ip 	= $db->get_client_ip();
	$email 		= $db->clean($_POST['email']);
	$password 	= $db->clean($_POST['password']);

	if ($email != "" && $password != "" && !filter_var($email, FILTER_VALIDATE_EMAIL) === false) {
		cb_logger(ADMINURL);
		$rs_user = $db->getData(CTABLE_ADMIN, "*", "email = '" . $email . "' AND password = '" . md5($password) . "' AND isArchived=0");
		if (@mysqli_num_rows($rs_user) > 0) {
			$row_user = @mysqli_fetch_assoc($rs_user);

			if ($row_user['active_account'] == 1) {
				$_SESSION[SESS_PRE . '_ADMIN_SESS_ID'] = $row_user['id'];
				$_SESSION[SESS_PRE . '_ADMIN_SESS_NAME'] 	= $row_user['first_name'] . ' ' . $row_user['last_name'];

				$rows = array("last_login" => $last_login, "last_ip" => $last_ip);
				$db->update(CTABLE_ADMIN, $rows, "id=" . $row_user['id']);

				if (isset($_REQUEST['from']) && $_REQUEST['from'] != "") {
					$db->location($_REQUEST['from']);
					exit;
				} else {
					$_SESSION['MSG'] = 'Success_login';
					$db->location(ADMINURL . "dashboard/");
					exit;
				}
			} else {
				$_SESSION['MSG'] = 'Activate_account';
				$db->location(ADMINURL);
			}
		} else {
			$_SESSION['MSG'] = 'Invalid_Email_Password';
			$db->location(ADMINURL);
		}
	} else {
		$_SESSION['MSG'] = 'Something_Wrong';
		$db->location(ADMINURL);
	}
} catch (\Throwable $th) {
	//throw $th;
	cb_logger($th);
}
