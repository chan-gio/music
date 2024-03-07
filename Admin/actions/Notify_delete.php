<?php
session_start();

if ($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET["nid"])) {
    // Kết nối đến CSDL
    include("../connect.php");

    // Lấy giá trị nid từ query parameter
    $nid = $_GET["nid"];

    // Xóa thông báo từ bảng notify
    $sqlDeleteNotify = "DELETE FROM notify WHERE nid = $nid";

    if ($conn->query($sqlDeleteNotify) === TRUE) {
        $_SESSION["notify_edit_error"] = "Xóa thông báo thành công!";
    } else {
        $_SESSION["notify_edit_error"] = "Lỗi khi xóa thông báo: " . $conn->error;
    }

    // Đóng kết nối CSDL
    $conn->close();
} else {
    $_SESSION["notify_edit_error"] = "Phương thức yêu cầu không hợp lệ hoặc nid không được cung cấp!";
}

// Chuyển hướng về trang quản lý thông báo
header("Location: ../index.php?manage=Notify");
exit();
?>
