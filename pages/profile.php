<?php

SecurityService::requireAuth(true);

$user = SecurityService::getLogged();

$username = null;

$errors_0 = array();
$errors_1 = array();
$errors_2 = array();
$success_0 = array();
$success_1 = array();
$success_2 = array();

if (isset($_POST["profile_submit"])) {
    $username = $_POST["username"];

    if (!isset($username) || strlen($username) <= 0) {
        array_push($errors_0, array("username" => "Username cannot be empty!"));
    } elseif ($username == $user["username"]) {
        array_push($errors_0, array("username" => "Username cannot be the same!"));
    }

    if (count($errors_0) <= 0) {
        UserService::updateUsername($user["id"], $username);
        $user = SecurityService::getLogged();
        array_push($success_0, array("username" => "Username successfully updated!"));
    }
} elseif (isset($_POST["password_submit"])) {
    $password = $_POST["password"];
    $password_verification = $_POST["password_verification"];

    if (!isset($password) || strlen($password) <= 0) {
        array_push($errors_1, array("password" => "Password cannot be empty!"));
    } if (!isset($password_verification) || strlen($password_verification) <= 0) {
        array_push($errors_1, array("password_verification" => "Password verification cannot be empty!"));
    } if ($password != $password_verification) {
        array_push($errors_1, array("passwords_match" => "Passwords does not match!"));
    }

    if (count($errors_1) <= 0) {
        UserService::updatePassword($user["id"], password_hash($password, PASSWORD_DEFAULT));
        array_push($success_1, array("password" => "Password successfully updated!"));
    }
} elseif (isset($_POST["update_submit"])) {
    $userID = $_POST["user_id"];
    $rankID = $_POST["rank_id"];

    UserService::updateRank($userID, $rankID);
} elseif (isset($_POST["delete_submit"])) {
    $userID = $_POST["user_id"];

    UserService::delete($userID);
} elseif (isset($_POST["about_submit"])) {
    $aboutContent = $_POST["about_content"];

    if (!isset($aboutContent) || strlen($aboutContent) <= 0) {
        array_push($errors_2, array("about" => "About content cannot be empty!"));
    }

    if (count($errors_2) <= 0) {
        PagesService::updateContent(PagesEnum::ABOUT, $aboutContent);
        array_push($success_2, array("about" => "About content successfully updated!"));
    }
}

?>

<div id="content" class="container">
    <div class="row">
        <div class="twelve columns">
            <h3 class="text-center no-margin-bottom">My profile - <?= $user["label"] ?></h3>
            <div class="text-center registered">Registered: <?= $user["created"] ?></div>
        </div>
    </div>
    <div class="row">
        <div class="twelve columns form-profile">
            <form action="" method="post">
                <div class="six columns">
                    <label for="email">Your email</label>
                    <input disabled class="u-full-width input-disabled" id="email" type="email" name="email"
                           placeholder="Email address" value="<?= $user['email'] ?>">
                </div>
                <div class="six columns">
                    <label for="email">Your username</label>
                    <input class="u-full-width" id="username" type="text" name="username" placeholder="Username"
                           value="<?= $user['username'] ?>">
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
                    <input class="u-full-width" id="password_verification" type="password" name="password_verification"
                           placeholder="Password verification">
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
            <?php
            if (SecurityService::requiredRank(RanksEnum::ADMIN)) {
                $users = UserService::getAll();
                $ranks = UserService::getRanks();
                $about = PagesService::get(PagesEnum::ABOUT);
                ?>
                <div class="twelve columns separator"></div>
                <div class="twelve columns">
                    <form action="" method="post">
                        <div class="twelve columns">
                            <label for="about_content">About content</label>
                            <textarea class="u-full-width" name="about_content" id="about_content" cols="30" rows="10" placeholder="Write your about page content."><?= $about["content"] ?></textarea>
                        </div>
                        <div class="twelve columns">
                            <div class="six columns offset-by-three">
                                <input class="u-full-width space-top" name="about_submit" type="submit" value="Update">
                            </div>
                        </div>
                    </form>
                    <div class="twelve columns">
                        <ul>
                            <div>
                                <?php
                                foreach ($errors_2 as $error) {
                                    ?>
                                    <li class="error"><?= array_values($error)[0] ?></li>
                                    <?php
                                }
                                ?>
                            </div>
                            <div>
                                <?php
                                foreach ($success_2 as $success) {
                                    ?>
                                    <li class="success"><?= array_values($success)[0] ?></li>
                                    <?php
                                }
                                ?>
                            </div>
                        </ul>
                    </div>
                </div>
                <div class="twelve columns separator"></div>
                <div class="twelve columns">
                    <table class="u-full-width">
                        <thead>
                        <tr>
                            <th>#</th>
                            <th>Username</th>
                            <th>Email</th>
                            <th>Rank</th>
                            <th>Created</th>
                            <th></th>
                            <th></th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php
                        foreach ($users as $u) {
                            ?>
                            <tr>
                                <form action="" method="post">
                                    <input type="hidden" name="user_id" value="<?= $u['id'] ?>">
                                    <td><?= $u["id"] ?></td>
                                    <td><?= $u["username"] ?></td>
                                    <td><?= $u["email"] ?></td>
                                    <td>
                                        <select name="rank_id">
                                            <?php
                                            foreach ($ranks as $rank) {
                                                ?>
                                                <option
                                                    value="<?= $rank['id'] ?>" <?= $u["rank"] == $rank["id"] ? 'selected' : '' ?>><?= $rank["label"] ?></option>
                                                <?php
                                            }
                                            ?>
                                        </select>
                                    </td>
                                    <td><?= $u["created"] ?></td>
                                    <td><input class="u-full-width" type="submit" value="Update" name="update_submit"></td>
                                    <td><input <?= $u["id"] == $user["id"] ? 'disabled' : '' ?> class="u-full-width <?= $u["id"] == $user["id"] ? 'input-disabled' : '' ?>" type="submit" value="Delete" name="delete_submit"></td>
                                </form>
                            </tr>
                            <?php
                        }
                        ?>
                        </tbody>
                    </table>
                </div>
                <?php
            }
            ?>
        </div>
    </div>
    <script>
        CKEDITOR.replace('about_content');
    </script>
</div>
