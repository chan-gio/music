<!DOCTYPE html>
<html style="height: 100%">
<link rel="stylesheet" type="text/css" href="style.css">

<head>
    <title>Phát nhạc</title>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
</head>

<body>

    <div style="display: flex;height: 792px;overflow-y: scroll;overflow-x: none;">
        <?php
        session_start();
        if (!isset($_SESSION['uid'])) {
            $_SESSION['uname'] = 'My account';


            echo '<script>
                    Swal.fire({
                        title: "Bạn cần đăng nhập để truy cập trang này. Bạn có tài khoản chưa?",
                        showCancelButton: true,
                        confirmButtonText: "Có rồi",
                        cancelButtonText: "Chưa"
                    }).then((result) => {
                        if (result.isConfirmed) {
                            window.location.href = "login.php";
                        } else {
                            window.location.href = "signup.php";
                        }
                    });
                </script>';
        }


        $uname = $_SESSION['uname'];



        include "connect.php";
        include "homeBar.php";
        if (!isset($_GET['sort'])) {
            require("mainContent.php");
        } else {
            $sort = $_GET['sort'];
            switch ($sort) {
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
<div class ="musicBar" style="display: flex; flex-direction: row;left: -10px;align-items: center;padding: 16px;gap: 100px;width: 100%;height: 104px;background: #4285F4;flex: none;order: 1;align-self: stretch;flex-grow: 0;position:relative;">
    <div id="playerBar">
    <div style="display: flex">    
    <img id="currentSongImage" src="" alt   ="Hình ảnh bài hát" style="height:90px;top:25px;right: 1080px;bottom: 0%;">
    <div style="width: 500px; display: flex; flex-direction: column; justify-content: center;">
    <span id="currentSongTitle">Chưa có bài hát được chọn</span>
    <br>
    <span id="currentSongAuthor">Tác giả: Unknown</span>
</div>
</div>
    </div>
   
    <div>
    <div>    
    <!-- Thêm thanh trạng thái thời gian vào đây -->
            <input type="range" id="progressBar" min="0" value="0" step="1" style = " width: 700px;">
        
        <!-- Thêm phần tử hiển thị thời gian -->
            <div class="musicprogress" style=" display: flex;
    justify-content: space-between;">
                <span id="currentTime">0:00</span>
                <span id="totalTime">0:00</span>
            </div>
            </div>
    <div style="    text-align: center;">
            <!-- Thêm nút phát ngẫu nhiên -->
    <button id="shuffleButton">
        <img src="../imxages/logo/Random.png">
    </button>
    <!-- Thêm nút Previous -->
    <button id="previousButton">

        <img src="../images/logo/Previous.png" >
    </button>
    <button id="playPauseButton">
        <img src="../images/logo/Pause.png">
    </button>
    <!-- Thêm nút Next -->
    <button id="nextButton">
        <img src="../images/logo/Next.png">
    </button>
    <!-- Thêm nút lặp lại -->
    <!-- Thêm nút phát ngẫu nhiên -->
    <button id="repeatButton">
        <img src="../images/logo/loop.png">
    </button>
    <a href="index.php?sort=queue">
                <i class=""></i>
                <span class="nav-text">
                    Queue
                </span>
            </a>
            <ul id="songList" style="display: none;">
                <!-- Danh sách bài hát sẽ được thêm vào đây bằng JavaScript -->
            </ul>

    </div>
          
        </div>
    </div>
    <?php
    include "musicBar.php"
    ?>
    <!-- <style>
       body {
    transition: background-color 0.5s, color 0.5s;
    }

    .dark-mode body {
    background-color: #333333;
    color: #ffffff;
    }
    </style> -->
    <script src="script.js"></script>

</body>

</html>