<?php

require_once($_SERVER['DOCUMENT_ROOT'] . "/config.php");

$response = new Response();
$errors = array();
$success = array();

$response->body = array();

if (Utilities::requiredParameters($_GET, array("article"))) {
    $article = ArticleService::get($_GET["article"]);
    $comments = $article->getComments();

    $response->statusCode = 200;
    $response->body = $comments;
} else {
    $response->statusCode = 400;
}

$response->errors = $errors;
$response->success = $success;

echo json_encode($response);
http_response_code($response->statusCode);
