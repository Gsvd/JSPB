<?php

Utilities::requireAuth(true);

$user = Utilities::getLoggedUser();

$username = null;

$errors_0 = array();
$errors_1 = array();
$success_0 = array();
$success_1 = array();

if (isset($_POST["profile_submit"])) {
    $username = $_POST["username"];

    if (!isset($username) || strlen($username) <= 0) {
        array_push($errors_0, array("username" => "Username cannot be empty!"));
    } elseif ($username == $user["username"]) {
        array_push($errors_0, array("username" => "Username cannot be the same!"));
    }

    if (count($errors_0) <= 0) {
        Utilities::updateUsername($user["id"], $username);
        $user = Utilities::getLoggedUser();
        array_push($success_0, array("username" => "Username successfully updated!"));
    }
} elseif (isset($_POST["password_submit"])) {
    $password = $_POST["password"];
    $password_verification = $_POST["password_verification"];

    if (!isset($password) || strlen($password) <= 0) {
        array_push($errors_1, array("password" => "Password cannot be empty!"));
    } if (!isset($password_verification) || strlen($password_verification) <= 0) {
        array_push($errors_1, array("password_verification" => "Password verification cannot be empty!"));
    } if (isset($password) && isset($password_verification) && strlen($password) <= 0 && strlen($password_verification) <= 0 && $password != $password_verification || $password != $password_verification) {
        array_push($errors_1, array("passwords_match" => "Passwords does not match!"));
    }

    if (count($errors_1) <= 0) {
        Utilities::updatePassword($user["id"], password_hash($password, PASSWORD_DEFAULT));
        array_push($success_1, array("password" => "Password successfully updated!"));
    }
}

?>

<div id="content" class="container">
    <div class="row">
        <div class="twelve columns">
            <h3 class="text-center no-margin-bottom">My profile</h3>
            <div class="text-center registered">Registered: <?= $user["created"] ?></div>
        </div>
    </div>
    <div class="row">
        <div class="twelve columns form-profile">
            <form action="" method="post">
                <div class="six columns">
                    <label for="email">Your email</label>
                    <input disabled class="u-full-width input-disabled" id="email" type="email" name="email" placeholder="Email address" value="<?= $user['email'] ?>">
                </div>
                <div class="six columns">
                    <label for="email">Your username</label>
                    <input class="u-full-width" id="username" type="text" name="username" placeholder="Username" value="<?= $user['username'] ?>">
                </div>
                <div class="row">
                    <div class="offset-by-three six columns">
                        <input class="u-full-width" type="submit" value="Update" name="profile_submit">
                    </div>
                </div>
                <div class="row">
                    <div class="twelve columns">
                        <ul>
                            <div>
                                <?php
                                foreach ($errors_0 as $error) {
                                    ?>
                                    <li class="error"><?= array_values($error)[0] ?></li>
                                    <?php
                                }
                                ?>
                            </div>
                            <div>
                                <?php
                                foreach ($success_0 as $success) {
                                    ?>
                                    <li class="success"><?= array_values($success)[0] ?></li>
                                    <?php
                                }
                                ?>
                            </div>
                        </ul>
                    </div>
                </div>
            </form>
            <div class="twelve columns separator"></div>
            <form action="" method="post">
                <div class="six columns">
                    <label for="password">Password</label>
                    <input class="u-full-width" id="password" type="password" name="password" placeholder="Password">
                </div>
                <div class="six columns">
                    <label for="password_verification">Password verification</label>
                    <input class="u-full-width" id="password_verification" type="password" name="password_verification" placeholder="Password verification">
                </div>
                <div class="row">
                    <div class="offset-by-three six columns">
                        <input class="u-full-width" type="submit" value="Update" name="password_submit">
                    </div>
                </div>
                <div class="row">
                    <div class="twelve columns">
                        <ul>
                            <div>
                                <?php
                                foreach ($errors_1 as $error) {
                                    ?>
                                    <li class="error"><?= array_values($error)[0] ?></li>
                                    <?php
                                }
                                ?>
                            </div>
                            <div>
                                <?php
                                foreach ($success_1 as $success) {
                                    ?>
                                    <li class="success"><?= array_values($success)[0] ?></li>
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
