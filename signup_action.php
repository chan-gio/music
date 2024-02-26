<?php
session_start();

include('connect.php');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = $_POST['email'];
    $username = $_POST['username'];
    $password = $_POST['password'];
    $password2 = $_POST['password2'];

    if($password != $password2) {
        header("Location:signup.php?error=pass");
        exit();
    }

    // Kiểm tra email trùng lặp
    $sql = "SELECT * FROM user WHERE uemail = '$email'";
    
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        // Email đã tồn tại, chuyển hướng với thông báo lỗi
        
        header("Location:signup.php?error=1");
        exit();
    }

    // Kiểm tra tên đăng nhập đã tồn tại
    $sql = "SELECT * FROM user WHERE uname = '$username'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        // Tên đăng nhập đã tồn tại, chuyển hướng với thông báo lỗi
        header("Location: signup.php?error=2");
        exit();
    }

    

    // // Kiểm tra mật khẩu hợp lệ (ít nhất 1 chữ và 1 số)
    // if (!preg_match('/^(?=.*[A-Za-z])(?=.*\d).{8,}$/', $password)) {
    //     // Mật khẩu không hợp lệ, chuyển hướng với thông báo lỗi
    //     header("Location: signup.php?error=3");
    //     exit();
    // }

    // Insert user vào cơ sở dữ liệu
    $sqlInsert = "INSERT INTO user(uemail, uname, upassword) VALUES ('$email', '$username', '$password')";
    
    if ($conn->query($sqlInsert) === TRUE) {
        // Đăng ký thành công, chuyển hướng đến trang khác (ví dụ: index.php)
        header("Location: login.php?error=7");
        exit();
    } else {
        // Đăng ký thất bại, chuyển hướng với thông báo lỗi
        header("Location: signup.php?error=4");
        exit();
    }
}

$conn->close();
?>
