<!DOCTYPE html>
<html lang="fr">

<?php
require_once './assets/includes/head.php';
?>

<body>
    <?php
    require_once './assets/includes/searchbar.php';
    require_once './assets/includes/header.php';


    $peopleId = $people->peopleId;
    $peopleFirstname = $people->peopleFirstname;
    $peopleLastname = $people->peopleLastname;
    $peopleFullname = $people->peopleFullname;
    $peopleBirthday = $people->peopleBirthday;
    $peopleDeathday = $people->peopleDeathday;
    $peopleBiography = $people->peopleBiography;
    $peoplePicture = $people->peoplePicture;
    $peopleBirthplace = $people->peopleBirthplace;
    $peopleKnownForDepartment = $people->peopleKnownForDepartment;
    $now = new DateTime();
    $birth = new DateTime($peopleBirthday);
    ?>


    <div class="container">
        <div class="people_container">

            <div class="people_picture">
                <img src="https://image.tmdb.org/t/p/w500<?= $peoplePicture; ?>" alt="people_picture">
            </div>
            <div class="people_infos">
                <h1><?= $peopleFullname; ?></h1>
                <p><?= date('d/m/Y', strtotime($peopleBirthday)); ?> - <?= $peopleDeathday ? date('d/m/Y', strtotime($peopleDeathday)) . " (" . $birth->diff(new DateTime($peopleDeathday))->format('%y ans') . ")" : $now->diff(new DateTime($peopleBirthday))->format('%y ans'); ?></p>
                <p><?= $peopleBirthplace; ?></p>
                <p><?= $peopleKnownForDepartment; ?></p>
            </div>
        </div>
        <br>

        <div class="people_biography">
            <h2>Biographie</h2>

            <p><?= $peopleBiography ? $peopleBiography : 'Aucune biographie à afficher'; ?></p>
        </div>
        <br>
        <div class="filmography">
            <h2>Filmographie</h2>
            <div class="gallery">
                <?php
                $films = $people->getFilms();

                foreach ($films as $film) { ?>

                    <div class="gallery__item">
                        <a href="index.php?view&id=<?= $film['mediaId']; ?>">
                            <img src="https://image.tmdb.org/t/p/w500<?= $film['mediaCoverImage']; ?>" alt="poster">
                        </a>
                    </div>
                <?php
                }
                ?>

            </div>
        </div>
    </div>


    <?php require_once './assets/includes/footer.php'; ?>
</body>

</html>