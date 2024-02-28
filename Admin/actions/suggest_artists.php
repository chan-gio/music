<?php
include("connect.php");

if (isset($_GET['query'])) {
    $query = $_GET['query'];

    $sql = "SELECT aname FROM artists WHERE aname LIKE '%$query%'";
    $result = $conn->query($sql);

    $artists = array();
    while ($row = $result->fetch_assoc()) {
        $artists[] = $row['aname'];
    }

    echo json_encode($artists);
}
?>
