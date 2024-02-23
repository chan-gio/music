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

<body class="nav-md">
<div class="container body">
    <div class="main_container">
    <?php
        /*Navigation*/
        include("navigation.php");

        /*page content */


        if(!isset($_GET['manage'])) {
          }

          else if($_GET['manage']=='songs'){
              require("SongsManagement.php");
          }
          else if($_GET['manage']=='users'){
            require("UsersManagement.php");
          }
          else if($_GET['manage']=='songs'){
            require("SongsManagement.php");
          }
          else if($_GET['manage']=='Song_add'){
            require("Song_add.php");
          }
          else if($_GET['manage']=='Song_trashcan'){
            require("Song_trashcan.php");
          }
          else if($_GET['manage']=='Song_edit'){
            require("Song_edit.php");
          }
          

       
        /* footer content */
       
     ?>   
    </div>
</div>



  </body>
</html>
