<?php
// generate a random string
function randomString($length = 10)
{
   $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
   $charactersLength = strlen($characters);
   $randomString = '';
   for ($i = 0; $i < $length; $i++) {
      $randomString .= $characters[rand(0, $charactersLength - 1)];
   }
   return $randomString;
}

// Craft an email containing a link that includes the verification token
function sendVerificationEmail($email, $token)
{
   $to = $email;
   $subject = 'Password Recovery';
   $message = 'Vous avez demandé à réinitialiser votre mot de passe.
   Veuillez cliquer sur le lien ci-dessous afin de le réinitialiser:
   http://localhost/digihub/?page=pwdrecover&token=' . $token;
   $headers = 'From:clmt.fvrl@gmail.com' . "\r\n";
    mail($to, $subject, $message, $headers);
}