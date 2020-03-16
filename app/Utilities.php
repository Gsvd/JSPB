<?php


require_once "Database.php";

class Utilities extends Database
{

    public static function previewText($text) {
        return trim(strip_tags(substr($text, 0, 256))) . " [...]";
    }

    public static function getRequestedArticle() {
        $urlArray = explode('/', $_SERVER['REQUEST_URI']);
        return end($urlArray);
    }

    public static function requiredParameters($request, $parameters) {
        foreach ($parameters as $parameter) {
            if (!isset($request[$parameter])) {
                return false;
            }
        }
        return true;
    }

}
