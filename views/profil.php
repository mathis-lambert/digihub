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
      <a class="btn" href="./?logout">Se déconnecter</a>
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
      <br>
      <h2>Vos Favoris</h2>
      <?php
      $filter_aim_at = "Film";
      $favorite = true;
      $userId = $_SESSION['userId'];
      include_once './assets/includes/filterBar.php';
      ?>
      <div class="gallery" id="film_container">
      </div>

      <br>
      <?php
      if ($_SESSION['userRole'] == 2) {
      ?>
         <h2>Tableau d'administration</h2>
         <br>
         <div class="admin">
            <h3>Utilisateurs</h3>
            <div class="editTable">
               <?php
               $users = $this->model->getAllUsers();
               ?>
               <div class="tableContainer">

                  <table>
                     <thead>
                        <tr>
                           <th>ID</th>
                           <th>Nom</th>
                           <th>Prénom</th>
                           <th>Date de naissance</th>
                           <th>Email</th>
                           <th>Role</th>
                           <th>Supprimer</th>
                        </tr>
                     </thead>
                     <tbody>
                        <?php
                        foreach ($users as $user) { ?>
                           <tr data-id="<?= $user['userId']; ?>" data-target="user">
                              <td><input type="text" name="userId" value="<?= $user['userId']; ?>" disabled /></td>
                              <td><input type="text" name="userLastname" value="<?= $user['userLastname']; ?>" disabled /></td>
                              <td><input type="text" name="userFirstname" value="<?= $user['userFirstname']; ?>" disabled /></td>
                              <td><input type="datetime" name="userBirthdate" value="<?= date('d/m/Y', strtotime($user['userBirthdate'])); ?>" disabled /></td>
                              <td><input type="email" name="userMail" value="<?= $user['userMail']; ?>" disabled /></td>
                              <td><input type="text" name="userRole" value="<?= $user['userRole']; ?>" disabled /></td>
                              <td class="action_links">
                                 <button class="btn btn-blue editButton" aria-label="modifier" title="modifier">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="currentColor" class="bi bi-pencil-square" viewBox="0 0 16 16">
                                       <path d="M15.502 1.94a.5.5 0 0 1 0 .706L14.459 3.69l-2-2L13.502.646a.5.5 0 0 1 .707 0l1.293 1.293zm-1.75 2.456-2-2L4.939 9.21a.5.5 0 0 0-.121.196l-.805 2.414a.25.25 0 0 0 .316.316l2.414-.805a.5.5 0 0 0 .196-.12l6.813-6.814z" />
                                       <path fill-rule="evenodd" d="M1 13.5A1.5 1.5 0 0 0 2.5 15h11a1.5 1.5 0 0 0 1.5-1.5v-6a.5.5 0 0 0-1 0v6a.5.5 0 0 1-.5.5h-11a.5.5 0 0 1-.5-.5v-11a.5.5 0 0 1 .5-.5H9a.5.5 0 0 0 0-1H2.5A1.5 1.5 0 0 0 1 2.5v11z" />
                                    </svg>
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="currentColor" class="bi bi-arrow-left-square" viewBox="0 0 16 16">
                                       <path fill-rule="evenodd" d="M15 2a1 1 0 0 0-1-1H2a1 1 0 0 0-1 1v12a1 1 0 0 0 1 1h12a1 1 0 0 0 1-1V2zM0 2a2 2 0 0 1 2-2h12a2 2 0 0 1 2 2v12a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2V2zm11.5 5.5a.5.5 0 0 1 0 1H5.707l2.147 2.146a.5.5 0 0 1-.708.708l-3-3a.5.5 0 0 1 0-.708l3-3a.5.5 0 1 1 .708.708L5.707 7.5H11.5z" />
                                    </svg>
                                 </button>
                                 <button class="btn validateButton" aria-label="annuler" title="Valider les modifications">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="currentColor" class="bi bi-arrow-left-square" viewBox="0 0 16 16">
                                       <path fill-rule="evenodd" d="M15 2a1 1 0 0 0-1-1H2a1 1 0 0 0-1 1v12a1 1 0 0 0 1 1h12a1 1 0 0 0 1-1V2zM0 2a2 2 0 0 1 2-2h12a2 2 0 0 1 2 2v12a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2V2zm11.5 5.5a.5.5 0 0 1 0 1H5.707l2.147 2.146a.5.5 0 0 1-.708.708l-3-3a.5.5 0 0 1 0-.708l3-3a.5.5 0 1 1 .708.708L5.707 7.5H11.5z" />
                                    </svg>
                                 </button>
                                 <button class="btn btn-red deleteButton" aria-label="supprimer" title="supprimer">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="currentColor" class="bi bi-x-square" viewBox="0 0 16 16">
                                       <path d="M14 1a1 1 0 0 1 1 1v12a1 1 0 0 1-1 1H2a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1h12zM2 0a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V2a2 2 0 0 0-2-2H2z" />
                                       <path d="M4.646 4.646a.5.5 0 0 1 .708 0L8 7.293l2.646-2.647a.5.5 0 0 1 .708.708L8.707 8l2.647 2.646a.5.5 0 0 1-.708.708L8 8.707l-2.646 2.647a.5.5 0 0 1-.708-.708L7.293 8 4.646 5.354a.5.5 0 0 1 0-.708z" />
                                    </svg>
                                 </button>
                              </td>
                           </tr>
                        <?php } ?>
                     </tbody>
                  </table>
               </div>
            </div>
            <br>
            <h3>Commentaires</h3>
            <div class="editTable">
               <?php
               $comments = $this->model->getAllComments();
               ?>
               <div class="tableContainer">
                  <table>
                     <thead>
                        <tr>
                           <th>ID</th>
                           <th>Utilisateur</th>
                           <th>Media</th>
                           <th>Texte</th>
                           <th>Note</th>
                           <th>Date</th>
                           <th>Statut</th>
                           <th>Actions</th>
                        </tr>
                     </thead>
                     <tbody>
                        <?php
                        foreach ($comments as $comment) { ?>
                           <tr data-id="<?= $comment['commentId']; ?>" data-target="comment">
                              <td>
                                 <?= $comment['commentId']; ?>
                              </td>
                              <td><?= $comment['userLastname']; ?> <?= $comment['userFirstname']; ?></td>
                              <td><?= $comment['mediaName']; ?></td>
                              <td><input name="comment_text" type="text" value="<?= $comment['commentText']; ?>" disabled /></td>
                              <td><input name="comment_rating" type="number" value="<?= $comment['commentRating']; ?>" disabled /></td>
                              <td><?= date('d/m/Y', strtotime($comment['commentDate'])); ?></td>
                              <td>
                                 <select name="comment_status" disabled>
                                    <option value="ok" <?= $comment['commentStatus'] == "ok" ? 'selected' : ''; ?>>Actif</option>
                                    <option value="disabled" <?= $comment['commentStatus'] == "disabled" ? 'selected' : ''; ?>>Inactif</option>
                                 </select>
                              <td class="action_links">
                                 <button class="btn btn-blue editButton" aria-label="modifier" title="modifier">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="currentColor" class="bi bi-pencil-square" viewBox="0 0 16 16">
                                       <path d="M15.502 1.94a.5.5 0 0 1 0 .706L14.459 3.69l-2-2L13.502.646a.5.5 0 0 1 .707 0l1.293 1.293zm-1.75 2.456-2-2L4.939 9.21a.5.5 0 0 0-.121.196l-.805 2.414a.25.25 0 0 0 .316.316l2.414-.805a.5.5 0 0 0 .196-.12l6.813-6.814z" />
                                       <path fill-rule="evenodd" d="M1 13.5A1.5 1.5 0 0 0 2.5 15h11a1.5 1.5 0 0 0 1.5-1.5v-6a.5.5 0 0 0-1 0v6a.5.5 0 0 1-.5.5h-11a.5.5 0 0 1-.5-.5v-11a.5.5 0 0 1 .5-.5H9a.5.5 0 0 0 0-1H2.5A1.5 1.5 0 0 0 1 2.5v11z" />
                                    </svg>
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="currentColor" class="bi bi-arrow-left-square" viewBox="0 0 16 16">
                                       <path fill-rule="evenodd" d="M15 2a1 1 0 0 0-1-1H2a1 1 0 0 0-1 1v12a1 1 0 0 0 1 1h12a1 1 0 0 0 1-1V2zM0 2a2 2 0 0 1 2-2h12a2 2 0 0 1 2 2v12a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2V2zm11.5 5.5a.5.5 0 0 1 0 1H5.707l2.147 2.146a.5.5 0 0 1-.708.708l-3-3a.5.5 0 0 1 0-.708l3-3a.5.5 0 1 1 .708.708L5.707 7.5H11.5z" />
                                    </svg>
                                 </button>
                                 <button class="btn validateButton" aria-label="annuler" title="Valider les modifications">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="currentColor" class="bi bi-arrow-left-square" viewBox="0 0 16 16">
                                       <path fill-rule="evenodd" d="M15 2a1 1 0 0 0-1-1H2a1 1 0 0 0-1 1v12a1 1 0 0 0 1 1h12a1 1 0 0 0 1-1V2zM0 2a2 2 0 0 1 2-2h12a2 2 0 0 1 2 2v12a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2V2zm11.5 5.5a.5.5 0 0 1 0 1H5.707l2.147 2.146a.5.5 0 0 1-.708.708l-3-3a.5.5 0 0 1 0-.708l3-3a.5.5 0 1 1 .708.708L5.707 7.5H11.5z" />
                                    </svg>
                                 </button>
                                 <button class="btn btn-red deleteButton" aria-label="supprimer" title="supprimer">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="currentColor" class="bi bi-x-square" viewBox="0 0 16 16">
                                       <path d="M14 1a1 1 0 0 1 1 1v12a1 1 0 0 1-1 1H2a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1h12zM2 0a2 2 0 0 0-2 2v12a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V2a2 2 0 0 0-2-2H2z" />
                                       <path d="M4.646 4.646a.5.5 0 0 1 .708 0L8 7.293l2.646-2.647a.5.5 0 0 1 .708.708L8.707 8l2.647 2.646a.5.5 0 0 1-.708.708L8 8.707l-2.646 2.647a.5.5 0 0 1-.708-.708L7.293 8 4.646 5.354a.5.5 0 0 1 0-.708z" />
                                    </svg>
                                 </button>
                              </td>
                           </tr>
                        <?php } ?>
                     </tbody>
                  </table>
               </div>
            </div>
            <br>
            <h3>Medias</h3>
            <em>
               Vous pouvez modifier les informations d'un média directement depuis sa page.
            </em>
            <h4> Pour en ajouter un :</h4>
            <button class="btn" onclick="window.location.href='./?addMedia'">Ajouter un média</button>

            <br>
            <h3>Genres</h3>
            <div class="gallery" id="genre_container">
            </div>
            <br>
            <h3>Acteurs</h3>
            <div class="gallery" id="people_container">
            </div>
         </div>
      <?php
      }
      ?>

   </div>

   <?php require_once './assets/includes/footer.php'; ?>
</body>

</html>