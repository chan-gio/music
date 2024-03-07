<?php
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Kết nối đến CSDL
    include("../connect.php");

    // Lấy dữ liệu từ form
    $alname = $_POST['txtalname'];
    $alstatus = $_POST['alstatus'];

    if ($_FILES['txtalimage']['size'] > 0) {
        $image_upload_dir = "../../albums/"; // Thư mục lưu trữ ảnh
        $file_extension = pathinfo($_FILES["txtalimage"]["name"], PATHINFO_EXTENSION);
        $new_image_name = uniqid() . '.' . $file_extension; // Tạo tên mới ngẫu nhiên cho tệp tin ảnh

        $target_file = $image_upload_dir . $new_image_name; // Đường dẫn tệp tin ảnh mới

        // Kiểm tra và di chuyển tệp tin ảnh đã tải lên vào thư mục đích
        if (move_uploaded_file($_FILES["txtalimage"]["tmp_name"], $target_file)) {
            // Thêm album vào bảng albums
            $sqlAddAlbum = "INSERT INTO albums (alname, alstatus, alimage) VALUES ('$alname', $alstatus, '$new_image_name')";
            if ($conn->query($sqlAddAlbum) === TRUE) {
                // Kiểm tra xem có bài hát nào được chọn không
                if (isset($_POST['txtsongs']) && !empty($_POST['txtsongs'])) {
                    $selectedSongs = $_POST['txtsongs'];

                    // Lấy id của album vừa thêm vào
                    $alid = $conn->insert_id;

                    // Thêm các bài hát vào bảng albums_songs
                    foreach ($selectedSongs as $sid) {
                        $sid = (int)$sid; // Chắc chắn rằng $sid là một số nguyên
                        $sqlAddSongToAlbum = "INSERT INTO albums_songs (alid, sid) VALUES ($alid, $sid)";
                        $conn->query($sqlAddSongToAlbum);
                    }
                }
                $_SESSION["album_add_error"] = "Thêm album thành công!";
                header("Location:../index.php?manage=Album");
                exit();
            } else {
                $_SESSION["album_add_error"] = $conn->error;
            }
        } else {
            $_SESSION["album_add_error"] = "Upload ảnh không thành công: " . $_FILES["txtalimage"]["error"];
        }
    } else {
        $_SESSION["album_add_error"] = "Bạn cần nhập đủ dữ liệu!";
    }

    // Đóng kết nối CSDL
    $conn->close();
}

// Nếu có lỗi hoặc không phải là phương thức POST, chuyển hướng về trang trước đó
header("Location:../index.php?manage=Album_add");
exit();
?>
