<?php
class Functions 
{
	/** Local Database Detail **/
  
	protected $db_l_host = "127.0.0.1";
	protected $db_l_user = "root";
	protected $db_l_pass = "password";
	protected $db_l_name = "clearballistics";
	//protected $db_l_socket = "/var/mysql/mysql.sock";
	
	/** Stagging Database Detail **/
	
	protected $db_host = "localhost";
	protected $db_user = "root";
	protected $db_pass = 'abcABC123';
	protected $db_name = "clearballistics"; 
		
	protected $con = false; 
	public $myconn; 

	function __construct() {
		global $myconn;

		if($_SERVER['HTTP_HOST'] == 'localhost' || $_SERVER['HTTP_HOST'] == 'pc-11' || $_SERVER['HTTP_HOST'] == '192.168.0.129'){ 

			$myconn = @mysqli_connect($this->db_l_host,$this->db_l_user,$this->db_l_pass,$this->db_l_name);
		} else {
			$myconn = @mysqli_connect($this->db_host,$this->db_user,$this->db_pass,$this->db_name);
		}
		
		if (mysqli_connect_errno()){
			echo "Failed to connect to MySQL: " . mysqli_connect_error();die;
		}
	}
	
	public function getData($table, $rows = '*', $where = null, $order = null, $die=0) // Select Query, $die==1 will print query
	{
		
		$results = array();
		$q = 'SELECT '.$rows.' FROM '.$table;
		if($where != null)
			$q .= ' WHERE '.$where;
		if($order != null)
			$q .= ' ORDER BY '.$order;
		if($die==1){ echo $q;die; }
		//echo $q . '<br />';
		cb_logger('functionGetDataWhere'.$where);
		if($this->tableExists($table))
		{			
			if(@mysqli_num_rows(mysqli_query($GLOBALS['myconn'],$q))>0){
				mysqli_query($GLOBALS['myconn'], "SET NAMES 'utf8'");
				$results = @mysqli_query($GLOBALS['myconn'],$q);
				return $results;
			}else{
				return false;
			}
		}
		else{
			return false;
		}
	}
	
	public function getValue($table, $row=null, $where=null, $die=0) // single records ref HB function
	{
		global $myconn;
		if($this->tableExists($table) && $row!=null && $where!=null)
		{
			$strquery = 'SELECT '.$row.' FROM '.$table.' WHERE '.$where;
			//echo $strquery . '<br /><br />';
			if($die==1){ echo $strquery;die; }
			cb_logger('getValue= '.$strquery);
			$rs = $myconn->query($strquery);
			if($rs->num_rows>0){
				$results = $rs->fetch_assoc();
				return $results[$row];
			}else{
				return false;
			}
		}
		else{
			return false;
		}
 	}
	
	public function getMaxVal($table, $row=null, $where=null, $die=0)
	{
		if($this->tableExists($table) && $row!=null && $where!=null)
		{
			$q = 'SELECT MAX('.$row.') as '.$row.' FROM '.$table.' WHERE '.$where;
			if($die==1){
				echo $q;die;
			}
			if(mysqli_num_rows(mysqli_query($GLOBALS['myconn'],$q))>0){
				$results = @mysqli_fetch_assoc(mysqli_query($GLOBALS['myconn'],$q));
				return $results[$row];
			}else{
				return 0;
			}
		}
		else{
			return 0;
		}
	}
	public function getMinVal($table, $row=null, $where=null, $die=0)
	{
		if($this->tableExists($table) && $row!=null && $where!=null)
		{
			$q = 'SELECT MIN('.$row.') as '.$row.' FROM '.$table.' WHERE '.$where;
			if($die==1){
				echo $q;die;
			}
			if(mysqli_num_rows(mysqli_query($GLOBALS['myconn'],$q))>0){
				$results = @mysqli_fetch_assoc(mysqli_query($GLOBALS['myconn'],$q));
				return $results[$row];
			}else{
				return 0;
			}
		}
		else{
			return 0;
		}
	}
	
	public function getSumVal($table, $row=null, $where=null, $die=0)
	{
		if($this->tableExists($table) && $row!=null && $where!=null)
		{
			$q = 'SELECT SUM('.$row.') as '.$row.' FROM '.$table.' WHERE '.$where;
			if($die==1){
				echo $q;die;
			}
			if(mysqli_num_rows(mysqli_query($GLOBALS['myconn'],$q))>0){
				$results = @mysqli_fetch_assoc(mysqli_query($GLOBALS['myconn'],$q));
				return $results[$row];
			}else{
				return 0;
			}
		}
		else{
			return 0;
		}
	}
	
	public function getAvgVal($table, $row=null, $where=null, $die=0)
	{
		if($this->tableExists($table) && $row!=null && $where!=null)
		{
			$q = 'SELECT AVG('.$row.') as '.$row.' FROM '.$table.' WHERE '.$where;
			if($die==1){
				echo $q;die;
			}
			if(mysqli_num_rows(mysqli_query($GLOBALS['myconn'],$q))>0){
				$results = @mysqli_fetch_assoc(mysqli_query($GLOBALS['myconn'],$q));
				return $results[$row];
			}else{
				return 0;
			}
		}
		else{
			return 0;
		}
	}

