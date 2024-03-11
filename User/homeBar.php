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

    <!-- <div class="has-subnav">
        <a href="index.php?sort=premiumContent">
            <div class="HOME">
                <img src="../images/logo/Vector3.png">
                <span class="nav-text">
                    Premium Content

                    </span>
                </div>
            </a><br>

    </div> -->

    <div class="has-subnav">
        <a href="index.php?sort=avatar">
            <div class="Avatar" style="display: flex;flex-direction: row;justify-content: space-between;align-items: center;padding: 16px 24px;gap: 16px;width: 275px;height: 50px;background: #B6B5E3;border-radius: 12px;flex: none;order: 1;align-self: stretch;flex-grow: 0;top: 340px;right: 5px; position:relative;">
                <img src="../images/logo/Avatar.png">
                <span class="nav-text" style=" right: 100px";>
                    <?php echo $uname ?>
                </span>
            </div>
        </a><br>

    </div>
    
    <style>
        .HOME {
    cursor: pointer;
}
    .nav-text{
        position: relative;
        font-size: var(--font-size-xs);
        line-height: 18px;
        font-family: var(--font-roboto);
        color: #000;
        text-align: center;
        cursor: pointer;
    }

    .HOME.selected {
        background-color: #3498db; 
        color: #fff; 
    }
         a {
            text-decoration: none;
        }

        a:hover {
            text-decoration: underline;
        }
            .homeBar {
                height: 790px;
                border-radius:10px;
                box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            }
            .HOME:focus{
                 background-color: #EEEEEE;
            }
            
    </style>
    <script>
        function selectNavItem(element) {
    // Remove the 'selected' class from all nav items
    var navItems = document.querySelectorAll('.nav-link');
    navItems.forEach(item => item.classList.remove('selected'));

    // Add the 'selected' class to the clicked nav item
    element.classList.add('selected');
}
    </script>
</div>
