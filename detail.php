<?php
    require_once 'database.php';
    // Nếu id k tồn tại hoặc id ko phải là số thì sẽ báo lỗi
    // Nếu ko hợp lệ lập tức quay trở về trang category để kiểm tra lại dữ liệu
    if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
        $_SESSION['error']= 'ID ko hợp lệ';
        header('Location: category.php');
        exit();
    }
    $id = $_GET['id'];
    // Tạo câu truy vấn
    $sql_select_one = "SELECT * FROM tbl_user WHERE id = $id";
    // Thực hiện câu truy vấn
    $result_one = mysqli_query($connection, $sql_select_one);
    // Vì khi bấm kiểm tra thì sẽ kiểm tra từng bảng 1
    // Trả về mảng 1 chiều
    $category = mysqli_fetch_assoc($result_one);
    // kiểm tra xem nếu không có danh mục thì sẽ báo lỗi
    if (empty($category)) {
        echo "Không có dữ liệu tương ứng với bản ghi có id = $id";
    
    return;
    }
?>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="bootstrap-4.5.0-dist/css/bootstrap.min.css">
    <title>Bản xem chi tiết</title>
</head>
<body>
ID: <?php echo $category['id']?><br>
Tên: <?php echo $category['name']?><br>
Số điện thoại: <?php  echo $category['numberphone']?><br>
Ghi chú: <?php echo $category ['description']?><br>
Hình ảnh: <img src="uploads/<?php echo $category ['avatar']; ?>" width="180px"><br>
Thời gian: <?php echo $category['created_at']?><br>
<form action="category.php" method = "post">
<input type="submit" name = "submit3" class="btn btn-danger" value = "Quay lại">
</form>
</body>
</html>