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
            <br>
            <button class="btn" onclick="toggleCast(this)">Afficher tout</button>
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
            <!-- <div class="comments_container" style="background-color:white;padding:1rem;">
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
                        echo '<p>' . $comment["commentText"] . '</p>';
                        echo '</div>';
                        echo '</div>';
                    }
                    ?>
                </div>
            </div> -->
            <div class="comment_container">
                <div class="comment" style="display:flex;gap:1rem;margin-top:1rem;background-color:#fff;padding:1rem;border-radius:10px;">
                    <?php foreach($comments as $comment) { ?>
                    <div class="profile_pic">
                        <img src="./assets/img/icons/user.jpg" alt="user" width="50px" style="border-radius: 25px;">
                    </div>
                    <div class="comment_body" style="display:flex;flex-direction:column;">
                        <div class="comment_info" style="display:flex;gap:1rem;">
                            <p class="username" style="color:#555;"><?= $userInfo->userFirstname ?></p>
                            <p class="comment_date" style="color:#888;"><?= $comment['commentDate'] ?></p>
                        </div>
                        <p class="comment_text" style="font-size: 18px;"><?= $comment['commentText'] ?></p>
                    </div>
                    <?php } ?>
                </div>
            </div>

            <h2 style="margin-top: 2rem;">Ajouter un commentaire</h2>
            <div class="comment_input" style="margin-top: 1rem;background-color: #fff;border-radius: 25px;display: flex;padding:.5rem;gap: 1rem;box-shadow: 0 0 10px rgba(0,0,0,.1);">
                <input type="hidden" name="commentMediaId" id="commentMediaId" value="<?= $media->id ?>">
                <input type="hidden" name="commentUserId" id="commentUserId" value="<?= $userInfo->userId ?>">
                <img src="./assets/img/icons/user.jpg" alt="user" width="50px" style="border-radius: 25px;margin-right:-10px;">
                <input type="text" name="commentText" id="commentText" style="background-color: #f2f2f2;border-radius: 10px;outline: none;border: none;padding: 0 1rem;width: 100%;" placeholder="Ajouter un commentaire...">
                <button id="add_comment" style="background:  #fff;color: #000;padding: 0 1rem">&gt;&gt;</button>
            </div>
        </div>
    </div>

    <script>
        function toggleCast(e) {
            let cast = document.querySelector('.cast_container');
            if (!cast.classList.contains('cast_container_full')) {
                cast.style.height = 'auto';
                cast.classList.add('cast_container_full');
                e.innerHTML = 'Réduire';
            } else {
                cast.style.height = '225px';
                e.innerHTML = 'Afficher tout';
                cast.classList.remove('cast_container_full');
            }
        }
    </script>


    <?php require_once './assets/includes/footer.php'; ?>
</body>

</html>