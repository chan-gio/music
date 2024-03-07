<?php
session_start();

// Kiểm tra nếu có dữ liệu được gửi từ form POST
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $alname = $_POST["txtalname"];
    $alid = $_GET["alid"];

    // Kết nối đến CSDL
    include("connect.php");
    $check = "Select * from albums where alname='" . $alname . "' AND alid != $alid";
    $result = $conn->query($check) or die($conn->error);
    if ($result->num_rows > 0) {
        $_SESSION["album_edit_error"] = "Tên album: $alname đã tồn tại!";
        header("Location:../index.php?manage=Album_edit&alid=$alid");
        exit();
    }

    
    

    $sql = "Update albums set alname ='$alname' where alid = $alid";
    $conn->query($sql) or die($conn->error);

    // Sửa ảnh
    if ($_FILES['txtalimage']['size'] > 0) {
        $image_upload_dir = "../../albums/"; // Thư mục lưu trữ ảnh
        $file_extension = pathinfo($_FILES["txtalimage"]["name"], PATHINFO_EXTENSION);
        $new_image_name = uniqid() . '.' . $file_extension; // Tạo tên mới ngẫu nhiên cho tệp tin ảnh

        $target_file = $image_upload_dir . $new_image_name; // Đường dẫn tệp tin ảnh mới
        // Kiểm tra và di chuyển tệp tin ảnh đã tải lên vào thư mục đích
        if (move_uploaded_file($_FILES["txtalimage"]["tmp_name"], $target_file)) {
            $sql = "Update albums set alimage = '$new_image_name' where alid = $alid";
            $conn->query($sql) or die($conn->error);
        } else {
            $_SESSION["album_edit_error"] = "Đã có lỗi xảy ra khi tải ảnh lên. Vui lòng thử lại!";
            header("Location:../index.php?manage=Album_edit?alid=".$alid);
            exit();
        }
    }

    

    $_SESSION["album_edit_error"] = "Sửa album thành công!";
    header("Location:../index.php?manage=Album");
    exit();
} else {
    // Nếu không có dữ liệu được gửi từ form POST, chuyển hướng trở lại trang trước
    $_SESSION["album_edit_error"] = "Bạn cần nhập đủ dữ liệu!";
    header("Location:../index.php?manage=Album_edit&=alid=$alid");
    exit();
}
?>
