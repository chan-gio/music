<?php
// Kết nối đến cơ sở dữ liệu
include "connect.php";

// Lấy giá trị từ ô tìm kiếm
$query = $_GET['q'];

// Thực hiện truy vấn tìm kiếm trong cơ sở dữ liệu
$searchQuery = "SELECT 'song' AS type, s.sid AS id, s.sname AS name, a.aname AS artist , s.simage AS image , s.slink AS link 
                FROM songs s
                JOIN artists a ON s.aid = a.aid
                WHERE s.sname LIKE '%$query%'

                UNION

                SELECT 'album' AS type, al.alid AS album_id, al.alname AS album_name, a.aname AS artist_name ,al.alimage AS album_image, '' AS album_link
                FROM albums al
                JOIN artists a ON al.aid = a.aid
                WHERE al.alname LIKE '%$query%'
                
                -- UNION

                -- SELECT 'podcast' AS type, po.poid AS podcast_id, po.poname AS podcast_name, a.aname AS artist_name ,po.poimage AS podcast_image, '' AS podcast_link
                -- FROM podcasts po
                -- JOIN artists a ON po.aid = a.aid
                -- WHERE po.poname LIKE '%$query%'  

                 UNION

                SELECT 'artist' AS type, aid AS artist_id, aname AS artist_name, '' AS sth, aimage AS artist_image, '' AS artist_link
                FROM artists 
                WHERE aname LIKE '%$query%' LIMIT 0, 25";
$searchResult = $conn->query($searchQuery);

// Xử lý kết quả tìm kiếm
$results = array();
if ($searchResult->num_rows > 0) {
    while ($row = $searchResult->fetch_assoc()) {
        $results[] = $row;
    }
}

// Trả về kết quả dưới dạng JSON
header('Content-Type: application/json');
echo json_encode($results);

// Đóng kết nối
$conn->close();
?>
