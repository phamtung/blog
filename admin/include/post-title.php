<?php
$title_id = $_GET['title_id'];
$Post = new post();
$sql = "SELECT * FROM post INNER JOIN title ON post.title_id = title.title_id ";
$Post->query($sql);

// include_once('pagination.php');
$Pagination = new pagination();
$sql="SELECT * FROM post WHERE title_id=".$title_id;
$table = $Pagination->query($sql);
$Pagination->totalRow($Pagination->query($sql));
$Pagination->totalPage(3);
$page = $Pagination->page();
$firstRow = $Pagination->firstRow($page, 3);

$Post = new post();
$sql = "SELECT * FROM post ORDER BY post_id DESC LIMIT ".$firstRow.", 3";
$Post->query($sql);
?>
<h2>Sản phẩm</h2>
<div id = "post">
    <table border="1" cellpadding="0" cellspacing="0" width="100%">
        <tr>
            <td width="5%">ID</td>
            <td width="20%">Tên bài viết</td>
            <td width="15%">Ảnh đại diện</td>
            <td width="40%">Tóm tắt</td>
            <td width="10%">Danh mục</td>
            <td width="5%">Sửa</td>
            <td width="5%">Xóa</td>
        </tr>
        <?php
            $sql = "SELECT * FROM post WHERE title_id = ".$title_id;
            $Post->query($sql);
            while($row = $Post->fetch()){
        ?>
        <tr>
            <td><?php echo $row['post_id'] ?></td>
            <td><?php echo $row['post_name']?></td>
            <td><img width="100%" src="themes/images/<?php echo $row['post_image']?>"></td>
            <td><?php echo substr($row['post_detail'],0,200).'...';?></td>
            <td><?php echo $row['title_name']?></td>
            <td><a href="index.php?page_layout=post-edit&post_id=<?php echo $row['post_id'] ?>"><span>Sửa</span></a></td>
            <td><a onclick= "return del();" href="index.php?page_layout=post-del&post_id=<?php echo $row['post_id'] ?>"><span>Xóa</span></a></</td>
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
                    echo "<a href='index.php?page_layout=post-title&title_id=".$row['post_id']."&page=".$page."'>".($page+1)."</a>";
                }
            }
        ?>
    </div>
</div>