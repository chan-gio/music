<?php
session_start();
include("connect.php");
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
  <!-- Meta, title, CSS, favicons, etc. -->
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <title>Quản lý</title>


  <!-- Custom Theme Style -->
  <link rel="stylesheet" href="sidebar.css">
</head>

<?php

if (!isset($_SESSION['adname'])) {
  // User is not logged in, display a message and redirect to login.php
  echo '<script>
   alert("Bạn cần đăng nhập.");
   window.location.href = "admin_login.php";
 </script>';
  exit(); // Stop further execution after redirect
}
?>

<body class="nav-md">
  <div class="container body">
    <div class="main_container">
      <?php
      /*Navigation*/
      include("navigation.php");

      /*page content */


      if (!isset($_GET['manage'])) {
      } else if ($_GET['manage'] == 'songs') {
        require("SongsManagement.php");
      } else if ($_GET['manage'] == 'users') {
        require("UsersManagement.php");
      } else if ($_GET['manage'] == 'songs') {
        require("SongsManagement.php");
      } else if ($_GET['manage'] == 'Song_add') {
        require("Song_add.php");
      } else if ($_GET['manage'] == 'Song_trashcan') {
        require("Song_trashcan.php");
      } else if ($_GET['manage'] == 'Song_edit') {
        require("Song_edit.php");
      } else if ($_GET['manage'] == 'artists') {
        require("ArtistsManagement.php");
      } else if ($_GET['manage'] == 'Artist_add') {
        require("Artist_add.php");
      } else if ($_GET['manage'] == 'Artist_trashcan') {
        require("Artist_trashcan.php");
      } else if ($_GET['manage'] == 'Artist_edit') {
        require("Artist_edit.php");
      } else if ($_GET['manage'] == 'Album') {
        require('AlbumManagement.php');
      } else if ($_GET['manage'] == 'Album_trashcan') {
        require("Album_trashcan.php");
      } else if ($_GET['manage'] == 'Song_in_album_edit') {
        require("Song_in_album_edit.php");
      } else if ($_GET['manage'] == 'Album_add') {
        require("Album_add.php");
      } else if ($_GET['manage'] == 'Album_edit') {
        require("Album_edit.php");
      } else if ($_GET['manage'] == 'Notify') {
        require("NotifyManagement.php");
      } else if ($_GET['manage'] == 'Notify_add') {
        require("Notify_add.php");
      } else if ($_GET['manage'] == 'Notify_edit') {
        require("Notify_edit.php");
      }

      /* footer content */

      ?>
    </div>
  </div>



</body>

</html>