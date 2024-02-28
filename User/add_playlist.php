<?php
include "connect.php";
session_start();
$playlistName = "Tên Playlist mới";
$uid = $_SESSION['uid'];

// Chuẩn bị truy vấn SQL để thêm dòng mới vào bảng playlist
$sql = "INSERT INTO `playlist`(`pid`, `pname`, `uid`) VALUES ('[value-1]','$playlistName','$uid')";

// Thực thi truy vấn và kiểm tra kết quả
if ($conn->query($sql) === TRUE) {
    echo "Dòng mới đã được thêm vào bảng playlist.";
    header("Location:index.php?sort=playList");
} else {
    echo "Lỗi: " . $sql . "<br>" . $conn->error;
}
// header("Location: index.php?sort=playList");

?>
