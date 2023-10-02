<?php

namespace rtff\controllers\authentication;

session_start();
require_once './DatabaseConnexion.php';
require_once './navigation.php';


if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $database = DatabaseConnexion::getInstance();
    $db = $database->getConnection();

    $account_id = htmlspecialchars($_POST['account_id']);
    $password = $_POST['password']; // Pas besoin de htmlspecialchars car password_verify fait déjà la comparaison en toute sécurité

    $query = "SELECT * FROM ACCOUNT WHERE account_id = :account_id";
    $stmt = $db->prepare($query);
    $stmt->bindParam(':account_id', $account_id);

    try {
        $stmt->execute();

        if ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            $hashed_password = $row['password'];

            if (password_verify($password, $hashed_password)) {
                $_SESSION['account_id'] = $row['account_id'];
                $_SESSION['display_name'] = $row['display_name'];
                $success_message = "Connexion réussie ! Bienvenue " . $_SESSION['display_name'] . "!";
                header("Location: viewPosts.php"); // Redirige l'utilisateur vers viewPosts.php
                exit;
            } else {
                $error_message = 'Identifiant/Mot de passe incorrect !';
            }
        } else {
            $error_message = 'Identifiant/Mot de passe incorrect !';
        }
    } catch (PDOException $e) {
        $error_message = 'Une erreur est survenue lors de la connexion.';
        // Loggez l'erreur $e->getMessage() dans un fichier d'erreurs ou un système de log.
    }
}
?>