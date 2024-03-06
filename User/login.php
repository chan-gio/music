<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Đăng nhập</title>
</head>

<body>
    <div class="background">
        <img src="../images/logo/logo.png" class="logo">
        <form action="./actions/login_action.php" method="post">
            <input type="text" placeholder="                Username" name="username" id="username_txt" class="signin">
            <input type="password" placeholder="                Password" name="password" id="password_txt" class="password">
            <?php
            // Display error message if redirected with an error parameter
            if (isset($_GET['error']) && $_GET['error'] == 1) {
                echo '<p style="color: red;top: 290px;left: 170px; position: relative;">Sai tên đăng nhập hoặc mật khẩu. Vui lòng thử lại.</p>';
            }
            else if(isset($_GET['error']) && $_GET['error'] == 2) {
                echo '<p style="color: red;top: 290px;left: 60px; position: relative;">Tài khoản của bạn hiện đang tạm bị khóa, vui lòng liên hệ trung tâm hỗ trợ để được giải quyết!</p>';
            }
            else if(isset($_GET['error']) && $_GET['error'] == 7) {
                echo '<p style="color: red;top: 290px;left: 220px; position: relative;">Đăng ký tạo tài khoản mới thành công</p>';
            }
            else if(isset($_GET['error']) && $_GET['error'] == 6) {
                echo '<p style="color: red;top: 290px;left: 270px; position: relative;">Đăng xuất thành công</p>';
            }
            ?>
            <button type="submit" class="buttonsignin">Sign In</button>
        </form>
        <a class="signup2">Don't have an account? <a href="signup.php" class="signup">Sign Up</a></a>
    </div>

</body>
<style>
    .signin{
        position: relative;
        width: 445px;
        height: 50px;
        left: 128px;
        top: 202px;
        
        
        font-family: 'Actor';
        font-style: normal;
        font-weight: 400;
        font-size: 18px;
        line-height: 22px;

        color: #9B9B9B;


        background: #FFFFFF;
        border-radius: 35px;
    }
    .signup2{
        position: absolute;
        width: 285px;
        height: 34px;
        left: 210px;
        top: 500px;

        font-family: 'Adamina';
        font-style: normal;
        font-weight: 400;
        font-size: 18px;
        line-height: 25px;
    }
    .password{
        position: absolute;
        width: 445px;
        height: 50px;
        left: 128px;
        top: 288px;
        font-family: 'Actor';
        font-style: normal;
        font-weight: 400;
        font-size: 18px;
        line-height: 22px;
        background: #FFFEFE;
        border-radius: 35px;

    }
    .signup{

        position: absolute;
        width: 285px;
        height: 34px;
        left: 390px;
        top: 500px;

        font-family: 'Adamina';
        font-style: normal;
        font-weight: 400;
        font-size: 18px;
        line-height: 25px;

        color: red;

        transform: rotate(0.01deg);

    }
    .buttonsignin{
        position: absolute;
        width: 445px;
        height: 60px;
        left: 128px;
        top: 401px;
        background: #A522F7;
        border-radius: 35px;
        font-family: 'Adamina';
        font-style: normal;
        font-weight: 400;
        font-size: 20px;
        line-height: 27px;
        color: #E7E7E7;
    }
    .background{
        position: absolute;
        width: 700px;
        height: 750px;
        left: calc(50% - 700px/2);
        top: 0px;

        background: rgba(255, 255, 255, 0.5);

    }
    .logo{

        position: absolute;
        width: 266px;
        height: 55px;
        left: 222px;
        top: 73px;

    }
    body{
        background-image: url('../images/logo/bglogin.png');    
        
    }
</style>

</html>