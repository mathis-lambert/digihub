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
   <div class="suggestions">
      <div class="suggestions_container">
         <?php
         $medias = $this->model->getOwnSuggestion();

         foreach ($medias as $media) {
         ?>
            <div class="suggestions_content">
               <div class="suggestions_img">
                  <img src="https://image.tmdb.org/t/p/original<?= $media['mediaBackgroundImage'] ?>" alt="cover">
                  <div class="overlay"></div>
               </div>
               <div class="suggestions_text">
                  <h2><?= $media['mediaName'] ?></h2>
                  <p><?= $media['typeName'] ?></p>
                  <a class="btn" href="./?view&id=<?= $media['mediaId'] ?>">Voir plus</a>
               </div>
            </div>
         <?php
         }
         ?>
      </div>
   </div>

   <script>
      const suggestions = document.querySelector('.suggestions');
      const container = document.querySelector('.suggestions_container');
      const content = document.querySelectorAll('.suggestions_content');
      let counter = 0;
      let activated = true;
      let scrollToPoint = 0;

      suggestions.addEventListener('scroll', () => {
         console.log(suggestions.scrollLeft);
      });

      const scrollSuggestions = (index) => {
         scrollToPoint = (window.innerWidth - content[index].offsetWidth * (index + 1)) - ((window.innerWidth - content[index].offsetWidth) / 2);
         container.style.transform = `translateX(${scrollToPoint}px)`;
      }

      (() => {
         scrollSuggestions(0);
         counter++;
      })();

      setInterval(() => {
         if (!activated) return;
         if (counter > content.length - 1) {
            counter = 0;
         }
         scrollSuggestions(counter);
         counter++;
      }, 5000);
   </script>
   <?php require_once './assets/includes/footer.php'; ?>
</body>

</html>