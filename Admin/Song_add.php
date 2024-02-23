<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Thêm bài hát</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
</head>

<?php
    if (!isset($_SESSION["song_add_error"])){
        $_SESSION["song_add_error"]="";
    }
?>

<body style="margin-left:100px;background-color: #f1efef" >
    <h2 style="margin-top:10px">Thêm bài hát mới</h2>
    <form class="row g-3" action="Song_add_action.php" method="POST" enctype="multipart/form-data" style="background-color:white;border:1px solid #ccc;margin-top:30px;padding:20px;border-radius:10px;">
        <div class="col-md-12">
            <label for="pname" class="form-label">Tên bài hát:</label>
            <input type="text" class="form-control" id="sname" name="txtsname" placeholder="" required>
        </div>
        <div class="col-md-12">
            <label for="pname" class="form-label">Ca sĩ:</label>
            <input type="text" class="form-control" id="sartist" name="txtsartist" placeholder="" required>
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

<?php
unset($_SESSION["song_add_error"]);
?>

</html>