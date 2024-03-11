<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sửa Playlist</title>
</head>
<body>
    <h1>Sửa Playlist</h1>
    <?php
    include "../connect.php";
    session_start();
    // Kiểm tra xem có giá trị pid được truyền từ URL không
    if(isset($_GET['pid'])) {
        // Lấy giá trị pid từ URL
        $pid = $_GET['pid'];

        // Kiểm tra xem có dữ liệu được gửi từ form không
        if(isset($_POST['pname'])) {
            // Lấy giá trị mới của pname từ form
            $newPname = $_POST['pname'];

            // Thực hiện truy vấn cập nhật tên playlist
            $sql = "UPDATE playlist SET pname='$newPname' WHERE pid=$pid";
            if ($conn->query($sql) === TRUE) {
                // Nếu cập nhật thành công, chuyển người dùng về trang danh sách playlist
                header("Location: ../index.php?sort=playList");
                exit();
            } else {
                echo "Lỗi: " . $conn->error;
            }

            // Đóng kết nối cơ sở dữ liệu
            $conn->close();
        } else {
            // Truy vấn cơ sở dữ liệu để lấy thông tin playlist cần sửa
            // ...

            // Hiển thị form chỉnh sửa playlist và điền giá trị cũ vào
            ?>
            <form action="" method="post">
                <input type="hidden" name="pid" value="<?php echo $pid; ?>">
                <label for="pname">Tên Playlist:</label>
                <input type="text" id="pname" name="pname">
                <input type="submit" value="Lưu">
            </form>
            <?php
        }
    } else {
        echo "<p>Không có ID playlist được cung cấp.</p>";
    }
    ?>
</body>
</html>
