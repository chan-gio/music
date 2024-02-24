<?php
include "connect.php";

$playlistName = "Tên Playlist mới";
// $uid = 

// Chuẩn bị truy vấn SQL để thêm dòng mới vào bảng playlist
$sql = "INSERT INTO `playlist`(`pid`, `pname`, `uid`) VALUES ('[value-1]','$playlistName','[value-3]')";

// Thực thi truy vấn và kiểm tra kết quả
if ($conn->query($sql) === TRUE) {
    echo "Dòng mới đã được thêm vào bảng playlist.";
} else {
    echo "Lỗi: " . $sql . "<br>" . $conn->error;
}
// header("Location: index.php?sort=playList");

?>
