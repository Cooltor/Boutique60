<?php


// 1 - Connexion à la BDD


$pdo = new PDO(
    "mysql:host=localhost;dbname=boutique60","root","",
    array(
        PDO::ATTR_ERRMODE => PDO::ERRMODE_WARNING, 
        PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8' 
    )
);



// 2 - Déclarer une variable qui va afficher les messages

$content = '';


?>

