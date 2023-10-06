<?php

use rtff\database\DatabaseConnexion;

require_once './DatabaseConnexion.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $database = \rtff\database\DatabaseConnexion::getInstance();
    $db = $database->getConnection();

    $user_id = $_POST['user_id'];
    $password = password_hash($_POST['password'], PASSWORD_BCRYPT);
    $display_name = $_POST['display_name'];

    $query_check = "SELECT COUNT(*) FROM ACCOUNT WHERE account_id = :user_id";
    $stmt_check = $db->prepare($query_check);
    $stmt_check->bindParam(':user_id', $user_id);
    $stmt_check->execute();

    if ($stmt_check->fetchColumn() > 0) {
        echo "Cette adresse e-mail est déjà utilisée. Veuillez en choisir une différente.";
    } else {
        $query = "INSERT INTO ACCOUNT (account_id, password, display_name, creation_date) VALUES (:user_id, :password, :display_name, NOW())";
        $stmt = $db->prepare($query);
        $stmt->bindParam(':user_id', $user_id);
        $stmt->bindParam(':password', $password);
        $stmt->bindParam(':display_name', $display_name);

        if ($stmt->execute()) {
            $to = 'Nom du Destinataire <'.$user_id.'>';
            $subject = mb_encode_mimeheader('Création de compte RT*F');
            $bndary = md5(uniqid(mt_rand()));

            $headers  = 'MIME-Version: 1.0' . "\r\n";
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

            if (mail($to, $subject, $message, $headers)) {
                echo "E-mail envoyé à " . $to;
            } else {
                echo "Un problème est survenu lors de l'envoi de l'e-mail.";
            }
            exit;
        } else {
            echo "Une erreur est survenue lors de la création de l'utilisateur.";
        }
    }
}
?>

<form method="post" action="createUser.php">
    Email: <input type="email" name="user_id" required><br>
    Mot de Passe: <input type="password" name="password" required><br>
    Nom d'Affichage: <input type="text" name="display_name" required><br>
    Image: <input type="text" name="image"><br>
    <input type="submit" value="Créer Utilisateur">
</form>
