<head>
    <link rel="stylesheet" type="text/css" href="./css/user.css">
</head>

<div class="songDetail">
    <ul id="songDetail">
        <!-- Danh sách bài hát sẽ được thêm vào đây bằng JavaScript -->
    </ul>

    <!-- Modal thêm vào danh sách phát(ban đầu sẽ ẩn) -->
    <div id="id02" class="modal">

        <form class="modal-content animate" action="Password_edit_action.php?cid=<?php echo $row['cid'] ?>" method="post">
            <div class="imgcontainer">
                <span onclick="document.getElementById('id02').style.display='none'" class="close" title="Close Modal">&times;</span>
            </div>

            
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
    // Đối tượng Audio để phát nhạc
    var audioPlayer = new Audio();
    var songs = []; // Mảng chứa danh sách bài hát

    // Hàm phát bài hát hiện tại
    function playCurrentSong() {
        var currentSong = songs[currentSongIndex];
        audioPlayer.src = currentSong.url;
        a
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

        <?php
        $id = $_GET['id'];
        // Truy vấn cơ sở dữ liệu để lấy các bài hát
        $sql = "SELECT a.*, b.aname FROM songs a
            JOIN artists b ON b.aid = a.aid
            Where a.sid = $id";
        $result = $conn->query($sql);

        // Hiển thị các liên kết đến bài hát
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $title = $row["sname"];
                $url = "songs/" . $row["slink"];
                $image = "images/" . $row["simage"];
                $aname = isset($row["aname"]) ? $row["aname"] : "Unknown";
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
                songDetail.appendChild(listItem);

                // Thêm icon ba chấm vào bên cạnh tên bài hát
                var ellipsisIcon = document.createElement('i');
                ellipsisIcon.className = 'fa fa-ellipsis-v';
                ellipsisIcon.addEventListener('click', showOptions); // Thêm sự kiện click cho biểu tượng ba chấm
                listItem.appendChild(ellipsisIcon); // Thêm icon ba chấm vào liên kết
                ellipsisIcon.style.marginLeft = '6px';

                // Tạo thẻ div chứa lựa chọn "thêm vào danh sách phát"
                var optionsDiv = document.createElement('div');
                optionsDiv.className = 'options';
                optionsDiv.style.display = 'none'; // Ẩn thẻ div ban đầu

                // Tạo lựa chọn "thêm vào danh sách phát"
                var addToPlaylistOption = document.createElement('p');
                addToPlaylistOption.innerText = 'Add to playlist';
                addToPlaylistOption.addEventListener('click', function() {
                    // Ở đây bạn có thể thực hiện xử lý để thêm vào danh sách phát
                    console.log("Thêm vào danh sách phát");
                });

                optionsDiv.appendChild(addToPlaylistOption);
                listItem.appendChild(optionsDiv);

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