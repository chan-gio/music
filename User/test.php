<script>
    function checkSongInPlaylist(songid, playlistId) {
    var result = false;

    // Sử dụng XMLHttpRequest hoặc Fetch API để gửi yêu cầu AJAX
    var xhr = new XMLHttpRequest();
    xhr.open('GET', './actions/check_duplicate.php?songid=' + songid + '&playlistid=' + playlistId, true);
    xhr.onreadystatechange = function() {
        if (xhr.readyState == 4 && xhr.status == 200) {
            result = xhr.responseText.trim() === 'true';
            console.log(result); // Log giá trị sau khi nhận phản hồi
        }
    };
    xhr.send();
    return result;
}
    checkSongInPlaylist(4,4);
</script>
<body>
    
</body>