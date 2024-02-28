<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Đăng nhập dành cho admin</title>
</head>

<body>
    <form action="./actions/admin_login_action.php" method="post">
        <input type="text" placeholder="Tên đăng nhập" name="adname" id="adname_txt">
        <input type="password" placeholder="Mật khẩu" name="adpassword" id="adpassword_txt">
        <?php
        // Display error message if redirected with an error parameter
        if (isset($_GET['aderror']) && $_GET['aderror'] == 1) {
            echo '<p style="color: red;">Sai tên đăng nhập hoặc mật khẩu. Vui lòng thử lại.</p>';
        }
        ?>
        <button type="submit">Đăng nhập</button>
    </form>


</body>

</html>