<?php
include "../connect.php";
// Kiểm tra xem yêu cầu có phải là phương thức POST không
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Kiểm tra xem songid đã được gửi đi hay không
    if (isset($_POST['songid'])) {
        // Lấy giá trị của songid từ dữ liệu POST
        $songid = $_POST['songid'];
        $pid = $_POST['pid'];
        
        // Thực hiện xóa bài hát khỏi playlist dựa vào songid (việc xóa phụ thuộc vào cấu trúc cơ sở dữ liệu của bạn)
        // Code xóa bài hát khỏi playlist ở đây
        $sql = "DELETE FROM songs_playlist WHERE sid = $songid and pid = $pid LIMIT 1;";

        if ($conn->query($sql) === TRUE) {
            // Trả về phản hồi thành công (HTTP status code 200)
            http_response_code(200);
            echo "Bài hát đã được xóa khỏi playlist thành công.";
        } else {
            // Nếu có lỗi khi thực thi câu lệnh SQL, trả về phản hồi lỗi (HTTP status code 500) và thông báo lỗi
            http_response_code(500);
            echo "Lỗi: " . $conn->error;
        }
    } else {
        // Nếu songid không được gửi đi, trả về phản hồi lỗi (HTTP status code 400)
        http_response_code(400);
        echo "Lỗi: Không thể xác định bài hát cần xóa.";
    }
} else {
    // Nếu không phải là phương thức POST, trả về phản hồi lỗi (HTTP status code 405)
    http_response_code(405);
    echo "Lỗi: Yêu cầu không hợp lệ.";
}
?>
