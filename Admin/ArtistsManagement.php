<?php

include("connect.php");

// Kiểm tra đăng nhập và vai trò của người dùng (ví dụ: chỉ admin mới có quyền quản lý voucher)
if (!isset($_SESSION["artist_edit_error"])){
    $_SESSION["artist_edit_error"]="";
}

if (!isset($_SESSION["artist_add_error"])){
    $_SESSION["artist_add_error"]="";
}

$query = "SELECT *
FROM artists
WHERE artists.astatus = 1;";
$result = $conn->query($query);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Quản lý ca sĩ</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link rel="stylesheet" href="./css/Management.css">
   
</head>

<body style="margin-left:100px;background-color: #f1efef">
    <h2 style="margin-top:10px">Quản lý ca sĩ</h2>
    <font color=red><?php echo $_SESSION["artist_edit_error"]; ?></font><br>
    <font color=red><?php echo $_SESSION["artist_add_error"]; ?></font><br>
    <button type="button" class="btn btn-primary"><a class="button-Add" href="index.php?manage=Artist_add">Thêm ca sĩ</a></button>
    <button type="button" style="background-color: red;" class="btn btn-primary"><a class="button-Add" href="index.php?manage=Artist_trashcan">Thùng rác</a></button>

    <table class="table table-striped" style="background-color:white;border:1px solid #ccc;margin-top:30px;padding:20px">
        <thead>
            <tr>
                <th scope="col">Mã ca sĩ</th>
                <th scope="col">Tên ca sĩ</th>
                <th scope="col">Ảnh</th>
                <th scope="col">Lượt xem</th>
                <th scope="col">Tình trạng</th>
                <th scope="col">Chỉnh sửa</th>
                <th scope="col">Xóa</th>
            </tr>
        </thead>
        <tbody>
            
        <?php
        while ($row = $result->fetch_assoc()) {
            echo "<tr>";
            echo "<td>{$row['aid']}</td>";
            echo "<td>{$row['aname']}</td>";
            echo '  <td>
                        <img src="../artists/' . $row['aimage'] .'" alt="Artist Image" style="width: 100px; height: auto;">
                    </td>';
            echo "<td>{$row['aview']}</td>";

            echo "<td>Khả dụng</td>";
            echo "<td><button type='button' class='btn btn-warning'><a class='button-edit' href='index.php?manage=Artist_edit&aid={$row['aid']}'>Chỉnh sửa</a></button></td>";
            echo '<td><button type="button" class="btn btn-danger"><a class="button-delete" onclick="return confirm(\'Bạn có chắc muốn xóa ca sĩ: '. $row["aname"] .' không?\')" href="./actions/Artist_delete.php?aid=' . $row["aid"] . '">Xóa</a></button></td>';
            echo "</tr>";
        }
        ?>
        </tbody>
       
    </table>
    
    
</body>

</html>

<?php
unset($_SESSION["artist_add_error"]);
unset($_SESSION["artist_edit_error"]);
// Đóng kết nối
$conn->close();
?>