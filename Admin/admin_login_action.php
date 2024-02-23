<?php
session_start(); 

include('connect.php');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $adname = $_POST['adname'];
    $adpassword = $_POST['adpassword'];

    // Kiểm tra đăng nhập
    $sql = "SELECT * FROM admins WHERE adname = '$adname' AND adpassword = '$adpassword'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        // Lấy thông tin admin
        $ad = $result->fetch_assoc();

        // Lưu adminname vào session
        $_SESSION['adname'] = $ad['adname'];

        // Đăng nhập thành công, chuyển hướng đến trang khác
        header("Location: admin.php");
        exit();
    } else {
        // Đăng nhập thất bại, chuyển hướng trở lại trang đăng nhập với thông báo lỗi
        header("Location: admin_login.php?aderror=1");
        exit();
    }
}

$conn->close();
?>
