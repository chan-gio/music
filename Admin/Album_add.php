<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Thêm album</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <!-- Thư viện jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>

    <!-- Thư viện Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Thư viện Bootstrap JS (popper.js và bootstrap.bundle.js) -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

</head>

<?php
if (!isset($_SESSION["album_add_error"])) {
    $_SESSION["album_add_error"] = "";
}
?>

<body style="margin-left:100px;background-color: #f1efef">
    <h2 style="margin-top:10px">Thêm album mới</h2>
    <form class="row g-3" id="songForm" action="./actions/Album_add_action.php" method="POST" enctype="multipart/form-data" style="background-color:white;border:1px solid #ccc;margin-top:30px;padding:20px;border-radius:10px;">
        <div class="col-md-12">
            <label for="pname" class="form-label">Tên album:</label>
            <input type="text" class="form-control" id="alname" name="txtalname" placeholder="" required>
        </div>
        <div class="col-md-12">
            <label for="pname" class="form-label">Bài hát có trong album:</label><br>
            <button type='button' class='btn btn-primary' data-bs-toggle='modal' data-bs-target='#artistSelectModal'>Thêm bài hát</button>
            <!-- Modal -->
            <div class="modal fade" id="artistSelectModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                <div class="modal-dialog" style="margin: 80px 140px;">
                    <div class="modal-content" style="width: 1360px;">
                        <div class="modal-header">
                            <h2 class="modal-title" id="exampleModalLabel">Thêm bài hát cho album này</h2>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
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
                                    $sqlCheck = "SELECT * FROM albums_songs WHERE sid = " . $row2['sid'];
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
            <label for="pimage" class="form-label">Ảnh</label>
            <input type="file" class="form-control" name="txtalimage" accept=".jpg" required>
        </div>

        


        <div class="col-md-12">
            <label for="sstatus" class="form-label">Trạng thái</label>
            <select class="form-select" id="alstatus" name="alstatus" required>
                <option value="1">Khả dụng</option>
                <option value="2">Không khả dụng</option>
            </select>
        </div>

        <font color=red><?php echo $_SESSION["album_add_error"]; ?></font><br>

        <div class="col-12">
            <button class="btn btn-primary" type="reset">Reset</button>
            <button class="btn btn-primary" type="submit">Thêm album</button>
        </div>
    </form>


</body>





<!-- Đặt mã JavaScript ở cuối trang hoặc bên trong sự kiện DOMContentLoaded -->
<!-- Tìm kiếm tên ca sĩ trong model artists -->
<script>
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

<?php
unset($_SESSION["album_add_error"]);
?>

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