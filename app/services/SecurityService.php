<?php

class SecurityService
{

    public static function getLogged() {
        $id = $_SESSION["id"];
        $db = new Database();
        $dbh = $db->connect();
        $sql = "
        SELECT u.id,
               u.email,
               u.username,
               u.password,
               u.created,
               r.id AS rank,
               r.label,
               r.code
        FROM users AS u INNER JOIN ranks AS r
        ON u.rank = r.id
        WHERE u.id = :id;
        ";
        $sth = $dbh->prepare($sql);
        $sth->execute(array(
            'id' => $id
        ));
        return $sth->fetch();
    }

    public static function isLogged() {
        return isset($_SESSION["username"]);
    }

    public static function requireAuth($state) {
        if (SecurityService::isLogged() && !$state || !SecurityService::isLogged() && $state) {
            header('Location: /error/403');
        }
    }

    public static function requiredRank($rank) {
        if (SecurityService::isLogged()) {
            $user = SecurityService::getLogged();
            if ($user["rank"] <= $rank) {
                return true;
            } else {
                return false;
            }
        }
    }

    public static function redirectIfNotAllowed($rank) {
        if (!SecurityService::requiredRank($rank)) {
            header('Location: /error/403');
        }
    }

    public static function login($email, $password) {
        $db = new Database();
        $dbh = $db->connect();
        $sql = "SELECT * FROM users WHERE email = :email";
        $sth = $dbh->prepare($sql);
        $sth->execute(array(
            ':email' => $email
        ));
        $user = $sth->fetch();
        if (password_verify($password, $user['password'])) {
            $_SESSION['id'] = $user['id'];
            $_SESSION['username'] = $user['username'];
            $_SESSION['email'] = $user['email'];
            return true;
        } else {
            return false;
        }
    }

    public static function logout() {
        session_start();
        session_destroy();
        header('Location: /');
    }

    public static function redirectTo($http) {
        header('Location: /error/' . strval($http));
    }

}
