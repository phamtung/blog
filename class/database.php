
<?
define('SERVER_MASTER_IP','123.30.171.229');
define('DEBUG_SHOW_QUERY', true);
/*~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~*/
/*                                                  CLASS                                                              */
/*~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~*/
/**
 * Class db_init
 * Class khoi tao ket noi database
 */
class db_init{
    /** Ten Server */
	var $server;
	/** Ten User */
    var $username;
    /** Mat khau */
	var $passworddb;
    /** Ten CSDL */
	var $database;
 	var $cookie_server = '';
   //Thư mục lưu log query slow
   var $path_query_slow =  "/log/slow/";
   //Thư mục lưu log query error
   var $path_query_error =  "/log/error/";
   //Thư mục lưu log query execute
   var $path_query_execute =  "/log/execute/";

    /*********************************************************************************************************/
	/**
	 * db_init::db_init()
	 * Ham khoi tao class
	 * @return
	 */
	function db_init(){
 		// Khai bao Server localhost day

		$this->server	 					= "localhost";
		$this->username 					= "root";
		$this->passworddb					= '';
		$this->database					= "temp";
      $this->path_query_slow        =  "/log/slow/";
      $this->path_query_error       =  "/log/error/";
      $this->path_query_execute     =  "/log/execute/";

      //Khai bao connect
		$this->links  = @mysql_pconnect($this->server, $this->username, $this->passworddb);

		//Neu khong ket noi duoc
		if(!$this->links){

			//ghi ra log loi query
			$url         = $file_line_query;
			$str         = "File : " . $file_line_query . " ";
			$str        .= "Not connect DB: host: " . $this->server . ", User : " . $this->username . chr(13);
			$str         = "" . chr(13) . chr(13) . $str;

			$this->log($this->path_query_error, "errorconect", $str);

			exit();
		}
		$db_select    = mysql_select_db($this->database,$this->links);
		@mysql_query("SET NAMES 'utf8'");

		if($_SERVER['SERVER_NAME'] == 'localhost'){
			$this->cookie_server			= '/'; //cau hinh server luu cookie
		}else{
			$this->cookie_server			= 'mytour.vn'; //cau hinh server luu cookie
		}

		//lay ra ip server hien tai neu la ip server test thi  ko can de domain static
		$current_apache_ip = @apache_getenv("SERVER_ADDR");
		if($current_apache_ip == SERVER_MASTER_IP){
			$this->server	 				= "localhost";
		}

	}

    /*********************************************************************************************************/
	/**
	 * db_init::log()
	 * Ham ghi log
	 * @param mixed $filename : ten file log
	 * @param mixed $content  : noi dung log
    * @param mixed $log_path : Đường dẫn lưu file (/ ở cuối)
	 * @return
	 */
	function log($log_path, $filename, $content){

      $endline       =  "\n";
      if($_SERVER['SERVER_NAME'] == "localhost"){
         $endline       =  PHP_EOL;
      }
      $break_line		=	"---------------------------------------------------------------------------";

      $tmp_path_log  = $_SERVER["DOCUMENT_ROOT"];
      // Nếu là sub domain thì lưu log ra ngoài.
   	if($_SERVER['SERVER_NAME'] != 'mytour.vn' && $_SERVER['SERVER_NAME'] != 'localhost' && $_SERVER['SERVER_NAME'] != 'dev.mytour.vn') {

   		$tmp_path_log = explode('/', $_SERVER['DOCUMENT_ROOT']);
         if (trim($tmp_path_log[count($tmp_path_log) - 1]) == '') unset($tmp_path_log[count($tmp_path_log) - 2]);
   		unset($tmp_path_log[count($tmp_path_log) - 1]);
   		$tmp_path_log = implode('/', $tmp_path_log);
   	}

		$log_path     =   $tmp_path_log . $log_path;
		$handle       =   @fopen($log_path . $filename . ".cfn", "a");
		//Neu handle chua co mo thêm ../
		if (!$handle) $handle = @fopen($log_path . $filename . ".cfn", "a");
		//Neu ko mo dc lan 2 thi exit luon
		if (!$handle) exit('Error handle!');

		fwrite($handle, date("d/m/Y H:i:s") . " " . @$_SERVER["REQUEST_URI"] . $endline . "IP:" . @$_SERVER['REMOTE_ADDR'] . $endline . $content . $endline . $break_line . $endline);
		fclose($handle);

	}

