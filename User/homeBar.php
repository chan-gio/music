<div class="homeBar">
    <link rel="stylesheet" type="text/css" href="style.css">
    <?php
    $imageUrl = "../images/logo/logo.png"; 
    ?>

    <img src="<?php echo $imageUrl; ?>" alt="Your Image">

    <a href="index.php?sort=">
        <div class="HOME">
            <img src="../images/logo/Vector.png">
            <span class="nav-text">
                Home
            </span>
        </div><br>
    </a>
    <a href="index.php?sort=search">
        <div class="HOME">
            <img src="../images/logo/Shape.png">
            <span class="nav-text">
                Search
            </span>
        </div><br>
    </a>

    <a href="index.php?sort=playList">
        <div class="HOME">
            <img src="../images/logo/Vector1.png">
            <span class="nav-text">
                Playlist
            </span>
        </div>
    </a><br>

    <div class="has-subnav">
        <a href="index.php?sort=notification">
            <div class="HOME">
                <img src="../images/logo/Vector2.png">
                <span class="nav-text">
                    Notification
                </span>
            </div>
        </a><br>

    </div>

    <div class="has-subnav">
        <a href="index.php?sort=premiumContent">
            <div class="HOME">
                <img src="../images/logo/Vector3.png">
                <span class="nav-text">
                    Premium Content

                    </span>
                </div>
            </a><br>

    </div>

    <div class="has-subnav">
        <a href="index.php?sort=avatar">
            <div class="Avatar" style="display: flex;flex-direction: row;justify-content: space-between;align-items: center;padding: 16px 24px;gap: 16px;width: 275px;height: 50px;background: #B6B5E3;border-radius: 12px;flex: none;order: 1;align-self: stretch;flex-grow: 0;top: 100px;right: 5px; position:relative;">
                <img src="../images/logo/Avatar.png">
                <span class="nav-text" style="width: 770px;height: 18px;font-family: 'Roboto';font-style: normal;font-weight: 400;font-size: 16px;line-height: 18px;color: #000000;flex: none;order: 1;flex-grow: 0;">

                    <?php echo $uname ?>
                </span>
            </div>
        </a><br>

    </div>
    <style>
         a {
            text-decoration: none;
        }

        a:hover {
            text-decoration: underline;
        }
            .homeBar {
                border-radius:10px;
                box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            }
            .HOME:focus{
                 background-color: #EEEEEE;
            }
    </style>

</div>
