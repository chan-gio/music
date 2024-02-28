<?php
    session_start();
    include("../connect.php");
    if(isset($_SESSION["song_edit_error"])){
        $_SESSION["song_edit_error"] = "";
    };
    $sid = $_GET["sid"];
    $sql = "Update songs set sstatus = 0 where sid=".$sid;
    $conn->query($sql);
    $_SESSION["song_edit_error"]="Xóa bài hát thành công!";
    header("Location:../admin.php?manage=songs");
?>