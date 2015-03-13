<?php
	$title_id = $_GET['title_id'];
	$Title = new title();
	$Title->del($title_id);
	header("location:listcat.php?page_layout=title-list");
?>

