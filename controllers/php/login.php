<?php

include '../../models/Db.php';
include '../../models/User.php';

$body = file_get_contents("php://input");

$login = json_decode($body);

$email = $login->email;
$password = $login->password;

if (!empty($email) && !empty($password)) {
   if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
      if (preg_match("/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{8,}$/", $password)) {
         // check if the email is already in the database
         $result = Db::quickFetch('users', 'userMail', $email);
         if (!empty($result)) {
            // check if the password is correct
            if (password_verify($password, $result['userPassword'])) {
               $body = array(
                  "success" => "Vous êtes bien connecté"
               );
               // start the session and store the userFirstname in it
               session_start();
               $_SESSION['user'] = $result['userFirstname'];
               $_SESSION['userId'] = $result['userId'];
               $_SESSION['userMail'] = $result['userMail'];
               $_SESSION['userRole'] = $result['userRole'];
            } else {
               $body = array(
                  "error" => "Le mot de passe est incorrect"
               );
            }
         } else {
            $body = array(
               "error" => "L'utilisateur n'existe pas"
            );
         }
      } else {
         $body = array(
            "error" => "Le mot de passe doit contenir au moins 8 caractères, une majuscule, une minuscule, un chiffre et un caractère spécial"
         );
      }
   } else {
      $body = array(
         "error" => "Veuillez entrer une adresse mail valide"
      );
   }
} else {
   $body = array(
      "error" => "Veuillez remplir tous les champs"
   );
}

echo json_encode($body);
