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

                // Thêm CSS cho nút deleteButton
                deleteButton.style.backgroundColor = 'red'; // Đặt màu nền là đỏ
                deleteButton.style.color = 'white'; // Đặt màu chữ là trắng
                deleteButton.style.border = 'none'; // Loại bỏ đường viền

                // Thêm nút vào DOM
                document.body.appendChild(deleteButton);


                // Thêm nút "Xóa" vào listItem
                listItem.appendChild(deleteButton);
                
                var editButton = document.createElement('button');
                editButton.innerText = 'Sửa';
                editButton.addEventListener('click', function(event) {
                    event.stopPropagation();
                    window.location.href = "./actions/edit_playlist.php?pid=<?php echo $plid; ?>";
                });

                // Thêm CSS cho nút editButton
                editButton.style.backgroundColor = 'blue'; // Đặt màu nền là xanh
                editButton.style.color = 'white'; // Đặt màu chữ là trắng
                editButton.style.border = 'none'; // Loại bỏ đường viền

                // Thêm nút vào DOM
                document.body.appendChild(editButton);

                // Thêm nút "Xóa" vào listItem
                listItem.appendChild(editButton);


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
<style>
    .playList {
        width: 300px; 
        margin: 20px;
        padding: 10px;
        border: 1px solid #ccc;
        border-radius: 5px;
        box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
    }

    #playList {
        list-style-type: none;
        padding: 0;
    }

    #playList li {
        margin-bottom: 5px;
    }

    #addPlayList {
        display: block;
        width: 100%;
        padding: 10px;
        margin-top: 10px;
        background-color: #3498db;
        color: #fff;
        border: none;
        border-radius: 3px;
        cursor: pointer;
    }

    #addPlayList:hover {
        background-color: #2980b9;
}
</style>
