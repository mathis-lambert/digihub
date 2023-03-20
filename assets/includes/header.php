<?php
if (!isset($_SESSION['user'])) {
?>
   <header>
      <div class="header_container">
         <nav>
            <a href="./" class="logo_img">
               <img src="./assets/img/digihub-full-png.png" alt="logo">
            </a>
         </nav>

         <div class="widgets">
            <a href="./?connexion">Se connecter</a>
         </div>
      </div>
   </header>
<?php
} else {
?>
   <header>
      <div class="header_container">
         <nav>
            <a href="./" class="logo_img">
               <img src="./assets/img/digihub-full-png.png" alt="logo">
            </a>
            <a href="./">Accueil</a>
            <a href="./?nouveautes">Nouveautés</a>
            <a href="./?top">Top</a>
            <button class="linkbutton" onclick="toggleCatalogue()">Catalogue</button>
         </nav>

         <div class="widgets">
            <button class="search-button">
               <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-search">
                  <circle cx="11" cy="11" r="8"></circle>
                  <line x1="21" y1="21" x2="16.65" y2="16.65"></line>
               </svg>
            </button>

            <a href="./?profil"><?= $_SESSION['user'] ?></a>
         </div>
      </div>
   </header>

   <div class="catalogue">
      <div class="catalogue_header">
         <h2>Catalogue</h2>
      </div>
      <div class="catalogue_container">
         <div class="catalogue_content">
            <h3>Films</h3>
            <div class="content_list">
               <?php
               $genres = $this->model->getGenres();
               foreach ($genres as $genre) {
                  echo '<a href="./?results&q=' . $genre['genreName'] . '">' . $genre['genreName'] . '</a>';
               }
               ?>
            </div>
         </div>
      </div>
   </div>
<?php
}
?>