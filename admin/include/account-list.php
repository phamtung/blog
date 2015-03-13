<script type="text/javascript" language="Javascript">
    function del(){
        return confirm("Bạn có muốn xóa tài khoản này không ???");  
    }
</script>

<div id = "post">
    <table border="1" cellpadding="0" cellspacing="0" width="100%">
        <tr>
            <td width="5%">ID</td>
            <td width="30%">Email tài khoản</td>
            <td width="10%">Ảnh đại diện</td>
            <td width="30%">Địa chỉ</td>
            <td width="15%">Họ tên</td>
            <td width="5%">Sửa</td>
            <td width="5%">Xóa</td>
        </tr>
        <?php
            $Pagination = new pagination();
            $Pagination->totalRow('user');
            $Pagination->totalPage(3);
            $page = $Pagination->page();
            $firstRow = $Pagination->firstRow($page,3);

            $User = new db_query("SELECT * FROM user ORDER BY user_id DESC LIMIT ".$firstRow.",3");
    		while($row = mysql_fetch_assoc($User->result)){
    	?>
        <tr>
            <td><?php echo $row['user_id'] ?></td>
            <td><?php echo $row['email']?></td>
            <td><img width="100%" src="themes/images/<?php echo $row['user_image']?>"></td>
            <td><?php echo $row['address']?></td>
            <td><?php echo $row['user_name']?></td>
            <td><a href="listuser.php?page_layout=account-edit&user_id=<?php echo $row['user_id'] ?>"><span>Sửa</span></a></td>
            <td><a onclick= "return del();" href="listuser.php?page_layout=account-del&user_id=<?php echo $row['user_id'] ?>"><span>Xóa</span></a></</td>
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
                    echo "<a href='listuser.php?page_layout=account-list&page=".$page."'>".($page+1)."</a>";
                }
            }
        ?>
    </div>
</div>