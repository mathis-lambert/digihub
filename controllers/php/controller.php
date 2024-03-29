<?php
session_start();
include_once './models/Model.php';

class Controller
{
   public $model;
   private $conn;

   public function __construct()
   {
      $this->model = new Model();
   }

   public function invoke()
   {
      //routes digihub app
      $page = isset(array_keys($_GET)[0]) ? array_keys($_GET)[0] : 'home';

      $conn = $this->model->getConn();

      if (!isset($_SESSION['user'])) {
         switch ($page) {
            case 'connexion':
               $currentPage = 'Connexion';
               include 'views/connexion.php';
               break;
            case 'inscription':
               $currentPage = 'Inscription';
               include 'views/inscription.php';
               break;
            case 'forgot_password':
               $currentPage = 'Mot de passe oublié';
               include 'views/forgot_password.php';
               break;
            default:
               $currentPage = 'Veuillez vous connecter';
               include 'views/not_connected.php';
               break;
         }
      } else {
         switch ($page) {
            case 'home':
               $currentPage = 'Accueil';
               include 'views/home.php';
               break;
            case 'results':
               $currentPage = 'Résultats';
               include 'views/results.php';
               break;
            case 'view':
               $currentPage = 'Vue média';
               $id = $_GET['id'];
               $media = $this->model->getMedia($id);
               $comments = $this->model->getCommentsByMediaId($id);
               if (!is_null($media)) {
                  include 'views/view.php';
               } else {
                  header('Location: ./?404');
               }
               break;
            case 'delete':
               include 'controllers/php/delete.php';
               break;
            case 'nouveautes':
               $currentPage = 'Nouveautés';
               include 'views/nouveautes.php';
               break;
            case 'top':
               $currentPage = 'Les Tops';
               include 'views/top.php';
               break;
            case 'profil':
               $currentPage = 'Profil';
               include 'views/profil.php';
               break;
            case 'people':
               $id = $_GET['id'];
               $people = $this->model->getPeople($id);
               $currentPage = 'Personne';
               if (!is_null($people)) {
                  include 'views/people.php';
               } else {
                  header('Location: ./?404');
               }
               break;
            case 'favorites':
               $currentPage = 'Favoris';
               include('views/favorites.php');
               break;
            case '404':
               $currentPage = '404';
               include 'views/404.php';
               break;
            case 'logout':
               session_unset();
               session_destroy();
               header('Location: ./');
               break;
            default:
               include 'views/home.php';
               break;
         }
      }
   }
}
