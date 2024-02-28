<nav class="main-menu" >
    <div class="" style="margin-bottom:30px;display:flex">
        <div class="icon-user">
            <i class="fa-solid fa-user fa fa-2x" style="color: #c2c4c7;"></i>
        </div>

        <div class="profile" style="color:white">
            <span>Xin Chào,</span>
            <h5>
                <?php if (isset($_SESSION['adname'])) {
                    if ($_SESSION['adname'])
                        echo $_SESSION['adname'];
                } ?>
            </h5>
        </div>
    </div>
    <ul>
        <li>
            <a href="admin.php?manage=songs">
                <i class="fa fa-music"></i>
                <span class="nav-text">
                    Quản lý bài hát
                </span>
            </a>
        </li>
        
        <li>
            <a href="admin.php?manage=artists">
                <i class="fa-solid fa-user fa"></i>
                <span class="nav-text">
                    Quản lý ca sĩ
                </span>
            </a>
        </li>

        <li>
            <a href="admin.php?manage=users">
                <i class="fa-solid fa-users fa fa-2x"></i>
                <span class="nav-text">
                    Quản lý người dùng
                </span>
            </a>
        </li>

        
    </ul>

    <ul class="logout">
        <li>
            <a onclick="return confirm('Bạn có chắc muốn đăng xuất hay không?')" href="logout.php">
                <i class="fa fa-power-off fa-2x"></i>
                <span class="nav-text">
                    Logout
                </span>
            </a>
        </li>
    </ul>
</nav>