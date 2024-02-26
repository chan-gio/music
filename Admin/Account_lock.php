<?php 
	session_start();
	require("../connect.php");
	$uid = $_REQUEST["uid"];

    $query = "SELECT * FROM user where uid=".$uid;
    $result = $conn->query($query);
    $row = $result->fetch_assoc();
    $number = ($row['ustatus'] == 0) ? 1 : 0;


	$sql = "update user set ustatus=".$number." where uid=$uid";
	$conn->query($sql) or die($conn->error);
	$conn->close();
	$_SESSION["users_error"]="Khóa/mở khóa thành công!";
	header("Location:admin.php?manage=users");
?>
