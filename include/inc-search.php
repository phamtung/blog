<?php
	if(isset($_POST['stext'])){
		$stext = $_POST['stext'];
	}
	$arr_text= explode(' ', $stext);
	$ntext = implode('%', $arr_text);
	$ntext = '%'.$ntext.'%';
	$Post = new db_query("SELECT * FROM post INNER JOIN title ON post.title_id = title.title_id WHERE post_name LIKE '".$ntext."' ORDER BY post_id DESC");
	$count = mysql_num_rows($Post->result);
?>
<H3>Có <?php echo $count;?> kết quả tìm kiếm với từ khóa <?php echo "'".$stext."'";?> :</H3>			
<?php 
	while($row = mysql_fetch_assoc($Post->result)){	
		$string = removeTitle($row['post_name']);
		$string2 = removeTitle($row['title_name']);
?>
<div class="post">
	
	<div class="col-md-1">
		<div class="time">
			<div class="month">
				<?php echo date('M', $row['post_time']);?>
			</div>
			<div class="day">
				<?php echo date('d', $row['post_time']);?>
			</div>
		</div>
		<div class="img-title">
			<img src="/admin/themes/images/<?php echo $row['title_image'];?>">
		</div>
	</div>
	<div class="col-md-11">
		<div class="img">
			<a href="/index/<?php echo $string2.'/'.$string.'-'.$row['post_id'];?>"><img src="/admin/themes/images/<?php echo $row['post_image'];?>"></a>
		</div>
		<div class="contain">
			<h4><a href="/index/<?php echo $string2.'/'.$string.'-'.$row['post_id'];?>"><?php echo $row['post_name'];?></a></h4>
			<span>Posted by <a href=""><?php echo $row['post_author'];?></a> in <a href=""><?php echo $row['title_name'];?></a></span>
			<?php
				$Comment = new db_query("SELECT comment_id FROM comment WHERE post_id=".$row['post_id']);
				$count = mysql_num_rows($Comment->result);
			?>
			<img class="com-img" src="/images/comm.png"><a href="/index/<?php echo $string2.'/'.$string.'-'.$row['post_id'];?>#comment-list"><?php echo $count;?></a>
			<p><?php echo substr($row['post_detail'],0,1000)."...";?></p>
			<a href="/index/<?php echo $string2.'/'.$string.'-'.$row['post_id'];?>">Continue reading -></a>
		</div>
	</div>
</div>
<?php
	}
?>