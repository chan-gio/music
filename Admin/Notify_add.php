<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Thêm thông báo</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <!-- Thư viện jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>

    <!-- Thư viện Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Thư viện Bootstrap JS (popper.js và bootstrap.bundle.js) -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

</head>

<?php
if (!isset($_SESSION["notify_add_error"])) {
    $_SESSION["notify_add_error"] = "";
}
?>

<body style="margin-left:100px;background-color: #f1efef">
    <h2 style="margin-top:10px">Thêm thông báo mới</h2>
    <form class="row g-3" action="./actions/Notify_add_action.php" method="POST" enctype="multipart/form-data" style="background-color:white;border:1px solid #ccc;margin-top:30px;padding:20px;border-radius:10px;">
        <div class="col-md-12">
            <label for="pname" class="form-label">Tên thông báo:</label>
            <input type="text" class="form-control" id="sname" name="txtnname" placeholder="" required>
        </div>
       
        <div class="col-md-12">
            <label for="pname" class="form-label">Chi tiết:</label>
            <textarea type="text" class="form-control" id="sname" name="txtndesc" placeholder="" required></textarea>
        </div>

        <div class="col-md-12">
            <label for="pimage" class="form-label">Ảnh</label>
            <input type="file" class="form-control" name="txtnimage" accept=".jpg" required>
        </div>

        
        <div class="col-md-12">
            <label for="pname" class="form-label">Đường dẫn (nếu có):</label>
            <input type="text" class="form-control" id="sname" name="txtnlink" placeholder="" required>
        </div>

        

        <font color=red><?php echo $_SESSION["notify_add_error"]; ?></font><br>

        <div class="col-12">
            <button class="btn btn-primary" type="reset">Reset</button>
            <button class="btn btn-primary" type="submit">Thêm thông báo</button>
        </div>
    </form>

</body>



<?php
unset($_SESSION["notify_add_error"]);
?>



</html>