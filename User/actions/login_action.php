<?php
session_start(); 

include('../connect.php');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Kiểm tra đăng nhập
    $sql = "SELECT * FROM user WHERE uname = '$username' AND upassword = '$password'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        // Lấy thông tin user
        $user = $result->fetch_assoc();

        // Lưu uid vào session
        $_SESSION['uid'] = $user['uid'];
        $_SESSION['uname'] = $user['uname'];

        // Đăng nhập thành công, chuyển hướng đến trang khác
        header("Location:../index.php");
        exit();
    } else {
        // Đăng nhập thất bại, chuyển hướng trở lại trang đăng nhập với thông báo lỗi
        header("Location:../login.php?error=1");
        exit();
    }
}

$conn->close();
?>
