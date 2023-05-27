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
            <p><b>Date de naissance :</b> <?php echo date('d/m/Y', strtotime($user->userBirthdate)); ?></p>
            <p><b>Email :</b> <?php echo $user->userMail; ?></p>
            <p><b>Membre depuis :</b> <?php echo date('d/m/Y', strtotime($user->userCreationDate)); ?></p>

         </div>
      </div>
      <h2>Vos Favoris</h2>
      <?php
      $filter_aim_at = "Film";
      $favorite = true;
      $userId = $_SESSION['userId'];
      include_once './assets/includes/filterBar.php';
      ?>
      <div class="gallery" id="film_container">
      </div>

   </div>

   <?php require_once './assets/includes/footer.php'; ?>
</body>

</html>