<?php


class CommentService
{

    public static function add($content, $author, $article) {
        $now = new DateTime();
        $db = new Database();
        $dbh = $db->connect();
        $sql = "INSERT INTO comments(content, author, article, created) VALUES(:content, :author, :article, :created)";
        $sth = $dbh->prepare($sql);
        $sth->execute(array(
            ':content' => $content,
            ':author' => $author,
            ':article' => $article,
            ':created' => $now->format("Y-m-d H:i:s")
        ));
    }

    public static function delete($id) {
        $db = new Database();
        $dbh = $db->connect();
        $sql = "DELETE FROM comments WHERE id = :id";
        $sth = $dbh->prepare($sql);
        $sth->execute(array(
            ':id' => $id
        ));
    }

    public static function getByArticleID($article) {
        $db = new Database();
        $dbh = $db->connect();
        $sql = "SELECT * FROM comments WHERE article = :article ORDER BY id DESC";
        $sth = $dbh->prepare($sql);
        $sth->execute(array(
            ':article' => $article
        ));
        return $sth->fetchAll();
    }

    public static function isCreator($comment, $user) {

    }

}
