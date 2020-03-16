<?php

require_once($_SERVER['DOCUMENT_ROOT'] . "/config.php");

SecurityService::requireAuth(true);
SecurityService::redirectIfNotAllowed(RanksEnum::WRITER);

$user = SecurityService::getLogged();
$article = ArticleService::get($_GET['article']);

$errors = array();
$success = array();

if (isset($_POST["comment_area"])) {
    $comment = $_POST["comment_area"];

    if (!isset($comment) || strlen($comment) <= 0) {
        array_push($errors, array("Comment cannot be empty!"));
    }

    if (count($errors) <= 0) {
        CommentService::add($comment, $user->getId(), $article->getId());
        array_push($success, array("Comment successfully added!"));
    }
} else if (isset($_POST["comment_delete"])) {
    $commentID = $_POST["comment_id"];

    CommentService::delete($commentID);
}
