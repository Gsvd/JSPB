<div id="nav" class="twelve columns">
    <ul>
        <li><a href="/">Home</a></li>
        <li><a href="/about.php">About</a></li>
        <?php
        if (isset($_SESSION["username"])) {
        ?>
            <li><a href="/write.php">Write</a></li>
            <li><a href="/profile.php"><?= $_SESSION["username"] ?></a></li>
            <li><a href="/logout.php">Logout</a></li>
        <?php
        } else {
        ?>
            <li><a href="/login.php">Login</a></li>
            <li><a href="/register.php">Register</a></li>
        <?php
        }
        ?>
    </ul>
</div>
