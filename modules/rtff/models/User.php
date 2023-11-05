<?php

namespace rtff\models;

use rtff\database\DatabaseConnexion;

class User {

    public static function connectUser($account_id, $password) {
        try {
            $database = DatabaseConnexion::getInstance();
            $db = $database->getConnection();

            $query = "SELECT password FROM ACCOUNT WHERE account_id = :account_id";
            $stmt = $db->prepare($query);
            $stmt->bindParam(':account_id', $account_id);
            $stmt->execute();

            if ($stmt->rowCount() == 0) {
                return "Identifiant incorrect.";
            }

            $row = $stmt->fetch(PDO::FETCH_ASSOC);

            $hashed_password = $row['password'];

            if (!password_verify($password, $hashed_password)) {
                return "Mot de passe incorrect.";
            }

            // Authentification réussie
            $_SESSION['account_id'] = $account_id;

            // Ajoutez ici la logique SQL pour modifier la table de la base de données
            $updateQuery = "UPDATE ACCOUNT SET last_connection_date = date('now')   WHERE account_id = :account_id";
            $updateStmt = $db->prepare($updateQuery);
            $updateStmt->execute();

            // Redirigez vers la page suivante ou affichez un message de succès
            header('Location: page_suivante.php');
            exit(); // Pour s'assurer que rien d'autre ne s'exécute après

        } catch (Exception $e) {
            error_log($e->getMessage());
            return "Une erreur est survenue lors de la connexion.";
        }
    }

    public static function createUser($account_id, $password, $display_name) {
        try {
            $database = DatabaseConnexion::getInstance();
            $db = $database->getConnection();

            $password = password_hash($password, PASSWORD_BCRYPT);

            $query_check = "SELECT COUNT(*) FROM ACCOUNT WHERE account_id = :account_id";
            $stmt_check = $db->prepare($query_check);
            $stmt_check->bindParam(':account_id', $account_id);
            $stmt_check->execute();

            if ($stmt_check->fetchColumn() > 0) {
                return "Cette adresse e-mail est déjà utilisée. Veuillez en choisir une différente.";
            } else {
                $query = "INSERT INTO ACCOUNT (account_id, password, display_name, creation_date) VALUES (:account_id, :password, :display_name, NOW())";
                $stmt = $db->prepare($query);
                $stmt->bindParam(':account_id', $account_id);
                $stmt->bindParam(':password', $password);
                $stmt->bindParam(':display_name', $display_name);

                if (!$stmt->execute()) {
                    throw new Exception("Une erreur est survenue lors de la création de l'utilisateur.");
                }

                // Envoi de l'e-mail
                self::sendEmail($account_id);

                return "Utilisateur créé avec succès!";
            }
        } catch (\Exception $e) {
            error_log($e->getMessage());
            return "Une erreur est survenue.";
        }
    }

    private static function sendEmail($account_id) {
        $to = 'Nom du Destinataire <' . $account_id . '>';
        $subject = mb_encode_mimeheader('Création de compte RT*F');
        $bndary = md5(uniqid(mt_rand()));

        $headers = 'MIME-Version: 1.0' . "\r\n";
        $headers .= 'Content-type: multipart/alternative; boundary="' . $bndary . '"';

        $message_text = 'Merci d\'avoir créé votre compte sur RT*F';
        $message_html = '<html><head><title>Bienvenue sur RT*F!</title></head><body style="background-color: #2c2a2e; color: white; text-align: center; padding: 20px;"><p>Merci d\'avoir créé votre compte chez nous!</p></body></html>';

        $message = '--' . $bndary . "\r\n";
        $message .= 'Content-Type: text/plain; charset=utf-8' . "\r\n";
        $message .= 'Content-Transfer-Encoding: quoted-printable' . "\r\n\r\n";
        $message .= $message_text . "\r\n\r\n";

        $message .= '--' . $bndary . "\r\n";
        $message .= 'Content-Type: text/html; charset=utf-8' . "\r\n";
        $message .= 'Content-Transfer-Encoding: quoted-printable' . "\r\n\r\n";
        $message .= $message_html . "\r\n\r\n";

        $message .= '--' . $bndary . '--';

        if (!mail($to, $subject, $message, $headers)) {
            throw new \Exception("Un problème est survenu lors de l'envoi de l'e-mail.");
        }

    }
}
