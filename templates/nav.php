<div id="nav" class="twelve columns">
    <ul>
        <li><a href="/">Home</a></li>
        <li><a href="/about">About</a></li>
        <?php
        if (isset($_SESSION["username"])) {
        ?>
            <li><a href="/write">Write</a></li>
            <li><a href="/profile"><?= $_SESSION["username"] ?></a></li>
            <li><a href="/logout">Logout</a></li>
        <?php
        } else {
        ?>
            <li><a href="/login">Login</a></li>
            <li><a href="/register">Register</a></li>
        <?php
        }
        ?>
    </ul>
</div>
