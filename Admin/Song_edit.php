<?php

include("connect.php");
$sid = $_GET["sid"];

if(!isset($_SESSION["song_edit_error"])){
    $_SESSION["song_edit_error"] = "";
}

$sql = "SELECT songs.*, artists.aname
FROM songs
JOIN artists ON songs.aid = artists.aid
WHERE sid=" . $sid;
$result = $conn->query($sql);
$row = $result->fetch_assoc();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Chỉnh sửa bài hát</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
</head>

<body style="margin-left:100px;background-color: #f1efef">
    <h2 style="margin-top:10px">Chỉnh sửa bài hát</h2>
    <form class="row g-3" action="./actions/Song_edit_action.php?sid=<?php echo $sid ?>" method="POST" enctype="multipart/form-data" style="background-color:white;border:1px solid #ccc;margin-top:30px;padding:20px;border-radius:10px;">
        <font color=red><?php echo $_SESSION["song_edit_error"]; ?></font><br>
        
        <div class="col-md-12">
            <label for="pname" class="form-label">Tên:</label>
            <input type="text" class="form-control" id="sname" name="txtsname" value="<?php echo $row['sname'] ?>" required>
        </div>
        <div class="col-md-12">
            <label for="pname" class="form-label">Ca sĩ:</label>
            <input type="text" class="form-control" id="sartist" name="txtsartist" value="<?php echo $row['aname'] ?>" required>
            <div id="artistSuggestions"></div>

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