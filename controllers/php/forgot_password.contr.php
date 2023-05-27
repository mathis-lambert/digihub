<?php

include '../../models/Db.php';
include '../../models/User.php';

$body = file_get_contents("php://input");

$forgot_password = json_decode($body);

$email = $forgot_password->email;

if (!empty($email)) {
   if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
         // check if the email is already in the database
         $result = Db::quickFetch('users', 'userMail', $email);
         if (!empty($result)) {
            // call the generateRandomString function
            $token = generateRandomString();
         } else {
            $body = array(
               "error" => "L'utilisateur n'existe pas"
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