	public function getFieldType($table, $row=null, $where=null, $die=0)
	{
		global $myconn;
		$rstable = array();
		//if($this->tableExists($table) && $row!=null)
		if($this->tableExists($table) )
		{
			//$strquery = 'SELECT * FROM '.$table.' WHERE '.$where;
			$strquery = 'SHOW FIELDS FROM '.$table;
			if($die==1){
				echo $strquery;die;
			}
			$rs = $myconn->query($strquery);
			if($rs->num_rows > 0){
				while( $results = $rs->fetch_assoc() )
				{
					//print '<pre>'; print_r($results);
					if( !is_null($row) )
					{
						if( $results['Field'] == $row )
						{
							//echo '<br />' . $results['Field']  . '==' . $row ;
							//echo ' Match';
							return $results['Type'];
						}
					}
					else {
						array_push($rstable, $results);
					}
				}
				return $rstable;
			}else{
				return 0;
			}
		}
		else{
			return 0;
		}
	}
		
	public function getTotalRecord($table, $where = null,$orderBy = null, $die=0) // return number of records
	{
		$q = 'SELECT * FROM '.$table;
		if($where != null)
			$q .= ' WHERE '.$where;
		if(!empty($orderBy)){
			$q .=" order by $orderBy";
		}
		if($die==1){
			echo $q;die;
		}
		if($this->tableExists($table))
			return mysqli_num_rows(mysqli_query($GLOBALS['myconn'],$q))+0;
		else
			return 0;
	}
	
	public function getTotalRecord_JoinData2($table, $join, $where = null, $die=0) // return number of records
	{
		$results = array();
		$q = 'SELECT * FROM '.$table. $join;
		if($where != null)
			$q .= ' WHERE '.$where;
		if($die==1){ echo $q;die; }
		return mysqli_num_rows(mysqli_query($GLOBALS['myconn'],$q))+0;
	}
	
	public function insert($table, $rows, $die=0) // MMinsert - Insert and Die Values 
    {	
    	//print_r($rows);
		global $myconn;
			try {
			cb_logger('trycatchinserting....'.$table);
			if($this->tableExists($table))
			{		
				cb_logger('insert table exist');
				$insert = 'INSERT INTO '.$table.' SET ';
				$keys = array_keys($rows);

				for($i = 0; $i < count($rows); $i++)
				{
					if(is_string($rows[$keys[$i]]))
					{
						$insert .= $keys[$i].'="'.$rows[$keys[$i]].'"';
					}
					else
					{
						$insert .= $keys[$i].'='.$rows[$keys[$i]];
					}
					if($i != count($rows)-1)
					{
						$insert .= ',';
					}
				}
				//echo $insert . '<br /><br />';

				if($die==1){
					echo $insert;die;
				}
				$ins = @mysqli_query($GLOBALS['myconn'],$insert);           
				if($ins)
				{
					cb_logger('insert true');
					$last_id = mysqli_insert_id($GLOBALS['myconn']);
					cb_logger('last_id'.$last_id);
					//die($last_id);
					return $last_id;
					
				}
				else
				{
				cb_logger($insert);
				cb_logger('insert false');
				cb_logger("error=".mysqli_error($GLOBALS['myconn']));
				return false;
				}
			}

		} catch (\Throwable $th) {
			cb_logger('problem with inserting....');
		}
    }
	
	public function delete($table, $where = null, $die=0)
	{
		if($this->tableExists($table))
		{
			if($where != null)
			{
				$delete = 'DELETE FROM '.$table.' WHERE '.$where;
				cb_logger($delete);
				if($die==1){
					echo $delete;die;
				}
				$del = @mysqli_query($GLOBALS['myconn'],$delete);
			}
			if($del)
			{
				return true;
			}
			else
			{
			   return false;
			}
		}
		else
		{
			return false;
		}
	}
    public function update($table, $rows, $where, $die=0) //update query
	{
		try {
			cb_logger('update');
			if($this->tableExists($table))
			{
				// Parse the where values
				// even values (including 0) contain the where rows
				// odd values contain the clauses for the row
				//print_r($where);die;
				
				$update = 'UPDATE '.$table.' SET ';
				$keys = array_keys($rows);
				for($i = 0; $i < count($rows); $i++)
				{
					if(is_string($rows[$keys[$i]]))
					{
						$update .= $keys[$i].'="'.$rows[$keys[$i]].'"';
					}
					else
					{
						$update .= $keys[$i].'='.$rows[$keys[$i]];
					}
					
					// Parse to add commas
					if($i != count($rows)-1)
					{
						$update .= ',';
					}
				}
				$update .= ' WHERE '.$where;

				//echo $update . '<br /><br />';
				cb_logger($update);
				if($die==1){
					echo $update;die;
				}
				//$update = trim($update," AND");
				$query = @mysqli_query($GLOBALS['myconn'],$update);
				if($query)
				{
					cb_logger('update success.');
					return true;
				}
				else
				{
					cb_logger('update failed.');
					return false;
				}
			}
			else
			{
				return false;
			}
		} catch (\Throwable $th) {
			cb_logger('update problem..');
			cb_logger($th);
		}
	}
	
