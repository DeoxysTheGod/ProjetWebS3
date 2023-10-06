<?php
session_start();
use rtff\models\User;

require_once '../../models/User.php';


if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $user_id = $_POST['user_id'];
    $password = $_POST['password'];
    $display_name = $_POST['display_name'];

    $notification = User::createUser($user_id, $password, $display_name); // Supposition d'une méthode statique
    echo $notification;
}

require_once '../../views/CreateUserPage.php';
