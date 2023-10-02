<?php
namespace rtff\controllers\authentication;

use rtff\models\User;
use rtff\views\ConnexionPage;

class ConnectUser {

    public function defaultMethod() {
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $user_id = $_POST['user_id'];
            $password = $_POST['password'];
            $notification = User::connectUser($user_id, $password);
            echo $notification;
        }
        // Vue affichée indépendamment de la méthode de la requête
        $view = new ConnexionPage();
        $view->show();
    }
}
