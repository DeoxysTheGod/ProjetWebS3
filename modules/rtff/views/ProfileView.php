<?php

namespace rtff\views;

class ProfileView {
    public function showUploadForm() {
        // Code HTML pour afficher le formulaire de téléchargement de l'image de profil
        return '
            <form action="uploadProfileImage.php" method="post" enctype="multipart/form-data">
                Sélectionnez une image de profil :
                <input type="file" name="profileImage" accept="image/*" required>
                <input type="submit" value="Télécharger l\'image" name="submit">
            </form>
        ';
    }

    public function showMessage($message) {
        // Affiche un message à l'utilisateur
        return '<p>' . htmlspecialchars($message) . '</p>';
    }
}