<?php 
	if($_SERVER['HTTP_HOST'] == 'localhost' || $_SERVER['HTTP_HOST'] == 'localhost:8080' || $_SERVER['HTTP_HOST'] == 'pc-11' || $_SERVER['HTTP_HOST'] == '192.168.0.129'){

	    $Protocol = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS']!=='off' || $_SERVER['SERVER_PORT']==443) ? "https://" : "http://";
		
	    $SITEURL = $Protocol.$_SERVER['HTTP_HOST']."/";
	    $ADMINURL = $Protocol.$_SERVER['HTTP_HOST']."/apanel/";
	}
	else 
	{
	    $Protocol = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS']!=='off' || $_SERVER['SERVER_PORT']==443) ? "https://" : "http://";
		
	    $SITEURL = $Protocol.$_SERVER['HTTP_HOST']."/";
	    $ADMINURL = $Protocol.$_SERVER['HTTP_HOST']."/apanel/";
	}       
		
	define('SITEURL', $SITEURL);
	define('ADMINURL', $ADMINURL);
	define('SITENAME','ClearBallistics');
	define('SITETITLE','Clear Ballistics');
	define('ADMINTITLE','Clear Ballistics Admin');
	define('CURR','&dollar;');				
?>