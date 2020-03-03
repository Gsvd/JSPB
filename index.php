<?php

$request = $_SERVER['REQUEST_URI'];

//ENUMERATIONS
require_once(__DIR__ . "/app/enum/RanksEnum.php");
require_once(__DIR__ . "/app/enum/FormsEnum.php");
require_once(__DIR__ . "/app/enum/PagesEnum.php");

require_once(__DIR__ . "/config.php");
require_once(__DIR__ . "/app/Utilities.php");
require_once(__DIR__ . "/app/services/UserService.php");
require_once(__DIR__ . "/app/services/SecurityService.php");
require_once(__DIR__ . "/app/services/ArticleService.php");
require_once(__DIR__ . "/app/services/PagesService.php");

require_once(__DIR__ . "/templates/header.php");
require_once(__DIR__ . "/templates/nav.php");

switch ($request) {
    case '':
    case '/':
        require __DIR__ . '/pages/articles.php';
        break;
    case '/about':
        require __DIR__ . '/pages/about.php';
        break;
    case '/write':
        require __DIR__ . '/pages/write.php';
        break;
    case '/profile':
        require __DIR__ . '/pages/profile.php';
        break;
    case '/register':
        require __DIR__ . '/pages/register.php';
        break;
    case '/login':
        require __DIR__ . '/pages/login.php';
        break;
    case '/logout':
        require __DIR__ . '/pages/logout.php';
        break;
    case (preg_match('/article\/[0-9]+/', $request) ? true : false):
        require __DIR__ . '/pages/article.php';
        break;
    case '/error/403':
        require __DIR__ . '/pages/errors/403.php';
        break;
    case '/error/404':
        require __DIR__ . '/pages/errors/404.php';
        break;
}

require_once (__DIR__ . "/templates/footer.php");
