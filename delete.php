<?php
    session_start();        
    require_once 'database.php';
    // Kiểm tra 
    // Nếu id k tồn tại hoặc id ko phải là số thì sẽ báo lỗi
    // Nếu ko hợp lệ lập tức quay trở về trang category để kiểm tra lại dữ liệu
    if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
        $_SESSION['error']= 'ID ko hợp lệ';
        header('Location: category.php');
        exit();
    }
    // Thực hiện truy vấn xóa bản ghi theo ID bắt được từ url
    $id = $_GET['id'];
    // Tạo truy vấn
    $sql_delete = "DELETE FROM tbl_user WHERE id = $id";
    // Thực hiện câu truy vấn vừa tạo
    $is_delete = mysqli_query($connection, $sql_delete);
    // Xóa thành công 
    if ($is_delete) {
        $_SESSION['success'] = 'Xóa bản ghi $id thành công';
    }
    // Xóa thất bịa thì trở về trang category
    else {
        $_SESSION['error'] = 'Xóa bản ghi thất bại';
    }
    header('Location:category.php');
    exit();
?>