<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Đăng ký</title>
</head> 

<body>
    <div class="background">
    <img src="../images/logo/logo.png" class="logo">
    <form action="./actions/signup_action.php" method="post">
        <input type="text" placeholder="                Email" name="email" id="Email_txt" class="email">
        <input type="text" placeholder="                Username" name="username" id="username_txt" class="username">
        <input type="password" placeholder="                Password" name="password" id="password_txt" class="password">
        <input type="password" placeholder="                Confirm Password" name="password2" id="password2_txt" class="confirmpassword">
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
        <button type="submit" class="buttonsignup">Sign Up</button>
        
    </form>
    <a class="signup2">Already have account? <a href="login.php" class="signup">Sign In</a></a>
    </div>
    <style>
        .email{
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
    .username{
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
    .password{
        position: absolute;
        width: 445px;
        height: 50px;
        left: 128px;
        top: 378px;
        font-family: 'Actor';
        font-style: normal;
        font-weight: 400;
        font-size: 18px;
        line-height: 22px;
        background: #FFFEFE;
        border-radius: 35px;

    }
    .confirmpassword{
        position: absolute;
        width: 445px;
        height: 50px;
        left: 128px;
        top: 468px;
        font-family: 'Actor';
        font-style: normal;
        font-weight: 400;
        font-size: 18px;
        line-height: 22px;
        background: #FFFEFE;
        border-radius: 35px;

    }
    .buttonsignup{
        position: absolute;
        width: 445px;
        height: 60px;
        left: 128px;
        top: 581px;
        background: #A522F7;
        border-radius: 35px;
        font-family: 'Adamina';
        font-style: normal;
        font-weight: 400;
        font-size: 20px;
        line-height: 27px;
        color: #E7E7E7;
    }
    .signup2{
        position: absolute;
        width: 285px;
        height: 34px;
        left: 210px;
        top: 680px;

        font-family: 'Adamina';
        font-style: normal;
        font-weight: 400;
        font-size: 18px;
        line-height: 25px;
    }
    .signup{

        position: absolute;
        width: 285px;
        height: 34px;
        left: 390px;
        top: 680px;

        font-family: 'Adamina';
        font-style: normal;
        font-weight: 400;
        font-size: 18px;
        line-height: 25px;

        color: red;

        transform: rotate(0.01deg);

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


</body>

</html>