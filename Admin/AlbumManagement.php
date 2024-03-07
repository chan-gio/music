<?php

include("connect.php");

// Kiểm tra đăng nhập và vai trò của người dùng (ví dụ: chỉ admin mới có quyền quản lý voucher)
if (!isset($_SESSION["album_edit_error"])) {
    $_SESSION["album_edit_error"] = "";
}

if (!isset($_SESSION["album_add_error"])) {
    $_SESSION["album_add_error"] = "";
}

if (!isset($_SESSION["song_in_album_edit_error"])) {
    $_SESSION["song_in_album_edit_error"] = "";
}
$query = "SELECT *
FROM albums
WHERE albums.alstatus = 1;";
$result = $conn->query($query);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Quản lý album</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <link rel="stylesheet" href="./css/Management.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">

</head>

<body style="margin-left:100px;background-color: #f1efef">
    <h2 style="margin-top:10px">Quản lý album</h2>
    <font color=red><?php echo $_SESSION["album_edit_error"]; ?></font><br>
    <font color=red><?php echo $_SESSION["album_add_error"]; ?></font><br>
    <font color=red><?php echo $_SESSION["song_in_album_edit_error"]; ?></font><br>
    <button type="button" class="btn btn-primary"><a class="button-Add" href="index.php?manage=Album_add">Thêm album</a></button>
    <button type="button" style="background-color: red;" class="btn btn-primary"><a class="button-Add" href="index.php?manage=Album_trashcan">Thùng rác</a></button>

    <table class="table table-striped" style="background-color:white;border:1px solid #ccc;margin-top:30px;padding:20px">
        <thead>
            <tr>
                <th scope="col">Mã album</th>
                <th scope="col">Tên album</th>
                <th scope="col">Ảnh bìa</th>
                <th scope="col">Lượt xem</th>
                <th scope="col">Tình trạng</th>
                <th scope="col">Chi tiết</th>
                <th scope="col">Xóa</th>
            </tr>
        </thead>
        <tbody>

            <?php
            while ($row = $result->fetch_assoc()) {
                echo "<tr>";
                echo "<td>{$row['alid']}</td>";
                echo "<td>{$row['alname']}</td>";
                echo '  <td>
                        <img src="../albums/' . $row['alimage'] . '" alt="Album Image" style="width: 100px; height: auto;">
                    </td>';
                echo "<td>{$row['alview']}</td>";

                echo "<td>Khả dụng</td>";
                echo "<td><button type='button' class='btn btn-warning' ><a href='#' class='button-edit detail-album'  data-alid='{$row['alid']}' data-bs-toggle='modal' data-bs-target='#albumModal'>Chi tiết</a></button></td>";
                echo '<td><button type="button" class="btn btn-danger"><a class="button-delete" onclick="return confirm(\'Bạn có chắc muốn xóa album: ' . $row["alname"] . ' không?\')" href="./actions/Album_delete.php?alid=' . $row["alid"] . '">Xóa</a></button></td>';
                echo "</tr>";
            }
            ?>
        </tbody>

    </table>



    <!-- Modal -->
    <div class="modal fade" id="albumModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" style="margin: 80px 140px;">
            <div class="modal-content" style="width: 1360px;">
                <div class="modal-header">
                    <h3>Chi tiết album</h3>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <table class="table table-striped" style="background-color:white;border:1px solid #ccc;margin-top:30px;padding:20px">
                        <thead>
                            <tr>
                                <th scope="col">Mã album</th>
                                <th scope="col">Tên album</th>
                                <th scope="col">Ca sĩ</th>
                                <th scope="col">Ảnh bìa</th>
                                <th scope="col">Lượt xem</th>
                                <th scope="col">Tình trạng</th>
                                <th>Chỉnh sửa</th>
                            </tr>
                        </thead>
                        <tbody id="modal-album-table">

                        </tbody>
                    </table>
                    <br><br>
                    <h5>Các bài hát có trong album</h5>
                    <div id="buttoneditsongsinalbum"></div>
                    <table class="table table-striped" style="background-color:white;border:1px solid #ccc;margin-top:30px;padding:20px">
                        <thead>
                            <tr>
                                <th scope="col">Mã bài hát</th>
                                <th scope="col">Tên bài hát</th>
                                <th scope="col">Ca sĩ</th>
                                <th scope="col">Nội dung</th>
                                <th scope="col">Lượt nghe</th>
                                <th scope="col">Xóa khỏi album</th>
                            </tr>
                        </thead>
                        <tbody id="songsInAlbumTable">



                        </tbody>

                    </table>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-primary" data-bs-dismiss="modal">Đóng</button>
                </div>
            </div>
        </div>
    </div>
</body>

