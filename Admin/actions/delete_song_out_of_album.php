<?php
// Kết nối đến cơ sở dữ liệu
include("connect.php");
session_start();

// Kiểm tra xem có tham số sid và alid được truyền từ URL không
if (isset($_GET['sid']) && isset($_GET['alid'])) {
    $songId = $_GET['sid'];
    $albumId = $_GET['alid'];

    // Thực hiện xóa bài hát khỏi album
    $deleteQuery = "DELETE FROM albums_songs WHERE sid = $songId AND alid = $albumId";
    if ($conn->query($deleteQuery) === TRUE) {
        $_SESSION["album_edit_error"]="Xóa bài hát khỏi album thành công!";
        header("Location:../index.php?manage=Album");
    } else {
        echo "Lỗi: " . $conn->error;
    }
} else {
    echo "Thiếu tham số sid hoặc alid";
}

// Đóng kết nối
$conn->close();
?>
