<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Chỉnh sửa album</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <!-- Thư viện jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>

    <!-- Thư viện Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Thư viện Bootstrap JS (popper.js và bootstrap.bundle.js) -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

</head>

<?php
if (!isset($_SESSION["album_edit_error"])) {
    $_SESSION["album_edit_error"] = "";
}
$alid = $_GET['alid'];
$sql = "select * from albums where alid=$alid";
$result = $conn->query($sql);
$row=$result->fetch_assoc();
?>

<body style="margin-left:100px;background-color: #f1efef">
    <h2 style="margin-top:10px">Chỉnh sửa album</h2>
    <form class="row g-3" id="songForm" action="./actions/Album_edit_action.php?alid=<?php echo $alid ?>&alname=<?php echo $row['alname'] ?>" method="POST" enctype="multipart/form-data" style="background-color:white;border:1px solid #ccc;margin-top:30px;padding:20px;border-radius:10px;">
        <div class="col-md-12">
            <label for="pname" class="form-label">Tên album:</label>
            <input type="text" class="form-control" id="alname" name="txtalname" value="<?php echo $row['alname'] ?>" placeholder="" required>
        </div>
        

        <div class="col-md-12">
            <label for="pimage" class="form-label">Ảnh</label>
            <br>
            <img src="../albums/<?php echo $row['alimage'] ?>" alt="Album Image" style="width: 400px; height: auto;">
            <br>
            <label for="" class="form-label">Chọn ảnh khác:</label>
            <input type="file" class="form-control" name="txtalimage" accept=".jpg" placeholder="chọn ảnh khác" >
        </div>

        


       

        <font color=red><?php echo $_SESSION["album_edit_error"]; ?></font><br>

        <div class="col-12">
            <button class="btn btn-primary" type="reset">Reset</button>
            <button class="btn btn-primary" type="submit">Lưu</button>
        </div>
    </form>


</body>






<?php
unset($_SESSION["album_edit_error"]);
?>



</html>