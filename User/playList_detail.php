<?php
    $id = $_GET['id'];
    $sql2 = "select * from playlist where pid=".$id;
    $result2 = $conn->query($sql2);
    $row2 = $result2->fetch_assoc();
?>
<h1><?php echo $row2['pname'] ?></h1>
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

    function removeSongFromPlaylist(songid, pid) {
    // Gửi yêu cầu AJAX để xóa bài hát khỏi playlist
    var xhr = new XMLHttpRequest();
    xhr.onreadystatechange = function() {
        if (xhr.readyState === XMLHttpRequest.DONE) {
            if (xhr.status === 200) {
                // Xóa thành công, làm mới trang hoặc cập nhật danh sách bài hát
                location.reload(); // Làm mới trang để cập nhật danh sách bài hát
            } else {
                // Xử lý lỗi khi xóa bài hát
                console.error('Error removing song from playlist:', xhr.responseText);
            }
        }
    };
    xhr.open('POST', './actions/remove_song_from_playlist.php', true);
    xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
    // Truyền cả songid và pid
    var data = 'songid=' + encodeURIComponent(songid) + '&pid=' + encodeURIComponent(pid);
    xhr.send(data);
}




    // Sự kiện DOMContentLoaded để tạo danh sách bài hát
    document.addEventListener('DOMContentLoaded', function() {
        var playList = document.getElementById('playList');

        <?php
        

        // Truy vấn cơ sở dữ liệu để lấy các bài hát
        $sql = "SELECT a.pid, c.*,
                    (SELECT d.aname 
                    FROM songs_artists e 
                    JOIN artists d ON d.aid = e.aid 
                    WHERE e.sid = c.sid 
                    LIMIT 1) AS aname
                FROM playlist a
                JOIN songs_playlist b ON a.pid = b.pid
                JOIN songs c ON b.sid = c.sid
                WHERE a.pid = $id";
        $result = $conn->query($sql);

        // Hiển thị các liên kết đến bài hát
        if ($result->num_rows > 0) {
            while($row = $result->fetch_assoc()) {
                $pid = $row["pid"];
                $sid = $row["sid"];
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
                var removeButton = document.createElement('button'); // Tạo nút "Xóa"

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

                  // Thiết lập thuộc tính và sự kiện cho nút "Xóa"
                  removeButton.innerText = 'Xóa';
                  var csong = {}; // Khai báo biến csong trước khi sử dụng
                removeButton.addEventListener('click', function() {
                    removeSongFromPlaylist(<?php echo $sid; ?>, <?php echo $pid; ?>); // Truyền ID của bài hát cần xóa
                });

                var img = document.createElement('img');
                img.src = '<?php echo $image; ?>';
                img.alt = '<?php echo $title; ?>';
                img.style.width = '50px'; // Có thể điều chỉnh kích thước ảnh tùy ý
                
                

                listItem.appendChild(img); // Thêm ảnh vào mục danh sách
                listItem.appendChild(link);
                listItem.appendChild(removeButton);
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
<style>
            /* Style cho danh sách phát */
        .playList {
            position:relative;
            right: 370px;
            max-width: 300px; /* Đặt chiều rộng tối đa của danh sách phát */
            margin: 20px auto; /* Canh giữa danh sách phát */
            padding: 10px;
            background-color: #f8f8f8;
            border: 1px solid #ddd;
            border-radius: 5px;
        }

        /* Style cho mỗi mục danh sách */
        .playList li {
            list-style: none; /* Ẩn dấu chấm liệt kê */
            margin-bottom: 10px;
            display: flex;
            align-items: center;
        }

        .playList img {
            width: 50px;
            height: 50px;
            margin-right: 10px;
            border-radius: 50%; /* Bo góc hình ảnh thành hình tròn */
            object-fit: cover; /* Đảm bảo hình ảnh không bị biến đổ */
        }

        .playList a {
            text-decoration: none;
            color: #333;
            font-weight: bold;
            flex-grow: 1; /* Mở rộng phần tử để chiếm đủ không gian */
        }

        .playList button {
            background-color: #e74c3c;
            color: #fff;
            border: none;
            padding: 5px 10px;
            cursor: pointer;
            border-radius: 3px;
            margin-left: 10px;
        }

        .playList button:hover {
            background-color: #c0392b;
        }

</style>
