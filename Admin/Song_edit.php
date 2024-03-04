<?php

include("connect.php");
$sid = $_GET["sid"];

if (!isset($_SESSION["song_edit_error"])) {
    $_SESSION["song_edit_error"] = "";
}

$sql = "SELECT
songs.*,
GROUP_CONCAT(artists.aname SEPARATOR ', ') AS artist_names
FROM
songs
LEFT JOIN songs_artists ON songs.sid = songs_artists.sid
LEFT JOIN artists ON songs_artists.aid = artists.aid
WHERE
songs.sid = " . $sid . "
GROUP BY
songs.sid, songs.sname";

$result = $conn->query($sql);
$row = $result->fetch_assoc();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Chỉnh sửa bài hát</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <!-- Thư viện jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>

    <!-- Thư viện Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Thư viện Bootstrap JS (popper.js và bootstrap.bundle.js) -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</head>

<body style="margin-left:100px;background-color: #f1efef">
    <h2 style="margin-top:10px">Chỉnh sửa bài hát</h2>
    <form class="row g-3" id="songForm" action="./actions/Song_edit_action.php?sid=<?php echo $sid ?>" method="POST" enctype="multipart/form-data" style="background-color:white;border:1px solid #ccc;margin-top:30px;padding:20px;border-radius:10px;">
        <font color=red><?php echo $_SESSION["song_edit_error"]; ?></font><br>

        <div class="col-md-12">
            <label for="pname" class="form-label">Tên:</label>
            <input type="text" class="form-control" id="sname" name="txtsname" value="<?php echo $row['sname'] ?>" required>
        </div>
        <div class="col-md-12">
            <label for="pname" class="form-label">Ca sĩ: <?php echo $row['artist_names'] ?></label>
            <br>
            <button type='button' class='btn btn-primary' data-bs-toggle='modal' data-bs-target='#artistSelectModal'>Chỉnh sửa</button>
            <!-- Modal -->
            <div class="modal fade" id="artistSelectModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog" style="margin: 80px 140px;">
                    <div class="modal-content" style="width: 1360px;">
                        <div class="modal-header">
                            <h2 class="modal-title" id="exampleModalLabel">Chỉnh sửa ca sĩ cho bài hát này</h2>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <h3 class="modal-title fs-5" id="exampleModalLabel">Tìm kiếm ca sĩ</h3>
                            <div class="row g-3">
                                <div class="col-md-6">
                                    <input style="width:100%;" type="text" class="form-control" id="sartist" name="txtsartist" placeholder="">
                                    <div style="width:100%;" id="artistSuggestions"></div>

                                </div>

                                <div class="col-md-3">
                                    <button type='button' class='btn btn-secondary' style="width:100%;" id="resetButton">Reset</button>
                                </div>
                            </div>

                            <br>
                            <h5 for="partist" class="form-label">Ca sĩ:</h5>
                            <br>
                            <div class="row g-3" id="ArtistsContainer">
                                <?php
                                $sqlArtists = "SELECT * FROM artists WHERE astatus = 1";
                                $resultArtists = $conn->query($sqlArtists);

                                while ($row2 = $resultArtists->fetch_assoc()) {
                                    // Kiểm tra xem ca sĩ có trong bảng songs_artists hay không
                                    $sqlCheck = "SELECT * FROM songs_artists WHERE sid = $sid AND aid = {$row2['aid']}";
                                    $resultCheck = $conn->query($sqlCheck);
                                    $isChecked = $resultCheck->num_rows > 0;

                                    echo "
<div class='col-md-3 d-flex'>
    <input style='display: inline-block' class='form-check-input " . ($isChecked ? 'chose' : '') . "' type='checkbox' name='txtsartist[]' value='{$row2['aid']}' id='artistCheckbox{$row2['aid']}' " . ($isChecked ? 'checked' : '') . ">
    <label style='display: inline-block' class='form-check-label'> {$row2['aname']}</label>
</div>";
                                }
                                ?>

                            </div>

                            </select>


                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" id="artists-cancel" data-bs-dismiss="modal">Hủy</button>
                            <button type="button" class="btn btn-primary" id="saveButton" data-bs-dismiss="modal">Lưu</button>
                        </div>
                    </div>
                </div>
            </div>

        </div>

        <div class="col-md-12">
            <label for="simg" class="form-label">Ảnh bìa:</label>
            <br>
            <img src="../images/<?php echo $row['simage'] ?>" alt="Song Image" style="width: 400px; height: auto;">
            <br>
            <label for="" class="form-label">Chọn ảnh khác:</label>
            <input type="file" class="form-control" name="txtsimage" accept=".jpg" placeholder="chọn ảnh khác">
        </div>

        <div class="col-md-12">
            <label for="simg" class="form-label">File:</label>
            <br>
            <audio controls>
                <source src="../songs/<?php echo $row['slink'] ?>" type="audio/mpeg">
            </audio>
            <br>
            <label for="" class="form-label">Thay đổi file:</label>
            <input type="file" class="form-control" name="txtssrc" accept=".mp3" placeholder="chọn file khác">
        </div>







        <div class="col-12">
            <button class="btn btn-primary" type="reset">Reset</button>
            <button class="btn btn-primary" type="submit">Lưu</button>
        </div>
    </form>


</body>

