<?php
$post_id = $_GET['post_id'];
$Post = new db_query("SELECT * FROM post INNER JOIN title ON post.title_id = title.title_id WHERE post_id = ".$post_id);
$row = mysql_fetch_assoc($Post->result);
$title = $row['post_name'];
?>

<div class="contain post-blog">
	<div class="row">
		<div class="col-md-1">
			<img src="/admin/themes/images/<?php echo $row['title_image'];?>">
		</div>
		<div class="col-md-11 inf">
			<h4><?php echo $row['post_name'];?></h4>
			<span><?php echo date('d/m/Y H:i:s', $row['post_time']);?> Posted by <a href=""><?php echo $row['post_author'];?></a> in <a href=""><?php echo $row['title_name'];?></a></span>
		</div>
	</div>
	<div class="row im">
		<div class="col-md-12"><img width="100%" src="/admin/themes/images/<?php echo $row['post_image'];?>"></div>
	</div>
	<div class="row">
		<div class="col-md-12">
			<p><?php echo $row['post_detail'];?></p>
		</div>
	</div>
	<div class="row">
		<div class="col-md-12">
			<div class="col-md-12 conn">
				<ul>
					<li><p>share</p></li>
					<li><a href="https://facebook.com"><img src="/images/fb.png"></a></li>
					<li><a href="https://twitter.com"><img src="/images/tw.png"></a></li>
					<li><a href="https://plus.google.com"><img src="/images/gg.png"></a></li>
					<li><a href="https://instagram.com"><img src="/images/in.png"></a></li>
				</ul>
			</div>
		</div>
	</div>
	<?php
		$Comment = new db_query("SELECT * FROM comment WHERE post_id = ".$post_id);
		$count = mysql_num_rows($Comment->result);
	?>
	<div class="row comment">
		<div id="comment-list" class="col-md-12 comm-show">
			<H3><?php echo $count?> Comments</H3>
			<?php
				$sql = "SELECT * FROM comment WHERE post_id = ".$post_id." ORDER BY comment_id DESC LIMIT 0,4" ;
				$Comment->query($sql);
				while($rowc = $Comment->fetch()){
					$string = removeTitle($row['post_name']);
			?>
			<div class="comm">
				<div class="ava"><img src="/images/com-img.png"></div>
				<div class="person">
					<p><span><?php echo $rowc['comment_name']?></span> - <?php echo $rowc['comment_time']?></p>
				</div>
				<div class="detail">
					<?php echo $rowc['comment_detail']?>
				</div>
			</div>
			<?php
				}
			?>
		</div>
		<?php
			if(isset($_POST['action']) && $_POST['action'] == 'commenting'){
			    $comment_name = isset($_POST["comment_name"]) ? $_POST["comment_name"] : '';
			    $comment_email = isset($_POST["comment_email"]) ? $_POST["comment_email"] : '';
			    $comment_detail = isset($_POST["comment_detail"]) ? $_POST["comment_detail"] : '';
			    $comment_time = date('d/m/Y H:i:s'); 
			    $captcha = isset($_POST["captcha"]) ? $_POST["captcha"] : '';
			    $comment_name = $Post->remove($comment_name);
			    $comment_email = $Post->remove($comment_email);
			    $comment_detail = $Post->remove($comment_detail);

				if($Comment->check($comment_name, $comment_email, $comment_detail,$captcha) == true){
			        $error = $Comment->errors_check;
			    }
			    else{
			    	if($captcha == $_SESSION['security_code']){  
			        	$Comment->add($comment_name, $comment_email, $comment_detail, $comment_time, $post_id);
				    }
				    else{
				    	$error = "Sai mã";
				    }
				}
			}
			
		?>
		<div class="col-md-12 comm-post">
			<?php 
				if(isset($error)){
					echo $error;
					echo '	<script>
					        	window.location.href = "/listing/'.$string.'-'.$post_id.'#comment-list";
					        </script>';
				}
			?>
			<H3>Leave a comment</H3>
			<form width="200px" method="post" action="">
		        <input type="text" name="comment_name" /><label>Name</label><br />      
		        <input type="email" name="comment_email" /><label>Email</label><br />
		        <textarea name="comment_detail"></textarea></br>
		        <input type="text" name="captcha" />
		        <img src="/capcha.jpg" />
		        <br />
		        <div class = "but-com">
		        	<input type="submit" name="submit" value=''/>
		        	<input type="hidden" name="action" value='commenting'/>
		        </div>
		    </form>
		</div>
	</div>
</div>