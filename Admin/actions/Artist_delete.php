<?php
    session_start();
    include("connect.php");
    if(isset($_SESSION["artist_edit_error"])){
        $_SESSION["artist_edit_error"] = "";
    };
    $aid = $_GET["aid"];
    $sql = "Update artists set astatus = 0 where aid=".$aid;
    $conn->query($sql);
    $_SESSION["artist_edit_error"]="Xóa ca sĩ thành công!";
    header("Location:../index.php?manage=artists");
?>