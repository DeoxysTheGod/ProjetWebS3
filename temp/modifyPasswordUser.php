<?php

use rtff\database\DatabaseConnexion;

require_once './DatabaseConnexion.php';

$message = '';

if (isset($_GET['token'])) {
    $token = $_GET['token'];
    $database = new Database();
    $db = $database->getConnection();

    $query = "SELECT * FROM TOKEN WHERE token_id = :token_id AND date_creation >= NOW() - INTERVAL 30 MINUTE";
    $stmt = $db->prepare($query);
    $stmt->bindParam(':token_id', $token);
    $stmt->execute();

    if ($stmt->rowCount() == 0) {
        $message = "Token invalide ou expiré !";
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
                $message = "Mot de passe modifié avec succès !";
                // Vous pourriez vouloir supprimer le token après l'utilisation
                $query = "DELETE FROM TOKEN WHERE token_id = :token_id";
                $stmt = $db->prepare($query);
                $stmt->bindParam(':token_id', $token);
                $stmt->execute();
            } else {
                $message = "Une erreur est survenue lors de la modification du mot de passe.";
            }
        }
    }
} else {
    $message = "Paramètre token manquant !";
}
?>

<!-- Affichage du message -->
<?php if ($message != ''): ?>
    <p><?php echo $message; ?></p>
    <?php if ($message === "Mot de passe modifié avec succès !") ?>
        <p><html>
<head>
    <title>Connectez-vous</title>
</head>
<body>
<p>Cliquez sur le bouton ci-dessous pour vous connectez :</p>
<a href="https://rtff.alwaysdata.net/connectUser.php" >Cliquez ici</a>
</body>
</html></p>
<?php endif; ?>

<!-- Formulaire de modification du mot de passe -->
<?php if (isset($token) && $message == ''): ?>
    <form method="post" action="modifyPasswordUser.php?token=<?php echo $token; ?>">
        Nouveau Mot de Passe: <input type="password" name="new_password" required><br>
        <input type="submit" value="Modifier Mot de Passe">
    </form>
<?php endif; ?>
