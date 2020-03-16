<?php

require_once($_SERVER['DOCUMENT_ROOT'] . "/config.php");

$response = new Response();
$errors = array();
$success = array();

if (Utilities::requiredParameters($_POST, array("comment_area", "article_id"))) {
    $user = SecurityService::getLogged();
    $article = ArticleService::get($_POST["article_id"]);
    $comment = $_POST["comment_area"];

    if (strlen($comment) <= 0) {
        array_push($errors, array("Comment cannot be empty!"));
    } if ($article->isNull()) {
        array_push($errors, array("Article cannot be found!"));
    }

    if (count($errors) <= 0) {
        CommentService::add($comment, $user->getId(), $article->getId());
        array_push($success, array("Comment successfully added!"));
        $response->statusCode = 200;
    } else {
        $response->statusCode = 400;
    }
} else {
    $response->statusCode = 400;
}

$response->errors = $errors;
$response->success = $success;

echo json_encode($response);
http_response_code($response->statusCode);