	public function tableExists($table)
	{
		return true;
	}
	
	public function limitChar($content, $limit, $url="javascript:void(0);", $txt="&hellip;")
	{
		if(strlen($content)<=$limit){
			return $content;
		}else{
			$ans = substr($content,0,$limit);
			if($url!=""){
				$ans .= "<a href='$url' class='desc'>$txt</a>";
			}else{
				$ans .= "&hellip;";
			}
			return $ans;
		}
	}
	
	public function dupCheck($table, $where = null, $die=0) // Duplication Check
	{
		$q = 'SELECT id FROM '.$table;
		if($where != null)
			$q .= ' WHERE '.$where;
		if($die==1){ echo $q;die; }
		if($this->tableExists($table))
		{
			$results = @mysqli_num_rows(mysqli_query($GLOBALS['myconn'],$q));
			if($results>0){
				return true;
			}else{
				return false;
			}
		}
		else
			return false;
	}
	
	public function location($redirectPageName=null) // Location
	{
		if($redirectPageName==null){
			header("Location:".$this->SITEURL);
			exit;
		}else{
			header("Location:".$redirectPageName);
			exit;
		}
	}
	
	public function getDisplayOrder($table, $where=null, $die=0) // Display Order
	{
		$q = 'SELECT MAX(display_order) as display_order FROM '.$table;
		if($where != null)
			$q .= ' WHERE '.$where;
		if($die==1){
			echo $q;die;
		}
		if($this->tableExists($table))
		{
			$results = @mysqli_query($GLOBALS['myconn'],$q);
			if(@mysqli_num_rows($results)>0){
				$disp_d = mysqli_fetch_assoc($results);
				return intval($disp_d['display_order'])+1;
			}else{
				return 1;
			}
		}
		else{
			return 1;
		}
	}
	
	public function createSlug($string)    // Slug
	{   
		$slug = strtolower(trim(preg_replace('/-{2,}/','-',preg_replace('/[^a-zA-Z0-9-]/', '-', $string)),"-"));
		return $slug;
	}
	
	public function num($val, $deci="2", $sep=".", $thousand_sep=""){
		$price = number_format($val, $deci, $sep, $thousand_sep);
		$price = preg_replace('/\.00/', '', $price);
		return $price;
	}
	
	public function get_client_ip(){
		$ipaddress = '';
		if (getenv('HTTP_CLIENT_IP'))
			$ipaddress = getenv('HTTP_CLIENT_IP');
		else if(getenv('HTTP_X_FORWARDED_FOR'))
			$ipaddress = getenv('HTTP_X_FORWARDED_FOR');
		else if(getenv('HTTP_X_FORWARDED'))
			$ipaddress = getenv('HTTP_X_FORWARDED');
		else if(getenv('HTTP_FORWARDED_FOR'))
			$ipaddress = getenv('HTTP_FORWARDED_FOR');
		else if(getenv('HTTP_FORWARDED'))
			$ipaddress = getenv('HTTP_FORWARDED');
		else if(getenv('REMOTE_ADDR'))
			$ipaddress = getenv('REMOTE_ADDR');
		else
			$ipaddress = 'UNKNOWN';
		  
		return $ipaddress;
	}
	
	public function getReview($pid,$p=true)
	{
		$total_review 	= $this->getTotalRecord("product_review","pid = '".$pid."'");
		$avg_rate 		= 20*intval($this->getAvgVal("product_review","rate","id = '".$pid."'"));
		?>
		<div class="ratings">
			<div class="rating-box">
				<div style="width:<?php echo $avg_rate; ?>%" class="rating"></div>
			</div>
			<?php if($p){ ?>
			<p class="rating-links">
				<a href="javascript:void(0);"><?php echo $total_review; ?> Review(s)</a> <span class="separator">|</span> <a href="javascript:void(0);" onClick="rBC();">Add Your Review</a> 
			</p>
			<?php } ?>
		</div>
		<?php
	}
	
	public function clean($string)
	{
		$string = trim($string);			// Trim empty space before and after
		//if(get_magic_quotes_gpc()) {
			$string = stripslashes($string);	// Stripslashes
		//}
		$string = mysqli_real_escape_string($GLOBALS['myconn'],$string);	// mysqli_real_escape_string
		return $string;
	}
	function rpconvertYoutube($string) {
		return preg_replace(
			"/\s*[a-zA-Z\/\/:\.]*youtu(be.com\/watch\?v=|.be\/)([a-zA-Z0-9\-_]+)([a-zA-Z0-9\/\*\-\_\?\&\;\%\=\.]*)/i",
			"<iframe width=\"100%\" height=\"250\" src=\"//www.youtube.com/embed/$2\" allowfullscreen frameborder=\"0\"></iframe>",
			$string
		);
	}
	
