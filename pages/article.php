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
        array_push($errors, array("Comment cannot be empty!"));
    }

    if (count($errors) <= 0) {
        CommentService::add($comment, $user->getId(), $article->getId());
        array_push($success, array("Comment successfully added!"));
    }
} else if (isset($_POST["comment_delete"])) {
    $commentID = $_POST["comment_id"];

    CommentService::delete($commentID);
}

$comments = $article->getComments();

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
        $author = UserService::get($article->getAuthor()->getId());
        ?>
        <div class="row">
            <div class="article">
                <div class="row">
                    <div class="twelve columns title">
                        <img class="cover" src="/assets/images/covers/<?= $article->getCover() ?>" alt="">
                    </div>
                </div>
                <div class="row">
                    <div class="twelve columns title">
                        <h2 id="title">
                            <?= $article->getTitle() ?>
                        </h2>
                    </div>
                </div>
                <div class="row">
                    <div class="twelve columns content">
                        <?= $article->getContent() ?>
                    </div>
                </div>
                <div class="row">
                    <div class="twelve columns author">
                        by <?= $author->getUsername() ?>, <?= $article->getCreated() ?>
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
                    <form id="comment_form" action="" method="post">
                        <input name="article_id" type="hidden" value="<?= $article->getId() ?>">
                        <div class="eight columns offset-by-two">
                            <textarea class="u-full-width" name="comment_area" id="comment_area" cols="30" rows="10"
                                      placeholder="Arrays start at one."></textarea>
                        </div>
                        <div class="eight columns offset-by-two">
                            <input id="comment_submit" class="u-full-width" type="button" name="comment_submit" value="Submit">
                        </div>
                    </form>
                </div>
                <div class="twelve columns">
                    <ul>
                        <div id="errors"></div>
                        <div id="success"></div>
                    </ul>
                </div>
                <div class="row">
                    <?php
                    foreach ($comments as $comment) {
                        ?>
                        <div class="twelve columns comment">
                            <div class="ten columns">
                                <?= $comment->getContent() ?>
                            </div>
                            <?php
                            if ($comment->getAuthor() == $user->getId() || SecurityService::requiredRank(RanksEnum::ADMIN)) {
                                ?>
                                <div class="two columns">
                                    <form action="" method="post">
                                        <input name="comment_id" type="hidden" value="<?= $comment->getId() ?>">
                                        <input name="comment_delete" class="u-full-width" type="submit" value="Delete">
                                    </form>
                                </div>
                                <?php
                            }
                            ?>
                            <div class="twelve columns author space-top text-right">
                                by <?= $comment->getAuthor()->getUsername() ?>, <?= $comment->getCreated() ?>
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
    <script>
        document.getElementById("comment_submit").addEventListener("click", function () {
            var form = new FormData(document.getElementById("comment_form"));
            fetch("/api/comments/add.php", {
                method: "POST",
                body: form
            })
            .then(function (response) {
                return response.text()
            })
            .then(function (text) {
                let response = JSON.parse(text);
                let success = "";
                let errors = "";
                response.success.forEach(function (element) {
                   success += `<li class='success'>${element}</li>`
                });
                response.errors.forEach(function (element) {
                    errors += `<li class='error'>${element}</li>`
                });
                document.getElementById("success").innerHTML = success;
                document.getElementById("errors").innerHTML = errors;
            })
        })
    </script>
</div>
