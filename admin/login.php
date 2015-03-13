<?php 

	ob_start();
	session_start();
	require_once "../config.php";
	if(isset($_SESSION["email"]) && isset($_SESSION["password"] )){
        
        header('location:index.php');
    }
    else {
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<title>login</title>
	<link rel="stylesheet" type="text/css" href="themes/css/login.css" />

	<script type="text/javascript">
		function checkEmail($email){
			
			var type = /([a-z0-9]\.\-)+\@(([a-z0-9]\-)\.([a-z0-9]\-))/;
			if(type.test($email)){
				return true;
			}
		}
	</script>
</head>

<body>
	<?php	

	if(isset($_POST["submit"])){
		$email = isset($_POST["email"]) ? $_POST["email"] : '';
		$password = isset($_POST["password"]) ? $_POST["password"] : '';
		$User = new user();
		if($User->check($email, $password) == true){
			$error = $User->errors_check;
		}
		else {
			if($User->login($email, $password) == true){
				header("location:index.php");
			}
			else{
				$error = $User->errors;
			}
		}
	}	
	?>

	<form name="frm" method="post">
		<div id="login">
			<div class = "line">
				<img width="100%" src="themes/images/login-bar.png">
			</div>
			<h4><?php
				if(isset($error)){
					echo $error;
				}
			?></h4>
			<div class = "login-box">
				<div class = "box">
					<input type="email" name="email" placeHolder="Email Address">
				</div>
				<div class = "box">
					<input type="password" name="password" placeHolder="Password"> 
				</div>
				<div class = "sign-in">
					<input type="submit" name="submit" value="SIGN IN">
				</div>
			</div>
			
		</div>
	</form>
</body>
</html>
<?php
	}
?>