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
    $media = $conn->prepare("SELECT * FROM medias, types, authors WHERE medias.mediaTypeId = types.typeID AND medias.mediaAuthorId = authors.authorID AND medias.mediaID = $mediaId");
    $media->execute();
    $media = $media->fetch(PDO::FETCH_ASSOC);

    $mediaName = $media['mediaName'];
    $mediaType = $media['typeName'];
    $mediaAuthor = $media['authorFirstname'] . ' ' . $media['authorLastname'];
    $mediaYear = $media['mediaYear'];
    $mediaShortDesc = $media['mediaShortDesc'];
    $mediaLongDesc = $media['mediaLongDesc'];
    $mediaCover = $media['mediaCoverImage'];
    $mediaBgImage = $media['mediaBackgroundImage'];
    ?>
    <div class="media_container">
        <div class="background">
            <img src="./assets/img/backgrounds/<?= $mediaBgImage; ?>" alt="background">
            <div class="overlay"></div>
        </div>

        <div class="inner_container">
            <div class=" landing">
                <div class="left">
                    <div class="cover">
                        <img src="./assets/img/cover/<?= $mediaCover; ?>" alt="couverture">
                    </div>
                    <div class="infos">
                        <h1><?= $mediaName; ?></h1>
                        <p><?= $mediaType; ?></p>
                        <p><?= $mediaAuthor; ?></p>
                        <p><?= $mediaYear; ?></p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <?php require_once './includes/footer.php'; ?>
</body>

</html>