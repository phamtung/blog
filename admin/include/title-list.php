<script type="text/javascript" language="Javascript">
    function del(){
        return confirm("Bạn có muốn xóa danh mục này không ???");  
    }
</script>

<div id = "post">
    <table border="1" cellpadding="0" cellspacing="0" width="100%">
        <tr>
            <td width="10%">ID</td>
            <td width="60%">Tên danh mục</td>
            <td width="10%">Ảnh danh mục</td>
            <td width="10%">Sửa</td>
            <td width="10%">Xóa</td>
        </tr>
        <?php
            $Pagination = new pagination();
            $Pagination->totalRow('title');
            $Pagination->totalPage(3);
            $page = $Pagination->page();
            $firstRow = $Pagination->firstRow($page,3);

            $Title = new db_query("SELECT * FROM title LIMIT ".$firstRow.",3");
            while($row = mysql_fetch_assoc($Title->result)){
        ?>
        <tr>
            <td><?php echo $row['title_id'] ?></td>
            <td><a href="listcat.php?page_layout=post-title&title_id=<?php echo $row['title_id'];?>"><?php echo $row['title_name']?></td>
            <td><img width="100%" src="themes/images/<?php echo $row['title_image']?>"></td>
            <td><a href="listcat.php?page_layout=title-edit&title_id=<?php echo $row['title_id'] ?>"><span>Sửa</span></a></td>
            <td><a onclick= "return del();" href="listcat.php?page_layout=title-del&title_id=<?php echo $row['title_id'] ?>"><span>Xóa</span></a></</td>
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
                    echo "<a href='listcat.php?page_layout=title-list&page=".$page."'>".($page+1)."</a>";
                }
            }
        ?>
    </div>
</div>