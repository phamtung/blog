<?php
	$user_id = $_GET['user_id'];
	$User = new User();
	$User->del($user_id);
	header("location:listuser.php?page_layout=account-list");
?>

