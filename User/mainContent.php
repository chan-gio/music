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
                echo "<span style='left: 80px; top:-20px; position:relative;'>$sname</span>";
            }
        }
    ?>
    </div>
    </div>
    <div>
    <p style="right: 580px; top:360px; position: relative;" >Popular album</p>
    <div class = "pAlbum">
    
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
                echo "<span style='top: 100px;right: 95px; position:relative;font-size: 15px;font-weight: 400;width:80px;'>$alname</span>";
            }
        }
    ?>

    </div>
    </div>
</div>
<div>
<p style="right:250px; position:relative;top: 10px;">Popular Astist</p>
<div class = "rightContent">
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
                    echo "<span style='top: 70px;right: 130px; position:relative;font-weight:15px;'>$aname</span>";
                }
             }
            ?>
        </div>
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
            width: 129.5px;
            display: flex;
            flex-direction: column;
            align-items: flex-start;
            justify-content: flex-start;
            padding: var(--padding-sm) 0 0;
            box-sizing: border-box;
        }

        .pMusic{
            width: 577px;
            border-radius: var(--br-9xs);
            background-color: #E6E6E6;
            flex-direction: column;
            padding: var(--padding-5xs) var(--padding-5xl);
            gap: 0 65.5px;

        }
        .pAlbum{
            width: 480px;
            height: 295px;
            background-color: #E6E6E6;
            display: flex;
            padding: 20px;
            gap: 12px 0;
            border-radius: 16px;
            flex-direction: row;
            align-items: center;
            justify-content: center;
            box-sizing: border-box;
            isolation: isolate;


        
        }
        .rightContent2{
            
        display: flex;
        flex-direction: row;
        flex-wrap: wrap;
        align-items: center;
        justify-content: space-between;
        align-content: space-between;
        gap: 16px;

        width: 460px;
        height: 252px;

        flex: none;
        order: 1;
        align-self: stretch;
        flex-grow: 0;

        font-family: 'Inter';
        font-style: normal;
        font-weight: 400;
        font-size: 16px;
        line-height: 14px;    
        margin-bottom: 20px;
        

        }
        .pAlbum img{
            position: relative;
            left: 20px;
            top: -40px;
            display: flex;
            flex-wrap: wrap;
            flex-direction: row;
            justify-content: flex-start;
            align-items: flex-start;
            padding: 0px;
            gap: 10px;
            width:180px;
            height: 120px;
            order: 0;
            flex-grow: 2;

        }

       .pMusic img{
            display: flex;
            flex-wrap: wrap;
            flex-direction: row;
            justify-content: flex-start;
            align-items: flex-start;
            padding: 0px;
            gap: 10px;
            width: 45px;
            height: 45px;
            position: relative;
            top: 10px;
            left:10px;
            order: 0;
            flex-grow: 2;
       }
        
        .rightContent2 img {

            display: flex;
            flex-wrap: wrap;
            flex-direction: row;
            justify-content: flex-start;
            align-items: flex-start;
            padding: 0px;
            gap: 10px;
            width: 100px;
            height: 100px;
            border-radius: 10px;
            order: 0;
            flex-grow: 2;

        }
        
        .rightContent {
            
            right:250px ;
            position: relative;
            top: 20px;
        }
        .pAlbum {
            
            right: 570px;
            top:380px;
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