<!DOCTYPE html>
<html lang="fr">


<?php
require_once './assets/includes/head.php';
?>

<body>
    <?php
    require_once './assets/includes/searchbar.php';
    require_once './assets/includes/header.php';
    ?>

    <h1 class="container">Nouveautés</h1>
    <h2 class="container">Films</h2>
    <div class="gallery container">
        <?php
        $news = $this->model->getNewMedias("Film");
        foreach ($news as $new) {
            echo '<div class="gallery__item">';
            echo '<a href="./?view&id=' . $new['mediaId'] . '">';
            echo '<img src="https://image.tmdb.org/t/p/w500' . $new['mediaCoverImage'] . '" alt="' . $new['mediaName'] . '">';
            echo '</a>';
            echo '</div>';
        }
        ?>

    </div>

    <?php
    require_once './assets/includes/footer.php';
    ?>
</body>

</html>