<!-- HTML -->
<input class="searchBar" type="search" placeholder="Search" aria-label="Search" onkeyup="search(this.value)">
<div id="songResults" style="display:none">
    <h2>Songs</h2>
    <div id="songListResults" class="resultList"></div>
</div>
<div id="albumResults" style="display:none">
    <h2>Albums</h2>
    <div id="albumListResults" class="resultList"></div>
</div>
<div id="podcastResults" style="display:none">
    <h2>Podcasts</h2>
    <div id="podcastListResults" class="resultList"></div>
</div>
<div id="artistResults" style="display:none">
    <h2>Artists</h2>
    <div id="artistListResults" class="resultList"></div>
</div>

<!-- JavaScript -->
<script>

function search(query) {
    // Kiểm tra nếu ô tìm kiếm rỗng thì ẩn tất cả kết quả
    if (query.trim() === "") {
        document.getElementById("songResults").style.display = "none";
        document.getElementById("albumResults").style.display = "none";
        document.getElementById("podcastResults").style.display = "none";
        document.getElementById("artistResults").style.display = "none";
        return;
    }
    
   
    var xhttp = new XMLHttpRequest();
    xhttp.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
            // Xử lý dữ liệu trả về từ PHP
            var songListResults = document.getElementById("songListResults");
            var albumListResults = document.getElementById("albumListResults");
            var podcastListResults = document.getElementById("podcastListResults");
            var artistListResults = document.getElementById("artistListResults");
            songListResults.innerHTML = ""; 
            albumListResults.innerHTML = "";
            podcastListResults.innerHTML = ""; 
            artistListResults.innerHTML = "";
            // Hiển thị kết quả trả về ra màn hình
            var responseData = JSON.parse(this.responseText);
            if (responseData.length > 0) {
                // Xử lý hiển thị kết quả khi có dữ liệu
                for (var i = 0; i < responseData.length; i++) {
                    var result = responseData[i];
                    var resultElement = document.createElement("div");
                    resultElement.classList.add("resultItem");
                    
                    // Tạo và thêm thông tin vào danh sách phù hợp
                    switch (result.type) {
                        case 'song':
                            document.getElementById("songResults").style.display = "block";
                            var imageElement = document.createElement("img");
                            imageElement.src = "../images/" + result.image;
                            imageElement.alt = result.name;
                            resultElement.appendChild(imageElement);

                            var songItem = document.createElement("span");
                            songItem.textContent = result.name + " by: " + result.artist;
                            resultElement.appendChild(songItem);

                            // Thêm sự kiện click để điều hướng người dùng đến trang chi tiết bài hát
                            resultElement.addEventListener('click', function() {
                                window.location.href = "index.php?sort=song_detail&id=" + result.id;
                            });

                            songListResults.appendChild(resultElement);
                            break;

                        case 'album':
                            document.getElementById("albumResults").style.display = "block";
                            var imageElement = document.createElement("img");
                            imageElement.src = "../albums/" + result.image;
                            imageElement.alt = result.name;
                            resultElement.appendChild(imageElement);

                            var albumItem = document.createElement("span");
                            albumItem.textContent = result.name + " by: " + result.artist;
                            resultElement.appendChild(albumItem);

                            // Thêm sự kiện click để điều hướng người dùng đến trang chi tiết album
                            resultElement.addEventListener('click', function() {
                                window.location.href = "index.php?sort=album_detail&id=" + result.id;
                            });

                            albumListResults.appendChild(resultElement);
                            break;

                        case 'podcast':
                            document.getElementById("podcastResults").style.display = "block";
                            var imageElement = document.createElement("img");
                            imageElement.src = "../podcasts/" + result.image;
                            imageElement.alt = result.name;
                            resultElement.appendChild(imageElement);

                            var podcastItem = document.createElement("span");
                            podcastItem.textContent = result.name + " by: " + result.artist;
                            resultElement.appendChild(podcastItem);

                            // Thêm sự kiện click để điều hướng người dùng đến trang chi tiết podcast
                            resultElement.addEventListener('click', function() {
                                window.location.href = "index.php?sort=podcast_detail&id=" + result.id;
                            });

                            podcastListResults.appendChild(resultElement);
                            break;

                        case 'artist':
                            document.getElementById("artistResults").style.display = "block";
                            var imageElement = document.createElement("img");
                            imageElement.src = "../artists/" + result.image;
                            imageElement.alt = result.name;
                            resultElement.appendChild(imageElement);

                            var artistItem = document.createElement("span");
                            artistItem.textContent = result.name;
                            resultElement.appendChild(artistItem);

                            // Thêm sự kiện click để điều hướng người dùng đến trang chi tiết nghệ sĩ
                            resultElement.addEventListener('click', function() {
                                window.location.href = "index.php?sort=artist_detail&id=" + result.id;
                            });

                            artistListResults.appendChild(resultElement);
                            break;

                        default:
                            break;
                    }
                }
            } else {
            }
        }
    };
    xhttp.open("GET", "search.php?q=" + query, true);
    xhttp.send();
}
</script>
