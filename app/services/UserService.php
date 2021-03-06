<?php


class UserService
{

    public static function add($username, $email, $password) {
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

    public static function update(User $user) {
        $db = new Database();
        $dbh = $db->connect();
        $sql = "UPDATE users SET username = :username, password = :password, email = :email, rank = :rank WHERE id = :id";
        $sth = $dbh->prepare($sql);
        $sth->execute(array(
            ':username' => $user->getUsername(),
            ':password' => $user->getPassword(),
            ':email' => $user->getEmail(),
            ':rank' => $user->getRank()->getId(),
            ':id' => $user->getId()
        ));
    }

    public static function get($id) {
        $db = new Database();
        $dbh = $db->connect();
        $sql = "
        SELECT u.id,
               u.email,
               u.username,
               u.created,
               r.id AS 'rank',
               r.label,
               r.code
        FROM users AS u INNER JOIN ranks AS r
        ON u.rank = r.id
        WHERE u.id = :id
        ";
        $sth = $dbh->prepare($sql);
        $sth->execute(array(
            ':id' => $id
        ));
        $row = $sth->fetch();
        $user = new User($row['id'], $row['username'], $row['email'], $row['created'], new Rank($row['rank'], $row['label'], $row['code']));
        return $user;
    }

    public static function delete($id) {
        $db = new Database();
        $dbh = $db->connect();
        $sql = "DELETE FROM users WHERE id = :id";
        $sth = $dbh->prepare($sql);
        $sth->execute(array(
            ':id' => $id
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

    public static function updateRank($id, $rank) {
        $db = new Database();
        $dbh = $db->connect();
        $sql = "UPDATE users SET rank = :rank WHERE id = :id";
        $sth = $dbh->prepare($sql);
        $sth->execute(array(
            ':rank' => $rank,
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

    public static function getAll() {
        $db = new Database();
        $dbh = $db->connect();
        $sql = "
        SELECT u.id,
               u.email,
               u.username,
               u.password,
               u.created,
               r.id AS 'rank',
               r.label,
               r.code
        FROM users AS u INNER JOIN ranks AS r
        ON u.rank = r.id
        ";
        $sth = $dbh->prepare($sql);
        $sth->execute();
        $rows = $sth->fetchAll();
        $users = array();
        foreach ($rows as $row) {
            $user = new User($row['id'], $row['username'], $row['email'], $row['created'], new Rank($row['rank'], $row['label'], $row['code']));
            array_push($users, $user);
        }
        return $users;
    }

}
