<?php
class comment extends db_init{
	public function __construct(){
		
		$this->db_init();
	}

	public function add($comment_name, $comment_email, $comment_detail, $comment_time, $post_id){
			$sql = "INSERT INTO comment(comment_name, comment_email, comment_detail, comment_time, post_id) 
					VALUES('".$comment_name."', '".$comment_email."', '".$comment_detail."', '".$comment_time."', '".$post_id."')";
			$this->query($sql);		
	}
	
	public function check($comment_name, $comment_email, $comment_detail, $captcha){
		if($comment_name == '' || $comment_email == '' || $comment_detail == '' || $captcha == ''){
				$this->errors_check = "Nhập đầy đủ thông tin !";
				return true;			
		}
	}
}