<?php
if(isset($_POST['submit'])){
    $post_name = isset($_POST["post_name"]) ? $_POST["post_name"] : '';
    $title_id = isset($_POST["title_id"]) ? $_POST["title_id"] : '';
    $post_detail = isset($_POST["post_detail"]) ? $_POST["post_detail"] : '';
    $post_image = isset($_FILES['post_image']['name']) ? $_FILES['post_image']['name'] : '';
    $post_author = isset($_POST["post_author"]) ? $_POST["post_author"] : '';
    $post_time = time();    
    move_uploaded_file($_FILES['post_image']['tmp_name'],'themes/images/'.$post_image);
    $Post = new post();
    if($Post->check($post_name, $post_image, $post_detail, $title_id, $post_author) == true){
        $error = $Post->errors_check;
    }
    else{
        if($Post->add($post_name, $post_image, $post_detail, $title_id, $post_author, $post_time) == true){
            $error = $Post->errors;
        }
        else {
            header("location:listpost.php?page_layout=post-list");
        }
    }
    
}
?>
<?php if(isset($error)){echo $error;}?>
<div class = "add">
    <form method="post" enctype="multipart/form-data">
        <label>Tên bài viết</label><br /><input type="text" name="post_name" /></br>        
        <label>Ảnh đại diện</label><br /><input type="file" name="post_image" /></br>
        <label>Nội dung bài viết</label><br />
        <?php
            include("fckeditor/fckeditor.php");
            $sBasePath = $_SERVER['PHP_SELF'] ;
            $sBasePath = substr($sBasePath, 0, strpos($sBasePath, "index.php"));
            $sBasePath = $sBasePath."fckeditor/";
            $oFCKeditor = new FCKeditor('post_detail') ;
            $oFCKeditor->BasePath = $sBasePath ;
            $oFCKeditor->Create() ;
        ?>
        </br>
        <label>Danh mục bài viết</label><br />
            <select name="title_id">
                <option value="unselect" selected="selected">chọn danh mục bài viết</option>
                <?php                            
                $menu = Menu(0);                                        
                foreach($menu as $k => $row)
                {                    
                    echo '<option value="'.$row['title_id'].'">'.$row['title_name'].'</option>';

                }                              
                ?>
               
            </select>
        </br>
        <label>Tên tác giả</label><br /><input type="text" name="post_author" /></br></br> 
        <input type="submit" name="submit" value="Thêm mới" class="but"/>
    </form>
</div>




