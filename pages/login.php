<?php

SecurityService::requireAuth(false);

$email = null;

$errors = array();

if (isset($_POST["login_submit"])) {
    $email = $_POST["email"];
    $password = $_POST["password"];

    if (!isset($email) || strlen($email) <= 0) {
        array_push($errors, array("Email cannot be empty!"));
    } if (!isset($password) || strlen($password) <= 0) {
        array_push($errors, array("Password cannot be empty!"));
    }

    if (count($errors) <= 0) {
        if (!SecurityService::login($email, $password)) {
            array_push($errors, array("User or password incorrect!"));
        } else {
            header('Location: /');
        }
    }
}

?>

<div id="content" class="container">
    <div class="row">
        <div class="twelve columns">
            <form action="" method="post">
                <div class="row">
                    <div class="twelve columns">
                        <input class="u-full-width" type="email" name="email" placeholder="Email address" value="<?= $email ?>">
                    </div>
                </div>
                <div class="row">
                    <div class="twelve columns">
                        <input class="u-full-width" type="password" name="password" placeholder="********">
                    </div>
                </div>
                <div class="row">
                    <div class="offset-by-three six columns">
                        <input class="u-full-width" type="submit" value="Submit" name="login_submit">
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
