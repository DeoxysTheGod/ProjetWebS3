<?php
namespace rtff\controllers\authentication;

class ConnectUser {

    public function defaultMethod() {
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $user_id = $_POST['user_id'];
            $password = $_POST['password'];
            $notification = \rtff\models\User::connectUser($user_id, $password);
            echo $notification;
        }
        // Vue affichée indépendamment de la méthode de la requête
        $view = new \rtff\views\ConnexionPage();
        $view->show();
    }
}
