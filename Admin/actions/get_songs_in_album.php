<?php
include("../connect.php");

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $alid = $_POST['alid'];

    // Thực hiện truy vấn để lấy danh sách bài hát trong album
    $query = "SELECT
    songs.*,
    GROUP_CONCAT(artists.aname SEPARATOR '\n') AS artist_names
FROM
    songs
LEFT JOIN
    songs_artists ON songs.sid = songs_artists.sid
LEFT JOIN
    artists ON songs_artists.aid = artists.aid
WHERE
    songs.sstatus = 1 
    AND EXISTS (
        SELECT 1
        FROM albums_songs
        WHERE albums_songs.sid = songs.sid
        AND albums_songs.alid = $alid
    )
GROUP BY
    songs.sid, songs.sname;";

    $result = $conn->query($query);

    if ($result->num_rows > 0) {
        $songs = array();
        while ($row = $result->fetch_assoc()) {
            $songs[] = $row;
        }

        // Trả về dữ liệu dưới dạng JSON
        echo json_encode($songs);
    } else {
        echo json_encode(array()); // Trả về mảng JSON rỗng nếu không có bài hát nào trong album
    }
} else {
    echo json_encode(array('error' => 'Invalid request')); // Trả về thông báo lỗi nếu request không hợp lệ
}

$conn->close();
?>
