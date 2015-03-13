<?php
	session_start();
	require_once 'config.php';
	$layout = 'listing';
	$post_id = $_GET['post_id'];
	$Post = new db_query("SELECT * FROM post INNER JOIN title ON post.title_id = title.title_id WHERE post_id = ".$post_id);
	$row = mysql_fetch_assoc($Post->result);
	$title = $row['post_name'];
?>
<!DOCTYPE html>
<html>
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<title><?php echo $title;?> </title>
	<link rel="stylesheet" type="text/css" href="/css/style.css" />
	<!-- Bootstrap CSS -->
	<link href="/css/bootstrap.min.css" rel="stylesheet" >
</head>

<body>
	<div id="header">
		<?php
			include '/include/inc-header.php';
		?>
		<div class="info-header">
			<div class="container">
				<div class="row">		
					<div class="col-md-10">
						<ul class="breadcrumb">
							<li><a href="">Home</a></li>
							<?php
								$Post = new db_query("SELECT * FROM post WHERE post_id = ".$post_id);
								$rowp = mysql_fetch_assoc($Post->result);

								$Title = new db_query("SELECT * FROM title WHERE title_id = ".$row['title_id']);
								$row2 = mysql_fetch_assoc($Title->result);
								$parent = $row2['title_level'];
								$id = $row2['title_id'];
								$Menu = new menu();
								$result = $Menu->getAllParent('title','title_id','title_level',$id);
								$count = count($result);
								for($i = $count; $i>0 ; $i--){
									$Title = new db_query("SELECT * FROM title WHERE title_id = ".$result[$i]);
									$row3 = mysql_fetch_assoc($Title->result);
									$string = removeTitle($row3['title_name']);
									echo "<li><a href='/category/".$string."-".$row3['title_id']."'>".$row3['title_name']."</a></li>";
								}

								
							?>
							<li><?php echo $rowp['post_name'];?></li>
						</ul>
					</div>
					<div class="com-md-2">
					</div>
				</div>
			</div>
		</div>
	</div>
	<div id="body">
		<div class = "container">
			<div class = "row">
				<div class = "col-md-9">
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
							$Comments = new db_query("SELECT * FROM comment WHERE post_id = ".$post_id);
							$count = mysql_num_rows($Comments->result);
						?>
						<div class="row comment">
							<div id="comment-list" class="col-md-12 comm-show">
								<H3><?php echo $count?> Comments</H3>
								<?php
									$Comments = new db_query("SELECT * FROM comment WHERE post_id = ".$post_id." ORDER BY comment_id DESC LIMIT 0,4" );
									while($rowc = mysql_fetch_assoc($Comments->result)){
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
								$Post = new post();
								$Comment = new comment();
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
				</div>
				<div class = "col-md-3">
				<?php
					include '/include/inc-sidebar.php';
				?>
				</div>	
			</div>
		</div>
	</div>
	<div id="footer">
		<?php	
			include ('/include/inc-footer.php');
		?>
	</div>
	<script src="//code.jquery.com/jquery-1.10.2.js"></script>
	<script type="text/javascript">
		$(function(){

			$(".drop-list li").hover(function(){
				$(this).find('> .sublist').show();	
			}, function() {
				$(this).find('> .sublist').hide();
			});
			
		});	
	</script>
	<!-- <script src="//code.jquery.com/ui/1.11.2/jquery-ui.js"></script> -->
</body>

</html>