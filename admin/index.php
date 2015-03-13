<?php
 	ob_start();
    session_start();
    require_once "../config.php";
 	error_reporting(E_ALL & ~E_NOTICE & ~E_DEPRECATED);

 	if(!(isset($_SESSION["email"]) && isset($_SESSION["password"] ))){
		header('location:login.php');
	}
	else {

 	$layout = $_GET['page_layout'];
?>
<!DOCTYPE html>
<html>
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<title>ADMIN</title>
	<link rel="stylesheet" type="text/css" href="themes/css/admin.css" />
	<link href="themes/css/bootstrap.min.css" rel="stylesheet" >
</head>

<body>
	<div class="sidebar">
		<?php
			include '/include/inc-sidebar.php';
		?>
	</div>
	<div class="col-md-10 body-right">
		<div class="header">
			<?php
				include '/include/inc-header.php';
			?>
		</div>
		<div class="row contain">
			<?php
				include '/include/inc-index.php';
			?>
		</div>
		<div class="row footer">
			<?php
				include '/include/inc-footer.php';
			?>
		</div>
	</div>
	<script src="//code.jquery.com/jquery-1.10.2.js"></script>
	<script type="text/javascript" language="Javascript">
		$(function(){
			$(".menu-1").click(function(){
				if (! $(this).hasClass('show')) {
					$(".submenu").slideUp();
					$(".menu-1").removeClass("show");
					$(this).addClass('show');
					$(this).next().slideToggle();
				}
				else{
					$(".submenu").slideUp();
					$(this).next().slideToggle();
				}
			});
		});
	</script>
</body>

</html>
<?php
}
?>