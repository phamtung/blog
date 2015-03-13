<?php
if(isset($_POST['submit'])){
    $email = isset($_POST["email"]) ? $_POST["email"] : '';
    $address = isset($_POST["address"]) ? $_POST["address"] : '';
    $password = isset($_POST["password"]) ? $_POST["password"] : '';
    $user_name = isset($_POST["user_name"]) ? $_POST["user_name"] : '';
    $user_image = isset($_FILES['user_image']['name']) ? $_FILES['user_image']['name'] : '';
        
    move_uploaded_file($_FILES['user_image']['tmp_name'],'themes/images/'.$user_image);
    $User = new user();
    if($User->check($email, $password) == true){
        $error = $User->errors_check;
    }
    else{
        if($User->add($email, $user_image, $address, $password, $user_name) == true){
            $error = $User->errors;
        }
        else {
            header("location:listuser.php?page_layout=account-list");
        }
    }
    
}
?>
<?php if(isset($error)){echo $error;}?>
<div class = "add-user">
    <form width="200px" method="post" enctype="multipart/form-data">
        <label>Email tài khoản</label><br /><input type="email" name="email" /></br>        
        <label>Ảnh đại diện</label><br /><input type="file" name="user_image" /></br>
        <label>Địa chỉ</label><br /><input type="text" name="address" /><br />
        <label>Mật khẩu</label><br /><input type="password" name="password" /></br>
        <label>Họ tên</label><br /><input type="text" name="user_name" /></br>
        <input type="submit" name="submit" value="Thêm mới" class = "but-acc"/>
    </form>
</div>