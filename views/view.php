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
        <br>
        <?php
        if (!is_null($mediaTrailer)) {
        ?>
            <div class="trailer">
                <h2>Trailer</h2>
                <iframe width="100%" height="500px" src="https://www.youtube.com/embed/<?= $mediaTrailer; ?>" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
            </div>

        <?php
        }
        ?>
        <br>

        <div class="cast">
            <h2>Distribution</h2>
            <br>
            <button class="btn" onclick="toggleCast(this)">Afficher tout</button>
            <div class="gallery cast_container">
                <?php
                $mediaActors = json_decode($media->actors);
                foreach ($mediaActors as $actor) {
                    echo '<div class="actor">';
                    echo '<a href="./?people&id=' . $actor->peopleId . '" class="no-style">';
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
        <br>
        <div id="comments">
            <h2>Commentaires</h2>
            <br>
            <div class="comment_container">
                <div class="comments">

                    <?php
                    if (count($comments) == 0) {
                        echo '<p>Aucun commentaire pour le moment</p>';
                    } else {
                        foreach ($comments as $comment) {
                            $user = User::find($comment['commentUserId']); ?>
                            <div class="comment">
                                <div class="profile_pic">
                                    <img src="./assets/img/icons/user.jpg" alt="user" width="50px" style="border-radius: 25px;">
                                </div>
                                <div class="comment_body" style="display:flex;flex-direction:column;">
                                    <div class="comment_info" style="display:flex;gap:1rem;">
                                        <p class="username" style="color:#555;"><?= $user->userFirstname ?></p>
                                        <p class="comment_date" style="color:#888;"><?= date("d/m/Y", strtotime($comment['commentDate'])) ?></p>
                                    </div>
                                    <div class="comment_rating">
                                        <?php
                                        for ($i = 0; $i < $comment['commentRating']; $i++) {
                                            echo '<i class="full-star"></i>';
                                        }
                                        for ($i = 0; $i < 5 - $comment['commentRating']; $i++) {
                                            echo '<i class="empty-star"></i>';
                                        }
                                        ?>
                                    </div>
                                    <p class="comment_text" style="font-size: 18px;"><?= $comment['commentText'] ?></p>
                                </div>
                            </div>
                    <?php }
                    } ?>
                </div>
            </div>

            <h2 style="margin-top: 2rem;">Donnez votre avis !</h2>
            <h3>Note :</h3>
            <!-- Note ETOILE -->
            <fieldset class="rating">
                <input type="radio" id="star5" name="rating" value="5" /><label class="full" for="star5" title="Awesome - 5 stars"></label>
                <input type="radio" id="star4half" name="rating" value="4.5" /><label class="half" for="star4half" title="Pretty good - 4.5 stars"></label>
                <input type="radio" id="star4" name="rating" value="4" /><label class="full" for="star4" title="Pretty good - 4 stars"></label>
                <input type="radio" id="star3half" name="rating" value="3.5" /><label class="half" for="star3half" title="Meh - 3.5 stars"></label>
                <input type="radio" id="star3" name="rating" value="3" /><label class="full" for="star3" title="Meh - 3 stars"></label>
                <input type="radio" id="star2half" name="rating" value="2.5" /><label class="half" for="star2half" title="Kinda bad - 2.5 stars"></label>
                <input type="radio" id="star2" name="rating" value="2" /><label class="full" for="star2" title="Kinda bad - 2 stars"></label>
                <input type="radio" id="star1half" name="rating" value="1.5" /><label class="half" for="star1half" title="Meh - 1.5 stars"></label>
                <input type="radio" id="star1" name="rating" value="1" /><label class="full" for="star1" title="Sucks big time - 1 star"></label>
                <input type="radio" id="starhalf" name="rating" value="half" /><label class="half" for="starhalf" title="Sucks big time - 0.5 stars"></label>
            </fieldset>
            <br><br>
            <h3>Commentaire :</h3>
            <div class="comment_input">
                <input type="hidden" name="commentMediaId" id="commentMediaId" value="<?= $media->id ?>">
                <input type="hidden" name="commentUserId" id="commentUserId" value="<?= $userInfo->userId ?>">
                <img src="./assets/img/icons/user.jpg" alt="user">
                <input type="text" name="commentText" id="commentText" placeholder="Ajouter un commentaire...">
                <button id="add_comment">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512">
                        <path d="M16.1 260.2c-22.6 12.9-20.5 47.3 3.6 57.3L160 376V479.3c0 18.1 14.6 32.7 32.7 32.7c9.7 0 18.9-4.3 25.1-11.8l62-74.3 123.9 51.6c18.9 7.9 40.8-4.5 43.9-24.7l64-416c1.9-12.1-3.4-24.3-13.5-31.2s-23.3-7.5-34-1.4l-448 256zm52.1 25.5L409.7 90.6 190.1 336l1.2 1L68.2 285.7zM403.3 425.4L236.7 355.9 450.8 116.6 403.3 425.4z" />
                    </svg>
                </button>
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