<?php

require_once("config.php");
require_once("app/Utilities.php");

Utilities::requireAuth(true);

$errors = array();

if (isset($_POST["article_submit"])) {
    $title = $_POST["article_title"];
    $content = $_POST["article_content"];
    $author = $_POST["article_author"];
    if (!isset($title) || strlen($title) <= 0) {
        array_push($errors, array("title" => "Title cannot be empty!"));
    } if (!isset($content) || strlen($content) <= 0) {
        array_push($errors, array("content" => "Content cannot be empty!"));
    } if (!isset($author) || strlen($author) <= 0) {
        array_push($errors, array("author" => "Author cannot be empty!"));
    }

    if (count($errors) <= 0) {
        Utilities::addArticle($title, $content, $author);
    }
}

require_once(__ROOT__ . "/templates/header.php");
require_once (__ROOT__ . "/templates/nav.php");

?>

<div id="content" class="container">
    <form action="" method="post">
        <div class="row">
            <div class="twelve columns">
                <input class="u-full-width" type="text" name="article_title" placeholder="Just some title" value="<?= $title ?>">
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
            <div class="six columns">
                <input class="u-full-width" type="text" name="article_author" placeholder="Xx_Sram_xX" value="<?= $author ?>">
            </div>
            <div class="six columns">
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
                </ul>
            </div>
        </div>
    </form>
</div>

<?php require_once(__ROOT__ . "/templates/footer.php"); ?>
