<?php
session_start();
    unset($_SESSION["adname"]);
    header("location:admin_login.php");
?>
