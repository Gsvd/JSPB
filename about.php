<?php

session_start();

require_once("config.php");
require_once("app/Utilities.php");

require_once(__ROOT__ . "/templates/header.php");
require_once (__ROOT__ . "/templates/nav.php");

$errors = array();

?>

<div id="content" class="container">
    <div class="row">
        <div class="twelve columns">
            ABOUT
        </div>
    </div>
</div>

<?php require_once(__ROOT__ . "/templates/footer.php"); ?>
