<div class="box cat">
	<span>categories</span>
	<ul>
	<?php
		$Title = new db_query("SELECT * FROM title WHERE title_level = 0");
		while($row = mysql_fetch_assoc($Title->result)){
			$string = removeTitle($row['title_name']);
	?>
		<li><a href="/category/<?php echo $string.'-'.$row['title_id'];?>"><img src="/images/icon-cat.png"><?php echo $row['title_name']?></a></li>
	<?php
		}
	?>
	</ul>
</div>
<div class="box">
	<span>recent posts</span>
	<ul>
		<li><a href="">empty</a></li>
	</ul>
</div>
<div class="box">
	<span>archive</span>
	<ul>
	<?php
		$Post = new db_query("SELECT post_time FROM post");
		$row = mysql_fetch_assoc($Post->result);
	?>					
		<li><a href="/archive/<?php echo date('y', $row['post_time']);?>"><img src="/images/icon-cat.png"><?php echo date('Y', $row['post_time']);?></a></li>
	</ul>
</div>
