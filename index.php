<?php

$request = $_SERVER['REQUEST_URI'];

//ENUMERATIONS
require_once(__DIR__ . "/app/enum/RanksEnum.php");
require_once(__DIR__ . "/app/enum/FormsEnum.php");

require_once(__DIR__ . "/config.php");
require_once(__DIR__ . "/app/Utilities.php");

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
    case '/error/403':
        require __DIR__ . '/pages/errors/403.php';
        break;
}

require_once (__DIR__ . "/templates/footer.php");
