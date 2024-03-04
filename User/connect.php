<?php 
$servername="localhost";
$username="root";
$password="123456789";
$port="3306";
$database="music_web";
$conn = new mysqli($servername,$username,$password,$database,$port);
if ($conn->connect_error){
	die("Lỗi kết nối với CSDL");
}
?>