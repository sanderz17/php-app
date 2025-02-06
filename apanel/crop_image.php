<?php
	header('Content-Type: application/json');
	include("connect.php");

	if($_REQUEST['img'] == 'catimg')
	{
		$IMAGENM_SLUG 	= "_cat";
		$IMAGEPATH_T 	= CATEGORY_T;
		$IMAGEPATH_A 	= CATEGORY_A;

		$error		 = false;
		$absolutedir = dirname(__FILE__);
		$dir		 = $IMAGEPATH_A;
		$serverdir	 = $absolutedir.$dir;
		$tmp		 = explode(',',$_REQUEST['data']);
		$imgdata 	 = base64_decode($tmp[1]);
		$extension	 = strtolower(end(explode('.',$_REQUEST['name'])));

		if(isset($_SESSION['image_path']) && $_SESSION['image_path']!=""){
			unlink($IMAGEPATH_T.$_SESSION['image_path']);
		}
		$filename = time()."_".rand(1,9999999).$IMAGENM_SLUG.".".$extension;

		if ($_REQUEST['name'] != "") 
		{
			$_SESSION['image_path']=$filename;
			$handle	= fopen($IMAGEPATH_T.$filename,'w');
			fwrite($handle, $imgdata);
			fclose($handle);
			$response = array(
				"status" 	=> "success",
				"url" 		=> $IMAGEPATH_T.$filename.'?'.time(),
				"filename" 	=> $filename
			);
		}
	}

	else if($_REQUEST['img'] == 'prodimg')
	{
		$IMAGENM_SLUG 	= "_prod";
		$IMAGEPATH_T 	= PRODUCT_T;
		$IMAGEPATH_A 	= PRODUCT_A;

		$error		 = false;
		$absolutedir = dirname(__FILE__);
		$dir		 = $IMAGEPATH_A;
		$serverdir	 = $absolutedir.$dir;
		$tmp		 = explode(',',$_REQUEST['data']);
		$imgdata 	 = base64_decode($tmp[1]);
		$extension	 = strtolower(end(explode('.',$_REQUEST['name'])));

		if(isset($_SESSION['image_path']) && $_SESSION['image_path']!=""){
			unlink($IMAGEPATH_T.$_SESSION['image_path']);
		}
		$filename = time()."_".rand(1,9999999).$IMAGENM_SLUG.".".$extension;

		if ($_REQUEST['name'] != "") 
		{
			$_SESSION['image_path']=$filename;
			$handle	= fopen($IMAGEPATH_T.$filename,'w');
			fwrite($handle, $imgdata);
			fclose($handle);
			$response = array(
				"status" 	=> "success",
				"url" 		=> $IMAGEPATH_T.$filename.'?'.time(),
				"filename" 	=> $filename
			);
		}
	}

	else if($_REQUEST['img'] == 'rand_prodimg')
	{
		$IMAGENM_SLUG 	= "_rprod";
		$IMAGEPATH_T 	= PRODUCT_T;
		$IMAGEPATH_A 	= PRODUCT_A;

		$error		 = false;
		$absolutedir = dirname(__FILE__);
		$dir		 = $IMAGEPATH_A;
		$serverdir	 = $absolutedir.$dir;
		$tmp		 = explode(',',$_REQUEST['data']);
		$imgdata 	 = base64_decode($tmp[1]);
		$extension	 = strtolower(end(explode('.',$_REQUEST['name'])));

		if(isset($_SESSION['rand_image_path']) && $_SESSION['rand_image_path']!=""){
			unlink($IMAGEPATH_T.$_SESSION['rand_image_path']);
		}
		$filename = time()."_".rand(1,9999999).$IMAGENM_SLUG.".".$extension;

		if ($_REQUEST['name'] != "") 
		{
			$_SESSION['rand_image_path']=$filename;
			$handle	= fopen($IMAGEPATH_T.$filename,'w');
			fwrite($handle, $imgdata);
			fclose($handle);
			$response = array(
				"status" 	=> "success",
				"url" 		=> $IMAGEPATH_T.$filename.'?'.time(),
				"filename" 	=> $filename
			);
		}
	}
	else if($_REQUEST['img'] == 'prod_alt_img')
	{
		$IMAGENM_SLUG 	= "_prod_alt";
		$IMAGEPATH_T 	= PRODUCT_T;
		$IMAGEPATH_A 	= PRODUCT_A;

		$error		 = false;
		$absolutedir = dirname(__FILE__);
		$dir		 = $IMAGEPATH_A;
		$serverdir	 = $absolutedir.$dir;
		$tmp		 = explode(',',$_REQUEST['data']);
		$imgdata 	 = base64_decode($tmp[1]);
		$extension	 = strtolower(end(explode('.',$_REQUEST['name'])));

		if(isset($_SESSION['image_path']) && $_SESSION['image_path']!=""){
			unlink($IMAGEPATH_T.$_SESSION['image_path']);
		}
		$filename = time()."_".rand(1,9999999).$IMAGENM_SLUG.".".$extension;

		if ($_REQUEST['name'] != "") 
		{
			$_SESSION['image_path']=$filename;
			$handle	= fopen($IMAGEPATH_T.$filename,'w');
			fwrite($handle, $imgdata);
			fclose($handle);
			$response = array(
				"status" 	=> "success",
				"url" 		=> $IMAGEPATH_T.$filename.'?'.time(),
				"filename" 	=> $filename
			);
		}
	}
	else if($_REQUEST['img'] == 'clientimg')
	{
		$IMAGENM_SLUG 	= "_logo";
		$IMAGEPATH_T 	= CLIENT_T;
		$IMAGEPATH_A 	= CLIENT_A;

		$error		 = false;
		$absolutedir = dirname(__FILE__);
		$dir		 = $IMAGEPATH_A;
		$serverdir	 = $absolutedir.$dir;
		$tmp		 = explode(',',$_REQUEST['data']);
		$imgdata 	 = base64_decode($tmp[1]);
		$extension	 = strtolower(end(explode('.',$_REQUEST['name'])));

		if(isset($_SESSION['image_path']) && $_SESSION['image_path']!=""){
			unlink($IMAGEPATH_T.$_SESSION['image_path']);
		}
		$filename = time()."_".rand(1,9999999).$IMAGENM_SLUG.".".$extension;

		if ($_REQUEST['name'] != "") 
		{
			$_SESSION['image_path']=$filename;
			$handle	= fopen($IMAGEPATH_T.$filename,'w');
			fwrite($handle, $imgdata);
			fclose($handle);
			$response = array(
				"status" 	=> "success",
				"url" 		=> $IMAGEPATH_T.$filename.'?'.time(),
				"filename" 	=> $filename
			);
		}
	}

	else if($_REQUEST['img'] == 'review_img')
	{
		$IMAGENM_SLUG 	= "_rimg";
		$IMAGEPATH_T 	= HOME_T;
		$IMAGEPATH_A 	= HOME_A;

		$error		 = false;
		$absolutedir = dirname(__FILE__);
		$dir		 = $IMAGEPATH_A;
		$serverdir	 = $absolutedir.$dir;
		$tmp		 = explode(',',$_REQUEST['data']);
		$imgdata 	 = base64_decode($tmp[1]);
		$extension	 = strtolower(end(explode('.',$_REQUEST['name'])));

		if(isset($_SESSION['image_path']) && $_SESSION['image_path']!=""){
			unlink($IMAGEPATH_T.$_SESSION['image_path']);
		}
		$filename = time()."_".rand(1,9999999).$IMAGENM_SLUG.".".$extension;

		if ($_REQUEST['name'] != "") 
		{
			$_SESSION['image_path']=$filename;
			$handle	= fopen($IMAGEPATH_T.$filename,'w');
			fwrite($handle, $imgdata);
			fclose($handle);
			$response = array(
				"status" 	=> "success",
				"url" 		=> $IMAGEPATH_T.$filename.'?'.time(),
				"filename" 	=> $filename
			);
		}
	}

	else if($_REQUEST['img'] == 'dimension')
	{
		$IMAGENM_SLUG 	= "_dimn";
		$IMAGEPATH_T 	= PRODUCT_T;
		$IMAGEPATH_A 	= PRODUCT_A;

		$error		 = false;
		$absolutedir = dirname(__FILE__);
		$dir		 = $IMAGEPATH_A;
		$serverdir	 = $absolutedir.$dir;
		$tmp		 = explode(',',$_REQUEST['data']);
		$imgdata 	 = base64_decode($tmp[1]);
		$extension	 = strtolower(end(explode('.',$_REQUEST['name'])));

		if(isset($_SESSION['dimen_image_path']) && $_SESSION['dimen_image_path']!=""){
			unlink($IMAGEPATH_T.$_SESSION['dimen_image_path']);
		}
		$filename = time()."_".rand(1,9999999).$IMAGENM_SLUG.".".$extension;

		if ($_REQUEST['name'] != "") 
		{
			$_SESSION['dimen_image_path']=$filename;
			$handle	= fopen($IMAGEPATH_T.$filename,'w');
			fwrite($handle, $imgdata);
			fclose($handle);
			$response = array(
				"status" 	=> "success",
				"url" 		=> $IMAGEPATH_T.$filename.'?'.time(),
				"filename" 	=> $filename
			);
		}
	}

	else if($_REQUEST['img'] == 'exCategory')
	{
		$IMAGENM_SLUG 	= "_exCate";
		$IMAGEPATH_T 	= CATEGORY_T;
		$IMAGEPATH_A 	= CATEGORY_A;

		$error		 = false;
		$absolutedir = dirname(__FILE__);
		$dir		 = $IMAGEPATH_A;
		$serverdir	 = $absolutedir.$dir;
		$tmp		 = explode(',',$_REQUEST['data']);
		$imgdata 	 = base64_decode($tmp[1]);
		$extension	 = strtolower(end(explode('.',$_REQUEST['name'])));

		if(isset($_SESSION['cate_image_path']) && $_SESSION['cate_image_path']!=""){
			unlink($IMAGEPATH_T.$_SESSION['cate_image_path']);
		}
		$filename = time()."_".rand(1,9999999).$IMAGENM_SLUG.".".$extension;

		if ($_REQUEST['name'] != "") 
		{
			$_SESSION['cate_image_path']=$filename;
			$handle	= fopen($IMAGEPATH_T.$filename,'w');
			fwrite($handle, $imgdata);
			fclose($handle);
			$response = array(
				"status" 	=> "success",
				"url" 		=> $IMAGEPATH_T.$filename.'?'.time(),
				"filename" 	=> $filename
			);
		}
	}

	else if($_REQUEST['img'] == 'blogImg')
	{
		$IMAGENM_SLUG 	= "_blog";
		$IMAGEPATH_T 	= BLOG_T;
		$IMAGEPATH_A 	= BLOG_A;

		$error		 = false;
		$absolutedir = dirname(__FILE__);
		$dir		 = $IMAGEPATH_A;
		$serverdir	 = $absolutedir.$dir;
		$tmp		 = explode(',',$_REQUEST['data']);
		$imgdata 	 = base64_decode($tmp[1]);
		$extension	 = strtolower(end(explode('.',$_REQUEST['name'])));

		if(isset($_SESSION['image_path']) && $_SESSION['image_path']!=""){
			unlink($IMAGEPATH_T.$_SESSION['image_path']);
		}
		$filename = time()."_".rand(1,9999999).$IMAGENM_SLUG.".".$extension;

		if ($_REQUEST['name'] != "") 
		{
			$_SESSION['image_path']=$filename;
			$handle	= fopen($IMAGEPATH_T.$filename,'w');
			fwrite($handle, $imgdata);
			fclose($handle);
			$response = array(
				"status" 	=> "success",
				"url" 		=> $IMAGEPATH_T.$filename.'?'.time(),
				"filename" 	=> $filename
			);
		}
	}

	else if($_REQUEST['img'] == 'accessories_img')
	{
		$IMAGENM_SLUG 	= "_blog";
		$IMAGEPATH_T 	= ACCESSORIE_T;
		$IMAGEPATH_A 	= ACCESSORIE_A;

		$error		 = false;
		$absolutedir = dirname(__FILE__);
		$dir		 = $IMAGEPATH_A;
		$serverdir	 = $absolutedir.$dir;
		$tmp		 = explode(',',$_REQUEST['data']);
		$imgdata 	 = base64_decode($tmp[1]);
		$extension	 = strtolower(end(explode('.',$_REQUEST['name'])));

		if(isset($_SESSION['image_path']) && $_SESSION['image_path']!=""){
			unlink($IMAGEPATH_T.$_SESSION['image_path']);
		}
		$filename = time()."_".rand(1,9999999).$IMAGENM_SLUG.".".$extension;

		if ($_REQUEST['name'] != "") 
		{
			$_SESSION['image_path']=$filename;
			$handle	= fopen($IMAGEPATH_T.$filename,'w');
			fwrite($handle, $imgdata);
			fclose($handle);
			$response = array(
				"status" 	=> "success",
				"url" 		=> $IMAGEPATH_T.$filename.'?'.time(),
				"filename" 	=> $filename
			);
		}
	}

	print json_encode($response);
?>