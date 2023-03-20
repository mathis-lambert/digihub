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

   <h1 class="container">Profil de <?php echo $_SESSION['user']; ?></h1>

   <?php require_once './assets/includes/footer.php'; ?>
</body>

</html>