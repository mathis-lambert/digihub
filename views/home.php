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
   <h1 class="container">Notre suggestion</h1>
   <?php
   $medias = $this->model->getOwnSuggestion();

   foreach ($medias as $media) {
      print_r($media);
   }
   ?>
   <?php require_once './assets/includes/footer.php'; ?>
</body>

</html>