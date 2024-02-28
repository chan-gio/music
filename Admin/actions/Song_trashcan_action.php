<?php
    session_start();
    include("connect.php");
    if(isset($_SESSION["song_edit_error"])){
        $_SESSION["song_edit_error"] = "";
    };
    if ($_SERVER["REQUEST_METHOD"] == "GET") {
        $sid=$_GET["sid"];
        $sql = "Update songs set sstatus = 1 where sid=".$sid;
        $conn->query($sql);
        $_SESSION["song_edit_error"]="Khôi phục bài hát thành công!";
        header("Location:../admin.php?manage=Song_trashcan");
    }
?>