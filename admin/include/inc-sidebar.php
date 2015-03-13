<div class="col-md-2 body-left">
	<div class="logo">
		<a href="index.php"><img src="themes/images/logo.png"></a>
	</div>
	<div class="menu">
		<div class="menu-1 show">
			<span>post</span>
		</div>
		<div class="submenu <?php echo ($layout == "post-add" || $layout == "post-list") ? 'active': ''?>" >
			<div class="menu-2">
				<a href="listpost.php?page_layout=post-add" <?php echo $layout == "post-add" ? 'class="menu-active"': ''?>>thêm mới bài viết</a>
			</div>
			<div class="menu-2">
				<a href="listpost.php?page_layout=post-list" <?php echo $layout == "post-list" ? 'class="menu-active"': ''?>>danh sách bài viết</a>
			</div>
		</div>
		<div class="menu-1">
			<span>danh mục</span>
		</div>
		<div class="submenu <?php echo ($layout == "title-add" || $layout == "title-list") ? 'active': ''?>">
			<div class="menu-2">
				<a href="listcat.php?page_layout=title-add" <?php echo $layout == "title-add" ? 'class="menu-active"': ''?>>thêm danh mục</a>
			</div>
			<div class="menu-2">
				<a href="listcat.php?page_layout=title-list" <?php echo $layout == "title-list" ? 'class="menu-active"': ''?>>list danh mục</a>
			</div>
		</div>
		<div class="menu-1">
			<span>tài khoản</span>
		</div>
		<div class="submenu <?php echo ($layout == "account-add" || $layout == "account-list") ? 'active': ''?>">
			<div class="menu-2">
				<a href="listuser.php?page_layout=account-add" <?php echo $layout == "account-add" ? 'class="menu-active"': ''?>>thêm mới tài khoản</a>
			</div>
			<div class="menu-2">
				<a href="listuser.php?page_layout=account-list" <?php echo $layout == "account-list" ? 'class="menu-active"': ''?>>danh sách tài khoản</a>
			</div>
		</div>
	</div>
</div>