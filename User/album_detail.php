<?php
if (!isset($_SESSION["notify"])) {
    $_SESSION["notify"] = "";
}

$id = $_GET['id'];
// Truy vấn cơ sở dữ liệu để lấy các bài hát
$sql = "SELECT a.*, c.*, GROUP_CONCAT(d.aname)
        FROM albums a
        JOIN albums_songs b ON a.alid = b.alid
        JOIN songs c ON b.sid = c.sid
        JOIN songs_artists e ON e.sid = c.sid
        JOIN artists d ON d.aid = e.aid
        WHERE a.alid = $id
        GROUP BY c.sid, c.sname;";
$result = $conn->query($sql);

// Lấy tất cả các bản ghi và lưu trữ chúng trong một mảng
$songsArray = $result->fetch_all(MYSQLI_ASSOC);

// Hiển thị tên album
if (!empty($songsArray)) {
    $alname = $songsArray[0]["alname"];
    $alimage = $songsArray[0]["alimage"];
?>
    <h2 id="albumName"><?php echo $alname; ?></h2>
    <img src="<?php echo "../albums/" . $alimage; ?>" alt="">
<?php
} else {
    echo "Album hiện không có bài hát nào";
}
?>

<head>
    <link rel="stylesheet" type="text/css" href="./css/user.css">
</head>

<div class="albumDetail">
    <font color=red><?php echo $_SESSION["notify"]; ?></font><br>
    <ul id="albumDetail">
        <!-- Danh sách bài hát sẽ được thêm vào đây bằng JavaScript -->
    </ul>

    <!-- Modal thêm vào danh sách phát(ban đầu sẽ ẩn) -->
    <div id="id02" class="modal">
        <form id="playlistForm" class="modal-content animate" action="./actions/add_to_playlist-album.php?alid=<?php echo $id ?>" method="post">
            <div class="imgcontainer">
                <span onclick="document.getElementById('id02').style.display='none'" class="close" title="Close Modal">&times;</span>
            </div>
            <input type="hidden" id="songid" name="songid">
            <input type="hidden" id="playlistId" name="playlistId">
            <?php
            // Truy vấn để lấy danh sách các playlist
            $sql = "SELECT * FROM playlist";
            $result = $conn->query($sql);
            ?>

            <!-- Ô checkbox để chọn playlist -->
            <div class="form-group">
                <label>Chọn Playlist:</label>
                <?php
                // Kiểm tra xem có dữ liệu trả về từ truy vấn hay không
                if ($result->num_rows > 0) {
                    while ($playlistRow = $result->fetch_assoc()) {
                        $pid = $playlistRow['pid'];
                        $pname = $playlistRow['pname'];
                ?>
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" name="playlists[]" id="playlist_<?php echo $pid; ?>" value="<?php echo $pid; ?>">
                            <label class="form-check-label" for="playlist_<?php echo $pid; ?>"><?php echo $pname; ?></label>
                        </div>
                <?php
                    }
                } else {
                    echo 'Không có playlist nào khả dụng.';
                }
                ?>
            </div>

            <!-- Các nút điều khiển và ô nhập liệu khác -->
            <div class="group-button row">
                <div class="col-md-2 col-sm-0"></div>
                <button type="button" class="btn btn-outline-danger col-md-3" onclick="hideModal()">Huỷ</button>
                <div class="col-md-2 col-sm-0"></div>
                <button type="button" class="btn btn-success col-md-3" onclick="validateForm()">Thêm</button>
                <div class="col-md-2 col-sm-0"></div>
            </div>
        </form>
    </div>
</div>

