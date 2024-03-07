<?php
include("connect.php");

if (isset($_GET['query'])) {
    $query = $_GET['query'];

    $sql = "SELECT aname FROM songs WHERE aname LIKE '%$query%'";
    $result = $conn->query($sql);

    $songs = array();
    while ($row = $result->fetch_assoc()) {
        $songs[] = $row['aname'];
    }

    echo json_encode($songs);
}
?>
