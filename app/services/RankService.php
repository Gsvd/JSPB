<?php


class RankService
{

    public static function get($id) {
        $db = new Database();
        $dbh = $db->connect();
        $sql = "SELECT * FROM ranks WHERE id = :id";
        $sth = $dbh->prepare($sql);
        $sth->execute(array(
            ':id' => $id
        ));
        $row = $sth->fetch();
        $rank = new Rank($row['id'], $row['label'], $row['code']);
        return $rank;
    }

    public static function getAll() {
        $db = new Database();
        $dbh = $db->connect();
        $sql = "SELECT * FROM ranks ORDER BY id ASC";
        $sth = $dbh->prepare($sql);
        $sth->execute();
        $rows = $sth->fetchAll();
        $ranks = array();
        foreach ($rows as $row) {
            $rank = new Rank($row['id'], $row['label'], $row['code']);
            array_push($ranks, $rank);
        }
        return $ranks;
    }

}
