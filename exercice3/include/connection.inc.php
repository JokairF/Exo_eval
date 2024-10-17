<?php

$host = "127.0.0.1:3306";
$bd = "avion_eval";
$login = "root";
$motdepasse = "";
$erreur = null;

try {
    $db = new PDO("mysql:host=$host;dbname=$bd", $login, $motdepasse);
} catch (Exception $e) {
    $error = "Erreur dans la connexion : " . $e->getMessage();
    echo "<div class='alert alert-danger'>$error</div>";
}
