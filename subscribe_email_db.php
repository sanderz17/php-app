<?php
include("connect.php");
include_once "include/notification.class.php";
$subs_email = $_REQUEST['subs_email'];
// die('1');

$api_key = API_KEY;

if (!empty($subs_email) && ISMAIL) {
	// $nt = new Notification();
	// include('mailbody/subscribe_site.php');
	// $subject = SITETITLE.' Subscribed';
	// $toemail = $subs_email;
	// $nt->sendEmail($toemail,$subject,$body);

	// echo $toemail;

	// $email = 'EMAIL_ADDRESS';
	$list_id = AUDIENCE_ID;
	$api_key = API_KEY;
	$auth = base64_encode('user:' . $api_key);

	// server name followed by a dot. 
	// We use us17 because us17 is present in API KEY
	$server = 'us17.';

	$data = array(
		'email_address' => $subs_email,
		'status'        => 'subscribed',
		'tags'	=> array('Newsletter')
	);

	$json_data = json_encode($data);

	$data_center = substr($api_key, strpos($api_key, '-') + 1);

	$url = 'https://' . $data_center . '.api.mailchimp.com/3.0/lists/' . $list_id . '/members';
	// $url = 'https://'.$server.'api.mailchimp.com/3.0/lists/'.$list_id.'/members/';

	$curl = curl_init();
	curl_setopt($curl, CURLOPT_URL, $url);
	curl_setopt($curl, CURLOPT_HTTPHEADER, array(
		'Content-Type: application/json',
		'Authorization: Basic ' . $auth
	));
	curl_setopt($curl, CURLOPT_USERAGENT, 'PHP-MCAPI/2.0');
	curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
	curl_setopt($curl, CURLOPT_TIMEOUT, 10);
	curl_setopt($curl, CURLOPT_POST, true);
	curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
	curl_setopt($curl, CURLOPT_POSTFIELDS, $json_data);

	$result = curl_exec($curl);
	$httpcode = curl_getinfo($curl, CURLINFO_HTTP_CODE); // curl response code
	curl_close($curl);
	$res = json_decode($result);
	// print '<pre>'; print_r($res);
	//print $httpcode;

	if ($res->status == 'subscribed') {
		// echo "<p>THANK YOU ".$subs_email." HAS BEEN SUBSCRIBED</p>";
		echo "THANK YOU FOR SUBMITTING YOUR EMAIL ADDRESS ";
	} else {
		// echo $res->detail;
		echo $subs_email . " is already a subscribed";
	}

	// $json = json_encode([
	// 	'email_address' => $subs_email,
	// 	'status'        => 'subscribed', //pass status
	// ]);

	// try {
	// 	$ch = curl_init($url);
	// 	curl_setopt($ch, CURLOPT_USERPWD, 'user:' . $api_key);
	// 	curl_setopt($ch, CURLOPT_HTTPHEADER, ['Content-Type: application/json']);
	// 	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
	// 	curl_setopt($ch, CURLOPT_TIMEOUT, 10);
	// 	curl_setopt($ch, CURLOPT_POST, 1);
	// 	curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
	// 	curl_setopt($ch, CURLOPT_POSTFIELDS, $json);
	// 	$result = curl_exec($ch);
	// 	$status_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
	// 	curl_close($ch);

	// 	// echo " result ".$result."  status_code ".$status_code;
	// 	// print_r($result);
	// 	// die;

	// 	if (200 == $status_code) {
	// 		echo $subs_email;
	// 	}
	// } catch(Exception $e) {
	// 	echo $e->getMessage();
	// }
}

function getSubEmailAddress()
{
	try {
		$list_id = AUDIENCE_ID;
		$api_key = API_KEY;
		$auth = base64_encode('user:' . $api_key);

		$data_center = substr($api_key, strpos($api_key, '-') + 1);
		$url = 'https://' . $data_center . '.api.mailchimp.com/3.0/lists/' . $list_id . '/members?fields=members.email_address,members.full_name,members.id&count=10';
		$curl = curl_init();
		curl_setopt($curl, CURLOPT_URL, $url);
		curl_setopt($curl, CURLOPT_HTTPHEADER, array(
			'Content-Type: application/json',
			'Authorization: Basic ' . $auth
		));
		curl_setopt($curl, CURLOPT_USERAGENT, 'PHP-MCAPI/2.0');
		curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($curl, CURLOPT_TIMEOUT, 60);
		curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
		$result = curl_exec($curl);
		$httpcode = curl_getinfo($curl, CURLINFO_HTTP_CODE); // curl response code
		curl_close($curl);
		cb_logger($result);
		return $result;
	} catch (\Throwable $th) {
		cb_logger($th);
		throw new Error($th);
	}
}


?>
<?php
if (isset($_REQUEST['list'])) {
	$emailListData = json_decode(getSubEmailAddress(), true);
	//cb_logger(print_r($emailListData));
	/* 	$jsonData = json_decode($emailListData, true); */
?>
	<form action="" name="frm" id="frm" method="post">
		<input type="hidden" name="hdnmode" id="hdnmode" value="">
		<?php
		/* 			$db->getDeleteButton();
			$db->getAddButton($page, $ctable1); */
		?>
		<table id="example" class="table table-striped table-bordered table-colored mb-3">
			<thead>
				<tr>
					<th><input type="checkbox" name="chkall" id="chkall" onclick="javascript:check_all();"></th>
					<th>No.</th>
					<th>Name</th>
					<th>Email</th>
				</tr>
			</thead>
			<tbody>
				<?php
				try {

					if (@count($emailListData) > 0) {
						$count = 0;
						foreach ($emailListData['members'] as $email) {
							cb_logger(json_encode($email));
							$count++;
				?>
							<tr>
								<td><input type="checkbox" name="chkid[]" value="<?php echo $email['id']; ?>"></td>
								<td><?php echo $count; ?></td>
								<td><?php echo $email['full_name']; ?></td>
								<td><?php echo $email['email_address']; ?></td>
							</tr>
				<?php
						}
					}
				} catch (\Throwable $th) {
					cb_logger($th);
					throw $th;
				}
				?>
			</tbody>
		</table>
		<?php
			$db->getDeleteButton();
			$db->getAddButton($page, $ctable1);
			$db->getTablePaginationBlock($pagiArr);	
		?>
		<br />
	</form>

<?php }; ?>