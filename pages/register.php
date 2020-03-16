<?php

SecurityService::requireAuth(false);

$username = null;
$email = null;

$errors = array();

if (isset($_POST["user_submit"])) {
    $username = $_POST["username"];
    $email = $_POST["email"];
    $password = $_POST["password"];
    $password_verification = $_POST["password_verification"];
    if (!isset($username) || strlen($username) <= 0) {
        array_push($errors, array("Username cannot be empty!"));
    } if (!isset($email) || strlen($email) <= 0) {
        array_push($errors, array("Email cannot be empty!"));
    } if (!isset($password) || strlen($password) <= 0) {
        array_push($errors, array("Password cannot be empty!"));
    } if (!isset($password_verification) || strlen($password_verification) <= 0) {
        array_push($errors, array("Password verification cannot be empty!"));
    } if (isset($password) && isset($password_verification) && strlen($password) <= 0 && strlen($password_verification) <= 0 && $password != $password_verification) {
        array_push($errors, array("Passwords does not match!"));
    }

    if (count($errors) <= 0) {
        UserService::add($username, $email, password_hash($password, PASSWORD_DEFAULT));
        header('Location: /login');
    }
}

require_once(__ROOT__ . "/templates/header.php");
require_once (__ROOT__ . "/templates/nav.php");

?>

<div id="content" class="container">
    <div class="row">
        <div class="twelve columns">
            <form action="" method="post">
                <div class="row">
                    <div class="twelve columns">
                        <input class="u-full-width" type="text" name="username" placeholder="Xx_Sram_xX" value="<?= $username ?>">
                    </div>
                </div>
                <div class="row">
                    <div class="twelve columns">
                        <input class="u-full-width" type="email" name="email" placeholder="Email address" value="<?= $email ?>">
                    </div>
                </div>
                <div class="row">
                    <div class="six columns">
                        <input class="u-full-width" type="password" name="password" placeholder="Password">
                    </div>
                    <div class="six columns">
                        <input class="u-full-width" type="password" name="password_verification" placeholder="Password verification">
                    </div>
                </div>
                <div class="row">
                    <div class="offset-by-three six columns">
                        <input class="u-full-width" type="submit" value="Submit" name="user_submit">
                    </div>
                </div>
                <div class="row">
                    <div class="twelve columns">
                        <ul>
                            <div>
                                <?php
                                foreach ($errors as $error) {
                                    ?>
                                    <li class="error"><?= array_values($error)[0] ?></li>
                                    <?php
                                }
                                ?>
                            </div>
                        </ul>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>

<?php require_once(__ROOT__ . "/templates/footer.php"); ?>
