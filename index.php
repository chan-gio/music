<!DOCTYPE html>
<html>
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
            case 'podcast_detail':
                require("podcast_detail.php");
                break;
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
<div class ="musicBar" style="display: flex;">
    <div id="playerBar">
        <span id="currentSongTitle">Chưa có bài hát được chọn</span>
        <br>
        <span id="currentSongAuthor">Tác giả: Unknown</span>
        <br>
        <img id="currentSongImage" src="" alt   ="Hình ảnh bài hát">
         <!-- Thêm phần tử hiển thị thời gian -->
         <span id="currentTime">0:00</span> / <span id="totalTime">0:00</span>
    </div>
    <!-- Thêm thanh trạng thái thời gian vào đây -->
    <input type="range" id="progressBar" min="0" value="0" step="1">

    <!-- Thêm nút phát/dừng -->
    <button id="playPauseButton">Phát</button>
    <!-- Thêm nút Previous -->
    <button id="previousButton">Previous</button>
    <!-- Thêm nút Next -->
    <button id="nextButton">Next</button>
    <!-- Thêm nút lặp lại -->
    <button id="repeatButton">Lặp lại</button>
    <!-- Thêm nút phát ngẫu nhiên -->
    <button id="shuffleButton">Phát ngẫu nhiên</button>
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
    <?php
    include "musicBar.php"
    ?>
</body>
</html>