    /*********************************************************************************************************/
 	/**
 	 * db_init::debug_query()
 	 * Ham print query vào 1 file log de kiem tra loi
 	 * @param string $query : cau query
 	 * @param string $file_line_query : noi dung loi
 	 * @return
 	 */
 	function debug_query($query, $file_line_query){

 		//neu localhost thi luon save query vào file con de kiem tra
 		if(@$_SERVER["SERVER_ADDR"] == "127.0.0.1"){
 		   $back_track = debug_backtrace();
         $caller     = array_shift($back_track);
 			$this->log("/log/", "query", "File : " . (isset($caller['file']) ? $caller['file'] : '') . " line: " . (isset($caller['line']) ? $caller['line'] : '') . " \n " . $query);
 		}

 	}

 	/**
 	 * db_init::dumpLogQuery()
 	 * @param array $arrayCheckQuery
 	 * @return
 	 */
   static function showQueryExecute(){
      //Check IP
      global  $con_ip;
      if (!isset($con_ip))   return '';

      $arr_ip  =  explode(',', $con_ip);
      if (empty($arr_ip)) return '';

      if (in_array(@$_SERVER['REMOTE_ADDR'], $arr_ip)) {
 	 		global $arrayCheckQuery,$page_check_exec_start;
 	 		$time_exec_page = microtime_float_v2() - $page_check_exec_start;
 	 		?>
 	 		<div style="padding-bottom: 30px; background: green; color: white;">
				<div style="padding: 10px; font-weight: bold;">
					Total Query: <span style="color: #FF8080;"><?=$arrayCheckQuery["total"]?></span>
					| Generate page time: <span style="color: #FF8080;"><?=$time_exec_page?></span>
					| Generate query time: <span style="color: #FF8080;"><?=$arrayCheckQuery["total_exec"]?></span>
            </div>
				<table border="1">
					<tr>
						<th>STT</th>
						<th>Time</th>
						<th>File</th>
						<th>Query</th>
					</tr>
					<?
					uasort($arrayCheckQuery["queries"], 'sortQuery');
					foreach($arrayCheckQuery["queries"] as $key => $query){
						?>
						<tr>
							<td style="padding: 5px; text-align: center;"><?=$key+1?></td>
							<td style="padding: 5px; text-align: center;font-weight: bold;color: #FF8080;"><?=number_format($query["time_exec"],5,",","")?></td>
							<td style="padding: 5px;"><?=$query["file"] . '&nbsp;(' . $query["line"]  . ')'?></td>
							<td style="padding: 5px;"><?=nl2br($query["args"][0])?></td>
						</tr>
						<?
					}
					?>
				</table>
			</div>
         <?
      }
 	 }

    /*********************************************************************************************************/
	/**
	 * db_init::__destruct()
	 * Ham huy tu dong chay khi unset class
	 * @return
	 */
	function __destruct(){
		unset($this->server);
		unset($this->username);
		unset($this->passworddb);
		unset($this->database);
	}
}

function sortQuery($a, $b)
{
    if ($a["time_exec"] == $b["time_exec"]) {
        return 0;
    }
    return ($a["time_exec"] > $b["time_exec"]) ? -1 : 1;
}

function microtime_float_v2(){
   list($usec, $sec) = explode(" ", microtime());
   return ((float)$usec + (float)$sec);
}

if(!isset($page_check_exec_start)){
	$page_check_exec_start = microtime_float_v2();
}

/*~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~*/
/*                                                  CLASS                                                              */
/*~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~*/
/**
 * Class db_query
 * Class thuc hien 1 truy van
 */
class db_query{
	/** Ket qua cua cau truy van */
	var $result;
    /** ket noi */
	var $links;
   var $query;
    /** Thoi gian nhieu nhat 1 cau query duoc thuc hien */
	var $time_slow_log = 0.03;     //

