<?php

session_start();

//ENTITIES
require_once($_SERVER['DOCUMENT_ROOT'] . "/api/entities/Response.php");

//MODELS
require_once($_SERVER['DOCUMENT_ROOT'] . "/app/models/User.php");
require_once($_SERVER['DOCUMENT_ROOT'] . "/app/models/Rank.php");
require_once($_SERVER['DOCUMENT_ROOT'] . "/app/models/Article.php");
require_once($_SERVER['DOCUMENT_ROOT'] . "/app/models/Comment.php");

//ENUMERATIONS
require_once($_SERVER['DOCUMENT_ROOT'] . "/app/enum/RanksEnum.php");
require_once($_SERVER['DOCUMENT_ROOT'] . "/app/enum/FormsEnum.php");

//SERVICES
require_once($_SERVER['DOCUMENT_ROOT'] . "/app/services/UserService.php");
require_once($_SERVER['DOCUMENT_ROOT'] . "/app/services/SecurityService.php");
require_once($_SERVER['DOCUMENT_ROOT'] . "/app/services/ArticleService.php");
require_once($_SERVER['DOCUMENT_ROOT'] . "/app/services/RankService.php");
require_once($_SERVER['DOCUMENT_ROOT'] . "/app/services/CommentService.php");

//UTILITIES
require_once($_SERVER['DOCUMENT_ROOT'] . "/app/Utilities.php");

?>
