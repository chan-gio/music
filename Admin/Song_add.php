<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Thêm bài hát</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <!-- Thư viện jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>

    <!-- Thư viện Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Thư viện Bootstrap JS (popper.js và bootstrap.bundle.js) -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

</head>

<?php
if (!isset($_SESSION["song_add_error"])) {
    $_SESSION["song_add_error"] = "";
}
?>

<body style="margin-left:100px;background-color: #f1efef">
    <h2 style="margin-top:10px">Thêm bài hát mới</h2>
    <form class="row g-3" action="Song_add_action.php" method="POST" enctype="multipart/form-data" style="background-color:white;border:1px solid #ccc;margin-top:30px;padding:20px;border-radius:10px;">
        <div class="col-md-12">
            <label for="pname" class="form-label">Tên bài hát:</label>
            <input type="text" class="form-control" id="sname" name="txtsname" placeholder="" required>
        </div>
        <div class="col-md-12">
            <label for="pname" class="form-label">Ca sĩ:</label>
            <input type="text" class="form-control" id="sartist" name="txtsartist" placeholder="" required>
            <div id="artistSuggestions"></div>
        </div>

        <div class="col-md-12">
            <label for="pimage" class="form-label">Ảnh</label>
            <input type="file" class="form-control" name="txtsimage" accept=".jpg" required>
        </div>

        <div class="col-md-12">
            <label for="psrc" class="form-label">File</label>
            <input type="file" class="form-control" name="txtssrc" accept=".mp3" required>
        </div>


        <div class="col-md-12">
            <label for="sstatus" class="form-label">Trạng thái</label>
            <select class="form-select" id="sstatus" name="sstatus" required>
                <option value="1">Khả dụng</option>
                <option value="2">Không khả dụng</option>
            </select>
        </div>

        <font color=red><?php echo $_SESSION["song_add_error"]; ?></font><br>

        <div class="col-12">
            <button class="btn btn-primary" type="reset">Reset</button>
            <button class="btn btn-primary" type="submit">Thêm bài hát</button>
        </div>
    </form>

</body>

<script>
    document.getElementById('sartist').addEventListener('input', function() {
        var input = this.value;

        if (input.length > 0) {
            // Gửi yêu cầu AJAX
            var xhr = new XMLHttpRequest();
            xhr.open('GET', 'suggest_artists.php?query=' + input, true);

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

<?php
unset($_SESSION["song_add_error"]);
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