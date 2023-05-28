<?php

include '../../models/Db.php';
include '../../models/User.php';

$body = file_get_contents("php://input");

$register = json_decode($body);

$firstname = $register->firstname;
$lastname = $register->lastname;
$birthdate = $register->birthdate;
$email = $register->email;
$password = $register->password;
$confirm_password = $register->confirm_password;
$userCreationDate = date("Y-m-d H:i:s");
$userFavoriteMediaType = 1;
$userFavoriteBookTag = "all";
$userFavoriteMovieTag = "all";

if (!empty($firstname) && !empty($lastname) && !empty($birthdate) && !empty($email) && !empty($password) && !empty($confirm_password) && !empty($userCreationDate) && !empty($userFavoriteMediaType) && !empty($userFavoriteBookTag) && !empty($userFavoriteMovieTag)) {
   if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
      if (preg_match("/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{8,}$/", $password)) {
         if ($password === $confirm_password) {
            // check if the email is not already in the database
            $result = Db::quickFetch('users', 'userMail', $email);
            if (empty($result)) {
               // hash the password
               $password = password_hash($password, PASSWORD_DEFAULT);
               // insert the user in the database
               User::create($firstname, $lastname, $birthdate, $email, $password, $userCreationDate, $userFavoriteMediaType, $userFavoriteBookTag, $userFavoriteMovieTag);
               // start the session and store the userFirstname in it
               session_start();
               $user = Db::quickFetch('users', 'userMail', $email);
               $_SESSION['user'] = $firstname;
               $_SESSION['userId'] = $user['userId'];
               $_SESSION['userMail'] = $user['userMail'];
               $_SESSION['userRole'] = $user['userRole'];
               $body = array(
                  "success" => "Votre compte a bien été créé"
               );
            } else {
               $body = array(
                  "error" => "Cette adresse mail est déjà utilisée"
               );
            }
         } else {
            $body = array(
               "error" => "Les mots de passe ne correspondent pas"
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
