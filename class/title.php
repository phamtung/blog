<?php
class title extends db_init{
	
	public $errors;

	public function __construct(){
		
		$this->db_init();
	}

	public function add($title_name, $title_image, $title_level){
		$sql = "SELECT title_name FROM title WHERE title_name = '".$title_name."'";
		$this->query($sql);
		if($this->numRows() > 0){
			$this->errors = "Danh mục đã tồn tại !!";
			return true;
		}
		else{
			$sql = "INSERT INTO title (title_name, title_image, title_level) 
					VALUES ('".$title_name."', '".$title_image."', '".$title_level."')";
			$this->query($sql);
		}
	}

	public function del($title_id){
		$sql = "DELETE FROM title WHERE title_id = ".$title_id."";
		$this->query($sql);
	}
	
	public function check($title_name, $title_image, $title_level){
		if($title_name == '' && $title_image == '' && $title_level == ''){
				$this->errors_check = "Nhập đầy đủ thông tin !";
				return true;			
		}
	}
	
	public function edit($title_id, $title_name, $title_image, $title_level){
		$sql = "SELECT * FROM title WHERE title_name = '".$title_name."' AND title_id != ".$title_id;
		$this->query($sql);
		if($this->numRows() > 0){
			$this->errors_rep = "Danh mục đã tồn tại";
			return true;
		}
		else {
			$sql = "UPDATE title SET 	title_name 		= 	'".$title_name."', 
										title_image 	= 	'".$title_image."',
										title_level 	= 	'".$title_level."'
								WHERE title_id 		= 	'".$title_id."'";
			$this->query($sql);	
		}
	}				
}