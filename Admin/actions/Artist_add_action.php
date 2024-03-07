<?php
session_start();

// Kiểm tra nếu có dữ liệu được gửi từ form POST
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $aname = $_POST["txtaname"];
    $astatus = $_POST["astatus"];
    
    

    // Kết nối đến CSDL
    include("connect.php");
    $check = "Select * from artists where aname='" .$aname. "' ";
    $result=$conn->query($check) or die($conn->error);
	if ($result->num_rows>0){
		$_SESSION["artist_add_error"]="Ca sĩ: $aname đã tồn tại!";
		header("Location:index.php?manage=Artist_add");
        exit();
    }

    
    
    if ($_FILES['txtaimage']['size'] > 0) {
        $image_upload_dir = "../../artists/"; // Thư mục lưu trữ ảnh
        $file_extension = pathinfo($_FILES["txtaimage"]["name"], PATHINFO_EXTENSION);
        $new_image_name = uniqid() . '.' . $file_extension; // Tạo tên mới ngẫu nhiên cho tệp tin ảnh

        $target_file = $image_upload_dir . $new_image_name; // Đường dẫn tệp tin ảnh mới

        // Kiểm tra và di chuyển tệp tin ảnh đã tải lên vào thư mục đích
        if (move_uploaded_file($_FILES["txtaimage"]["tmp_name"], $target_file)) {
            
        } else {
            $_SESSION["artist_add_error"] = "Đã có lỗi xảy ra khi tải ảnh lên. Vui lòng thử lại!";
            header("Location: index.php?manage=Artist_add");
            exit();
        }

        

        //Thực hiện thêm vào database
        $sqlinsert = "INSERT INTO artists (aname, aimage, aview, astatus) VALUES ('$aname', '$new_image_name', 0, $astatus)";
        if ($conn->query($sqlinsert) === TRUE) {
            $_SESSION["artist_add_error"] = "Thêm mới ca sĩ thành công!";
            header("Location:index.php?manage=artists");
            exit();
        } else {
            $_SESSION["artist_add_error"] = "Lỗi khi thêm ca sĩ: " . $conn->error;
            header("Location:index.php?manage=Artist_add");
            exit();
        }
       
    } else {
        $_SESSION["artist_add_error"] = "Bạn cần nhập đủ dữ liệu!";
        header("Location:index.php?manage=Artist_add");
        exit();
    }
} else {
    // Nếu không có dữ liệu được gửi từ form POST, chuyển hướng trở lại trang Product_add.php
    header("Location: index.php?manage=Artist_add");
    exit();
}
?>
