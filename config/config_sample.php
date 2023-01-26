<?php
// CONFIG FILE

// Database credentials
define('DB_HOST', 'SERVEUR HOST');
define("DB_USERNAME", "USERNAME");
define("DB_PASSWORD", "PASSWORD");
define("DB_NAME", "NAME OF DATABASE");

// Define local timezone
setlocale(LC_TIME, 'fr_FR.utf8', 'fra');
date_default_timezone_set('Europe/Paris');

// Create PDO connection
try {
    $conn = new PDO("mysql:host=" . DB_HOST . ";dbname=" . DB_NAME, DB_USERNAME, DB_PASSWORD);
    // set the PDO error mode to exception
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    // echo "Connected successfully";
    $conn->exec("SET NAMES 'utf8'");
} catch (PDOException $e) {
    echo "Connection failed: " . $e->getMessage();
}

$roleArray = [
    0 => 'Utilisateur',
    1 => 'Bibliothécaire',
    2 => 'Administrateur',
];

// Functions
function getRoleName($role)
{
    global $roleArray;
    return $roleArray[$role];
}
function generateRandomString($length = 20)
{
    return substr(str_shuffle(str_repeat($x = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ', ceil($length / strlen($x)))), 1, $length);
}
function generateRandomNumber($length = 20)
{
    return substr(str_shuffle(str_repeat($x = '0123456789', ceil($length / strlen($x)))), 1, $length);
}
