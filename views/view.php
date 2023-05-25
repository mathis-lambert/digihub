<!DOCTYPE html>
<html lang="fr">

<?php
require_once './assets/includes/head.php';
?>

<body>
    <script src="./controllers/js/favorites.js"></script>
    <script defer src="./controllers/js/comments.js"></script>
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
                        <div data-aos="fade-right" data-aos-duration="750" data-aos-delay="250">
                            <?php
                            if (isset($_SESSION['user'])) {
                                $userInfo = User::find($_SESSION['userId']);
                                $favorite = Favorites::find($media->id, $userInfo->userId);
                            ?>
                                <button onclick="toggleFavorite(this, <?= $media->id ?>,<?= $userInfo->userId ?>)">
                                    <?php
                                    if (is_null($favorite)) {
                                        echo 'Ajouter aux favoris';
                                    } else {
                                        echo 'Retirer des favoris';
                                    }
                                    ?>
                                </button>
                            <?php
                            }
                            ?>
                        </div>
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
                        echo '<img src="./assets/img/icons/user.jpg" alt="actor" width="100px">';
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

        <div id="comments">
            <h2>Commentaires</h2>
            <div class="comments_container" style="background-color:white;padding:1rem;">
                <div class="comments">
                    <?php
                    foreach ($comments as $comment) {
                        $user = User::find($comment['commentUserId']);
                        echo '<div class="comment">';
                        echo '<div class="comment_header">';
                        echo '<div class="comment_user" style="display:flex;align-items:center">';
                        echo '<img src="./assets/img/icons/user.jpg" alt="user" width="50px">';
                        echo '<p>' . $user->userFirstname . ' </p>';
                        echo '<p style="margin-left:.25rem"> (' . $comment['commentRating'] . ' étoiles) </p>';
                        echo '</div>';
                        echo '</div>';
                        echo '<div class="comment_body">';
                        echo '<h3>' . $comment["commentTitle"] . '</h3>';
                        echo '<p>' . $comment["commentText"] . '</p>';
                        echo '</div>';
                        echo '</div>';
                    }
                    ?>
                </div>
            </div>
            <div class="comment_input" style="display:flex;flex-direction:column;margin:.5rem;gap:.5rem">
                <input type="hidden" name="commentMediaId" id="commentMediaId" value="<?= $media->id ?>">
                <input type="hidden" name="commentUserId" id="commentUserId" value="<?= $userInfo->userId ?>">
                <div class="row" style="display:flex;gap:.5rep">
                    <input id="commentTitle" style="padding:.5rem;width:50%" type="text" name="commentTitle" placeholder="Titre">
                    <select style="padding:.5rem" name="commentRating" id="commentRating">
                        <option value="1">1 étoile</option>
                        <option value="2">2 étoiles</option>
                        <option value="3">3 étoiles</option>
                        <option value="4">4 étoiles</option>
                        <option value="5">5 étoiles</option>
                    </select>
                </div>
                <textarea style="padding:.5rem;height:6rem" name="commentText" id="commentText" placeholder="Commentaire"></textarea>
                <button id="add_comment">Ajouter le commentaire</button>
            </div>
        </div>
    </div>


    <?php require_once './assets/includes/footer.php'; ?>
</body>

</html>