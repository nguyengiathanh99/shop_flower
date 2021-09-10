<?php
session_start();
    require_once 'database.php';
    //Dựa vào cấu trúc URL, thì sẽ dùng mảng $_GET để lấy giá trị id,để biết đc đang cập nhật trên bản ghi nào
    // xử lý validate cho dữ liệu từ url, vì user có thể sửa đc
    // Nếu id k tồn tại hoặc id ko phải là số thì sẽ báo lỗi
    // Nếu ko hợp lệ lập tức quay trở về trang category để kiểm tra lại dữ liệu
    if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
        $_SESSION['error']= 'ID ko hợp lệ';
        header('Location: category.php');
        exit();
    }
    
    $id = $_GET['id'];
    // Truy vấn CSDL để lấy bản ghi tương ứng với id lấy được từ url
    $sql_select_one = "SELECT * FROM tbl_user WHERE id = $id";
    // Thực thi truy vấn
    $result_one = mysqli_query($connection, $sql_select_one);
    // Trả về mảng 1 chiều
    $category = mysqli_fetch_assoc($result_one);

    if (isset($_POST['submit'])) {
      // Tạo biến
        $name = $_POST['name'];
        $number = $_POST['number'];
        $description = $_POST['description'];
        $avatar_arr = $_FILES['avatar'];
        // Kiểm tra điều kiện tên và ghi chú
        if (empty($name) || empty($description)) {
          $error = ' Không được để trống các trường';
        }
        // Điều kiện nhập số phải lớn hơn 0
        elseif ($number < 0) {
          $error = 'Phải nhập số lớn hơn 0 ';
        }
         // Validate file upload lên phải có dạng ảnh
        // Và lấy ra đuôi file
        elseif ($avatar_arr['error'] == 0 ) {
         //validate file upload phải có dạng ảnh
		    //lấy ra đuôi file
          $extension = pathinfo ($avatar_arr['name'], PATHINFO_EXTENSION);
          // chuyển về ký tự thường
          $extension = strtolower($extension);
          //tạo mảng chứa các đuôi file ảnh hợp lệ
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
              // với chức năng update, trước khi tạo ra đuôi
			        // file mang tính duy nhất thì cần xóa ảnh cũ đi
			        //để tránh rác hệ thống
                @unlink("uploads/$avatar");
                $avatar = time() . '-' .$avatar_arr['name'];
                //upload file từ thư mục tạm của XAMPP vào trong thư mục uploads bạn đã tạo
                move_uploaded_file($avatar_arr['tmp_name'], $dir_upload . '/' . $avatar);
            }
            // Tạo câu truy vấn UPDATE 
            $sql_update = "UPDATE tbl_user SET `name`='$name',`numberphone`='$number',
            `description`='$description',`avatar`='$avatar' WHERE `id` = $id";
            // Thực thi câu truy vấn
            $is_update =  mysqli_query($connection,$sql_update);
            // Nếu update thành công sẽ quay trở về category
            if ($is_update) {
                $_SESSION['success'] = 'Update dữ liệu thành công';
                header('Location: category.php');
                exit();
            }
            // Upadate thất bại sẽ báo lỗi
            else {
              $error = 'Update thất bại';
            }
    
        }
      }
      
?>
<html lang="en">
<head>
    <link rel="stylesheet" href="bootstrap-4.5.0-dist/css/bootstrap.min.css">
    <title>Form sửa dữ liệu</title>
</head>
<body>
<div class="container">
<form action=""  method = "post" enctype="multipart/form-data">
<h1 class = "text-success" style = "text-align: center">Form sửa dữ liệu</h1>
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
  <input type="submit" name = "submit" class="btn btn-success" value = "Sửa">
  
</form> 
</div>

</body>
</html>