<?php

include("connect.php");

// Kiểm tra đăng nhập và vai trò của người dùng (ví dụ: chỉ admin mới có quyền quản lý voucher)
if (!isset($_SESSION["album_edit_error"])){
    $_SESSION["album_edit_error"]="";
}

if (!isset($_SESSION["album_add_error"])){
    $_SESSION["album_add_error"]="";
}

$query = "SELECT *
FROM albums
WHERE albums.alstatus = 0;";
$result = $conn->query($query);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Thùng rác</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link rel="stylesheet" href="./css/Management.css">
   
</head>

<body style="margin-left:100px;background-color: #f1efef">
    <h2 style="margin-top:10px">Album đã xóa</h2>
    <font color=red><?php echo $_SESSION["album_edit_error"]; ?></font><br>
    <font color=red><?php echo $_SESSION["album_add_error"]; ?></font><br>
    <button type="button" style="background-color: red;" class="btn btn-primary"><a class="button-Add" href="admin.php?manage=Album">Trở về</a></button>
    <table class="table table-striped" style="background-color:white;border:1px solid #ccc;margin-top:30px;padding:20px">
        <thead>
            <tr>
                <th scope="col">Mã album</th>
                <th scope="col">Tên album</th>
                <th scope="col">Ca sĩ</th>
                <th scope="col">Ảnh</th>
                <th scope="col">Lượt xem</th>
                <th scope="col">Tình trạng</th>
                <th scope="col">Chỉnh sửa</th>
                <th scope="col">Khôi phục</th>
            </tr>
        </thead>
        <tbody>
            
        <?php
        while ($row = $result->fetch_assoc()) {
            echo "<tr>";
            echo "<td>{$row['alid']}</td>";
            echo "<td>{$row['alname']}</td>";
            echo "<td>{$row['alname']}</td>";
            echo '  <td>
                        <img src="../albums/' . $row['alimage'] .'" alt="Album Image" style="width: 100px; height: auto;">
                    </td>';
            echo "<td>{$row['alview']}</td>";

            echo "<td>Đã xóa</td>";
            echo "<td><button type='button' class='btn btn-warning'><a class='button-edit' href='admin.php?manage=Album_edit&aid={$row['alid']}'>Chỉnh sửa</a></button></td>";
            echo '<td><button type="button" class="btn btn-warning"><a class="button-edit" onclick="return confirm(\'Bạn có chắc muốn khôi phục album: '. $row["alname"] .' không?\')" href="./actions/Album_trashcan_action.php?alid=' . $row["alid"] . '">Khôi phục</a></button></td>';
            
            echo "</tr>";
        }
        ?>
        </tbody>
       
    </table>
    
    
</body>

</html>

<?php
unset($_SESSION["album_add_error"]);
unset($_SESSION["album_edit_error"]);
// Đóng kết nối
$conn->close();
?>