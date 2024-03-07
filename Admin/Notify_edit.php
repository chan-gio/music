<?php


if (!isset($_SESSION["notify_edit_error"])) {
    $_SESSION["notify_edit_error"] = "";
}

include("connect.php");

if (isset($_GET["nid"])) {
    $nid = $_GET["nid"];

    // Lấy thông tin thông báo từ CSDL
    $sql = "SELECT * FROM notify WHERE nid = $nid";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
    } else {
        $_SESSION["notify_edit_error"] = "Không tìm thấy thông báo với mã $nid";
        header("Location: index.php?manage=Notify");
        exit();
    }
} else {
    $_SESSION["notify_edit_error"] = "Mã thông báo không được cung cấp";
    header("Location: index.php?manage=Notify");
    exit();
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Chỉnh sửa thông báo</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <!-- Thư viện jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>

    <!-- Thư viện Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Thư viện Bootstrap JS (popper.js và bootstrap.bundle.js) -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

</head>

<body style="margin-left:100px;background-color: #f1efef">
    <h2 style="margin-top:10px">Chỉnh sửa thông báo</h2>
    <form class="row g-3" action="./actions/Notify_edit_action.php?nid=<?php echo $nid ?>" method="POST"
        enctype="multipart/form-data"
        style="background-color:white;border:1px solid #ccc;margin-top:30px;padding:20px;border-radius:10px;">
        <div class="col-md-12">
            <label for="nname" class="form-label">Tên thông báo:</label>
            <input type="text" class="form-control" id="nname" name="txtnname" placeholder=""
                value="<?php echo $row['nname'] ?>" required>
        </div>

        <div class="col-md-12">
            <label for="ndesc" class="form-label">Chi tiết:</label>
            <textarea type="text" class="form-control" id="ndesc" name="txtndesc" placeholder=""
                required><?php echo $row['ndesc'] ?></textarea>
        </div>

        <div class="col-md-12">
            <label for="nlink" class="form-label">Đường dẫn:</label>
            <input type="text" class="form-control" id="nlink" name="txtnlink" placeholder=""
                value="<?php echo $row['nlink'] ?>" required>
        </div>

        <div class="col-md-12">
            <label for="nimage" class="form-label">Ảnh:</label>
            <br>
            <img src="../notify/<?php echo $row['nimage'] ?>" alt="Notify Image" style="width: 400px; height: auto;">
            <br>
            <label for="" class="form-label">Chọn ảnh khác:</label>
            <input type="file" class="form-control" name="txtnimage" accept=".jpg" placeholder="chọn ảnh khác">
        </div>

        <font color=red><?php echo $_SESSION["notify_edit_error"]; ?></font><br>

        <div class="col-12">
            <button class="btn btn-primary" type="reset">Reset</button>
            <button class="btn btn-primary" type="submit">Lưu</button>
        </div>
    </form>

</body>

<?php
unset($_SESSION["notify_edit_error"]);
$conn->close();
?>

</html>
