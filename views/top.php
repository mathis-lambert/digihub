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

    <h1 class="container">Les TOPS !</h1>
    <h2 class="container">Films</h2>


    <?php
    $filter_aim_at = "Film";
    include_once './assets/includes/filterBar.php';
    ?>
    <div class="gallery container" id="film_container">
    </div>

    <?php
    require_once './assets/includes/footer.php';
    ?>
</body>

</html>