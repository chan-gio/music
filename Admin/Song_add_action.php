<?php
session_start();

// Kiểm tra nếu có dữ liệu được gửi từ form POST
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $sname = $_POST["txtsname"];
    $sartist = $_POST["txtsartist"];
    $sstatus = $_POST["sstatus"];
    
    

    // Kết nối đến CSDL
    include("connect.php");
    $check = "Select * from songs where sname='" .$sname. "' ";
    $result=$conn->query($check) or die($conn->error);
	if ($result->num_rows>0){
		$_SESSION["song_add_error"]="Bài hát: $sname đã tồn tại!";
		header("Location:admin.php?manage=Song_add");
        exit();
    }
    
    if ($_FILES['txtsimage']['size'] > 0 && $_FILES['txtssrc'] > 0) {
        $image_upload_dir = "../images/"; // Thư mục lưu trữ ảnh
        $file_extension = pathinfo($_FILES["txtsimage"]["name"], PATHINFO_EXTENSION);
        $new_image_name = uniqid() . '.' . $file_extension; // Tạo tên mới ngẫu nhiên cho tệp tin ảnh

        $target_file = $image_upload_dir . $new_image_name; // Đường dẫn tệp tin ảnh mới

        // Kiểm tra và di chuyển tệp tin ảnh đã tải lên vào thư mục đích
        if (move_uploaded_file($_FILES["txtsimage"]["tmp_name"], $target_file)) {
            
        } else {
            $_SESSION["song_add_error"] = "Đã có lỗi xảy ra khi tải ảnh lên. Vui lòng thử lại!";
            header("Location: admin.php?manage=Song_add");
            exit();
        }

        $audio_upload_dir = "../songs/"; // Thư mục lưu trữ nhạc
        $file_extension = pathinfo($_FILES["txtssrc"]["name"], PATHINFO_EXTENSION);
        $new_audio_name = uniqid() . '.' . $file_extension; // Tạo tên mới ngẫu nhiên cho tệp tin nhạc

        $target_file = $audio_upload_dir . $new_audio_name; // Đường dẫn tệp tin nhạc mới

        // Kiểm tra và di chuyển tệp tin nhạc đã tải lên vào thư mục đích
        if (move_uploaded_file($_FILES["txtssrc"]["tmp_name"], $target_file)) {
           
        } else {
                $_SESSION["song_add_error"] = "Đã có lỗi xảy ra khi tải file bài hát lên. Vui lòng thử lại!";
                header("Location: admin.php?manage=Song_add");
                exit();
        }

        //Thực hiện thêm vào database
        $sqlinsert = "INSERT INTO songs (sname, sartist, simg, ssrc, sstatus) VALUES ('$sname', '$sartist', '$new_image_name', '$new_audio_name', $sstatus)";
        if ($conn->query($sqlinsert) === TRUE) {
            $_SESSION["song_add_error"] = "Thêm mới bài hát thành công!";
            header("Location:admin.php?manage=songs");
            exit();
        } else {
            $_SESSION["song_add_error"] = "Lỗi khi thêm bài hát: " . $conn->error;
            header:("Location:admin.php?manage=Song_add");
            exit();
        }
       
    } else {
        $_SESSION["song_error"] = "Bạn cần nhập đủ dữ liệu!";
        header("Location:admin.php?manage=songs");
        exit();
    }
} else {
    // Nếu không có dữ liệu được gửi từ form POST, chuyển hướng trở lại trang Product_add.php
    header("Location: admin.php?manage=Song_add");
    exit();
}
?>
