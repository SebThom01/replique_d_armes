<?php
session_start();
$bdd = new PDO('mysql:host=localhost;dbname=replique_d_armes;charset=utf8', 'root', ''); 
var_dump($_SESSION);

// $servername = 'localhost';
// $username = 'root';
// $password = '';
// $database = 'replique_d_armes';
// $bdd = new PDO('mysql:host='.$servername.';dbname='.$database.';charset=utf8', $username, $password);
// var_dump($bdd);
