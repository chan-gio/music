<?php

include("connect.php");

// Kiểm tra đăng nhập và vai trò của người dùng (ví dụ: chỉ admin mới có quyền quản lý voucher)
if (!isset($_SESSION["song_edit_error"])){
    $_SESSION["song_edit_error"]="";
}

if (!isset($_SESSION["song_add_error"])){
    $_SESSION["song_add_error"]="";
}


$query = "SELECT
songs.*,
GROUP_CONCAT(artists.aname SEPARATOR '\n') AS artist_names
FROM
songs
LEFT JOIN songs_artists ON songs.sid = songs_artists.sid
LEFT JOIN artists ON songs_artists.aid = artists.aid
WHERE
songs.sstatus = 0
GROUP BY
songs.sid, songs.sname;
";
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
    <h2 style="margin-top:10px">Bài hát đã xóa</h2>
    <font color=red><?php echo $_SESSION["song_edit_error"]; ?></font><br>
    <font color=red><?php echo $_SESSION["song_add_error"]; ?></font><br>
    <button type="button" style="background-color: red;" class="btn btn-primary"><a class="button-Add" href="admin.php?manage=songs">Trở về</a></button>

    <table class="table table-striped" style="background-color:white;border:1px solid #ccc;margin-top:30px;padding:20px">
        <thead>
            <tr>
                <th scope="col">Mã bài hát</th>
                <th scope="col">Tên bài hát</th>
                <th scope="col">Ca sĩ</th>
                <th scope="col">Nội dung</th>
                <th scope="col">Tình trạng</th>
                <th scope="col">Chỉnh sửa</th>
                <th scope="col">Khôi phục</th>
            </tr>
        </thead>
        <tbody>
            
        <?php
        while ($row = $result->fetch_assoc()) {
            echo "<tr>";
            echo "<td>{$row['sid']}</td>";
            echo "<td>{$row['sname']}</td>";
            echo "<td>" . nl2br($row['artist_names']) . "</td>"; 

            echo '  <td>
                        <img src="../images/' . $row['simage'] .'" alt="Song Image" style="width: 100px; height: auto;">
                        <br>
                        <audio controls>
                        <source src="../songs/'. $row['slink'] .'" type="audio/mpeg">
                        </audio>
                    </td>';

            echo "<td>Đã xóa</td>";
            echo "<td><button type='button' class='btn btn-warning'><a class='button-edit' href='admin.php?manage=Song_edit&sid={$row['sid']}'>Chỉnh sửa</a></button></td>";
            echo '<td><button type="button" class="btn btn-warning"><a class="button-edit" onclick="return confirm(\'Bạn có chắc muốn khôi phục bài hát: '. $row["sname"] .' không?\')" href="./actions/Song_trashcan_action.php?sid=' . $row["sid"] . '">Khôi phục</a></button></td>';
            echo "</tr>";
        }
        ?>
        </tbody>
       
    </table>
    
    
</body>

</html>

<?php
unset($_SESSION["song_add_error"]);
unset($_SESSION["song_edit_error"]);
// Đóng kết nối
$conn->close();
?>