<?php
unset($_SESSION["song_edit_error"]);
?>

<script>
    document.getElementById('sartist').addEventListener('input', function() {
        var input = this.value;

        if (input.length > 0) {
            // Gửi yêu cầu AJAX
            var xhr = new XMLHttpRequest();
            xhr.open('GET', './actions/suggest_artists.php?query=' + input, true);

            xhr.onreadystatechange = function() {
                if (xhr.readyState == 4 && xhr.status == 200) {
                    // Xử lý kết quả
                    var suggestions = JSON.parse(xhr.responseText);
                    displaySuggestions(suggestions);
                }
            };

            xhr.send();
        } else {
            // Nếu input trống, ẩn gợi ý
            document.getElementById('artistSuggestions').innerHTML = '';
        }
    });

    function displaySuggestions(suggestions) {
        var suggestionsContainer = document.getElementById('artistSuggestions');
        suggestionsContainer.innerHTML = '';

        if (suggestions.length > 0) {
            // Hiển thị gợi ý
            var ul = document.createElement('ul');
            suggestions.forEach(function(artist) {
                var li = document.createElement('li');
                li.textContent = artist;
                ul.appendChild(li);
            });
            suggestionsContainer.appendChild(ul);
        } else {
            // Nếu không có gợi ý, ẩn container
            suggestionsContainer.innerHTML = '';
        }
    }

    document.getElementById('artistSuggestions').addEventListener('click', function(e) {
        // Kiểm tra xem sự kiện click có xảy ra trên một thẻ <li> không
        if (e.target.tagName === 'LI') {
            // Lấy nội dung của thẻ <li> được click
            var selectedArtist = e.target.textContent;

            // Đặt nội dung vào ô input
            document.getElementById('sartist').value = selectedArtist;

            // Ẩn danh sách gợi ý
            document.getElementById('artistSuggestions').innerHTML = '';
        }
    });
</script>


<!-- Đặt mã JavaScript ở cuối trang hoặc bên trong sự kiện DOMContentLoaded -->
<!-- Tìm kiếm tên ca sĩ trong model artists -->
<script>
    document.addEventListener("DOMContentLoaded", function() {
        var checkboxes = document.querySelectorAll('.form-check-input');
        var labels = document.querySelectorAll('.form-check-label');

        document.getElementById('sartist').addEventListener('input', function() {
            var input = this.value.toLowerCase();
            var container = document.getElementById('ArtistsContainer');

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
                xhr.open('GET', './actions/suggest_artists.php?query=' + input, true);

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


        // Bắt sự kiện khi nút "Reset" được click
        document.getElementById('resetButton').addEventListener('click', function() {
            // Đặt giá trị của ô input tìm kiếm về rỗng
            document.getElementById('sartist').value = '';

            //ẩn gợi ý
            var suggestionsContainer = document.getElementById('artistSuggestions');
            suggestionsContainer.innerHTML = '';
            // Hiển thị lại tất cả các checkbox và label
            checkboxes.forEach(function(checkbox, index) {
                checkbox.style.display = 'inline-block';
                labels[index].style.display = 'inline-block';
            });
        });
    });

    //Nút hủy
    document.addEventListener("DOMContentLoaded", function() {
        var checkboxes = document.querySelectorAll('.form-check-input');

        // Bắt sự kiện khi nút "Hủy" được click
        document.getElementById('artists-cancel').addEventListener('click', function() {
            // Bỏ chọn tất cả các ô checkbox
            checkboxes.forEach(function(checkbox) {
                checkbox.checked = false;
            });
            //Chọn lại các ô có class là chose
            // Bỏ chọn tất cả các ô checkbox có class là "chosen"
            checkboxes.forEach(function(checkbox) {
                if (checkbox.classList.contains('chose')) {
                    checkbox.checked = true;
                }
            });

        });
    });

    //nút lưu artist modal
    document.addEventListener("DOMContentLoaded", function() {
        document.getElementById('saveButton').addEventListener('click', function() {
            var checkboxes = document.querySelectorAll('.form-check-input');
            var selectedArtists = [];

            checkboxes.forEach(function(checkbox) {
                if (checkbox.checked) {
                    // Nếu checkbox được chọn, thêm giá trị aid vào mảng selectedArtists
                    selectedArtists.push(checkbox.value);
                }
            });



            // Thêm các giá trị aid vào input ẩn để submit cùng với form
            var hiddenInput = document.createElement('input');
            hiddenInput.type = 'hidden';
            hiddenInput.name = 'selectedArtists';
            hiddenInput.value = selectedArtists.join(',');

            // Thêm input ẩn vào form
            document.getElementById('songForm').appendChild(hiddenInput);
        });
    });
</script>

<style>
    /* Sử dụng lớp Bootstrap để làm cho các mục <li> giống với ô input */
    #artistSuggestions ul li {
        padding: 0.375rem 0.75rem;
        margin: 0;
        display: block;
        width: 100%;
        color: #495057;
        background-color: #fff;
        border: 1px solid #ced4da;
        border-radius: 0.25rem;
    }

    ul {
        padding-left: 0;
    }

    /* Hiệu ứng hover cho mỗi mục trong danh sách */
    #artistSuggestions ul li:hover {
        background-color: #f0f0f0;
        cursor: pointer;
    }
</style>

</html>