<?php

namespace rtff\controllers\pages;

use rtff\models\ProfileModel;

class ProfileController {
    public function uploadProfileImage($userId, $image) {
        $profileModel = new ProfileModel();

        $fileName = uniqid() . '.' . pathinfo($image['name'], PATHINFO_EXTENSION);
        $destination = 'uploads/' . $fileName;

        $profileView = new ProfileView();

        if (move_uploaded_file($image['tmp_name'], $destination)) {
            $result = $profileModel->updateProfileImage($userId, $destination);

            if ($result) {
                $message = "L'image de profil a été mise à jour avec succès !";
                echo $profileView->showMessage($message);
                return "L'image de profil a été mise à jour avec succès !";
            } else {
                return "Une erreur est survenue lors de la mise à jour de l'image de profil.";
                $message = "Une erreur est survenue lors de la mise à jour de l'image de profil.";
                echo $profileView->showMessage($message);
            }
        } else {
            return "Une erreur est survenue lors du déplacement du fichier.";
            $message = "Une erreur est survenue lors de la mise à jour de l'image de profil.";
            echo $profileView->showMessage($message);
        }

    }
}