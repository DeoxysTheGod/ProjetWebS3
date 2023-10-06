<?php
// importation de la classe DatabaseConnexion et démarrage de la session
use rtff\database\DatabaseConnexion;

require_once './DatabaseConnexion.php';
session_start();

if (!isset($_SESSION['account_id'])) {
    header('Location: connectUser.php');
    exit;
}

// Définition de la classe Post
class Post {
    public static function createPost($title, $message, $author, $image_path) {
        try {
            $db = DatabaseConnexion::getInstance()->getConnection();

            $query = "INSERT INTO TICKET (title, message, image_path, date, author) VALUES (:title, :message, :image_path, NOW(), :author)";
            $stmt = $db->prepare($query);
            $stmt->bindParam(':title', $title);
            $stmt->bindParam(':message', $message);
            $stmt->bindParam(':image_path', $image_path);
            $stmt->bindParam(':author', $author);

            if ($stmt->execute()) {
                return "Post créé avec succès !";
            } else {
                throw new Exception("Une erreur est survenue lors de la création du post.");
            }
        } catch (Exception $e) {
            error_log($e->getMessage());
            return "Une erreur est survenue.";
        }
    }
}

$notification = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $title = htmlspecialchars($_POST['title']);
    $message = htmlspecialchars($_POST['message']);
    $author = $_SESSION['account_id'];
    $image_path = null;

    // Gestion de l'upload de l'image
    // (c'est une version simplifiée, vous pouvez avoir besoin de gérer plus d'erreurs et de validations)
    if (isset($_FILES['image']) && $_FILES['image']['error'] == 0) {
        $upload_dir = 'uploads/';
        $uploaded_file = $upload_dir . uniqid() . '.' . pathinfo($_FILES['image']['name'], PATHINFO_EXTENSION);
        if (move_uploaded_file($_FILES["image"]["tmp_name"], $uploaded_file)) {
            $image_path = $uploaded_file;
        }
    }

    $notification = Post::createPost($title, $message, $author, $image_path);
}

// Importation du fichier de navigation
require_once './navigation.php';
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Créer un Post</title>
</head>
<body>
<div style="margin-left:220px; padding:10px;">
    <form method="post" action="createPost.php" enctype="multipart/form-data">
        <div>
            <label for="title">Titre:</label>
            <input type="text" name="title" id="title" required>
        </div>
        <div>
            <label for="message">Message:</label>
            <textarea name="message" id="message" required></textarea>
        </div>
        <div>
            <label for="image">Image:</label>
            <input type="file" name="image" id="image">
        </div>
        <div>
            <input type="submit" value="Créer Post">
        </div>
    </form>
    <div>
        <?php echo $notification; ?>
    </div>
</div>
</body>
</html>
