<?php
session_start();

// Kiểm tra nếu có dữ liệu được gửi từ form POST
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nid = $_GET["nid"];
    $nname = $_POST["txtnname"];
    $ndesc = $_POST["txtndesc"];
    $nlink = $_POST["txtnlink"];

    // Kết nối đến CSDL
    include("connect.php");

    // Kiểm tra tên thông báo đã tồn tại chưa
    $checkQuery = "SELECT * FROM notify WHERE nname = '$nname' AND nid != $nid";
    $checkResult = $conn->query($checkQuery) or die($conn->error);

    if ($checkResult->num_rows > 0) {
        $_SESSION["notify_edit_error"] = "Tên thông báo: $nname đã tồn tại!";
        header("Location:../index.php?manage=Notify_edit&nid=$nid");
        exit();
    }

    // Update thông báo
    $updateQuery = "UPDATE notify SET nname = '$nname', ndesc = '$ndesc', nlink = '$nlink' WHERE nid = $nid";
    $conn->query($updateQuery) or die($conn->error);

    // Kiểm tra và cập nhật ảnh
    if ($_FILES['txtnimage']['size'] > 0) {
        $image_upload_dir = "../../notify/"; // Thư mục lưu trữ ảnh thông báo
        $file_extension = pathinfo($_FILES["txtnimage"]["name"], PATHINFO_EXTENSION);
        $new_image_name = uniqid() . '.' . $file_extension; // Tạo tên mới ngẫu nhiên cho tệp tin ảnh

        $target_file = $image_upload_dir . $new_image_name; // Đường dẫn tệp tin ảnh mới

        // Kiểm tra và di chuyển tệp tin ảnh đã tải lên vào thư mục đích
        if (move_uploaded_file($_FILES["txtnimage"]["tmp_name"], $target_file)) {
            $updateImageQuery = "UPDATE notify SET nimage = '$new_image_name' WHERE nid = $nid";
            $conn->query($updateImageQuery) or die($conn->error);
        } else {
            $_SESSION["notify_edit_error"] = "Đã có lỗi xảy ra khi tải ảnh lên. Vui lòng thử lại!";
            header("Location:../index.php?manage=Notify_edit&nid=$nid");
            exit();
        }
    }

    $_SESSION["notify_edit_error"] = "Chỉnh sửa thông báo thành công!";
    header("Location:../index.php?manage=Notify");
    exit();
} else {
    // Nếu không có dữ liệu được gửi từ form POST, chuyển hướng trở lại trang trước
    $_SESSION["notify_edit_error"] = "Bạn cần nhập đủ dữ liệu!";
    header("Location:../index.php?manage=Notify_edit&nid=$nid");
    exit();
}
?>
