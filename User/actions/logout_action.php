<?php
include("../connect.php");
session_start();
unset($_SESSION);
session_unset();

// Kết thúc session
session_destroy();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Clear Local Storage</title>
    <!-- Thêm mã JavaScript để xóa Local Storage -->
    <script>
        localStorage.clear();
        // Chuyển hướng người dùng đến trang login
        window.location.href = "../login.php?error=6";
    </script>
</head>
<body>
    <!-- Nếu cần hiển thị thông báo hoặc nội dung khác, bạn có thể thêm vào đây -->
</body>
</html>
