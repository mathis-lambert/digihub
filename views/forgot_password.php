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
      <form method="post" id="forgot_password_form" class="card">
         <h1 class="form-title">Mot de passe oublié</h1>
         <div class="input-div">
            <label for="email">Email</label>
            <input type="email" name="email" id="email" placeholder="mail@exemple.com" required />
         </div>
         <input type="submit" class="form-btn" value="Réinitialiser mon mot de passe" />
      </form>
   </div>

   <?php require_once './assets/includes/footer.php'; ?>
   <script src="controllers/js/forgot_password.js"></script>
</body>

</html>