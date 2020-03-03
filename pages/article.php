<?php

$article = ArticleService::get(Utilities::getRequestedArticle());

if ($article == null)
    SecurityService::redirectTo(404);

$user = SecurityService::getLogged();

$errors = array();
$success = array();

if (isset($_POST["comment_submit"])) {
    $comment = $_POST["comment_area"];

    if (!isset($comment) || strlen($comment) <= 0) {
        array_push($errors, array("comment" => "Comment cannot be empty!"));
    }

    if (count($errors) <= 0) {
        CommentService::add($comment, $user["id"], $article["id"]);
        array_push($success, array("comment" => "Comment successfully added!"));
    }
} else if (isset($_POST["comment_delete"])) {
    $commentID = $_POST["comment_id"];

    CommentService::delete($commentID);
}

$comments = CommentService::getByArticleID($article["id"]);

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
                    <div class="twelve columns title">
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
        <div class="twelve columns separator"></div>
        <div class="row">
            <div class="comments">
                <div class="row">
                    <div class="twelve columns">
                        <h3 class="text-center">Comments</h3>
                    </div>
                </div>
                <div class="row">
                    <form action="" method="post">
                        <div class="eight columns offset-by-two">
                            <textarea class="u-full-width" name="comment_area" id="comment_area" cols="30" rows="10"
                                      placeholder="Arrays start at one."></textarea>
                        </div>
                        <div class="eight columns offset-by-two">
                            <input class="u-full-width" type="submit" name="comment_submit" value="Submit">
                        </div>
                    </form>
                </div>
                <div class="twelve columns">
                    <ul>
                        <div>
                            <?php
                            foreach ($errors as $error) {
                                ?>
                                <li class="error"><?= array_values($error)[0] ?></li>
                                <?php
                            }
                            ?>
                        </div>
                        <div>
                            <?php
                            foreach ($success as $message) {
                                ?>
                                <li class="success"><?= array_values($message)[0] ?></li>
                                <?php
                            }
                            ?>
                        </div>
                    </ul>
                </div>
                <div class="row">
                    <?php
                    foreach ($comments as $comment) {
                        $author = UserService::get($comment["author"]);
                        ?>
                        <div class="twelve columns comment">
                            <div class="ten columns">
                                <?= $comment["content"] ?>
                            </div>
                            <?php
                            if ($comment["author"] == $user["id"] || SecurityService::requiredRank(RanksEnum::ADMIN)) {
                                ?>
                                <div class="two columns">
                                    <form action="" method="post">
                                        <input name="comment_id" type="hidden" value="<?= $comment['id'] ?>">
                                        <input name="comment_delete" class="u-full-width" type="submit" value="Delete">
                                    </form>
                                </div>
                                <?php
                            }
                            ?>
                            <div class="twelve columns author space-top text-right">
                                by <?= $author["username"] ?>, <?= $article['created'] ?>
                            </div>
                        </div>
                        <?php
                    }
                    ?>
                </div>
            </div>
        </div>
        <?php
    }
    ?>
</div>