	public function checkLogin($url=""){
		if(!isset($_SESSION[SESS_PRE.'_SESS_USER_ID']) || $_SESSION[SESS_PRE.'_SESS_USER_ID']==""){
			$_SESSION[SESS_PRE.'_FAIL_LOG'] = "1";
			if($url==""){
				$_SESSION['backUrl'] = "http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
				$this->location(SITEURL.'login/');
			}else{
				$this->location($url);
			}
		}
	}
	
	public function CheckoutLogin($url=""){
		if(!isset($_SESSION[SESS_PRE.'_SESS_USER_ID']) || $_SESSION[SESS_PRE.'_SESS_USER_ID']==""){
			$_SESSION[SESS_PRE.'_FAIL_LOG'] = "1";
			if($url==""){
				$_SESSION['backUrl'] = "http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
				$this->location(SITEURL.'checkout-login/');
			}else{
				$this->location($url);
			}
		}
	}
	
	public function checkNotLogin($url=""){
		if(isset($_SESSION[SESS_PRE.'_SESS_USER_ID']) || $_SESSION[SESS_PRE.'_SESS_USER_ID']!=""){
			$_SESSION[SESS_PRE.'_FAIL_LOG'] = "1";
			if($url==""){
				$_SESSION['backUrl'] = "http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
				$this->location(SITEURL);
			}else{
				$this->location($url);
			}
		}
	}
	public function checkAdminLogin($url=""){
	// print_r($_SESSION[SESS_PRE.'_ADMIN_SESS_ID']."test");die();

		if(!isset($_SESSION[SESS_PRE.'_ADMIN_SESS_ID']) || $_SESSION[SESS_PRE.'_ADMIN_SESS_ID']==""){
			if($url==""){
				$_SESSION['adminbackUrl'] = "http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
				$this->location(ADMINURL);
			}else{
				$this->location($url);
			}
		}
    }
	
	public function printr($val, $isDie=1){
		echo "<pre>";
		print_r($val);
		if($isDie){die;}
	}

	public function CheckRemember(){
		if(isset($_COOKIE['SESS_COOKIE']) && $_COOKIE['SESS_COOKIE']>0){
			$_SESSION[SESS_PRE.'_SESS_USER_ID']=$_COOKIE['SESS_COOKIE'];
		}
	}

	public function Date($date, $format="m/d/Y H:i A"){
		return date_format(date_create($date),$format);
	}

	function paginate_function($item_per_page, $current_page, $total_records, $total_pages)
	{
		$pagination = '';
		if($total_pages > 0 && $total_pages != 1 && $current_page <= $total_pages){ //verify total pages and current page number
			$pagination .= '<div class="gallery-pagination">';
			$pagination .= '<div class="gallery-pagination-inner">';
			$pagination .= '<ul class="all_pages_list">';
			
			$right_links    = $current_page + 3; 
			$previous       = $current_page - 3; //previous link 
			$next           = $current_page + 1; //next link
			$previous_new   = $current_page - 1; //next link
			$first_link     = true; //boolean var to decide our first link
			
			if($current_page > 1){
				$previous_link = ($previous_new==0 || $previous_new==-1)? 1: $previous_new;
				$pagination .= '<li class="first"><a class="pagination-prev" href="#" data-page="1" title="First"><<</a></li>'; //first link
				$pagination .= '<li><a class="pagination-prev" href="#" data-page="'.$previous_link.'" title="Previous"><</a></li>'; //previous link
					for($i = ($current_page-2); $i < $current_page; $i++){ //Create left-hand side links
						if($i > 0){
							$pagination .= '<li><a href="#" data-page="'.$i.'" title="Page'.$i.'">'.$i.'</a></li>';
						}
					}   
				$first_link = false; //set first link to false
			}
			
			if($first_link){ //if current active page is first link
				$pagination .= '<li class="first active"><a href="javascript:void(0);">'.$current_page.'</a></li>';
			}elseif($current_page == $total_pages){ //if it's the last active link
				$pagination .= '<li class="last active"><a href="javascript:void(0);">'.$current_page.'</a></li>';
			}else{ //regular current link
				$pagination .= '<li class="active"><a href="javascript:void(0);">'.$current_page.'</a></li>';
			}
					
			for($i = $current_page+1; $i < $right_links ; $i++){ //create right-hand side links
				if($i<=$total_pages){
					$pagination .= '<li><a href="#" data-page="'.$i.'" title="Page '.$i.'">'.$i.'</a></li>';
				}
			}
			if($current_page < $total_pages){ 
					$next_link = ($i > $total_pages) ? $total_pages : $i;
					$pagination .= '<li><a class="pagination-next" href="#" data-page="'.$next.'" title="Next">></a></li>'; //next link
					$pagination .= '<li class="last"><a class="pagination-next" href="#" data-page="'.$total_pages.'" title="Last">>></a></li>'; //last link
			}
			
			$pagination .= '</ul>'; 
			$pagination .= '</div>'; 
			$pagination .= '</div>';
		}
		return $pagination; //return pagination links
	}
	public function paginate_function_front($item_per_page, $current_page, $total_records, $total_pages)
	{
		$pagination = '';
		if($total_pages > 0 && $total_pages != 1 && $current_page <= $total_pages){ //verify total pages and current page number
			$right_links    = $current_page + 3; 
			$previous       = $current_page - 3; 
			$next           = $current_page + 1; 
			$first_link     = true; 

			if($current_page > 1){
				$previous_link = ($previous<=0)?1:$previous;
				$pagination .= '<li class="paginate_button "><a href="#" aria-controls="datatable1" data-page="1" title="First">&laquo;</a></li>'; //first link
				$pagination .= '<li class="paginate_button "><a href="#" aria-controls="datatable1" data-page="'.$previous_link.'" title="Previous">&lt;</a></li>'; //previous link
					for($i = ($current_page-2); $i < $current_page; $i++){ //Create left-hand side links
						if($i > 0){
							$pagination .= '<li class="paginate_button "><a href="#"  data-page="'.$i.'" aria-controls="datatable1" title="Page'.$i.'">'.$i.'</a></li>';
						}
					}   
				$first_link = false; //set first link to false
			}
			
			if($first_link){ //if current active page is first link
				$pagination .= '<li class="paginate_button active"><a aria-controls="datatable1">'.$current_page.'</a></li>';
			}elseif($current_page == $total_pages){ //if it's the last active link
				$pagination .= '<li class="paginate_button active"><a aria-controls="datatable1">'.$current_page.'</a></li>';
			}else{ //regular current link
				$pagination .= '<li class="paginate_button active"><a aria-controls="datatable1">'.$current_page.'</a></li>';
			}
			
			for($i = $current_page+1; $i < $right_links ; $i++){ //create right-hand side links
				if($i<=$total_pages){
					$pagination .= '<li class="paginate_button "><a href="#" aria-controls="datatable1" data-page="'.$i.'" title="Page '.$i.'">'.$i.'</a></li>';
				}
			}

			if($current_page < $total_pages){ 
				$next_link = ($i > $total_pages)? $total_pages : $i;
				$pagination .= '<li class="paginate_button "><a href="#" aria-controls="datatable1" data-page="'.$next_link.'" title="Next">&gt;</a></li>'; //next link
				$pagination .= '<li class="paginate_button "><a href="#" aria-controls="datatable1" data-page="'.$total_pages.'" title="Last">&raquo;</a></li>'; //last link
			}
		}
		return $pagination; //return pagination links
	}
	
