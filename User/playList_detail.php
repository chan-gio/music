<div class="playList">
    <ul id="playList">
        <!-- Danh sách bài hát sẽ được thêm vào đây bằng JavaScript -->
    </ul>
</div>

<script>
    // Đối tượng Audio để phát nhạc
    var audioPlayer = new Audio();
    var songs = []; // Mảng chứa danh sách bài hát

    // Hàm phát bài hát hiện tại
    function playCurrentSong() {
        var currentSong = songs[currentSongIndex];
        audioPlayer.src = currentSong.url;
        audioPlayer.play();

        var currentSongTitle = document.getElementById('currentSongTitle');
        var currentSongAuthor = document.getElementById('currentSongAuthor');
        var currentSongImage = document.getElementById('currentSongImage');

        currentSongTitle.innerText = "Bài hát: " + currentSong.title;
        currentSongAuthor.innerText = "Tác giả: " + currentSong.author;
        currentSongImage.src = currentSong.image;
    }

    // Sự kiện DOMContentLoaded để tạo danh sách bài hát
    document.addEventListener('DOMContentLoaded', function() {
        var playList = document.getElementById('playList');

        <?php
        $id = $_GET['id'];
        // Truy vấn cơ sở dữ liệu để lấy các bài hát
        $sql = "SELECT c.*, d.aname FROM playlist a
                JOIN songs_playlist b ON a.pid = b.pid
                JOIN songs c ON b.sid = c.sid
                JOIN artists d ON d.aid = c.aid
                WHERE a.pid = $id";
        $result = $conn->query($sql);

        // Hiển thị các liên kết đến bài hát
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
                link.addEventListener('click', function() {
                    // Lấy index của bài hát được click
                    var index = songs.findIndex(function(song) {
                        return song.url === '<?php echo $url; ?>';
                    });
                    if (index !== -1) {
                        currentSongIndex = index;
                        playCurrentSong();
                    }
                });

                var img = document.createElement('img');
                img.src = '<?php echo $image; ?>';
                img.alt = '<?php echo $title; ?>';
                img.style.width = '50px'; // Có thể điều chỉnh kích thước ảnh tùy ý

                listItem.appendChild(img); // Thêm ảnh vào mục danh sách
                listItem.appendChild(link);
                playList.appendChild(listItem);

                // Thêm bài hát vào mảng songs
                songs.push({
                    title: '<?php echo $title; ?>',
                    url: '<?php echo $url; ?>',
                    author: '<?php echo $aname; ?>',
                    image: '<?php echo $image; ?>'
                });
        <?php
            }
        } else {
            echo "console.log('0 results');";
        }
        ?>
    });
</script>
