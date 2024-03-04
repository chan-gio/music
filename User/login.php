<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Đăng nhập</title>
</head>

<body>
    <form action="./actions/login_action.php" method="post">
        <input type="text" placeholder="Tên đăng nhập" name="username" id="username_txt">
        <input type="password" placeholder="Mật khẩu" name="password" id="password_txt">
        <?php
        // Display error message if redirected with an error parameter
        if (isset($_GET['error']) && $_GET['error'] == 1) {
            echo '<p style="color: red;">Sai tên đăng nhập hoặc mật khẩu. Vui lòng thử lại.</p>';
        }
        else if(isset($_GET['error']) && $_GET['error'] == 7) {
            echo '<p style="color: red;">Đăng ký tạo tài khoản mới thành công</p>';
        }
        else if(isset($_GET['error']) && $_GET['error'] == 6) {
            echo '<p style="color: red;">Đăng xuất thành công</p>';
        }
        ?>
        <button type="submit">Đăng nhập</button>
    </form>


</body>

</html>