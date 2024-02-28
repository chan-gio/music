<?php
session_start();

// Kiểm tra nếu có dữ liệu được gửi từ form POST
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $aname = $_POST["txtaname"];
    $aid = $_GET["aid"];

    // Kết nối đến CSDL
    include("connect.php");
    $check = "Select * from artists where aname='" . $aname . "' AND aid != $aid";
    $result = $conn->query($check) or die($conn->error);
    if ($result->num_rows > 0) {
        $_SESSION["artist_edit_error"] = "Tên ca sĩ: $aname đã tồn tại!";
        header("Location:../admin.php?manage=Artist_edit&aid=$aid");
        exit();
    }

    
    

    $sql = "Update artists set aname ='$aname' where aid = $aid";
    $conn->query($sql) or die($conn->error);

    // Sửa ảnh
    if ($_FILES['txtaimage']['size'] > 0) {
        $image_upload_dir = "../artists/"; // Thư mục lưu trữ ảnh
        $file_extension = pathinfo($_FILES["txtaimage"]["name"], PATHINFO_EXTENSION);
        $new_image_name = uniqid() . '.' . $file_extension; // Tạo tên mới ngẫu nhiên cho tệp tin ảnh

        $target_file = $image_upload_dir . $new_image_name; // Đường dẫn tệp tin ảnh mới
        // Kiểm tra và di chuyển tệp tin ảnh đã tải lên vào thư mục đích
        if (move_uploaded_file($_FILES["txtaimage"]["tmp_name"], $target_file)) {
            $sql = "Update artists set aimage = '$new_image_name' where aid = $aid";
            $conn->query($sql) or die($conn->error);
        } else {
            $_SESSION["artist_edit_error"] = "Đã có lỗi xảy ra khi tải ảnh lên. Vui lòng thử lại!";
            header("Location:../admin.php?manage=Artist_edit");
            exit();
        }
    }

    

    $_SESSION["artist_edit_error"] = "Sửa ca sĩ thành công!";
    header("Location:../admin.php?manage=artists");
    exit();
} else {
    // Nếu không có dữ liệu được gửi từ form POST, chuyển hướng trở lại trang trước
    $_SESSION["artist_edit_error"] = "Bạn cần nhập đủ dữ liệu!";
    header("Location:../admin.php?manage=Artist_edit&=aid=$aid");
    exit();
}
?>
