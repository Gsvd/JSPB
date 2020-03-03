<?php


class PagesService
{

    public static function get($id) {
        $db = new Database();
        $dbh = $db->connect();
        $sql = "
        SELECT p.id,
               p.content,
               r.id AS rank,
               r.label,
               r.code
        FROM pages AS p INNER JOIN ranks AS r
        ON p.rank = r.id
        WHERE p.id = :id
        ";
        $sth = $dbh->prepare($sql);
        $sth->execute(array(
            ':id' => $id
        ));
        return $sth->fetch();
    }

    public static function updateContent($id, $content) {
        $db = new Database();
        $dbh = $db->connect();
        $sql = "UPDATE pages SET content = :content WHERE id = :id";
        $sth = $dbh->prepare($sql);
        $sth->execute(array(
            ':content' => $content,
            ':id' => $id
        ));
    }

}
