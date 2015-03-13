<?php
class user extends db_init{
	
	protected $user_id;
	protected $email;
	protected $password;
	protected $user_name;
	public $errors;

	public function __construct(){
		
		$this->db_init();
	}
	
	public function login($email, $password){
		$email = $this->fix($email);
		$password = $this->fix(md5($password));

		$user = new db_query("SELECT * FROM user 
				WHERE email ='".$email."' AND password = '".$password."'");
				
		if(mysql_num_rows($user->result) > 0){
			$_SESSION["email"] = $email;
			$_SESSION["password"] = $password;
			return true;
		}
		else{
			$this->errors = 'Không đúng tài khoản hoặc mật khẩu !';
			return false;
		}
	}

	public function add($email, $user_image, $address, $password, $user_name){
		$user = new db_query("SELECT email FROM user WHERE email = '".$email."'");
		if(mysql_num_rows($user->result) > 0){
			$this->errors = "Tài khoản đã tồn tại !!";
			return true;
		}
		else{
			$user = new db_query("INSERT INTO user (email, user_image, address, password, $user_name) 
					VALUES ('".$email."', '".$user_image."', '".$address."', '".md5($password)."', '".$user_name."')");
		}
	}

	public function fix($str) {
		return str_replace("'", "\'", $str);
	}

	public function del($user_id){
		$user = new db_query("DELETE FROM user WHERE user_id = ".$user_id."");
	}
	
	public function check($email, $password){
		if($email == '' && $password == ''){
				$this->errors_check = "Nhập đầy đủ thông tin !";
				return true;			
		}
	}
	
	public function edit($user_id, $email, $user_image, $address, $password, $user_name){
		$user = new db_query("SELECT * FROM user WHERE email = '".$email."' AND user_id != ".$user_id);
		if(mysql_num_rows($user->result) > 0){
			$this->errors_rep = "Tài khoản đã tồn tại";
			return true;
		}
		else {
			$user = new db_query("UPDATE user SET email 		= 	'".$email."', 
									user_image 	= 	'".$user_image."',
									address 	= 	'".$address."',
									password 	= 	'".md5($password)."',
									user_name 	= 	'".$user_name."'
					WHERE user_id = ".$user_id);
		}
	}				
}