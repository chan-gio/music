<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Đăng ký</title>
</head> 

<body>
    <form action="signup_action.php" method="post">
        <input type="text" placeholder="Email" name="email" id="Email_txt">
        <input type="text" placeholder="Tên đăng nhập" name="username" id="username_txt">
        <input type="password" placeholder="Mật khẩu" name="password" id="password_txt">
        <input type="password"placeholder="Nhập lại mật khẩu" name="password2" id="password2_txt">
        <?php
        if (isset($_GET['error']) && $_GET['error'] == 'pass') {
            echo '<p style="color: red;">Mật khẩu nhập lại không đúng.</p>';
        }
        if (isset($_GET['error']) && $_GET['error'] == 1) {
            echo '<p style="color: red;">Email đã có người dùng. Vui lòng thử lại.</p>';
        }
        else if(isset($_GET['error']) && $_GET['error'] == 2) {
            echo '<p style="color: red;">Tên đăng nhập đã có người dùng. Vui lòng thử lại.</p>';
        }
        else if(isset($_GET['error']) && $_GET['error'] == 3) {
            echo '<p style="color: red;">Mật khẩu không hợp lệ. Vui lòng thử lại. (Mật khẩu hợp lệ phải có ít nhất 1 chữ cái và 1 chữ số.</p>';
        }
        ?>
        <button type="submit">Đăng ký</button>
    </form>


</body>

</html>