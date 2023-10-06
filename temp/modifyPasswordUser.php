<?php
use rtff\database\DatabaseConnexion;

class PasswordResetView
{
    private $message = '';
    private $token = '';

    public function __construct($token)
    {
        $this->token = $token;
    }

    public function render()
    {
        $message = $this->processReset();

        // Affichage du message et du formulaire
        echo '<p>' . $message . '</p>';

        if ($message === "Mot de passe modifié avec succès !") {
            echo '<p><html>
<head>
    <title>Connectez-vous</title>
</head>
<body>
<p>Cliquez sur le bouton ci-dessous pour vous connecter :</p>
<a href="https://rtff.alwaysdata.net/connectUser.php">Cliquez ici</a>
</body>
</html></p>';
        }

        if ($this->message == '') {
            echo '<form method="post" action="modifyPasswordUser.php?token=' . $this->token . '">
                Nouveau Mot de Passe: <input type="password" name="new_password" required><br>
                <input type="submit" value="Modifier Mot de Passe">
            </form>';
        }
    }

    private function processReset()
    {
        $token = $this->token;
        $database = new Database();
        $db = $database->getConnection();

        if (isset($_GET['token'])) {
            $query = "SELECT * FROM TOKEN WHERE token_id = :token_id AND date_creation >= NOW() - INTERVAL 30 MINUTE";
            $stmt = $db->prepare($query);
            $stmt->bindParam(':token_id', $token);
            $stmt->execute();

            if ($stmt->rowCount() == 0) {
                $this->message = "Token invalide ou expiré !";
                $query = "DELETE FROM TOKEN WHERE token_id = :token_id";
                $stmt = $db->prepare($query);
                $stmt->bindParam(':token_id', $token);
                $stmt->execute();
            } else {
                $account = $stmt->fetch(PDO::FETCH_ASSOC);

                if ($_SERVER["REQUEST_METHOD"] == "POST") {
                    $new_password = password_hash($_POST['new_password'], PASSWORD_BCRYPT);

                    $query = "UPDATE ACCOUNT SET password = :new_password WHERE account_id= :account_id";
                    $stmt = $db->prepare($query);
                    $stmt->bindParam(':new_password', $new_password);
                    $stmt->bindParam(':account_id', $account['account_id']);

                    if ($stmt->execute()) {
                        $this->message = "Mot de passe modifié avec succès !";
                        // Vous pourriez vouloir supprimer le token après l'utilisation
                        $query = "DELETE FROM TOKEN WHERE token_id = :token_id";
                        $stmt = $db->prepare($query);
                        $stmt->bindParam(':token_id', $token);
                        $stmt->execute();
                    } else {
                        $this->message = "Une erreur est survenue lors de la modification du mot de passe.";
                    }
                }
            }
        } else {
            $this->message = "Paramètre token manquant !";
        }

        return $this->message;
    }
}

// Usage:
$token = isset($_GET['token']) ? $_GET['token'] : '';
$view = new PasswordResetView($token);
$view->render();
