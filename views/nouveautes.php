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



    <div class="container">
        <h1>Nouveautés</h1>
        <h2>Films</h2>

        <?php
        $filter_aim_at = "Film";
        include_once './assets/includes/filterBar.php';
        ?>
        <div class="gallery" id="film_container">
        </div>
    </div>

    <?php
    require_once './assets/includes/footer.php';
    ?>
</body>

</html>