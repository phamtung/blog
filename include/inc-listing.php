				<?php
					$Pagination = new pagination();
		            $Pagination->totalRow('post');
		            $Pagination->totalPage(4);
		            $page = $Pagination->page();
		            $firstRow = $Pagination->firstRow($page,4);

					$Post = new db_query("SELECT * FROM post INNER JOIN title ON post.title_id = title.title_id ORDER BY post_id DESC LIMIT ".$firstRow.",4");
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
							<a href="/detail/<?php echo $string2.'/'.$string.'-'.$row['post_id'];?>"><img src="/admin/themes/images/<?php echo $row['post_image'];?>"></a>
						</div>
						<div class="contain">
							<h4><a href="/detail/<?php echo $string2.'/'.$string.'-'.$row['post_id'];?>"><?php echo $row['post_name'];?></a></h4>
							<span>Posted by <a href=""><?php echo $row['post_author'];?></a> in <a href="/index/category/<?php echo $row['title_id']?>"><?php echo $row['title_name'];?></a></span>
							<?php
								$Comment = new db_query("SELECT comment_id FROM comment WHERE post_id=".$row['post_id']);
								$count = mysql_num_rows($Comment->result);
							?>
							<img class="com-img" src="/images/comm.png"><a href="/detail/<?php echo $string2.'/'.$string.'-'.$row['post_id'];?>#comment-list"><?php echo $count;?></a>
							<p><?php echo substr($row['post_detail'],0,1000)."...";?></p>
							<a href="/detail/<?php echo $string2.'/'.$string.'-'.$row['post_id'];?>">Continue reading -></a>
						</div>
					</div>
				</div>
				<?php
					}
				?>
				<div class="page">
			        <?php
			        	if($page != 0){
			        		echo "<a href='/listing/".($page-1)."'><</a>";
			        	}
				        for ( $page = 0; $page <= ($Pagination->totalPage(4) - 1); $page++ ){
				            if($page == $_GET['page']){
				                echo '<span>'.($page+1).'</span>';
			                }
			                else{
			                    echo "<a href='/listing/".$page."'>".($page+1)."</a>";
			                }
				        }
				        if($_GET['page'] != ($Pagination->totalPage(4) - 1)){
			            	echo "<a href='/listing/".($_GET['page']+1)."'>></a>";
			            }
			        ?>
			    </div>