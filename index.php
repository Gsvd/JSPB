<?php

require_once("config.php");
require_once("app/Utilities.php");

require_once(__ROOT__ . "/templates/header.php");
require_once(__ROOT__ . "/templates/nav.php");

if (isset($_POST["article_delete"])) {
    Utilities::deleteArticle($_POST["article_id"]);
}

$articles = Utilities::getArticles();

?>

<div id="content" class="container">
    <?php
    if (!Utilities::isLogged()) {
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
                                <?= $article['title'] ?>
                            </h2>
                        </div>
                        <div class="one column">
                            <input type="hidden" value="<?= $article['id'] ?>" name="article_id">
                            <input type="submit" value="Delete" name="article_delete">
                        </div>
                    </div>
                    <div class="row">
                        <div class="twelve columns content">
                            <?= $article['content'] ?>
                        </div>
                    </div>
                    <div class="row">
                        <div class="twelve columns author">
                            by <?= $article['author'] ?>, <?= $article['created'] ?>
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

<?php require_once (__ROOT__ . "/templates/footer.php"); ?>
