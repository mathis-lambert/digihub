<?php
include_once './models/Model.php';

class Controller
{
   public $model;
   public $conn;

   public function __construct($conn)
   {
      $this->conn = $conn;
      $this->model = new Model($conn);
   }

   public function invoke()
   {
      //routes digihub app
      $page = isset(array_keys($_GET)[0]) ? array_keys($_GET)[0] : 'home';

      $conn = $this->model->getConn();

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
            include 'views/view.php';
            break;
         case 'nouveautes':
            include 'views/nouveautes.php';
            break;
         case 'top':
            include 'views/top.php';
            break;
         case 'connexion':
            $currentPage = 'Connexion';
            include 'views/connexion.php';
            break;
         case 'inscription':
            $currentPage = 'Inscription';
            include 'views/inscription.php';
            break;
         default:
            include 'views/home.php';
            break;
      }
   }
}
