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
         <?php
         if (isset($_SESSION['user'])) {
            echo '<a href="./?profil">' . $_SESSION['user'] . '</a>';
         } else {
            echo '<a href="./?connexion">Se connecter</a>';
         }
         ?>
      </div>
   </div>
</header>

<div class="catalogue">

</div>