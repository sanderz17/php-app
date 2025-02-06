<?php
include("connect.php");
include("include/notification.class.php");



$question_input		= 	$db->clean($_REQUEST['question_input']);
$input_name 		= 	$db->clean($_REQUEST['input_name']);
$input_lastname 	= 	$db->clean($_REQUEST['input_lastname']);
$input_email 		= 	$db->clean($_REQUEST['input_email']);
$input_confirm 		= 	$db->clean($_REQUEST['input_confirm']);
$input_phone        =   $db->clean($_REQUEST['input_phone']);
$input_address      =   $db->clean($_REQUEST['input_address']);
$input_city         =   $db->clean($_REQUEST['input_city']);
$input_country      =   $db->clean($_REQUEST['input_country']);
$input_state        =   $db->clean($_REQUEST['input_state']);
$input_zip          =   $db->clean($_REQUEST['input_zip']);
$descr_ques         =   $db->clean($_REQUEST['descr_ques']);

if($input_name!="" && $input_lastname!="" && $input_email!=""& $input_phone!="")
	{
        // print_r($_REQUEST); exit;
        $rows 	= array(
            "today_query"  	=> $question_input,
            "firstname"		=> $input_name,
            "lastname"	    => $input_lastname,
            "email"         => $input_email,
            "number"        => $input_phone,
            "street_address"=> $input_address,
            "city"          => $input_city,
            "country"       => $input_country,
            "state"         => $input_state,
            "zip_code"      => $input_zip,
            "message"       => $descr_ques,
        );
        $uid = $db->insert('contact', $rows);
        if($uid!='')
        {
            if( ISMAIL )
            {
                $subject = 'Contact request sent successfully';
                $nt = new Notification();
                include("mailbody/contact_to_user.php");
                $toemail = $email;
                  //  die($toemail);
                $nt->sendEmail($toemail, $subject, $body);
            }

            $_SESSION['MSG'] = "Send Mail Successfully";
            $db->location(SITEURL."contact/");
        }
    }
    else
	{
		$_SESSION['MSG'] = 'FILL_ALL_DATA';
		$db->location(SITEURL."contact/");
	}
?>