	public function getJoinData($table1, $table2, $join_on, $rows = '*',$where = null, $order = null, $die=0) // Select Query, $die==1 will print query
	{
		global $myconn;
		$results = array();
		$strquery = 'SELECT '.$rows.' FROM '.$table1.' LEFT JOIN '.$table2.' ON '.$join_on;
		if($where != null)
			$strquery .= ' WHERE '.$where;
		if($order != null)
			$strquery .= ' ORDER BY '.$order;
		if($die==1){ echo $strquery; die; }
		cb_logger($strquery);
		$rs = $myconn->query($strquery);
		if(mysqli_num_rows(mysqli_query($GLOBALS['myconn'],$strquery))>0){
			$results = @mysqli_query($GLOBALS['myconn'],$strquery);
			return $results;
		}else{
			return false;
		}
	}
	
	public function getJoinData2($table, $join, $rows = '*', $where = null, $order = null,$die=0) // Select Query, $die==1 will print query
	{
		$results = array();
		$q = 'SELECT '.$rows.' FROM '.$table. $join;
		if($where != null)
			$q .= ' WHERE '.$where;
		if($order != null)
			$q .= ' ORDER BY '.$order;
		//echo $q;
		if($die==1){ echo $q;die; }
		if(mysqli_num_rows(mysqli_query($GLOBALS['myconn'],$q))>0){
			$results = @mysqli_query($GLOBALS['myconn'],$q);
			return $results;
		}else{
			return false;
		}
	} 	
	
	public function GetNotificationTxt($ntype1, $ntype){
		return constant($ntype);
	}

	public function generateRandomString($length = 10, $include_date = true) {
		$characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
		$charactersLength = strlen($characters);
		$randomString = '';
		for ($i = 0; $i < $length; $i++) {
			$randomString .= $characters[rand(0, $charactersLength - 1)];
		}

		if( $include_date )
		{
			//$randomString .= '-'.date('YmdHis');
			$randomString .= '-'.time();
		}
		return $randomString;
	}
	
	public function getStar($star)
	{
		if($star=='0.5')
		{
			return 'detail-rating-half';
		} else if($star=='1')
		{
			return 'detail-rating-1';
		} else if($star=='1.5')
		{
			return 'detail-rating-half-1';

		} else if($star=='2')
		{
			return 'detail-rating-2';

		} else if($star=='2.5')
		{
			return 'detail-rating-half-2';

		} else if($star=='3')
		{
			return 'detail-rating-3';

		} else if($star=='3.5')
		{
			return 'detail-rating-half-3';

		} else if($star=='4')
		{
			return 'detail-rating-4';

		} else if($star=='4.5')
		{
			return 'detail-rating-half-4';

		} else if($star=='5')
		{
			return 'detail-rating-5';

		}

	}

