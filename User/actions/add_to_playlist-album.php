<?php
include "../connect.php";
session_start();
// Kiểm tra xem dữ liệu đã được gửi qua phương thức POST chưa
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Kiểm tra xem songid và playlistIds có được gửi đi không
    if (isset($_POST['songid']) && isset($_POST['playlistId'])) {
        $alid = $_GET['alid'];
        // Lấy giá trị của songid từ dữ liệu POST
        $songid = $_POST['songid'];
        // Lấy mảng các playlistIds từ dữ liệu POST
        $playlistIds = $_POST['playlistId'];
        // Chuyển đổi chuỗi playlistIds thành mảng
        $playlistIdsArray = explode(",", $playlistIds);

        // Lặp qua từng playlistId và thực hiện chèn vào cơ sở dữ liệu
        foreach ($playlistIdsArray as $playlistId) {
            // Thực hiện truy vấn chèn dữ liệu vào cơ sở dữ liệu
            $sql = "INSERT INTO `songs_playlist`(`pid`, `sid`) VALUES ('$playlistId','$songid')";
            // Thực thi truy vấn và kiểm tra kết quả
            if ($conn->query($sql) === TRUE) {
                echo "Bài hát mới đã được thêm vào playlist của bạn.";
                $_SESSION['notify'] = 'Thêm vào danh sách phát thành công!';
                header("Location:../index.php?sort=album_detail&id=$alid");
            } else {
                echo "Lỗi: " . $sql . "<br>" . $conn->error;
            }
        }
    } else {
        // Nếu songid hoặc playlistId không được gửi đi, xử lý tùy ý, ví dụ: hiển thị thông báo lỗi
        echo "Lỗi: Không thể lấy được songid hoặc playlistId.";
    }
} else {
    // Nếu không phải là phương thức POST, xử lý tùy ý, ví dụ: chuyển hướng hoặc hiển thị thông báo lỗi
    echo "Lỗi: Yêu cầu không hợp lệ.";
}
?>