<script>
    var isUserConfirmed = false; // Biến để kiểm soát xác nhận từ người dùng
    var songid;
    var currentSongIndex = 0; // Thêm biến này để lưu vị trí của bài hát đang chơi
    var audioPlayer = new Audio();
    var songs = [];

    document.addEventListener('DOMContentLoaded', function() {
        var albumDetail = document.getElementById('albumDetail');

        <?php
        foreach ($songsArray as $song) {
            $title = $song["sname"];
            $url = "../songs/" . $song["slink"];
            $image = "../images/" . $song["simage"];
            $aname = isset($song["aname"]) ? $song["aname"] : "Unknown";
        ?>
            var listItem = document.createElement('li');
            var link = document.createElement('a');
            link.href = 'javascript:void(0)';
            link.innerText = '<?php echo $title; ?>';
            link.addEventListener('click', createClickHandler(songs.length));

            var img = document.createElement('img');
            img.src = '<?php echo $image; ?>';
            img.alt = '<?php echo $title; ?>';
            img.style.width = '50px';
            listItem.appendChild(img);
            listItem.appendChild(link);


            var ellipsisIcon = document.createElement('i');
            ellipsisIcon.className = 'fa fa-ellipsis-v';
            ellipsisIcon.addEventListener('click', showOptions);
            listItem.appendChild(ellipsisIcon);
            ellipsisIcon.style.marginLeft = '6px';

            var optionsDiv = document.createElement('div');
            optionsDiv.className = 'options';
            optionsDiv.style.display = 'none';
            var addToPlaylistOption = document.createElement('p');
            addToPlaylistOption.innerText = 'Add to playlist';
            addToPlaylistOption.addEventListener('click', function() {
                document.getElementById('id02').style.display = 'block';
                songid = <?php echo $song['sid']; ?>;
                updateSongId(<?php echo $song['sid']; ?>);
            });
            optionsDiv.appendChild(addToPlaylistOption);
            listItem.appendChild(optionsDiv);

            songs.push({
                title: '<?php echo $title; ?>',
                url: '<?php echo $url; ?>',
                author: '<?php echo $aname; ?>',
                image: '<?php echo $image; ?>'
            });

            albumDetail.appendChild(listItem);
        <?php
        }
        ?>
    });

    function createClickHandler(index) {
        return function() {
            currentSongIndex = index;
            playCurrentSong();
        };
    }

    function playCurrentSong() {
        var currentSong = songs[currentSongIndex];
        audioPlayer.src = currentSong.url;
        audioPlayer.play();
    }
    document.addEventListener('click', function(event) {
    var optionsDivs = document.querySelectorAll('.options');

    // Lặp qua tất cả các hộp thoại "Add to playlist" và kiểm tra xem chúng có cần ẩn không
    optionsDivs.forEach(function(optionsDiv) {
        var ellipsisIcon = optionsDiv.previousElementSibling; // Lấy phần tử dấu ba chấm tương ứng với hộp thoại "Add to playlist"

        // Kiểm tra xem vị trí click có thuộc về hộp thoại "Add to playlist" hoặc phần tử cha của nó không
        if (optionsDiv.style.display === 'block' && !ellipsisIcon.contains(event.target) && !optionsDiv.contains(event.target)) {
            // Nếu không, ẩn hộp thoại "Add to playlist"
            optionsDiv.style.display = 'none';
        }
    });
});



    function showOptions() {
        var optionsDiv = this.parentElement.querySelector('.options');
        optionsDiv.style.display = 'block';
    }

    function hideModal() {
        document.getElementById('id02').style.display = 'none';
    }

    function updateSongId(id) {
        document.getElementById('songid').value = id;
        songid = id;
    }

    // Hàm xử lý khi người dùng nhấn nút "Thêm"
    async function validateForm() {
        var selectedPlaylists = document.querySelectorAll('input[name="playlists[]"]:checked');
        var selectedPlaylistIds = [];
        var duplicate = false; //không trùng
        for (var i = 0; i < selectedPlaylists.length; i++) {
            var playlistId = selectedPlaylists[i].value;
            selectedPlaylistIds.push(playlistId);
            console.log(songid);
            // Kiểm tra sự trùng lặp bằng AJAX
            var isDuplicate = await checkSongInPlaylist(songid, playlistId);

            if (isDuplicate) {
                duplicate = true; // có trùng
            }
        }

        document.getElementById('playlistId').value = selectedPlaylistIds.join(',');

        if (duplicate) {
            // Hiển thị hộp thoại xác nhận nếu có trùng lặp
            var userConfirmation = confirm("Bài hát đã có trong danh sách phát, Bạn có muốn thêm lại không?");
            if (userConfirmation) {
                isUserConfirmed = true;
                document.getElementById('playlistForm').submit();
            }
        } else {
            document.getElementById('playlistForm').submit();

        }
    }

    // Hàm kiểm tra trùng lặp bằng AJAX
    async function checkSongInPlaylist(songid, playlistId) {
        try {
            const response = await fetch('./actions/check_duplicate.php?songid=' + songid + '&playlistid=' + playlistId);

            if (!response.ok) {
                throw new Error('Network response was not ok');
            }

            const data = await response.text();
            const result = data.trim() === 'true';
            return result;
        } catch (error) {
            return false;
        }
    }
</script>
<?php
    unset($_SESSION["notify"]);
?>
<style>
    @import url(https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css);

    @import url(https://fonts.googleapis.com/css?family=Titillium+Web:300);

    .options {
        position: absolute;
        background-color: #fff;
        box-shadow: 0 0 5px rgba(0, 0, 0, 0.2);
        padding: 10px;
        z-index: 1;
        border: 1px;
        margin-left: 132px;
    }

    .options p {
        margin: 0;
        padding: 5px;
        cursor: pointer;
    }

    .options:hover {
        background-color: #f1f1f1;
        cursor: pointer;
    }
</style>