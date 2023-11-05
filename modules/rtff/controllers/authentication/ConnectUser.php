<?php
namespace rtff\controllers\authentication;

use rtff\models\User;

/**
 * Méthode par défaut du contrôleur.
 * Gère la connexion de l'utilisateur.
 */
class ConnectUser {
    public function defaultMethod() {
        session_start();
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $account_id = $_POST['account_id'];
            $password = $_POST['password'];
            $notification = User::connectUser($account_id, $password);
            echo $notification;
        }
        // Vue affichée indépendamment de la méthode de la requête
        $view = new \rtff\views\ConnexionPage();
        $view->show();
    }
}
