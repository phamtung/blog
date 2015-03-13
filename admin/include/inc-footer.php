<?php
	$User = new db_query("SELECT * FROM user WHERE email ='".$_SESSION["email"]."'");
	$row = mysql_fetch_assoc($User->result);
?>
<table width="100%" cellpadding="0" cellspacing="0">
	<tr>
		<td width="60%"><a href=""><img src="themes/images/icon-6.png">Free admin template by Asif Aleem (freebiesgallery.com)</a></td>
		<td width="30%"><a href=""><img width="10%" src="themes/images/<?php echo $row['user_image']?>" class="ava-admin"><?php echo $row['user_name']?></a></td>
		<td><a href="listuser.php?page_layout=account-edit&user_id=<?php echo $row['user_id'] ?>"><img src="themes/images/icon-7.png"></a></td>
		<td><a href="logout.php"><img src="themes/images/icon-8.png"></a></td>
	</tr>
</table>