</html>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
<script>
    //Hàm chuyển dấu xuống dòng trong sql thành br trong html
    function nl2br_custom(str) {
        return str ? str.replace(/(?:\r\n|\r|\n)/g, '<br>') : 'Chưa có ca sĩ';
    }
    // Lấy tất cả nút "Chỉnh sửa"
    const showDetailsButtons = document.querySelectorAll('.detail-album');

    // Thêm event listener cho mỗi nút
    showDetailsButtons.forEach(button => {
        button.addEventListener('click', (event) => {
            const albumId = event.target.dataset.alid;
            console.log(albumId); // Kiểm tra giá trị albumId trong consoleconst albumId = event.target.dataset.alid;
            const xhr = new XMLHttpRequest();
            const url = "./actions/get_album_details.php";
            const params = `alid=${albumId}`;
            xhr.open("POST", url, true);
            xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");

            // Lấy modal body   
            const modalBody = document.getElementById('albumModal').querySelector('#modal-album-table');

            // Xóa nội dung cũ của modal
            modalBody.innerHTML = '';

            // Định nghĩa callback để xử lý khi response về từ server
            xhr.onreadystatechange = function() {
                if (xhr.readyState == 4) {
                    if (xhr.status == 200) {
                        // Xử lý dữ liệu từ response
                        try {
                            const data = JSON.parse(xhr.responseText);
                            var artist_names = nl2br_custom(data.alartist);
                            // Hiển thị dữ liệu trong modal body
                            const modalBody = document.getElementById('albumModal').querySelector('#modal-album-table');
                            modalBody.innerHTML = `
                                <tr>
                                    <td>${data.alid}</td>
                                    <td>${data.alname}</td>
                                    <td>${artist_names}</td>
                                    <td><img src="../albums/${data.alimage}" alt="Album Image" style="width: 100px; height: auto;"></td>
                                    <td>${data.alview}</td>
                                    <td>Khả dụng</td>
                                    <td><button type='button' class='btn btn-warning' ><a href='index.php?manage=Album_edit&alid=${data.alid}' class='button-edit detail-album' >Chỉnh sửa</a></button></td>

                                    
                                </tr>`;
                        } catch (error) {
                            console.error("Error parsing JSON:", error);
                        }
                    } else {
                        console.error("XHR error:", xhr.status);
                    }
                }
            };

            // Gửi request với dữ liệu đã được chuẩn bị
            xhr.send(params);


            //THực hiện đổ dữ liệu cho ds bài hát trong album
            const xhr2 = new XMLHttpRequest();
            const url2 = "./actions/get_songs_in_album.php";
            const params2 = `alid=${albumId}`;
            xhr2.open("POST", url2, true);
            xhr2.setRequestHeader("Content-type", "application/x-www-form-urlencoded");

            //THêm nút sửa
            const button = document.getElementById('albumModal').querySelector('#buttoneditsongsinalbum');
            button.innerHTML = "<button type='button' class='btn btn-warning'><a class='button-edit' href='index.php?manage=Song_in_album_edit&alid=" + albumId + "'>Chỉnh sửa</a></button>";



            // Lấy modal body   
            const songsInAlbumTable = document.getElementById('albumModal').querySelector('#songsInAlbumTable');

            // Xóa nội dung cũ của modal
            songsInAlbumTable.innerHTML = '';

            // Định nghĩa callback để xử lý khi response về từ server
            xhr2.onreadystatechange = function() {
                if (xhr2.readyState == 4) {
                    if (xhr2.status == 200) {
                        // Xử lý dữ liệu từ response
                        try {
                            const data = JSON.parse(xhr2.responseText);

                            if (data.length > 0) {
                                // Hiển thị dữ liệu trong modal body
                                data.forEach(song => {
                                    const row = document.createElement('tr');
                                    var artist_names2 = nl2br_custom(song.artist_names);

                                    row.innerHTML = `
                                    <td>${song.sid}</td>
                                    <td>${song.sname}</td>      
                                    <td>${artist_names2}</td>
                                    <td>
                                        <img src="../images/${song.simage}" alt="Song Image" style="width: 100px; height: auto;">
                                        <br>
                                        <audio controls>
                                        <source src="../songs/${song.slink}" type="audio/mpeg">
                                        </audio>
                                    </td>
                                    <td>${song.sview}</td>
                                    <td><button type="button" class="btn btn-danger" onclick="confirmDelete(event, '${song.sname}', '${data.alname}', '${song.sid}', '${albumId}')">Xóa</button></td>
                                `;
                                    songsInAlbumTable.appendChild(row);
                                });
                            } else {
                                // Hiển thị thông báo khi không có bài hát trong album
                                const emptyRow = document.createElement('tr');
                                emptyRow.innerHTML = '<td colspan="6">Album tạm thời chưa có bài hát nào.</td>';
                                songsInAlbumTable.appendChild(emptyRow);
                            }

                        } catch (error) {
                            console.error("Error parsing JSON:", error);
                        }
                    } else {
                        console.error("XHR error:", xhr2.status);
                    }
                }
            };

            // Gửi request với dữ liệu đã được chuẩn bị
            xhr2.send(params2);

        });
    });

    //Hàm confirm nút xóa bài hát trong album
    function confirmDelete(event, songName, albumName, songId, albumId) {
        event.preventDefault();
        if (confirm(`Bạn có chắc muốn xóa bài hát "${songName}" khỏi album "${albumName}" không?`)) {
            window.location.href = `./actions/delete_song_out_of_album.php?sid=${songId}&alid=${albumId}`;
        }
    }

    function confirmDeleteAlbum(event, albumName, albumId) {
    event.preventDefault();
    if (confirm(`Bạn có chắc muốn xóa album "${albumName}" không?`)) {
        window.location.href = `./actions/Album_delete.php?alid=${albumId}`;
    }
}

</script>
<?php
unset($_SESSION["album_add_error"]);
unset($_SESSION["album_edit_error"]);
unset($_SESSION["song_in_album_edit_error"]);
// Đóng kết nối
$conn->close();
?>