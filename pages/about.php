<?php

SecurityService::redirectIfNotAllowed(PagesService::get(PagesEnum::ABOUT)["rank"]);
$page = PagesService::get(PagesEnum::ABOUT);

?>

<div id="content" class="container">
    <div class="row">
        <div class="twelve columns">
            <?= $page["content"] ?>
        </div>
    </div>
</div>