	public function get_lat_long($address){

		$address = str_replace(" ", "+", $address);

		$json = file_get_contents("http://maps.google.com/maps/api/geocode/json?address=$address&sensor=false&key=AIzaSyAUQcF7ZrTLD1IUQ9UQErTGhpxQjz_x6ys");
		$json = json_decode($json);
		print_r($json);die();
		$lat = $json->{'results'}[0]->{'geometry'}->{'location'}->{'lat'};
		$long = $json->{'results'}[0]->{'geometry'}->{'location'}->{'lng'};
		return $lat.','.$long;
	}

/*	public function generate_user_plan($user_id, $condition_id=1)
	{
		// set the table used to store CONDITION data
		$table = '';
		if( $condition_id == 1 )
		{
			$table = 'menopause_profile';
		}

		// get all the fields from the table used to store CONDITION data
		//$arfields = $this->getFieldType($table);
		//print '<pre>'; print_r($arfields);

		//foreach ($arfields as $field) {

			//if( $field['Field'] == 'symptoms' )
			{
			/*	// get the question details for the field
				$question = $this->getData('question', '*', 'field_name="' . $field['Field'] . '"');
				$question_id = $question['id'];		******

				// get symptoms
				//$symptoms = $this->getValue($table, $field['Field'], 'user_id=' . (int) $user_id);
				$symptoms = $this->getValue($table, 'symptoms', 'user_id=' . (int) $user_id);
				$arsymptoms = explode(',', $symptoms);

				//print 'aaa   '; print_r($symptoms); print '<br />';

				// get symptom therapies
				$sym_therapies = '';
				$arsym_therapies = $this->getData('symptom_therapy', 'DISTINCT therapy_id', 'symptom_id IN (' . $symptoms . ')');
				//foreach ($arsym_therapies as $therapy) {
				while($therapy = @mysqli_fetch_assoc($arsym_therapies)) {
					$sym_therapies .= $therapy['therapy_id'] . ',';
				}
				if( strlen($sym_therapies) > 0 )
					$sym_therapies = rtrim($sym_therapies, ',');
				//print 'bbb    '; print_r($sym_therapies); print '<br />';

				// get selected therapy method
				$approach = $this->getValue($table, 'approach', 'user_id=' . (int) $user_id);
				$user_approach = $this->getValue('answer', 'answer', 'id=' . (int) $approach);
				//print 'approach = ' . $approach . ' ====  user_approach' . $user_approach . '<br />';

				$medical = 0;
				$complementary = 0;

				$condition = 'id IN ('.$sym_therapies.')';
				if( stristr($user_approach, 'medical') === TRUE )
				{	
					$medical = 1;
					$condition .= ' AND isMedical=' . $medical;
				}
				else if( stristr($user_approach, 'complementary') === TRUE )
				{
					$complementary = 1;
					$condition .= ' AND isComplementary=' . $complementary;
				}
				/*else
				{
					$medical = 1;
					$complementary = 1;
				}**********

				//print 'Medical = ' . $medical . '  ====   complementary = ' . $complementary . '<br />';

				$condition .= ' AND isArchived=0';

				// filter therapies and get final therapies comparing symptom therapies and selected therapy methods
				$final_therapy = '';
				//$arfinal_therapy = $this->getData('therapy', 'id', 'id IN ('.$sym_therapies.') AND isMedical=' . $medical . ' AND isComplementary=' . $complementary . ' AND isArchived=0');
				$arfinal_therapy = $this->getData('therapy', 'id', $condition);
				//foreach ($arfinal_therapy as $therapy) {
				while($therapy = @mysqli_fetch_assoc($arfinal_therapy)) {
					$final_therapy .= $therapy['id'] . ',';
				}
				$arfinal_therapy = explode(',', $final_therapy);

				if( strlen($final_therapy) > 0 )
					$final_therapy = rtrim($final_therapy, ',');
				//print 'ccc <pre>'; print_r($arfinal_therapy); print '<br />';

				// get suggestions which have selected symptoms and therapies
				foreach ($arsymptoms as $symptom) 
				{
					foreach ($arfinal_therapy as $therapy) 
					{
						$arsuggestion = $this->getData('therapy_suggestion', 'suggestion_id', 'symptom_id=' . $symptom . ' AND therapy_id=' . $therapy);						

						//foreach ($arsuggestion as $suggestion) 
						while($suggestion = @mysqli_fetch_assoc($arsuggestion)) 
						{
							$rows = array(
									'user_id' => (int) $user_id, 
									'condition_id' => $condition_id, 
									'suggestion_id' => $suggestion['suggestion_id'],
								);
							$check_dupli = (int) $this->getValue('user_plan', 'id', 'user_id=' . (int) $user_id . ' AND suggestion_id=' . (int) $suggestion['suggestion_id'] . ' AND condition_id=' . (int) $condition_id . ' AND isArchived=0' );
							if( $check_dupli > 0 )
								$this->update('user_plan', $rows, 'id=' . (int) $check_dupli);
							else
								$this->insert('user_plan', $rows);
						}
					}
				}
			}
		//}
			//exit;
	} 	*/

