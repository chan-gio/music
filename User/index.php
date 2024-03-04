<!DOCTYPE html>
<html>
<link rel="stylesheet" type="text/css" href="style.css">
<head>
    <title>Phát nhạc</title>
    
</head>
<body>
<div style="display: flex;">
    <?php
    session_start();
    include "connect.php";
    include "homeBar.php";
    if(!isset($_GET['sort'])) {
        require("mainContent.php");
    } else {
        $sort = $_GET['sort'];
        switch($sort) {
            case 'search':
                require("searchPage.php");
                break;
            case 'playList':
                require("playList.php");
                break;
            case 'notification':
                require("notification.php");
                break;
            case 'premiumContent':
                require("premiumContent.php");
                break;
            case 'avatar':
                require("avatar.php");
                break;
            case 'album':
                require("album.php");
                break;    
            case 'queue':
                require("queue.php");
                break;    
            case 'song_detail':
                require("song_detail.php");
                break;
            case 'album_detail':
                require("album_detail.php");
                break;
            // case 'podcast_detail':
            //     require("podcast_detail.php");
            //     break;
            case 'artist_detail':
                require("artist_detail.php");
                break;
            case 'playList_detail':
                require("playList_detail.php");
                break;
            default:
                require("mainContent.php");
                break;
        }
    }
    
    ?>



   
</div>
<div class ="musicBar" style="display: flex; flex-direction: row;top 300px;justify-content: space-between;align-items: center;padding: 16px;gap: 16px;width: 1390px;height: 104px;background: #4285F4;flex: none;order: 1;align-self: stretch;flex-grow: 0;position:relative;">
    <div id="playerBar">
        <span id="currentSongTitle">Chưa có bài hát được chọn</span>
        <br>
        <span id="currentSongAuthor">Tác giả: Unknown</span>
        <br>
        <img id="currentSongImage" src="" alt   ="Hình ảnh bài hát" style="width:7%; height:90px;top:25px;position: absolute;right: 1030px;bottom: 0%;">
         <!-- Thêm phần tử hiển thị thời gian -->
        <div class="musicprogress" style="">
            <span id="currentTime">0:00</span> / <span id="totalTime">0:00</span>
        </div>
    </div>
    <!-- Thêm thanh trạng thái thời gian vào đây -->
    <input type="range" id="progressBar" min="0" value="0" step="1">
    <!-- Thêm nút phát ngẫu nhiên -->
    <button id="shuffleButton">
        <img src="../images/logo/Random.png">
    </button>
    <!-- Thêm nút Previous -->
    <button id="previousButton">

        <img src="../images/logo/Previous.png" >
    </button>
    <!-- Thêm nút phát/dừng -->
    <button id="playPauseButton">
        <img src="../images/logo/Pause.png">
    </button>
    <!-- Thêm nút Next -->
    <button id="nextButton">
        <img src="../images/logo/Next.png">
    </button>
    <!-- Thêm nút lặp lại -->
    <button id="repeatButton">
        <img src="../images/logo/loop.png">
    </button>
    
    <div>
    <a href="index.php?sort=queue">
                <i class="fa-solid fa-shirt fa fa-2x"></i>
                <span class="nav-text">
                Queue
                </span>
            </a>
    <ul id="songList" style="display: none;">
        <!-- Danh sách bài hát sẽ được thêm vào đây bằng JavaScript -->
    </ul>
    
</div>
</div>
<style>
    
</style>
    <?php
    include "musicBar.php"
    ?>
</body>
</html>
