<?php

include("connect.php");

// Kiểm tra đăng nhập và vai trò của người dùng (ví dụ: chỉ admin mới có quyền quản lý voucher)
if (!isset($_SESSION["notify_edit_error"])){
    $_SESSION["notify_edit_error"]="";
}

if (!isset($_SESSION["notify_add_error"])){
    $_SESSION["notify_add_error"]="";
}

$query = "SELECT *
FROM notify
";
$result = $conn->query($query);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Quản lý thông báo</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link rel="stylesheet" href="./css/Management.css">
   
</head>

<body style="margin-left:100px;background-color: #f1efef">
    <h2 style="margin-top:10px">Quản lý thông báo</h2>
    <br><br>
    <button type="button" class="btn btn-primary"><a class="button-Add" href="index.php?manage=Notify_add">Thêm thông báo</a></button>
    <font color=red><?php echo $_SESSION["notify_edit_error"]; ?></font><br>
    <font color=red><?php echo $_SESSION["notify_add_error"]; ?></font><br>

    <table class="table table-striped" style="background-color:white;border:1px solid #ccc;margin-top:30px;padding:20px">
        <thead>
            <tr>
                <th scope="col">Mã thông báo</th>
                <th scope="col">Tên thông báo</th>
                <th scope="col">Chi tiết</th>
                <th scope="col">Ảnh</th>
                <th scope="col">Đường dẫn</th>
                <th scope="col">Chỉnh sửa</th>
                <th scope="col">Xóa</th>
            </tr>
        </thead>
        <tbody>
            
        <?php
        while ($row = $result->fetch_assoc()) {
            echo "<tr>";
            echo "<td>{$row['nid']}</td>";
            echo "<td>{$row['nname']}</td>";
            echo "<td>{$row['ndesc']}</td>";
            echo '  <td>
                        <img src="../notify/' . $row['nimage'] .'" alt="Notify Image" style="width: 100px; height: auto;">
                    </td>';
            echo "<td><a href='../User/{$row['nlink']}'>{$row['nlink']}</a></td>";


            echo "<td><button type='button' class='btn btn-warning'><a class='button-edit' href='index.php?manage=Notify_edit&nid={$row['nid']}'>Chỉnh sửa</a></button></td>";
            echo '<td><button type="button" class="btn btn-danger"><a class="button-delete" onclick="return confirm(\'Bạn có chắc muốn xóa thông báo: '. $row["nname"] .' không?\')" href="./actions/Notify_delete.php?nid=' . $row["nid"] . '">Xóa</a></button></td>';
            echo "</tr>";
        }
        ?>
        </tbody>
       
    </table>
    
    
</body>

</html>

<?php
unset($_SESSION["notify_add_error"]);
unset($_SESSION["notify_edit_error"]);
// Đóng kết nối
$conn->close();
?>