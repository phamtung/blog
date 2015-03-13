<?php
if(isset($_POST['submit'])){
    $title_name = isset($_POST["title_name"]) ? $_POST["title_name"] : '';
    $title_level = isset($_POST["title_level"]) ? $_POST["title_level"] : '';
    $title_image = isset($_FILES['title_image']['name']) ? $_FILES['title_image']['name'] : '';
    move_uploaded_file($_FILES['title_image']['tmp_name'],'themes/images/'.$title_image);
  
    $Title = new title();
    if($Title->check($title_name, $title_image, $title_level) == true){
        $error = $Title->errors_check;
    }
    else{
        if($Title->add($title_name, $title_image, $title_level) == true){
            $error = $Title->errors;
        }
        else {
            header("location:listcat.php?page_layout=title-list");
        }
    }
    
}
?>

<?php if(isset($error)){echo $error;}?>
<div class = "add">
    <form method="post" enctype="multipart/form-data" action="">       
        <label>Tên danh mục</label><br /><input type="text" name="title_name" /></br>
        <label>Ảnh danh mục</label><br /><input type="file" name="title_image" /></br>
        <label>Level</label><br /><input type="text" name="title_level" /></br>
        <input type="submit" name="submit" value="Thêm mới" class="but"/>
    </form>
</div>