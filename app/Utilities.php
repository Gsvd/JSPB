<?php


require_once "Database.php";

class Utilities extends Database
{

    public static function getArticles() {
        $db = new Database();
        $dbh = $db->connect();
        $sql = "SELECT * FROM articles ORDER BY id DESC";
        $sth = $dbh->prepare($sql);
        $sth->execute();
        $articles = $sth->fetchAll();
        return $articles;
    }

    public static function deleteArticle($id) {
        $db = new Database();
        $dbh = $db->connect();
        $sql = "DELETE FROM articles WHERE id = :id";
        $sth = $dbh->prepare($sql);
        $sth->execute(array(
            ':id' => $id
        ));
    }

    public static function addArticle($title, $content, $author) {
        $now = new DateTime();
        $db = new Database();
        $dbh = $db->connect();
        $sql = "INSERT INTO articles(title, content, author, created) VALUES(:title, :content, :author, :created)";
        $sth = $dbh->prepare($sql);
        $sth->execute(array(
            ':title' => $title,
            ':content' => $content,
            ':author' => $author,
            ':created' => $now->format("Y-m-d H:i:s")
        ));
    }

    public static function addUser($username, $email, $password) {
        $now = new DateTime();
        $db = new Database();
        $dbh = $db->connect();
        $sql = "INSERT INTO users(username, password, email, created) VALUES(:username, :password, :email, :created)";
        $sth = $dbh->prepare($sql);
        $sth->execute(array(
            ':username' => $username,
            ':password' => $password,
            ':email' => $email,
            ':created' => $now->format("Y-m-d H:i:s")
        ));
    }

    public static function updateUsername($id, $username) {
        $db = new Database();
        $dbh = $db->connect();
        $sql = "UPDATE users SET username = :username WHERE id = :id";
        $sth = $dbh->prepare($sql);
        $sth->execute(array(
            ':username' => $username,
            ':id' => $id
        ));
    }

    public static function updatePassword($id, $password) {
        $db = new Database();
        $dbh = $db->connect();
        $sql = "UPDATE users SET password = :password WHERE id = :id";
        $sth = $dbh->prepare($sql);
        $sth->execute(array(
            ':password' => $password,
            ':id' => $id
        ));
    }

    public static function getLoggedUser() {
        session_start();
        $email = $_SESSION["email"];
        $db = new Database();
        $dbh = $db->connect();
        $sql = "SELECT * FROM users WHERE email = :email";
        $sth = $dbh->prepare($sql);
        $sth->execute(array(
            'email' => $email
        ));
        return $sth->fetch();
    }

    public static function isLogged() {
        return isset($_SESSION["username"]);
    }

    public static function requireAuth($state) {
        if(Utilities::isLogged() && !$state || !Utilities::isLogged() && $state) {
            header('Location: /errors/403.php');
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
            session_start();
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
        header('Location: /index.php');
    }

}
