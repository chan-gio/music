<script>
function playCurrentSong() {
    var currentSong = songs[currentSongIndex];
    if (currentSong && currentSong.url) {
        audioPlayer.src = currentSong.url;
        audioPlayer.play();

        var currentSongTitle = document.getElementById('currentSongTitle');
        var currentSongAuthor = document.getElementById('currentSongAuthor');
        var currentSongImage = document.getElementById('currentSongImage');

        currentSongTitle.innerText = "Bài hát: " + currentSong.title;
        currentSongAuthor.innerText = "Tác giả: " + currentSong.author;
        currentSongImage.src = currentSong.image;
    } else {
        console.error("Current song or its URL is undefined.");
    }
}

</script>