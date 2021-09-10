<?php
    require_once 'database.php';
    // Lấy ra toàn bộ danh mục trong bảng user vừa khởi tạo
    // Truy vấn dữ liệu
    $sql_select_all = "SELECT * FROM tbl_user";
    // Thực thi truy vấn dữ liệu
    $result_all = mysqli_query($connection, $sql_select_all);
    // Lấy ra mảng dữ liệu từ tbl_user 
    // Trả về mảng kết hợp
    $categories = mysqli_fetch_all($result_all, MYSQLI_ASSOC);
    echo "<pre>";
    print_r($categories);
    echo "</pre>";
?>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="bootstrap-4.5.0-dist/css/bootstrap.min.css">
    <title>Category</title>
</head>
<body>
    <form action="create.php" method = "post">
        <input type="submit" name = "submit2" class="btn btn-danger" value = "Thêm mới">
    </form>
    <table class="table" border = "1" cellspacing = "0" cellpading = "8">
    <thead class="thead-dark">
      <tr>
        <th>ID</th>
        <th>Tên</th>
        <th>Số điện thoại</th>
        <th>Ghi chú</th>
        <th>Hình ảnh</th>
        <th>Thời gian</th>
        <th>Thao tác</th>
      </tr>
      
    </thead>
    <tbody>
      <!-- Sử dụng vòng lặp foreach để in mảng ra dữ liệu từ bảng tbl_user
          vào table -->
          <!-- Khởi tạo vòng lặp foreach -->
    <?php foreach ($categories AS $values): ?>
      <tr>
        <!-- Hiện ra các giá trị id, name, numberphone, description-->
        <td><?php echo $values['id']; ?></td>
        <td><?php echo $values['name']; ?></td>
        <td><?php echo $values['numberphone'] ?></td>
        <td><?php echo $values['description'] ?></td>
        <!-- Hiện ra file ảnh -->
        <td>
            <img src="uploads/<?php echo $values['avatar'] ?>" width="150px">
        </td>
        <!-- Hiện ra thời gian user khởi tạo -->
        <td>
            <?php
               echo date('d-m-Y H:i:s', strtotime($values['created_at']))
            ?>
        </td>
        <!-- Gắn 3 url liên kết với các id để xử lý thêm,sửa,xóa -->
        <td>
        <?php
            $url_detail = 'detail.php?id=' . $values['id'];
            $url_update = 'update.php?id=' . $values['id'];
            $url_delete = 'delete.php?id=' . $values['id'];
            ?>
            <a href="<?php echo $url_detail; ?>"> Xem chi tiết</a>
            <a href="<?php echo $url_update; ?>" style = "color:green">Sửa</a>
            <a href="<?php echo $url_delete; ?>" onclick = "return confirm('Bạn muốn xóa?')"
            style = "color:red">Xóa</a>
        </td>
      </tr>
    <?php endforeach; ?>
    <!-- Kết thúc vòng lặp foreach -->
    </tbody>
  </table>
        
</body>
</html>