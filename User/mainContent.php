<div class="mainContent">
    <div>
        <p>Popular music</p>
        <div class="pMusic">
        <?php
        $sql6 = "SELECT * FROM songs
                where sstatus=1
                ORDER BY sview DESC LIMIT 0,10";

        $result6 = $conn->query($sql6);

        if ($result6->num_rows > 0) {
            while($row6 = $result6->fetch_assoc()) {
                $sid = $row6["sid"];
                $sname = $row6["sname"];
                $simage = "../images/" . $row6["simage"];
                echo "<a href='index.php?sort=song_detail&id=$sid'><img src='$simage' alt='$sname'></a>";
                echo $sname;
            }
        }
    ?>
    </div>
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
                where a.alstatus=1
                GROUP BY a.alid, a.alname
                ORDER BY total_views DESC 
                LIMIT 0,10;";
        $result5 = $conn->query($sql5);

        if ($result5->num_rows > 0) {
            while($row5 = $result5->fetch_assoc()) {
                $alid = $row5["alid"];
                $alname = $row5["alname"];
                $alimage = "../albums/" . $row5["alimage"];
                echo "<a href='index.php?sort=album_detail&id=$alid'><img src='$alimage' alt='$alname'></a><br>";
                echo $alname;
            }
        }
    ?>

    </div>
</div>
<div class = "rightContent">
        <p>Popular Astist</p><br>
        <div class="rightContent2">
            
            <?php
             $sql1 = "SELECT * FROM artists
             where astatus=1
                    ORDER BY aview DESC LIMIT 0,10";
             $result1 = $conn->query($sql1);

             if ($result1->num_rows > 0) {
                while($row1 = $result1->fetch_assoc()) {
                    $aname = $row1["aname"];
                    $aid = $row1["aid"];
                    $aimage = "../artists/".$row1["aimage"];
                    echo "<a href='index.php?sort=artist_detail&id=$aid'><img src='$aimage' alt='$aname'></a>";
                    echo $aname;
                }
             }
            ?>
        </div>

        <!-- <div>

        if ($result1->num_rows > 0) {
            while ($row1 = $result1->fetch_assoc()) {
                $aname = $row1["aname"];
                $aid = $row1["aid"];
                $aimage = "../artists/" . $row1["aimage"];
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

        <style>
        

        .mainContent {
            display: flex;
            justify-content: space-between;
            padding: 16px;
        }

        .pMusic{
            

            border:black;
            border-radius: 1px;
            display: flex;
            flex-direction: column;
            align-items: flex-start;
            padding: 0px;
            gap: 8px;

            width: 207px;
            height: 252px;

            font-family: 'Inter';
            font-style: normal;
            font-weight: 400;
            font-size: 13px;
            line-height: 14px;


            letter-spacing: 1px;
            flex: none;
            order: 0;
            flex-grow: 1;
            

        }
        .pAlbum{
            
            display: flex;
            flex-direction: column;
            align-items: flex-start;
            padding: 0px;
            gap: 6px;

            width: 207px;
            height: 336px;

            flex: none;
            order: 2;
            align-self: stretch;
            flex-grow: 0;


        
        }
        .rightContent2{
            
        display: flex;
        flex-direction: row;
        flex-wrap: wrap;
        align-items: flex-start;
        align-content: flex-start;
        padding: 0px;
        gap: 16px;

        width: 416px;
        height: 306px;

        flex: none;
        order: 1;
        align-self: stretch;
        flex-grow: 0;

        font-family: 'Inter';
        font-style: normal;
        font-weight: 400;
        font-size: 13px;
        line-height: 14px;
        letter-spacing: 1px;


        }
       
        .pMusic img,
        .pAlbum img,
        .rightContent2 img {

            display: flex;
            flex-wrap: wrap;
            flex-direction: row;
            justify-content: flex-start;
            align-items: flex-start;
            padding: 0px;
            gap: 10px;
            width: 45px;
            height: 45px;
            
            order: 0;
            flex-grow: 2;

        }
        
        .rightContent {
            
            left: 200px;
            position: relative;
            top: 13px;
            overflow-y: scroll;
            overflow-x: none;
        }
        .pAlbum {
            
            left: 100px;
            top: 0px;
            position: relative;
        }
        p {
            font-size: 1.2em;
            font-weight: bold;
            margin-bottom: 15px;
        }

        a {
            text-decoration: none;
        }

        a:hover {
            text-decoration: underline;
        }
    </style>

    </div>  