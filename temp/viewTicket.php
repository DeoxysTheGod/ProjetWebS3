<?php
session_start();
require_once './Database.php';
require_once './navigation.php';

if(!isset($_SESSION['account_id'])) {
    header('Location: connectUser.php');
    exit;
}

$database = new Database();
$db = $database->getConnection();

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['comment'])) {
    $comment_query = "INSERT INTO COMMENT (text, date, author, ticket_id) VALUES (:text, NOW(), :author, :ticket_id)";
    $comment_stmt = $db->prepare($comment_query);
    $comment_stmt->bindParam(':text', $_POST['comment']);
    $comment_stmt->bindParam(':author', $_SESSION['account_id']);
    $comment_stmt->bindParam(':ticket_id', $_GET['ticket_id']);
    $comment_stmt->execute();
}

$ticket_id = isset($_GET['ticket_id']) ? $_GET['ticket_id'] : null;

if(!$ticket_id) {
    // Rediriger vers une page d'erreur ou la liste des tickets si ticket_id n'est pas présent
    header('Location: error.php');
    exit;
}

$query = "SELECT t.*, a.display_name AS username FROM TICKET t LEFT JOIN ACCOUNT a ON t.author = a.account_id WHERE t.ticket_id = :ticket_id";
$stmt = $db->prepare($query);
$stmt->bindParam(':ticket_id', $ticket_id);
$stmt->execute();
$ticket = $stmt->fetch(PDO::FETCH_ASSOC);

$comment_query = "SELECT c.*, a.display_name AS username FROM COMMENT c LEFT JOIN ACCOUNT a ON c.author = a.account_id WHERE c.ticket_id = :ticket_id ORDER BY date DESC";
$comment_stmt = $db->prepare($comment_query);
$comment_stmt->bindParam(':ticket_id', $ticket_id);
$comment_stmt->execute();
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>View Ticket</title>
</head>
<body>
<div style="margin-right:220px; padding:10px;">
    <h1><?php echo htmlspecialchars($ticket['title']); ?></h1>
    <p><?php echo htmlspecialchars($ticket['message']); ?></p>
    <p><strong>Auteur :</strong> <?php echo htmlspecialchars($ticket['username']); ?></p>
    <p><strong>Date :</strong> <?php echo htmlspecialchars($ticket['date']); ?></p>
    <h2>Commentaires</h2>
    <form method="post" action="viewTicket.php?ticket_id=<?php echo htmlspecialchars($ticket_id); ?>">
        <textarea name="comment" required></textarea><br>
        <input type="submit" value="Poster le Commentaire">
    </form>
    <?php while ($comment = $comment_stmt->fetch(PDO::FETCH_ASSOC)) { ?>
        <div style='border: 1px solid #ccc; margin-bottom: 10px; padding: 10px;'>
            <p><?php echo htmlspecialchars($comment['text']); ?></p>
            <p><strong>Auteur :</strong> <?php echo htmlspecialchars($comment['username'] ?? 'Auteur inconnu'); ?></p>
            <p><strong>Date :</strong> <?php echo htmlspecialchars($comment['date']); ?></p>
        </div>
    <?php } ?>
</div>
</body>
</html>
