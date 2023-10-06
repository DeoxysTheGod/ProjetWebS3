<?php

// Inclure la configuration de la base de données
use rtff\database\DatabaseConnexion;

require_once './DatabaseConnexion.php';

// Créer une instance de la base de données pour tester la connexion
$database = new DatabaseConnexion();
$db = $database->getConnection();

// Pour le moment, nous allons juste renvoyer un message JSON basique pour vérifier que tout fonctionne
header("Content-Type: application/json");

if ($db) {
    echo json_encode(["message" => "Connexion à la base de données réussie !"]);
} else {
    echo json_encode(["message" => "Connexion à la base de données échouée."]);
}

?>
