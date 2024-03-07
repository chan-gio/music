<?php
    session_start();
    include("connect.php");
    if(isset($_SESSION["album_edit_error"])){
        $_SESSION["album_edit_error"] = "";
    };
    if ($_SERVER["REQUEST_METHOD"] == "GET") {
        $alid=$_GET["alid"];
        $sql = "Update albums set alstatus = 1 where alid=".$alid;
        $conn->query($sql);
        $_SESSION["album_edit_error"]="Khôi phục album thành công!";
        header("Location:../index.php?manage=Album_trashcan");
    }
?>