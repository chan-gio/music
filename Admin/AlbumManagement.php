<?php

include("connect.php");

// Kiểm tra đăng nhập và vai trò của người dùng (ví dụ: chỉ admin mới có quyền quản lý voucher)
if (!isset($_SESSION["album_edit_error"])) {
    $_SESSION["album_edit_error"] = "";
}

if (!isset($_SESSION["album_add_error"])) {
    $_SESSION["album_add_error"] = "";
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
    <button type="button" class="btn btn-primary"><a class="button-Add" href="admin.php?manage=Album_add">Thêm album</a></button>
    <button type="button" style="background-color: red;" class="btn btn-primary"><a class="button-Add" href="admin.php?manage=Album_trashcan">Thùng rác</a></button>

    <table class="table table-striped" style="background-color:white;border:1px solid #ccc;margin-top:30px;padding:20px">
        <thead>
            <tr>
                <th scope="col">Mã album</th>
                <th scope="col">Tên album</th>
                <th scope="col">Ca sĩ</th>
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
                    <h1 class="modal-title fs-5" id="exampleModalLabel">Chi tiết album</h1>
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
                                <th scope="col">Chi tiết</th>
                                <th scope="col">Xóa</th>
                            </tr>
                        </thead>
                        <tbody id="modal-album-table">

                        </tbody>
                    </table>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Đóng</button>
                    <button type="button" class="btn btn-primary">Lưu</button>
                </div>
            </div>
        </div>
    </div>
</body>

</html>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
<script>
    // Lấy tất cả nút "Chỉnh sửa"
    const showDetailsButtons = document.querySelectorAll('.detail-album');

    // Thêm event listener cho mỗi nút
    showDetailsButtons.forEach(button => {
        button.addEventListener('click', (event) => {
            const albumId = event.target.dataset.alid;
            const xhr = new XMLHttpRequest();
            const url = "./actions/get_album_details.php";
            const params = `alid=${albumId}`;
            xhr.open("POST", url, true);
            xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");

            // Định nghĩa callback để xử lý khi response về từ server
            xhr.onreadystatechange = function () {
                if (xhr.readyState == 4) {
                    if (xhr.status == 200) {
                        // Xử lý dữ liệu từ response
                        try {
                            const data = JSON.parse(xhr.responseText);

                            // Hiển thị dữ liệu trong modal body
                            const modalBody = document.getElementById('albumModal').querySelector('#modal-album-table');
                            modalBody.innerHTML = `
                                <tr>
                                    <th scope="col">Tên album: ${data.alname}</th>
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

        });
    });
</script>
<?php
unset($_SESSION["album_add_error"]);
unset($_SESSION["album_edit_error"]);
// Đóng kết nối
$conn->close();
?>