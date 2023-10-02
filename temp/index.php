<?php

// Inclure la configuration de la base de données
require_once './Database.php';

// Créer une instance de la base de données pour tester la connexion
$database = new Database();
$db = $database->getConnection();

// Pour le moment, nous allons juste renvoyer un message JSON basique pour vérifier que tout fonctionne
header("Content-Type: application/json");

if ($db) {
    echo json_encode(["message" => "Connexion à la base de données réussie !"]);
} else {
    echo json_encode(["message" => "Connexion à la base de données échouée."]);
}

?>
