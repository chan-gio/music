<script>
        // Đối tượng Audio để phát nhạc
        var audioPlayer = new Audio();
        var songs = [];

        // Biến để kiểm tra trạng thái hiện tại của audio (đang phát hoặc dừng)
        var isPlaying = false;
        // Biến để theo dõi vị trí của bài hát hiện tại
        var currentSongIndex = 0;

        document.addEventListener('DOMContentLoaded', function() {
            var songList = document.getElementById('songList');
            var songIndex = 0; // Biến đếm vị trí của bài hát

            <?php
            // Truy vấn cơ sở dữ liệu để lấy các bài hát
            $sql = "(SELECT s.sid AS id, s.sname AS sname, GROUP_CONCAT(a.aname) AS aname , s.simage AS simage , s.slink AS slink 
            FROM songs s
            JOIN songs_artists l ON s.sid = l.sid
            JOIN artists a ON l.aid = a.aid
            group by s.sid, s.sname
            ORDER BY RAND()
            LIMIT 50);";
            $result = $conn->query($sql);

            // Hiển thị các liên kết đến bài hát và thêm chúng vào mảng songs
            if ($result->num_rows > 0) {
                while($row = $result->fetch_assoc()) {
                    $title = $row["sname"];
                    $url = "../songs/".$row["slink"];
                    $image = "../images/".$row["simage"];
                    $aname = isset($row["aname"]) ? $row["aname"] : "Unknown";
            ?>
                    // Tạo một hàm xử lý sự kiện click cho mỗi liên kết đến bài hát
                    function createClickHandler(index) {
                        return function() {
                            currentSongIndex = index; // Cập nhật vị trí của bài hát được chọn
                            playCurrentSong(); // Phát bài hát được chọn
                        };
                    }

                    var listItem = document.createElement('li');
                    var link = document.createElement('a');
                    link.href = 'javascript:void(0)';
                    link.innerText = '<?php echo $title;?>';
                    
                    // Lắng nghe sự kiện click của các liên kết đến bài hát và sử dụng hàm xử lý sự kiện được tạo ra
                    link.addEventListener('click', createClickHandler(songIndex));

                    var img = document.createElement('img');
                    img.src = '<?php echo $image; ?>';
                    img.alt = '<?php echo $title; ?>';
                    img.style.width = '50px'; // Có thể điều chỉnh kích thước ảnh tùy ý

                    listItem.appendChild(img); // Thêm ảnh vào mục danh sách
                    listItem.appendChild(link);
                    songList.appendChild(listItem);

                    // Thêm bài hát vào mảng songs
                    songs.push({
                        title: '<?php echo $title; ?>',
                        url: '<?php echo $url; ?>',
                        author: '<?php echo $aname; ?>',
                        image: '<?php echo $image; ?>'
                    });

                    songIndex++; // Tăng biến đếm vị trí của bài hát
            <?php
                }
            } else {
                echo "console.log('0 results');";
            }
            ?>
        });


        function playCurrentSong() {
            var currentSong = songs[currentSongIndex];
            audioPlayer.src = currentSong.url;
            audioPlayer.play();

            var currentSongTitle = document.getElementById('currentSongTitle');
            var currentSongAuthor = document.getElementById('currentSongAuthor');
            var currentSongImage = document.getElementById('currentSongImage');
            
            // Cập nhật thông tin bài hát đang phát lên phần "Now Playing"
            var queueSongTitle = document.getElementById('queueSongTitle');
            var queueSongAuthor = document.getElementById('queueSongAuthor');
            var queueSongImage = document.getElementById('queueSongImage');
            
            currentSongTitle.innerText = "Bài hát: " + currentSong.title;
            currentSongAuthor.innerText = "Tác giả: " + currentSong.author;
            currentSongImage.src = currentSong.image;

            // Ẩn bài hát đang phát trong danh sách
            var songItems = document.getElementById('songList').getElementsByTagName('li');
            for (var i = 0; i < songItems.length; i++) {
                songItems[i].classList.remove('playing');
            }
            var currentSongItem = songItems[currentSongIndex];
            currentSongItem.classList.add('playing');

            // Đối với phần "Now Playing", bạn muốn cập nhật thông tin của bài hát hiện tại, không phải của queueSongTitle, queueSongAuthor và queueSongImage.
            // Bạn cũng cần cập nhật src của queueSongImage, không phải của queueSongTitle.
            // queueSongTitle.innerText = "Bài hát: " + currentSong.title;
            // queueSongAuthor.innerText = "Tác giả: " + currentSong.author;
            // queueSongImage.src = currentSong.image;
        }


        
         // Lắng nghe sự kiện click của nút Previous
         var previousButton = document.getElementById('previousButton');
        previousButton.addEventListener('click', function() {
            if (currentSongIndex > 0) {
                currentSongIndex--;
            } else {
                currentSongIndex = songs.length - 1; // Chuyển đến bài hát cuối cùng nếu đang ở đầu danh sách
            }
            playCurrentSong();
        });

        // Lắng nghe sự kiện click của nút Next
        var nextButton = document.getElementById('nextButton');
        nextButton.addEventListener('click', function() {
            if (currentSongIndex < songs.length - 1) {
                currentSongIndex++;
            } else {
                currentSongIndex = 0; // Chuyển đến bài hát đầu tiên nếu đang ở cuối danh sách
            }
            playCurrentSong();
        });
       // Lắng nghe sự kiện play của đối tượng Audio
        var playImgSrc = '../images/logo/play.png';  // Đường dẫn hình ảnh cho trạng thái phát
        var pauseImgSrc = '../images/logo/Pause.png';
        var playPauseButtonImg = document.createElement('img'); // Tạo một thẻ hình ảnh để sử dụng cho nút play/pause
        playPauseButtonImg.src = playImgSrc; // Đặt hình ảnh ban đầu của nút là hình ảnh play

        audioPlayer.addEventListener('play', function() {
            // Đặt biến isPlaying thành true khi bài hát được phát
            isPlaying = true;

            // Thay đổi nội dung của nút từ văn bản thành hình ảnh dựa trên trạng thái hiện tại
            playPauseButton.innerHTML = ''; // Xóa nội dung hiện tại của nút play/pause
            playPauseButton.appendChild(playPauseButtonImg); // Thêm thẻ hình ảnh vào nút play/pause
            playPauseButtonImg.src = pauseImgSrc; // Đặt hình ảnh của nút thành hình ảnh pause\
            playPauseButtonImg.style.height = '10px'; // Đặt chiều cao của hình ảnh nút play

        });

        // Lắng nghe sự kiện pause của đối tượng Audio
        audioPlayer.addEventListener('pause', function() {
            // Đặt biến isPlaying thành false khi bài hát dừng
            isPlaying = false;
            // Đổi nút phát/dừng thành nút phát
            playPauseButtonImg.src = playImgSrc; // Đặt lại hình ảnh của nút thành hình ảnh play
        });



         // Lắng nghe sự kiện input của thanh trạng thái thời gian để tua
        var progressBar = document.getElementById('progressBar');
        progressBar.addEventListener('input', function() {
            var seekTime = audioPlayer.duration * (progressBar.value / 100);
            audioPlayer.currentTime = seekTime;
        });
        // Lắng nghe sự kiện timeupdate của đối tượng Audio để cập nhật thanh trạng thái thời gian và thời gian hiện tại
        audioPlayer.addEventListener('timeupdate', function() {
            // Lấy thời gian hiện tại và tổng thời gian của bài hát
            var currentTime = audioPlayer.currentTime;
            var duration = audioPlayer.duration;

            // Tính toán phần trăm tiến độ của bài hát
            var progressPercent = (currentTime / duration) * 100;

            // Cập nhật giá trị của thanh trạng thái thời gian
            var progressBar = document.getElementById('progressBar');
            progressBar.value = progressPercent;

            // Cập nhật thời gian hiện tại và tổng thời gian hiển thị
            var currentTimeDisplay = formatTime(currentTime);
            var totalTimeDisplay = formatTime(duration);
            var currentTimeElement = document.getElementById('currentTime');
            var totalTimeElement = document.getElementById('totalTime');
            currentTimeElement.textContent = currentTimeDisplay;
            totalTimeElement.textContent = totalTimeDisplay;
        });

        // Hàm để định dạng thời gian từ giây thành mm:ss
        function formatTime(time) {
            var minutes = Math.floor(time / 60);
            var seconds = Math.floor(time % 60);
            seconds = seconds < 10 ? '0' + seconds : seconds;
            return minutes + ':' + seconds;
        }

        // Lắng nghe sự kiện input của thanh trạng thái thời gian để tua
        var progressBar = document.getElementById('progressBar');
        progressBar.addEventListener('input', function() {
            var seekTime = audioPlayer.duration * (progressBar.value / 100);
            audioPlayer.currentTime = seekTime;
        });

        // Lắng nghe sự kiện click của nút phát/dừng
        var playPauseButton = document.getElementById('playPauseButton');
        playPauseButton.addEventListener('click', function() {
            if (isPlaying) {
                audioPlayer.pause(); // Nếu đang phát, dừng lại
            } else {
                audioPlayer.play(); // Nếu không, phát
            }
        });

        // Lắng nghe sự kiện click của nút lặp lại
        var repeatButton = document.getElementById('repeatButton');
        repeatButton.addEventListener('click', function() {
        // Đảo ngược trạng thái lặp lại
        audioPlayer.loop = !audioPlayer.loop;

        // Thêm thông báo
        var alertMessage = audioPlayer.loop ? 'Lặp lại đã được bật.' : 'Lặp lại đã được tắt.';
        alert(alertMessage);
});

        // Biến để kiểm tra trạng thái của chế độ lặp lại
        var isShuffleOn = false;

        // Hàm để phát bài hát ngẫu nhiên khi kết thúc bài hát hiện tại
        function playRandomSong() {
            if (!isShuffleOn) { // Kiểm tra nếu chế độ lặp lại không được bật
                if (!audioPlayer.paused) {
                    // Nếu bài hát vẫn đang phát, đợi cho đến khi kết thúc trước khi chuyển sang bài hát ngẫu nhiên
                    audioPlayer.addEventListener('ended', function onEnded() {
                        audioPlayer.removeEventListener('ended', onEnded); // Xóa bỏ trình nghe sự kiện để tránh gọi nhiều lần
                        var randomIndex = Math.floor(Math.random() * songs.length);
                        currentSongIndex = randomIndex;
                        playCurrentSong();
                    });
                }
            }
        }

        // Lắng nghe sự kiện click của nút phát ngẫu nhiên
        var shuffleButton = document.getElementById('shuffleButton');
        shuffleButton.addEventListener('click', function() {
        isShuffleOn = !isShuffleOn; // Đảo ngược trạng thái của chế độ lặp lại
        
        if (isShuffleOn) {
            shuffleButton.style.color = 'red'; // Đổi màu của nút để chỉ ra rằng chế độ lặp lại đã được bật
            alert("Chế độ Shuffle đã được bật!");
        } else {
            shuffleButton.style.color = ''; // Xóa màu của nút
            alert("Chế độ Shuffle đã được tắt!");
        }

        playRandomSong();
});

        // Lắng nghe sự kiện ended của đối tượng Audio để tự động chuyển sang bài hát tiếp theo
        audioPlayer.addEventListener('ended', function() {
            if (!audioPlayer.loop) { // Nếu không bật chế độ lặp lại
                if (isShuffleOn) { // Kiểm tra nếu chế độ phát ngẫu nhiên được bật
                    var randomIndex = Math.floor(Math.random() * songs.length); // Lấy ngẫu nhiên một bài hát từ danh sách
                    currentSongIndex = randomIndex;
                } else { // Nếu không, chuyển sang bài hát tiếp theo trong danh sách
                    currentSongIndex = (currentSongIndex + 1) % songs.length;
                }
                playCurrentSong();
            }
        });

      // Lưu trạng thái phát nhạc vào localStorage
        function savePlayerState() {
            localStorage.setItem('currentSongIndex', currentSongIndex);
            localStorage.setItem('isPlaying', isPlaying);
            // Lưu URL của bài hát hiện tại, nếu có
            if (currentSongIndex >= 0 && currentSongIndex < songs.length) {
                localStorage.setItem('currentSongURL', songs[currentSongIndex].url);
            }
            // Lưu thời gian hiện tại của bài hát
            localStorage.setItem('currentTime', audioPlayer.currentTime);
        }

        // Khôi phục trạng thái phát nhạc từ localStorage
        function restorePlayerState() {
            currentSongIndex = parseInt(localStorage.getItem('currentSongIndex')) || 0;
            isPlaying = localStorage.getItem('isPlaying') === 'true';
            var currentSongURL = localStorage.getItem('currentSongURL');
            var currentTime = parseFloat(localStorage.getItem('currentTime')) || 0;

            // Nếu có URL của bài hát được lưu trữ, tìm chỉ số của bài hát dựa trên URL và phát bài hát
            if (currentSongURL) {
                for (var i = 0; i < songs.length; i++) {
                    if (songs[i].url === currentSongURL) {
                        currentSongIndex = i;
                        break;
                    }
                }
                // Phát bài hát
                if (isPlaying) {
                    playCurrentSong();
                }
                else{
                    playCurrentSong();
                    audioPlayer.pause()
                }
                // Thiết lập thời gian của bài hát
                audioPlayer.currentTime = currentTime;
            }
        }

        // Lắng nghe sự kiện trước khi trang được tải hoặc đóng
        window.addEventListener('beforeunload', function() {
            savePlayerState();
        });

        // Khôi phục trạng thái phát nhạc khi trang được tải
        document.addEventListener('DOMContentLoaded', function() {
            restorePlayerState();
        });
    </script>
    <style>
        .playing {
    display: none;
    
}   </style>
