<!DOCTYPE html>
<html lang="fr">

<?php
require_once './assets/includes/head.php';
?>

<body>
    <?php
    require_once './assets/includes/searchbar.php';
    require_once './assets/includes/header.php';

    $mediaName = $media->titre;
    $mediaType = $media->type;
    $mediaGenres = json_decode($media->genres);
    $mediaAuthors = json_decode($media->authors);
    $mediaActors = json_decode($media->actors);
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
                                                                                                                    foreach ($mediaGenres as $genre) {
                                                                                                                        echo $genre . ' ';
                                                                                                                    }
                                                                                                                    ?></p>
                        <p data-aos="fade-right" data-aos-duration="750" data-aos-delay="200"><?php
                                                                                                foreach ($mediaAuthors as $author) {
                                                                                                    echo $author->peopleFullname . ' ';
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
        <div class="cast">
            <h2>Cast</h2>
            <div class="cast_container">
                <?php
                $mediaActors = json_decode($media->actors);
                foreach ($mediaActors as $actor) {
                    echo '<div class="actor">';
                    if ($actor->peoplePicture != null) {
                        echo '<img src="https://image.tmdb.org/t/p/w500' . $actor->peoplePicture . '" alt="actor" width="100px">';
                    } else {
                        echo '<img src="./assets/img/icons/err.svg" alt="actor" width="100px">';
                    }
                    echo $actor->peopleFullname;
                    echo " | " . $actor->characterName;
                    echo '</div>';
                }
                ?>
            </div>
        </div>


    </div>



    <?php require_once './assets/includes/footer.php'; ?>
</body>

</html>