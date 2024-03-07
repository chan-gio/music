<?php
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Kết nối đến CSDL
    include("../connect.php");

    // Lấy dữ liệu từ form
    $nname = $_POST['txtnname'];
    $ndesc = $_POST['txtndesc'];
    $nlink = $_POST['txtnlink'];

    if ($_FILES['txtnimage']['size'] > 0) {
        $image_upload_dir = "../../notify/"; // Thư mục lưu trữ ảnh thông báo
        $file_extension = pathinfo($_FILES["txtnimage"]["name"], PATHINFO_EXTENSION);
        $new_image_name = uniqid() . '.' . $file_extension; // Tạo tên mới ngẫu nhiên cho tệp tin ảnh

        $target_file = $image_upload_dir . $new_image_name; // Đường dẫn tệp tin ảnh mới

        // Kiểm tra và di chuyển tệp tin ảnh đã tải lên vào thư mục đích
        if (move_uploaded_file($_FILES["txtnimage"]["tmp_name"], $target_file)) {
            // Thêm thông báo vào bảng notifies
            $sqlAddNotify = "INSERT INTO notify (nname, ndesc, nimage, nlink) VALUES ('$nname', '$ndesc', '$new_image_name', '$nlink')";
            if ($conn->query($sqlAddNotify) === TRUE) {
                $_SESSION["notify_add_error"] = "Thêm thông báo thành công!";
            } else {
                $_SESSION["notify_add_error"] = $conn->error;
            }
        } else {
            $_SESSION["notify_add_error"] = "Lỗi khi tải lên ảnh: " . $_FILES["txtnimage"]["error"];
        }
    } else {
        $_SESSION["notify_add_error"] = "Bạn cần chọn một ảnh!";
    }

    // Đóng kết nối CSDL
    $conn->close();
} else {
    $_SESSION["notify_add_error"] = "Phương thức yêu cầu không hợp lệ!";
}

// Chuyển hướng về trang quản lý thông báo
header("Location: ../index.php?manage=Notify");
exit();
?>
