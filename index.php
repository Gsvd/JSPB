<?php

$request = $_SERVER['REQUEST_URI'];

require_once($_SERVER['DOCUMENT_ROOT'] . "/config.php");

require_once($_SERVER['DOCUMENT_ROOT'] . "/templates/header.php");
require_once($_SERVER['DOCUMENT_ROOT'] . "/templates/nav.php");

switch ($request) {
    case '':
    case '/':
        require $_SERVER['DOCUMENT_ROOT'] . '/pages/articles.php';
        break;
    case '/about':
        require $_SERVER['DOCUMENT_ROOT'] . '/pages/about.php';
        break;
    case '/write':
        require $_SERVER['DOCUMENT_ROOT'] . '/pages/write.php';
        break;
    case '/profile':
        require $_SERVER['DOCUMENT_ROOT'] . '/pages/profile.php';
        break;
    case '/register':
        require $_SERVER['DOCUMENT_ROOT'] . '/pages/register.php';
        break;
    case '/login':
        require $_SERVER['DOCUMENT_ROOT'] . '/pages/login.php';
        break;
    case '/logout':
        require $_SERVER['DOCUMENT_ROOT'] . '/pages/logout.php';
        break;
    case (preg_match('/article\/[0-9]+/', $request) ? true : false):
        require $_SERVER['DOCUMENT_ROOT'] . '/pages/article.php';
        break;
    case '/error/403':
        require $_SERVER['DOCUMENT_ROOT'] . '/pages/errors/403.php';
        break;
    case '/error/404':
        require $_SERVER['DOCUMENT_ROOT'] . '/pages/errors/404.php';
        break;
}

require_once ($_SERVER['DOCUMENT_ROOT'] . "/templates/footer.php");
