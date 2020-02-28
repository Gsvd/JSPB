<?php

Utilities::requireAuth(true);
Utilities::redirectIfNotAllowed(RanksEnum::WRITER);

$title = null;
$content = null;

$errors = array();
$success = array();

if (isset($_POST["article_submit"])) {
    $title = $_POST["article_title"];
    $content = $_POST["article_content"];
    if (!isset($title) || strlen($title) <= 0) {
        array_push($errors, array("title" => "Title cannot be empty!"));
    } if (!isset($content) || strlen($content) <= 0) {
        array_push($errors, array("content" => "Content cannot be empty!"));
    }

    if (count($errors) <= 0) {
        Utilities::addArticle($title, $content, $_SESSION["username"]);
        array_push($success, array("article" => "Article successfully added!"));
    }
}

?>

<div id="content" class="container">
    <form action="" method="post">
        <div class="row">
            <div class="twelve columns">
                <input class="u-full-width" type="text" name="article_title" placeholder="Lorem ipsum dolor sit amet" value="<?= $title ?>">
            </div>
        </div>
        <div class="row">
            <div class="twelve columns">
                <textarea name="article_content"
                          class="u-full-width"
                          cols="30"
                          rows="10"
                          placeholder="Maybe you can write something about coronavirus?"><?= $content ?></textarea>
            </div>
        </div>
        <div class="row">
            <div class="offset-by-three six columns">
                <input class="u-full-width" type="submit" value="Submit" name="article_submit">
            </div>
        </div>
        <div class="row">
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
        </div>
    </form>
</div>