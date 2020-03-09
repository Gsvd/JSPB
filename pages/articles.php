<?php

if (isset($_POST["article_delete"])) {
    ArticleService::delete($_POST["article_id"]);
}

$articles = ArticleService::getAll();

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
        foreach ($articles as $article) {
            ?>
            <form action="" method="post">
                <div class="row">
                    <div class="article">
                        <div class="row">
                            <div class="eleven columns title">
                                <h2>
                                    <a href="/article/<?= $article->getId() ?>">
                                        <?= $article->getTitle() ?>
                                    </a>
                                </h2>
                            </div>
                            <?php
                            if (SecurityService::requiredRank(RanksEnum::ADMIN)) {
                                ?>
                                <div class="one column">
                                    <input type="hidden" value="<?= $article->getId() ?>" name="article_id">
                                    <input type="submit" value="Delete" name="article_delete">
                                </div>
                                <?php
                            }
                            ?>
                        </div>
                        <div class="row">
                            <div class="twelve columns content">
                                <?= Utilities::previewText($article->getContent()) ?>
                            </div>
                        </div>
                        <div class="row">
                            <div class="twelve columns author">
                                by <?= $article->getAuthor()->getUsername() ?>, <?= $article->getCreated() ?>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
            <?php
        }
    }
    ?>
</div>
