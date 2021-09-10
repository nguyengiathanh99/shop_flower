<?php
session_start();
  require_once 'database.php';
  $error = '';
  $result = '';
  // echo "<pre>";
  // print_r($_POST);
  // print_r($_FILES);
  // echo "</pre>";
  if (isset($_POST['submit'])) {
    // Tạo biến
    $name = $_POST['name'];
    $number = $_POST['number'];
    $description = $_POST['description'];
    $avatar_arr = $_FILES['avatar'];
    // Kiểm tra điều kiện
    if (empty($name) || empty($description)) {
      $error = ' Không được để trống các trường';
    }
    // Điều kiện nhập số phải lớn hơn 0
    elseif ($number < 0) {
      $error = 'Phải nhập số lớn hơn 0 ';
    }
    // Chỉ xử lý validate file upload nếu có file được tải lên 
    // Dựa vào thuộc tính error của mảng $_FILES
    elseif ($avatar_arr['error'] == 0 ) {
      // Validate file upload lên phải có dạng ảnh
      // Và lấy ra đuôi file
      $extension = pathinfo ($avatar_arr['name'], PATHINFO_EXTENSION);
      // chuyển về ký tự thường
      $extension = strtolower($extension);
      // Tạo ra các đuôi file ảnh hợp lệ
      $extension_allowed = ['jpg', 'png', 'gif', 'jpeg'];
      // Lấy dung lượng của file upload theo đơn vị mb
      $fize_size_mb = $avatar_arr['size'] / 1024 / 1024;
      
      // Kiểm tra xem user có upload đúng file ảnh hay ko
      if (!in_array($extension, $extension_allowed)) {
        $error = 'Cần upload dạng file ảnh';
      }
      // Dung lượng file ảnh phải từ 2mb đổ xuống
      elseif ($fize_size_mb > 2) {
        $error = 'File upload không được quá 2MB';
      }
    }
    // Xử lý khi ko có lỗi xảy ra
    if (empty($error)) {
        $avatar = '';
        //xử lý upload file nếu có hành động upload
        if ($avatar_arr['error'] == 0) {
          //tạo thư mục chứa file sẽ upload lên
			    //tạo thư mục có tên = uploads, ngang hàng với file hiện tại
            $dir_upload = 'uploads';
            // Nếu chưa có file upload
            // Sẽ khởi tạo file
            if (!file_exists($dir_upload)) {
                mkdir($dir_upload);
            }
            //tạo ra tên file mang tính duy nhất, để tránh trường
			      //hợp bị đè file khi user upload cùng 1 file lên hệ thống nhiều lần
            $avatar = time() . '-' .$avatar_arr['name'];
            //upload file từ thư mục tạm của XAMPP vào trong thư mục uploads bạn đã tạo

            move_uploaded_file($avatar_arr['tmp_name'], $dir_upload . '/' . $avatar);
        }
        // Tạo câu truy vấn insert
        $sql_insert = "INSERT INTO tbl_user (`name`, `numberphone`, `description`, `avatar`)
                        VALUES('$name', '$number', '$description', '$avatar')";
        // Thực thi câu truy vấn vừa tạo
        $is_insert =  mysqli_query($connection, $sql_insert);
        // Nếu insert thành công
        // thì dữ liệu sẽ được chuyển sang bảng category
        if ($is_insert) {
            $_SESSION['success'] = 'Insert dữ liệu thành công';
            header('Location: category.php');
            exit();
        }
        // Insert thất bại sẽ thông báo lỗi
        else {
          $error = 'Insert thất bại';
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
<h1 class = "text-secondary" style = "text-align: center"> Đăng Ký Mua Hoa</h1>
<div class="form-group" >
    <label>Tên Khách Hàng:</label>
    <input type="text" class="form-control" placeholder="Nhập tên"  name = "name">
  </div>
  <div class="form-group">
    <label>Số điện thoại:</label>
    <input type="number" class="form-control" placeholder="Nhập số điện thoại" name = "number">
  </div>
  <div class="form-group">
    <label>Ghi chú:</label>
    <textarea class="form-control" name = "description" rows="3" placeholder="Nhập ghi chú" ></textarea>
  <div class="form-group">
    <label>Hình ảnh</label>
    <input type="file" class="form-control" placeholder="Hình ảnh" name = "avatar">
  </div>
  <input type="submit" name = "submit" class="btn btn-success" value = "Đăng Nhập">
  <a href="category.php" class = "text-danger">Thoát</a>
</form> 
</div>

</body>
</html>