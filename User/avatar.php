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
    <button onclick="confirmLogout()">Log out</button>

</body>

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