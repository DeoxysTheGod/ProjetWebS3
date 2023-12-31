<?php
namespace rtff\controllers\authentication;
use rtff\models\User;
use rtff\views\CreateUserView;

class CreateUser
{
    /**
     * Méthode par défaut pour la création d'un utilisateur.
     *
     * Cette méthode gère la création d'un utilisateur à partir des données du formulaire.
     * Elle vérifie si un fichier image de profil a été téléchargé et le traite en conséquence.
     */
    public function defaultMethod()
    {
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $user_id = $_POST['user_id'];
            $password = $_POST['password'];
            $display_name = $_POST['display_name'];
            $image_path = '';

            // Vérifie si un fichier image de profil a été téléchargé
            if (isset($_FILES['profileImage']) && $_FILES['profileImage']['error'] === 0) {
                $uploadsDir = 'uploads/profiles/';

                // Assure que le répertoire d'upload existe
                if (!file_exists($uploadsDir)) {
                    mkdir($uploadsDir, 0777, true);
                }

                $fileName = uniqid() . '.' . pathinfo($_FILES['profileImage']['name'], PATHINFO_EXTENSION);
                $destination = realpath($uploadsDir) . '/' . $fileName;

                // Déplace le fichier téléchargé vers le répertoire d'images de profil
                if (move_uploaded_file($_FILES['profileImage']['tmp_name'], $destination)) {
                    $image_path = $destination;
                } else {
                    echo "Une erreur est survenue lors du téléchargement de l'image de profil.";
                }
            }

            // Crée l'utilisateur avec l'image de profil en utilisant le modèle User
            $notification = User::createUser($user_id, $password, $image_path, $display_name);

            if ($notification === "Compte créé avec succès !") {
                // Redirige l'utilisateur vers une page de confirmation ou une autre page
                header('Location: confirmation.php');
                exit;
            } else {
                echo $notification;
            }
        }

        // Vue affichée indépendamment de la méthode de la requête
        $view = new CreateUserView();
        $view->show();
    }
}