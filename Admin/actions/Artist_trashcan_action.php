<?php
    session_start();
    include("connect.php");
    if(isset($_SESSION["artist_edit_error"])){
        $_SESSION["artist_edit_error"] = "";
    };
    if ($_SERVER["REQUEST_METHOD"] == "GET") {
        $aid=$_GET["aid"];
        $sql = "Update artists set astatus = 1 where aid=".$aid;
        $conn->query($sql);
        $_SESSION["artist_edit_error"]="Khôi phục ca sĩ thành công!";
        header("Location:../index.php?manage=Artist_trashcan");
    }
?>