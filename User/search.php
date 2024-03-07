<?php
// Kết nối đến cơ sở dữ liệu
include "connect.php";

// Lấy giá trị từ ô tìm kiếm
$query = $_GET['q'];

// Thực hiện truy vấn tìm kiếm trong cơ sở dữ liệu
$searchQuery = "SELECT 'song' AS type, s.sid AS id, s.sname AS name, GROUP_CONCAT(a.aname) AS artist , s.simage AS image , s.slink AS link 
                FROM songs s
                JOIN songs_artists b ON s.sid = b.sid
                JOIN artists a ON b.aid = a.aid
                WHERE s.sname LIKE '%$query%' AND s.sstatus=1
                GROUP BY s.sid, s.sname

                UNION

                SELECT 'album' AS type, al.alid AS id, al.alname AS name, GROUP_CONCAT(c.aname) AS artist ,al.alimage AS image, '' AS link
                FROM albums al
                JOIN albums_songs d ON al.alid = d.alid
                JOIN songs e ON e.sid = d.sid
                JOIN songs_artists b ON e.sid = b.sid
                JOIN artists c ON c.aid = b.aid
                WHERE al.alname LIKE '%$query%' AND al.alstatus=1
                GROUP BY al.alid, al.alname
                
                UNION

                SELECT 'artist' AS type, aid AS id, aname AS artist, '' AS sth, aimage AS image, '' AS link
                FROM artists 
                WHERE aname LIKE '%$query%' AND astatus=1
                LIMIT 0, 25";
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
