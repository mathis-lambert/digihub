<?php

class User
{
   public $userId;
   public $userFirstname;
   public $userLastname;
   public $userBirthdate;
   public $userMail;
   public $userPassword;

   public function __construct($userId, $userFirstname, $userLastname, $userBirthdate, $userMail, $userPassword)
   {
      $this->userId = $userId;
      $this->userFirstname = $userFirstname;
      $this->userLastname = $userLastname;
      $this->userBirthdate = $userBirthdate;
      $this->userMail = $userMail;
      $this->userPassword = $userPassword;
   }

   public static function all()
   {
      $list = [];
      $db = Db::getInstance();
      $req = $db->query('SELECT * FROM users');

      foreach ($req->fetchAll() as $user) {
         $list[] = new User($user['userId'], $user['userFirstname'], $user['userLastname'], $user['userBirthdate'], $user['userMail'], $user['userPassword']);
      }

      return $list;
   }

   public static function find($userId)
   {
      $db = Db::getInstance();
      $userId = intval($userId);
      $req = $db->prepare('SELECT * FROM users WHERE userId = :userId');
      $req->execute(array('userId' => $userId));
      $user = $req->fetch();

      return new User($user['userId'], $user['userFirstname'], $user['userLastname'], $user['userBirthdate'], $user['userMail'], $user['userPassword']);
   }

   public static function create($userFirstname, $userLastname, $userBirthdate, $userMail, $userPassword)
   {
      $db = Db::getInstance();
      $req = $db->prepare('INSERT INTO users (userFirstname, userLastname, userBirthdate, userMail, userPassword) VALUES (:userFirstname, :userLastname, :userBirthdate, :userMail, :userPassword)');
      $req->execute(array('userFirstname' => $userFirstname, 'userLastname' => $userLastname, 'userBirthdate' => $userBirthdate, 'userMail' => $userMail, 'userPassword' => $userPassword));
   }

   public static function update($userId, $userFirstname, $userLastname, $userBirthdate, $userMail, $userPassword)
   {
      $db = Db::getInstance();
      $req = $db->prepare('UPDATE users SET userFirstname = :userFirstname, userLastname = :userLastname, userBirthdate = :userBirthdate, userMail = :userMail, userPassword = :userPassword WHERE userId = :userId');
      $req->execute(array('userId' => $userId, 'userFirstname' => $userFirstname, 'userLastname' => $userLastname, 'userBirthdate' => $userBirthdate, 'userMail' => $userMail, 'userPassword' => $userPassword));
   }

   public static function delete($userId)
   {
      $db = Db::getInstance();
      $userId = intval($userId);
      $req = $db->prepare('DELETE FROM users WHERE userId = :userId');
      $req->execute(array('userId' => $userId));
   }
}
