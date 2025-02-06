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
	private $sales_email = 'sales@clearballistics.com';
	function __construct($db)
	{
		$this->cart = $db;
	}

	function sendMail($sendTo = null, $subject = '', $body = '')
	{
		//Create an instance; passing `true` enables exceptions
		$mail = new PHPMailer(true);
		try {
			//Server settings
			if (explode("@", $sendTo)[1] == "gmail.com") {
				$mail->SMTPDebug = SMTP::DEBUG_OFF;                      //Enable verbose debug output
				$mail->isSMTP();                                            //Send using SMTP
				$mail->Host = 'smtp.gmail.com';                  //Set the SMTP server to send through
				$mail->SMTPAuth   = true;                                   //Enable SMTP authentication
				$mail->Username = 'philip31th@gmail.com';                     //SMTP username
				$mail->Password = 'weeksagjwlrwrtcv';                            //SMTP password
				$mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;            //Enable implicit TLS encryption
				$mail->Port       = 587;                                 //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`
				$mail->setFrom('mailer@ballisticsguy.com', "Clear Ballistics Website");
				cb_logger("gmail address:$sendTo");
			} else {
				$mail->SMTPDebug = SMTP::DEBUG_OFF;                      //Enable verbose debug output
				$mail->isSMTP();                                            //Send using SMTP
				$mail->Host = 'mail.ballisticsguy.com';                  //Set the SMTP server to send through
				$mail->SMTPAuth   = true;                                   //Enable SMTP authentication
				$mail->Username = 'cb_test_email@ballisticsguy.com';                     //SMTP username
				$mail->Password = 'GpWD7Lsd&AAg';                            //SMTP password
				$mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;            //Enable implicit TLS encryption
				$mail->Port       = 465;
				// From
				$mail->setFrom('sales@clearballistics.com', "Clear Ballistics Website");
			}
			//Add a recipient
			$mail->addAddress($sendTo, '');
			//Content
			$body = $body;
			$mail->isHTML(true);                                  //Set email format to HTML
			$mail->Subject = $subject;
			$mail->Body    = $body;
			if ($mail->send()) {
				cb_logger("sendMail : Email sent!");
				return true;
			} else {
				return false;
			}

			//echo 'Message has been sent';
		} catch (Exception $e) {
			cb_logger("Message could not be sent. Mailer Error: {$mail->ErrorInfo}");
			return false;
		}
	}

	function sendMailWithTemplates($cart_id = null, $sendTo, $subject = '', $template = '')
	{
		try {
			//Content
			$this->cart_id = $cart_id;
			$body = $this->buildTemplate($template);
			$this->sendMail($sendTo, $subject, $body);
			$this->sendMail($this->sales_email, $subject, $body);
			$this->sendMail('cb_test_email@ballisticsguy.com', $subject, $body);
			cb_logger("email sent");
			return true;
			//echo 'Message has been sent';
		} catch (Exception $e) {
			cb_logger($e);
			return false;
		}
	}

	function sendMailWithTemplatesToCustomer($cart_id = null, $sendTo, $subject = '', $template = '')
	{
		try {
			//Content
			$this->cart_id = $cart_id;
			$body = $this->buildTemplate($template);
			$this->sendMail($sendTo, $subject, $body);
			$this->sendMail('cb_test_email@ballisticsguy.com', $subject, $body);
			cb_logger("email sent");
			return true;
			//echo 'Message has been sent';
		} catch (Exception $e) {
			cb_logger($e);
			return false;
		}
	}

	function buildTemplate($templateName)
	{
		$template = [
			'new_confirmation_order_template' => './include/email_templates/new_order_confirmation.php',
			'cancel_order_template' => './include/email_templates/cancel_order.php',
			'failed_order_template' => './include/email_templates/failed_order.php',
			'order_complete_template' => './include/email_templates/complete.php',
			'quotation_order_template' => './include/email_templates/quotation_order.php'
		];
		ob_start();
		$this->cart_id;
		include($template[$templateName]);
		return ob_get_clean();
	}
}
