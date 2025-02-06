<?php
require __DIR__ . '/phpMailer/Exception.php';
require __DIR__ . '/phpMailer/PHPMailer.php';
require __DIR__ . '/phpMailer/SMTP.php';
// Start with PHPMailer class
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
use PHPMailer\PHPMailer\SMTP;

class Notification
{
	public $cart;
	public $cart_id;
	private $recipients = [
		'Sales@clearballistics.com'
	];
	public $title;
	function __construct()
	{
	}

	function sendMail($cart_id, $sendTo, $subject = '', $template = null, $title = '')
	{
		try {
			switch ($template) {
				case 0:
					$subject = $title = 'Order Cancelled';
					break;
				case 1:
					return false;
					break;
				case 2:
					$subject = $title = 'New Order Confirmation';
					break;
				case 3:
					$subject = $title = 'Order Shipped';
					break;
				case 4:
					$subject = $title = 'Order Delivered';
					break;
				case 5:
					$subject = $title = 'Order Pending Payment';
					break;
				default:
					# code...
					break;
			}
			//Create an instance; passing `true` enables exceptions
			$mail = new PHPMailer(true);
			$this->recipients[] = $sendTo;
			//Server settings
			$mail->SMTPDebug = SMTP::DEBUG_OFF;                      		//Enable verbose debug output
			$mail->isSMTP();                                            //Send using SMTP
			$mail->Host = 'clearballistics.com';                  			//Set the SMTP server to send through
			$mail->SMTPAuth   = true;                                   //Enable SMTP authentication
			$mail->Username = 'cb_test_email@ballisticsguy.com';      //SMTP username
			$mail->Password = 'GpWD7Lsd&AAg';                           //SMTP password
			$mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;            //Enable implicit TLS encryption
			$mail->Port       = 465;                                    //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`

			//Recipients
			$mail->setFrom('cb_test_email@clearballistics.com', "Clear Ballistics Info");
			//Add a recipient
			foreach ($this->recipients as $recipient) {
				cb_logger($recipient);
				$mail->addAddress($recipient, '');
			}

			//Content
			$this->title = $title;
			$this->cart_id = $cart_id;
			$body = $this->buildTemplate($template);
			$mail->isHTML(true);                                  //Set email format to HTML
			$mail->Subject = $subject;
			$mail->Body    = $body;
			$mail->send();
			return true;
		} catch (Exception $e) {
			cb_logger($e);
		} finally {
			//return false;
		}
	}

	function buildTemplate($templateOrder)
	{
		$template = [
			'./include/email_templates/cancel_order.php',
			'./include/email_templates/complete_order.php',
			'./include/email_templates/order_status.php',
			'./include/email_templates/order_status.php',
			'./include/email_templates/order_status.php',
			'./include/email_templates/order_status.php',
		];
		ob_start();
		$this->cart_id;
		include($template[$templateOrder]);
		return ob_get_clean();
	}

	function getTitle()
	{
	}
}
