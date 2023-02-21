<?php
require_once './config/config.php';
?>
<!DOCTYPE html>
<html lang="fr">

<?php
$currentPage = 'Vue média';
require_once './includes/head.php';
?>

<body>
    <?php
    require_once './includes/searchbar.php';
    require_once './includes/header.php';

    $mediaId = $_GET['id'];
    $media = $conn->prepare("SELECT * FROM medias, authors, genres, types, appartient_genre, appartient_author WHERE medias.mediaTypeId = types.typeID AND medias.mediaId = appartient_author.appartientMediaId  AND appartient_author.appartientAuthorId = authors.authorId AND medias.mediaId = appartient_genre.appartientMediaId AND genres.genreId = appartient_genre.appartientGenreId AND medias.mediaID = $mediaId");
    $media->execute();
    $media = $media->fetch(PDO::FETCH_ASSOC);

    $mediaName = $media['mediaName'];
    $mediaType = $media['typeName'];
    $mediaAuthor = $media['authorFirstname'] . ' ' . $media['authorLastname'];
    $mediaYear = $media['mediaYear'];
    $mediaDescription = $media['mediaDescription'];
    $mediaCover = $media['mediaCoverImage'];
    $mediaBgImage = $media['mediaBackgroundImage'];
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
                        <p data-aos="fade-right" data-aos-duration="750" data-aos-delay="150"><?= $mediaType; ?></p>
                        <p data-aos="fade-right" data-aos-duration="750" data-aos-delay="200"><?= $mediaAuthor; ?></p>
                        <p data-aos="fade-right" data-aos-duration="750" data-aos-delay="250"><?= $mediaYear; ?></p>
                    </div>
                    <div class="cover" data-aos="fade-right" data-aos-duration="750" data-aos-delay="0">
                        <img src="https://image.tmdb.org/t/p/w500<?= $mediaCover; ?>" alt="cover">
                    </div>
                </div>
            </div>
        </div>
    </div>

    <?php require_once './includes/footer.php'; ?>
</body>

</html>