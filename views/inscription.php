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

   <div class="container">
      <form method="post" id="register_form" class="card">
         <h1 class="form-title">Inscription</h1>
         <div class="input-div">
            <label for="firstname">Prénom</label>
            <input type="text" name="firstname" id="firstname" placeholder="John" required />
         </div>
         <div class="input-div">
            <label for="lastname">Nom</label>
            <input type="text" name="lastname" id="lastname" placeholder="Doe" required />
         </div>
         <div class="input-div">
            <label for="birthdate">Date de naissance</label>
            <input type="date" name="birthdate" id="birthdate" required />
         </div>
         <div class="input-div">
            <label for="email">Email</label>
            <input type="email" name="email" id="email" placeholder="mail@exemple.com" required />
         </div>
         <div class="input-div">
            <label for="password">Mot de passe</label>
            <input type="password" name="password" id="password" placeholder="************" required />
         </div>
         <div class="input-div">
            <label for="confirm_password">Confirmation du mot de passe</label>
            <input type="password" name="confirm_password" id="confirm_password" placeholder="************" required />
         </div>
         <input class="form-btn" type="submit" value="S'inscrire" />
         <a class="form-link" href="./?connexion" style="color: black;">Déjà inscrit ? Connectez-vous !</a>
      </form>
   </div>

   <?php require_once './assets/includes/footer.php'; ?>
   <script src="./controllers/js/inscription.js"></script>
</body>

</html>