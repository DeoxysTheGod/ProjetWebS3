<?php
use rtff\database\DatabaseConnexion;

require_once './DatabaseConnexion.php';
rtff\Autoloader::register();

class User {

    public static function connectUser($user_id, $password) {
        try {
            $database = DatabaseConnexion::getInstance();
            $db = $database->getConnection();

            $query = "SELECT password FROM ACCOUNT WHERE account_id = :user_id";
            $stmt = $db->prepare($query);
            $stmt->bindParam(':user_id', $user_id);
            $stmt->execute();

            if ($stmt->rowCount() == 0) {
                return "Identifiant incorrect.";
            }

            $row = $stmt->fetch(PDO::FETCH_ASSOC);
            $hashed_password = $row['password'];

            if (!password_verify($password, $hashed_password)) {
                return "Mot de passe incorrect.";
            }

            // définition de la session
            $_SESSION['user_id'] = $user_id;

            return "Connexion réussie!";
        } catch (Exception $e) {
            error_log($e->getMessage());
            return "Une erreur est survenue lors de la connexion.";
        }
    }
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    session_start();
    $user_id = $_POST['user_id'];
    $password = $_POST['password'];
    $notification = User::connectUser($user_id, $password);
    echo $notification;
}
