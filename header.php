

<header>
    <ul>
        <li><a class="logo" href="index.php?page=1">CAMAGRU</a></li>
        <?php
        if (!isset($_SESSION['pseudo'])) { ?>
            <li><a class='nav' href='index.php?page=1'>Galerie</a></li>
            <li style="float:right; border-left:1px solid #bbb;" class="copy"><a class='nav' href='inscription.php' >Signup</a></li>
            <li style="float:right; border-left:1px solid #bbb;"><a class='nav' href='login.php' >Login</a></li>
        <?php }
        else { ?>
            <li><a class='nav' href='index.php?page=1'>Galerie</a></li>
            <li><a class='nav' href='cam.php'>Snapshot</a></li>
            <li style="float:right"><a class='nav' href='logout.php'>Logout <?php echo "   " . htmlspecialchars($_SESSION['pseudo']); ?></a></li>
        <?php } ?>
    </ul>
</header>
