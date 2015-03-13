<?php
class pagination extends db_init{
	public $page;
	public $totalPage;
	public $totalRow;
	public $rowPerPage;
	public $firstRow;
	function __construct(){	
		$this->db_init();	
	}
	function totalRow($table_name){
		$Page = new db_query("SELECT * FROM ".$table_name);
		$this->totalRow = mysql_num_rows($Page->result);
	}
	function totalPage($rowPerPage){
			return $this->totalPage = ceil($this->totalRow/$rowPerPage);
	}
	function firstRow($page, $rowPerPage){
		$this->firstRow = $page * $rowPerPage;
		return $this->firstRow;
	}
	function page(){		
		if(isset($_GET['page'])){
			$this->page = $_GET['page'];
		}
		else{
			$this->page = 0;	
		}
		return $this->page;
	}
}?>