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
        $row = $sth->fetch();
        $user = UserService::get($row['author']);
        $article = new Article($row['id'], $row['title'], $row['content'], $user, $row['created'], $row['cover']);
        return $article;
    }

    public static function getAll() {
        $db = new Database();
        $dbh = $db->connect();
        $sql = "SELECT * FROM articles ORDER BY id DESC";
        $sth = $dbh->prepare($sql);
        $sth->execute();
        $rows = $sth->fetchAll();
        $articles = array();
        foreach ($rows as $row) {
            $user = UserService::get($row['author']);
            $article = new Article($row['id'], $row['title'], $row['content'], $user, $row['created'], $row['cover']);
            array_push($articles, $article);
        }
        return $articles;
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
