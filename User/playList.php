<div class="playList">
    <ul id="playList">
        <!-- Danh sách bài hát sẽ được thêm vào đây bằng JavaScript -->
    </ul>
    <button id="addPlayList">Thêm Play List</button>
</div>

<script>
    // Đối tượng Audio để phát nhạc
    var audioPlayer = new Audio();
    var songs = []; // Mảng chứa danh sách bài hát

    // Hàm để gửi yêu cầu AJAX để xóa playlist
    function removePlaylist(pid) {
        // Hiển thị hộp thoại xác nhận trước khi xóa playlist
        var result = confirm("Bạn có chắc chắn muốn xóa playlist này không?");
        if (result) {
            // Nếu người dùng đồng ý, gửi yêu cầu AJAX để xóa playlist
            var xhr = new XMLHttpRequest();
            xhr.onreadystatechange = function() {
                if (xhr.readyState === XMLHttpRequest.DONE) {
                    if (xhr.status === 200) {
                        // Xóa thành công, làm mới trang hoặc cập nhật danh sách bài hát
                        location.reload(); // Làm mới trang để cập nhật danh sách bài hát
                    } else {
                        // Xử lý lỗi khi xóa playlist
                        console.error('Error removing playlist:', xhr.responseText);
                    }
                }
            };
            xhr.open('POST', './actions/remove_playlist.php', true);
            xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
            // Truyền pid của playlist cần xóa
            var data = 'pid=' + encodeURIComponent(pid);
            xhr.send(data);
        }
    }

    // Sự kiện DOMContentLoaded để tạo danh sách bài hát
    document.addEventListener('DOMContentLoaded', function() {
        var playList = document.getElementById('playList');
        var addPlayListButton = document.getElementById('addPlayList');

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

                // Tạo nút "Xóa" cho mỗi danh sách phát
                var deleteButton = document.createElement('button');
                deleteButton.innerText = 'Xóa';
                deleteButton.addEventListener('click', function(event) {
                    event.stopPropagation(); // Ngăn chặn sự kiện click trên liên kết
                    // Thực hiện hành động xóa playlist
                    removePlaylist(<?php echo $plid; ?>); // Gọi hàm xóa playlist với pid tương ứng
                });

                // Thêm nút "Xóa" vào listItem
                listItem.appendChild(deleteButton);

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
            window.location.href = "./actions/add_playlist.php";
        });
    });
</script>
