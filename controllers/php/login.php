<?php
$body = file_get_contents("php://input");

$login = json_decode($body);

$email = $login->email;
$password = $login->password;

if (!empty($email) && !empty($password)) {
   if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
      if (preg_match("/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{8,}$/", $password)) {
         // check if the email is already in the database
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

// $body = array(
//    "error" => "Veuillez remplir tous les champs"
// );

echo json_encode($body);