    /*********************************************************************************************************/
	/**
	 * db_query::db_query()
	 *
	 * @param mixed $query : cau truy van
	 * @param string $file_line_query : loi se ghi
	 * @return
	 */
	function db_query($query, $file_line_query = ""){

      global   $con_time_slow_query;
      $dbinit       = new db_init();
      $this->links  = @mysql_pconnect($dbinit->server, $dbinit->username, $dbinit->passworddb);

		@mysql_select_db($dbinit->database);
		@mysql_query("SET NAMES 'utf8'");
		

      if (isset($con_time_slow_query) && $con_time_slow_query > 0) $this->time_slow_log =  doubleval($con_time_slow_query);

		$arrDebugQuery = array();
		global $arrayCheckQuery;
		if(!isset($arrayCheckQuery)){
			$arrayCheckQuery = array("total" => 0,'queries' => array(),"total_exec" => 0);
		}
		$back_track = debug_backtrace();
		#+ Dùng array shift (loại bỏ giá trị đầu tiên của array) loại bỏ key của $back_track
		$caller     = array_shift($back_track);
		if(isset($caller["object"])) unset($caller["object"]);
      //File
      $debug_file 	= isset($caller['file']) ? $caller['file'] : '';
		$debug_file		= str_replace('\\','/',$debug_file);
      $debug_file		= str_replace($_SERVER['DOCUMENT_ROOT'],'',$debug_file);

		$this->query   =  $query;
	

		$time_start   = $this->microtime_float();
		$this->result = @mysql_query($query, $this->links);
		$time_end     = $this->microtime_float();
		$time         = $time_end - $time_start;

		//Neu query ko co ket qua -> dump log
		if (!$this->result){

			$error   = "File : " . (isset($caller['file']) ? $caller['file'] : '') . " line: " . (isset($caller['line']) ? $caller['line'] : '') . "\n" . @mysql_error($this->links);
			@mysql_close($this->links);
		 	$dbinit->log($dbinit->path_query_error, "error_sql", $error . "\n" . $query);

      	if(@$_SERVER["SERVER_NAME"] == "localhost" || @$_SERVER["SERVER_NAME"] == "hms.mytour.vn" || @$_SERVER["SERVER_NAME"] == "dev.mytour.vn"){
            die( $error . ": " . $query);
    		}
			die();
			//*/
		}

		$arrayCheckQuery["total"] += 1;
		$arrayCheckQuery["total_exec"] += $time;
		$caller["time_exec"]	= $time;

		//neu thoi gian thuc hien query lon hon hoac bang 0.05 thi ghi log lai.
		if ($time >= $this->time_slow_log){

			//*/
			$str     = "File : " . (isset($caller['file']) ? $caller['file'] : '') . " line: " . (isset($caller['line']) ? $caller['line'] : '') . "\n";
			$str    .= "Query time : " . number_format($time,10,".",",") . "\n";
			$str    .= $query . chr(13);
			$dbinit->log($dbinit->path_query_slow, "slow_sql", $str);
			//*/

		}
      $caller['file']   =  $debug_file;
		if(DEBUG_SHOW_QUERY) $arrayCheckQuery["queries"][] = $caller;
		//ghi query ra log de kiem tra
		$dbinit->debug_query($query, $file_line_query);
		unset($dbinit);
	}

    /*********************************************************************************************************/
	/**
	 * db_query::resultArray()
	 * Ham lay ket qua
	 * @return array $arrayReturn : Mang
	 */
	function resultArray(){
		$arrayReturn = array();
		while($row = mysql_fetch_assoc($this->result)){
			$arrayReturn[] = $row;
		}
		return $arrayReturn;
	}

    /*********************************************************************************************************/
	/**
	 * db_query::close()
	 * Ham dong ket noi
	 * @return
	 */
	function close(){
		@mysql_free_result($this->result);
		if ($this->links){
			@mysql_close($this->links);
		}
	}

    /*********************************************************************************************************/
	/**
	 * db_query::microtime_float()
	 * Ham tinh thoi gian(miligiay)
	 * @return float $return
	 */
	function microtime_float(){
      list($usec, $sec) = explode(" ", microtime());
      return ((float)$usec + (float)$sec);
	}
}
//End class db_query


