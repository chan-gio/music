<?php
    
    $uid = $_SESSION['uid'];
    $sql = "select * from user where uid = " .$uid ;
    $result = $conn->query($sql);
    $row = $result->fetch_assoc();
?>

<body>
<div style="border:2px solid #333;position: relative; height: 200px;width: 100%;border-radius: 10px;">
    <div class="user-info" style="left: 400px;">
        <h2 >Username: </h2>
        <h3 style="position: relative; bottom: 20px; font-size: 40px;"><?php echo $row['uname'] ?></h3>
    </div>
    <div class="user-info" style="bottom: 50px; left: 400px;">
        <h2>Email: </h2>
        <h3 style="position: relative; top: 6px;"><?php echo $row['uemail'] ?></h3>
    </div>
        <button class="logout" onclick="confirmLogout()">Log out</button>
</div>
</body>

<style>
      .user-info {
        max-width: 270px;
        width:100%;
        padding: 15px;
        font-size: 19px;
        position: relative;
        display: flex;
    }
    .logout {
        bottom: 150px;
        position: relative;
        left: 1200px;
        font-size: 24px;
        text-align: center;
        cursor: pointer;
        outline: none;
        border: none;
        box-shadow: 0 9px #999;
    }

    .button:hover {background-color: #E6E6E6}

    .logout:active {
        background-color: red;
        box-shadow: 0 5px #666;
        transform: translateY(4px);
    }
    .logout {
        display: flex;
        align-items: center;
        justify-content: flex-end;
        width: 7px;
        height: 10px;
        background-color: #282F8A;
        color: #fff;
        border-radius: 7px;
        padding: 25px 60px 25px 90px;
        }
</style>

<script>
function confirmLogout() {
    Swal.fire({
        title: "Do you want to log out?",
        showCancelButton: true,
        confirmButtonText: "Yes",
        cancelButtonText: "No"
    }).then((result) => {
        if (result.isConfirmed) {
            // Nếu người dùng đồng ý, chuyển hướng đến trang login.php
            window.location.href = "./actions/logout_action.php";
        }
    });
}
</script>