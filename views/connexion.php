<!DOCTYPE html>
<html lang="fr">

<?php
require_once './includes/head.php';
?>

<body>

   <?php
   require_once './includes/searchbar.php';
   require_once './includes/header.php';
   ?>

   <form method="post" id="login_form" class="container">
      <div class="input-div">
         <label for="email">Email</label>
         <input type="email" name="email" id="email" placeholder="mail@exemple.com" required />
         <p class="error_msg" id="mail_error"></p>
      </div>
      <div class="input-div">
         <label for="password">Mot de passe</label>
         <input type="password" name="password" id="password" placeholder="************" required />
         <p class="error_msg" id="password_error"></p>
      </div>
      <input type="submit" value="Login" id="submitForm" />
   </form>

   <?php require_once './includes/footer.php'; ?>
   <script src="../controllers/js/connect.js"></script>
</body>

</html>