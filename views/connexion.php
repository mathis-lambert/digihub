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

   <form method="post" id="login_form" class="container">
      <div class="input-div">
         <label for="email">Email</label>
         <input type="email" name="email" id="email" placeholder="mail@exemple.com" required />
      </div>
      <div class="input-div">
         <label for="password">Mot de passe</label>
         <input type="password" name="password" id="password" placeholder="************" required />
      </div>
      <input type="submit" value="Se connecter" />
      <a href="./?inscription" style="color: black;">Pas encore inscrit ? Créez votre compte !</a>
   </form>

   <?php require_once './assets/includes/footer.php'; ?>
   <script src="./controllers/js/connexion.js"></script>
</body>

</html>