<?php
    session_start();
    include("connect.php");
    if(isset($_SESSION["album_edit_error"])){
        $_SESSION["album_edit_error"] = "";
    };
    $alid = $_GET["alid"];
    $sql = "Update albums set alstatus = 0 where alid=".$alid;
    $conn->query($sql);
    $_SESSION["album_edit_error"]="Xóa album thành công!";
    header("Location:../index.php?manage=Album");
?>