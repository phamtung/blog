<script type="text/javascript" language="Javascript">
    function del(){
        return confirm("Bạn có muốn xóa bài viết này không ???");  
    }
</script>
<div id = "post">
    <table border="1" cellpadding="0" cellspacing="0" width="100%" height="500px">
        <tr>
            <td width="5%">ID</td>
            <td width="20%">Tên bài viết</td>
            <td width="15%">Ảnh đại diện</td>
            <td width="30%">Tóm tắt</td>
            <td width="10%">Danh mục</td>
            <td width="10%">Tác giả</td>
            <td width="5%">Sửa</td>
            <td width="5%">Xóa</td>
        </tr>
        <?php
            $Pagination = new pagination();
            $Pagination->totalRow('post');
            $Pagination->totalPage(3);
            $page = $Pagination->page();
            $firstRow = $Pagination->firstRow($page,3);

            $Post = new db_query("SELECT * FROM post INNER JOIN title ON post.title_id = title.title_id ORDER BY post_id DESC LIMIT ".$firstRow.",3");
    		while($row = mysql_fetch_assoc($Post->result)){
    	?>
        <tr>
            <td><?php echo $row['post_id'] ?></td>
            <td><?php echo $row['post_name']?></td>
            <td><img width="100%" src="themes/images/<?php echo $row['post_image']?>"></td>
            <td><?php echo substr($row['post_detail'],0,200)?></td>
            <td><?php echo $row['title_name']?></td>
            <td><?php echo $row['post_author']?></td>
            <td><a href="listpost.php?page_layout=post-edit&post_id=<?php echo $row['post_id'] ?>"><span>Sửa</span></a></td>
            <td><a onclick= "return del();" href="listpost.php?page_layout=post-del&post_id=<?php echo $row['post_id'] ?>"><span>Xóa</span></a></</td>
        </tr>
        <?php
    		}
		?>
    </table>
    <div class="page">
        <?php
            for ( $page = 0; $page <= ($Pagination->totalPage(3) - 1); $page++ ){
                if($page == $_GET['page']){
                    echo '<span>'.($page+1).'</span>';
                }
                else{
                    echo "<a href='listpost.php?page_layout=post-list&page=".$page."'>".($page+1)."</a>";
                }
            }
        ?>
    </div>
</div>