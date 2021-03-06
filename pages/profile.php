<?php

SecurityService::requireAuth(true);

$user = SecurityService::getLogged();

$username = null;

$errors_0 = array();
$errors_1 = array();
$success_0 = array();
$success_1 = array();

if (isset($_POST["profile_submit"])) {
    $username = $_POST["username"];

    if (!isset($username) || strlen($username) <= 0) {
        array_push($errors_0, array("Username cannot be empty!"));
    } elseif ($username == $user->getUsername()) {
        array_push($errors_0, array("Username cannot be the same!"));
    }

    if (count($errors_0) <= 0) {
        $user->setUsername($username);
        UserService::update($user);
        array_push($success_0, array("Username successfully updated!"));
    }
} elseif (isset($_POST["password_submit"])) {
    $password = $_POST["password"];
    $password_verification = $_POST["password_verification"];

    if (!isset($password) || strlen($password) <= 0) {
        array_push($errors_1, array("Password cannot be empty!"));
    } if (!isset($password_verification) || strlen($password_verification) <= 0) {
        array_push($errors_1, array("Password verification cannot be empty!"));
    } if ($password != $password_verification) {
        array_push($errors_1, array("Passwords does not match!"));
    }

    if (count($errors_1) <= 0) {
        $user->setPassword($password);
        UserService::update($user);
        array_push($success_1, array("Password successfully updated!"));
    }
} elseif (isset($_POST["update_submit"])) {
    $userID = $_POST["user_id"];
    $rankID = $_POST["rank_id"];

    $user = UserService::get($userID);
    $user->setRank(RankService::get($rankID));
    UserService::update($user);
    UserService::updateRank($userID, $rankID);
} elseif (isset($_POST["delete_submit"])) {
    $userID = $_POST["user_id"];

    UserService::delete($userID);
}

$user = SecurityService::getLogged();

?>

<div id="content" class="container">
    <div class="row">
        <div class="twelve columns">
            <h3 class="text-center no-margin-bottom">My profile - <?= $user->getRank()->getLabel() ?></h3>
            <div class="text-center registered">Registered: <?= $user->getCreated() ?></div>
        </div>
    </div>
    <div class="row">
        <div class="twelve columns form-profile">
            <form action="" method="post">
                <div class="six columns">
                    <label for="email">Your email</label>
                    <input disabled class="u-full-width input-disabled" id="email" type="email" name="email"
                           placeholder="Email address" value="<?= $user->getEmail() ?>">
                </div>
                <div class="six columns">
                    <label for="email">Your username</label>
                    <input class="u-full-width" id="username" type="text" name="username" placeholder="Username"
                           value="<?= $user->getUsername() ?>">
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
                $ranks = RankService::getAll();
                ?>
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
                                    <input type="hidden" name="user_id" value="<?= $u->getId() ?>">
                                    <td><?= $u->getId() ?></td>
                                    <td><?= $u->getUsername() ?></td>
                                    <td><?= $u->getEmail() ?></td>
                                    <td>
                                        <select name="rank_id">
                                            <?php
                                            foreach ($ranks as $rank) {
                                                ?>
                                                <option
                                                    value="<?= $rank->getId() ?>" <?= $u->getRank()->getId() == $rank->getId() ? 'selected' : '' ?>><?= $rank->getLabel() ?></option>
                                                <?php
                                            }
                                            ?>
                                        </select>
                                    </td>
                                    <td><?= $u->getCreated() ?></td>
                                    <td><input class="u-full-width" type="submit" value="Update" name="update_submit"></td>
                                    <td><input <?= $u->getId() == $user->getId() ? 'disabled' : '' ?> class="u-full-width <?= $u->getId() == $user->getId() ? 'input-disabled' : '' ?>" type="submit" value="Delete" name="delete_submit"></td>
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
</div>
