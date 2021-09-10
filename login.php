<?php
    session_start();
    require_once 'database.php';
    $error = '';
    $result = '';
    if (isset($_POST['submit'])) {
        // Tạo biến
        $username = $_POST['username'];
        $password = $_POST['password'];
        
        // Điều kiện đăng nhập
        if (empty($username) || empty($password)) {
            $error = 'Không được để trống các trường';
        }
        elseif (strlen($password) < 6 ) {
            $error = 'Mật khẩu phải lớn hơn 6 ký tự';
        }
             // Xử lý khi ko có lỗi xảy ra
            if (empty($error)) {
                // Chọn từ bảng...điều kiện ở username và password
                // Để kiểm tra xem tài khoản mật khẩu đã tồn tại hay chưa
                // Tạo câu truy vấn
                $sql_login = "SELECT * FROM tbl_login WHERE username = '$username' and password = '$password' ";
                // Thực thi câu truy vấn vừa tạo
                $query_insert = mysqli_query($connection,$sql_login);
                // Trả về số cột tương ứng
                $num = mysqli_num_rows($query_insert);

                // Nếu tồn tại thì cho phép người dùng đăng nhập tới trang index
                if ($num > 0) {
                    $_SESSION['success'] = $username;
                    header('Location:index.html');
                    exit();
                }
                // còn k thì lỗi đăng nhập
                else {
                    $error = 'Sai tên đăng nhập hoặc mật khẩu';
                }
            }        
        }
            
    
?>
<h3 style = "color:red"><?php echo $error ?></h3>
<h3 style = "color:green"><?php echo $result ?></h3>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/style1.css">
    <title>Đăng nhập khách hàng</title>
</head>
<body>
    <form action="" class="box" method = "post">
        <h1>Tiệm hoa phố</h1>
        <input type="text" name="username" placeholder="Tài khoản">
        <input type="password" name="password" placeholder="Mật khẩu">
        <input type="submit" name = "submit" value="Đăng Nhập">
        <a href="register.php">Đăng ký tài khoản </a>
    </form>
</body>
</html>