	public function generate_user_plan($user_id, $condition_id=1)
	{
		// set the table used to store CONDITION data
		$table = '';
		if( $condition_id == 1 )
		{
			$table = 'menopause_profile';
		}

		// get all the fields from the table used to store CONDITION data
		//$arfields = $this->getFieldType($table);
		//print '<pre>'; print_r($arfields);

		//foreach ($arfields as $field) {

			//if( $field['Field'] == 'symptoms' )
			{
			/*	// get the question details for the field
				$question = $this->getData('question', '*', 'field_name="' . $field['Field'] . '"');
				$question_id = $question['id'];		*/

				// get symptoms
				//$symptoms = $this->getValue($table, $field['Field'], 'user_id=' . (int) $user_id);
				$symptoms = $this->getValue($table, 'symptoms', 'user_id=' . (int) $user_id);
				$arsymptoms = explode(',', $symptoms);

				//print 'aaa   '; print_r($symptoms); print '<br />';

				// get symptom therapies
				$sym_therapies = '';
				$arsym_therapies = $this->getData('symptom_therapy', 'DISTINCT therapy_id', 'symptom_id IN (' . $symptoms . ')');
				//foreach ($arsym_therapies as $therapy) {
				while($therapy = @mysqli_fetch_assoc($arsym_therapies)) {
					$sym_therapies .= $therapy['therapy_id'] . ',';
				}
				if( strlen($sym_therapies) > 0 )
					$sym_therapies = rtrim($sym_therapies, ',');
				//print 'bbb    '; print_r($sym_therapies); print '<br />';

				// get selected therapy method
				$approach = $this->getValue($table, 'approach', 'user_id=' . (int) $user_id);
				$user_approach = $this->getValue('answer', 'answer', 'id=' . (int) $approach);
				//print 'approach = ' . $approach . ' ====  user_approach = ' . $user_approach . '<br />';

				$medical = 0;
				$complementary = 0;

				$condition = 'id IN ('.$sym_therapies.')';
				$main_condition = '';

				// medical, complementary, holistic
				//echo '===' . stristr($user_approach, 'medical') . '===';
				//if( stristr($user_approach, 'medical') === TRUE )
				if( strtolower(stristr($user_approach, 'medical')) == 'medical' )
				{	
					$medical = 1;
					$condition .= ' AND isMedical=' . $medical;
					$main_condition .= ' AND isMedical=' . $medical;
				}
				else if( strtolower(stristr($user_approach, 'complementary')) == 'complementary' )
				{
					$complementary = 1;
					$condition .= ' AND isComplementary=' . $complementary;
					$main_condition .= ' AND isComplementary=' . $complementary;
				}

				// medication
				$medication = 0;
				$med_ans_id = $this->getValue($table, 'medication', 'user_id=' . (int) $user_id);
				$medication = $this->getValue('answer', 'answer', 'id=' . (int) $med_ans_id);
				$medication = strtolower(trim($medication));
				if( strtolower(stristr($medication, 'yes')) == 'yes' )
					$medication = 1;
				else
					$medication = 0;
				$main_condition .= ' AND FIND_IN_SET('.$medication.', medication)';

				// smoke
				$smoke = 0;
				$smk_ans_id = $this->getValue($table, 'smoke', 'user_id=' . (int) $user_id);
				$smoke = $this->getValue('answer', 'answer', 'id=' . (int) $smk_ans_id);
				$smoke = strtolower(trim($smoke));
				if( strtolower(stristr($smoke, 'yes')) == 'yes' )
					$smoke = 1;
				else
					$smoke = 0;
				$main_condition .= ' AND FIND_IN_SET('.$smoke.', smoker)';

				// caffeine
				$caffeine = 1;
				$caf_ans_id = $this->getValue($table, 'caffeine', 'user_id=' . (int) $user_id);
				$caffeine = $this->getValue('answer', 'answer', 'id=' . (int) $caf_ans_id);
				$caffeine = strtolower(trim($caffeine));
				//echo '====' . $caffeine . '<br />';
				if( strtolower(stristr($caffeine, "i don't drink caffeine")) == "i don't drink caffeine" )
					$caffeine = 0;
				else
					$caffeine = 1;
				//echo '====' . $caffeine . '<br />';

				//if( $caffeine == 1 )
					$main_condition .= ' AND FIND_IN_SET('.$caffeine.', caffeine)';

				// alcohol
				$alcohol = 1;
				$alco_ans_id = $this->getValue($table, 'alcohol', 'user_id=' . (int) $user_id);
				$alcohol = $this->getValue('answer', 'answer', 'id=' . (int) $alco_ans_id);
				$alcohol = strtolower(trim($alcohol));

				//echo '====' . $alcohol . '<br />';
				if( strtolower(stristr($alcohol, "i don't drink alcohol")) == "i don't drink alcohol" )
					$alcohol = 0;
				else
					$alcohol = 1;
				//echo '====' . $alcohol . '<br />';

				//if( $alcohol == 1 )
					$main_condition .= ' AND FIND_IN_SET('.$alcohol.', alcohol)';

				// HRT Risk (tried_treatments)
				$hrt = 0;
				$hrt_ans_id = $this->getValue($table, 'tried_treatments', 'user_id=' . (int) $user_id);
				$rshrt = $this->getData('answer', 'answer', 'id IN (' . $hrt_ans_id . ')');
				$hrt = array();
				while( $rowhrt = @mysqli_fetch_assoc($rshrt) )
					array_push($hrt, strtolower($rowhrt['answer']));
				if( in_array('hrt', $hrt) )
					$hrt = 1;
				else
					$hrt = 0;
				$main_condition .= ' AND FIND_IN_SET('.$hrt.', hrt_risk)';

				//print 'Medical = ' . $medical . '  ====   complementary = ' . $complementary . '<br />';

				$condition .= ' AND isArchived=0';

				// filter therapies and get final therapies comparing symptom therapies and selected therapy methods
				$final_therapy = '';
				//$arfinal_therapy = $this->getData('therapy', 'id', 'id IN ('.$sym_therapies.') AND isMedical=' . $medical . ' AND isComplementary=' . $complementary . ' AND isArchived=0');
				$arfinal_therapy = $this->getData('therapy', 'id', $condition);
				//foreach ($arfinal_therapy as $therapy) {
				while($therapy = @mysqli_fetch_assoc($arfinal_therapy)) {
					$final_therapy .= $therapy['id'] . ',';
				}
				$arfinal_therapy = explode(',', $final_therapy);

				if( strlen($final_therapy) > 0 )
					$final_therapy = rtrim($final_therapy, ',');
				//print 'ccc <pre>'; print_r($arfinal_therapy); print '<br />';

				// get suggestions which have selected symptoms and therapies
			/*	foreach ($arsymptoms as $symptom) 
				{
					foreach ($arfinal_therapy as $therapy) 
					{
						$arsuggestion = $this->getData('therapy_suggestion', 'suggestion_id', 'symptom_id=' . $symptom . ' AND therapy_id=' . $therapy);						

						//foreach ($arsuggestion as $suggestion) 
						while($suggestion = @mysqli_fetch_assoc($arsuggestion)) 
						{
							$rows = array(
									'user_id' => (int) $user_id, 
									'condition_id' => $condition_id, 
									'suggestion_id' => $suggestion['suggestion_id'],
								);
							$check_dupli = (int) $this->getValue('user_plan', 'id', 'user_id=' . (int) $user_id . ' AND suggestion_id=' . (int) $suggestion['suggestion_id'] . ' AND condition_id=' . (int) $condition_id . ' AND isArchived=0' );
							if( $check_dupli > 0 )
								$this->update('user_plan', $rows, 'id=' . (int) $check_dupli);
							else
								$this->insert('user_plan', $rows);
						}
					}
				}	*/

				$arsuggestion = array();
				foreach ($arsymptoms as $symptom) 
				{
					$rssuggestion = $this->getData('symptom_suggestion', 'suggestion_id', 'symptom_id=' . $symptom . ' AND isArchived=0');						

					//foreach ($rssuggestion as $suggestion) 
					while($suggestion = @mysqli_fetch_assoc($rssuggestion)) 
					{
						if( !in_array($suggestion['suggestion_id'], $arsuggestion) )
							array_push($arsuggestion, $suggestion['suggestion_id']);
						/*$rows = array(
								'user_id' => (int) $user_id, 
								'condition_id' => $condition_id, 
								'suggestion_id' => $suggestion['suggestion_id'],
							);
						$check_dupli = (int) $this->getValue('user_plan', 'id', 'user_id=' . (int) $user_id . ' AND suggestion_id=' . (int) $suggestion['suggestion_id'] . ' AND condition_id=' . (int) $condition_id . ' AND isArchived=0' );
						if( $check_dupli > 0 )
							$this->update('user_plan', $rows, 'id=' . (int) $check_dupli);
						else
							$this->insert('user_plan', $rows);*/
					}
				}

				$strsuggestion = implode(',', $arsuggestion);

				$rssuggestion = $this->getData('suggestion', '*', 'id IN ('.$strsuggestion.')' . $main_condition . ' AND isArchived=0');

				// process all the possible suggestion and only selected which match full criteria
				$this->update('user_plan', array('isArchived' => 1), 'user_id=' . (int) $user_id . ' AND condition_id=' . (int) $condition_id . ' AND isArchived=0' );
				while($suggestion = @mysqli_fetch_assoc($rssuggestion)) {
					$rows = array(
							'user_id' => (int) $user_id, 
							'condition_id' => $condition_id, 
							'suggestion_id' => $suggestion['id'],
						);
					$check_dupli = (int) $this->getValue('user_plan', 'id', 'user_id=' . (int) $user_id . ' AND suggestion_id=' . (int) $suggestion['id'] . ' AND condition_id=' . (int) $condition_id . ' AND isArchived=0' );
					if( $check_dupli > 0 )
						$this->update('user_plan', $rows, 'id=' . (int) $check_dupli);
					else
						$this->insert('user_plan', $rows);
				}
			}
		//}
			//exit;
	}

}	

include("admin.class.php");
include("cart.class.php");
include("shipstation.class.php");
?>