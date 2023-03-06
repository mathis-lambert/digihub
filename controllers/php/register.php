<?php
$body = file_get_contents("php://input");

$register = json_decode($body);

$firstname = $register->firstname;
$lastname = $register->lastname;
$birthdate = $register->birthdate;
$email = $register->email;
$password = $register->password;
$confirm_password = $register->confirm_password;

if (!empty($firstname) && !empty($lastname) && !empty($birthdate) && !empty($email) && !empty($password) && !empty($confirm_password)) {
   if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
      if (preg_match("/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{8,}$/", $password)) {
         if ($password === $confirm_password) {
            // check if the email is not already in the database
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
