<?php
class post extends db_init{
	public function __construct(){
		
		$this->db_init();
	}

	public function add($post_name, $post_image, $post_detail, $title_id, $post_author, $post_time){
		
		$sql = "SELECT * FROM post WHERE post_name = '".$post_name."'";
		$this->query($sql);
		if($this->numRows() > 0){
			$this->errors = "Bài viết đã tồn tại !!";
			return true;
		}
		else{
			$sql = "INSERT INTO post(post_name, post_image, post_detail, title_id, post_author, post_time) 
					VALUES('".$post_name."', '".$post_image."', '".$post_detail."', '".$title_id."', '".$post_author."', '".$post_time."')";
			$this->query($sql);
		}		
	}
	
	public function del($post_id){
		
		$sql = "DELETE FROM post WHERE post_id = ".$post_id."";
		$this->query($sql);
	}
	
	public function check($post_name, $post_image, $post_detail, $title_id, $post_author){
		if($post_name == '' && $post_image == '' && $post_detail == '' && $title_id == 'unselect' && $post_author == ''){
				$this->errors_check = "Nhập đầy đủ thông tin !";
				return true;			
		}
	}
	
	public function edit($post_id, $post_name, $post_image, $post_detail, $title_id, $post_author, $post_time){
		$sql = "SELECT * FROM post WHERE post_name = '".$post_name."' AND post_id != ".$post_id;
		$this->query($sql);
		if($this->numRows() > 0){
			$this->errors_rep = "Bài viết đã tồn tại";
			return true;
		}
		else {
			$sql = "UPDATE post SET post_name 		= 	'".$post_name."', 
									post_image 		= 	'".$post_image."',
									post_detail 	= 	'".$post_detail."',
									title_id 		= 	'".$title_id."',
									post_author 	= 	'".$post_author."',
									post_time 		= 	'".$post_time."'
								WHERE post_id 		= 	'".$post_id."'";
			$this->query($sql);	
		}
	}

	public function remove($text){
		return htmlentities($text);
	}	

	
}



?>