/*~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~*/
/*                                                  CLASS                                                              */
/*~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~*/
/**
 * Class db_execute
 * Class thuc thi 1 query
 */
class db_execute{
    /** ket noi */
	var $links;
    /** so dong bi anh huong */
	var $total = 0;

    /*********************************************************************************************************/
	/**
	 * db_execute::db_execute()
	 * Thuc hien 1 cau query
	 * @param mixed $query : Cau query
	 * @param string $file_line_query : Ghi loi
	 * @return
	 */
	function db_execute($query, $file_line_query = ""){
      global $user_id;
      $back_track   = debug_backtrace();
      $caller       = array_shift($back_track);
		$dbinit       = new db_init();
      $this->links  = @mysql_pconnect($dbinit->server, $dbinit->username, $dbinit->passworddb);

		@mysql_select_db($dbinit->database);
		@mysql_query("SET NAMES 'utf8'");
		@mysql_query($query);

		//kiem tra thanh cong hay chua
		$this->total = @mysql_affected_rows();

		//neu ket qua query thuc thi khong thanh cong tru truong hop insert ignore
		if($this->total < 0 && strpos($query, "IGNORE") === false ){
			$error = @mysql_error($this->links);
			@mysql_close($this->links);
            //ghi log
			$dbinit->log($dbinit->path_query_execute , "error_sql", "File : " . (isset($caller['file']) ? $caller['file'] : '') . " line: " . (isset($caller['line']) ? $caller['line'] : '') . " " . $error . "\n" . $query);
		}
		@mysql_close($this->links);

		//ghi query ra log de kiem tra
		$dbinit->debug_query($query, $file_line_query);
		unset($dbinit);
	}
}



/*~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~*/
/*                                                  CLASS                                                              */
/*~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~*/
/**
 * Class db_count
 * Class dem so ket qua cua cau query
 */
class db_count{
	/** so luong ket qua */
    var $total;

	/*********************************************************************************************************/
    /**
	 * db_count::db_count()
	 *
	 * @param string $sql : Cau lenh sql
	 * @return int so ket qua
	 */
	function db_count($sql){
		$db_ex    = new db_query($sql);

		if( $row = mysql_fetch_assoc($db_ex->result)){
			$this->total = intval($row["count"]);
		}else{
			$this->total = 0;
		}
		$db_ex->close();
		unset($db_ex);
		return $this->total;
	}
}


/*~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~*/
/*                                                  CLASS                                                              */
/*~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~*/
/**
 * Class db_execute_return
 * Class thuc hien 1 cau query,co tra ve ket qua la id cuoi cung dc insert.
 */
class db_execute_return{
	/** ket noi*/
	var $links;
    /** ket qua*/
	var $result;

    /*********************************************************************************************************/
	/**
	 * db_execute_return::db_execute()
	 *
	 * @param string $query : cau truy van
	 * @param string $file_line_query : Loi se ghi
	 * @return int :ID duoc them vao cuoi cung.
	 */
	function db_execute($query, $file_line_query = ""){

		$dbinit       =   new db_init();
		$this->links  =   @mysql_pconnect($dbinit->server, $dbinit->username, $dbinit->passworddb);
		@mysql_select_db($dbinit->database);


		@mysql_query("SET NAMES 'utf8'");
		@mysql_query($query);

		$total        =   @mysql_affected_rows();

		//neu ket qua khong thanh cong và khong phai là insert ignore
		if($total < 0 && strpos($query, "IGNORE") === false ){

			$error = @mysql_error($this->links);
			@mysql_close($this->links);

			$dbinit->log($dbinit->path_query_execute, "error_sql", $file_line_query . " " . $error . "\n" . $query);
		}

		$last_id      =   0;
		$this->result = @mysql_query("select LAST_INSERT_ID() as last_id", $this->links);

		if($row = @mysql_fetch_array($this->result)){
			$last_id = $row["last_id"];
		}

		@mysql_close($this->links);

		//ghi query ra log de kiem tra
		$dbinit->debug_query($query, $file_line_query);
		//huy bien
		unset($dbinit);
		return $last_id;
	}
}

/*~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~*/


?>