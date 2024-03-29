<?php
header('Content-Type: application/json');
include("connect.php");

// Kiểm tra nếu request là AJAX và có tham số alid
if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST['alid'])) {
    $alid = $_POST['alid'];

    // Tránh SQL Injection bằng cách sử dụng prepared statement
    $query = "SELECT * FROM albums WHERE alid = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $alid);
    $stmt->execute();
    $result = $stmt->get_result();

    $query2 = "SELECT GROUP_CONCAT(DISTINCT artists.aname ORDER BY artists.aname SEPARATOR '\n') AS related_artists
    FROM albums
    JOIN albums_songs ON albums.alid = albums_songs.alid
    JOIN songs ON albums_songs.sid = songs.sid
    JOIN songs_artists ON songs.sid = songs_artists.sid
    JOIN artists ON songs_artists.aid = artists.aid
    WHERE albums.alid = ?
    ";
    $stmt2 = $conn->prepare($query2);
    $stmt2->bind_param("i", $alid);
    $stmt2->execute();
    $artist_names = $stmt2->get_result();

    // Kiểm tra số hàng trả về
    if ($result->num_rows > 0 && $artist_names->num_rows <=0) {
        $row = $result->fetch_assoc();
        $data = array(
            "alid" => $row["alid"],
            "alname" => $row["alname"],
            "alimage" => $row["alimage"],
            "alview" => $row["alview"],
            "alartist" => "Tạm thời chưa có ca sĩ"
            // Thêm các trường dữ liệu khác cần hiển thị
        );
    
        echo json_encode($data);
    }
    else if($result->num_rows > 0 && $artist_names->num_rows >0){
        $row = $result->fetch_assoc();
        $row2 = $artist_names->fetch_assoc();
        $data = array(
            "alid" => $row["alid"],
            "alname" => $row["alname"],
            "alimage" => $row["alimage"],
            "alview" => $row["alview"],
            "alartist" => $row2["related_artists"],
            // Thêm các trường dữ liệu khác cần hiển thị
        );

        echo json_encode($data);
    } else {
        // Trả về JSON thông báo lỗi thay vì in ra trực tiếp
        echo json_encode(["error" => "Không tìm thấy album"]);
    }

    $stmt->close();
    $conn->close();
} else {
    // Trả về JSON thông báo lỗi nếu không phải là request AJAX hoặc thiếu tham số
    echo json_encode(["error" => "Invalid request"]);
}
?>
