<?php
$id = $_GET['id'];
// Truy vấn cơ sở dữ liệu để lấy các bài hát
$sql = "SELECT a.*, b.* FROM artists a
        JOIN songs_artists c ON a.aid = c.aid
        JOIN songs b ON c.sid = b.sid
        WHERE a.aid = $id";
$result = $conn->query($sql);

// Lấy tất cả các bản ghi và lưu trữ chúng trong một mảng
$songsArray = $result->fetch_all(MYSQLI_ASSOC);

// Hiển thị tên album
if (!empty($songsArray)) {
    $aname = $songsArray[0]["aname"];
    $aimage = $songsArray[0]["aimage"];
?>
    <h2 id="artistName"><?php echo $aname; ?></h2>
    <img src="<?php echo "../artists/" . $aimage; ?>" alt="">
<?php
} else {
    echo "console.log('0 results');";
}
?>

<div class="artistDetail">
    <ul id="artistDetail">
        <!-- Danh sách bài hát sẽ được thêm vào đây bằng JavaScript -->
    </ul>
</div>

<script>
     // Đối tượng Audio để phát nhạc
     var audioPlayer = new Audio();
        var songs = [];
        var currentSongIndex = 0; // Đặt giá trị mặc định cho currentSongIndex

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
        var artistDetail = document.getElementById('artistDetail');

        <?php
        // Lặp qua mảng songsArray để tạo các phần tử HTML
        foreach($songsArray as $song) {
            $title = $song["sname"];
            $url = "../songs/".$song["slink"];
            $image = "../images/".$song["simage"];
            $aname = isset($song["aname"]) ? $song["aname"] : "Unknown";
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
            artistDetail.appendChild(listItem);

            // Thêm bài hát vào mảng songs
            songs.push({
                title: '<?php echo $title; ?>',
                url: '<?php echo $url; ?>',
                author: '<?php echo $aname; ?>',
                image: '<?php echo $image; ?>'
            });
        <?php
        }
        ?>
    });
</script>
