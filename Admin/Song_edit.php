<?php

include("connect.php");
$sid = $_GET["sid"];

if(!isset($_SESSION["song_edit_error"])){
    $_SESSION["song_edit_error"] = "";
}

$sql = "select * from songs where sid=" . $sid;
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
    <form class="row g-3" action="Song_edit_action.php?sid=<?php echo $sid ?>" method="POST" enctype="multipart/form-data" style="background-color:white;border:1px solid #ccc;margin-top:30px;padding:20px;border-radius:10px;">
        <font color=red><?php echo $_SESSION["song_edit_error"]; ?></font><br>
        
        <div class="col-md-12">
            <label for="pname" class="form-label">Tên:</label>
            <input type="text" class="form-control" id="sname" name="txtsname" value="<?php echo $row['sname'] ?>" required>
        </div>
        <div class="col-md-12">
            <label for="pname" class="form-label">Ca sĩ:</label>
            <input type="text" class="form-control" id="sartist" name="txtsartist" value="<?php echo $row['sartist'] ?>" required>
        </div>
       
        <div class="col-md-12">
            <label for="simg" class="form-label">Ảnh bìa:</label>
            <br>
            <img src="../images/<?php echo $row['simg'] ?>" alt="Song Image" style="width: 400px; height: auto;">
            <br>
            <label for="" class="form-label">Chọn ảnh khác:</label>
            <input type="file" class="form-control" name="txtsimg" accept=".jpg" placeholder="chọn ảnh khác">
        </div>

        <div class="col-md-12">
            <label for="simg" class="form-label">File:</label>
            <br>
            <audio controls>
                        <source src="../songs/<?php echo $row['ssrc'] ?>" type="audio/mpeg">
            </audio>
            <br>
            <label for="" class="form-label">Thay đổi file:</label>
            <input type="file" class="form-control" name="txtssrc" accept=".mp3" placeholder="chọn file khác">
        </div>

       
        

        


        <div class="col-12">
            <button class="btn btn-primary" type="reset">Reset</button>
            <button class="btn btn-primary" type="submit">Sửa bài hát</button>
        </div>
    </form>

   
</body>

<?php
unset($_SESSION["song_edit_error"]);
?>

</html>