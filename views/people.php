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
    ?>

    <div class="container">
        <div class="people_container">
            <div class="people_picture">
                <img src="https://image.tmdb.org/t/p/w500<?= $peoplePicture; ?>" alt="people_picture">
            </div>
            <div class="people_infos">
                <h1><?= $peopleFullname; ?></h1>
                <p><?= $peopleBirthday; ?></p>
                <p><?= $peopleBirthplace; ?></p>
                <p><?= $peopleKnownForDepartment; ?></p>
            </div>
        </div>
        <div class="people_biography">
            <h2>Biography</h2>
            <p><?= $peopleBiography; ?></p>
        </div>
    </div>


    <?php require_once './assets/includes/footer.php'; ?>
</body>

</html>