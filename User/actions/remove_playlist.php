<?php
include "../connect.php";
// Kiểm tra xem yêu cầu có phải là phương thức POST không
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Kiểm tra xem pid đã được gửi đi hay không
    if (isset($_POST['pid'])) {
        // Lấy giá trị của pid từ dữ liệu POST
        $pid = $_POST['pid'];
        
        // Thực hiện xóa bài hát khỏi playlist dựa vào pid
        $sql1 = "DELETE FROM songs_playlist WHERE pid = $pid;";
        $sql2 = "DELETE FROM playlist WHERE pid = $pid;";

        // Thực thi câu lệnh SQL xóa bài hát khỏi playlist và xóa playlist
        if ($conn->query($sql1) === TRUE && $conn->query($sql2) === TRUE) {
            // Trả về phản hồi thành công (HTTP status code 200)
            http_response_code(200);
            echo "Playlist và các bài hát đã được xóa thành công.";
        } else {
            // Nếu có lỗi khi thực thi câu lệnh SQL, trả về phản hồi lỗi (HTTP status code 500) và thông báo lỗi
            http_response_code(500);
            echo "Lỗi: " . $conn->error;
        }
    } else {
        // Nếu pid không được gửi đi, trả về phản hồi lỗi (HTTP status code 400)
        http_response_code(400);
        echo "Lỗi: Không thể xác định playlist cần xóa.";
    }
} else {
    // Nếu không phải là phương thức POST, trả về phản hồi lỗi (HTTP status code 405)
    http_response_code(405);
    echo "Lỗi: Yêu cầu không hợp lệ.";
}
?>
