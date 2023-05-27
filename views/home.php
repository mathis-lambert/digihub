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
   <div class="container no-height">
      <h1>Notre suggestion</h1>
   </div>
   <div class="suggestions">
      <button id="_next" class="next">&gt;</button>
      <button id="_prev" class="prev">&lt;</button>
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
   <div class="container">
      <h1>Vous aimerez peut-être</h1>

      <h1>Les plus populaires</h1>

      <h1>Les mieux notés</h1>
      <div class="medias">
      <?php
      $mediasRating = $this->model->getTopRatingMedias();

      foreach ($mediasRating as $mediaRating) {
      ?>
         <div class="media">
            <div>
               <img height="200" src="https://image.tmdb.org/t/p/original<?= $mediaRating['mediaCoverImage'] ?>" alt="cover">
               <a class="btn center" href="./?view&id=<?= $mediaRating['mediaId'] ?>">Voir plus</a>
            </div>
         </div>
      <?php
      }
      ?>
      </div>

      <h1>Les plus récents</h1>
      <div class="medias">
      <?php
      $mediasDate = $this->model->getMediaByDateSortie();

      foreach ($mediasDate as $mediaDate) {
      ?>
         <div class="media">
            <div>
               <img height="200" src="https://image.tmdb.org/t/p/original<?= $mediaDate['mediaCoverImage'] ?>" alt="cover">
               <a class="btn center" href="./?view&id=<?= $mediaDate['mediaId'] ?>">Voir plus</a>
            </div>
         </div>
      <?php
      }
      ?>
      </div>
      

   </div>

   <style>
            .medias {
               display: flex;
               justify-content: flex-start;
               align-items: center;
               flex-wrap: wrap;
               gap: 1rem;
            }
            .center {
               display: block;
               margin: 0 auto;
            }
         </style>

   </div>

   <script>
      const suggestions = document.querySelector('.suggestions');
      const container = document.querySelector('.suggestions_container');
      const content = document.querySelectorAll('.suggestions_content');
      let counter = 0;
      let activated = true;
      let scrollToPoint = 0;

      const next = document.querySelector('#_next');
      const prev = document.querySelector('#_prev');

      suggestions.addEventListener('scroll', () => {
         console.log(suggestions.scrollLeft);
      });

      const scrollSuggestions = (index) => {
         scrollToPoint = (window.innerWidth - content[index].offsetWidth * (index + 1)) - ((window.innerWidth - content[index].offsetWidth) / 2);
         container.style.transform = `translateX(${scrollToPoint}px)`;
      }

      (() => {
         counter = Math.floor(Math.random() * (content.length - 1));
         scrollSuggestions(counter);
      })();

      next.addEventListener('click', () => {
         if (counter >= content.length - 1) {
            counter = 0;
         } else {
            counter++;
         }
         scrollSuggestions(counter);
      });

      prev.addEventListener('click', () => {
         if (counter <= 0) {
            counter = content.length - 1;
         } else {
            counter--;
         }
         console.log(counter);
         scrollSuggestions(counter);
      });

      setInterval(() => {
         if (!activated) return;
         if (counter > content.length - 1) {
            counter = 0;
         }
         console.log(counter);
         scrollSuggestions(counter);
         counter++;
      }, 5000);
   </script>
   <?php require_once './assets/includes/footer.php'; ?>
</body>

</html>