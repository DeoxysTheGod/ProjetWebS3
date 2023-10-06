<?php
namespace rtff\controllers\authentication;
use rtff\models\User;

session_start();

class CreateUser
{
    public function defaultMethod()
    {
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $user_id = $_POST['user_id'];
            $password = $_POST['password'];
            $display_name = $_POST['display_name'];

            $notification = User::createUser($user_id, $password, $display_name); // Supposition d'une méthode statique
            echo $notification;
        }
        // Vue affichée indépendamment de la méthode de la requête
        $view = new \rtff\views\CreateUserPage();
        $view->show();
    }
}
