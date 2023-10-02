<?php

use rtff\database\DatabaseConnexion;

require_once './DatabaseConnexion.php';

$database = DatabaseConnexion::getInstance();
$db = $database->getConnection();

$query = "SELECT t.*, a.display_name AS username FROM TICKET t LEFT JOIN ACCOUNT a ON t.author = a.account_id";
$stmt = $db->prepare($query);

try {
    $stmt->execute();
} catch (PDOException $e) {
    error_log("Erreur: " . $e->getMessage()); // Log l'erreur plutôt que de l'afficher à l'utilisateur
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Votre Page</title>
</head>
<body>
<div style="margin-left:220px; padding:10px;">
    <h1>Liste des Posts</h1>
    <?php
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        renderPost($row);
    }
    ?>
</div>
<?php require_once './navigation.php'; ?>
</body>
</html>

<?php
function renderPost($row) {
    $title = htmlspecialchars($row['title'] ?? 'Titre inconnu');
    $message = htmlspecialchars($row['message'] ?? 'Message inconnu');
    $username = htmlspecialchars($row['username'] ?? 'Auteur inconnu');
    $date = htmlspecialchars($row['date'] ?? 'Date inconnue');
    $imagePath = htmlspecialchars($row['image_path'] ?? '');
    $ticketId = htmlspecialchars($row['ticket_id'] ?? '');

    echo "<div style='border: 1px solid #ccc; margin-bottom: 10px; padding: 10px;'>";
    echo "<h2>{$title}</h2>";
    echo "<p>{$message}</p>";

    if ($imagePath !== '') {
        echo "<img src='{$imagePath}' alt='Image associée' style='width: 200px; height: auto;'/>";
    }

    echo "<p><strong>Auteur :</strong> {$username}</p>";
    echo "<p><strong>Date :</strong> {$date}</p>";
    echo "<a href='viewTicket.php?ticket_id={$ticketId}' style='padding: 10px; background-color: blue; color: white; text-decoration: none; border-radius: 5px;'>Répondre</a>";
    echo "<button style='background-color: transparent; border: none; cursor: pointer; padding: 0; margin: 0; display: inline-block;'>";
    echo "<img src='like.png' alt='Like' style='width: 25px; height: 25px;'/>";
    echo "</button>";
    echo "</div>";
}
?>
