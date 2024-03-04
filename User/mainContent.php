<div class ="mainContent">
    <div class ="pMusic">
    <p>Popular music</p>
    <?php
        $sql6 = "SELECT a.*, GROUP_CONCAT(c.aname)
                    FROM songs a
                    JOIN songs_artists b ON a.sid = b.sid
                    JOIN artists c ON c.aid = b.aid
                    GROUP BY a.sid, a.sname
                    ORDER BY a.sview DESC
                    LIMIT 0,10;";
        $result6 = $conn->query($sql6);

        if ($result6->num_rows > 0) {
            while($row6 = $result6->fetch_assoc()) {
                $sid = $row6["sid"];
                $sname = $row6["sname"];
                $simage = "images/" . $row6["simage"];
                echo "<a href='index.php?sort=song_detail&id=$sid'><img src='$simage' alt='$sname'></a>";
                echo $sname;
            }
        }
    ?>
    </div>
    <div class = "pAlbum">
    <p>Popular album</p>
    <?php
        $sql5 = "SELECT a.*, GROUP_CONCAT(c.aname), SUM(a.alview) AS total_views 
                FROM albums a
                JOIN albums_songs d ON a.alid = d.alid
                JOIN songs e ON e.sid = d.sid
                JOIN songs_artists b ON e.sid = b.sid
                JOIN artists c ON c.aid = b.aid
                GROUP BY a.alid, a.alname
                ORDER BY total_views DESC 
                LIMIT 0,10;";
        $result5 = $conn->query($sql5);

        if ($result5->num_rows > 0) {
            while($row5 = $result5->fetch_assoc()) {
                $alid = $row5["alid"];
                $alname = $row5["alname"];
                $alimage = "albums/" . $row5["alimage"];
                echo "<a href='index.php?sort=album_detail&id=$alid'><img src='$alimage' alt='$alname'></a>";
                echo $alname;
            }
        }
    ?>

    </div>
</div>
<div class = "rightContent">
        <div>
            <p>Popular Astist</p>
            <?php
             $sql1 = "SELECT * FROM artists
                    ORDER BY aview DESC LIMIT 0,10";
             $result1 = $conn->query($sql1);

             if ($result1->num_rows > 0) {
                while($row1 = $result1->fetch_assoc()) {
                    $aname = $row1["aname"];
                    $aid = $row1["aid"];
                    $aimage = "artists/".$row1["aimage"];
                    echo "<a href='index.php?sort=artist_detail&id=$aid'><img src='$aimage' alt='$aname'></a>";
                    echo $aname;
                }
             }
            ?>
        </div>

        <!-- <div>
            <p>Top Podcasts</p>
            <?php
                // $sql2 = "SELECT * FROM podcasts
                //         ORDER BY poview DESC LIMIT 0,10";
                // $result2 = $conn->query($sql2);

                // if ($result2->num_rows > 0) {
                //     while($row2 = $result2->fetch_assoc()) {
                //         $poid = $row2["poid"];
                //         $poname = $row2["poname"];
                //         $poimage = "podcasts/".$row2["poimage"];
                //         echo "<a href='index.php?sort=podcast_detail&id=$poid'><img src='$poimage' alt='$poname'></a>";
                //         echo $poname;
                //     }
                // }
                ?>
        </div> -->
        </div>
    </div>  