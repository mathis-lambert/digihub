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
    $mediaTrailer = $media->trailer;
    ?>
    <div class="media_container">
        <div class="background">
            <img src="https://image.tmdb.org/t/p/original<?= $mediaBgImage; ?>" alt="background">
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
        <?php
        if (!is_null($mediaTrailer)) { ?>
            <div class="trailer">
                <h2>Trailer</h2>
                <iframe width="100%" height="500px" src="https://www.youtube.com/embed/<?= $mediaTrailer; ?>" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
            </div>

        <?php } ?>

        <div class="cast">
            <h2>Cast</h2>
            <div class="gallery cast_container">
                <?php
                $mediaActors = json_decode($media->actors);
                foreach ($mediaActors as $actor) {
                    echo '<div class="actor">';
                    echo '<a href="./?people&id=' . $actor->peopleId . '">';
                    if ($actor->peoplePicture != null) {
                        echo '<img src="https://image.tmdb.org/t/p/w500' . $actor->peoplePicture . '" alt="actor" width="100px">';
                    } else {
                        echo '<img src="./assets/img/icons/err.svg" alt="actor" width="100px">';
                    }
                    echo '<br>';
                    echo $actor->peopleFullname;
                    echo " <br> " . $actor->characterName;
                    echo '</a>';
                    echo '</div>';
                }
                ?>
            </div>
        </div>


    </div>



    <?php require_once './assets/includes/footer.php'; ?>
</body>

</html>