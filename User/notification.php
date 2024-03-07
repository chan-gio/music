<style>
    .notification-container {
        display: inline-block;
        margin: 10px; 
        text-align: center; 
    }

    .notification-container img {
        max-width: 100%; 
        height: auto;
    }
</style>

<?php 
$sql = "SELECT * FROM notify"; 
$result = $conn->query($sql); 

if ($result->num_rows > 0) { 
    echo "<ul class='notification-list'>"; 
    while($row = $result->fetch_assoc()) { 
        $nname = $row["nname"]; 
        $ndesc = $row["ndesc"]; 
        $nlink = $row["nlink"]; 
        $nimage = "../notify/" . $row["nimage"]; 

        echo "<li class='notification-item'>"; 

        echo "<a href='$nlink'><img src='$nimage' alt='$nname'></a>"; 

        echo "<span class='notification-name'>$nname</span>"; 

        echo "<span class='notification-description'>$ndesc</span>"; 

        echo "</li>"; 
    } 
    echo "</ul>"; 
} 
?>

<style>
    .notification-list {
        list-style: none;
        padding: 0;
        margin: 0;
    }

    .notification-item {
        width: 1090px;
        height: 60px;
        display: flex;
        align-items: center;
        border: 1px solid #e1e1e1;
        border-radius: 8px;
        margin-bottom: 15px;
        overflow: hidden;
        transition: background-color 0.3s ease;
    }

    .notification-item:hover {
        background-color: #f5f5f5;
    }

    .notification-item a {
        text-decoration: none;
    }

    .notification-item img {
        width: 60px;
        height: 60px;
        object-fit: cover;
        border-radius: 50%;
        margin-right: 15px;
    }

    .notification-content {
        flex: 1;
    }

    .notification-name {
        font-weight: bold;
        margin-bottom: 5px;
    }

    .notification-description {
        color: #777;
    }

    /* Responsive styles for smaller screens */
    @media (max-width: 768px) {
        .notification-item {
            flex-direction: column;
            align-items: flex-start;
        }

        .notification-item img {
            margin-right: 0;
            margin-bottom: 10px;
        }
    }

</style>




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