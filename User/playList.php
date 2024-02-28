<div class="playList">
    <ul id="playList">
        <!-- Danh sách bài hát sẽ được thêm vào đây bằng JavaScript -->
    </ul>
    <button id="addPlayList">Thêm Play List</button>
    <button id="deletePlayList">Xóa Play List</button>
</div>

<script>
    // Đối tượng Audio để phát nhạc
    var audioPlayer = new Audio();
    var songs = []; // Mảng chứa danh sách bài hát

    // Sự kiện DOMContentLoaded để tạo danh sách bài hát
    document.addEventListener('DOMContentLoaded', function() {
        var playList = document.getElementById('playList');
        var addPlayListButton = document.getElementById('addPlayList');
        var deletePlayListButton = document.getElementById('deletePlayList');

        <?php
        // Truy vấn cơ sở dữ liệu để lấy các bài hát
        $sql = "SELECT a.* FROM playlist a
                JOIN user b ON a.uid = b.uid";
        //WHERE a.uid = $uid";
        $result = $conn->query($sql);

        // Hiển thị các liên kết đến bài hát
        if ($result->num_rows > 0) {
            while($row = $result->fetch_assoc()) {
                $plid = $row["pid"];
                $title = $row["pname"];
        ?>
                // Tạo một liên kết cho mỗi bài hát
                var link = document.createElement('a');
                link.innerText = '<?php echo $title;?>';
                link.href = "index.php?sort=playList_detail&id=" + <?php echo $plid; ?>;
                
                // Tạo một list item và thêm link vào đó
                var listItem = document.createElement('li');
                listItem.appendChild(link);
                
                // Thêm sự kiện click để điều hướng người dùng đến trang chi tiết bài hát
                link.addEventListener('click', function(event) {
                    event.preventDefault(); // Ngăn chặn hành động mặc định của liên kết
                    window.location.href = this.href;
                });

                // Thêm listItem vào danh sách phát
                playList.appendChild(listItem);
        <?php
            }
        } else {
            echo "console.log('0 results');";
        }
        ?>

        // Thêm sự kiện click cho nút "Thêm Play List"
        addPlayListButton.addEventListener('click', function() {
            // Xử lý logic khi người dùng nhấn nút "Thêm Play List"
            // Ví dụ: chuyển người dùng đến trang thêm Play List
            window.location.href = "add_playlist.php";
        });

        // Thêm sự kiện click cho nút "Xóa Play List"
        deletePlayListButton.addEventListener('click', function() {
            // Xử lý logic khi người dùng nhấn nút "Xóa Play List"
            // Ví dụ: hiển thị một thông báo xác nhận và gửi yêu cầu xóa Play List đến máy chủ
        });
    });
</script>
