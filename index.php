<?php
require_once './config/config.php';
?>
<!DOCTYPE html>
<html lang="fr">

<?php
$currentPage = 'Accueil';
require_once './includes/head.php';
?>

<body>


  <?php
  require_once './includes/searchbar.php';
  require_once './includes/header.php';
  ?>
  <h1 class="container">Hello World !</h1>
  <?php require_once './includes/footer.php'; ?>
</body>

</html>