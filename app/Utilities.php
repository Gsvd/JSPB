<?php


require_once "Database.php";

class Utilities extends Database
{

    public static function previewText($text) {
        return trim(substr($text, 0, 256)) . " [...]";
    }

    public static function getRequestedArticle() {
        $urlArray = explode('/', $_SERVER['REQUEST_URI']);
        return end($urlArray);
    }

}
