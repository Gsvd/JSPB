<?php

$article = ArticleService::get(Utilities::getRequestedArticle());

if ($article == null)
    SecurityService::redirectTo(404);

?>

<div id="content" class="container">
    <?php
    if (!SecurityService::isLogged()) {
        ?>
        <div class="row">
            <div class="twelve columns text-center">
                You must be logged in to read articles!
            </div>
        </div>
        <?php
    } else {
        $author = UserService::get($article["author"]);
        ?>
        <div class="row">
            <div class="article">
                <div class="row">
                    <div class="eleven columns title">
                        <h2>
                            <?= $article['title'] ?>
                        </h2>
                    </div>
                </div>
                <div class="row">
                    <div class="twelve columns content">
                        <?= $article['content'] ?>
                    </div>
                </div>
                <div class="row">
                    <div class="twelve columns author">
                        by <?= $author["username"] ?>, <?= $article['created'] ?>
                    </div>
                </div>
            </div>
        </div>
        <?php
    }
    ?>
</div>
