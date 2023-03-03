<!DOCTYPE html>
<html lang="fr">

<?php
require_once './includes/head.php';
?>

<body>
    <?php
    require_once './includes/searchbar.php';
    require_once './includes/header.php';

    $mediaName = $media->titre;
    $mediaType = $media->type;
    $mediaGenres = $media->genres;
    $mediaAuthors = $media->authors;
    $mediaYear = $media->annee;
    $mediaDescription = $media->synopsis;
    $mediaCover = $media->affiche;
    $mediaBgImage = $media->background;
    ?>
    <div class="media_container">
        <div class="background">
            <img src="https://image.tmdb.org/t/p/w1280<?= $mediaBgImage; ?>" alt="background">
            <div class="overlay"></div>
        </div>

        <div class="inner_container">
            <div class=" landing">
                <div class="left">
                    <div class="infos">
                        <h1 data-aos="fade-right" data-aos-duration="750" data-aos-delay="100"><?= $mediaName; ?></h1>
                        <p data-aos="fade-right" data-aos-duration="750" data-aos-delay="150"><?= $mediaType; ?> - <?php
                                                                                                                    $mediaGenres = json_decode($mediaGenres);
                                                                                                                    foreach ($mediaGenres as $genre) {
                                                                                                                        echo $genre . ' ';
                                                                                                                    }
                                                                                                                    ?></p>
                        <p data-aos="fade-right" data-aos-duration="750" data-aos-delay="200"><?php
                                                                                                $mediaAuthors = json_decode($mediaAuthors);
                                                                                                foreach ($mediaAuthors as $author) {
                                                                                                    echo $author . ' ';
                                                                                                }
                                                                                                ?></p>
                        <p data-aos="fade-right" data-aos-duration="750" data-aos-delay="250"><?= $mediaYear; ?></p>
                    </div>
                    <div class="cover" data-aos="fade-right" data-aos-duration="750" data-aos-delay="0">
                        <img src="https://image.tmdb.org/t/p/w500<?= $mediaCover; ?>" alt="cover">
                    </div>
                </div>
            </div>
        </div>

    </div>
    <div class="container">
        <div class="description">
            <h2>Synopsis</h2>
            <p><?= $mediaDescription; ?></p>
        </div>


    </div>



    <?php require_once './includes/footer.php'; ?>
</body>

</html>