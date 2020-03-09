<?php


class ArticleService
{

    public static function get($id) {
        $db = new Database();
        $dbh = $db->connect();
        $sql = "SELECT * FROM articles WHERE id = :id";
        $sth = $dbh->prepare($sql);
        $sth->execute(array(
            ':id' => $id
        ));
        return $sth->fetch();
    }

    public static function getAll() {
        $db = new Database();
        $dbh = $db->connect();
        $sql = "SELECT * FROM articles ORDER BY id DESC";
        $sth = $dbh->prepare($sql);
        $sth->execute();
        return $sth->fetchAll();
    }

    public static function delete($id) {
        $db = new Database();
        $dbh = $db->connect();
        $sql = "DELETE FROM articles WHERE id = :id";
        $sth = $dbh->prepare($sql);
        $sth->execute(array(
            ':id' => $id
        ));
    }

    public static function add($title, $content, $author, $cover) {
        $now = new DateTime();
        $db = new Database();
        $dbh = $db->connect();
        $sql = "INSERT INTO articles(title, content, author, created, cover) VALUES(:title, :content, :author, :created, :cover)";
        $sth = $dbh->prepare($sql);
        $sth->execute(array(
            ':title' => $title,
            ':content' => $content,
            ':author' => $author,
            ':created' => $now->format("Y-m-d H:i:s"),
            ':cover' => $cover
        ));
    }

}
