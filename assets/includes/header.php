<?php
if (!isset($_SESSION['user'])) {
?>
   <header>
      <div class="header_container" data-aos="fade-down" data-aos-duration="1000">
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
      <div class="header_container" data-aos="fade-down" data-aos-duration="1000">
         <nav>
            <a href="./" class="logo_img">
               <img src="./assets/img/digihub-full-png.png" alt="logo" id="logo_full">
               <img src="./assets/img/dh-icon.png" alt="logo" id="logo_small">
            </a>
            <a href="./" class="nav_link">Accueil</a>
            <a href="./?nouveautes" class="nav_link">Nouveautés</a>
            <a href="./?top" class="nav_link">Top</a>
            <button class="nav_link linkbutton" onclick="toggleCatalogue()">Catalogue</button>
         </nav>

         <div class="widgets">
            <button class="search-button">
               <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-search">
                  <circle cx="11" cy="11" r="8"></circle>
                  <line x1="21" y1="21" x2="16.65" y2="16.65"></line>
               </svg>
            </button>
            <div class="burger">
               <div class="burger_line"></div>
               <div class="burger_line"></div>
               <div class="burger_line"></div>
            </div>
            <a href="./?profil" class="profil_link"><?= $_SESSION['user'] ?></a>
         </div>
      </div>
   </header>

   <div class="small_menu">
      <div class="small_menu_container">
         <div class="small_menu_content">
            <a href="./" class="nav_link">Accueil</a>
            <a href="./?nouveautes" class="nav_link">Nouveautés</a>
            <a href="./?top" class="nav_link">Top</a>
            <a href="./?catalogue" class="nav_link">Catalogue</a>
            <a href="./?profil" class="profil_link"><?= $_SESSION['user'] ?></a>
            <a href="./?deconnexion" class="profil_link">Se déconnecter</a>
         </div>
      </div>
   </div>

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

<script>
   const header = document.querySelector('header');

   window.addEventListener('scroll', () => {
      if (window.scrollY > 50) {
         header.classList.add('scrolled');
      } else {
         header.classList.remove('scrolled');
      }
   });

   const burger = document.querySelector('.burger');
   const smallMenu = document.querySelector('.small_menu');

   burger.addEventListener('click', () => {
      burger.classList.toggle('active');
      smallMenu.classList.toggle('active');
   });
</script>