<?php
	$post_id = $_GET['post_id'];
	$Post = new post();
	$Post->del($post_id);
	header("location:listpost.php?page_layout=post-list");
?>

