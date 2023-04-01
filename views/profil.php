<?php
// if session is not set and this page is directly typed in the url, redirect to home
if (!isset($_SESSION['user'])) {
   header('Location: ./?');
}
?>

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
      <h1>Profil de <?php echo $_SESSION['user']; ?></h1>
      <br>
      <div class="content">
         <div class="profile-pic">
            <img class="user" src="assets/img/icons/user.jpg" alt="profil" />
         </div>
         <div class="infos">
            <?php $user = $this->model->getUserByName($_SESSION['user']); ?>
            <p><b>ID :</b> <?php echo $user->userId; ?></p>
            <p><b>Nom :</b> <?php echo $user->userLastname; ?></p>
            <p><b>Prénom :</b> <?php echo $user->userFirstname; ?></p>
            <!-- format date into D/M/Y -->
            <p><b>Date de naissance :</b> <?php echo date('d/m/Y', strtotime($user->userBirthdate)); ?></p>
            <p><b>Email :</b> <?php echo $user->userMail; ?></p>
            <p><b>Membre depuis :</b> <?php echo date('d/m/Y', strtotime($user->userCreationDate)); ?></p>
            <?php $type = $this->model->getMediaTypeNameById($user->userFavoriteMediaType) ?>
            <p><b>Media favori :</b> <?php echo $type ?></p>
            <p><b>Genre de livre favori :</b> <?php echo $user->userFavoriteBookTag; ?></p>
            <p><b>Genre de film favori :</b> <?php echo $user->userFavoriteMovieTag; ?></p>
         </div>
      </div>
   </div>

   <?php require_once './assets/includes/footer.php'; ?>
</body>

</html>