<?php
include("../connect.php");

// Nhận dữ liệu từ yêu cầu AJAX
$songid = $_GET['songid'];
$playlistId = $_GET['playlistid'];

// Thực hiện kiểm tra trùng lặp trong cơ sở dữ liệu
$checkQuery = "SELECT * FROM songs_playlist WHERE sid = $songid AND pid = $playlistId";
$result = $conn->query($checkQuery);

// Trả kết quả về cho JavaScript
if ($result->num_rows > 0) {
    echo 'true';
} else {
    echo 'false';
}

$conn->close();
?>
