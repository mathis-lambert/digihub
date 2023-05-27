<!DOCTYPE html>
<html lang="fr">

<?php
require_once './assets/includes/head.php';
?>

<body>
    <?php
    require_once './assets/includes/searchbar.php';
    require_once './assets/includes/header.php';
    ?>
    <div class="container not-connected_container">
        <div class="overlay_landing"></div>
        <div class="not-connected_content">
            <h1>Veuillez vous connecter pour accéder à Digihub</h1>
            <p>
                <b>Digihub</b> est la référence dans le contenu numérique. <br>
                Retouvez vos films et séries préférés, ainsi que des livres numériques.
            </p>
            <p>
                Vous n'avez pas de compte ? <a href="./?inscription" class="btn btn-primary no-scale inline no-style white">Inscrivez-vous</a>
            </p>
            <div>
                <a href="./?connexion" class="btn no-scale inline">Se connecter</a>
                <a href="./?forgot_password" class="btn no-scale no-style font_xs inline white">Mot de passe oublié ?</a>
            </div>
        </div>
    </div>
    <?php require_once './assets/includes/footer.php'; ?>
</body>

</html>