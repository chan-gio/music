<?php
    
    $uid = $_SESSION['uid'];
    $sql = "select * from user where uid = " .$uid ;
    $result = $conn->query($sql);
    $row = $result->fetch_assoc();
?>

<body>
<div class="user-info">
    <h2>Username: </h2>
    <h3><?php echo $row['uname'] ?></h3>
</div>
<div class="user-info">
    <h2>Email: </h2>
    <h3><?php echo $row['uemail'] ?></h3>
</div>
    <button class="logout" onclick="confirmLogout()">Log out</button>

</body>

<style>
      .user-info {
        background-color: #f5f5f5;
        border: 1px solid #ddd;
        border-radius: 5px;
        margin-bottom: 20px;
        padding: 15px;
        box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
    }

    /* Style for the username heading */
    .user-info h2 {
        color: #3498db;
        font-size: 22px;
        margin-bottom: 5px;
    }

    /* Style for the username data */
    .user-info h3 {
        color: #555;
        font-size: 18px;
    }

    /* Style for the email heading */
    .user-info h2 + div h2 {
        color: #27ae60;
        font-size: 22px;
        margin-top: 15px; /* Adjust spacing between sections */
        margin-bottom: 5px;
    }

    /* Style for the email data */
    .user-info h2 + div h3 {
        color: #555;
        font-size: 18px;
    }
    .logout {
        position: relative;
        left: 700px;
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