<div class="menu-header">
	<div class="container">
		<div class="row">
			<div class="col-md-9">
				<img src="/images/logo.png">
			</div>
			<div class="col-md-1 <?php echo $layout == "home" ? 'menu-active': ''?>">
				<a href="/index.php"><div class="item-menu">
					home
				</div></a>
			</div>
			<div class="col-md-1 drop <?php echo $layout == "listing" ? 'menu-active': ''?>">
				<a href="/listing/"><div class="item-menu">
					blog
				</div></a>				
				<div class="drop-list">
					<ul>
						<?php								
							$Title = new db_query("SELECT * FROM title");

							$data = array();
							while ($arr = mysql_fetch_assoc($Title->result)){
								$data[] = $arr;
							}
							foreach ($data as $value) {
								if($value['title_level'] == 0){
									$string = removeTitle($value['title_name']);
									echo '<li><a href="/category/'.$string.'-'.$value['title_id'].'">'.$value['title_name'].'</a>';
									$id = $value['title_id'];
									multimenu($data, $id);
									echo '</li>';
								}
							}								
						?>								
					</ul>
				</div>
			</div>
			<div class="col-md-1 x">
				<form method="post" name="sform" action="/search/">
					<div class="item-menu find">
						<input type="button" name="search" class="b1">
						<div class="search">
							<input type="text" name="stext" placeHolder="Search the site">
						</div>
					</div>
				</form>
			</div>
		</div>
	</div>
</div>
