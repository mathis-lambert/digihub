<?php
// CONFIG FILE
// Define local timezone
setlocale(LC_TIME, 'fr_FR.utf8', 'fra');
date_default_timezone_set('Europe/Paris');


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

function quickFetch($conn, $table, $column, $value)
{
    $sql = $conn->prepare("SELECT * FROM $table WHERE $column = '$value'");
    $sql->execute();
    $result = $sql->fetch(PDO::FETCH_ASSOC);
    return $result;
}

function quickFetchAll($conn, $table, $column, $value)
{
    $sql = $conn->prepare("SELECT * FROM $table WHERE $column = '$value'");
    $sql->execute();
    $result = $sql->fetchAll(PDO::FETCH_ASSOC);
    return $result;
}
