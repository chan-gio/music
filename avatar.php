<?php
    include("connect.php");
    $uid = $_SESSION['uid'];
    $sql = "select * from user where uid = " .$uid ;
    $result = $conn->query($sql);
    $row = $result->fetch_assoc();
?>

<body>
    <h2>Tên đăng nhập: </h2><h3><?php echo $row['uname'] ?></h3>
    <br>
    <h2>Email: </h2><h3><?php echo $row['uemail'] ?></h3>
    <br>

</body>