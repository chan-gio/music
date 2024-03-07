<head>
    <link rel="stylesheet" type="text/css" href="./css/user.css">
</head>

<div class="songDetail">
    <ul id="songDetail">
        <!-- Danh sách bài hát sẽ được thêm vào đây bằng JavaScript -->
    </ul>

    <!-- Modal thêm vào danh sách phát(ban đầu sẽ ẩn) -->
    <div id="id02" class="modal">

        <form id="playlistForm" class="modal-content animate" action="./actions/add_to_playlist.php" method="post">
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
                <button type="button" class="btn btn-outline-danger col-md-3" onclick="document.getElementById('id02').style.display='none'">Huỷ</button>
                <div class="col-md-2 col-sm-0"></div>
                <button type="submit" class="btn btn-success col-md-3">Thêm</button>
                <div class="col-md-2 col-sm-0"></div>
            </div>
        </form>


    </div>
</div>

<script>
    var isUserConfirmed = false; // Biến để kiểm soát xác nhận từ người dùng
    var songid;
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

    document.addEventListener('DOMContentLoaded', function() {
        var songDetail = document.getElementById('songDetail');
        var selectedSongId = null;
        var selectedPlaylistId = null;

        // Hàm cập nhật giá trị cho input hidden songid
        function updateSongId(id) {
            selectedSongId = id;
            document.getElementById('songid').value = id;
        }



        <?php
        $id = $_GET['id'];
        // Truy vấn cơ sở dữ liệu để lấy các bài hát
        $sql = "SELECT
        songs.*,
        GROUP_CONCAT(artists.aname SEPARATOR ', ') AS artist_names
        FROM
        songs
        LEFT JOIN songs_artists ON songs.sid = songs_artists.sid
        LEFT JOIN artists ON songs_artists.aid = artists.aid
        WHERE
        songs.sstatus = 1
        and songs.sid = $id
        GROUP BY
        songs.sid, songs.sname;
        ";
        $result = $conn->query($sql);

        // Hiển thị các liên kết đến bài hát
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $sview = $row["sview"];
                $title = $row["sname"];
                $url = "../songs/" . $row["slink"];
                $image = "../images/" . $row["simage"];
                $aname = explode(', ', $row['artist_names']);
        ?>
                // Tạo một hàm xử lý sự kiện click cho mỗi liên kết đến bài hát
                function createClickHandler(index) {
                    return function() {
                        currentSongIndex = index; // Cập nhật vị trí của bài hát được chọn
                        playCurrentSong(); // Phát bài hát được chọn
                    };
                }

                // Tạo một hàm xử lý sự kiện click cho biểu tượng ba chấm
                function showOptions() {
                    // Hiển thị thẻ div chứa lựa chọn "thêm vào danh sách phát"
                    optionsDiv.style.display = 'block';
                }

                // Click chỗ khác thì ẩn hộp thoại thêm vào danh sách phát
                document.addEventListener('click', function(event) {
                    var optionsDiv = document.querySelector('.options');
                    var three_dots = document.querySelector('.fa-ellipsis-v');

                    // Kiểm tra xem vị trí click có thuộc về hộp thoại options hoặc dấu ba chấm hay không
                    if (optionsDiv.style.display === 'block' && (event.target !== three_dots && event.target !== optionsDiv && !optionsDiv.contains(event.target))) {
                        // Nếu không, ẩn hộp thoại options
                        optionsDiv.style.display = 'none';
                    }
                });

                var listItem = document.createElement('li');
                var link = document.createElement('a');
                link.href = 'javascript:void(0)';
                link.innerText = '<?php echo $title; ?>';
                var viewCountDiv = document.createElement('p');
                viewCountDiv.innerText = 'View: ' + <?php echo $sview; ?>;
                link.addEventListener('click', function() {
                    // Lấy index của bài hát được click
                    var index = songs.findIndex(function(song) {
                        return song.url === '<?php echo $url; ?>';
                    });
                    if (index !== -1) {
                        currentSongIndex = index;
                        playCurrentSong();
                        increaseSongView(<?php echo $id; ?>); // Gọi hàm để tăng view của bài hát
                    }
                });

                var img = document.createElement('img');
                img.src = '<?php echo $image; ?>';
                img.alt = '<?php echo $title; ?>';
                img.style.width = '50px'; // Có thể điều chỉnh kích thước ảnh tùy ý

                listItem.appendChild(img); // Thêm ảnh vào mục danh sách
                listItem.appendChild(link);
                songDetail.appendChild(listItem);
                

                // Thêm icon ba chấm vào bên cạnh tên bài hát
                var ellipsisIcon = document.createElement('i');
                ellipsisIcon.className = 'fa fa-ellipsis-v';
                ellipsisIcon.addEventListener('click', showOptions); // Thêm sự kiện click cho biểu tượng ba chấm
                listItem.appendChild(ellipsisIcon); // Thêm icon ba chấm vào liên kết
                ellipsisIcon.style.marginLeft = '6px';
                listItem.appendChild(viewCountDiv);


                // Tạo thẻ div chứa lựa chọn "thêm vào danh sách phát"
                var optionsDiv = document.createElement('div');
                optionsDiv.className = 'options';
                optionsDiv.style.display = 'none'; // Ẩn thẻ div ban đầu

                // Tạo lựa chọn "thêm vào danh sách phát"
                var addToPlaylistOption = document.createElement('p');
                addToPlaylistOption.innerText = 'Add to playlist';


                //Bắt sự kiện click thêm vào danh sách phát
                optionsDiv.addEventListener('click', function() {
                    // Ở đây bạn có thể thực hiện xử lý để thêm vào danh sách phát
                    document.getElementById('id02').style.display = 'block'
                    songid = <?php echo $row['sid']; ?>;
                    updateSongId(<?php echo $row['sid']; ?>); // Cập nhật songid khi người dùng chọn bài hát
                });

                optionsDiv.appendChild(addToPlaylistOption);
                listItem.appendChild(optionsDiv);

                // Thêm bài hát vào mảng songs
                songs.push({
                    title: '<?php echo $title; ?>',
                    url: '<?php echo $url; ?>',
                    author: '<?php echo implode(', ', $aname); ?>',
                    image: '<?php echo $image; ?>'
                });
        <?php
            }
        } else {
            echo "console.log('0 results');";
        }
        ?>
    });

    // Hàm xử lý việc tăng view cho bài hát
