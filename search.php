<?php
	require_once 'config.php';
	$title = "Danh sách tìm kiếm";
	$layout = 'search';
	error_reporting(E_ALL & ~E_NOTICE & ~E_DEPRECATED);
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
							<li class="active"><a href="">Blog</a></li>
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
					include '/include/inc-search.php';
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