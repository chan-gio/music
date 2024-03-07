<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Chỉnh sửa</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

</head>

<body>
    <?php
    $alid = $_GET['alid'];
    include("connect.php");
    $sql = "select * from albums where alid = $alid";
    $result = $conn->query($sql);
    $row = $result->fetch_assoc();
    ?>

    <body style="margin-left:100px;background-color: #f1efef">
        <h2 style="margin-top:10px">Chỉnh sửa bài hát trong album</h2>
        <table class="table table-striped" style="background-color:white;border:1px solid #ccc;margin-top:30px;padding:20px">
            <thead>
                <tr>
                    <th scope="col">Mã album</th>
                    <th scope="col">Tên album</th>
                    <th scope="col">Ca sĩ</th>
                    <th scope="col">Ảnh bìa</th>
                    <th scope="col">Lượt xem</th>
                    <th scope="col">Tình trạng</th>
                </tr>
            </thead>
            <tbody>

            </tbody>
            <tbody id="modal-album-table">

            </tbody>
        </table>
        <form class="row g-3" id="songForm" action="./actions/song_in_album_edit.php?alid=<?php echo $alid ?>" method="POST" enctype="multipart/form-data" style="background-color:white;border:1px solid #ccc;margin-top:30px;padding:20px;border-radius:10px;">
            <div class="modal-header">
            </div>
            <div class="modal-body">
                <h3 class="modal-title fs-5" id="exampleModalLabel">Tìm kiếm bài hát</h3>
                <div class="row g-3">
                    <div class="col-md-6">
                        <input style="width:100%;" type="text" class="form-control" id="sartist" name="txtsartist" placeholder="">

                    </div>

                    <div class="col-md-3">
                        <button type='button' class='btn btn-secondary' style="width:100%;" id="resetButton">Reset</button>
                    </div>
                </div>

                <br>
                <h5 for="partist" class="form-label">Bài hát:</h5>
                <br>
                <div class="row g-3" id="SongsContainer">
                    <?php
                    $sqlArtists = "SELECT * FROM songs WHERE sstatus = 1";
                    $resultArtists = $conn->query($sqlArtists);

                    while ($row2 = $resultArtists->fetch_assoc()) {
                        // Kiểm tra xem bài hát có trong bảng songs_artists hay không
                        $sqlCheck = "SELECT * FROM albums_songs WHERE sid = " . $row2['sid'] . " and alid=" . $alid;
                        $resultCheck = $conn->query($sqlCheck);
                        $isChecked = $resultCheck->num_rows > 0;

                        echo "
<div class='col-md-3 d-flex'>
    <input style='display: inline-block' class='form-check-input " . ($isChecked ? 'chose' : '') . "' type='checkbox' name='txtsongs[]' value='{$row2['sid']}' id='songCheckbox{$row2['sid']}' " . ($isChecked ? 'checked' : '') . ">
    <label style='display: inline-block' class='form-check-label'> {$row2['sname']}</label>
</div>";
                    }
                    ?>

                </div>

                </select>


            </div>
            <div class="modal-footer">
            </div>


            <div class="col-12">
                <button class="btn btn-primary" type="reset">Reset</button>
                <button class="btn btn-primary" id="submitButton" type="submit">Lưu</button>
            </div>
        </form>

    </body>

</html>

<script>
    //Hàm chuyển dấu xuống dòng trong sql thành br trong html
    function nl2br_custom(str) {
        return str ? str.replace(/(?:\r\n|\r|\n)/g, '<br>') : 'Chưa có ca sĩ';
    }
    const albumId = <?php echo $alid ?>;
    console.log(albumId); // Kiểm tra giá trị albumId trong consoleconst albumId = event.target.dataset.alid;
    const xhr = new XMLHttpRequest();
    const url = "./actions/get_album_details.php";
    const params = `alid=${albumId}`;
    xhr.open("POST", url, true);
    xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");

    // Lấy modal body   
    const modalBody = document.getElementById('modal-album-table');

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
                    const modalBody = document.getElementById('modal-album-table');

                    modalBody.innerHTML = `
                                <tr>
                                    <td>${data.alid}</td>
                                    <td>${data.alname}</td>
                                    <td>${artist_names}</td>
                                    <td><img src="../albums/${data.alimage}" alt="Album Image" style="width: 100px; height: auto;"></td>
                                    <td>${data.alview}</td>
                                    <td>Khả dụng</td>

                                    
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


    // Bắt sự kiện khi nút "Reset" được click
    document.getElementById('resetButton').addEventListener('click', function() {
        // Đặt giá trị của ô input tìm kiếm về rỗng
        document.getElementById('sartist').value = '';



    });

    //Sự kiện hiện các ô checkbox theo giá trị tìm kiếm
    document.addEventListener("DOMContentLoaded", function() {
        var checkboxes = document.querySelectorAll('.form-check-input');
        var labels = document.querySelectorAll('.form-check-label');

        document.getElementById('sartist').addEventListener('input', function() {
            var input = this.value.toLowerCase();
            var container = document.getElementById('SongsContainer');

            if (input.length > 0) {
                // Lưu trữ các thẻ div hiện tại
                var currentDivs = container.querySelectorAll('.col-md-3.d-flex');
                var suggestionsDivs = [];

                // Di chuyển các div hiện lên trên đầu
                currentDivs.forEach(function(div) {
                    if (div.textContent.toLowerCase().includes(input)) {
                        // Nếu div phù hợp, thêm vào mảng suggestionsDivs
                        suggestionsDivs.push(div);
                    } else {
                        // Nếu không phù hợp, giữ nguyên trong container
                        container.appendChild(div);
                    }
                });

                // Đẩy các div phù hợp lên đầu container
                suggestionsDivs.forEach(function(div) {
                    container.insertBefore(div, container.firstChild);
                });

                // Gửi yêu cầu AJAX
                var xhr = new XMLHttpRequest();
                xhr.open('GET', './actions/suggest_songs.php?query=' + input, true);

                xhr.onreadystatechange = function() {
                    if (xhr.readyState == 4 && xhr.status == 200) {
                        // Xử lý kết quả
                        var suggestions = JSON.parse(xhr.responseText);
                        displaySuggestions(suggestions);
                    }
                };

                xhr.send();
            } else {
                // Nếu input trống, hiển thị lại tất cả div như cũ
                var currentDivs = container.querySelectorAll('.col-md-3.d-flex');
                currentDivs.forEach(function(div) {
                    container.appendChild(div);
                });

                // Ẩn gợi ý
                document.getElementById('artistSuggestions').innerHTML = '';
            }
        });



    });

    //nút lưu artist modal
    document.addEventListener("DOMContentLoaded", function() {
        document.getElementById('submitButton').addEventListener('click', function() {
            var checkboxes = document.querySelectorAll('.form-check-input');
            var selectedSongs = [];

            checkboxes.forEach(function(checkbox) {
                if (checkbox.checked) {
                    // Nếu checkbox được chọn, thêm giá trị aid vào mảng selectedSongs
                    selectedSongs.push(checkbox.value);
                }
            });



            // Thêm các giá trị aid vào input ẩn để submit cùng với form
            var hiddenInput = document.createElement('input');
            hiddenInput.type = 'hidden';
            hiddenInput.name = 'selectedSongs';
            hiddenInput.value = selectedSongs.join(',');

            // Thêm input ẩn vào form
            document.getElementById('songForm').appendChild(hiddenInput);
        });
    });
</script>