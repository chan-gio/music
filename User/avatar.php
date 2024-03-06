<?php
    
    $uid = $_SESSION['uid'];
    $sql = "select * from user where uid = " .$uid ;
    $result = $conn->query($sql);
    $row = $result->fetch_assoc();
?>

<body>
    <h2>Username: </h2><h3><?php echo $row['uname'] ?></h3>
    <br>
    <h2>Email: </h2><h3><?php echo $row['uemail'] ?></h3>
    <br>
    <button class="logout" onclick="confirmLogout()">Log out</button>

</body>

<style>
    .logout {
        width: 60px;
        height: 35px;
        top: 20px;
        left: 500px;
        position: relative;
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