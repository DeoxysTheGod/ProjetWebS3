<?php
require_once './modules/rtff/Autoloader.php';
rtff\Autoloader::register();

// Si le formulaire a été soumis
if ($_SERVER["REQUEST_METHOD"] == "POST") {
	$database = (new includes\database\DatabaseConnexion());
	$db = $database->getConnection();

	$user_id = $_POST['user_id'];
	$password = password_hash($_POST['password'], PASSWORD_BCRYPT);
	$display_name = $_POST['display_name'];

	$query = "INSERT INTO ACCOUNT (account_id, password, display_name,creation_date) VALUES (:user_id, :password, :display_name, NOW())";

	$stmt = $db->prepare($query);
	$stmt->bindParam(':user_id', $user_id);
	$stmt->bindParam(':password', $password);
	$stmt->bindParam(':display_name', $display_name);
	// Liez également les autres paramètres

	if ($stmt->execute()) {
		echo "Utilisateur créé avec succès !";
	} else {
		echo "Une erreur est survenue lors de la création de l'utilisateur.";
	}
}