<?php
session_start();

// Kiểm tra nếu có dữ liệu được gửi từ form POST
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $alid = $_GET["alid"];
    $flag = $_GET["flag"];
    if($flag == "trashcan"){
        $location = "Location:../index.php?manage=Album_trashcan";
    }
    else if($flag == "album"){
        $location = "Location:../index.php?manage=Album";
    }
    else {
        $location = "Location:../index.php?manage=Album";
    }
    // Kết nối đến CSDL
    include("../connect.php");

    // Câu lệnh SQL để xóa hết bản ghi trong bảng albums_songs với điều kiện alid
    $sqlDelete = "DELETE FROM albums_songs WHERE alid = $alid";

    if ($conn->query($sqlDelete) === TRUE) {
        // Kiểm tra xem có ít nhất một bài hát đã được chọn hay không
        if (isset($_POST['selectedSongs']) && !empty($_POST['selectedSongs'])) {
            $selectedSongs = explode(',', $_POST['selectedSongs']);
            // Duyệt qua mảng $selectedSongs và thực hiện câu lệnh INSERT
            foreach ($selectedSongs as $sid) {
                $sid = (int)$sid; // Chắc chắn rằng $sid là một số nguyên
                $sqlInsert = "INSERT INTO albums_songs (alid, sid) VALUES ($alid, $sid)";

                if ($conn->query($sqlInsert) !== TRUE) {
                    // Xử lý khi có lỗi trong quá trình thêm bản ghi mới
                    $_SESSION["song_in_album_edit_error"] = $conn->error;
                    header($location);
                    exit();
                }
            }
        }
        $_SESSION["song_in_album_edit_error"] = "Chỉnh sửa bài hát trong album thành công!";
        header($location);
        exit();
    } else {
        $_SESSION["song_in_album_edit_error"] = $conn->error;
    }
}
