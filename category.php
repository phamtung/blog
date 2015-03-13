<?php
	error_reporting(E_ALL & ~E_NOTICE & ~E_DEPRECATED);
	require_once 'config.php';
	$layout = 'category';
	$cat_id = $_GET['cat_id'];
	$title = 'Chi tiet danh muc';
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
								$Title = new db_query("SELECT * FROM title WHERE title_id = ".$cat_id);
								$row2 = mysql_fetch_assoc($Title->result);
								$parent = $row2['title_level'];
								$id = $row2['title_id'];
								$Menu = new menu();
								$result = $Menu->getAllParent('title','title_id','title_level',$id);
								$count = count($result);
								for($i = $count; $i>0 ; $i--){
									$submenu = new db_query("SELECT * FROM title WHERE title_id = ".$result[$i]);
									$row = mysql_fetch_assoc($submenu->result);
									$string = removeTitle($row['title_name']);
									echo "<li><a href='/category/".$string."-".$row['title_id']."'>".$row['title_name']."</a></li>";
								}
							?>	
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
				<?php
					$check = new db_query("SELECT title_level FROM title WHERE title_id = ".$cat_id);
					$row = mysql_fetch_assoc($check->result);
					if($row['title_level'] == 0){ 
						include '/include/inc-cat.php';
					}
					else{
						include '/include/inc-subcat.php';
					}
				?>
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