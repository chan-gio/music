<?php
require_once '../connect.php';

// Kiểm tra nếu không có id được gửi đến
if (!isset($_GET['id'])) {
    http_response_code(400);
    echo json_encode(['success' => false, 'message' => 'Invalid request']);
    exit;
}

$songId = $_GET['id'];

// Truy vấn SQL để tăng số lượt xem của bài hát
$sql = "UPDATE songs SET sview = sview + 1 WHERE sid = ?";

// Truy vấn SQL để tăng số lượt xem của nghệ sĩ có liên quan đến bài hát
$sql2 = "UPDATE artists a
        JOIN songs_artists c ON a.aid = c.aid
        JOIN songs b ON c.sid = b.sid
        SET a.aview = a.aview + 1
        WHERE b.sid = ?";
        
try {
    $conn->begin_transaction();

    // Thực thi truy vấn SQL cho bài hát
    $stmt = $conn->prepare($sql);
    $stmt->bind_param('i', $songId);
    $stmt->execute();
    $stmt->close();

    // Thực thi truy vấn SQL cho nghệ sĩ
    $stmt2 = $conn->prepare($sql2);
    $stmt2->bind_param('i', $songId);
    $stmt2->execute();
    $stmt2->close();

    $conn->commit();

    echo json_encode(['success' => true]);
} catch (Exception $e) {
    $conn->rollback();
    http_response_code(500);
    echo json_encode(['success' => false, 'message' => 'Failed to increase view count: ' . $e->getMessage()]);
}
?>
