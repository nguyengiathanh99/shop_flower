<?php
    require_once 'database.php';
    $error = '';
    $result = '';
    
    if (isset($_POST['submit'])) {
        // Tạo biến
        $username = $_POST['username'];
        $password = $_POST['password'];
        $repassword = $_POST['repassword'];
        // Kiểm tra điều kiện
        if (empty($username) || empty($password)) {
            $error = 'Không được để trống các trường';
        }
        // Kiểm tra độ dài mật khẩu
        elseif (strlen($password) < 6 ) {
            $error = 'Mật khẩu phải lớn hơn 6 ký tự';
        }
        // Kiểm tra 2 mật khẩu xem có trùng không
        elseif ($password != $repassword) {
            $error = 'Mật khẩu không trùng nhau';
        }
        // Xử lý khi ko có lỗi xảy ra
        if (empty($error)) {
            // Kiểm tra xem tài khoản đăng ký đã tồn tại hay chưa
            $sql = "SELECT * FROM tbl_login WHERE username = '$username'";
            $sql_query = mysqli_query($connection,$sql);
            $num = mysqli_num_rows($sql_query);

            // Nếu chưa thì thêm vào csdl và đăng ký thành công
            // Sau đó chuyển về trang đăng nhập
            if ($num == 0) {
                // Tạo câu truy vấn insert
                $sql_insert = "INSERT INTO tbl_login(`username`,`password`)
                                VALUES('$username','$password')";
                // Thực thi câu truy vấn vừa tạo
                $is_insert = mysqli_query($connection,$sql_insert);
                // var_dump($is_insert);
                if ($is_insert) {
                    header('Location:login.php');
                }
                else {
                    $error = 'Đăng ký thất bại';
                }
            }
            // Nếu có tài khoản rồi sẽ thông báo lỗi
            else {
                $error = 'Tài khoản đã tồn tại';
            }
        }
    }
?>
<h3 style = "color:red"><?php echo $error ?></h3>
<h3 style = "color:green"><?php echo $result ?></h3>
<html lang="en">
<head>
    <link rel="stylesheet" href="bootstrap-4.5.0-dist/css/bootstrap.min.css">
    <title>Form đăng nhập đăng ký</title>
</head>
<body>
<div class="container">
<form action=""  method = "post" enctype="multipart/form-data">
<h2 class = "text-secondary" style = "text-align: center">Đăng ký tài khoản</h2>
<div class="form-group" >
    <label>Tài khoản:</label>
    <input type="text" class="form-control" placeholder="Nhập tài khoản"  name = "username">
  </div>
  <div class="form-group">
    <label>Mật khẩu:</label>
    <input type="password" class="form-control" placeholder="Nhập mật khẩu" name = "password">
  </div>
  <div class="form-group">
    <label> Nhập lại mật khẩu:</label>
    <input type="password" class="form-control" placeholder="Nhập lại mật khẩu" name = "repassword">
  </div>
  <input type="submit" name = "submit" class="btn btn-success" value = "Đăng ký">
  <input type="reset" name = "reset" class="btn btn-danger" value = "Đăng ký lại">
  
</form> 
</div>

</body>
</html>