async function increaseSongView(songId) {
    try {
        const response = await fetch(`./actions/increase_view.php?id=${songId}`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json'
            },
        });

        if (!response.ok) {
            throw new Error('Network response was not ok');
        }

        const data = await response.json();
        if (data.success) {
            console.log('Lượt xem của bài hát đã được tăng lên.');
        } else {
            console.error('Có lỗi xảy ra khi tăng lượt xem của bài hát.');
        }
    } catch (error) {
        console.error('Error increasing song view:', error);
    }
}

</script>






<!-- Check thêm vào ds phát -->
<script>
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

    async function validateForm(event) {

    }

    //Hàm xử lý nếu người dùng ấn cancel thì không gửi form đi nữa(không thêm vào ds phát nữa)
    document.getElementById('playlistForm').addEventListener('submit', async function(event) {
        event.preventDefault(); // Ngăn chặn việc gửi form đi mặc định

        var selectedPlaylists = document.querySelectorAll('input[name="playlists[]"]:checked');
        var selectedPlaylistIds = []; // Mảng lưu các playlistId được chọn
        var showWarning = false;

        for (var i = 0; i < selectedPlaylists.length; i++) {
            var playlistId = selectedPlaylists[i].value;

            try {
                var isSongInPlaylist = await checkSongInPlaylist(songid, playlistId); // Sử dụng await để đợi cho đến khi kiểm tra AJAX hoàn thành
                if (isSongInPlaylist) {
                    showWarning = true;
                }
                selectedPlaylistIds.push(playlistId); // Thêm playlistId vào mảng
            } catch (error) {
                console.error('Error checking song in playlist:', error);
            }
        }

        // Cập nhật giá trị cho input hidden playlistId với toàn bộ playlistId được chọn
        document.getElementById('playlistId').value = selectedPlaylistIds.join(',');

        if (showWarning) {
            var userConfirmation = confirm("Bài hát đã có trong danh sách phát, Bạn có muốn thêm lại không?");
            if (userConfirmation) {
                this.submit(); // Gửi form đi nếu người dùng đồng ý
            } else {
                document.getElementById('id02').style.display = 'none'; // Ẩn modal nếu người dùng từ chối
            }
        } else {
            this.submit(); // Gửi form đi nếu không cần hiển thị cảnh báo
        }
    });


    // Hàm cập nhật giá trị cho input hidden playlistId
    function updatePlaylistId(id) {
        selectedPlaylistId = id;
        document.getElementById('playlistId').value = id;
    }
</script>

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